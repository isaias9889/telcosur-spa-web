<?php
$pageTitle = $pageTitle ?? 'TelcoSur SPA';
$pageDescription = $pageDescription ?? '';
$activeNav = $activeNav ?? '';
$whatsappMessage = $whatsappMessage ?? 'Hola TelcoSur SPA, quisiera hacer una consulta.';
$mobilePrimaryHref = $mobilePrimaryHref ?? 'planes.php#consulta-plan';
$mobilePrimaryLabel = $mobilePrimaryLabel ?? 'Consultar plan';
$mobileWhatsappMessage = $mobileWhatsappMessage ?? 'Hola TelcoSur SPA, quisiera hacer una consulta rápida.';
$floatingWhatsappMessage = $floatingWhatsappMessage ?? $whatsappMessage;
$extraStylesheets = $extraStylesheets ?? [];
$extraHead = $extraHead ?? '';
$homeUrl = 'index.php#inicio';

$navItems = [
    'inicio' => ['label' => 'Inicio', 'href' => $homeUrl],
    'servicios' => ['label' => 'Servicios', 'href' => 'servicios.php'],
    'planes' => ['label' => 'Planes', 'href' => 'planes.php'],
    'trabaja' => ['label' => 'Trabaja con nosotros', 'href' => 'trabaja-con-nosotros.php'],
    'cobertura' => ['label' => 'Cobertura', 'href' => 'cobertura.php'],
    'sobre' => ['label' => 'Sobre nosotros', 'href' => 'sobre-nosotros.php'],
    'contacto' => ['label' => 'Contacto', 'href' => 'contacto.php'],
];
