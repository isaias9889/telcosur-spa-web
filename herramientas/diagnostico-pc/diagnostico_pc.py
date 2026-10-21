"""Diagnóstico de PC: detecta antivirus instalados y revisa la salud del equipo.

Uso:
    python diagnostico_pc.py              Diagnóstico rápido
    python diagnostico_pc.py --profundo   Agrega revisión de imagen de Windows (requiere administrador)
    python diagnostico_pc.py --escanear   Lanza un escaneo rápido de Microsoft Defender
    python diagnostico_pc.py --sin-abrir  No abre el reporte HTML al terminar
"""

from __future__ import annotations

import argparse
import ctypes
import html
import json
import os
import platform
import shutil
import subprocess
import sys
import webbrowser
from dataclasses import dataclass, field
from datetime import datetime
from pathlib import Path

VERSION = "1.0.0"

OK = "OK"
ADVERTENCIA = "ADVERTENCIA"
PROBLEMA = "PROBLEMA"
INFO = "INFO"

COLORES = {
    OK: "\033[92m",
    ADVERTENCIA: "\033[93m",
    PROBLEMA: "\033[91m",
    INFO: "\033[96m",
}
RESET = "\033[0m"

ES_WINDOWS = os.name == "nt"


@dataclass
class Resultado:
    categoria: str
    nombre: str
    estado: str
    detalle: str
    recomendacion: str = ""


@dataclass
class Reporte:
    resultados: list[Resultado] = field(default_factory=list)

    def agregar(self, categoria, nombre, estado, detalle, recomendacion=""):
        r = Resultado(categoria, nombre, estado, detalle, recomendacion)
        self.resultados.append(r)
        imprimir_resultado(r)

    def contar(self, estado):
        return sum(1 for r in self.resultados if r.estado == estado)


def imprimir_resultado(r: Resultado):
    color = COLORES.get(r.estado, "")
    print(f"  {color}[{r.estado:^11}]{RESET} {r.nombre}: {r.detalle}")
    if r.recomendacion:
        print(f"               -> {r.recomendacion}")


def titulo(texto):
    print(f"\n\033[1m== {texto} ==\033[0m")


def ejecutar(comando, timeout=120):
    flags = 0x08000000 if ES_WINDOWS else 0  # CREATE_NO_WINDOW
    try:
        proc = subprocess.run(
            comando,
            capture_output=True,
            timeout=timeout,
            creationflags=flags,
        )
    except (OSError, subprocess.TimeoutExpired) as exc:
        return None, str(exc)
    salida = proc.stdout.decode("utf-8", errors="replace")
    return proc.returncode, salida


def powershell(script, timeout=120):
    """Ejecuta PowerShell y devuelve el resultado JSON como lista (o None si falla)."""
    completo = (
        "[Console]::OutputEncoding = [System.Text.Encoding]::UTF8; "
        "$ErrorActionPreference = 'SilentlyContinue'; "
        f"@({script}) | ConvertTo-Json -Depth 4 -Compress"
    )
    codigo, salida = ejecutar(
        ["powershell", "-NoProfile", "-NonInteractive", "-ExecutionPolicy", "Bypass", "-Command", completo],
        timeout=timeout,
    )
    if codigo is None:
        return None
    salida = salida.strip()
    if not salida:
        return []
    try:
        datos = json.loads(salida)
    except json.JSONDecodeError:
        return None
    if isinstance(datos, dict):
        return [datos]
    return datos


def es_administrador():
    if ES_WINDOWS:
        try:
            return bool(ctypes.windll.shell32.IsUserAnAdmin())
        except (AttributeError, OSError):
            return False
    return hasattr(os, "geteuid") and os.geteuid() == 0


def formato_bytes(n):
    for unidad in ("B", "KB", "MB", "GB", "TB"):
        if n < 1024:
            return f"{n:.1f} {unidad}"
        n /= 1024
    return f"{n:.1f} PB"


# --------------------------------------------------------------------------
# Antivirus
# --------------------------------------------------------------------------

def decodificar_estado_av(product_state):
    """Interpreta productState de SecurityCenter2: (activo, firmas_al_dia)."""
    hexa = f"{int(product_state):06X}"
    activo = hexa[2:4] in ("10", "11")
    al_dia = hexa[4:6] == "00"
    return activo, al_dia


def revisar_antivirus_windows(rep: Reporte, escanear: bool):
    titulo("Antivirus y protección")
    productos = powershell(
        "Get-CimInstance -Namespace root/SecurityCenter2 -ClassName AntiVirusProduct "
        "| Select-Object displayName, productState, pathToSignedProductExe"
    )
    defender = powershell(
        "Get-MpComputerStatus | Select-Object AMServiceEnabled, AntivirusEnabled, "
        "RealTimeProtectionEnabled, AntivirusSignatureAge, QuickScanAge"
    )
    defender_activo = bool(defender and defender[0].get("AntivirusEnabled")
                           and defender[0].get("RealTimeProtectionEnabled"))

    if not productos and not defender_activo:
        # Windows Server no tiene Centro de seguridad, así que la lista vacía no basta para concluir.
        rep.agregar("Antivirus", "Antivirus instalado", PROBLEMA,
                    "No se detectó ningún antivirus con protección activa.",
                    "Activa Microsoft Defender o instala un antivirus confiable.")
    elif productos:
        algun_activo = False
        for p in productos:
            nombre = p.get("displayName") or "Desconocido"
            try:
                activo, al_dia = decodificar_estado_av(p.get("productState", 0))
            except (TypeError, ValueError):
                rep.agregar("Antivirus", nombre, INFO, "Detectado (estado desconocido).")
                continue
            algun_activo = algun_activo or activo
            if activo and al_dia:
                rep.agregar("Antivirus", nombre, OK, "Activo y con firmas actualizadas.")
            elif activo:
                rep.agregar("Antivirus", nombre, ADVERTENCIA, "Activo pero con firmas desactualizadas.",
                            "Actualiza las definiciones de virus.")
            else:
                rep.agregar("Antivirus", nombre, INFO, "Instalado pero no es el antivirus activo.")
        if not algun_activo and not defender_activo:
            rep.agregar("Antivirus", "Protección activa", PROBLEMA,
                        "Hay antivirus instalados, pero ninguno está activo.",
                        "Activa la protección en tiempo real.")

    if defender:
        d = defender[0]
        if d.get("AntivirusEnabled") and d.get("RealTimeProtectionEnabled"):
            rep.agregar("Antivirus", "Microsoft Defender", OK, "Protección en tiempo real activada.")
        elif d.get("AMServiceEnabled"):
            rep.agregar("Antivirus", "Microsoft Defender", INFO,
                        "Servicio presente; la protección en tiempo real está desactivada "
                        "(normal si usas otro antivirus).")
        edad = d.get("AntivirusSignatureAge")
        if isinstance(edad, int) and d.get("AntivirusEnabled"):
            if edad > 7:
                rep.agregar("Antivirus", "Firmas de Defender", ADVERTENCIA,
                            f"Las definiciones tienen {edad} días.",
                            "Ejecuta Windows Update para actualizarlas.")
            else:
                rep.agregar("Antivirus", "Firmas de Defender", OK, f"Actualizadas hace {edad} día(s).")
        escaneo = d.get("QuickScanAge")
        if isinstance(escaneo, int) and d.get("AntivirusEnabled") and escaneo > 14 and escaneo < 4294967295:
            rep.agregar("Antivirus", "Último escaneo", ADVERTENCIA,
                        f"El último escaneo rápido fue hace {escaneo} días.",
                        "Ejecuta este programa con --escanear.")

        amenazas = powershell(
            "Get-MpThreatDetection | Sort-Object InitialDetectionTime -Descending "
            "| Select-Object -First 20 ThreatID, InitialDetectionTime, ActionSuccess, "
            "@{n='Archivo';e={$_.Resources -join ', '}}"
        )
        nombres = {}
        if amenazas:
            catalogo = powershell("Get-MpThreat | Select-Object ThreatID, ThreatName, IsActive") or []
            nombres = {t.get("ThreatID"): t for t in catalogo}
        if amenazas:
            activas = [a for a in amenazas if nombres.get(a.get("ThreatID"), {}).get("IsActive")]
            lista = ", ".join(sorted({nombres.get(a.get("ThreatID"), {}).get("ThreatName", "?") for a in amenazas}))
            estado = PROBLEMA if activas else ADVERTENCIA
            rep.agregar("Antivirus", "Amenazas detectadas", estado,
                        f"{len(amenazas)} detección(es) en el historial: {lista}",
                        "Revisa 'Seguridad de Windows > Protección contra virus > Historial de protección'."
                        if not activas else "Hay amenazas activas: ejecuta un examen completo de inmediato.")
        elif amenazas is not None:
            rep.agregar("Antivirus", "Amenazas detectadas", OK, "Sin amenazas en el historial de Defender.")

        if escanear:
            print("  Ejecutando escaneo rápido de Defender (puede tardar varios minutos)...")
            resultado = powershell("Start-MpScan -ScanType QuickScan; 'listo'", timeout=3600)
            if resultado is None:
                rep.agregar("Antivirus", "Escaneo rápido", ADVERTENCIA, "No se pudo completar el escaneo.",
                            "Ejecuta el programa como administrador.")
            else:
                rep.agregar("Antivirus", "Escaneo rápido", OK,
                            "Escaneo terminado. Vuelve a ejecutar el diagnóstico para ver nuevas detecciones.")

    firewall = powershell("Get-NetFirewallProfile | Select-Object Name, Enabled")
    if firewall:
        apagados = [f.get("Name") for f in firewall if not f.get("Enabled")]
        if apagados:
            rep.agregar("Antivirus", "Firewall", ADVERTENCIA,
                        f"Desactivado en perfil(es): {', '.join(apagados)}.",
                        "Activa el firewall en 'Seguridad de Windows > Firewall'.")
        else:
            rep.agregar("Antivirus", "Firewall", OK, "Activo en todos los perfiles.")


def revisar_antivirus_unix(rep: Reporte):
    titulo("Antivirus y protección")
    candidatos = {
        "clamscan": "ClamAV", "clamd": "ClamAV (demonio)", "sophos": "Sophos",
        "savscan": "Sophos", "esets": "ESET", "mdatp": "Microsoft Defender for Endpoint",
        "rkhunter": "rkhunter", "chkrootkit": "chkrootkit",
    }
    encontrados = sorted({nombre for binario, nombre in candidatos.items() if shutil.which(binario)})
    if sys.platform == "darwin" and Path("/Library/Apple/System/Library/CoreServices/XProtect.bundle").exists():
        encontrados.append("XProtect (integrado en macOS)")
    if encontrados:
        rep.agregar("Antivirus", "Antivirus instalado", OK, ", ".join(encontrados))
    else:
        rep.agregar("Antivirus", "Antivirus instalado", ADVERTENCIA, "No se detectó ningún antivirus conocido.",
                    "En Linux puedes instalar ClamAV (sudo apt install clamav).")


# --------------------------------------------------------------------------
# Discos
# --------------------------------------------------------------------------

def revisar_espacio(rep: Reporte, rutas):
    for ruta in rutas:
        try:
            uso = shutil.disk_usage(ruta)
        except OSError:
            continue
        if uso.total == 0:
            continue
        libre_pct = uso.free / uso.total * 100
        detalle = f"{formato_bytes(uso.free)} libres de {formato_bytes(uso.total)} ({libre_pct:.0f}%)"
        if libre_pct < 5:
            rep.agregar("Disco", f"Espacio en {ruta}", PROBLEMA, detalle,
                        "Libera espacio: el sistema puede volverse inestable.")
        elif libre_pct < 15:
            rep.agregar("Disco", f"Espacio en {ruta}", ADVERTENCIA, detalle, "Considera liberar espacio.")
        else:
            rep.agregar("Disco", f"Espacio en {ruta}", OK, detalle)


def unidades_windows():
    if hasattr(os, "listdrives"):
        return os.listdrives()
    return [f"{letra}:\\" for letra in "ABCDEFGHIJKLMNOPQRSTUVWXYZ" if os.path.exists(f"{letra}:\\")]


def revisar_discos_windows(rep: Reporte):
    titulo("Discos")
    discos = powershell(
        "Get-PhysicalDisk | Select-Object FriendlyName, MediaType, HealthStatus, OperationalStatus, Size"
    )
    if discos:
        for d in discos:
            nombre = d.get("FriendlyName") or "Disco"
            salud = str(d.get("HealthStatus", ""))
            operativo = d.get("OperationalStatus")
            operativo = ", ".join(map(str, operativo)) if isinstance(operativo, list) else str(operativo)
            tam = formato_bytes(d["Size"]) if isinstance(d.get("Size"), (int, float)) else ""
            detalle = f"Salud: {salud}, estado: {operativo} {tam}".strip()
            if salud in ("Healthy", "0"):
                rep.agregar("Disco", nombre, OK, detalle)
            elif salud in ("Warning", "1"):
                rep.agregar("Disco", nombre, ADVERTENCIA, detalle, "Respalda tus archivos: el disco muestra signos de desgaste.")
            else:
                rep.agregar("Disco", nombre, PROBLEMA, detalle, "Respalda tus archivos YA y considera reemplazar el disco.")
    else:
        wmic = powershell("Get-CimInstance Win32_DiskDrive | Select-Object Model, Status")
        for d in wmic or []:
            estado = OK if d.get("Status") == "OK" else PROBLEMA
            rep.agregar("Disco", d.get("Model") or "Disco", estado, f"Estado SMART: {d.get('Status')}")

    fallas = powershell(
        "Get-CimInstance -Namespace root/wmi -ClassName MSStorageDriver_FailurePredictStatus "
        "| Select-Object InstanceName, PredictFailure"
    )
    for f in fallas or []:
        if f.get("PredictFailure"):
            rep.agregar("Disco", "Predicción SMART", PROBLEMA,
                        f"El disco {f.get('InstanceName')} predice una falla inminente.",
                        "Respalda tus archivos inmediatamente.")

    volumenes = powershell(
        "Get-Volume | Where-Object DriveLetter | Select-Object DriveLetter, FileSystem, HealthStatus"
    )
    for v in volumenes or []:
        salud = str(v.get("HealthStatus", ""))
        if salud not in ("Healthy", "0", ""):
            rep.agregar("Disco", f"Volumen {v.get('DriveLetter')}:", ADVERTENCIA,
                        f"Sistema de archivos con estado '{salud}'.",
                        f"Ejecuta como administrador: chkdsk {v.get('DriveLetter')}: /scan")

    revisar_espacio(rep, unidades_windows())


def revisar_discos_unix(rep: Reporte):
    titulo("Discos")
    rutas = ["/"]
    if Path("/home").exists() and os.stat("/home").st_dev != os.stat("/").st_dev:
        rutas.append("/home")
    revisar_espacio(rep, rutas)

    if not shutil.which("smartctl"):
        rep.agregar("Disco", "SMART", INFO, "smartctl no está instalado; no se revisó la salud física.",
                    "Instala smartmontools para revisar la salud del disco.")
        return
    _, salida = ejecutar(["smartctl", "--scan"])
    dispositivos = [linea.split()[0] for linea in salida.splitlines() if linea.startswith("/dev/")]
    for dev in dispositivos:
        codigo, salida = ejecutar(["smartctl", "-H", dev])
        if codigo is None:
            continue
        texto = salida.upper()
        if "PASSED" in texto or "OK" in texto.split("HEALTH STATUS:")[-1][:10]:
            rep.agregar("Disco", f"SMART {dev}", OK, "La autoevaluación SMART pasó.")
        elif "FAILED" in texto:
            rep.agregar("Disco", f"SMART {dev}", PROBLEMA, "La autoevaluación SMART falló.",
                        "Respalda tus archivos inmediatamente.")
        else:
            rep.agregar("Disco", f"SMART {dev}", INFO, "No se pudo leer SMART (prueba con sudo).")


# --------------------------------------------------------------------------
# Sistema y hardware
# --------------------------------------------------------------------------

def evaluar_memoria(rep: Reporte, total, libre):
    usada_pct = (total - libre) / total * 100
    detalle = f"{usada_pct:.0f}% en uso ({formato_bytes(total - libre)} de {formato_bytes(total)})"
    if usada_pct > 90:
        rep.agregar("Sistema", "Memoria RAM", ADVERTENCIA, detalle, "Cierra programas o revisa procesos que consuman mucha memoria.")
    else:
        rep.agregar("Sistema", "Memoria RAM", OK, detalle)


def evaluar_encendido(rep: Reporte, dias):
    if dias > 14:
        rep.agregar("Sistema", "Tiempo encendido", ADVERTENCIA, f"{dias:.0f} días sin reiniciar.",
                    "Reinicia el equipo para aplicar actualizaciones y liberar recursos.")
    else:
        rep.agregar("Sistema", "Tiempo encendido", OK, f"{dias:.1f} días desde el último reinicio.")


def revisar_sistema_windows(rep: Reporte, profundo: bool):
    titulo("Sistema")
    so = powershell(
        "Get-CimInstance Win32_OperatingSystem | Select-Object Caption, Version, "
        "TotalVisibleMemorySize, FreePhysicalMemory, "
        "@{n='DiasEncendido';e={((Get-Date) - $_.LastBootUpTime).TotalDays}}"
    )
    if so:
        s = so[0]
        rep.agregar("Sistema", "Sistema operativo", INFO, f"{s.get('Caption')} ({s.get('Version')})")
        if s.get("TotalVisibleMemorySize"):
            evaluar_memoria(rep, s["TotalVisibleMemorySize"] * 1024, s.get("FreePhysicalMemory", 0) * 1024)
        if isinstance(s.get("DiasEncendido"), (int, float)):
            evaluar_encendido(rep, s["DiasEncendido"])

    pendiente = powershell(
        "(Test-Path 'HKLM:\\SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Component Based Servicing\\RebootPending') -or "
        "(Test-Path 'HKLM:\\SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\WindowsUpdate\\Auto Update\\RebootRequired')"
    )
    if pendiente and pendiente[0] is True:
        rep.agregar("Sistema", "Reinicio pendiente", ADVERTENCIA, "Hay actualizaciones esperando un reinicio.",
                    "Reinicia el equipo.")

    actualizacion = powershell(
        "Get-HotFix | Where-Object InstalledOn | Sort-Object InstalledOn -Descending | Select-Object -First 1 "
        "@{n='Dias';e={((Get-Date) - $_.InstalledOn).TotalDays}}, HotFixID"
    )
    if actualizacion and isinstance(actualizacion[0].get("Dias"), (int, float)):
        dias = actualizacion[0]["Dias"]
        if dias > 60:
            rep.agregar("Sistema", "Windows Update", ADVERTENCIA, f"La última actualización fue hace {dias:.0f} días.",
                        "Abre Configuración > Windows Update y busca actualizaciones.")
        else:
            rep.agregar("Sistema", "Windows Update", OK, f"Última actualización hace {dias:.0f} días ({actualizacion[0].get('HotFixID')}).")

    bateria = powershell(
        "Get-CimInstance -Namespace root/wmi -ClassName BatteryFullChargedCapacity | Select-Object FullChargedCapacity; "
        "Get-CimInstance -Namespace root/wmi -ClassName BatteryStaticData | Select-Object DesignedCapacity"
    )
    if bateria and len(bateria) >= 2:
        llena = bateria[0].get("FullChargedCapacity")
        diseno = bateria[1].get("DesignedCapacity")
        if llena and diseno:
            salud = llena / diseno * 100
            estado = OK if salud >= 60 else ADVERTENCIA
            rep.agregar("Sistema", "Batería", estado, f"Capacidad al {salud:.0f}% de la original.",
                        "" if estado == OK else "La batería está desgastada; considera reemplazarla.")

    titulo("Errores registrados (últimos 7 días)")
    eventos = powershell(
        "Get-WinEvent -FilterHashtable @{LogName='System'; Level=1,2; StartTime=(Get-Date).AddDays(-7)} -MaxEvents 2000 "
        "| Group-Object ProviderName, Id | Select-Object Count, "
        "@{n='Proveedor';e={$_.Group[0].ProviderName}}, @{n='Id';e={$_.Group[0].Id}}",
        timeout=180,
    )
    if eventos is None:
        rep.agregar("Eventos", "Registro del sistema", ADVERTENCIA, "No se pudo leer el visor de eventos.")
    else:
        revisar_eventos(rep, eventos)

    if profundo:
        titulo("Revisión profunda")
        if not es_administrador():
            rep.agregar("Sistema", "Imagen de Windows", ADVERTENCIA, "Se omitió: requiere ejecutar como administrador.",
                        "Clic derecho sobre el programa > Ejecutar como administrador.")
        else:
            print("  Revisando la imagen de Windows (puede tardar unos minutos)...")
            imagen = powershell("Repair-WindowsImage -Online -ScanHealth | Select-Object ImageHealthState", timeout=1800)
            estado_img = str(imagen[0].get("ImageHealthState")) if imagen else ""
            if estado_img in ("Healthy", "0"):
                rep.agregar("Sistema", "Imagen de Windows", OK, "Sin daños en los archivos del sistema.")
            elif estado_img in ("Repairable", "1"):
                rep.agregar("Sistema", "Imagen de Windows", PROBLEMA, "Archivos del sistema dañados (reparable).",
                            "Ejecuta como administrador: DISM /Online /Cleanup-Image /RestoreHealth y luego sfc /scannow")
            elif estado_img in ("NonRepairable", "2"):
                rep.agregar("Sistema", "Imagen de Windows", PROBLEMA, "Archivos del sistema dañados (no reparable).",
                            "Considera restaurar o reinstalar Windows tras respaldar tus archivos.")
            else:
                rep.agregar("Sistema", "Imagen de Windows", ADVERTENCIA, "No se pudo determinar el estado.")


EVENTOS_CONOCIDOS = {
    ("Microsoft-Windows-Kernel-Power", 41): (PROBLEMA, "Apagados inesperados (cortes de energía o cuelgues)"),
    ("Microsoft-Windows-WER-SystemErrorReporting", 1001): (PROBLEMA, "Pantallazos azules (BSOD)"),
    ("BugCheck", 1001): (PROBLEMA, "Pantallazos azules (BSOD)"),
    ("Microsoft-Windows-WHEA-Logger", None): (PROBLEMA, "Errores de hardware (CPU, RAM o placa)"),
    ("disk", None): (PROBLEMA, "Errores de lectura/escritura del disco"),
    ("Ntfs", None): (ADVERTENCIA, "Errores del sistema de archivos NTFS"),
    ("volmgr", None): (ADVERTENCIA, "Errores del administrador de volúmenes"),
    ("storahci", None): (ADVERTENCIA, "Errores del controlador de almacenamiento"),
    ("stornvme", None): (ADVERTENCIA, "Errores del controlador NVMe"),
}


def revisar_eventos(rep: Reporte, eventos):
    otros = 0
    encontrados = {}
    for ev in eventos:
        proveedor, ident, cuenta = ev.get("Proveedor"), ev.get("Id"), ev.get("Count", 0)
        clave = (proveedor, ident) if (proveedor, ident) in EVENTOS_CONOCIDOS else (proveedor, None)
        if clave in EVENTOS_CONOCIDOS:
            encontrados[clave] = encontrados.get(clave, 0) + cuenta
        else:
            otros += cuenta
    for clave, cuenta in encontrados.items():
        estado, descripcion = EVENTOS_CONOCIDOS[clave]
        rep.agregar("Eventos", descripcion, estado, f"{cuenta} evento(s) registrados.",
                    "Si se repite, respalda tus datos y revisa el hardware.")
    if not encontrados:
        rep.agregar("Eventos", "Fallas críticas de hardware", OK, "Sin apagados inesperados, BSOD ni errores de disco.")
    if otros > 50:
        rep.agregar("Eventos", "Otros errores del sistema", ADVERTENCIA, f"{otros} errores generales registrados.",
                    "Revisa el Visor de eventos > Registros de Windows > Sistema.")
    else:
        rep.agregar("Eventos", "Otros errores del sistema", INFO, f"{otros} errores generales (cantidad normal).")


def revisar_sistema_unix(rep: Reporte):
    titulo("Sistema")
    rep.agregar("Sistema", "Sistema operativo", INFO, f"{platform.system()} {platform.release()}")
    meminfo = Path("/proc/meminfo")
    if meminfo.exists():
        valores = {}
        for linea in meminfo.read_text().splitlines():
            clave, _, resto = linea.partition(":")
            valores[clave] = int(resto.split()[0]) * 1024
        if "MemTotal" in valores:
            evaluar_memoria(rep, valores["MemTotal"], valores.get("MemAvailable", valores.get("MemFree", 0)))
    uptime = Path("/proc/uptime")
    if uptime.exists():
        evaluar_encendido(rep, float(uptime.read_text().split()[0]) / 86400)
    if hasattr(os, "getloadavg"):
        carga = os.getloadavg()[1]
        nucleos = os.cpu_count() or 1
        estado = ADVERTENCIA if carga > nucleos * 1.5 else OK
        rep.agregar("Sistema", "Carga de CPU", estado, f"Promedio 5 min: {carga:.2f} ({nucleos} núcleos)")


# --------------------------------------------------------------------------
# Reporte
# --------------------------------------------------------------------------

def veredicto(rep: Reporte):
    problemas, advertencias = rep.contar(PROBLEMA), rep.contar(ADVERTENCIA)
    if problemas:
        return PROBLEMA, f"Se encontraron {problemas} problema(s) que requieren atención."
    if advertencias:
        return ADVERTENCIA, f"El equipo funciona, pero hay {advertencias} advertencia(s)."
    return OK, "El equipo está en buen estado."


def generar_html(rep: Reporte, destino: Path):
    colores = {OK: "#16a34a", ADVERTENCIA: "#d97706", PROBLEMA: "#dc2626", INFO: "#0284c7"}
    estado, mensaje = veredicto(rep)
    filas = []
    categoria_actual = None
    for r in rep.resultados:
        if r.categoria != categoria_actual:
            categoria_actual = r.categoria
            filas.append(f'<tr class="cat"><td colspan="3">{html.escape(r.categoria)}</td></tr>')
        reco = f'<div class="reco">{html.escape(r.recomendacion)}</div>' if r.recomendacion else ""
        filas.append(
            f'<tr><td><span class="badge" style="background:{colores[r.estado]}">{r.estado}</span></td>'
            f"<td>{html.escape(r.nombre)}</td><td>{html.escape(r.detalle)}{reco}</td></tr>"
        )
    contenido = f"""<!DOCTYPE html>
<html lang="es"><head><meta charset="utf-8"><title>Diagnóstico de PC</title>
<style>
body{{font-family:Segoe UI,Arial,sans-serif;background:#f1f5f9;color:#0f172a;margin:0;padding:32px}}
.card{{max-width:960px;margin:auto;background:#fff;border-radius:12px;box-shadow:0 4px 20px #0001;padding:28px}}
h1{{margin:0 0 4px}} .meta{{color:#64748b;font-size:14px}}
.veredicto{{margin:20px 0;padding:16px;border-radius:8px;color:#fff;font-size:18px;background:{colores[estado]}}}
table{{width:100%;border-collapse:collapse}} td{{padding:10px;border-bottom:1px solid #e2e8f0;vertical-align:top}}
tr.cat td{{background:#f8fafc;font-weight:600;padding-top:18px}}
.badge{{color:#fff;border-radius:4px;padding:2px 8px;font-size:12px;font-weight:600}}
.reco{{color:#475569;font-size:13px;margin-top:4px}} .reco:before{{content:"→ "}}
</style></head><body><div class="card">
<h1>Diagnóstico de PC</h1>
<div class="meta">Equipo: {html.escape(platform.node())} · {datetime.now():%d/%m/%Y %H:%M} · v{VERSION}</div>
<div class="veredicto">{html.escape(mensaje)}</div>
<table>{''.join(filas)}</table>
</div></body></html>"""
    destino.write_text(contenido, encoding="utf-8")


def carpeta_reportes():
    base = Path(sys.executable).parent if getattr(sys, "frozen", False) else Path(__file__).parent
    try:
        prueba = base / ".escritura"
        prueba.touch()
        prueba.unlink()
        return base
    except OSError:
        return Path.home()


def main():
    parser = argparse.ArgumentParser(description="Detecta antivirus y revisa la salud del PC.")
    parser.add_argument("--profundo", action="store_true", help="revisa archivos del sistema (requiere administrador)")
    parser.add_argument("--escanear", action="store_true", help="ejecuta un escaneo rápido de Microsoft Defender")
    parser.add_argument("--sin-abrir", action="store_true", help="no abre el reporte HTML al terminar")
    args = parser.parse_args()

    if ES_WINDOWS:
        os.system("")  # habilita colores ANSI en la consola
        for flujo in (sys.stdout, sys.stderr):
            if hasattr(flujo, "reconfigure"):
                flujo.reconfigure(encoding="utf-8", errors="replace")

    print(f"\033[1mDiagnóstico de PC v{VERSION}\033[0m  -  {platform.node()}")
    print("Administrador: " + ("sí" if es_administrador() else "no (algunas pruebas pueden omitirse)"))

    rep = Reporte()
    if ES_WINDOWS:
        revisar_antivirus_windows(rep, args.escanear)
        revisar_discos_windows(rep)
        revisar_sistema_windows(rep, args.profundo)
    else:
        revisar_antivirus_unix(rep)
        revisar_discos_unix(rep)
        revisar_sistema_unix(rep)

    estado, mensaje = veredicto(rep)
    print(f"\n{COLORES[estado]}\033[1mRESULTADO: {mensaje}{RESET}")

    destino = carpeta_reportes() / f"reporte-diagnostico-{datetime.now():%Y%m%d-%H%M%S}.html"
    generar_html(rep, destino)
    print(f"Reporte guardado en: {destino}")
    if not args.sin_abrir:
        webbrowser.open(destino.as_uri())

    if getattr(sys, "frozen", False) and ES_WINDOWS:
        input("\nPresiona Enter para salir...")
    return 2 if estado == PROBLEMA else (1 if estado == ADVERTENCIA else 0)


if __name__ == "__main__":
    sys.exit(main())
