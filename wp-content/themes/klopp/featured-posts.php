<?php if ( get_theme_mod('klopp_featposts_enable') && is_home() ) : ?>

<div class="featposts container">
		<div class="section-title">
			<span><?php echo esc_html(get_theme_mod('klopp_featposts_title', __('Featured Articles','klopp'))); ?></span>
		</div>
	
	<?php if ( have_posts() ) : ?>
	
				<?php /* Start the Loop */  ?>
				<?php
	    		$args = array( 'posts_per_page' => (get_theme_mod('klopp_featposts_rows') * 4), 'category' => get_theme_mod('klopp_featposts_cat') );
				$lastposts = get_posts( $args );
				foreach ( $lastposts as $post ) :
				  setup_postdata( $post ); ?> 	
						
				<article id="post-<?php the_ID(); ?>" <?php post_class('item col-md-3 col-xs-6 col-sm-4'); ?>>
					<div class="item-container">
							<?php if (has_post_thumbnail()) : ?>	
								<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('klopp-featpost-thumb'); ?></a>
							<?php else : ?>
								<a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>"><img src="<?php echo get_template_directory_uri()."/assets/images/placeholder2.jpg"; ?>"></a>
	
							<?php endif; ?>
							
							<a class="post-title" href="<?php the_permalink() ?>"><?php echo the_title(); ?></a>
							
					</div>		
						
				</article><!-- #post-## -->
					
				<?php endforeach; 
				wp_reset_postdata();
			 endif; ?>

</div>

<?php endif; ?>