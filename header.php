<!DOCTYPE HTML>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
    <!--<![endif]-->
    <head>
        <?php get_template_part('contents/head'); ?>
        <?php get_template_part('functions'); ?>
    </head>
    <body <?php body_class(); ?>>
        
        <div id="corpo" class="container-fluid">
            
            <div id="header" class="container-fluid">
                <div id="header_faixa_base">
                    <div id="header_faixa" class="container-fluid">
                        <div class="conteudo container">
                            <div id="header_faixa_telefone" class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                <span class="img_telefone col-lg-6"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico_telefone.png" alt=""  /></span>
                                <span class="txt_telefone col-lg-6"><span class="ddd">11</span> 5070 - 5884</span>
                            </div><!--FIM DIV HEADER FAIXA TELEFONE-->
                            <div id="header_faixa_usuario" class="col-lg-1 col-md-1 col-sm-1 col-xs-6">
                                <a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico_usuario.png" alt="" title="" ></a>
                            </div><!--FIM DIV HEADER FAIXA USUARIO-->
                            <div id="header_faixa_busca" class="col-lg-1 col-md-1 col-sm-1 col-xs-6">
                                <a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico_busca.png"  alt="" title="" ></a>
                            </div><!--FIM DIV FAIXA BUSCA-->
                            <div id="header_faixa_redes" class="col-lg-7 col-md-7 col-sm-4 col-xs-4">
                                <a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico_facebook.png"  alt="" title="" ></a>
                                <a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico_twitter.png"  alt="" title="" ></a>
                                <a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico_googleplus.png"  alt="" title="" ></a>
                                <a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/img/ico_in.png"  alt="" title="" ></a>
                            </div><!--FIM HEADER FAIXA REDES-->
                            
                        </div><!--FIM CONTEUDO HEADER FAIXA-->
                    </div><!--FIM DIV HEADER FAIXA-->
                </div><!--FIM DIV HEADER FAIXA BASE-->
                <div class="conteudo container">
                    <div id="header_logo" class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <a href=""><?php echo get_header_image(); ?><img src="<?php echo get_template_directory_uri(); ?>/assets/img/nexus.png"  title="" alt="" /></a>
                    </div><!--FIM DIV HEADER LOGO-->
                    <ul id="header_menu" class="col-lg-8 col-md-8 col-sm-8 col-xs-6">
                    	<?php wp_list_cats('sort_column=name'); ?>
                        <a href="">HOME</a>
                    </ul><!--FIM DIV HEADER MENU-->
                </div><!--FIM CONTEUDO HEADER-->
                <div id="header_banner">
                    
                    <a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/img/banner1.jpg"  class="img-responsive" alt="" title="" /></a>
                    <div class="conteudo container">
                    <div id="header_banner_prev"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/prev.png"  id="prev" alt="" title="" /></div>
                    <div id="header_banner_next"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/next.png"  id="next" alt="" title="" /></div>
                    </div>
                </div><!--FIM DIV HEADER BANNER-->
            </div><!--FIM DIV HEADER-->
            <div id="conteudo">