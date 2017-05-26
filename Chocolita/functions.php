<?php
/**
 * Chocolita functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Chocolita
 */

if ( ! function_exists( 'chocolita_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function chocolita_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Chocolita, use a find and replace
	 * to change 'chocolita' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'chocolita', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'chocolita' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'chocolita_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'chocolita_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function chocolita_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'chocolita_content_width', 640 );
}
add_action( 'after_setup_theme', 'chocolita_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function chocolita_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'chocolita' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'chocolita' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'chocolita_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function chocolita_scripts() {
	wp_enqueue_style( 'chocolita-style', get_stylesheet_uri() );

	wp_enqueue_script( 'chocolita-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'chocolita-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'chocolita_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


// Register Custom Post Type
function register_movie_post_type() {

	$labels = array(
		'name'                  => _x( 'Películas', 'Post Type General Name', 'wpcampcr' ),
		'singular_name'         => _x( 'Película', 'Post Type Singular Name', 'wpcampcr' ),
		'menu_name'             => __( 'Películas', 'wpcampcr' ),
		'name_admin_bar'        => __( 'Película', 'wpcampcr' ),
		'archives'              => __( 'Item Archives', 'wpcampcr' ),
		'parent_item_colon'     => __( 'Parent Item:', 'wpcampcr' ),
		'all_items'             => __( 'All Items', 'wpcampcr' ),
		'add_new_item'          => __( 'Agregar Nueva Película', 'wpcampcr' ),
		'add_new'               => __( 'Agregar Película', 'wpcampcr' ),
		'new_item'              => __( 'Nueva Película', 'wpcampcr' ),
		'edit_item'             => __( 'Editar Película', 'wpcampcr' ),
		'update_item'           => __( 'Actualizar Película', 'wpcampcr' ),
		'view_item'             => __( 'Ver Película', 'wpcampcr' ),
		'search_items'          => __( 'Search Item', 'wpcampcr' ),
		'not_found'             => __( 'Not found', 'wpcampcr' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'wpcampcr' ),
		'featured_image'        => __( 'Featured Image', 'wpcampcr' ),
		'set_featured_image'    => __( 'Set featured image', 'wpcampcr' ),
		'remove_featured_image' => __( 'Remove featured image', 'wpcampcr' ),
		'use_featured_image'    => __( 'Use as featured image', 'wpcampcr' ),
		'insert_into_item'      => __( 'Insert into item', 'wpcampcr' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'wpcampcr' ),
		'items_list'            => __( 'Items list', 'wpcampcr' ),
		'items_list_navigation' => __( 'Items list navigation', 'wpcampcr' ),
		'filter_items_list'     => __( 'Filter items list', 'wpcampcr' ),
	);
	$rewrite = array(
		'slug'                  => 'pelicula',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Película', 'wpcampcr' ),
		'description'           => __( 'Películas para wpcampcr', 'wpcampcr' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-format-video',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
	);
	register_post_type( 'movie', $args );

}
add_action( 'init', 'register_movie_post_type', 0 );

// Register Custom Taxonomy
function register_genre_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Géneros', 'Taxonomy General Name', 'wpcampcr' ),
		'singular_name'              => _x( 'Género', 'Taxonomy Singular Name', 'wpcampcr' ),
		'menu_name'                  => __( 'Géneros', 'wpcampcr' ),
		'all_items'                  => __( 'All Items', 'wpcampcr' ),
		'parent_item'                => __( 'Parent Item', 'wpcampcr' ),
		'parent_item_colon'          => __( 'Parent Item:', 'wpcampcr' ),
		'new_item_name'              => __( 'Agregar Género', 'wpcampcr' ),
		'add_new_item'               => __( 'Agregar Nuevo Género', 'wpcampcr' ),
		'edit_item'                  => __( 'Editar Género', 'wpcampcr' ),
		'update_item'                => __( 'Actualizar Género', 'wpcampcr' ),
		'view_item'                  => __( 'Ver Género', 'wpcampcr' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'wpcampcr' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'wpcampcr' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'wpcampcr' ),
		'popular_items'              => __( 'Popular Items', 'wpcampcr' ),
		'search_items'               => __( 'Search Items', 'wpcampcr' ),
		'not_found'                  => __( 'Not Found', 'wpcampcr' ),
		'no_terms'                   => __( 'No items', 'wpcampcr' ),
		'items_list'                 => __( 'Items list', 'wpcampcr' ),
		'items_list_navigation'      => __( 'Items list navigation', 'wpcampcr' ),
	);
	$rewrite = array(
		'slug'                       => 'genero',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'genre', array( 'movie' ), $args );

}
add_action( 'init', 'register_genre_taxonomy', 0 );
