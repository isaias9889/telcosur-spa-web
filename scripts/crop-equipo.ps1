# Recorta y normaliza fotos del equipo TelcoSur
Add-Type -AssemblyName System.Drawing

function Export-TeamPhoto {
    param(
        [string]$SourcePath,
        [string]$DestPath,
        [double]$TargetRatio,
        [double]$TrimPercent = 0.04,
        [int]$MaxWidth = 1200
    )

    if (-not (Test-Path $SourcePath)) {
        Write-Warning "No existe: $SourcePath"
        return
    }

    $src = [System.Drawing.Image]::FromFile($SourcePath)
    $trimX = [int]($src.Width * $TrimPercent)
    $trimY = [int]($src.Height * $TrimPercent)
    $cropW = $src.Width - (2 * $trimX)
    $cropH = $src.Height - (2 * $trimY)

    if ($cropW -lt 10 -or $cropH -lt 10) {
        $src.Dispose()
        return
    }

    $currentRatio = $cropW / $cropH

    if ($currentRatio -gt $TargetRatio) {
        $newW = [int]($cropH * $TargetRatio)
        $newH = $cropH
        $x = $trimX + [int](($cropW - $newW) / 2)
        $y = $trimY
    }
    else {
        $newW = $cropW
        $newH = [int]($cropW / $TargetRatio)
        $x = $trimX
        $y = $trimY + [int](($cropH - $newH) / 2)
    }

    $bmp = New-Object System.Drawing.Bitmap $newW, $newH
    $graphics = [System.Drawing.Graphics]::FromImage($bmp)
    $graphics.InterpolationMode = [System.Drawing.Drawing2D.InterpolationMode]::HighQualityBicubic
    $graphics.PixelOffsetMode = [System.Drawing.Drawing2D.PixelOffsetMode]::HighQuality
    $graphics.CompositingQuality = [System.Drawing.Drawing2D.CompositingQuality]::HighQuality

    $sourceRect = New-Object System.Drawing.Rectangle $x, $y, $newW, $newH
    $graphics.DrawImage($src, 0, 0, $sourceRect, [System.Drawing.GraphicsUnit]::Pixel)

    if ($newW -gt $MaxWidth) {
        $scale = $MaxWidth / $newW
        $outW = $MaxWidth
        $outH = [int]($newH * $scale)
        $resized = New-Object System.Drawing.Bitmap $outW, $outH
        $g2 = [System.Drawing.Graphics]::FromImage($resized)
        $g2.InterpolationMode = [System.Drawing.Drawing2D.InterpolationMode]::HighQualityBicubic
        $g2.DrawImage($bmp, 0, 0, $outW, $outH)
        $g2.Dispose()
        $bmp.Dispose()
        $bmp = $resized
    }

    $encoder = [System.Drawing.Imaging.ImageCodecInfo]::GetImageEncoders() | Where-Object { $_.MimeType -eq 'image/jpeg' }
    $encoderParams = New-Object System.Drawing.Imaging.EncoderParameters 1
    $encoderParams.Param[0] = New-Object System.Drawing.Imaging.EncoderParameter ([System.Drawing.Imaging.Encoder]::Quality), 88L
    $bmp.Save($DestPath, $encoder, $encoderParams)

    $graphics.Dispose()
    $bmp.Dispose()
    $src.Dispose()

    Write-Host "OK $DestPath"
}

$dir = Join-Path $PSScriptRoot '..\assets\equipo'

Export-TeamPhoto -SourcePath "$dir\imagen_01_arriba_izquierda.jpg" -DestPath "$dir\equipo-hero.jpg" -TargetRatio 1.65 -TrimPercent 0.02
Export-TeamPhoto -SourcePath "$dir\imagen_03_arriba_derecha.jpg" -DestPath "$dir\equipo-escalera.jpg" -TargetRatio 0.72 -TrimPercent 0.03
Export-TeamPhoto -SourcePath "$dir\imagen_04_medio_izquierda.jpg" -DestPath "$dir\equipo-equipo.jpg" -TargetRatio 1.55 -TrimPercent 0.03
Export-TeamPhoto -SourcePath "$dir\imagen_08_abajo_centro.jpg" -DestPath "$dir\equipo-celebracion.jpg" -TargetRatio 1.7 -TrimPercent 0.04
