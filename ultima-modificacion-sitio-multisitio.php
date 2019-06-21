<?php
/**
 * Plugin Name: Última modificación Multisitio
 * Plugin URI:  https://developer.wordpress.org/plugins/wp-widget-ultima-modificacion-multisitio
 * Description: Muestra la fecha y hora de la última modificación realizada al contenido del sitio
 * Version:     1.0.0
 * Author:      Ernesto Tur Laurencio
 * Author URI:  https://www.twitter.com/Sasousuke
 * License:     GPL3
 */

class wp_widget_ultima_modificacion_multisitio extends WP_Widget {
	
    function __construct(){
        // Constructor del Widget
        $widget_ops = array(
			'classname' => 'wp_widget_ultima_modificacion_multisitio', 
			'description' => "Muestra la fecha y hora de la última modificación realizada al contenido del sitio" );
        $this->WP_Widget('wp_widget_ultima_modificacion_multisitio', "Última modificación", $widget_ops);
    }

function widget($args,$instance){
		// Contenido del Widget que se mostrará en la Sidebar
        echo $before_widget;
		
		$my_fecha = "";
		
		$umm_args = array(
			'post_type' => array( 'post', 'page', 'attachment', 'nav_menu_item' ),
			'post_status' => 'publish',
			'orderby' => 'modified',
			'order'   => 'DESC',
			'posts_per_page' => 1
		);

		$the_query = new WP_Query($umm_args);
		
		// The Loop
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$my_fecha = get_the_modified_date();
				break;
			}
			/* Restore original Post Data */
			wp_reset_postdata();
		} else {
			// no posts found
		}
   
        ?>
        <div id="ultima_modificacion" class="sidebar-wrap clearfix ultima-modificacion-multisitio">
			<div class="widget_title"><h3>ACTUALIZACIÓN</h3></div>
			<div class="textwidget">
				<p><strong>Actualizado: </strong><?php echo $my_fecha; ?></p>
			</div>
        </div>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance){
        return $old_instance;
    }

    function form($instance){
        // Formulario de opciones del Widget, que aparece cuando añadimos el Widget a una Sidebar
    }
}

// register Última_modificación_Multisitio
add_action( 'widgets_init', function(){
	register_widget( 'wp_widget_ultima_modificacion_multisitio' );
});
