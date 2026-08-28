# Sincroniza el proyecto con XAMPP local
$src = Split-Path $PSScriptRoot -Parent
$dst = "C:\xampp\htdocs\telcosur-spa-web"

if (-not (Test-Path $dst)) {
    Write-Error "No se encontró XAMPP en $dst"
    exit 1
}

$paths = @(
    "index.php",
    "404.php",
    "planes.php",
    "servicios.php",
    "sobre-nosotros.php",
    "cobertura.php",
    "contacto.php",
    "trabaja-con-nosotros.php",
    "resultado.php",
    "equipo-tema.php",
    "privacidad.php",
    "terminos.php",
    "contacto-enviar.php",
    "consulta-plan.php",
    "postular.php",
    "mail-config.example.php",
    "mail-config.php",
    "composer.json",
    "composer.lock",
    "vendor",
    "robots.txt",
    "sitemap.xml",
    "site.webmanifest",
    ".htaccess",
    "css\fonts.css",
    "css\critical.css",
    "css\critical.min.css",
    "css\corporate.css",
    "css\animations.css",
    "css\polish.css",
    "css\accessibility.css",
    "css\style.css",
    "css\bundle.min.css",
    "js\main.js",
    "js\animations.js",
    "js\bundle.min.js",
    "js\vendor",
    "assets",
    "includes",
    "includes\interactive-map.php",
    "includes\map-offices.php"
)

foreach ($rel in $paths) {
    $from = Join-Path $src $rel
    $to = Join-Path $dst $rel
    if (-not (Test-Path $from)) { continue }
    if ((Get-Item $from).PSIsContainer) {
        Copy-Item "$from\*" (Split-Path $to -Parent) -Recurse -Force -ErrorAction SilentlyContinue
        New-Item -ItemType Directory -Force -Path $to | Out-Null
        Copy-Item "$from\*" $to -Recurse -Force
    } else {
        Copy-Item $from $to -Force
    }
}

Write-Output "Deploy completado: $dst"
