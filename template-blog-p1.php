<?php
/*
 * The template for displaying one article of blog streampage with style "Blog 3"
 * 
 * @package norma
*/
?>
<article <?php post_class(($post_categories_classes ? $post_categories_classes.' ' : '').'post_format_'.$post_format.' '.($post_number%2==0 ? 'even' : 'odd') . ($post_number==0 ? ' first' : '') . ($post_number==$per_page? ' last' : '')); ?>>
<?php 
if ($post_protected) { 
?>
	<div class="post_content"><?php echo $post_descr; ?></div>
<?php 
} else {
	
	$no_thumb = true;
	
	if ($post_format != 'quote') {
		// If post have thumbnail - show it
		if ( $post_thumb ) {
			$no_thumb = false;
		?>
			<div class="image_wrapper">
				<?php echo $post_thumb; ?>
                <span class="image_overlay"></span>
                <a href="<?php echo $post_link; ?>" class="image_link"><span class="icon-link"></span></a>
                <a href="<?php echo $post_attachment; ?>" class="image_zoom prettyPhoto"><span class="icon-search"></span></a>
			</div>
		<?php
		}
	
		// Post title
		?>	
		<div class="title_area<?php echo $no_thumb ? ' without_thumb' : ''; ?>">
			<h2 class="post_title"><a href="<?php echo $post_link; ?>"><?php echo $post_title; ?></a></h2>
			<?php if ($counters!='none') { ?>
			<span class="post_views"><a href="<?php echo $post_comments_link; ?>"><span class="icon-<?php echo $counters=='comments' ? 'comment' : 'eye'; ?>"></span><span class="views_number"><?php echo $counters=='comments' ? $post_comments : $post_views; ?></span></a></span>
			<?php } ?>
			<?php if ($post_categories_str != '') { ?>
				<span class="post_categories">
					<?php echo $post_categories_str; ?>
				</span>
			<?php } // post_categories ?>
		</div>
	<?php
	}
	?>

		<div class="post_content">
			<?php 
			if (get_custom_option('blog_mode')=='short') {
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
					echo $post_content; 
				}
			}
			?>
		</div>
<?php
}
?>
</article>
