"""Genera presentación PPT del sitio web TelcoSur para jefatura."""
from __future__ import annotations

from datetime import date
from pathlib import Path

from pptx import Presentation
from pptx.dml.color import RGBColor
from pptx.enum.shapes import MSO_SHAPE
from pptx.enum.text import MSO_ANCHOR, PP_ALIGN
from pptx.util import Inches, Pt

ROOT = Path(__file__).resolve().parent.parent
OUT = ROOT / "docs" / "presentacion" / "TelcoSur-Sitio-Web-Presentacion.pptx"
SHOTS = ROOT / "docs" / "presentacion" / "screenshots"
LOGO = ROOT / "assets" / "logo.png"

# Colores corporativos TelcoSur
BRAND = RGBColor(196, 30, 58)
INK = RGBColor(10, 22, 40)
HEADING = RGBColor(13, 34, 71)
MUTED = RGBColor(90, 107, 130)
WHITE = RGBColor(255, 255, 255)
LIGHT = RGBColor(248, 249, 251)
ACCENT_BG = RGBColor(13, 27, 42)


def set_run(run, size=18, bold=False, color=INK, font="Calibri"):
    run.font.name = font
    run.font.size = Pt(size)
    run.font.bold = bold
    run.font.color.rgb = color


def add_bg(slide, prs, color=LIGHT):
    fill = slide.background.fill
    fill.solid()
    fill.fore_color.rgb = color


def add_bar(slide, prs, top=Inches(0), height=Inches(0.12)):
    bar = slide.shapes.add_shape(
        MSO_SHAPE.RECTANGLE, Inches(0), top, prs.slide_width, height
    )
    bar.fill.solid()
    bar.fill.fore_color.rgb = BRAND
    bar.line.fill.background()
    return bar


def add_footer(slide, prs, text="TelcoSur SPA · telcosurspa.cl"):
    box = slide.shapes.add_textbox(
        Inches(0.5), prs.slide_height - Inches(0.45), prs.slide_width - Inches(1), Inches(0.3)
    )
    tf = box.text_frame
    tf.vertical_anchor = MSO_ANCHOR.MIDDLE
    p = tf.paragraphs[0]
    p.alignment = PP_ALIGN.RIGHT
    r = p.add_run()
    r.text = text
    set_run(r, size=10, color=MUTED)


def add_title_slide(prs):
    slide = prs.slides.add_slide(prs.slide_layouts[6])
    add_bg(slide, prs, ACCENT_BG)
    add_bar(slide, prs, top=prs.slide_height - Inches(0.18), height=Inches(0.18))

    if LOGO.exists():
        slide.shapes.add_picture(str(LOGO), Inches(0.8), Inches(1.0), height=Inches(1.1))

    tb = slide.shapes.add_textbox(Inches(0.8), Inches(2.35), Inches(11), Inches(2.2))
    tf = tb.text_frame
    tf.word_wrap = True
    p = tf.paragraphs[0]
    r = p.add_run()
    r.text = "Sitio web corporativo TelcoSur"
    set_run(r, size=40, bold=True, color=WHITE)

    p2 = tf.add_paragraph()
    r2 = p2.add_run()
    r2.text = "Renovación digital · Presencia institucional · Sur de Chile"
    set_run(r2, size=20, color=RGBColor(200, 210, 225))

    p3 = tf.add_paragraph()
    r3 = p3.add_run()
    r3.text = f"Presentación ejecutiva · {date.today():%d/%m/%Y}"
    set_run(r3, size=14, color=RGBColor(160, 175, 195))

    tag = slide.shapes.add_shape(
        MSO_SHAPE.ROUNDED_RECTANGLE, Inches(0.8), Inches(4.85), Inches(4.2), Inches(0.55)
    )
    tag.fill.solid()
    tag.fill.fore_color.rgb = BRAND
    tag.line.fill.background()
    ttf = tag.text_frame
    ttf.vertical_anchor = MSO_ANCHOR.MIDDLE
    tp = ttf.paragraphs[0]
    tp.alignment = PP_ALIGN.CENTER
    tr = tp.add_run()
    tr.text = "Distribuidor autorizado Claro y VTR"
    set_run(tr, size=13, bold=True, color=WHITE)


def add_bullet_slide(prs, title, bullets, subtitle=None):
    slide = prs.slides.add_slide(prs.slide_layouts[6])
    add_bg(slide, prs)
    add_bar(slide, prs)
    add_footer(slide, prs)

    tb = slide.shapes.add_textbox(Inches(0.7), Inches(0.45), Inches(12), Inches(0.9))
    tf = tb.text_frame
    p = tf.paragraphs[0]
    r = p.add_run()
    r.text = title
    set_run(r, size=30, bold=True, color=HEADING)

    y = 1.35
    if subtitle:
        sb = slide.shapes.add_textbox(Inches(0.7), Inches(1.25), Inches(12), Inches(0.5))
        sp = sb.text_frame.paragraphs[0]
        sr = sp.add_run()
        sr.text = subtitle
        set_run(sr, size=14, color=MUTED)
        y = 1.75

    body = slide.shapes.add_textbox(Inches(0.9), Inches(y), Inches(11.5), Inches(5))
    btf = body.text_frame
    btf.word_wrap = True
    for i, item in enumerate(bullets):
        para = btf.paragraphs[0] if i == 0 else btf.add_paragraph()
        para.level = 0
        para.space_after = Pt(10)
        br = para.add_run()
        br.text = f"• {item}"
        set_run(br, size=17, color=INK)


def add_image_slide(prs, title, image_name, bullets=None, subtitle=None):
    slide = prs.slides.add_slide(prs.slide_layouts[6])
    add_bg(slide, prs)
    add_bar(slide, prs)
    add_footer(slide, prs)

    tb = slide.shapes.add_textbox(Inches(0.7), Inches(0.42), Inches(12), Inches(0.7))
    tf = tb.text_frame
    p = tf.paragraphs[0]
    r = p.add_run()
    r.text = title
    set_run(r, size=26, bold=True, color=HEADING)

    if subtitle:
        sb = slide.shapes.add_textbox(Inches(0.7), Inches(0.95), Inches(12), Inches(0.4))
        sr = sb.text_frame.paragraphs[0].add_run()
        sr.text = subtitle
        set_run(sr, size=12, color=MUTED)

    img_path = SHOTS / image_name
    img_top = Inches(1.25 if subtitle else 1.05)
    if bullets:
        body = slide.shapes.add_textbox(Inches(0.7), img_top, Inches(4.6), Inches(5.5))
        btf = body.text_frame
        btf.word_wrap = True
        for i, item in enumerate(bullets):
            para = btf.paragraphs[0] if i == 0 else btf.add_paragraph()
            para.space_after = Pt(8)
            br = para.add_run()
            br.text = f"• {item}"
            set_run(br, size=14, color=INK)
        if img_path.exists():
            slide.shapes.add_picture(
                str(img_path), Inches(5.5), Inches(1.15), width=Inches(7.2)
            )
    elif img_path.exists():
        slide.shapes.add_picture(str(img_path), Inches(0.7), img_top, width=Inches(12))


def add_two_col_slide(prs, title, left_title, left_items, right_title, right_items):
    slide = prs.slides.add_slide(prs.slide_layouts[6])
    add_bg(slide, prs)
    add_bar(slide, prs)
    add_footer(slide, prs)

    tb = slide.shapes.add_textbox(Inches(0.7), Inches(0.45), Inches(12), Inches(0.7))
    r = tb.text_frame.paragraphs[0].add_run()
    r.text = title
    set_run(r, size=28, bold=True, color=HEADING)

    for col, (ctitle, citems, x) in enumerate(
        [(left_title, left_items, 0.7), (right_title, right_items, 6.8)]
    ):
        card = slide.shapes.add_shape(
            MSO_SHAPE.ROUNDED_RECTANGLE, Inches(x), Inches(1.2), Inches(5.8), Inches(5.6)
        )
        card.fill.solid()
        card.fill.fore_color.rgb = WHITE
        card.line.color.rgb = RGBColor(221, 230, 242)

        ht = slide.shapes.add_textbox(Inches(x + 0.25), Inches(1.4), Inches(5.3), Inches(0.5))
        hr = ht.text_frame.paragraphs[0].add_run()
        hr.text = ctitle
        set_run(hr, size=18, bold=True, color=BRAND)

        body = slide.shapes.add_textbox(Inches(x + 0.35), Inches(1.95), Inches(5.1), Inches(4.5))
        btf = body.text_frame
        btf.word_wrap = True
        for i, item in enumerate(citems):
            para = btf.paragraphs[0] if i == 0 else btf.add_paragraph()
            para.space_after = Pt(8)
            br = para.add_run()
            br.text = f"• {item}"
            set_run(br, size=14, color=INK)


def add_closing_slide(prs):
    slide = prs.slides.add_slide(prs.slide_layouts[6])
    add_bg(slide, prs, ACCENT_BG)
    add_bar(slide, prs, top=prs.slide_height - Inches(0.18), height=Inches(0.18))

    tb = slide.shapes.add_textbox(Inches(0.8), Inches(2.0), Inches(11.5), Inches(2.5))
    tf = tb.text_frame
    r = tf.paragraphs[0].add_run()
    r.text = "Gracias"
    set_run(r, size=44, bold=True, color=WHITE)

    p2 = tf.add_paragraph()
    r2 = p2.add_run()
    r2.text = "Sitio disponible para revisión en entorno local y preparado para publicación en telcosurspa.cl"
    set_run(r2, size=18, color=RGBColor(200, 210, 225))

    p3 = tf.add_paragraph()
    r3 = p3.add_run()
    r3.text = "Cerca de ti, cerca de todos."
    set_run(r3, size=16, bold=True, color=BRAND)


def main():
    OUT.parent.mkdir(parents=True, exist_ok=True)
    prs = Presentation()
    prs.slide_width = Inches(13.333)
    prs.slide_height = Inches(7.5)

    add_title_slide(prs)

    add_bullet_slide(
        prs,
        "Objetivo del proyecto",
        [
            "Fortalecer la presencia digital institucional de TelcoSur como empresa regional del sur de Chile.",
            "Comunicar de forma clara la operación comercial, las 8 plazas y el respaldo Claro · VTR.",
            "Ofrecer canales ordenados para clientes, colaboradores y aliados comerciales.",
            "Entregar una experiencia profesional en escritorio y dispositivos móviles.",
        ],
        subtitle="Renovación del sitio web corporativo",
    )

    add_bullet_slide(
        prs,
        "Resumen ejecutivo",
        [
            "Sitio web corporativo completo con 8 secciones principales y páginas internas especializadas.",
            "Identidad visual unificada: tipografía display, botones consistentes y paleta rojo corporativo.",
            "Mapa interactivo con 8 oficinas, zoom, enfoque por ciudad y datos de contacto.",
            "Formularios de contacto, cobertura y postulaciones con validación y protección CSRF.",
            "Optimización técnica: CSS/JS empaquetados, fuentes auto-hospedadas y CSS crítico inline.",
        ],
    )

    add_bullet_slide(
        prs,
        "Estructura del sitio",
        [
            "Inicio — Propuesta de valor, indicadores y mapa compacto de presencia regional.",
            "Nosotros — Historia, misión, visión, valores y galería del equipo.",
            "Servicios — Líneas de operación comercial, territorial e institucional.",
            "Cobertura — Mapa interactivo completo y formulario de revisión de disponibilidad.",
            "Talento — Oportunidades laborales y postulaciones.",
            "Contacto — Canales segmentados por tipo de consulta.",
            "Planes — Catálogo referencial de servicios hogar Claro y VTR.",
        ],
        subtitle="Navegación clara orientada a distintos públicos",
    )

    add_image_slide(
        prs,
        "Página de inicio renovada",
        "01-inicio.png",
        bullets=[
            "Hero con foto del equipo y mensaje institucional.",
            "Logos Claro y VTR integrados en el encabezado.",
            "Franja de indicadores: 8 plazas, 2 marcas, zona Sur.",
            "Llamados a la acción claros hacia Nosotros, Servicios y Contacto.",
            "Header transparente que refuerza imagen corporativa.",
        ],
        subtitle="Primera impresión profesional al ingresar al sitio",
    )

    add_image_slide(
        prs,
        "Mapa interactivo de cobertura",
        "02-cobertura.png",
        bullets=[
            "8 plazas comerciales desde Santiago hasta Puerto Montt.",
            "Marcadores numerados, ruta visual y panel de oficina seleccionada.",
            "Zoom con rueda, botones +/- y opción centrar mapa.",
            "Enlace directo a Google Maps y copia de dirección.",
            "Reutilizado en inicio (vista compacta) y cobertura (vista completa).",
        ],
        subtitle="Herramienta clave para demostrar presencia territorial",
    )

    add_image_slide(
        prs,
        "Páginas internas corporativas",
        "03-servicios.png",
        bullets=[
            "Hero institucional consistente en todas las secciones.",
            "Barra de distribuidor autorizado Claro · VTR.",
            "Tarjetas numeradas con ámbitos de operación.",
            "Migas de pan para orientación del usuario.",
        ],
        subtitle="Servicios · Operación regional con respaldo de marcas líderes",
    )

    add_image_slide(
        prs,
        "Nosotros y equipo TelcoSur",
        "04-nosotros.png",
        subtitle="Humaniza la marca y refuerza cultura de equipo en el sur de Chile",
    )

    add_image_slide(
        prs,
        "Contacto institucional",
        "05-contacto.png",
        subtitle="Canales segmentados: corporativo, cobertura, talento y oficinas regionales",
    )

    add_image_slide(
        prs,
        "Experiencia móvil optimizada",
        "06-mobile-inicio.png",
        bullets=[
            "Menú hamburguesa y barra de acción inferior.",
            "Botones amplios y legibles en pantallas pequeñas.",
            "Acceso directo a WhatsApp flotante.",
            "Tipografía y contraste adaptados para uso en terreno.",
        ],
        subtitle="Diseño responsive pensado para colaboradores y clientes en movimiento",
    )

    add_two_col_slide(
        prs,
        "Mejoras de diseño implementadas",
        "Identidad visual",
        [
            "Fuente display Plus Jakarta Sans para títulos.",
            "Botones unificados (primario, outline, ghost).",
            "Iconografía SVG inline (sin dependencias externas).",
            "Fotos del equipo con tratamiento uniforme.",
            "Eliminación de contenido repetitivo y testimonios genéricos.",
        ],
        "Experiencia de usuario",
        [
            "Animaciones suaves al scroll y al cargar secciones.",
            "Header con sombra al desplazarse en todas las páginas.",
            "Mapa interactivo con feedback visual inmediato.",
            "CTA claros en cada sección según objetivo.",
            "Accesibilidad: skip links, ARIA y contraste mejorado.",
        ],
    )

    add_two_col_slide(
        prs,
        "Base técnica y rendimiento",
        "Stack y arquitectura",
        [
            "PHP + Apache (XAMPP) con despliegue automatizado.",
            "CSS/JS minificados en bundles de producción.",
            "Fuentes Inter y Plus Jakarta auto-hospedadas.",
            "CSS crítico inline para carga above-the-fold.",
            "Imágenes AVIF/WebP cuando están disponibles.",
        ],
        "Seguridad y SEO",
        [
            "Tokens CSRF en formularios.",
            "Meta tags Open Graph y URLs canónicas.",
            "Sitemap.xml y robots.txt configurados.",
            "Políticas de privacidad y términos.",
            "Compresión Gzip vía .htaccess.",
        ],
    )

    add_bullet_slide(
        prs,
        "Indicadores clave del sitio",
        [
            "8 plazas comerciales representadas en mapa y contenido.",
            "2 marcas líderes: Claro y VTR como distribuidor autorizado.",
            "6+ páginas corporativas con contenido institucional estructurado.",
            "3 formularios operativos: contacto, cobertura y postulaciones.",
            "100% responsive: escritorio, tablet y móvil.",
        ],
        subtitle="Métricas de valor para la operación comercial",
    )

    add_bullet_slide(
        prs,
        "Próximos pasos recomendados",
        [
            "Publicar en dominio de producción telcosurspa.cl con certificado SSL.",
            "Configurar analítica (Google Analytics / Search Console) para medir tráfico.",
            "Validar formularios con envío real de correo en servidor productivo.",
            "Auditoría Lighthouse final y monitoreo periódico de rendimiento.",
            "Plan de actualización de contenidos (novedades, vacantes, fotos de equipo).",
        ],
        subtitle="Para consolidar el proyecto y medir resultados",
    )

    add_closing_slide(prs)

    prs.save(str(OUT))
    print(f"Presentación generada: {OUT}")


if __name__ == "__main__":
    main()
