# Habilita mod_filter en XAMPP (necesario para Gzip vía AddOutputFilterByType en .htaccess).
# Ejecutar como administrador si httpd.conf no es escribible.
$conf = 'C:\xampp\apache\conf\httpd.conf'
if (-not (Test-Path $conf)) {
    Write-Error "No se encontró $conf"
    exit 1
}

$content = Get-Content $conf -Raw
$original = $content

$content = $content -replace '#LoadModule filter_module modules/mod_filter\.so', 'LoadModule filter_module modules/mod_filter.so'

if ($content -eq $original) {
    if ($content -match '^\s*LoadModule filter_module') {
        Write-Output 'mod_filter ya estaba habilitado.'
    } else {
        Write-Warning 'No se encontró la línea de mod_filter en httpd.conf.'
    }
} else {
    Set-Content -Path $conf -Value $content -NoNewline
    Write-Output 'mod_filter habilitado en httpd.conf. Reinicia Apache en XAMPP (Stop -> Start).'
}

# Verificar módulos cargados (requiere Apache en ejecución)
$apache = 'C:\xampp\apache\bin\httpd.exe'
if (Test-Path $apache) {
    & $apache -M 2>&1 | Select-String -Pattern 'deflate|filter'
}
