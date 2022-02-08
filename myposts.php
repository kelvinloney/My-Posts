<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/kelvinloney
 * @since             1.0.0
 * @package           Myposts
 *
 * @wordpress-plugin
 * Plugin Name: MyPosts
 * Description: A plugin that will tell what posts (of any post type) were published so far this calendar month and who their authors were.
 * Version: 1.0
 * Author: Kelvin Loney
 * Author URI: https://github.com/kelvinloney
 */

add_shortcode( 'myposts_show_this_months_posts_by_author', 'myposts_show_this_months_posts_by_author' );
function myposts_show_this_months_posts_by_author() {
		if( ! current_user_can( 'administrator' ) ) :
			return;
		endif;

		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'any',
			'post_status' => 'publish',
			'date_query' => array(
				'after' => array(
					'year' => date( 'Y' ),
					'month' => date( 'm' ),
					'day' => 1,
				),
			),
			'orderby' => 'date',
			'order' => 'DESC',
		);

		$query = new WP_Query( $args );

		ob_start();

		while( $query->have_posts() ) :
			$query->the_post(); ?>

			<h2><?php the_title(); ?></h2>
			By <?php the_author(); ?> on <?php echo get_the_date( 'l, F d, Y' ); ?>
			<?php the_excerpt(); ?>

		<?php endwhile;

		wp_reset_postdata();

		return ob_get_clean();
}