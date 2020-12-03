<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title><?php wp_title( ' | ', TRUE, 'right' ); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        
        <link rel="stylesheet" type="text/css" href="<?php bloginfo( 'template_url' ); ?>/public/css/app.min.css" media="screen"/>

        <link rel="shortcut icon" href="<?php bloginfo( 'template_url' ); ?>/public/images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?php bloginfo( 'template_url' ); ?>/public/images/favicon.ico" type="image/x-icon">
        
        <?php wp_head(); ?>
        
    </head>

    <body <?php body_class(); ?>>
        <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please
            <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->