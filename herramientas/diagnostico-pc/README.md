# Diagnóstico de PC

Programa ejecutable que detecta los antivirus instalados y revisa si el equipo tiene fallas.
Al terminar muestra el resultado en la consola y abre un reporte HTML en el navegador.

## Qué revisa

| Área | Windows | Linux / macOS |
|------|---------|---------------|
| Antivirus | Antivirus registrados en el Centro de seguridad (activo / firmas al día), Microsoft Defender, historial de amenazas, firewall | ClamAV, Sophos, ESET, Defender for Endpoint, rkhunter, XProtect |
| Discos | Salud física (SMART), predicción de falla, estado del sistema de archivos, espacio libre | Espacio libre, SMART con `smartctl` |
| Sistema | RAM, días sin reiniciar, reinicio pendiente, última actualización de Windows, desgaste de batería | RAM, días encendido, carga de CPU |
| Eventos (7 días) | Apagados inesperados, pantallazos azules, errores de hardware (WHEA), errores de disco y NTFS | — |
| Profundo (`--profundo`) | Integridad de los archivos de Windows (`Repair-WindowsImage -ScanHealth`) | — |

Cada punto se marca como **OK**, **ADVERTENCIA**, **PROBLEMA** o **INFO**, con una recomendación cuando corresponde.

## Obtener el `.exe`

**Opción A, desde GitHub:** cada cambio en esta carpeta ejecuta el workflow
*Diagnóstico de PC (ejecutable Windows)*. Entra a la pestaña **Actions**, abre la última ejecución
y descarga el artefacto `DiagnosticoPC`.

**Opción B, compilarlo en tu PC:** instala [Python 3](https://www.python.org/downloads/)
(marca *Add python.exe to PATH*) y haz doble clic en `compilar.bat`. El ejecutable queda en
`dist\DiagnosticoPC.exe`.

## Uso

- Doble clic en `DiagnosticoPC.exe` para el diagnóstico rápido.
- Para la revisión completa, abre una terminal **como administrador** y ejecuta:

```powershell
DiagnosticoPC.exe --profundo --escanear
```

| Opción | Efecto |
|--------|--------|
| `--profundo` | Revisa si los archivos de Windows están dañados (requiere administrador, tarda unos minutos) |
| `--escanear` | Lanza un escaneo rápido de Microsoft Defender |
| `--sin-abrir` | No abre el reporte HTML al terminar |

Sin compilar también funciona con `python diagnostico_pc.py`.

El código de salida es `0` si todo está bien, `1` si hay advertencias y `2` si hay problemas.

Windows SmartScreen puede advertir que el `.exe` no está firmado; elige *Más información > Ejecutar de todas formas*.
