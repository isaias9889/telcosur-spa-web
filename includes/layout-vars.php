<?php

$pageTitle = $pageTitle ?? 'TelcoSur';

$pageDescription = $pageDescription ?? '';

$activeNav = $activeNav ?? '';

$whatsappMessage = $whatsappMessage ?? 'Hola TelcoSur, quisiera más información sobre la empresa.';

$mobilePrimaryHref = $mobilePrimaryHref ?? 'sobre-nosotros.php';

$mobilePrimaryLabel = $mobilePrimaryLabel ?? 'Conocer TelcoSur';

$mobileWhatsappMessage = $mobileWhatsappMessage ?? 'Hola TelcoSur, quisiera más información.';

$floatingWhatsappMessage = $floatingWhatsappMessage ?? $whatsappMessage;

$extraStylesheets = $extraStylesheets ?? ['css/corporate.css'];

$extraHead = $extraHead ?? '';

$hidePartnerStrip = $hidePartnerStrip ?? false;

$bodyClass = $bodyClass ?? 'corp-site';

$headerClass = $headerClass ?? 'header';

$logoHeight = $logoHeight ?? 88;

$canonicalUrl = $canonicalUrl ?? '';

$siteBaseUrl = $siteBaseUrl ?? 'https://telcosurspa.cl/';

$themeColor = $themeColor ?? '#0d1b2a';

$gaMeasurementId = $gaMeasurementId ?? '';

$homeUrl = 'index.php#inicio';



$navItems = [

    'inicio' => ['label' => 'Inicio', 'href' => $homeUrl],

    'sobre' => ['label' => 'Nosotros', 'href' => 'sobre-nosotros.php'],

    'servicios' => ['label' => 'Servicios', 'href' => 'servicios.php'],

    'cobertura' => ['label' => 'Cobertura', 'href' => 'cobertura.php'],

    'trabaja' => ['label' => 'Talento', 'href' => 'trabaja-con-nosotros.php'],

    'contacto' => ['label' => 'Contacto', 'href' => 'contacto.php'],

];

