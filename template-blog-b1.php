<?php
/*
 * The template for displaying one article of blog streampage with style "Blog 1"
 * 
 * @package norma
*/
?>
	<?php if($post_categories[0]['term_id'] == 8) { ?>
    
    <div class="content_destaque_item col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <a href="<?php the_permalink() ?>">
            
            <img src="<?php echo $post_image;?>" alt="<?php the_title(); ?>" class="imagem img-responsive" title="<?php the_title(); ?>" />
            
            <span class="titulo"><?php the_title(); ?></span>
            <span class="texto"><?php the_excerpt(); ?></span>
        </a>
    </div><!--FIM DIV CONTENT DESTAQUE ITEM-->
    
    <?php } elseif($post_categories[0]['term_id'] == 10) { ?>
    
    <div class="content_trabalhos_item col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <a href="<?php the_permalink() ?>">
            	<?php if (has_post_thumbnail( $post->ID ) ): ?>
				<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
                <img src="<?php echo $post_image; ?>" alt="<?php the_title(); ?>" class="imagem img-responsive" title="<?php the_title(); ?>" />
                <?php endif; ?>
                <span class="titulo"><?php the_title(); ?></span>
                <span class="texto"><?php the_excerpt(); ?></span>
            </a>
        </div><!--FIM CONTENT TRABALHO ITEM-->
    <?php } elseif($post_categories[0]['term_id'] == 9) { ?>
    
    <div class="content_noticias_item">
        <a href="<?php the_permalink() ?>">
            <div class="content_noticias_data">
                <span class="mes"><?php the_time('M') ?></span>
                <span class="data"><?php the_time('j') ?></span>
            </div>
            <span class="titulo"><?php the_title(); ?></span>
        
            <div class="content_noticias_comentario">
            	
            		<img src="<?php echo get_template_directory_uri(); ?>/assets/img/comentario.png" alt="" title="" />&nbsp;<?php echo $post_comments;?>
                
            </div>
            <span class="texto"><?php the_excerpt(); ?></span>
        	</a>
    </div><!--FIM DIV CONTENT NOTICIAS ITEM-->
    
    <?php } elseif($post_categories[0]['term_id'] == 11) { ?>
    
    <div class="content_sobre_item content_sobre_item1">
    	<a href="<?php the_permalink() ?>">
            <span class="titulo"><?php the_title(); ?></span>
            <div class="mais" id="mais1">+</div>
            <span class="texto"><?php the_excerpt(); ?></span>
    	</a>
    </div><!--FIM DIV CONTENT SOBRE ITEM-->	
    
    <?php } elseif($post_categories[0]['term_id'] == 3) { ?>
    
    <div class="content_depoimento_item">
    	<a href="<?php the_permalink() ?>">
            <span class="depoimento"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/aspas_depoimento.png" alt="" title="" ><?php echo the_excerpt(); ?></span>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/john.jpg"  width="40" height="40" alt="" title="" class="img-thumbnail img-circle">
            <span class="nome">John Snow</span>
            <span class="cargo">Diretor comercial</span>
        </a>
    </div>

	<?php } ?>