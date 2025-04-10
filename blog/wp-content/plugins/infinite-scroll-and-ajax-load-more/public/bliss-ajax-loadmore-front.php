<?php
class Bliss_loadmore_public {
	public function __construct() {
	    add_action( 'wp_enqueue_scripts', array( $this, 'bliss_loadmore_scripts' ));
	   	add_action('wp_ajax_loadmore', array( $this, 'bliss_loadmore_ajax_handler')); // wp_ajax_{action}
		add_action('wp_ajax_nopriv_loadmore', array( $this, 'bliss_loadmore_ajax_handler')); // wp_ajax_nopriv_{action}
		add_shortcode( 'ajax-loadmore-button', array( $this, 'bliss_load_more_button' ));
	}
	
  	public function bliss_loadmore_scripts() {
 
	    global $wp_query; 
	    // In most cases it is already included on the page and this line can be removed
	    //wp_enqueue_script('jquery');
	 
	    // register our main script but do not enqueue it yet
	    //wp_enqueue_script( 'bliss_js', BLISS_AJAX_LOADMORE_URL . 'public/js/jquery-1.11.3.min.js', array('jquery'), BLISS_AJAX_LOADMORE_VERSION, false );
	    $scroll = get_option('scroll_type');
		//echo $scroll[0];
	    if($scroll[0] == 'option2'){ //for button
	    	wp_enqueue_script( 'bliss_loadmore', BLISS_AJAX_LOADMORE_URL . 'public/js/bliss-loadmore.js', array('jquery'), BLISS_AJAX_LOADMORE_VERSION, true );
	    }
	    else{ //for infinite scroll
	    	if(!is_single()){
	    	wp_enqueue_script( 'bliss_loadmore', BLISS_AJAX_LOADMORE_URL . 'public/js/bliss-infinite-loadmore.js', array('jquery'), BLISS_AJAX_LOADMORE_VERSION, true );
	    }
	    }
	 
	    // now the most interesting part
	    // we have to pass parameters to bliss-loadmore.js script but we can get the parameters values only in PHP
	    // you can define variables directly in your HTML but I decided that the most proper way is wp_localize_script()
	    wp_localize_script( 'bliss_loadmore', 'bliss_loadmore_params', array(
	        'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
	        'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
	        'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
	        'max_page' => $wp_query->max_num_pages,
	        'maindiv' => get_option('loadmore_main_selector') ? get_option('loadmore_main_selector') : '#main',
	        'innerdiv' => get_option('loadmore_class_selector') ? get_option('loadmore_class_selector') : '.post',
	        'loadmore_image' => get_option('loadmore_image') ? get_option('loadmore_image') : BLISS_AJAX_LOADMORE_URL.'public/images/ajax-loader.gif',
	    	) );

	    wp_register_style( 'bliss-loadmore-css', BLISS_AJAX_LOADMORE_URL . 'public/css/bliss-loadmore.css', array(), BLISS_AJAX_LOADMORE_VERSION );
        wp_enqueue_style( 'bliss-loadmore-css' );
    }

    //show content of the post on load more
	function bliss_loadmore_ajax_handler(){
		// prepare our arguments for the query
		global $wp_query; // you can remove this line if everything works for you
		// don't display the button if there are not enough posts
		
		$args = json_decode( stripslashes( $_POST['query'] ), true );
		$pages = sanitize_text_field(stripslashes($_POST['page']));
		$args['paged'] = $pages + 1; // we need next page to be loaded
		$args['post_status'] = 'publish';
	 
		// it is always better to use WP_Query but not here
		query_posts( $args );
		ob_start();
		if( have_posts() ) :
	 		// run the loop
			while( have_posts() ): the_post();
				//call loop from the template
				//$this->bliss_get_template( 'content-loop.php' );
                get_template_part( 'template-parts/content', get_post_format() );
			endwhile;
	 		
		endif;
		die; // here we exit the script and even no wp_reset_query() required!
	}

	//create the template file for the display output
	public function bliss_locate_template( $template_name, $template_path = '', $default_path = '' ) {

	   if ( !$template_path) {
	       $template_path = 'ajax-load-more'; //For the override create this directory name under the theme folder
	   }
	   if ( !$default_path) {
	       $default_path = BLISS_AJAX_LOADMORE_DIR . '/templates/';
	   }
	   // Look within passed path within the theme - this is priority
	   $template = locate_template( array(trailingslashit( $template_path) . $template_name, $template_name) );
	   // Add support of third perty plugin
	          if ( !$template) {
	       $template = $default_path . $template_name;
	   }
	   return $template;
	}

	public function bliss_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	   if ( $args && is_array( $args ) ) {
	       extract( $args );
	   }
	   $located = $this->bliss_locate_template( $template_name, $template_path, $default_path);
	   include($located);
	}

	public function bliss_load_more_button()
	{
		global $wp_query; // you can remove this line if everything works for you
		// don't display the button if there are not enough posts
		$scroll = get_option('scroll_type');
	    if($scroll[0] == 'option2'){ //for button
			$btntxt =  __('Load More', 'bl-scroll');
			if(get_option('loadmore_button_text')){ $btntxt = get_option('loadmore_button_text');}
			if(get_option('loadmore_button_bgcolor')){ $btnbg = 'background:' . get_option('loadmore_button_bgcolor'). ';';}
			if(get_option('loadmore_button_txtcolor')){ $btncolor = ' color:' . get_option('loadmore_button_txtcolor') . ';';}
			if(get_option('loadmore_image')){ $loadmore_image =  get_option('loadmore_image');}
			else{
				$loadmore_image = BLISS_AJAX_LOADMORE_URL.'public/images/ajax-loader.gif';
			}
			if (  $wp_query->max_num_pages > 1 ){
				printf('<div class="bliss_loadmore" style="%1$s %2$s">%3$s</div>', $btnbg, $btncolor, $btntxt );
				printf('<div class="loading-img"><img src="%s" alt="" /></div>', $loadmore_image);
			}
		}
	}
}
new Bliss_loadmore_public();
?>