# Optimiza imágenes pesadas para producción local.
# Guarda copias originales en assets/original/

$ErrorActionPreference = 'Stop'
Add-Type -AssemblyName System.Drawing

$root = Split-Path -Parent $PSScriptRoot
$assets = Join-Path $root 'assets'
$originalDir = Join-Path $assets 'original'

if (-not (Test-Path $originalDir)) {
    New-Item -ItemType Directory -Path $originalDir | Out-Null
}

function Save-Jpeg {
    param(
        [System.Drawing.Bitmap]$Bitmap,
        [string]$Path,
        [long]$Quality = 82
    )

    $codec = [System.Drawing.Imaging.ImageCodecInfo]::GetImageEncoders() |
        Where-Object { $_.MimeType -eq 'image/jpeg' } |
        Select-Object -First 1

    $encoder = [System.Drawing.Imaging.Encoder]::Quality
    $encoderParams = New-Object System.Drawing.Imaging.EncoderParameters(1)
    $encoderParams.Param[0] = New-Object System.Drawing.Imaging.EncoderParameter($encoder, $Quality)
    $Bitmap.Save($Path, $codec, $encoderParams)
    $encoderParams.Dispose()
}

function Resize-Image {
    param(
        [System.Drawing.Image]$Image,
        [int]$MaxWidth
    )

    if ($Image.Width -le $MaxWidth) {
        $newWidth = $Image.Width
        $newHeight = $Image.Height
    } else {
        $ratio = $MaxWidth / $Image.Width
        $newWidth = [int]$MaxWidth
        $newHeight = [int][Math]::Round($Image.Height * $ratio)
    }

    $bitmap = New-Object System.Drawing.Bitmap($newWidth, $newHeight)
    $graphics = [System.Drawing.Graphics]::FromImage($bitmap)
    $graphics.InterpolationMode = [System.Drawing.Drawing2D.InterpolationMode]::HighQualityBicubic
    $graphics.PixelOffsetMode = [System.Drawing.Drawing2D.PixelOffsetMode]::HighQuality
    $graphics.DrawImage($Image, 0, 0, $newWidth, $newHeight)
    $graphics.Dispose()
    return $bitmap
}

function Optimize-Asset {
    param(
        [string]$FileName,
        [int]$MaxWidth,
        [long]$JpegQuality = 82
    )

    $sourcePath = Join-Path $assets $FileName

    if (-not (Test-Path $sourcePath)) {
        Write-Warning "No existe: $FileName"
        return
    }

    $backupPath = Join-Path $originalDir $FileName
    if (-not (Test-Path $backupPath)) {
        Copy-Item $sourcePath $backupPath
    }

    $bytes = [System.IO.File]::ReadAllBytes($sourcePath)
    $stream = New-Object System.IO.MemoryStream(,$bytes)
    $image = [System.Drawing.Image]::FromStream($stream)
    $stream.Dispose()

    $resized = Resize-Image -Image $image -MaxWidth $MaxWidth
    $image.Dispose()

    $baseName = [System.IO.Path]::GetFileNameWithoutExtension($FileName)
    $jpegPath = Join-Path $assets ($baseName + '.jpg')
    $pngPath = Join-Path $assets ($baseName + '.png')
    $pngTempPath = Join-Path $assets ($baseName + '.tmp.png')

    Save-Jpeg -Bitmap $resized -Path $jpegPath -Quality $JpegQuality

    if ($FileName -eq 'fibra.png') {
        $resized.Save($pngTempPath, [System.Drawing.Imaging.ImageFormat]::Png)
        Move-Item -Path $pngTempPath -Destination $pngPath -Force
    }

    $oldKb = [Math]::Round((Get-Item $backupPath).Length / 1KB, 1)
    $jpgKb = [Math]::Round((Get-Item $jpegPath).Length / 1KB, 1)
    $pngKb = [Math]::Round((Get-Item $pngPath).Length / 1KB, 1)

    Write-Output "$FileName -> ${baseName}.jpg (${jpgKb} KB), ${baseName}.png (${pngKb} KB). Original: ${oldKb} KB"

    $resized.Dispose()
}

Optimize-Asset -FileName 'fibra.png' -MaxWidth 800 -JpegQuality 82
Optimize-Asset -FileName 'mapa-regional-sur.png' -MaxWidth 1024 -JpegQuality 80
