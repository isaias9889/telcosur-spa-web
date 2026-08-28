# Genera WebP si ImageMagick (magick) está instalado
$root = Join-Path (Split-Path $PSScriptRoot -Parent) 'assets'

function Resolve-MagickExe {
    $cmd = Get-Command magick -ErrorAction SilentlyContinue
    if ($cmd) {
        return $cmd.Source
    }

    $searchRoots = @($env:ProgramFiles)
    $programFilesX86 = ${env:ProgramFiles(x86)}
    if ($programFilesX86) {
        $searchRoots += $programFilesX86
    }

    foreach ($root in $searchRoots) {
        $match = Get-ChildItem -Path $root -Filter magick.exe -Recurse -ErrorAction SilentlyContinue |
            Where-Object { $_.FullName -like '*ImageMagick*' } |
            Select-Object -First 1
        if ($match) {
            return $match.FullName
        }
    }

    return $null
}

$magickExe = Resolve-MagickExe

if (-not $magickExe) {
    Write-Output 'ImageMagick no encontrado. Instala magick o agrega su carpeta al PATH del sistema.'
    exit 1
}

Write-Output "Usando: $magickExe"

Get-ChildItem -Path $root -Recurse -Include *.jpg,*.jpeg,*.png | ForEach-Object {
    $webp = [System.IO.Path]::ChangeExtension($_.FullName, '.webp')
    & $magickExe $_.FullName -quality 82 $webp
    Write-Output "WebP: $($_.Name)"
}
Write-Output 'WebP generados.'
