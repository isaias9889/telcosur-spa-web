@echo off
REM Genera dist\DiagnosticoPC.exe a partir de diagnostico_pc.py
cd /d "%~dp0"

where python >nul 2>nul
if errorlevel 1 (
    echo Python no esta instalado. Descargalo desde https://www.python.org/downloads/
    echo Marca la opcion "Add python.exe to PATH" durante la instalacion.
    pause
    exit /b 1
)

python -m pip install --upgrade pyinstaller
python -m PyInstaller --onefile --console --name DiagnosticoPC diagnostico_pc.py
if errorlevel 1 (
    echo Error al compilar.
    pause
    exit /b 1
)

echo.
echo Listo: %~dp0dist\DiagnosticoPC.exe
pause
