<?php
/**
 * The template for displaying the footer.
 *
 * @package norma
 */
?>
    </div><!-- #main -->
	
	<footer id="footer" class="site_footer" role="contentinfo">
		
        
        <div id="footer_sidebar">
            <div id="footer_corpo">
                <div class="conteudo container">
                    <div id="footer_post" class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                        <span class="titulo">posts recentes</span>
                        <div class="separacao"></div>
                        <div class="barra"></div>
                        <div class="separacao"></div>
                        
                        <?php
                        query_posts('showposts=2'); 
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
							?>
							<div class="footer_post_item">
								<a href="<?php the_permalink() ?>">
									<img src="<?php echo $post_image; ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>" >
									<span class="titulo"><?php the_title(); ?></span>
									<span class="texto"><?php the_time('F j, Y') ?></span>
								</a>    
							</div>
							<?php
						endwhile; 
						?>
                        
                    </div><!--FIM DIV FOOTER POST-->
                    <div id="footer_fale" class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                        <span class="titulo">fale conosco</span>
                        <div class="separacao"></div>
                        <div class="barra"></div>
                        <div class="separacao"></div>
                        <div id="footer_fale_item"><div class="sc_contact_form">

                        <form action="wp-admin/admin-ajax.php" >
                            <input type="text" value="" id="sc_contact_form_username" name="username" placeholder="Seu nome*" />
                            <input type="text" id="sc_contact_form_email" name="email" placeholder="Seu email*" />
                            <textarea id="sc_contact_form_message" name="message" placeholder="Mensagem*" rows="3" ></textarea>
                            <input type="button" name="enviar" value="Enviar" class="btn" />
                            <div class="result sc_infobox"></div>
                        </form>
                        <script type="text/javascript">
							jQuery(document).ready(function() {
								jQuery(".footer_fale_item .enter").click(function(e){
									userSubmitForm(jQuery(this).parents("form"), "wp-admin/admin-ajax.php", "4757f4d62e");
									e.preventDefault();
									return false;
								});
							});
						</script>

                        </div></div>
                    </div><!--FIM DIV FOOTER FALE-->
                    <div id="footer_twitter" class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                        <span class="titulo">últimas no twitter</span>
                        <div class="separacao"></div>
                        <div class="barra"></div>
                        <div class="separacao"></div>
                        <div class="footer_twitter_item">
                        	<?php echo add_shortcode('ultimos_tweets','mostra_tweets'); ?>
                            
                            <!--<a href="">
                                <img src="<?php //echo get_template_directory_uri(); ?>/assets/img/twitter.png"  alt="" title="" />
                                <span class="titulo">Lorem ipsum: Dolor consectetur sed do eiusmod tempor incidendunt.</span>
                                <span class="texto">http://wsaasdfe/elit/sed</span>
                                <span class="subtexto">about an your ago</span>
                            </a>-->
                        </div><!--FIM FOOTER TWITTER ITEM-->
                        
                    </div><!--FIM DIV FOOTER TWITTER-->
                    <div id="footer_facebook" class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                        <span class="titulo">acompanhe pelo facebook</span>
                        <div class="separacao"></div>
                        <div class="barra"></div>
                        <div class="separacao"></div>
                        <div class="fb-like-box" data-href="https://www.facebook.com/FacebookDevelopers" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
                        <?php //echo facebook_likes('FacebookDevelopers');?>
                        <!--<div id="footer_facebook_item">
                            <img src="http://placehold.it/60x60" title="" alt="" >
                            <img src="http://placehold.it/60x60" title="" alt="" >
                            <img src="http://placehold.it/60x60" title="" alt="" >
                            <img src="http://placehold.it/60x60" title="" alt="" >
                            <img src="http://placehold.it/60x60" title="" alt="" >
                            <img src="http://placehold.it/60x60" title="" alt="" >
                            <img src="http://placehold.it/60x60" title="" alt="" >
                            <img src="http://placehold.it/60x60" title="" alt="" >
                        </div><!--FIM DIV FOOTER FACEBOOK ITEM-->
                    </div><!--FIM DIV FOOTER FACEBOOK-->
                </div>
            </div><!--FIM DIV FOOTER CORPO-->
            
            <div id="footer_menu">
            	<div class="conteudo container">
                    <span class="titulo">Acesso rápido</span>
                    	
                            <span class="item"><nav id="menuinferior_area" class="menuinferior_area" role="navigation">
                                <?php
                                    wp_nav_menu(array(
                                        'menu'              => '',
                                        'container'         => '',
                                        'container_class'   => '',
                                        'container_id'      => '',
                                        'items_wrap'      	=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                        'menu_class'        => '',
                                        'menu_id'           => 'menu_inferior',
                                        'echo'              => true,
                                        'fallback_cb'       => '',
                                        'before'            => '',
                                        'after'             => '',
                                        'link_before'       => '',
                                        'link_after'        => '',
                                        'depth'             => 11,
                                        'theme_location'    => 'menu_inferior'
                                    ));
                                ?>			
                            </nav></span>
                
                    
                  
                    
                    
                    
                </div>
            </div><!--FIM DIV FOOTER MENU-->
        </div>

		<div id="footer_copyright">
        	<div id="footer_copyright_desenvolvido">
            	<a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/img/agencia_kcm.png" title="" alt="" /></a>
            </div>
			<div id="footer_copyright_inner">
				<?php
					echo get_theme_option('footer_copyright')
				?>
			</div>
            
		</div>
	</footer>

</div><!-- #page -->

<a href="#" id="toTop"></a>

<div id="popup_login" class="popup_form">
	<div class="popup_title">
    	<span class="popup_arrow"></span>
        <a href="#" class="popup_close">x</a>
	</div>
    <div class="popup_body">
        <form action="<?php echo wp_login_url(); ?>" method="post" name="login_form">
			<input type="hidden" name="redirect_to" value="<?php echo home_url(); ?>"/>
			<div class="popup_field"><input type="text" name="log" id="log" placeholder="<?php _e('Login*', 'wpspace'); ?>" /></div>
			<div class="popup_field"><input type="password" name="pwd" id="pwd" placeholder="<?php _e('Password*', 'wpspace'); ?>" /></div>
			<div class="popup_field popup_button"><a href="#"><?php _e('Login', 'wpspace'); ?></a></div>
			<!--
			<div class="popup_field">
            	<input name="rememberme" id="rememberme" type="checkbox" value="forever">
                <label for="rememberme"><?php _e('Remember me', 'wpspace'); ?></label>
            </div>
            -->
			<div class="popup_field forgot_password">
				<?php _e('Forgot password?', 'wpspace'); ?>
            	<br /><a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>"><?php _e('Click here &raquo;', 'wpspace'); ?></a>
            </div>
            <div class="result sc_infobox"></div>
		</form>
    </div>
</div>

<div id="popup_register" class="popup_form">
	<div class="popup_title">
    	<span class="popup_arrow"></span>
        <a href="#" class="popup_close">x</a>
    </div>
    <div class="popup_body">
        <form action="#" method="post" name="register_form">
			<input type="hidden" name="redirect_to" value="<?php echo home_url(); ?>"/>
			<div class="popup_field"><input type="text" name="registration_username" id="registration_username" placeholder="<?php _e('Your name*', 'wpspace'); ?>" /></div>
			<div class="popup_field"><input type="text" name="registration_email" id="registration_email" placeholder="<?php _e('Your email*', 'wpspace'); ?>" /></div>
			<div class="popup_field"><input type="password" name="registration_pwd" id="registration_pwd" placeholder="<?php _e('Your Password*', 'wpspace'); ?>" /></div>
			<div class="popup_field"><input type="password" name="registration_pwd2" id="registration_pwd2" placeholder="<?php _e('Confirm Password*', 'wpspace'); ?>" /></div>
			<div class="popup_field popup_button"><a href="#"><?php _e('Register', 'wpspace'); ?></a></div>
            <div class="result sc_infobox"></div>
		</form>
    </div>
</div>

<?php
if (get_theme_option('theme_customizer') == 'yes') {
	$theme_color = get_custom_option('theme_color');
	$body_style = get_custom_option('body_style');
	$bg_color = get_custom_option('bg_color');
	$bg_pattern = get_custom_option('bg_pattern');
	$bg_image = get_custom_option('bg_image');
?>
	<div id="custom_options">
		<div class="co_header">
			<a href="#" id="co_toggle" class="icon-cog"></a>
            <div class="co_title_wrapper"><h4 class="co_title"><?php _e('Choose Your Style', 'wpspace'); ?></h4></div>
		</div>
		<div class="co_options">
			<form name="co_form">
				<input type="hidden" id="co_site_url" name="co_site_url" value="<?php echo 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>" />
				<div class="co_form_row first">
					<input type="hidden" name="co_theme_color" value="<?php echo $theme_color; ?>" />
					<span class="co_label"><?php _e('Basic color:', 'wpspace'); ?></span>
                    <div id="co_theme_color" class="colorSelector"><div></div></div>
                </div>
                <div class="co_form_row">
					<input type="hidden" name="co_body_style" value="<?php echo $body_style; ?>" />
					<span class="co_label"><?php _e('Background:', 'wpspace'); ?></span>
                    <div class="co_switch_box">
                        <a href="#" class="stretched"><?php _e('Stretched', 'wpspace'); ?></a>
                        <div class="switcher"><a href="#"></a></div>
                        <a href="#" class="boxed"><?php _e('Boxed', 'wpspace'); ?></a>
                    </div>
                    <?php if ($body_style == 'boxed') { ?>
                    <script type="text/javascript">
						jQuery(document).ready(function() {
							var box = jQuery('#custom_options .switcher');
							var switcher = box.find('a').eq(0);
							var right = box.width() - switcher.width() + 2;
							switcher.css({left: right});
						});
                    </script>
                    <?php } ?>
                </div>
				<?php if (false) { ?>
                <div class="co_form_row">
					<input type="hidden" name="co_bg_color" value="<?php echo $bg_color; ?>" />
					<span class="co_label"><?php _e('Background color:', 'wpspace'); ?></span>
                    <div id="co_bg_color" class="colorSelector"><div></div></div>
                </div>
                <?php } ?>
				<div class="co_form_row">
					<input type="hidden" name="co_bg_pattern" value="<?php echo $bg_pattern; ?>" />
					<span class="co_label"><?php _e('Background pattern:', 'wpspace'); ?></span>
                    <div id="co_bg_pattern_list">
                    	<a href="#" id="pattern_1" class="co_pattern_wrapper<?php echo $bg_pattern==1 ? ' current' : '' ; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/bg/pattern_1.png" /></a>
                    	<a href="#" id="pattern_2" class="co_pattern_wrapper<?php echo $bg_pattern==2 ? ' current' : '' ; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/bg/pattern_2.png" /></a>
                    	<a href="#" id="pattern_3" class="co_pattern_wrapper<?php echo $bg_pattern==3 ? ' current' : '' ; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/bg/pattern_3.png" /></a>
                    	<a href="#" id="pattern_4" class="co_pattern_wrapper<?php echo $bg_pattern==4 ? ' current' : '' ; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/bg/pattern_4.png" /></a>
                    	<a href="#" id="pattern_5" class="co_pattern_wrapper<?php echo $bg_pattern==5 ? ' current' : '' ; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/bg/pattern_5.png" /></a>
					</div>
                </div>
				<div class="co_form_row">
					<input type="hidden" name="co_bg_image" value="<?php echo $bg_image; ?>" />
					<span class="co_label"><?php _e('Background image:', 'wpspace'); ?></span>
                    <div id="co_bg_images_list">
                    	<a href="#" id="image_1" class="co_image_wrapper<?php echo $bg_image==1 ? ' current' : '' ; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/bg/image_1.jpg" /></a>
                    	<a href="#" id="image_2" class="co_image_wrapper<?php echo $bg_image==2 ? ' current' : '' ; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/bg/image_2.jpg" /></a>
                    	<a href="#" id="image_3" class="co_image_wrapper<?php echo $bg_image==3 ? ' current' : '' ; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/bg/image_3.jpg" /></a>
					</div>
                </div>
	        </form>
			<script type="text/javascript" language="javascript">
				jQuery(document).ready(function(){
					// Theme & Background color
					jQuery('#co_theme_color div').css('backgroundColor', '<?php echo $theme_color; ?>');
					//jQuery('#co_bg_color div').css('backgroundColor', '<?php echo $bg_color; ?>');    
                });
            </script>
        </div>
	</div>
<?php
}

?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/bootstrap.min.js" ></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/script.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
	<?php
	// Reject old browsers
	global $jreject;
	if ($jreject) {
	?>
		jQuery.reject({
			reject : {
				all: false, // Nothing blocked
				msie5: true, msie6: true, msie7: true, msie8: true // Covers MSIE 5-8
				/*
				 * Possibilities are endless...
				 *
				 * // MSIE Flags (Global, 5-8)
				 * msie, msie5, msie6, msie7, msie8,
				 * // Firefox Flags (Global, 1-3)
				 * firefox, firefox1, firefox2, firefox3,
				 * // Konqueror Flags (Global, 1-3)
				 * konqueror, konqueror1, konqueror2, konqueror3,
				 * // Chrome Flags (Global, 1-4)
				 * chrome, chrome1, chrome2, chrome3, chrome4,
				 * // Safari Flags (Global, 1-4)
				 * safari, safari2, safari3, safari4,
				 * // Opera Flags (Global, 7-10)
				 * opera, opera7, opera8, opera9, opera10,
				 * // Rendering Engines (Gecko, Webkit, Trident, KHTML, Presto)
				 * gecko, webkit, trident, khtml, presto,
				 * // Operating Systems (Win, Mac, Linux, Solaris, iPhone)
				 * win, mac, linux, solaris, iphone,
				 * unknown // Unknown covers everything else
				 */
			},
			imagePath: "<?php echo get_template_directory_uri(); ?>/js/jreject/images/",
			header: "<?php _e('Your browser is out of date', 'wpspace'); ?>", // Header Text
			paragraph1: "<?php _e('You are currently using an unsupported browser', 'wpspace'); ?>", // Paragraph 1
			paragraph2: "<?php _e('Please install one of the many optional browsers below to proceed', 'wpspace'); ?>",
			closeMessage: "<?php _e('Close this window at your own demise!', 'wpspace'); ?>" // Message below close window link
		});
	<?php 
	} 
	
	if (get_theme_option('menu_position')=='fixed') {
		// Menu fixed position
	?>
		var menu_offset = jQuery('#header_middle').offset().top;
		jQuery(window).scroll(function() {
			var s = jQuery(this).scrollTop();
			if (s >= menu_offset) {
				jQuery('body').addClass('menu_fixed');
			} else {
				jQuery('body').removeClass('menu_fixed');
			}
		});
	<?php } ?>
});


// Javascript String constants for translation
GLOBAL_ERROR_TEXT	= "<?php _e('Global error text', 'wspace'); ?>";
NAME_EMPTY 			= "<?php _e('The name can\'t be empty', 'wspace'); ?>";
NAME_LONG 			= "<?php _e('Too long name', 'wspace'); ?>";
EMAIL_EMPTY 		= "<?php _e('Too short (or empty) email address', 'wspace'); ?>";
EMAIL_LONG 			= "<?php _e('Too long email address', 'wspace'); ?>";
EMAIL_NOT_VALID 	= "<?php _e('Invalid email address', 'wspace'); ?>";
MESSAGE_EMPTY 		= "<?php _e('The message text can\'t be empty', 'wspace'); ?>";
MESSAGE_LONG 		= "<?php _e('Too long message text', 'wspace'); ?>";
SEND_COMPLETE 		= "<?php _e("Send message complete!", 'wspace'); ?>";
SEND_ERROR 			= "<?php _e("Transmit failed!", 'wspace'); ?>";
GEOCODE_ERROR 		= "<?php _e("Geocode was not successful for the following reason:", 'wspace'); ?>";
LOGIN_EMPTY			= "<?php _e("The Login field can't be empty", 'wpspace'); ?>";
LOGIN_LONG			= "<?php _e('Too long login field', 'wpspace'); ?>";
PASSWORD_EMPTY		= "<?php _e("The password can't be empty and shorter then 5 characters", 'wpspace'); ?>";
PASSWORD_LONG		= "<?php _e('Too long password', 'wpspace'); ?>";
PASSWORD_NOT_EQUAL	= "<?php _e('The passwords in both fields are not equal', 'wpspace'); ?>";
REGISTRATION_SUCCESS= "<?php _e('Registration success! Please log in!', 'wpspace'); ?>";
REGISTRATION_FAILED	= "<?php _e('Registration failed!', 'wpspace'); ?>";

// AJAX parameters
<?php global $ajax_url, $ajax_nonce; ?>
ajax_url = "<?php echo $ajax_url; ?>";
ajax_nonce = "<?php echo $ajax_nonce; ?>";
</script>


<?php wp_footer(); ?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=205159832983961&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

</body>
</html>