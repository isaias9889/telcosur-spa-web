<?php
/**
 * Fotos y contenido cultural del equipo TelcoSur.
 */
if (defined('TELCOSUR_EQUIPO_DATA_LOADED')) {
    return;
}
define('TELCOSUR_EQUIPO_DATA_LOADED', true);

$equipoGaleria = [
    [
        'src' => 'assets/equipo/equipo-hero.jpg',
        'alt' => 'Equipo TelcoSur reunido en oficina comercial',
        'caption' => 'Nuestro equipo',
        'position' => 'center 42%',
        'solo_hero' => true,
    ],
    [
        'slug' => 'compromiso-regional',
        'src' => 'assets/equipo/equipo-escalera.jpg',
        'alt' => 'Colaboradores TelcoSur en escalera de oficina',
        'caption' => 'Compromiso regional',
        'position' => 'center 30%',
        'title' => 'Compromiso regional',
        'lead' => 'Trabajamos con presencia local en el sur de Chile, cercanos a las comunidades y equipos que hacen posible nuestra operación.',
        'intro' => 'En TelcoSur entendemos que la conectividad no se construye solo con infraestructura: se construye con personas que conocen el territorio, sus dinámicas y sus necesidades.',
        'paragraphs' => [
            'Nuestra operación se extiende desde Santiago hasta Puerto Montt, con plazas comerciales que permiten coordinar talento, atención y seguimiento en cada ciudad.',
            'Ese compromiso regional se traduce en equipos que representan a TelcoSur con responsabilidad, cercanía y respeto por el entorno donde trabajan.',
            'Creemos en una empresa que crece junto a las comunidades del sur, aportando empleo, formación y un vínculo estable con clientes y colaboradores.',
        ],
        'highlights' => [
            '8 plazas comerciales en el sur de Chile',
            'Coordinación territorial desde oficinas locales',
            'Atención cercana a hogares y equipos comerciales',
            'Operación ordenada con visión de largo plazo',
        ],
    ],
    [
        'slug' => 'fuerza-comercial',
        'src' => 'assets/equipo/equipo-exterior.jpg',
        'alt' => 'Equipo TelcoSur en actividad exterior',
        'caption' => 'Fuerza comercial',
        'position' => 'center 38%',
        'title' => 'Fuerza comercial',
        'lead' => 'Equipos en terreno con formación, acompañamiento y cultura profesional para representar marcas líderes en el sur de Chile.',
        'intro' => 'La fuerza comercial de TelcoSur es el motor que conecta hogares con servicios Claro y VTR, siempre con procesos claros y respaldo institucional.',
        'paragraphs' => [
            'Formamos ejecutivos y supervisores con capacitación en productos, habilidades comerciales y orientación al cliente.',
            'El trabajo en terreno se complementa con seguimiento, coordinación desde las plazas y una cultura de equipo que prioriza el aprendizaje continuo.',
            'Nuestros colaboradores comerciales son la cara visible de TelcoSur en cada comuna: profesionales, preparados y comprometidos con su desarrollo.',
        ],
        'highlights' => [
            'Capacitación en productos Claro y VTR',
            'Acompañamiento en terreno y seguimiento de metas',
            'Oportunidades para perfiles comerciales y supervisores',
            'Cultura de equipo y proyección profesional',
        ],
    ],
    [
        'slug' => 'companerismo',
        'src' => 'assets/equipo/equipo-oficina.jpg',
        'alt' => 'Colaboradores TelcoSur en oficina',
        'caption' => 'Compañerismo',
        'position' => 'center 40%',
        'title' => 'Compañerismo',
        'lead' => 'Celebramos los logros, cuidamos el ambiente laboral y fortalecemos vínculos que hacen de TelcoSur un lugar donde las personas importan.',
        'intro' => 'El compañerismo es parte central de nuestra identidad: creemos que los mejores resultados surgen cuando el equipo se siente valorado, escuchado y parte de algo más grande.',
        'paragraphs' => [
            'Compartimos momentos de coordinación, reconocimiento y encuentro que refuerzan la confianza entre colaboradores de distintas plazas.',
            'Promovemos un ambiente de respeto, colaboración y apoyo mutuo, especialmente en el trabajo comercial que exige constancia y energía en terreno.',
            'TelcoSur no es solo una operación comercial: es una comunidad de personas que construyen día a día la empresa con compromiso y buena disposición.',
        ],
        'highlights' => [
            'Cultura de equipo y reconocimiento interno',
            'Celebraciones y momentos de encuentro',
            'Ambiente laboral respetuoso y colaborativo',
            'Personas como eje de la operación regional',
        ],
    ],
];

$equipoHero = $equipoGaleria[0];

$equipoGaleriaVisible = array_values(array_filter(
    $equipoGaleria,
    static fn (array $foto): bool => empty($foto['solo_hero'])
));

function equipoPhotoPath(string $relativePath): string
{
    return preg_replace('/\?.*$/', '', $relativePath);
}

function equipoPhotoVersion(string $relativePath): string
{
    $path = equipoPhotoPath($relativePath);
    $full = __DIR__ . '/../' . $path;

    return is_file($full) ? (string) filemtime($full) : '1';
}

function equipoPhotoUrl(string $relativePath): string
{
    $path = equipoPhotoPath($relativePath);

    return $path . '?v=' . equipoPhotoVersion($path);
}

/**
 * @return array<string, array<string, mixed>>
 */
function equipoTemasPorSlug(): array
{
    global $equipoGaleriaVisible;

    $temas = [];
    foreach ($equipoGaleriaVisible as $foto) {
        if (!empty($foto['slug'])) {
            $temas[$foto['slug']] = $foto;
        }
    }

    return $temas;
}

/**
 * @return array<string, mixed>|null
 */
function equipoTemaPorSlug(string $slug): ?array
{
    $temas = equipoTemasPorSlug();

    return $temas[$slug] ?? null;
}
