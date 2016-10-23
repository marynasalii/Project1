<?php
/**
 * @package Klopp
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('grid klopp col-md-12'); ?>>


		<div class="featured-thumb col-md-6 col-sm-6">
			<?php if (has_post_thumbnail()) : ?>	
				<a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_post_thumbnail('klopp-thumb'); ?></a>
			<?php else: ?>
				<a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><img src="<?php echo get_template_directory_uri()."/assets/images/placeholder2.jpg"; ?>"></a>
			<?php endif; ?>
			<div class="postedon"><?php klopp_posted_on_date(); ?></div>
		</div><!--.featured-thumb-->
		
		<div class="out-thumb col-md-6 col-sm-6">
			<header class="entry-header">
					<h1 class="entry-title title-font"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
					
					<span class="readmore"><a class="hvr-shutter-in-vertical" href="<?php the_permalink() ?>"><?php _e('Read More','klopp'); ?></a></span>
				</header><!-- .entry-header -->
		</div>
		
				
		
</article><!-- #post-## -->