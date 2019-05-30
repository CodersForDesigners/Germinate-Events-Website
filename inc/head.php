<?php

/*
 * Get all the links on the site
 */
$defaultLinks = require __DIR__ . '/default-nav-links.php';
$links = getContent( $defaultLinks, 'pages' );

/*
 * Figure out the base URL
 */
$urlPath = strstr( $_SERVER[ 'REQUEST_URI' ], '?', true );
if ( ! $urlPath )
	$urlPath = $_SERVER[ 'REQUEST_URI' ];
$urlFragments = preg_split( '/\//', $urlPath );
	// Pull out the first non-empty fragment
$calculatedBaseSlug = '';
$inferredBaseSlug = $_GET[ '_slug' ] ?? '';
foreach ( $urlFragments as $fragment ) {
	if ( ! empty( $fragment ) ) {
		$calculatedBaseSlug = $fragment;
		break;
	}
}
if ( $inferredBaseSlug == $calculatedBaseSlug )
	$baseURL = '';
else
	$baseURL = '/' . $calculatedBaseSlug . '/';

/*
 * Get the title and URL of the website and current page
 */
// $siteUrl = getSiteUrl();
$siteTitle = getContent( 'Net Worth Ladder | Germinate Wealth', 'site_title' );
$pageUrl = $siteUrl . $urlPath;
$pageTitle = getCurrentPageTitle( $links, $baseURL, $siteTitle );

?>

<head>

	<!-- Do NOT place anything above this -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">

	<title><?php echo $pageTitle ?></title>


	<?php if ( ! empty( $baseURL ) ) : ?>
		<base href="<?php echo $baseURL ?>">
	<?php endif; ?>

	<!--
	*
	*	Metadata
	*
	- -->
	<!-- Short description of the document (limit to 150 characters) -->
	<!-- This content *may* be used as a part of search engine results. -->
	<meta name="description" content="<?php echo getContent( 'Spend an evening with Saurabh Mukherjea as he leads you on the low risk road to Stupendous Wealth.', 'description' ); ?>">
	<!-- Short description of your document's subject -->
	<meta name="subject" content="<?php echo getContent( '', 'subject' ); ?>">


	<!--
	*
	*	Authors
	*
	- -->
	<!-- Links to information about the author(s) of the document -->
	<meta name="author" content="Lazaro Advertising">
	<link rel="author" href="humans.txt">


	<!--
	*
	*	SEO
	*
	- -->
	<!-- Control the behavior of search engine crawling and indexing -->
	<meta name="robots" content="index,follow"><!-- All Search Engines -->
	<meta name="googlebot" content="index,follow"><!-- Google Specific -->
	<!-- Verify website ownership -->
	<meta name="google-site-verification" content="<?php echo getContent( '', 'google_site_verification_token' ); ?>"><!-- Google Search Console -->


	<!--
	*
	*	UI / Chrome
	*
	- -->
	<!-- Theme Color for Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="<?php echo getContent( '#f9f9f9', 'theme_color' ); ?>">

	<!-- Favicons -->
	<link rel="icon" href="media/favicon/favicon.ico">


	<!-- ~ iOS ~ -->
	<!-- Disable automatic detection and formatting of possible phone numbers -->
	<meta name="format-detection" content="telephone=no">
	<!-- Launch Screen Image -->
	<!-- <link rel="apple-touch-startup-image" href="/path/to/launch.png"> -->
	<!-- Launch Icon Title -->
	<meta name="apple-mobile-web-app-title" content="<?php echo getContent( 'Germinate Events', 'apple -> ios_app_title' ); ?>">
	<!-- Enable standalone (full-screen) mode -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<!-- Status bar appearance (has no effect unless standalone mode is enabled) -->
	<meta name="apple-mobile-web-app-status-bar-style" content="<?php echo getContent( 'default', 'apple -> ios_status_bar_style' ); ?>">

	<!-- ~ Android ~ -->
	<!-- Add to home screen -->
	<meta name="mobile-web-app-capable" content="yes">
	<!-- More info: https://developer.chrome.com/multidevice/android/installtohomescreen -->


	<!--
	*
	*	Social
	*
	- -->
	<!-- Facebook Open Graph -->
	<meta property="og:url" content="<?php echo $pageUrl ?>">
	<meta property="og:type" content="website">
	<meta property="og:title" content="<?php echo $pageTitle ?>">
	<meta property="og:image" content="<?php echo getContent( '', 'og -> image' ) ?>">
	<meta property="og:description" content="<?php echo getContent( 'Spend an evening with Saurabh Mukherjea as he leads you on the low risk road to Stupendous Wealth.', 'og -> description' ) ?>">
	<meta property="og:site_name" content="<?php echo getContent( '', 'site_title' ) ?>">


	<!-- Schema.org / Google+ -->
	<meta itemprop="name" content="<?php echo $pageTitle ?>">
	<meta itemprop="description" content="<?php echo getContent( 'Spend an evening with Saurabh Mukherjea as he leads you on the low risk road to Stupendous Wealth.', 'schema -> description' ) ?>">
	<meta itemprop="image" content="<?php echo getContent( '', 'schema -> image' ) ?>">


	<!--
	*
	*	Enqueue Files
	*
	- -->
	<!-- Stylesheet -->
	<?php require __DIR__ . '/../style.php'; ?>
	<!-- jQuery 3 -->
	<script type="text/javascript" src="plugins/jquery/jquery-3.0.0.min.js<?php echo $ver ?>"></script>
	<!-- Slick Carousel -->
	<!-- <link rel="stylesheet" type="text/css" href="plugins/slick/slick.css<?php echo $ver ?>"/> -->
	<!-- <link rel="stylesheet" type="text/css" href="plugins/slick/slick-theme.css<?php echo $ver ?>"/> -->

	<!--
	*
	*	Fonts and Icons
	*
	- -->
	<?php echo getContent( <<<ARB
	<!-- Fonts -->
	<link rel="stylesheet" href="https://use.typekit.net/wix8miw.css">
	<!-- Icons -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
ARB
, 'fonts_and_icons' ) ?>


	<?php
		/*
		 * Arbitrary Code ( Bottom of Head )
		 */
		echo getContent( '', 'arbitrary_code_head_bottom' );
	?>


</head>
