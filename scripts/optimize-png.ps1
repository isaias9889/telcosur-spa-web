# Optimiza los PNG del proyecto con pngquant (cuantización de paleta) + oxipng (lossless).
# No toca la carpeta assets/original ni los archivos *-original.png (respaldos).

function Resolve-Tool {
    param([string]$Name)
    $cmd = Get-Command $Name -ErrorAction SilentlyContinue
    if ($cmd) { return $cmd.Source }
    $fallback = Join-Path "C:\Users\Usuario\bin" ($Name + '.exe')
    if (Test-Path $fallback) { return $fallback }
    return $null
}

$pngquant = Resolve-Tool 'pngquant'
$oxipng   = Resolve-Tool 'oxipng'

if (-not $pngquant) { Write-Output 'pngquant no encontrado.'; exit 1 }
if (-not $oxipng)   { Write-Output 'oxipng no encontrado.';   exit 1 }

$assets = Join-Path (Split-Path $PSScriptRoot -Parent) 'assets'

$targets = Get-ChildItem -Path $assets -Filter *.png -Recurse |
    Where-Object {
        $_.FullName -notmatch '\\original\\' -and
        $_.Name -notmatch '-original\.png$'
    }

$totalBefore = 0
$totalAfter  = 0

foreach ($file in $targets) {
    $before = $file.Length
    $totalBefore += $before

    # pngquant: reduce paleta manteniendo calidad; conserva el archivo si no mejora.
    & $pngquant --quality=70-95 --skip-if-larger --strip --force --ext .png "$($file.FullName)" 2>$null

    # oxipng: optimización lossless adicional + limpieza de metadatos segura.
    & $oxipng -o 4 --strip safe --quiet "$($file.FullName)" 2>$null

    $after = (Get-Item $file.FullName).Length
    $totalAfter += $after

    $saved = $before - $after
    $pct = if ($before -gt 0) { [math]::Round(($saved / $before) * 100, 1) } else { 0 }
    $name = $file.FullName.Replace($assets + '\', '')
    Write-Output ("{0,-32} {1,8:N1} KB -> {2,8:N1} KB  (-{3}%)" -f $name, ($before/1KB), ($after/1KB), $pct)
}

$savedTotal = $totalBefore - $totalAfter
$pctTotal = if ($totalBefore -gt 0) { [math]::Round(($savedTotal / $totalBefore) * 100, 1) } else { 0 }
Write-Output ''
Write-Output ("Total: {0:N1} KB -> {1:N1} KB  (ahorro {2:N1} KB, -{3}%)" -f ($totalBefore/1KB), ($totalAfter/1KB), ($savedTotal/1KB), $pctTotal)
Write-Output 'Optimización PNG completada.'
