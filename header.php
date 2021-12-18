<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-209660629-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());
		  gtag('config', 'UA-209660629-1');
		</script>
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-WJMJ2Z5');</script>
		<!-- End Google Tag Manager -->		
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_OBJT9VmXrBvBfWZ4vYbJg5bEHpxZsS8"></script>
		
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_template_directory_uri(); ?>/assets/img/icons/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/assets/img/icons/touch.png" rel="apple-touch-icon-precomposed">
		<link rel="stylesheet" href="https://use.typekit.net/opq0wlj.css">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php wp_head(); ?>
		<?php require_once "assets/php/Mobile_Detect.php"; global $detect; $detect = new Mobile_Detect();?>
	</head>
	<body <?php body_class(); ?>>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WJMJ2Z5"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->

		<header class="header clear" role="banner">
			<div class="sub-header">
				<div class="wrap-l flex">
					<ul class="cntct">
					<?php $cntct = get_field('cntclnk', 'options'); if( $cntct ):?>
						<?php foreach( $cntct as $c ):?>
							<li><a href="<?php echo $c['lanksrc'];?>"><span class="flex vert-center white-text"><?php echo $c['lanktext'];?></span></a></li>
						<?php endforeach;?>
					<?php endif;?>
					</ul>
					<?php wp_nav_menu( array( 'theme_location'=>'extra-menu' ) );?>
				</div>
			</div>	
			<div class="main-header">
				<div id="menuwrap" class="wrap-xl flex vert-center flex-space">
					<div class="logo pad-s">
						<a href="<?php echo home_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo.svg" alt="Logo" class="logo-img" width="200px" height="55px"/></a>
					</div>
					<nav class="nav" role="navigation">
						<?php wp_nav_menu( array( 'theme_location'=>'header-menu' ) );?>
					</nav>
					<div class="hamburger-outer flex vert-center horiz-center primary-bg">
						<button class="c-hamburger c-hamburger--htx"><span></span></button>
					</div>
				</div>
			</div>
		</header>
