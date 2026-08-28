<?php
/**
 * Datos estructurados Organization, WebSite y oficinas.
 */
require_once __DIR__ . '/offices-data.php';

$siteBaseUrl = $siteBaseUrl ?? 'https://telcosurspa.cl/';
$base = rtrim($siteBaseUrl, '/');

$graph = [
    [
        '@type' => 'Organization',
        '@id' => $base . '/#organization',
        'name' => 'TelcoSur SPA',
        'url' => $base . '/',
        'logo' => $base . '/assets/logo.png',
        'email' => 'contacto@telcosurspa.cl',
        'description' => 'Empresa regional de telecomunicaciones y distribución autorizada Claro y VTR en el sur de Chile.',
        'areaServed' => 'Sur de Chile',
        'slogan' => 'Cerca de ti, cerca de todos.',
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'contactType' => 'customer service',
            'email' => 'contacto@telcosurspa.cl',
            'areaServed' => 'CL',
            'availableLanguage' => ['es'],
        ],
    ],
    [
        '@type' => 'WebSite',
        '@id' => $base . '/#website',
        'url' => $base . '/',
        'name' => 'TelcoSur SPA',
        'publisher' => ['@id' => $base . '/#organization'],
        'inLanguage' => 'es-CL',
    ],
];

foreach ($oficinasTelcosur as $oficina) {
    $graph[] = [
        '@type' => 'LocalBusiness',
        'name' => 'TelcoSur SPA — ' . $oficina['city'],
        'parentOrganization' => ['@id' => $base . '/#organization'],
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $oficina['address'],
            'addressLocality' => $oficina['city'],
            'addressRegion' => $oficina['region'],
            'addressCountry' => 'CL',
        ],
        'areaServed' => $oficina['city'],
    ];
}

$jsonLd = ['@context' => 'https://schema.org', '@graph' => $graph];
?>
<script type="application/ld+json"><?php echo json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?></script>
