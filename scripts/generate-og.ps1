# Genera imágenes Open Graph (1200x630) de marca con ImageMagick
$assets = Join-Path (Split-Path $PSScriptRoot -Parent) 'assets'
$logo = Join-Path $assets 'logo.png'

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

$ogDir = Join-Path $assets 'og'
New-Item -ItemType Directory -Force -Path $ogDir | Out-Null

$fontBold = 'C:/Windows/Fonts/arialbd.ttf'
$fontReg = 'C:/Windows/Fonts/arial.ttf'

function New-OgImage {
    param([string]$OutName, [string]$Title)

    $out = Join-Path $ogDir $OutName

    # Fondo degradado corporativo + logo a la izquierda + texto a la derecha
    $args = @(
        '-size', '1200x630', "gradient:#0d1b2a-#123a6b",
        '(', $logo, '-resize', '300x300', ')', '-gravity', 'West', '-geometry', '+90+0', '-composite',
        '-font', $fontBold, '-pointsize', '74', '-fill', '#ffffff', '-gravity', 'West', '-annotate', '+470-70', $Title,
        '-font', $fontReg, '-pointsize', '32', '-fill', '#cfe0f5', '-gravity', 'West', '-annotate', '+472+10', 'Distribuidor autorizado Claro y VTR',
        '-font', $fontReg, '-pointsize', '28', '-fill', '#9fb6d6', '-gravity', 'West', '-annotate', '+472+70', 'Cerca de ti, cerca de todos - Sur de Chile',
        '-quality', '88', $out
    )
    & $magick @args
    Write-Output "OG: $OutName"

    $webp = [System.IO.Path]::ChangeExtension($out, '.webp')
    & $magick $out -quality 85 $webp
}

New-OgImage -OutName 'og-default.jpg' -Title 'TelcoSur'
New-OgImage -OutName 'og-home.jpg' -Title 'TelcoSur'
New-OgImage -OutName 'og-nosotros.jpg' -Title 'Nosotros'
New-OgImage -OutName 'og-servicios.jpg' -Title 'Servicios'
New-OgImage -OutName 'og-cobertura.jpg' -Title 'Cobertura'
New-OgImage -OutName 'og-talento.jpg' -Title 'Talento'
New-OgImage -OutName 'og-contacto.jpg' -Title 'Contacto'

Write-Output 'Imágenes Open Graph generadas.'
