<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>

 *
 * @package klopp
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses klopp_header_style()
 * @uses klopp_admin_header_style()
 * @uses klopp_admin_header_image()
 */
function klopp_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'klopp_custom_header_args', array(
		'default-image'          => get_template_directory_uri().'/assets/images/header.jpg',
		'default-text-color'     => '#ffffff',
		'width'  				 => 1440,
		'height'				 => 380,
		'flex-height'            => true,
		'wp-head-callback'       => 'klopp_header_style',
		'admin-head-callback'    => 'klopp_admin_header_style',
		'admin-preview-callback' => 'klopp_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'klopp_custom_header_setup' );

if ( ! function_exists( 'klopp_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see klopp_custom_header_setup().
 */
function klopp_header_style() {
	?>
	<style>
	#masthead {
			background-image: url(<?php header_image(); ?>);
			background-size: <?php echo esc_html(get_theme_mod('klopp_himg_style','cover')); ?>;
			background-position-x: <?php echo esc_html(get_theme_mod('klopp_himg_align','center')); ?>;
			background-repeat: <?php echo  get_theme_mod('klopp_himg_repeat') ? "repeat" : "no-repeat" ?>;
		}
	</style>	
	<?php
}
endif; // klopp_header_style

if ( ! function_exists( 'klopp_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see klopp_custom_header_setup().
 */
function klopp_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg h1,
		#desc {
		}
		#headimg h1 {
		}
		#headimg h1 a {
		}
		#desc {
		}
		#headimg img {
		}
	</style>
<?php
}
endif; // klopp_admin_header_style

if ( ! function_exists( 'klopp_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see klopp_custom_header_setup().
 */
function klopp_admin_header_image() {
	$style = sprintf( ' style="color:#%s;"', get_header_textcolor() );
?>
	<div id="headimg">
		<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="displaying-header-text" id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
	</div>
<?php
}
endif; // klopp_admin_header_image