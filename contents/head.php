<meta charset="<?php bloginfo('charset'); ?>">
<title><?php wp_title('|', true, 'left'); ?></title>

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js"></script>
<![endif]-->
<!--[if IE 9]>
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
<![endif]-->
<link rel="icon" type="image/png" href="<?php bloginfo('template_url') ?>/assets/img/favicon.png" />

<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Roboto:500italic' rel='stylesheet' type='text/css'>

<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url') ?>" />

<?php wp_head(); ?>