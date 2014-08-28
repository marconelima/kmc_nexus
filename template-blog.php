<?php
/*
Template Name: Blog streampage
*/
get_header(); 


$mult = min(2, max(1, get_theme_option("retina_ready")));
$counters = get_theme_option("blog_counters");
$page_style = get_custom_option('blog_style');
$mode = get_custom_option('blog_mode');
if (!in_array($page_style, array('b1', 'b2', 'b3', 'p1', 'p2', 'p3', 'p4'))) $page_style = 'b1';
$thumb_size = array(
	'b1' => array('w' => array(790, 1090), 'h' => array(391, 391)),
	'b2' => array('w' => array(860, 1170), 'h' => array(391, 391)),
	'b3' => array('w' => array(360, 360),  'h' => array(222, 222)),
	'p1' => array('w' => array(570, 570),  'h' => array(310, 310)),
	'p2' => array('w' => array(570, 570),  'h' => array(400, 400)),
	'p3' => array('w' => array(370, 370),  'h' => array(320, 320)),
	'p4' => array('w' => array(270, 270),  'h' => array(220, 220)),
);
$thumb_idx = get_custom_option('blog_sidebar_position')=='fullwidth' ? 1 : 0;
$use_isotope = false;
if (in_array($page_style, array('p1', 'p2', 'p3', 'p4')) && get_custom_option('portfolio_use_isotope')=='yes') {
	$use_isotope = true;
	wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array('jquery'), '1.5.25', true );
	wp_enqueue_script( 'isotope-init', get_template_directory_uri() . '/js/_isotope.js', array('jquery', 'isotope'), '1.0.0', true );
}

$ppp = (int) get_custom_option('blog_posts_per_page');
$ppp = $ppp > 0 ? $ppp : (int) get_option('posts_per_page');
?>
	<div id="main_inner" class="clearboth">
		<div id="content" class="content_blog blog_style_<?php echo $page_style; ?>" role="main">
        
        	
		<?php 
			if (in_array($page_style, array('p1', 'p2', 'p3', 'p4'))) {
				// Show categories filter list
				$cat_id = (int) get_query_var('cat');
				$portfolio_parent = is_category() ? getParentCategoryByProperty($cat_id, 'blog_style', array('p1', 'p2', 'p3', 'p4')) : 0;
				$portfolio_link = '#';
				if ($portfolio_parent) {
					$portfolio_term = get_term_by( 'id', $portfolio_parent, 'category');
					$portfolio_link = get_term_link($portfolio_term->slug, 'category');
				} else {
					if (($blog_id = getTemplatePageId('template-blog')) > 0)
						$portfolio_link = get_permalink($blog_id);
				}
				$args = array(
					'type'                     => 'post',
					'child_of'                 => $portfolio_parent,
					'orderby'                  => 'name',
					'order'                    => 'ASC',
					'hide_empty'               => 1,
					'hierarchical'             => 0,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => 'category',
					'pad_counts'               => false );
				$portfolio_list = get_categories($args); 
				if (count($portfolio_list) > 0) {
					$output = '<a href="' . ($use_isotope ? '#' : $portfolio_link) . '" data-filter="*"' . ($portfolio_parent==$cat_id ? ' class="current"' : '') .'>'.__('All', 'wpspace').'</a>';
					foreach ($portfolio_list as $cat) {
						$output .= '<a href="' . ($use_isotope ? '#' : get_term_link($cat->slug, 'category') ) . '" data-filter=".category_'.$cat->term_id.'"' . ($cat_id==$cat->term_id ? ' class="current"' : '') .'>'.$cat->name.'</a>';
					}
					?>
                    <div id="portfolio_iso_filters"><?php echo $output; ?></div>
                    <?php
					if ($use_isotope) {
					?>
						<script type="text/javascript">
                            var ppp = <?php echo $ppp; ?>;
                        </script>
                    <?php
					}
					?>
                    <div class="portfolio_items">
                    <?php
				}
			} else {
				
				// Author page - show author block
				/*
				if ( is_author() ) {				
					get_template_part('template', 'blog_author');
				}
				*/
			}

			global $wp_query, $more, $post;
			$page_number = get_query_var('paged') ? get_query_var('paged') : 1;
			$wp_query_need_restore = false;
			
			if ( is_page() || $use_isotope) {
				$args = $wp_query->query_vars;
				$args['post_type'] =  'post';
				$args['order'] = 'DESC';
				$args['orderby'] = 'date';
				unset($args['p']);
				unset($args['page_id']);
				unset($args['pagename']);
				unset($args['name']);
				$args['posts_per_page'] = $use_isotope ? 9999 : $ppp;
				if ($use_isotope && $portfolio_parent) {
					$args['cat'] = $portfolio_parent;
					$args['category_name'] = $portfolio_term->slug;
				}
				if ($page_number > 1 || $use_isotope) $args['ignore_sticky_posts'] = 1;
				query_posts( $args );
				$wp_query_need_restore = true;
			}
			$per_page = count($wp_query->posts);
			$post_number = 0;

			$oldmore = $more;
			$more = 0;
						
			if($_GET['cat'] > 0){
			
			query_posts('cat='.$_GET['cat']); 
			while ( have_posts() ) : the_post();  ?>
            <?php setPostViews(get_the_ID()); ?>

                <?php
				$tpl_dir = get_template_directory_uri();

				$post_id = get_the_ID();
				$post_protected = post_password_required();
				$post_format = get_post_format();
				if (empty($post_format)) $post_format = 'standard';
				$post_link = get_permalink();
				$post_comments_link = $counters=='comments' ? get_comments_link( $post_id ) : $post_link;
				$post_date = get_the_date();
				$post_title = getPostTitle();
				$post_descr = get_the_excerpt();					//getPostDescription();
				$post_comments = get_comments_number();
				$post_views = getPostViews($post_id);
				$post_custom_options = get_post_meta($post_id, 'post_custom_options', true);
				$post_icon = isset($post_custom_options['page_icon']) ? $post_custom_options['page_icon'] : get_post_meta($post_id, 'page_icon', true);
				if ($post_icon=='' || $post_icon=='default') $post_icon = getPostFormatIcon($post_format);
				$post_thumb = get_custom_option("single_featured_image") == 'yes' 
					? getResizedImageTag($post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx] ? $thumb_size[$page_style]['h'][$thumb_idx]*$mult : null)
					: '';
				// Author info
				$post_author = get_the_author();
				$post_author_id = get_the_author_meta('ID');
				$post_author_url = get_author_posts_url($post_author_id, ''); 
				
				// Content
				$post_content = get_the_content(null, get_custom_option('single_text_before_readmore')!='yes');
				if ($post_format == 'gallery') {
					if (get_custom_option('blog_substitute_gallery')=='yes') {
						$post_content = substituteGallery($post_content, $post_id, $thumb_size[$subst_style]['w'][$thumb_idx]*$mult, $thumb_size[$subst_style]['h'][$thumb_idx]*$mult);
					}
				} else if ($post_format == 'video') {
					if (get_custom_option('blog_substitute_video')=='yes') {
						$post_content = substituteVideo($post_content, $thumb_size[$subst_style]['w'][$thumb_idx], $thumb_size[$subst_style]['h'][$thumb_idx]);
					}
				} else if ($post_format == 'audio') {
					if (get_custom_option('blog_substitute_audio')=='yes') {
						$post_content = substituteAudio($post_content);
					}
				}
				$post_content = apply_filters('the_content', $post_content);
				
				// Categories list
				$post_categories_str = '';
				$post_categories_ids = array();
				$post_categories = getCategoriesByPostId($post_id);
				for ($i = 0; $i < count($post_categories); $i++) {
					$post_categories_ids[] = $post_categories[$i]['term_id'];
					$post_categories_str .= '<a class="cat_link" href="' . $post_categories[$i]['link'] . '">'
						. $post_categories[$i]['name'] 
						. ($i < count($post_categories)-1 ? ',' : '')
						. '</a> ';
				}
				// Tags list
				$post_tags_str = '';
				if (get_custom_option("single_show_post_tags") == 'yes') {				
					if (($post_tags = get_the_tags()) != 0) {
						$tag_number=0;
						foreach ($post_tags as $tag) {
							$tag_number++;
							$post_tags_str .= '<a class="tag_link" href="' . get_tag_link($tag->term_id) . '">' . $tag->name . ($tag_number==count($post_tags) ? '' : ',') . '</a> ';
						}
					}
				}
				
				?>
            <article <?php post_class('post_format_'.$post_format.' '.($post_number%2==0 ? 'even' : 'odd') . ($post_number==0 ? ' first' : '') . ($post_number==$per_page? ' last' : '')); ?>>
                <div class="post_info_1">
						<div class="content_noticias_data_post">
                            <span class="mes"><?php the_time('M') ?></span>
                            <span class="data"><?php the_time('j') ?></span>
                        </div>
						
						<?php if ($counters!='none') { ?>
                        <div class="post_comments"><a href="<?php echo $post_comments_link; ?>"><span class="icon-<?php echo $counters=='comments' ? 'comment' : 'eye'; ?>"></span><span class="comments_number"><?php echo $counters=='comments' ? $post_comments : $post_views; ?></span></a></div>
                        <?php } ?>
					</div>
            <?php 
            if ($post_protected) { 
            ?>
                <div class="post_content"><?php echo $post_descr; ?></div>
            <?php 
            } else {
                if ($post_format!='quote') {
                ?>
                    <div class="title_area">
                        <h1 class="post_title"><a href="<?php echo $post_link; ?>"><?php echo $post_title; ?></a></h1>
                    </div>
            
                    <div class="post_info post_info_2">
                        <span class="post_author"><?php _e('Posted by: ', 'wpspace'); ?><a href="<?php echo $post_author_url; ?>" class="post_author"><?php echo $post_author; ?></a></span>
                        <?php 
                        if ($post_categories_str != '') { 
                        ?>
                            <span class="post_info_delimiter"></span>
                            <span class="post_categories">
                                <span class="cats_label"><?php _e('Categories:', 'wpspace'); ?></span>
                                <?php echo $post_categories_str; ?>
                            </span>
                        <?php } // post_cats ?>
                    </div>
            
                <?php
                }
                // If post have thumbnail - show it
                if ( $post_thumb ) {
                ?>
                    <div class="pic_wrapper image_wrapper">
                        <?php echo $post_thumb; ?>
                    </div>
                <?php
                }
                ?>
                
                    <div class="post_content">
                        <?php if (get_custom_option('blog_mode')=='short') {
                            echo apply_filters('the_content', $post_descr);
                            ?>
                            <div class="readmore"><a href="<?php echo $post_link; ?>" class="more-link"><?php _e('Read more', 'wpspace'); ?></a></div>
                            <?php 
                        } else {		// blog_mode == 'full'
                            if ($post_excerpt) {
                                echo apply_filters('the_content', $post_excerpt);
                                ?>
                                <div class="readmore"><a href="<?php echo $post_link; ?>" class="more-link"><?php _e('Read more', 'wpspace'); ?></a></div>
                                <?php
                            } else {
                                echo substr($post_content,0,500); 
								?>
								<div class="readmore"><a href="<?php echo $post_link; ?>" class="more-link"><?php _e('Read more', 'wpspace'); ?></a></div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="post_info post_info_3 clearboth">
                        <?php if ($post_tags_str != '') { ?>
                            <span class="post_tags">
                                <span class="tags_label"><?php _e('Tags:', 'wpspace'); ?></span>
                                <?php echo $post_tags_str; ?>
                            </span>
                        <?php } // post_tags ?>
                    </div>
            <?php
            }
            ?>
            </article>
            <?php endwhile?>	
            <?php		
			}else {
			?>	
			<div id="content_destaque">	
			<?php	
			query_posts('category_name=destaque&showposts=3'); 
			while ( have_posts() ) : the_post();  
				if ($post->post_date > date('Y-m-d 23:59:59') && $post->post_date_gmt > date('Y-m-d 23:59:59')) continue;

				$post_number++;
				
				
				if(has_post_thumbnail($post->ID)): 				
					$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'single-post-thumbnail');
                endif;
				
				$post_image = $image[0];
				
				//print_r($post_image);

				$post_id = get_the_ID();
				$post_protected = post_password_required();
				$post_format = get_post_format();
				if (empty($post_format)) $post_format = 'standard';
				$post_link = get_permalink();
				$post_comments_link = $counters=='comments' ? get_comments_link( $post_id ) : $post_link;
				$post_date = get_the_date();
				$post_comments = get_comments_number();
				$post_views = getPostViews($post_id);
				$post_author = get_the_author();
				$post_author_id = get_the_author_meta('ID');
				$post_author_url = get_author_posts_url($post_author_id, '');
				$post_custom_options = get_post_meta($post_id, 'post_custom_options', true);
				$post_icon = isset($post_custom_options['page_icon']) ? $post_custom_options['page_icon'] : get_post_meta($post_id, 'page_icon', true);
				if ($post_icon=='' || $post_icon=='default') $post_icon = getPostFormatIcon($post_format);
				
				$post_thumb = getResizedImageTag($post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
				$post_attachment = wp_get_attachment_url(get_post_thumbnail_id($post_id));

				$post_title = getPostTitle();
				$post_excerpt = trim(chop($post->post_excerpt));	//getPostDescription();
				$post_descr = getPostDescription();					//get_the_excerpt();
				$post_content = get_the_content(__('<span class="readmore">Read more</span>', 'wpspace'));
				if ($post_format == 'gallery') {
					if (get_custom_option('blog_substitute_gallery')=='yes') {
						if ($mode == 'full') {
							$post_content = substituteGallery($post_content, $post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
							$post_excerpt = substituteGallery($post_excerpt, $post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
						} else
							$post_descr = substituteGallery($post_descr,     $post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
					}
				} else if ($post_format == 'video') {
					if (get_custom_option('blog_substitute_video')=='yes') {
						if ($mode == 'full') {
							$post_content = substituteVideo($post_content, $thumb_size[$page_style]['w'][$thumb_idx], $thumb_size[$page_style]['h'][$thumb_idx]);
							$post_excerpt = substituteVideo($post_excerpt, $thumb_size[$page_style]['w'][$thumb_idx], $thumb_size[$page_style]['h'][$thumb_idx]);
						} else
							$post_descr   = substituteVideo($post_descr,   $thumb_size[$page_style]['w'][$thumb_idx], $thumb_size[$page_style]['h'][$thumb_idx]);
					}
				} else if ($post_format == 'audio') {
					if (get_custom_option('blog_substitute_audio')=='yes') {
						if ($mode == 'full') {
							$post_content = substituteAudio($post_content);
							$post_excerpt = substituteAudio($post_excerpt);
						} else
							$post_descr   = substituteAudio($post_descr);
					}
				}
				$post_content = apply_filters('the_content', $post_content);
				$post_content = decorateMoreLink(str_replace(']]>', ']]&gt;', $post_content));

				$post_categories = getCategoriesByPostId($post_id);
				$post_categories_str = '';
				$post_categories_classes = '';
				for ($i = 0; $i < count($post_categories); $i++) {
					$post_categories_str .= '<a class="cat_link" href="' . $post_categories[$i]['link'] . '">'
						. $post_categories[$i]['name'] 
						. ($i < count($post_categories)-1 ? ',' : '')
						. '</a> ';
					$post_categories_classes .= ($post_categories_classes ? ' ' : '') . 'category_'.$post_categories[$i]['term_id'];
				}

				$post_tags_str = '';
				if (($post_tags = get_the_tags()) != 0) {
					$tag_number=0;
					foreach ($post_tags as $tag) {
						$tag_number++;
						$post_tags_str .= '<a class="tag_link" href="' . get_tag_link($tag->term_id) . '">' . $tag->name . ($tag_number==count($post_tags) ? '' : ',') . '</a> ';
					}
				}
				
				require(get_template_directory() . '/template-blog-'.(in_array($page_style, array('p2', 'p3', 'p4')) ? 'p2' : $page_style).'.php');

			endwhile; 
			
			if (!$post_number) { 
				if (is_404()) {
			?>
				<article class="post_format_standard page_404">
                    <div class="title_area">
                        <h1 class="post_title"><?php _e( '404', 'wpspace' ); ?></h1>
                    </div>
					<div class="post_content">
                        <h2 class="post_subtitle"><?php _e( 'Oops, This Page Could Not Be Found!', 'wpspace' ); ?></h2>
						<div class="text">
							<div class="not_found"><?php _e( "Can't find what you need? Take a moment and do a search below!", 'wpspace' ); ?></div>
							<form class="searchform" action="<?php echo home_url(); ?>" method="get"><input class="field field_search" type="search" placeholder="<?php _e('Search &hellip;', 'wpspace'); ?>" value="" name="s"><a href="#" class="search_form_link"><span class="icon-search"></span></a></form>
							<a href="<?php echo get_site_url(); ?>" class="go_home sc_button sc_button_style_grey"><?php _e( 'Or start from our homepage', 'wpspace' ); ?></a>
						</div>
                    </div>
                </article>
			<?php
				} else if (is_search()) { 
			?>
				<article class="post_format_standard page_no_results">
                    <div class="title_area">
                        <h2 class="post_title"><?php echo sprintf( __( 'Search Results for: &laquo;%s&raquo;', 'wpspace' ), get_search_query() ); ?></h2>
                    </div>
					<div class="post_content">
						<div class="text">
							<p class="search_no_results">
								<?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'wpspace' ); ?>
							</p>
						</div>
                    </div>
                </article>
			<?php
				} else { 
			?>
				<article class="post_format_standard page_no_results">
                    <div class="title_area">
                        <h2 class="post_title"><?php echo sprintf( __( 'No posts found', 'wpspace' ), get_search_query() ); ?></h2>
                    </div>
					<div class="post_content">
						<div class="text">
							<p class="search_no_results">
								<?php _e( 'Sorry, but nothing matched your search terms.', 'wpspace' ); ?>
							</p>
						</div>
                    </div>
                </article>
			<?php
				}
			}
			?>
			</div><!--FIM DIV CONTENT DESTAQUE-->
            
            
            
            
            
            
            <div id="content_trabalhos">
                <span class="titulo">confira alguns trabalhos recentes</span>
                <div id="content_trabalhos_next"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icone_next.png" alt="" title=""  id="trabalho_next" /></div>
                <div id="content_trabalhos_prev"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icone_prev.png" alt="" title=""  id="trabalho_prev" /></div>
                <div class="separacao"></div>
                <div class="barra"></div>
                <div class="separacao"></div>
			<?php
			query_posts('category_name=trabalhos-recentes&showposts=4'); 
			while ( have_posts() ) : the_post();  
				if ($post->post_date > date('Y-m-d 23:59:59') && $post->post_date_gmt > date('Y-m-d 23:59:59')) continue;

				$post_number++;
				
				
				if(has_post_thumbnail($post->ID)): 				
					$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'single-post-thumbnail');
                endif;
				
				$post_image = $image[0];
				
				//print_r($post_image);

				$post_id = get_the_ID();
				$post_protected = post_password_required();
				$post_format = get_post_format();
				if (empty($post_format)) $post_format = 'standard';
				$post_link = get_permalink();
				$post_comments_link = $counters=='comments' ? get_comments_link( $post_id ) : $post_link;
				$post_date = get_the_date();
				$post_comments = get_comments_number();
				$post_views = getPostViews($post_id);
				$post_author = get_the_author();
				$post_author_id = get_the_author_meta('ID');
				$post_author_url = get_author_posts_url($post_author_id, '');
				$post_custom_options = get_post_meta($post_id, 'post_custom_options', true);
				$post_icon = isset($post_custom_options['page_icon']) ? $post_custom_options['page_icon'] : get_post_meta($post_id, 'page_icon', true);
				if ($post_icon=='' || $post_icon=='default') $post_icon = getPostFormatIcon($post_format);
				
				$post_thumb = getResizedImageTag($post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
				$post_attachment = wp_get_attachment_url(get_post_thumbnail_id($post_id));

				$post_title = getPostTitle();
				$post_excerpt = trim(chop($post->post_excerpt));	//getPostDescription();
				$post_descr = getPostDescription();					//get_the_excerpt();
				$post_content = get_the_content(__('<span class="readmore">Read more</span>', 'wpspace'));
				if ($post_format == 'gallery') {
					if (get_custom_option('blog_substitute_gallery')=='yes') {
						if ($mode == 'full') {
							$post_content = substituteGallery($post_content, $post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
							$post_excerpt = substituteGallery($post_excerpt, $post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
						} else
							$post_descr = substituteGallery($post_descr,     $post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
					}
				} else if ($post_format == 'video') {
					if (get_custom_option('blog_substitute_video')=='yes') {
						if ($mode == 'full') {
							$post_content = substituteVideo($post_content, $thumb_size[$page_style]['w'][$thumb_idx], $thumb_size[$page_style]['h'][$thumb_idx]);
							$post_excerpt = substituteVideo($post_excerpt, $thumb_size[$page_style]['w'][$thumb_idx], $thumb_size[$page_style]['h'][$thumb_idx]);
						} else
							$post_descr   = substituteVideo($post_descr,   $thumb_size[$page_style]['w'][$thumb_idx], $thumb_size[$page_style]['h'][$thumb_idx]);
					}
				} else if ($post_format == 'audio') {
					if (get_custom_option('blog_substitute_audio')=='yes') {
						if ($mode == 'full') {
							$post_content = substituteAudio($post_content);
							$post_excerpt = substituteAudio($post_excerpt);
						} else
							$post_descr   = substituteAudio($post_descr);
					}
				}
				$post_content = apply_filters('the_content', $post_content);
				$post_content = decorateMoreLink(str_replace(']]>', ']]&gt;', $post_content));

				$post_categories = getCategoriesByPostId($post_id);
				$post_categories_str = '';
				$post_categories_classes = '';
				for ($i = 0; $i < count($post_categories); $i++) {
					$post_categories_str .= '<a class="cat_link" href="' . $post_categories[$i]['link'] . '">'
						. $post_categories[$i]['name'] 
						. ($i < count($post_categories)-1 ? ',' : '')
						. '</a> ';
					$post_categories_classes .= ($post_categories_classes ? ' ' : '') . 'category_'.$post_categories[$i]['term_id'];
				}

				$post_tags_str = '';
				if (($post_tags = get_the_tags()) != 0) {
					$tag_number=0;
					foreach ($post_tags as $tag) {
						$tag_number++;
						$post_tags_str .= '<a class="tag_link" href="' . get_tag_link($tag->term_id) . '">' . $tag->name . ($tag_number==count($post_tags) ? '' : ',') . '</a> ';
					}
				}
				
				require(get_template_directory() . '/template-blog-'.(in_array($page_style, array('p2', 'p3', 'p4')) ? 'p2' : $page_style).'.php');

			endwhile; 
			
			if (!$post_number) { 
				if (is_404()) {
			?>
				<article class="post_format_standard page_404">
                    <div class="title_area">
                        <h1 class="post_title"><?php _e( '404', 'wpspace' ); ?></h1>
                    </div>
					<div class="post_content">
                        <h2 class="post_subtitle"><?php _e( 'Oops, This Page Could Not Be Found!', 'wpspace' ); ?></h2>
						<div class="text">
							<div class="not_found"><?php _e( "Can't find what you need? Take a moment and do a search below!", 'wpspace' ); ?></div>
							<form class="searchform" action="<?php echo home_url(); ?>" method="get"><input class="field field_search" type="search" placeholder="<?php _e('Search &hellip;', 'wpspace'); ?>" value="" name="s"><a href="#" class="search_form_link"><span class="icon-search"></span></a></form>
							<a href="<?php echo get_site_url(); ?>" class="go_home sc_button sc_button_style_grey"><?php _e( 'Or start from our homepage', 'wpspace' ); ?></a>
						</div>
                    </div>
                </article>
			<?php
				} else if (is_search()) { 
			?>
				<article class="post_format_standard page_no_results">
                    <div class="title_area">
                        <h2 class="post_title"><?php echo sprintf( __( 'Search Results for: &laquo;%s&raquo;', 'wpspace' ), get_search_query() ); ?></h2>
                    </div>
					<div class="post_content">
						<div class="text">
							<p class="search_no_results">
								<?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'wpspace' ); ?>
							</p>
						</div>
                    </div>
                </article>
			<?php
				} else { 
			?>
				<article class="post_format_standard page_no_results">
                    <div class="title_area">
                        <h2 class="post_title"><?php echo sprintf( __( 'No posts found', 'wpspace' ), get_search_query() ); ?></h2>
                    </div>
					<div class="post_content">
						<div class="text">
							<p class="search_no_results">
								<?php _e( 'Sorry, but nothing matched your search terms.', 'wpspace' ); ?>
							</p>
						</div>
                    </div>
                </article>
			<?php
				}
			}

			
		?>
			</div><!--FIM DIV CONTENT TRABALHO-->
            
            
            
            
            
            
            
            
            
            <div id="contet_noticias" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            	<span class="titulo">últimas notícias</span>
                <div class="separacao"></div>
                <div class="barra"></div>
                <div class="separacao"></div>
                <?php query_posts('category_name=noticias&showposts=2'); ?>
            	<?php while ( have_posts() ) : the_post();  
				if ($post->post_date > date('Y-m-d 23:59:59') && $post->post_date_gmt > date('Y-m-d 23:59:59')) continue;

				$post_number++;
				
				
				if(has_post_thumbnail($post->ID)): 				
					$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'single-post-thumbnail');
                endif;
				
				$post_image = $image[0];
				
				//print_r($post_image);

				$post_id = get_the_ID();
				$post_protected = post_password_required();
				$post_format = get_post_format();
				if (empty($post_format)) $post_format = 'standard';
				$post_link = get_permalink();
				$post_comments_link = $counters=='comments' ? get_comments_link( $post_id ) : $post_link;
				$post_date = get_the_date();
				$post_comments = get_comments_number();
				$post_views = getPostViews($post_id);
				$post_author = get_the_author();
				$post_author_id = get_the_author_meta('ID');
				$post_author_url = get_author_posts_url($post_author_id, '');
				$post_custom_options = get_post_meta($post_id, 'post_custom_options', true);
				$post_icon = isset($post_custom_options['page_icon']) ? $post_custom_options['page_icon'] : get_post_meta($post_id, 'page_icon', true);
				if ($post_icon=='' || $post_icon=='default') $post_icon = getPostFormatIcon($post_format);
				
				$post_thumb = getResizedImageTag($post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
				$post_attachment = wp_get_attachment_url(get_post_thumbnail_id($post_id));

				$post_title = getPostTitle();
				$post_excerpt = trim(chop($post->post_excerpt));	//getPostDescription();
				$post_descr = getPostDescription();					//get_the_excerpt();
				$post_content = get_the_content(__('<span class="readmore">Read more</span>', 'wpspace'));
				if ($post_format == 'gallery') {
					if (get_custom_option('blog_substitute_gallery')=='yes') {
						if ($mode == 'full') {
							$post_content = substituteGallery($post_content, $post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
							$post_excerpt = substituteGallery($post_excerpt, $post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
						} else
							$post_descr = substituteGallery($post_descr,     $post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
					}
				} else if ($post_format == 'video') {
					if (get_custom_option('blog_substitute_video')=='yes') {
						if ($mode == 'full') {
							$post_content = substituteVideo($post_content, $thumb_size[$page_style]['w'][$thumb_idx], $thumb_size[$page_style]['h'][$thumb_idx]);
							$post_excerpt = substituteVideo($post_excerpt, $thumb_size[$page_style]['w'][$thumb_idx], $thumb_size[$page_style]['h'][$thumb_idx]);
						} else
							$post_descr   = substituteVideo($post_descr,   $thumb_size[$page_style]['w'][$thumb_idx], $thumb_size[$page_style]['h'][$thumb_idx]);
					}
				} else if ($post_format == 'audio') {
					if (get_custom_option('blog_substitute_audio')=='yes') {
						if ($mode == 'full') {
							$post_content = substituteAudio($post_content);
							$post_excerpt = substituteAudio($post_excerpt);
						} else
							$post_descr   = substituteAudio($post_descr);
					}
				}
				$post_content = apply_filters('the_content', $post_content);
				$post_content = decorateMoreLink(str_replace(']]>', ']]&gt;', $post_content));

				$post_categories = getCategoriesByPostId($post_id);
				$post_categories_str = '';
				$post_categories_classes = '';
				for ($i = 0; $i < count($post_categories); $i++) {
					$post_categories_str .= '<a class="cat_link" href="' . $post_categories[$i]['link'] . '">'
						. $post_categories[$i]['name'] 
						. ($i < count($post_categories)-1 ? ',' : '')
						. '</a> ';
					$post_categories_classes .= ($post_categories_classes ? ' ' : '') . 'category_'.$post_categories[$i]['term_id'];
				}

				$post_tags_str = '';
				if (($post_tags = get_the_tags()) != 0) {
					$tag_number=0;
					foreach ($post_tags as $tag) {
						$tag_number++;
						$post_tags_str .= '<a class="tag_link" href="' . get_tag_link($tag->term_id) . '">' . $tag->name . ($tag_number==count($post_tags) ? '' : ',') . '</a> ';
					}
				}
				
				require(get_template_directory() . '/template-blog-'.(in_array($page_style, array('p2', 'p3', 'p4')) ? 'p2' : $page_style).'.php');

			endwhile; 
			
			if (!$post_number) { 
				if (is_404()) {
			?>
				<article class="post_format_standard page_404">
                    <div class="title_area">
                        <h1 class="post_title"><?php _e( '404', 'wpspace' ); ?></h1>
                    </div>
					<div class="post_content">
                        <h2 class="post_subtitle"><?php _e( 'Oops, This Page Could Not Be Found!', 'wpspace' ); ?></h2>
						<div class="text">
							<div class="not_found"><?php _e( "Can't find what you need? Take a moment and do a search below!", 'wpspace' ); ?></div>
							<form class="searchform" action="<?php echo home_url(); ?>" method="get"><input class="field field_search" type="search" placeholder="<?php _e('Search &hellip;', 'wpspace'); ?>" value="" name="s"><a href="#" class="search_form_link"><span class="icon-search"></span></a></form>
							<a href="<?php echo get_site_url(); ?>" class="go_home sc_button sc_button_style_grey"><?php _e( 'Or start from our homepage', 'wpspace' ); ?></a>
						</div>
                    </div>
                </article>
			<?php
				} else if (is_search()) { 
			?>
				<article class="post_format_standard page_no_results">
                    <div class="title_area">
                        <h2 class="post_title"><?php echo sprintf( __( 'Search Results for: &laquo;%s&raquo;', 'wpspace' ), get_search_query() ); ?></h2>
                    </div>
					<div class="post_content">
						<div class="text">
							<p class="search_no_results">
								<?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'wpspace' ); ?>
							</p>
						</div>
                    </div>
                </article>
			<?php
				} else { 
			?>
				<article class="post_format_standard page_no_results">
                    <div class="title_area">
                        <h2 class="post_title"><?php echo sprintf( __( 'No posts found', 'wpspace' ), get_search_query() ); ?></h2>
                    </div>
					<div class="post_content">
						<div class="text">
							<p class="search_no_results">
								<?php _e( 'Sorry, but nothing matched your search terms.', 'wpspace' ); ?>
							</p>
						</div>
                    </div>
                </article>
			<?php
				}
			}

			
		?>
        </div><!--FIM DIV CONTENT NOTICIAS-->
            
            
            
        <div id="contet_sobre" class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <span class="titulo">sobre nós</span>
            <div class="separacao"></div>
            <div class="barra"></div>
            <div class="separacao2"></div>
            <?php query_posts('category_name=sobre-nos&showposts=4'); ?>
            	<?php while ( have_posts() ) : the_post();  
				if ($post->post_date > date('Y-m-d 23:59:59') && $post->post_date_gmt > date('Y-m-d 23:59:59')) continue;

				$post_number++;
				
				
				if(has_post_thumbnail($post->ID)): 				
					$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'single-post-thumbnail');
                endif;
				
				$post_image = $image[0];
				
				//print_r($post_image);

				$post_id = get_the_ID();
				$post_protected = post_password_required();
				$post_format = get_post_format();
				if (empty($post_format)) $post_format = 'standard';
				$post_link = get_permalink();
				$post_comments_link = $counters=='comments' ? get_comments_link( $post_id ) : $post_link;
				$post_date = get_the_date();
				$post_comments = get_comments_number();
				$post_views = getPostViews($post_id);
				$post_author = get_the_author();
				$post_author_id = get_the_author_meta('ID');
				$post_author_url = get_author_posts_url($post_author_id, '');
				$post_custom_options = get_post_meta($post_id, 'post_custom_options', true);
				$post_icon = isset($post_custom_options['page_icon']) ? $post_custom_options['page_icon'] : get_post_meta($post_id, 'page_icon', true);
				if ($post_icon=='' || $post_icon=='default') $post_icon = getPostFormatIcon($post_format);
				
				$post_thumb = getResizedImageTag($post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
				$post_attachment = wp_get_attachment_url(get_post_thumbnail_id($post_id));

				$post_title = getPostTitle();
				$post_excerpt = trim(chop($post->post_excerpt));	//getPostDescription();
				$post_descr = getPostDescription();					//get_the_excerpt();
				$post_content = get_the_content(__('<span class="readmore">Read more</span>', 'wpspace'));
				if ($post_format == 'gallery') {
					if (get_custom_option('blog_substitute_gallery')=='yes') {
						if ($mode == 'full') {
							$post_content = substituteGallery($post_content, $post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
							$post_excerpt = substituteGallery($post_excerpt, $post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
						} else
							$post_descr = substituteGallery($post_descr,     $post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
					}
				} else if ($post_format == 'video') {
					if (get_custom_option('blog_substitute_video')=='yes') {
						if ($mode == 'full') {
							$post_content = substituteVideo($post_content, $thumb_size[$page_style]['w'][$thumb_idx], $thumb_size[$page_style]['h'][$thumb_idx]);
							$post_excerpt = substituteVideo($post_excerpt, $thumb_size[$page_style]['w'][$thumb_idx], $thumb_size[$page_style]['h'][$thumb_idx]);
						} else
							$post_descr   = substituteVideo($post_descr,   $thumb_size[$page_style]['w'][$thumb_idx], $thumb_size[$page_style]['h'][$thumb_idx]);
					}
				} else if ($post_format == 'audio') {
					if (get_custom_option('blog_substitute_audio')=='yes') {
						if ($mode == 'full') {
							$post_content = substituteAudio($post_content);
							$post_excerpt = substituteAudio($post_excerpt);
						} else
							$post_descr   = substituteAudio($post_descr);
					}
				}
				$post_content = apply_filters('the_content', $post_content);
				$post_content = decorateMoreLink(str_replace(']]>', ']]&gt;', $post_content));

				$post_categories = getCategoriesByPostId($post_id);
				$post_categories_str = '';
				$post_categories_classes = '';
				for ($i = 0; $i < count($post_categories); $i++) {
					$post_categories_str .= '<a class="cat_link" href="' . $post_categories[$i]['link'] . '">'
						. $post_categories[$i]['name'] 
						. ($i < count($post_categories)-1 ? ',' : '')
						. '</a> ';
					$post_categories_classes .= ($post_categories_classes ? ' ' : '') . 'category_'.$post_categories[$i]['term_id'];
				}

				$post_tags_str = '';
				if (($post_tags = get_the_tags()) != 0) {
					$tag_number=0;
					foreach ($post_tags as $tag) {
						$tag_number++;
						$post_tags_str .= '<a class="tag_link" href="' . get_tag_link($tag->term_id) . '">' . $tag->name . ($tag_number==count($post_tags) ? '' : ',') . '</a> ';
					}
				}
				
				require(get_template_directory() . '/template-blog-'.(in_array($page_style, array('p2', 'p3', 'p4')) ? 'p2' : $page_style).'.php');

			endwhile; 
			
			if (!$post_number) { 
				if (is_404()) {
			?>
				<article class="post_format_standard page_404">
                    <div class="title_area">
                        <h1 class="post_title"><?php _e( '404', 'wpspace' ); ?></h1>
                    </div>
					<div class="post_content">
                        <h2 class="post_subtitle"><?php _e( 'Oops, This Page Could Not Be Found!', 'wpspace' ); ?></h2>
						<div class="text">
							<div class="not_found"><?php _e( "Can't find what you need? Take a moment and do a search below!", 'wpspace' ); ?></div>
							<form class="searchform" action="<?php echo home_url(); ?>" method="get"><input class="field field_search" type="search" placeholder="<?php _e('Search &hellip;', 'wpspace'); ?>" value="" name="s"><a href="#" class="search_form_link"><span class="icon-search"></span></a></form>
							<a href="<?php echo get_site_url(); ?>" class="go_home sc_button sc_button_style_grey"><?php _e( 'Or start from our homepage', 'wpspace' ); ?></a>
						</div>
                    </div>
                </article>
			<?php
				} else if (is_search()) { 
			?>
				<article class="post_format_standard page_no_results">
                    <div class="title_area">
                        <h2 class="post_title"><?php echo sprintf( __( 'Search Results for: &laquo;%s&raquo;', 'wpspace' ), get_search_query() ); ?></h2>
                    </div>
					<div class="post_content">
						<div class="text">
							<p class="search_no_results">
								<?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'wpspace' ); ?>
							</p>
						</div>
                    </div>
                </article>
			<?php
				} else { 
			?>
				<article class="post_format_standard page_no_results">
                    <div class="title_area">
                        <h2 class="post_title"><?php echo sprintf( __( 'No posts found', 'wpspace' ), get_search_query() ); ?></h2>
                    </div>
					<div class="post_content">
						<div class="text">
							<p class="search_no_results">
								<?php _e( 'Sorry, but nothing matched your search terms.', 'wpspace' ); ?>
							</p>
						</div>
                    </div>
                </article>
			<?php
				}
			}

			
		?>
            
        </div><!--FIM DIV CONTENT SOBRE-->
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        <div id="contet_depoimento" class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <span class="titulo">depoimentos</span>
            <div class="separacao"></div>
            <div class="barra"></div>
            <div class="separacao2"></div>
            <?php query_posts('category_name=depoimento&showposts=1'); ?>
            	<?php while ( have_posts() ) : the_post();  
				if ($post->post_date > date('Y-m-d 23:59:59') && $post->post_date_gmt > date('Y-m-d 23:59:59')) continue;

				$post_number++;
				
				
				if(has_post_thumbnail($post->ID)): 				
					$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'single-post-thumbnail');
                endif;
				
				$post_image = $image[0];
				
				//print_r($post_image);

				$post_id = get_the_ID();
				$post_protected = post_password_required();
				$post_format = get_post_format();
				if (empty($post_format)) $post_format = 'standard';
				$post_link = get_permalink();
				$post_comments_link = $counters=='comments' ? get_comments_link( $post_id ) : $post_link;
				$post_date = get_the_date();
				$post_comments = get_comments_number();
				$post_views = getPostViews($post_id);
				$post_author = get_the_author();
				$post_author_id = get_the_author_meta('ID');
				$post_author_url = get_author_posts_url($post_author_id, '');
				$post_custom_options = get_post_meta($post_id, 'post_custom_options', true);
				$post_icon = isset($post_custom_options['page_icon']) ? $post_custom_options['page_icon'] : get_post_meta($post_id, 'page_icon', true);
				if ($post_icon=='' || $post_icon=='default') $post_icon = getPostFormatIcon($post_format);
				
				$post_thumb = getResizedImageTag($post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
				$post_attachment = wp_get_attachment_url(get_post_thumbnail_id($post_id));

				$post_title = getPostTitle();
				$post_excerpt = trim(chop($post->post_excerpt));	//getPostDescription();
				$post_descr = getPostDescription();					//get_the_excerpt();
				$post_content = get_the_content(__('<span class="readmore">Read more</span>', 'wpspace'));
				if ($post_format == 'gallery') {
					if (get_custom_option('blog_substitute_gallery')=='yes') {
						if ($mode == 'full') {
							$post_content = substituteGallery($post_content, $post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
							$post_excerpt = substituteGallery($post_excerpt, $post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
						} else
							$post_descr = substituteGallery($post_descr,     $post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx]*$mult);
					}
				} else if ($post_format == 'video') {
					if (get_custom_option('blog_substitute_video')=='yes') {
						if ($mode == 'full') {
							$post_content = substituteVideo($post_content, $thumb_size[$page_style]['w'][$thumb_idx], $thumb_size[$page_style]['h'][$thumb_idx]);
							$post_excerpt = substituteVideo($post_excerpt, $thumb_size[$page_style]['w'][$thumb_idx], $thumb_size[$page_style]['h'][$thumb_idx]);
						} else
							$post_descr   = substituteVideo($post_descr,   $thumb_size[$page_style]['w'][$thumb_idx], $thumb_size[$page_style]['h'][$thumb_idx]);
					}
				} else if ($post_format == 'audio') {
					if (get_custom_option('blog_substitute_audio')=='yes') {
						if ($mode == 'full') {
							$post_content = substituteAudio($post_content);
							$post_excerpt = substituteAudio($post_excerpt);
						} else
							$post_descr   = substituteAudio($post_descr);
					}
				}
				$post_content = apply_filters('the_content', $post_content);
				$post_content = decorateMoreLink(str_replace(']]>', ']]&gt;', $post_content));

				$post_categories = getCategoriesByPostId($post_id);
				$post_categories_str = '';
				$post_categories_classes = '';
				for ($i = 0; $i < count($post_categories); $i++) {
					$post_categories_str .= '<a class="cat_link" href="' . $post_categories[$i]['link'] . '">'
						. $post_categories[$i]['name'] 
						. ($i < count($post_categories)-1 ? ',' : '')
						. '</a> ';
					$post_categories_classes .= ($post_categories_classes ? ' ' : '') . 'category_'.$post_categories[$i]['term_id'];
				}

				$post_tags_str = '';
				if (($post_tags = get_the_tags()) != 0) {
					$tag_number=0;
					foreach ($post_tags as $tag) {
						$tag_number++;
						$post_tags_str .= '<a class="tag_link" href="' . get_tag_link($tag->term_id) . '">' . $tag->name . ($tag_number==count($post_tags) ? '' : ',') . '</a> ';
					}
				}
				
				require(get_template_directory() . '/template-blog-'.(in_array($page_style, array('p2', 'p3', 'p4')) ? 'p2' : $page_style).'.php');

			endwhile; 
			
			if (!$post_number) { 
				if (is_404()) {
			?>
				<article class="post_format_standard page_404">
                    <div class="title_area">
                        <h1 class="post_title"><?php _e( '404', 'wpspace' ); ?></h1>
                    </div>
					<div class="post_content">
                        <h2 class="post_subtitle"><?php _e( 'Oops, This Page Could Not Be Found!', 'wpspace' ); ?></h2>
						<div class="text">
							<div class="not_found"><?php _e( "Can't find what you need? Take a moment and do a search below!", 'wpspace' ); ?></div>
							<form class="searchform" action="<?php echo home_url(); ?>" method="get"><input class="field field_search" type="search" placeholder="<?php _e('Search &hellip;', 'wpspace'); ?>" value="" name="s"><a href="#" class="search_form_link"><span class="icon-search"></span></a></form>
							<a href="<?php echo get_site_url(); ?>" class="go_home sc_button sc_button_style_grey"><?php _e( 'Or start from our homepage', 'wpspace' ); ?></a>
						</div>
                    </div>
                </article>
			<?php
				} else if (is_search()) { 
			?>
				<article class="post_format_standard page_no_results">
                    <div class="title_area">
                        <h2 class="post_title"><?php echo sprintf( __( 'Search Results for: &laquo;%s&raquo;', 'wpspace' ), get_search_query() ); ?></h2>
                    </div>
					<div class="post_content">
						<div class="text">
							<p class="search_no_results">
								<?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'wpspace' ); ?>
							</p>
						</div>
                    </div>
                </article>
			<?php
				} else { 
			?>
				<article class="post_format_standard page_no_results">
                    <div class="title_area">
                        <h2 class="post_title"><?php echo sprintf( __( 'No posts found', 'wpspace' ), get_search_query() ); ?></h2>
                    </div>
					<div class="post_content">
						<div class="text">
							<p class="search_no_results">
								<?php _e( 'Sorry, but nothing matched your search terms.', 'wpspace' ); ?>
							</p>
						</div>
                    </div>
                </article>
			<?php
				}
			}

			
		?>
        </div><!--FIM DIV CONTENT DEPOIMENTO-->    
            
            
            
            
        <?php } ?>
            
		</div><!-- #content -->

		<?php //get_sidebar(); ?>

	</div><!-- #main_inner -->

<?php get_footer(); ?>
