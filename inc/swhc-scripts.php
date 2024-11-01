<?php 
/*
* Scripts
*/
if( !function_exists('swhc_scripts') ){
function swhc_scripts(){
	wp_enqueue_style('swhc-stylesheet', plugin_dir_url(__FILE__).'css/swhc-main.css',array(),'1.0');	
	//wp_enqueue_script('jquery');
}
}

add_action('init','swhc_scripts');



/*
* Custom CSS script
*/

if( !function_exists('swhc_custom_style') ){
function swhc_custom_style(){?>
	<style type="text/css"> 
		<?php 
		if(!empty(get_option('swhc_load_class'))){
			echo esc_attr( get_option('swhc_load_class') );
		} 
		if(!empty(get_option('swhc_load_classa'))){
			echo ','.esc_attr( get_option('swhc_load_classa') );
		} 
		if(!empty(get_option('swhc_load_classb'))){
			echo ','.esc_attr( get_option('swhc_load_classb') );
		} 
		if(!empty(get_option('swhc_load_classc'))){
			echo ','.esc_attr( get_option('swhc_load_classc') );
		} 
		if(!empty(get_option('swhc_load_classd'))){
			echo ','.esc_attr( get_option('swhc_load_classd') );
		} 		
		?>{
			display: none;
		}
		<?php if(empty(get_option('swhc_css_class'))){ ?>
		.btn.loadMoreBtn {
			color: #333333;
			text-align: center;
		}

		.btn.loadMoreBtn:hover {
		  text-decoration: none;
		}
		<?php } else{
			echo esc_attr( get_option('swhc_css_class') );
		} ?>
	</style>
<?php }

}

add_action('wp_head','swhc_custom_style');

/*
* Admin Scripts for form Design
*/
if( !function_exists('swhc_admin_style') ){
function swhc_admin_style(){?>
	<style type="text/css"> 
		@media(min-width:960px){
			.left-col{			
				width:60%;
			}
			.right-col{			
				width:40%;
			}
			td.right-col{
				vertical-align:top;
			}
		}
		.successModal {
			display: inline-block;
		}
		<?php if(empty(get_option('swhc_css_class'))){ ?>
		.btn.loadMoreBtn {
			color: #333333;
			text-align: center;
		}

		.btn.loadMoreBtn:hover {
		  text-decoration: none;
		}
		<?php } else{
			echo esc_attr( get_option('swhc_css_class') );
		} ?>
	</style>
<?php }
}

add_action('admin_head','swhc_admin_style');

/*
* Ajax option Saving
*/
if( !function_exists('swhc_ajax_save_btn') ){
	function swhc_ajax_save_btn(){ ?>
	<?php submit_button(); ?>
	<div id="saveResult"></div>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('#swhc_option_form').submit(function() {
				jQuery(this).ajaxSubmit({
					success: function() {
						jQuery('#saveResult').html("<div id='saveMessage' class='successModal'></div>");
						jQuery('#saveMessage').append("<p><?php echo htmlentities(__('Settings Saved Successfully','wp'),ENT_QUOTES); ?></p>").show();
					},
					beforeSend: function() {
						jQuery('#saveResult').html("<div id='saveMessage' class='successModal'><span class='is-active spinner'></span></div>");
					},
					timeout: 10000
				});
								

				return false;
			});
		});
	</script>
<?php }
}

add_action( 'wp_head', function(){
	if ( is_product() ){ 
    ?>


<div class="swhc_sticky">
<?php global $post;
$id = $post->ID; 
	
	?>
		<div class="product_img">
			
		
<?php if ( has_post_thumbnail()) : ?>
    
        <?php the_post_thumbnail(); 
		set_post_thumbnail_size( 50, 50 ); ?>     
 
<?php endif; ?>
		
		</div>
							<div class="product_title">
								<span><?php the_title();  ?>
								</span>	
							</div>

<?php


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

global $product;
?>

<?php if ( ! $product->is_in_stock() ) : ?>

    <a href="<?php echo apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ); ?>" class="button"><?php echo apply_filters( 'out_of_stock_add_to_cart_text', __( 'Read More', 'woocommerce' ) ); ?></a>

<?php else : ?>

    <?php
        $link = array(
            'url'   => '',
            'label' => '',
            'class' => ''
        );

        switch ( $product->product_type ) {
            case "variable" :
                $link['url']    = apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
                $link['label']  = apply_filters( 'variable_add_to_cart_text', __( 'Select options', 'woocommerce' ) );
            break;
            case "grouped" :
                $link['url']    = apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
                $link['label']  = apply_filters( 'grouped_add_to_cart_text', __( 'View options', 'woocommerce' ) );
            break;
            case "external" :
                $link['url']    = apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
                $link['label']  = apply_filters( 'external_add_to_cart_text', __( 'Read More', 'woocommerce' ) );
            break;
            default :
                if ( $product->is_purchasable() ) {
                    $link['url']    = apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
                    $link['label']  = apply_filters( 'add_to_cart_text', __( 'Add to cart', 'woocommerce' ) );
                    $link['class']  = apply_filters( 'add_to_cart_class', 'add_to_cart_button' );
                } else {
                    $link['url']    = apply_filters( 'not_purchasable_url', get_permalink( $product->id ) );
                    $link['label']  = apply_filters( 'not_purchasable_text', __( 'Read More', 'woocommerce' ) );
                }
            break;
        }

        // If there is a simple product.
        if ( $product->product_type == 'simple' ) {
            ?>
            <form action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="cart" method="post" enctype="multipart/form-data">
                <?php
                    // Displays the quantity box.
                    woocommerce_quantity_input();

                    // Display the submit button.
                    echo sprintf( '<button type="submit" data-product_id="%s" data-product_sku="%s" data-quantity="1" class="%s button product_type_simple">%s</button>', esc_attr( $product->id ), esc_attr( $product->get_sku() ), esc_attr( $link['class'] ), esc_html( $link['label'] ) );
                ?>
            </form>
            <?php
        } else {
          echo apply_filters( 'woocommerce_loop_add_to_cart_link', sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="%s button product_type_%s">%s</a>', esc_url( $link['url'] ), esc_attr( $product->id ), esc_attr( $product->get_sku() ), esc_attr( $link['class'] ), esc_attr( $product->product_type ), esc_html( $link['label'] ) ), $product, $link );
        }

    ?>

<?php endif; ?>

<?php } ?>
	</div>

    <!-- your code goes here -->
    <?php
});



if( !function_exists('swhc_custom_code') ){
function swhc_custom_code(){?>
	<script type="text/javascript"> 
		(function($) {
			'use strict';

			jQuery(document).ready(function() {
				//wrapper zero
				<?php if(!empty(get_option('swhc_wrapper_class'))):?>
					$("<?php echo esc_attr( get_option('swhc_wrapper_class') ); ?>").append('<a href="#" class="btn loadMoreBtn" id="loadMore"><?php echo esc_attr( get_option('swhc_load_label') ); ?></a>');
					
					$("<?php echo esc_attr( get_option('swhc_load_class') ); ?>").slice(0, <?php echo esc_attr( get_option('swhc_item_show') ); ?>).show();
$("<?php echo esc_attr( get_option('swhc_item_pagination') ); ?>").fadeOut('slow');				
				
			
					$("#loadMore").on('click', function (e) {
						e.preventDefault();
						$("<?php echo esc_attr( get_option('swhc_load_class') ); ?>:hidden").slice(0, <?php echo esc_attr( get_option('swhc_item_load') ); ?>).slideDown();
						if ($("<?php echo esc_attr( get_option('swhc_load_class') ); ?>:hidden").length == 0) {
							$("#loadMore").fadeOut('slow');
							$("<?php echo esc_attr( get_option('swhc_item_pagination') ); ?>").show();	
						}
					});
				<?php endif;?>
				// end wrapper 1

			});

		})(jQuery);
	</script>
<script>
jQuery(document).ready(function($) { 
$(window).scroll(function(){
    if ($(window).scrollTop() >= 50) {
        $('.swhc_sticky').addClass('st-sticky');
      
    }
    else {
      
        $('.swhc_sticky').removeClass('st-sticky');
    }
});
});
</script>





<?php } 
}

add_action('wp_footer','swhc_custom_code');