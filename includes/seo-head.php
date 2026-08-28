<?php
/**
 * Meta tags SEO, Open Graph y Twitter Cards.
 */
$siteBaseUrl = $siteBaseUrl ?? 'https://telcosurspa.cl/';
$ogImage = $ogImage ?? $siteBaseUrl . 'assets/og/og-default.jpg';
$ogType = $ogType ?? 'website';
$robotsMeta = $robotsMeta ?? 'index, follow';

if ($canonicalUrl === '') {
    $script = basename($_SERVER['SCRIPT_NAME'] ?? 'index.php');
    $canonicalUrl = rtrim($siteBaseUrl, '/') . '/' . ($script === 'index.php' ? '' : $script);
}

$ogTitle = $ogTitle ?? $pageTitle;
$ogDescription = $ogDescription ?? ($pageDescription !== '' ? $pageDescription : 'TelcoSur SPA — empresa regional de telecomunicaciones en el sur de Chile.');
?>
<meta name="robots" content="<?php echo htmlspecialchars($robotsMeta, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:locale" content="es_CL">
<meta property="og:type" content="<?php echo htmlspecialchars($ogType, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:site_name" content="TelcoSur SPA">
<meta property="og:title" content="<?php echo htmlspecialchars($ogTitle, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($ogDescription, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:url" content="<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:image" content="<?php echo htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo htmlspecialchars($ogTitle, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars($ogDescription, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="twitter:image" content="<?php echo htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8'); ?>">
