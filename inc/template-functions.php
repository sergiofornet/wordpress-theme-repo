<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Wordpress_Theme_Repo
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wordpress_theme_repo_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'wordpress_theme_repo_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function wordpress_theme_repo_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'wordpress_theme_repo_pingback_header' );

// /**
//  * Disable support for comments and trackbacks in post types.
//  */ 

// function wordpress_theme_repo_disable_comments_post_types_support() {
// 	$post_types = get_post_types();
// 	foreach ( $post_types as $post_type ) {
// 		if( post_type_supports( $post_type, 'comments' ) ) {
// 			remove_post_type_support( $post_type, 'comments' );
// 			remove_post_type_support( $post_type, 'trackbacks' );
// 		}
// 	}
// }
// add_action( 'admin_init', 'wordpress_theme_repo_disable_comments_post_types_support' );

// /**
//  * Close comments on the front-end.
//  */ 
// function wordpress_theme_repo_disable_comments_status() {
// 	return false;
// }
// add_filter( 'comments_open', 'wordpress_theme_repo_disable_comments_status', 20, 2);
// add_filter( 'pings_open', 'wordpress_theme_repo_disable_comments_status', 20, 2 );

// /**
//  * Hide existing comments.
//  */ 
// function wordpress_theme_repo_disable_comments_hide_existing_comments( $comments ) {
// 	$comments = array();
// 	return $comments;
// }
// add_filter( 'comments_array', 'wordpress_theme_repo_disable_comments_hide_existing_comments', 10, 2 );

// /**
//  * Remove comments page in menu.
//  */
// function wordpress_theme_repo_disable_comments_admin_menu() {
// 	remove_menu_page( 'edit-comments.php' );
// }
// add_action( 'admin_menu', 'wordpress_theme_repo_disable_comments_admin_menu' );

// /**
//  * Remove comments page in admin bar.
//  */
// function wordpress_theme_repo_disable_admin_bar_comments() {
//     global $wp_admin_bar;
//     $wp_admin_bar->remove_menu( 'comments' );
// }
// add_action( 'wp_before_admin_bar_render', 'wordpress_theme_repo_disable_admin_bar_comments' );

// /**
//  * Redirect any user trying to access comments page.
//  */
// function wordpress_theme_repo_disable_comments_admin_menu_redirect() {
// 	global $pagenow;
// 	if ( $pagenow === 'edit-comments.php' ) {
// 		wp_redirect( admin_url() ); exit;
// 	}
// }
// add_action( 'admin_init', 'wordpress_theme_repo_disable_comments_admin_menu_redirect' );

// /**
//  * Remove comments metabox from dashboard.
//  */
// function wordpress_theme_repo_disable_comments_dashboard() {
// 	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
// }
// add_action( 'admin_init', 'wordpress_theme_repo_disable_comments_dashboard' );

// /**
//  * Remove comments links from admin bar.
//  */
// function wordpress_theme_repo_disable_comments_admin_bar() {
// 	if ( is_admin_bar_showing() ) {
// 		remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
// 	}
// }
// add_action( 'init', 'wordpress_theme_repo_disable_comments_admin_bar' );

// /**
//  * Disable html in comments.
//  */
// add_filter( 'pre_comment_content', 'esc_html' );

/**
 * Remove meta tags from wp_header.
 */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );

/**
 * Remove RSS feeds.
 */
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );

/**
 * Disable login hints.
 */
function wordpress_theme_repo_login_errors() {
	return 'nop';
}
add_filter( 'login_errors', 'wordpress_theme_repo_login_errors' );

/** 
 * Disable url guess.
 */
function wordpress_theme_repo_stop_guessing( $url ) {
	if ( is_404() ) {
		return false;
	}
	return $url;
}
add_filter( 'redirect_canonical', 'wordpress_theme_repo_stop_guessing' );

/**
 * Remove WP emojis.
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );

/**
 * Disable access to author pages
 */
function wordpress_theme_repo_disable_author_page() {
	
	global $wp_query;
	
    if ( is_author() ) {
		
		// show a 404 page
        $wp_query->set_404();
		status_header( 404 );
		
    }
}
add_action( 'template_redirect', 'wordpress_theme_repo_disable_author_page');

/**
 * Modify default queries
 */
// function wordpress_theme_repo_modify_queries( $query ) {
	
// };
// add_action( 'pre_get_posts', 'wordpress_theme_repo_modify_queries' ); 