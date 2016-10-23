<?php
/**
 * klopp Theme Customizer
 *
 * @package klopp
 */
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function klopp_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	
	
	//Logo Settings
	$wp_customize->add_setting( 'klopp_logo_resize' , array(
	    'default'     => 100,
	    'sanitize_callback' => 'klopp_sanitize_positive_number',
	) );
	$wp_customize->add_control(
	        'klopp_logo_resize',
	        array(
	            'label' => __('Resize & Adjust Logo','klopp'),
	            'section' => 'title_tagline',
	            'settings' => 'klopp_logo_resize',
	            'priority' => 6,
	            'type' => 'range',
	            'active_callback' => 'klopp_logo_enabled',
	            'input_attrs' => array(
			        'min'   => 30,
			        'max'   => 200,
			        'step'  => 5,
			    ),
	        )
	);
	
	function klopp_logo_enabled($control) {
		$option = $control->manager->get_setting('custom_logo');
		return $option->value() == true;
	}
		
	
	//Replace Header Text Color with, separate colors for Title and Description
	//Override klopp_site_titlecolor
	$wp_customize->remove_control('display_header_text');
	$wp_customize->remove_setting('header_textcolor');
	$wp_customize->add_setting('klopp_site_titlecolor', array(
	    'default'     => '#FFF',
	    'sanitize_callback' => 'sanitize_hex_color',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize, 
		'klopp_site_titlecolor', array(
			'label' => __('Site Title Color','klopp'),
			'section' => 'colors',
			'settings' => 'klopp_site_titlecolor',
			'type' => 'color'
		) ) 
	);
	
	$wp_customize->add_setting('klopp_header_desccolor', array(
	    'default'     => '#FFF',
	    'sanitize_callback' => 'sanitize_hex_color',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize, 
		'klopp_header_desccolor', array(
			'label' => __('Site Tagline Color','klopp'),
			'section' => 'colors',
			'settings' => 'klopp_header_desccolor',
			'type' => 'color'
		) ) 
	);
	
	
	//Settings for Header Image
	$wp_customize->add_setting( 'klopp_himg_style' , array(
	    'default'     => 'cover',
	    'sanitize_callback' => 'klopp_sanitize_himg_style'
	) );
	
	/* Sanitization Function */
	function klopp_sanitize_himg_style( $input ) {
		if (in_array( $input, array('contain','cover') ) )
			return $input;
		else
			return '';	
	}
	
	$wp_customize->add_control(
	'klopp_himg_style', array(
		'label' => __('Header Image Arrangement','klopp'),
		'section' => 'header_image',
		'settings' => 'klopp_himg_style',
		'type' => 'select',
		'choices' => array(
				'contain' => __('Contain','klopp'),
				'cover' => __('Cover Completely (Recommended)','klopp'),
				)
	) );
	
	$wp_customize->add_setting( 'klopp_himg_align' , array(
	    'default'     => 'center',
	    'sanitize_callback' => 'klopp_sanitize_himg_align'
	) );
	
	/* Sanitization Function */
	function klopp_sanitize_himg_align( $input ) {
		if (in_array( $input, array('center','left','right') ) )
			return $input;
		else
			return '';	
	}
	
	$wp_customize->add_control(
	'klopp_himg_align', array(
		'label' => __('Header Image Alignment','klopp'),
		'section' => 'header_image',
		'settings' => 'klopp_himg_align',
		'type' => 'select',
		'choices' => array(
				'center' => __('Center','klopp'),
				'left' => __('Left','klopp'),
				'right' => __('Right','klopp'),
			)
	) );
	
	$wp_customize->add_setting( 'klopp_himg_repeat' , array(
	    'default'     => true,
	    'sanitize_callback' => 'klopp_sanitize_checkbox'
	) );
	
	$wp_customize->add_control(
	'klopp_himg_repeat', array(
		'label' => __('Repeat Header Image','klopp'),
		'section' => 'header_image',
		'settings' => 'klopp_himg_repeat',
		'type' => 'checkbox',
	) );
	
	
	//Settings For Logo Area
	
	$wp_customize->add_setting(
		'klopp_hide_title_tagline',
		array( 'sanitize_callback' => 'klopp_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'klopp_hide_title_tagline', array(
		    'settings' => 'klopp_hide_title_tagline',
		    'label'    => __( 'Hide Title and Tagline.', 'klopp' ),
		    'section'  => 'title_tagline',
		    'type'     => 'checkbox',
		)
	);
	
	$wp_customize->add_setting(
		'klopp_branding_below_logo',
		array( 'sanitize_callback' => 'klopp_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'klopp_branding_below_logo', array(
		    'settings' => 'klopp_branding_below_logo',
		    'label'    => __( 'Display Site Title and Tagline Below the Logo.', 'klopp' ),
		    'section'  => 'title_tagline',
		    'type'     => 'checkbox',
		    'active_callback' => 'klopp_title_visible'
		)
	);
	
	function klopp_title_visible( $control ) {
		$option = $control->manager->get_setting('klopp_hide_title_tagline');
	    return $option->value() == false ;
	}
	
	
	// SLIDER PANEL
	$wp_customize->add_panel( 'klopp_slider_panel', array(
	    'priority'       => 35,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => __('Main Slider','klopp'),
	) );
	
	$wp_customize->add_section(
	    'klopp_sec_slider_options',
	    array(
	        'title'     => __('Enable/Disable','klopp'),
	        'priority'  => 0,
	        'panel'     => 'klopp_slider_panel'
	    )
	);
	
	
	$wp_customize->add_setting(
		'klopp_main_slider_enable',
		array( 'sanitize_callback' => 'klopp_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'klopp_main_slider_enable', array(
		    'settings' => 'klopp_main_slider_enable',
		    'label'    => __( 'Enable Slider.', 'klopp' ),
		    'section'  => 'klopp_sec_slider_options',
		    'type'     => 'checkbox',
		)
	);
	
	$wp_customize->add_setting(
		'klopp_main_slider_count',
			array(
				'default' => '0',
				'sanitize_callback' => 'klopp_sanitize_positive_number'
			)
	);
	
	// Select How Many Slides the User wants, and Reload the Page.
	$wp_customize->add_control(
			'klopp_main_slider_count', array(
		    'settings' => 'klopp_main_slider_count',
		    'label'    => __( 'No. of Slides(Min:0, Max: 3)' ,'klopp'),
		    'section'  => 'klopp_sec_slider_options',
		    'type'     => 'number',
		    'description' => __('Save the Settings, and go Back to configure the slides.','klopp'),
		    
		)
	);
	
	
	$wp_customize->add_section(
	    'klopp_sec_upgrade',
	    array(
	        'title'     => __('Klopp Theme Help & Support','klopp'),
	        'priority'  => 45,
	    )
	);
	
	$wp_customize->add_setting(
			'klopp_upgrade',
			array( 'sanitize_callback' => 'esc_textarea' )
		);
			
	$wp_customize->add_control(
	    new WP_Customize_Upgrade_Control(
	        $wp_customize,
	        'klopp_upgrade',
	        array(
	            'label' => __('Help & Support','klopp'),
	            'description' => __('Thank you for choosing Klopp Theme. For Support Related to Klopp WordPress Theme Please Visit the WordPress <a target="_blank" href="https://wordpress.org/support/theme/klopp">Support Forums</a> or <a  href="https://inkhive.com" target="_blank">InkHive.com</a>','klopp'),
	            'section' => 'klopp_sec_upgrade',
	            'settings' => 'klopp_upgrade',			       
	        )
		)
	);
	
	$wp_customize->add_section(
	    'klopp_sec_upgrade_pro',
	    array(
	        'title'     => __('Discover Klopp Plus','klopp'),
	        'priority'  => 15,
	    )
	);
	
	$wp_customize->add_setting(
			'klopp_upgrade_pro',
			array( 'sanitize_callback' => 'esc_textarea' )
		);
			
	$wp_customize->add_control(
	    new WP_Customize_Upgrade_Control(
	        $wp_customize,
	        'klopp_upgrade_pro',
	        array(
	            'label' => __('More of Everything','klopp'),
	            'description' => __('Klopp Plus is the extended version of Klopp. It has More Features Including multiple header layouts, google fonts with over 650 choices, Unlimited Colors, Custom Skin Designer, Footer Layouts, Custom Widgets, More Blog Layouts, More Page Layouts and Options, More Featured Areas, More Showcases, Powerful Slider and so much more.  <a  href="https://inkhive.com/product/klopp-plus/" target="_blank">More Details</a>','klopp'),
	            'section' => 'klopp_sec_upgrade_pro',
	            'settings' => 'klopp_upgrade_pro',			       
	        )
		)
	);
		
	
		
	for ( $i = 1 ; $i <= 3 ; $i++ ) :
		
		//Create the settings Once, and Loop through it.
		
		$wp_customize->add_setting(
			'klopp_slide_img'.$i,
			array( 'sanitize_callback' => 'esc_url_raw' )
		);
		
		$wp_customize->add_control(
		    new WP_Customize_Image_Control(
		        $wp_customize,
		        'klopp_slide_img'.$i,
		        array(
		            'label' => '',
		            'section' => 'klopp_slide_sec'.$i,
		            'settings' => 'klopp_slide_img'.$i,			       
		        )
			)
		);
		
		
		$wp_customize->add_section(
		    'klopp_slide_sec'.$i,
		    array(
		        'title'     => __('Slide ','klopp').$i,
		        'priority'  => $i,
		        'panel'     => 'klopp_slider_panel'
		    )
		);
		
		$wp_customize->add_setting(
			'klopp_slide_title'.$i,
			array( 'sanitize_callback' => 'sanitize_text_field' )
		);
		
		$wp_customize->add_control(
				'klopp_slide_title'.$i, array(
			    'settings' => 'klopp_slide_title'.$i,
			    'label'    => __( 'Slide Title','klopp' ),
			    'section'  => 'klopp_slide_sec'.$i,
			    'type'     => 'text',
			)
		);
		
		$wp_customize->add_setting(
			'klopp_slide_desc'.$i,
			array( 'sanitize_callback' => 'sanitize_text_field' )
		);
		
		$wp_customize->add_control(
				'klopp_slide_desc'.$i, array(
			    'settings' => 'klopp_slide_desc'.$i,
			    'label'    => __( 'Slide Description','klopp' ),
			    'section'  => 'klopp_slide_sec'.$i,
			    'type'     => 'text',
			)
		);
		
		
		
		$wp_customize->add_setting(
			'klopp_slide_CTA_button'.$i,
			array( 'sanitize_callback' => 'sanitize_text_field' )
		);
		
		$wp_customize->add_control(
				'klopp_slide_CTA_button'.$i, array(
			    'settings' => 'klopp_slide_CTA_button'.$i,
			    'label'    => __( 'Custom Call to Action Button Text(Optional)','klopp' ),
			    'section'  => 'klopp_slide_sec'.$i,
			    'type'     => 'text',
			)
		);
		
		$wp_customize->add_setting(
			'klopp_slide_url'.$i,
			array( 'sanitize_callback' => 'esc_url_raw' )
		);
		
		$wp_customize->add_control(
				'klopp_slide_url'.$i, array(
			    'settings' => 'klopp_slide_url'.$i,
			    'label'    => __( 'Target URL','klopp' ),
			    'section'  => 'klopp_slide_sec'.$i,
			    'type'     => 'url',
			)
		);
		
	endfor;


	
	//CUSTOM SHOWCASE
	$wp_customize->add_panel( 'klopp_showcase_panel', array(
	    'priority'       => 35,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => __('Custom Showcase','klopp'),
	) );
	
	$wp_customize->add_section(
	    'klopp_sec_showcase_options',
	    array(
	        'title'     => __('Enable/Disable','klopp'),
	        'priority'  => 0,
	        'panel'     => 'klopp_showcase_panel'
	    )
	);
	
	
	$wp_customize->add_setting(
		'klopp_showcase_enable',
		array( 'sanitize_callback' => 'klopp_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'klopp_showcase_enable', array(
		    'settings' => 'klopp_showcase_enable',
		    'label'    => __( 'Enable Showcase on Front Page.', 'klopp' ),
		    'section'  => 'klopp_sec_showcase_options',
		    'type'     => 'checkbox',
		)
	);
	
	$wp_customize->add_setting(
		'klopp_showcase_title',
		array( 'sanitize_callback' => 'sanitize_text_field' )
	);
	
	$wp_customize->add_control(
			'klopp_showcase_title', array(
		    'settings' => 'klopp_showcase_title',
		    'label'    => __( 'Title','klopp' ),
		    'section'  => 'klopp_sec_showcase_options',
		    'type'     => 'text',
		)
	);
	
	for ( $i = 1 ; $i <= 3 ; $i++ ) :
		
		//Create the settings Once, and Loop through it.
		$wp_customize->add_section(
		    'klopp_showcase_sec'.$i,
		    array(
		        'title'     => __('ShowCase ','klopp').$i,
		        'priority'  => $i,
		        'panel'     => 'klopp_showcase_panel',
		        
		    )
		);	
		
		$wp_customize->add_setting(
			'klopp_showcase_img'.$i,
			array( 'sanitize_callback' => 'esc_url_raw' )
		);
		
		$wp_customize->add_control(
		    new WP_Customize_Image_Control(
		        $wp_customize,
		        'klopp_showcase_img'.$i,
		        array(
		            'label' => '',
		            'section' => 'klopp_showcase_sec'.$i,
		            'settings' => 'klopp_showcase_img'.$i,			       
		        )
			)
		);
		
		$wp_customize->add_setting(
			'klopp_showcase_title'.$i,
			array( 'sanitize_callback' => 'sanitize_text_field' )
		);
		
		$wp_customize->add_control(
				'klopp_showcase_title'.$i, array(
			    'settings' => 'klopp_showcase_title'.$i,
			    'label'    => __( 'Showcase Title','klopp' ),
			    'section'  => 'klopp_showcase_sec'.$i,
			    'type'     => 'text',
			)
		);
		
		$wp_customize->add_setting(
			'klopp_showcase_desc'.$i,
			array( 'sanitize_callback' => 'sanitize_text_field' )
		);
		
		$wp_customize->add_control(
				'klopp_showcase_desc'.$i, array(
			    'settings' => 'klopp_showcase_desc'.$i,
			    'label'    => __( 'Showcase Description','klopp' ),
			    'section'  => 'klopp_showcase_sec'.$i,
			    'type'     => 'text',
			)
		);
		
		
		$wp_customize->add_setting(
			'klopp_showcase_url'.$i,
			array( 'sanitize_callback' => 'esc_url_raw' )
		);
		
		$wp_customize->add_control(
				'klopp_showcase_url'.$i, array(
			    'settings' => 'klopp_showcase_url'.$i,
			    'label'    => __( 'Target URL','klopp' ),
			    'section'  => 'klopp_showcase_sec'.$i,
			    'type'     => 'url',
			)
		);
		
	endfor;
	
	//FEATURED POSTS
	
	$wp_customize->add_section(
	    'klopp_featposts',
	    array(
	        'title'     => __('Featured Posts','klopp'),
	        'priority'  => 35,
	    )
	);
	
	$wp_customize->add_setting(
		'klopp_featposts_enable',
		array( 'sanitize_callback' => 'klopp_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'klopp_featposts_enable', array(
		    'settings' => 'klopp_featposts_enable',
		    'label'    => __( 'Enable', 'klopp' ),
		    'section'  => 'klopp_featposts',
		    'type'     => 'checkbox',
		)
	);
	
	
	$wp_customize->add_setting(
		'klopp_featposts_title',
		array( 'sanitize_callback' => 'sanitize_text_field' )
	);
	
	$wp_customize->add_control(
			'klopp_featposts_title', array(
		    'settings' => 'klopp_featposts_title',
		    'label'    => __( 'Title', 'klopp' ),
		    'section'  => 'klopp_featposts',
		    'type'     => 'text',
		)
	);
	
	
	
	$wp_customize->add_setting(
		    'klopp_featposts_cat',
		    array( 'sanitize_callback' => 'klopp_sanitize_category' )
		);
	
		
	$wp_customize->add_control(
	    new WP_Customize_Category_Control(
	        $wp_customize,
	        'klopp_featposts_cat',
	        array(
	            'label'    => __('Category For Featured Posts','klopp'),
	            'settings' => 'klopp_featposts_cat',
	            'section'  => 'klopp_featposts'
	        )
	    )
	);
	
	$wp_customize->add_setting(
		'klopp_featposts_rows',
		array( 'sanitize_callback' => 'klopp_sanitize_positive_number' )
	);
	
	$wp_customize->add_control(
			'klopp_featposts_rows', array(
		    'settings' => 'klopp_featposts_rows',
		    'label'    => __( 'Max No. of Rows.', 'klopp' ),
		    'section'  => 'klopp_featposts',
		    'type'     => 'number',
		    'default'  => '0'
		)
	);
		
	// Layout and Design
	$wp_customize->add_panel( 'klopp_design_panel', array(
	    'priority'       => 40,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => __('Design & Layout','klopp'),
	) );
	
	$wp_customize->add_section(
	    'klopp_design_options',
	    array(
	        'title'     => __('Blog Layout','klopp'),
	        'priority'  => 0,
	        'panel'     => 'klopp_design_panel'
	    )
	);
	
	
	$wp_customize->add_setting(
		'klopp_blog_layout',
		array( 'sanitize_callback' => 'klopp_sanitize_blog_layout' )
	);
	
	function klopp_sanitize_blog_layout( $input ) {
		if ( in_array($input, array('grid','grid_2_column','grid_3_column','klopp') ) )
			return $input;
		else 
			return '';	
	}
	
	$wp_customize->add_control(
		'klopp_blog_layout',array(
				'label' => __('Select Layout','klopp'),
				'settings' => 'klopp_blog_layout',
				'section'  => 'klopp_design_options',
				'type' => 'select',
				'choices' => array(
						'klopp' => __('Klopp Theme Layout','klopp'),
						'grid' => __('Basic Blog Layout','klopp'),
						'grid_2_column' => __('Grid - 2 Column','klopp'),
						'grid_3_column' => __('Grid - 3 Column','klopp'),
						
					)
			)
	);
	
	$wp_customize->add_section(
	    'klopp_sidebar_options',
	    array(
	        'title'     => __('Sidebar Layout','klopp'),
	        'priority'  => 0,
	        'panel'     => 'klopp_design_panel'
	    )
	);
	
	$wp_customize->add_setting(
		'klopp_disable_sidebar',
		array( 'sanitize_callback' => 'klopp_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'klopp_disable_sidebar', array(
		    'settings' => 'klopp_disable_sidebar',
		    'label'    => __( 'Disable Sidebar Everywhere.','klopp' ),
		    'section'  => 'klopp_sidebar_options',
		    'type'     => 'checkbox',
		    'default'  => false
		)
	);
	
	$wp_customize->add_setting(
		'klopp_disable_sidebar_home',
		array( 'sanitize_callback' => 'klopp_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'klopp_disable_sidebar_home', array(
		    'settings' => 'klopp_disable_sidebar_home',
		    'label'    => __( 'Disable Sidebar on Home/Blog.','klopp' ),
		    'section'  => 'klopp_sidebar_options',
		    'type'     => 'checkbox',
		    'active_callback' => 'klopp_show_sidebar_options',
		    'default'  => false
		)
	);
	
	$wp_customize->add_setting(
		'klopp_disable_sidebar_front',
		array( 'sanitize_callback' => 'klopp_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'klopp_disable_sidebar_front', array(
		    'settings' => 'klopp_disable_sidebar_front',
		    'label'    => __( 'Disable Sidebar on Front Page.','klopp' ),
		    'section'  => 'klopp_sidebar_options',
		    'type'     => 'checkbox',
		    'active_callback' => 'klopp_show_sidebar_options',
		    'default'  => false
		)
	);
	
	
	$wp_customize->add_setting(
		'klopp_sidebar_width',
		array(
			'default' => 4,
		    'sanitize_callback' => 'klopp_sanitize_positive_number' )
	);
	
	$wp_customize->add_control(
			'klopp_sidebar_width', array(
		    'settings' => 'klopp_sidebar_width',
		    'label'    => __( 'Sidebar Width','klopp' ),
		    'description' => __('Min: 25%, Default: 33%, Max: 40%','klopp'),
		    'section'  => 'klopp_sidebar_options',
		    'type'     => 'range',
		    'active_callback' => 'klopp_show_sidebar_options',
		    'input_attrs' => array(
		        'min'   => 3,
		        'max'   => 5,
		        'step'  => 1,
		        'class' => 'sidebar-width-range',
		        'style' => 'color: #0a0',
		    ),
		)
	);
	
	/* Active Callback Function */
	function klopp_show_sidebar_options($control) {
	   
	    $option = $control->manager->get_setting('klopp_disable_sidebar');
	    return $option->value() == false ;
	    
	}
	
	class Klopp_Custom_CSS_Control extends WP_Customize_Control {
	    public $type = 'textarea';
	 
	    public function render_content() {
	        ?>
	            <label>
	                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	                <textarea rows="8" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
	            </label>
	        <?php
	    }
	}
	
	$wp_customize-> add_section(
    'klopp_custom_codes',
    array(
    	'title'			=> __('Custom CSS','klopp'),
    	'description'	=> __('Enter your Custom CSS to Modify design.','klopp'),
    	'priority'		=> 11,
    	'panel'			=> 'klopp_design_panel'
    	)
    );
    
	$wp_customize->add_setting(
	'klopp_custom_css',
	array(
		'default'		=> '',
		'sanitize_callback'    => 'wp_filter_nohtml_kses',
		'sanitize_js_callback' => 'wp_filter_nohtml_kses'
		)
	);
	
	$wp_customize->add_control(
	    new Klopp_Custom_CSS_Control(
	        $wp_customize,
	        'klopp_custom_css',
	        array(
	            'section' => 'klopp_custom_codes',
	            'settings' => 'klopp_custom_css'
	        )
	    )
	);
	
	function klopp_sanitize_text( $input ) {
	    return wp_kses_post( force_balance_tags( $input ) );
	}
	
	$wp_customize-> add_section(
    'klopp_custom_footer',
    array(
    	'title'			=> __('Custom Footer Text','klopp'),
    	'description'	=> __('Enter your Own Copyright Text.','klopp'),
    	'priority'		=> 11,
    	'panel'			=> 'klopp_design_panel'
    	)
    );
    
	$wp_customize->add_setting(
	'klopp_footer_text',
	array(
		'default'		=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
		)
	);
	
	$wp_customize->add_control(	 
	       'klopp_footer_text',
	        array(
	            'section' => 'klopp_custom_footer',
	            'settings' => 'klopp_footer_text',
	            'type' => 'text'
	        )
	);	
	
	$wp_customize->add_section(
	    'klopp_typo_options',
	    array(
	        'title'     => __('Google Web Fonts','klopp'),
	        'priority'  => 41,
	    )
	);
	
	$font_array = array('Yanone Kaffeesatz','Khula','Open Sans','Droid Sans','Droid Serif','Roboto','Roboto Condensed','Lato','Bree Serif','Oswald','Slabo','Lora','Source Sans Pro','PT Sans','Ubuntu','Lobster','Arimo','Bitter','Noto Sans');
	$fonts = array_combine($font_array, $font_array);
	
	$wp_customize->add_setting(
		'klopp_title_font',
		array(
			'default'=> 'Yanone Kaffeesatz',
			'sanitize_callback' => 'klopp_sanitize_gfont' 
			)
	);
	
	function klopp_sanitize_gfont( $input ) {
		if ( in_array($input, array('Source Sans Pro','Khula','Open Sans','Droid Sans','Droid Serif','Roboto','Roboto Condensed','Lato','Bree Serif','Oswald','Slabo','Lora','PT Sans','Ubuntu','Lobster','Arimo','Bitter','Noto Sans') ) )
			return $input;
		else
			return '';	
	}
	
	$wp_customize->add_control(
		'klopp_title_font',array(
				'label' => __('Title','klopp'),
				'settings' => 'klopp_title_font',
				'section'  => 'klopp_typo_options',
				'type' => 'select',
				'choices' => $fonts,
			)
	);
	
	$wp_customize->add_setting(
		'klopp_body_font',
			array(	'default'=> 'Source Sans Pro',
					'sanitize_callback' => 'klopp_sanitize_gfont' )
	);
	
	$wp_customize->add_control(
		'klopp_body_font',array(
				'label' => __('Body','klopp'),
				'settings' => 'klopp_body_font',
				'section'  => 'klopp_typo_options',
				'type' => 'select',
				'choices' => $fonts
			)
	);
	
	// Social Icons
	$wp_customize->add_section('klopp_social_section', array(
			'title' => __('Social Icons','klopp'),
			'priority' => 44 ,
	));
	
	$social_networks = array( //Redefinied in Sanitization Function.
					'none' => __('-','klopp'),
					'facebook' => __('Facebook','klopp'),
					'twitter' => __('Twitter','klopp'),
					'google-plus' => __('Google Plus','klopp'),
					'instagram' => __('Instagram','klopp'),
					'rss' => __('RSS Feeds','klopp'),
					'vine' => __('Vine','klopp'),
					'vimeo-square' => __('Vimeo','klopp'),
					'youtube' => __('Youtube','klopp'),
					'flickr' => __('Flickr','klopp'),
				);
				
	$social_count = count($social_networks);
				
	for ($x = 1 ; $x <= ($social_count - 3) ; $x++) :
			
		$wp_customize->add_setting(
			'klopp_social_'.$x, array(
				'sanitize_callback' => 'klopp_sanitize_social',
				'default' => 'none'
			));

		$wp_customize->add_control( 'klopp_social_'.$x, array(
					'settings' => 'klopp_social_'.$x,
					'label' => __('Icon ','klopp').$x,
					'section' => 'klopp_social_section',
					'type' => 'select',
					'choices' => $social_networks,			
		));
		
		$wp_customize->add_setting(
			'klopp_social_url'.$x, array(
				'sanitize_callback' => 'esc_url_raw'
			));

		$wp_customize->add_control( 'klopp_social_url'.$x, array(
					'settings' => 'klopp_social_url'.$x,
					'description' => __('Icon ','klopp').$x.__(' Url','klopp'),
					'section' => 'klopp_social_section',
					'type' => 'url',
					'choices' => $social_networks,			
		));
		
	endfor;
	
	function klopp_sanitize_social( $input ) {
		$social_networks = array(
					'none' ,
					'facebook',
					'twitter',
					'google-plus',
					'instagram',
					'rss',
					'vine',
					'vimeo-square',
					'youtube',
					'flickr'
				);
		if ( in_array($input, $social_networks) )
			return $input;
		else
			return '';	
	}	
	
	
	/* Sanitization Functions Common to Multiple Settings go Here, Specific Sanitization Functions are defined along with add_setting() */
	function klopp_sanitize_checkbox( $input ) {
	    if ( $input == 1 ) {
	        return 1;
	    } else {
	        return '';
	    }
	}
	
	function klopp_sanitize_positive_number( $input ) {
		if ( ($input >= 0) && is_numeric($input) )
			return $input;
		else
			return '';	
	}
	
	function klopp_sanitize_category( $input ) {
		if ( term_exists(get_cat_name( $input ), 'category') )
			return $input;
		else 
			return '';	
	}
	
	
}
add_action( 'customize_register', 'klopp_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function klopp_customize_preview_js() {
	wp_enqueue_script( 'klopp_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'klopp_customize_preview_js' );
