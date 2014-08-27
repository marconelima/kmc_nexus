<?php get_header(); ?>

<div class="conteudo container">
    <div id="content_destaque">
    	<?php query_posts('category_name=destaque'); ?>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
 		<div class="content_destaque_item col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <a href="">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/imagem1.png"  class="imagem img-responsive" alt="" title="" />
                <span class="titulo">Especialidade de Ensino a Dinstância</span>
                <span class="texto">Material didático elaborado por Doutora em Ensino a dinstância, considerando as especificidades postas pela educação online. A organização curricular dos cursos elaborados pela Nexus respeitam as diferenças estruturais entre a educação presencial e a educação a distância.</span>
            </a>
        </div><!--FIM DIV CONTENT DESTAQUE ITEM-->
		<?php endwhile?>
         
        <?php else: ?>
             
        <?php endif; ?>
        
        
        <div class="content_destaque_item col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <a href="">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/imagem2.png"  class="imagem img-responsive" alt="" title="" />
                <span class="titulo">Especialidade de Ensino a Dinstância</span>
                <span class="texto">Material didático elaborado por Doutora em Ensino a dinstância, considerando as especificidades postas pela educação online. A organização curricular dos cursos elaborados pela Nexus respeitam as diferenças estruturais entre a educação presencial e a educação a distância.</span>
            </a>
        </div><!--FIM DIV CONTENT DESTAQUE ITEM-->
        <div class="content_destaque_item col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <a href="">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/imagem3.png"  class="imagem img-responsive" alt="" title="" />
                <span class="titulo">Especialidade de Ensino a Dinstância</span>
                <span class="texto">Material didático elaborado por Doutora em Ensino a dinstância, considerando as especificidades postas pela educação online. A organização curricular dos cursos elaborados pela Nexus respeitam as diferenças estruturais entre a educação presencial e a educação a distância.</span>
            </a>
        </div><!--FIM DIV CONTENT DESTAQUE ITEM-->
    </div><!--FIM DIV CONTENT DESTAQUE-->
    
    <div id="content_trabalhos">
        <span class="titulo">confira alguns trabalhos recentes</span>
        <div id="content_trabalhos_next"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icone_next.png" alt="" title=""  id="trabalho_next" /></div>
        <div id="content_trabalhos_prev"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icone_prev.png" alt="" title=""  id="trabalho_prev" /></div>
        <div class="separacao"></div>
        <div class="barra"></div>
        <div class="separacao"></div>
        <?php query_posts('category_name=trabalhos'); ?>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="content_trabalhos_item col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <a href="">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/trabalho1.jpg"  class="imagem img-responsive" alt="" title="" />
                <span class="titulo">Cursos abertos UNESP</span>
                <span class="texto">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac sapien eget arcu semper placerat.</span>
            </a>
        </div><!--FIM CONTENT TRABALHO ITEM-->
        <?php endwhile?>
         
        <?php else: ?>
             
        <?php endif; ?>
        
        <div class="content_trabalhos_item col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <a href="">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/trabalho2.jpg"  class="imagem img-responsive" alt="" title="" />
                <span class="titulo">Cursos abertos UNESP</span>
                <span class="texto">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac sapien eget arcu semper placerat.</span>
            </a>
        </div><!--FIM CONTENT TRABALHO ITEM-->
        <div class="content_trabalhos_item col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <a href="">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/trabalho3.jpg"  class="imagem img-responsive" alt="" title="" />
                <span class="titulo">Cursos abertos UNESP</span>
                <span class="texto">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac sapien eget arcu semper placerat.</span>
            </a>
        </div><!--FIM CONTENT TRABALHO ITEM-->
        <div class="content_trabalhos_item col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <a href="">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/trabalho4.jpg"  class="imagem img-responsive" alt="" title="" />
                <span class="titulo">Cursos abertos UNESP</span>
                <span class="texto">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac sapien eget arcu semper placerat.</span>
            </a>
        </div><!--FIM CONTENT TRABALHO ITEM-->
    </div><!--FIM DIV CONTENT TRABALHOS-->
    
    <div id="contet_noticias" class="col-lg-6 col-md-6 col-sm-4 col-xs-4">
        <span class="titulo">últimas notícias</span>
        <div class="separacao"></div>
        <div class="barra"></div>
        <div class="separacao"></div>
        <div class="content_noticias_item">
            <a href="">
                <div class="content_noticias_data">
                    <span class="mes">Jun</span>
                    <span class="data">28</span>
                </div>
                <span class="titulo">Lorem ipsum dolor sit amet</span>
                <div class="content_noticias_comentario"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/comentario.png" alt="" title="" />&nbsp;27</div>
                <span class="texto">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam condimentum non felis ut volutpat. Ut et risus lectus. Vestibulum id turpis cursus, venenatis est vel, bibendum massa. Phasellus tempus tortor vestibulum erat faucibus molestie. </span>
            </a>
        </div><!--FIM DIV CONTENT NOTICIAS ITEM-->
        
        <div class="content_noticias_item">
            <a href="">
                <div class="content_noticias_data">
                    <span class="mes">Jun</span>
                    <span class="data">28</span>
                </div>
                <span class="titulo">Lorem ipsum dolor sit amet</span>
                <div class="content_noticias_comentario"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/comentario.png" alt="" title="" />&nbsp;27</div>
                <span class="texto">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam condimentum non felis ut volutpat. Ut et risus lectus. Vestibulum id turpis cursus, venenatis est vel, bibendum massa. Phasellus tempus tortor vestibulum erat faucibus molestie. </span>
            </a>
        </div><!--FIM DIV CONTENT NOTICIAS ITEM-->
    
    </div><!--FIM DIV CONTENT NOTICIAS-->
    
    <div id="contet_sobre" class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
        <span class="titulo">sobre nós</span>
        <div class="separacao"></div>
        <div class="barra"></div>
        <div class="separacao2"></div>
        <div class="content_sobre_item content_sobre_item1">
            <span class="titulo">Plataformas Empresariais</span>
            <div class="mais" id="mais1">+</div>
            <span class="texto">Lorem ipsum dolor sit amet, consect adipiscing elit consectetur adipiscing elit.</span>
        </div><!--FIM DIV CONTENT SOBRE ITEM-->	
        <div class="content_sobre_item content_sobre_item2">
            <span class="titulo">Suporte Pedagógico</span>
            <div class="mais" id="mais2">+</div>
            <span class="texto">Lorem ipsum dolor sit amet, consect adipiscing elit consectetur adipiscing elit.</span>
        </div><!--FIM DIV CONTENT SOBRE ITEM-->	
        <div class="content_sobre_item content_sobre_item3">
            <span class="titulo">Consultoria</span>
            <div class="mais" id="mais3">+</div>
            <span class="texto">Lorem ipsum dolor sit amet, consect adipiscing elit consectetur adipiscing elit.</span>
        </div><!--FIM DIV CONTENT SOBRE ITEM-->	
    </div><!--FIM DIV CONTENT SOBRE-->
    
    <div id="contet_depoimento" class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
        <span class="titulo">depoimentos</span>
        <div class="separacao"></div>
        <div class="barra"></div>
        <div class="separacao2"></div>
        <div class="content_depoimento_item">
            <span class="depoimento"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/aspas_depoimento.png" alt="" title="" >&nbsp;Lorem ipsum dolor sit amet, consect adipiscing elit consectetur adipiscing elit.</span>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/john.jpg"  width="40" height="40" alt="" title="" class="img-thumbnail img-circle">
            <span class="nome">John Snow</span>
            <span class="cargo">Diretor comercial</span>
        </div>
    </div><!--FIM DIV CONTENT DEPOIMENTO-->
    
    <div id="content_banner">
        <div id="content_banner_left" class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <a href=""><img src="http://placehold.it/570x160" class="img-responsive"  title="" alt="" ></a>
        </div><!--FIM DIV CONTENT BANNER LEFT-->
        <div id="content_banner_right" class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <a href=""><img src="http://placehold.it/570x160" class="img-responsive"  title="" alt="" ></a>
        </div><!--FIM DIV CONTENT BANNER RIGHT-->
    </div><!--FIM DIV CONTENT BANNER-->
    
    <div id="content_parceiro">
        <div class="content_parceiro_box">
            <span class="titulo">nossos parceiros</span>
            <span class="texto">Credibilidade nas parcerias</span>
        </div><!--FIM DIV CONTENT PARCEIRO BOX-->
        <div id="content_parceiro_logo">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/moodle.gif"  alt="" title="" />
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/microsoft.gif"  alt="" title="" />
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/qarbon.gif"  alt="" title="" />
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/composica.gif"  alt="" title="" />
        </div><!--FIM CONTENT PARCEIRO LOGO-->
    </div><!--FIM DIV CONTENT PARCEIRO-->
</div>
<?php get_footer(); ?>