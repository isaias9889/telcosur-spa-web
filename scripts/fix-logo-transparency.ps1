Add-Type -AssemblyName System.Drawing

function Remove-WhiteBackground {
    param(
        [string]$Path,
        [int]$Tolerance = 42
    )

    $srcPath = $Path -replace '\.png$', '-original.png'
    if (-not (Test-Path $srcPath)) {
        $srcPath = $Path
    }

    $bmp = [System.Drawing.Bitmap]::FromFile((Resolve-Path $srcPath))
    $out = New-Object System.Drawing.Bitmap $bmp.Width, $bmp.Height, ([System.Drawing.Imaging.PixelFormat]::Format32bppArgb)

    for ($y = 0; $y -lt $bmp.Height; $y++) {
        for ($x = 0; $x -lt $bmp.Width; $x++) {
            $pixel = $bmp.GetPixel($x, $y)
            $r = [int]$pixel.R
            $g = [int]$pixel.G
            $b = [int]$pixel.B
            $whiteDist = [Math]::Sqrt(($r - 255) * ($r - 255) + ($g - 255) * ($g - 255) + ($b - 255) * ($b - 255))

            if ($whiteDist -lt $Tolerance) {
                $alpha = [int]([Math]::Min(255, ($whiteDist / [double]$Tolerance) * 255))
                if ($alpha -le 8) {
                    $out.SetPixel($x, $y, [System.Drawing.Color]::FromArgb(0, 0, 0, 0))
                } else {
                    $out.SetPixel($x, $y, [System.Drawing.Color]::FromArgb($alpha, $r, $g, $b))
                }
            } else {
                $out.SetPixel($x, $y, [System.Drawing.Color]::FromArgb(255, $r, $g, $b))
            }
        }
    }

    $bmp.Dispose()
    $out.Save($Path, [System.Drawing.Imaging.ImageFormat]::Png)
    $out.Dispose()
}

$assets = Join-Path (Split-Path $PSScriptRoot -Parent) 'assets'
Remove-WhiteBackground (Join-Path $assets 'logo-claro.png')
Remove-WhiteBackground (Join-Path $assets 'logo-vtr.png')
Write-Output 'Logos con fondo transparente listos.'
