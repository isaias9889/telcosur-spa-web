# Comprime JPEG del proyecto (requiere archivos en assets/)
Add-Type -AssemblyName System.Drawing

function Compress-Jpeg {
    param([string]$Path, [long]$Quality = 82)

    $codec = [System.Drawing.Imaging.ImageCodecInfo]::GetImageEncoders() | Where-Object { $_.MimeType -eq 'image/jpeg' }
    $encoder = [System.Drawing.Imaging.Encoder]::Quality
    $params = New-Object System.Drawing.Imaging.EncoderParameters(1)
    $params.Param[0] = New-Object System.Drawing.Imaging.EncoderParameter($encoder, $Quality)

    $img = [System.Drawing.Image]::FromFile((Resolve-Path $Path))
    $img.Save($Path, $codec, $params)
    $img.Dispose()
}

$root = Join-Path (Split-Path $PSScriptRoot -Parent) 'assets'
Get-ChildItem -Path $root -Recurse -Include *.jpg,*.jpeg | ForEach-Object {
    Compress-Jpeg $_.FullName
    Write-Output "Comprimido: $($_.Name)"
}
Write-Output 'Compresión JPEG completada.'
