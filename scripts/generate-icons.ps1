# Genera favicon e iconos PWA desde assets/logo.png usando ImageMagick
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
if (-not (Test-Path $logo)) { Write-Output "No existe $logo"; exit 1 }

$iconsDir = Join-Path $assets 'icons'
New-Item -ItemType Directory -Force -Path $iconsDir | Out-Null

# Fondo del logo (esquina oscura) para rellenar hasta cuadrado
$bg = '#232323'

# favicon.ico multi-tamaño
& $magick $logo -background $bg -gravity center -extent 410x410 -define icon:auto-resize=16,32,48,64 (Join-Path $assets 'favicon.ico')
Write-Output 'favicon.ico'

# PWA / Apple
& $magick $logo -background $bg -gravity center -extent 410x410 -resize 192x192 (Join-Path $iconsDir 'icon-192.png')
& $magick $logo -background $bg -gravity center -extent 410x410 -resize 512x512 (Join-Path $iconsDir 'icon-512.png')
& $magick $logo -background $bg -gravity center -extent 410x410 -resize 180x180 (Join-Path $iconsDir 'apple-touch-icon.png')
Write-Output 'iconos PWA + apple-touch'

Write-Output 'Iconos generados.'
