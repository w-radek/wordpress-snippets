<?php
/* Disable the Gutenberg editor. */
// add_filter('use_block_editor_for_post', '__return_false');
// add_filter('use_block_editor_for_post_type', '__return_false', 10);

show_admin_bar( false );
add_theme_support( 'menus' );
add_theme_support( 'post-thumbnails' );
add_image_size( 'largeRetina', 2048, 0, true );
add_filter( 'xmlrpc_enabled', '__return_false' );

register_nav_menu('left_main_menu', 'Left main menu');
register_nav_menu('right_main_menu', 'Right main menu');


remove_filter( 'the_excerpt', 'wpautop' );

/**
 * Disable edit themes in WP Panel
 */
define( 'DISALLOW_FILE_EDIT', true );

/**
 * Hide ACF Menu
 */
function hide_acf_menu() {
	$current_user = wp_get_current_user();
	if($current_user->ID != '1') {
		remove_menu_page('edit.php?post_type=acf-field-group');
	}
}
add_action('admin_menu', 'hide_acf_menu', 100);

/**
 * Scripts
 */
add_action( 'wp_enqueue_scripts', 'fsdegrees_enqueue_script', 20 );
function fsdegrees_enqueue_script() {
	if (!is_admin()) {
		wp_enqueue_script('main', get_bloginfo('template_url').'/public/js/app.min.js', false,false,true);

        wp_localize_script('main','sharedData',array(
            'contactForm' => do_shortcode('[contact-form-7 id="5" title="Contact form 1"]')
        ));
	}
}

add_action('init', 'fsdegrees_init_actions');
function fsdegrees_init_actions() {
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_action( 'wp_head', 'feed_links_extra', 3);
	remove_action( 'wp_head', 'feed_links', 2);
	remove_action( 'wp_head', 'rsd_link');
	remove_action( 'wp_head', 'wlwmanifest_link');
	remove_action( 'wp_head', 'index_rel_link');
	remove_action( 'wp_head', 'parent_post_rel_link', 10 ,0);
	remove_action( 'wp_head', 'start_post_rel_link', 10 ,0);
	remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0);
	remove_action( 'wp_head', 'wp_generator');
	remove_action( 'wp_head', 'rel_canonical');

	add_rewrite_rule(
		'^search\/([^\/]+)(\/in\/([^\/]+))?(\/page\/([^\/]+))?\/?$',
		'index.php?s=$matches[1]&sin=$matches[3]&paged=$matches[5]',
		'top' );
		
}

/**
 * Add custom logo in wp-admin
 */
function fsdegrees_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'fsdegrees_login_logo_url' );

function fsdegrees_login_logo_url_title() {
    return the_title();
}
add_filter( 'login_headertitle', 'fsdegrees_login_logo_url_title' );

function fsdegrees_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/public/images/logo-dark.svg);
			-webkit-background-size: contain;
         	-moz-background-size: contain;
            -o-background-size: contain;
			background-size: contain;
			background-repeat: no-repeat;
			height: 80px;
			width: 320px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'fsdegrees_login_logo' );

/**
 * Remove Admin Menu Link to Theme Customizer
 */
add_action( 'admin_menu', function () {
    global $submenu;

    if ( isset( $submenu[ 'themes.php' ] ) ) {
        foreach ( $submenu[ 'themes.php' ] as $index => $menu_item ) {
            if ( in_array( 'customize', $menu_item ) ) {
                unset( $submenu[ 'themes.php' ][ $index ] );
            }
        }
    }
});

function remove_menus(){
  	remove_menu_page( 'edit-comments.php' );          //Comments
}
add_action( 'admin_menu', 'remove_menus' );

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Options',
		'menu_title'	=> 'Options',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

/**
 * Customize Menu Item Classes
 * @author Bill Erickson
 * @link http://www.billerickson.net/customize-which-menu-item-is-marked-active/
 *
 * @param array $classes, current menu classes
 * @param object $item, current menu item
 * @param object $args, menu arguments
 * @return array $classes
 */
function be_menu_item_classes( $classes, $item, $args ) {

    if( ( is_singular( 'collections' ) ) && 'Collections' == $item->title )
        $classes[] = 'current-menu-item';

	return array_unique( $classes );
}
add_filter( 'nav_menu_css_class', 'be_menu_item_classes', 10, 3 );

add_action( 'pre_get_posts',  'set_posts_per_page'  );
function set_posts_per_page( $query ) {

	global $wp_the_query;

	// is_home 
	if ( ( ! is_admin() ) && ( $query === $wp_the_query ) && ( $query->is_home() ) ) {
		$query->set( 'posts_per_page', 1 );
	}
	// elseif ( ( ! is_admin() ) && ( $query === $wp_the_query ) && ( $query->is_home() ) ) {
	// 	$query->set( 'posts_per_page', 1 );
	// }
	// Etc..

	return $query;
}

/**
 * Custom navigation
 */

function wpbeginner_numeric_posts_nav() {

    if( is_singular() )
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<ul class="pagination">' . "\n";

    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link('<') );

    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>…</li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link('>') );

    echo '</ul>' . "\n";

}