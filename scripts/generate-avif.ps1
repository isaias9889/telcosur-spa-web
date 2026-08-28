# Genera versiones AVIF (siguiente generación, más liviano que WebP) de las
# imágenes que ya tienen WebP. Requiere ImageMagick con soporte AVIF (libheif).

function Resolve-MagickExe {
    $cmd = Get-Command magick -ErrorAction SilentlyContinue
    if ($cmd) { return $cmd.Source }
    $roots = @($env:ProgramFiles)
    $x86 = ${env:ProgramFiles(x86)}
    if ($x86) { $roots += $x86 }
    foreach ($root in $roots) {
        $match = Get-ChildItem -Path $root -Filter magick.exe -Recurse -ErrorAction SilentlyContinue |
            Where-Object { $_.FullName -like '*ImageMagick*' } | Select-Object -First 1
        if ($match) { return $match.FullName }
    }
    return $null
}

$magick = Resolve-MagickExe
if (-not $magick) { Write-Output 'ImageMagick no encontrado.'; exit 1 }

$assets = Join-Path (Split-Path $PSScriptRoot -Parent) 'assets'

# Toma como referencia los .webp existentes (imágenes realmente servidas).
$webps = Get-ChildItem -Path $assets -Filter *.webp -Recurse |
    Where-Object { $_.FullName -notmatch '\\original\\' -and $_.Name -notmatch '-original\.webp$' }

$count = 0
foreach ($webp in $webps) {
    $base = [System.IO.Path]::ChangeExtension($webp.FullName, $null).TrimEnd('.')

    # Fuente preferida: JPG, luego PNG, luego el propio WEBP.
    $source = $null
    foreach ($ext in @('.jpg', '.jpeg', '.png')) {
        $candidate = $base + $ext
        if (Test-Path $candidate) { $source = $candidate; break }
    }
    if (-not $source) { $source = $webp.FullName }

    $avif = $base + '.avif'
    & $magick $source -quality 50 $avif 2>$null

    if (Test-Path $avif) {
        $count++
        $name = $avif.Replace($assets + '\', '')
        $kb = [math]::Round((Get-Item $avif).Length / 1KB, 1)
        Write-Output ("{0,-40} {1,8:N1} KB" -f $name, $kb)
    }
}

Write-Output ''
Write-Output "AVIF generados: $count"
