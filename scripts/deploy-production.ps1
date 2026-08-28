# Empaqueta el sitio para subir al hosting de producción.

# Excluye desarrollo, secretos y archivos innecesarios.

param(

    [string]$OutputDir = "",

    [switch]$NoZip

)



$ErrorActionPreference = "Stop"

$src = Split-Path $PSScriptRoot -Parent

$stamp = Get-Date -Format "yyyyMMdd-HHmm"

if ($OutputDir -eq "") {

    $OutputDir = Join-Path $src "dist\telcosur-spa-web-$stamp"

}



$php = "C:\xampp\php\php.exe"

$composer = "C:\Users\Usuario\bin\composer.bat"

if (-not (Test-Path $php)) { $php = "php" }



Write-Output "=== Deploy producción TelcoSur SPA ==="

Write-Output "Origen:  $src"

Write-Output "Destino: $OutputDir"



if (Test-Path $OutputDir) {

    Remove-Item $OutputDir -Recurse -Force

}

New-Item -ItemType Directory -Force -Path $OutputDir | Out-Null



$excludeDirs = @(

    "backups", "node_modules", ".git", "dist", "scripts", "reports", "ingresos",

    "vendor", ".cursor", ".idea", ".vscode"

)



$excludeFiles = @(

    "zap-quick-report.html", "phpstan.neon", "rector.php", ".php-cs-fixer.dist.php",

    "package.json", "package-lock.json", "_shelltest.txt",

    "db.php", "admin-config.php", "mail-config.php", "site-config.php"

)



# Copia con robocopy (exit 0-7 = OK)
$robocopyArgs = @($src, $OutputDir, "/E", "/NFL", "/NDL", "/NJH", "/NJS", "/NC", "/NS")
foreach ($d in $excludeDirs) {
    $robocopyArgs += "/XD"
    $robocopyArgs += $d
}
foreach ($f in $excludeFiles) {
    $robocopyArgs += "/XF"
    $robocopyArgs += $f
}
& robocopy @robocopyArgs | Out-Null

if ($LASTEXITCODE -gt 7) {

    Write-Error "Robocopy falló con código $LASTEXITCODE"

    exit 1

}



# Plantillas de configuración (siempre incluidas)

$templates = @(

    "db.example.php", "admin-config.example.php", "mail-config.example.php",

    "mail-config.production.example.php", "site-config.example.php"

)

foreach ($tpl in $templates) {

    $from = Join-Path $src $tpl

    if (Test-Path $from) {

        Copy-Item $from (Join-Path $OutputDir $tpl) -Force

    }

}



# Composer producción (solo dependencias runtime: PHPMailer)

Push-Location $OutputDir

if (Test-Path $composer) {

    & $composer install --no-dev --optimize-autoloader --no-interaction 2>&1 | Write-Output

} else {

  Write-Warning "Composer no encontrado. Copia vendor/ manualmente o ejecuta composer install --no-dev en el servidor."

  if (Test-Path (Join-Path $src "vendor")) {

    Copy-Item (Join-Path $src "vendor") (Join-Path $OutputDir "vendor") -Recurse -Force

  }

}

Pop-Location



# Carpetas escribibles

foreach ($dir in @("uploads\cv", "storage\rate-limit")) {

    $p = Join-Path $OutputDir $dir

    New-Item -ItemType Directory -Force -Path $p | Out-Null

    if (-not (Test-Path (Join-Path $p ".gitkeep"))) {

        New-Item -ItemType File -Force -Path (Join-Path $p ".gitkeep") | Out-Null

    }

}



$readme = @"

TELCOSUR SPA — Paquete de producción ($stamp)

============================================



1. Sube el contenido de esta carpeta a public_html (o www).



2. Crea en el servidor (NO subas desde tu PC):

   - db.php          (copia de db.example.php)

   - admin-config.php

   - mail-config.php (usa mail-config.production.example.php)

   - site-config.php (Turnstile + dominio)



3. Importa database.sql en MySQL.



4. Permisos de escritura: uploads/cv/ y storage/rate-limit/



5. Activa SSL en el hosting. HTTPS se fuerza solo en telcosurspa.cl (.htaccess).



6. Cloudflare Turnstile: site-config.php → enabled true + keys.



7. Prueba formularios, admin y correo antes de anunciar el sitio.

"@

Set-Content -Path (Join-Path $OutputDir "LEEME-DEPLOY.txt") -Value $readme -Encoding UTF8



$sizeMb = [math]::Round((Get-ChildItem $OutputDir -Recurse | Measure-Object -Property Length -Sum).Sum / 1MB, 1)

Write-Output "Paquete listo: $OutputDir ($sizeMb MB)"



if (-not $NoZip) {

    $zipPath = "$OutputDir.zip"

    if (Test-Path $zipPath) { Remove-Item $zipPath -Force }

    Compress-Archive -Path $OutputDir -DestinationPath $zipPath -Force

    $zipMb = [math]::Round((Get-Item $zipPath).Length / 1MB, 1)

    Write-Output "ZIP: $zipPath ($zipMb MB)"

}



Write-Output "Deploy producción completado."

