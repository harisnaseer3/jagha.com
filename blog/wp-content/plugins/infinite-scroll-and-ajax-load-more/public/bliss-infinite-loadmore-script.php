<?php
class Bliss_loadmore_public_script {
	public function __construct() {
		add_action( 'wp_footer', array( $this, 'bliss_infinite_loadmore_scripts' ));
	}
	public function bliss_infinite_loadmore_scripts() { ?>

		<script type="text/javascript">
		jQuery(function($){
			var canBeLoaded = true, // this param allows to initiate the AJAX call only if necessary
			    bottomOffset = 2000; // the distance (in px) from the page bottom when you want to load more posts
		 	
			$(window).scroll(function(){ 
				var data = {
					'action': 'loadmore',
					'query': bliss_loadmore_params.posts,
					'page' : bliss_loadmore_params.current_page
				};
				
				if( $(document).scrollTop() > ( $(document).height() - bottomOffset ) && canBeLoaded === true ){
					$.ajax({ 
						url : bliss_loadmore_params.ajaxurl,
						data:data,
						type:'POST',
						beforeSend: function( xhr ){

							// you can also add your own preloader here
							//$('#main').find('article:last-of-type').after().html('<span class="loading">Loading...</span>');;
							// you see, the AJAX call is in process, we shouldn't run it again until complete
							canBeLoaded = false; 
						},
						success:function(data){ 
							if( data ) {
								$('#main').find('article:last-of-type').after( data ); // where to insert posts
								//$('#main').find('.loading').hide();
								canBeLoaded = true; // the ajax is completed, now we can run it again

								bliss_loadmore_params.current_page++;
							}else{
								//$('#main').find('.loading').hide();
							}
						}
					});
				}
			});
		});
		</script>
<?php } 
}
new Bliss_loadmore_public_script();
?>