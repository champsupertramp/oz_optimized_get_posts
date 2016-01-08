<?php
/**
 * Plugin Name:       Optimize Posts Queries
 * Plugin URI:        http://www.champ.ninja/
 * Description:       This plugin optimizes the posts queries.
 * Version:           1.0.0
 * Author:            Champ Camba
 * Author URI:        http://www.champ.ninja/
 * License:           MIT License (MIT)
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
  */

if ( ! function_exists( 'oz_optimized_get_posts' ) ){
	function oz_optimized_get_posts() {
	    global $wp_query, $wpdb;
	 	
	 	if( $wp_query->max_num_pages > 1 ){
		    $wp_query->query_vars['no_found_rows'] = 1;
		    $wp_query->found_posts = $wpdb->get_var( "SELECT COUNT(*) FROM wp_posts WHERE 1=1 AND wp_posts.post_type = 'post' AND (wp_posts.post_status = 'publish' OR wp_posts.post_status = 'private')" );
		    $wp_query->found_posts = apply_filters_ref_array( 'found_posts', array( $wp_query->found_posts, &$wp_query ) );
		 
		    $posts_per_page = ( ! empty( $wp_query->query_vars['posts_per_page'] ) ? $wp_query->query_vars['posts_per_page'] : get_option( 'posts_per_page' ) );
		    $wp_query->max_num_pages = ceil( $wp_query->found_posts / $posts_per_page );

		 }else{

		 	if( $query->is_main_query() ){
 
			    $query->set( 'no_found_rows', TRUE );
			 
			}
		 }
	 
	    return $wp_query;
	}
	add_filter( 'pre_get_posts', 'oz_optimized_get_posts', 100 );
}
?>