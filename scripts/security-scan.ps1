# Escaneo de seguridad local (headers + ZAP quick scan si está instalado).
param(
    [string]$BaseUrl = 'http://localhost/telcosur-spa-web/',
    [string]$ZapDir = 'C:\Program Files\ZAP\Zed Attack Proxy'
)

$ErrorActionPreference = 'Continue'
Write-Output "=== Security scan: $BaseUrl ==="

try {
    $r = Invoke-WebRequest -Uri $BaseUrl -UseBasicParsing -TimeoutSec 15
    Write-Output "HTTP $($r.StatusCode)"
} catch {
    Write-Error "No se pudo acceder a $BaseUrl : $_"
    exit 1
}

$expected = @(
    'X-Content-Type-Options',
    'X-Frame-Options',
    'Referrer-Policy',
    'Content-Security-Policy'
)

foreach ($h in $expected) {
    if ($r.Headers[$h]) {
        Write-Output "[OK] $h : $($r.Headers[$h])"
    } else {
        Write-Output "[WARN] Falta header $h"
    }
}

if ($r.Content -match 'fonts\.googleapis|fonts\.gstatic') {
    Write-Output '[WARN] Referencias a Google Fonts en HTML'
} else {
    Write-Output '[OK] Sin Google Fonts en HTML'
}

if ($r.Content -match 'csrf|_token') {
    Write-Output '[OK] Formularios parecen incluir protección CSRF'
} else {
    Write-Output '[INFO] No se detectó token CSRF en la home (puede estar solo en formularios)'
}

$zapJar = Join-Path $ZapDir 'zap-2.17.0.jar'
if (-not (Test-Path $zapJar)) {
    $zapJar = Get-ChildItem $ZapDir -Filter 'zap-*.jar' -ErrorAction SilentlyContinue | Select-Object -First 1 -ExpandProperty FullName
}

$java = (Get-Command java -ErrorAction SilentlyContinue).Source
if (-not $java) {
    $java = (Get-ChildItem 'C:\Program Files\Eclipse Adoptium' -Recurse -Filter java.exe -ErrorAction SilentlyContinue |
        Select-Object -First 1 -ExpandProperty FullName)
}

if ($zapJar -and $java) {
    $report = Join-Path (Split-Path $PSScriptRoot -Parent) 'zap-quick-report.html'
    $zapHome = Join-Path $env:LOCALAPPDATA 'telcosur-zap'
    New-Item -ItemType Directory -Force -Path $zapHome | Out-Null
    $env:ZAP_HOME = $zapHome
    Push-Location $ZapDir
    Write-Output "Ejecutando ZAP quick scan (java: $java)..."
    & $java -jar $zapJar -cmd -quickurl $BaseUrl -quickout $report 2>&1
    $zapExit = $LASTEXITCODE
    Pop-Location
    if (Test-Path $report) {
        Write-Output "Reporte ZAP: $report (exit $zapExit)"
    }
} else {
    Write-Output '[INFO] ZAP/Java no disponibles; solo se verificaron headers HTTP.'
}
