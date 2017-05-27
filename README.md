# Charlas y Talleres impartidos en el WordCamp Managua 2017

- [Charla: Realzando tu admin panel de WordPress.](#realzando-tu-admin-panel-de-wordpress)
- [Taller: Creando Temas Personalizados.](#creando-temas-personalizados)

# Realzando tu admin panel de WordPress.

Los siguientes code snippets están basado en una charla impartida por [Amanda Giles](https://twitter.com/AmandaGilesNH) en el [WordCamp Miami 2017](https://2017.miami.wordcamp.org). Thank you Amanda for your blessings.

## Presentación.

- [realzando-admin-panel-managua2017.pdf](https://github.com/alexgordon25/wcmga2017/raw/master/presentacion/realzando-admin-panel-managua2017.pdf)

## Agrega Estilos a tu pantalla de Login

```
<?php  
//Custom CSS for login page
function login_css() {
    wp_enqueue_style('login-page', 
         get_template_directory_uri() . '/css/login.css', false );
}

// Change logo link from wordpress.org to your site’s url
function login_url() { return home_url(); }

// Change the alt text on the logo to show your site’s name
function login_title() { return get_option('blogname'); }

// calling it only on the login page
add_action( 'login_enqueue_scripts', 'login_css', 10 );
add_filter( 'login_headerurl', 'login_url');
add_filter( 'login_headertitle', 'login_title');
?>
```

## Promociona tu persona / portafolio

```
<?php  
// Custom Backend Footer
function custom_admin_footer() { ?>

<span id="footer-thankyou">
Desarrollado por <a href="https://twitter.com/alexgordon25" target="_blank">Daniel Gordon</a>. Para cualquier asistencia en este sitio, por favor <a href="mailto:alexgordon25@gmail.com">escríbeme</a>.
<span>

<?php }

// adding it to the admin area
add_filter('admin_footer_text', 'custom_admin_footer');
?>
```
*Los 2 snippets presentados pertenecesn a Eddie Machado’s* [Bones theme](http://themble.com/bones/)

## Amplía la información de tus listados

### Agrega columnas a tus listados

```
<?php 
/* Adds new column headers to 'movies' post type */
function movies_add_new_columns($columns)  {
        //Remove irrelevant columns
        unset($columns['author']);
        unset($columns['comments']);
        unset($columns['date']);
    
	$columns['release'] = 'Release Date';
	return $columns;
}
add_filter('manage_edit-movies_columns', 'movies_add_new_columns');

/* Adds content to new columns for 'movies' post type */
function movies_manage_columns($column_name, $id) {
	global $post;
	switch ($column_name) {
		case 'release':
			echo get_post_meta( $post->ID , 'release-year' , true );
			break;
	} 
}
add_action('manage_movies_posts_custom_column', 'movies_manage_columns', 10, 2);
?>
```

### Convierte esa información en clasificable/ordenable

```
<?php 
/* Make new 'movies' columns sortable */
function movies_columns_sortable($columns) {
	$custom = array(
		'release' => 'release',
	);
	return wp_parse_args($custom, $columns);
}
add_filter('manage_edit-movies_sortable_columns', 'movies_columns_sortable');

/* Handle ordering for 'movies' columns */
function movies_columns_orderby( $vars ) {
     if ( isset( $vars['orderby'] ) ) {
          if ( 'release' == $vars['release'] ) 
	     $vars = array_merge( $vars, array(
                    'orderby' => 'meta_value_num', 'meta_key' => 'release-year') );
     }        
     return $vars;
}
add_filter( 'request', 'movies_columns_orderby' );
?>
```

### Agrega un filtro de taxonomía

```
<?php  
/* Adds a filter in the Admin list pages on taxonomy for easier locating */
function movie_genre_filter_admin_content() {
    global $typenow;    
    if( $typenow == "movies") { $taxonomies = array('genre'); }        
    if (isset($taxonomies)) {
        foreach ($taxonomies as $tax_slug) {
            $tax_obj = get_taxonomy($tax_slug);
            $tax_name = $tax_obj->labels->name;
            $terms = get_terms($tax_slug);
            echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
            echo "<option value=''>Show All $tax_name</option>";
            foreach ($terms as $term) { 
                $label = (isset($_GET[$tax_slug])) ? $_GET[$tax_slug] : ''; 
                echo '<option value='. $term->slug, 
                        $label == $term->slug ? ' selected="selected"' : '','>' . 
                        $term->name .'</option>';
            }
        }
    }
}
add_action( 'restrict_manage_posts', 'movie_genre_filter_admin_content' );
?>
```

## Agrega estilos a tu Content Editor

```
<?php   
// Apply styles to content editor to make it match the site
function add_custom_editor_style() {
    //Looks for an 'editor-style.css' in your theme folder
    add_editor_style();

    //Or call it with a custom file name if you choose
    //(helpful especially when keeping css in a subfolder)
    //add_editor_style('css/my-editor-style.css');
}
add_action( 'admin_init', 'add_custom_editor_style' );
?>
```

## Agrega Google Fonts en tu Content editor.

```
<?php  
/* Add Google Fonts to the Admin editor */
function add_google_fonts_admin_editor() {
   $font_url = 'https://fonts.googleapis.com/css?family=Oswald:400,700';

   //Encode Google Fonts URL if it contains commas
   add_editor_style( esc_url( $font_url ) );
}
add_action( 'admin_init', 'add_google_fonts_admin_editor' );
?>
```

## Agrega nuevas estilos en tu selector de estilos del TinyMCE

```
<?php  
/* 
 * Adding new TinyMCE styles to editor 
 * https://codex.wordpress.org/TinyMCE_Custom_Styles
 */

// Callback function to insert 'styleselect' into the $buttons array
function add_tiny_mce_buttons( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
// Register our callback to the appropriate filter (2 means 2nd row)
add_filter('mce_buttons_2', 'add_tiny_mce_buttons');

// Callback function to filter the Tiny MCE settings
function tiny_mce_add_styles( $init_array ) {  
	// Define the style_formats array
	$style_formats = array(  
		// Each array child is a format with its own settings
		array(  
			'title' => 'Titulo Azul',  
			'block' => 'div',  
			'classes' => 'blue-title'
		)
 	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );  
	
	return $init_array;  
} 
add_filter('tiny_mce_before_init','tiny_mce_add_styles' ); 
?>
```

## Agrega un nuevo Widget a tu Dashboard

```
<?php  
//Add widget to dashboard page
function add_movies_dashboard_widgets() {
   wp_add_dashboard_widget('movies-widget', 'Recent Movies', 'movies_dashboard_widget');
}
add_action('wp_dashboard_setup', 'add_movies_dashboard_widgets');

//Dashboard widget logic (can be anything!)
function movies_dashboard_widget() {
    $args = array ( 'post_type' => 'movies', 'posts_per_page' => 5 );
    $movies = new WP_Query( $args );

    if($movies->have_posts()) : 
        while($movies->have_posts()): $movies->the_post();
            echo '<div style="margin-bottom: 10px;">';
            $url = home_url() . "/wp-admin/post.php?post=" . get_the_id() . '&action=edit';
            echo '<a href="' . $url . '">' . get_the_title() . '</a> - ';
            echo get_post_meta( get_the_id(), 'release-year' , true ) . '</div>'; 
        endwhile;
    endif;        
}
?>
```

## Agrega un enlace en tu Admin Bar

```
<?php   
//Add Links to Admin Bar
function movie_admin_bar_link( $wp_admin_bar ) {
    //Only add link for Admins
    if (current_user_can( 'manage_options' )) {
	$args = array(
	    'id'    => 'movies-page',
	    'title' => 'Manage Movies',
	    'href'  => home_url() . '/wp-admin/edit.php?post_type=movies',
	    'meta'  => array( 'class' => 'movies-admin-link' )
	);
        $wp_admin_bar->add_node( $args );
    }
}
add_action( 'admin_bar_menu', 'movie_admin_bar_link' );
?>
```


# Creando Temas Personalizados.

## Presentación.

- [custom-themes-managua2017.pdf](https://github.com/alexgordon25/wcmga2017/raw/master/presentacion/custom-themes-managua2017.pdf)

## Caso de Ejemplo.

Se requiere un sitio web con una sección principal de catálogo de Películas y otra de Noticias, el resto de paginas del sitio son estáticas.

PORTADA
	- PELICULAS
	- NOTICIAS

### Herramientas utilizadas.
- [Tema base de Chocolita](https://github.com/monchitonet/Chocolita)
- [WP Generate](https://generatewp.com/)
- [Advanced Custom Fields](https://www.advancedcustomfields.com/)
- [Plugin ACF Pro](https://github.com/alexgordon25/wcmga2017/blob/master/advanced-custom-fields-pro.zip)

### Registro de "Custom Post Type" Película.

Agregar al final de function.php

```php
function register_movie_post_type() {

	$labels = array(
		'name'                  => _x( 'Películas', 'Post Type General Name', 'Chocolita' ),
		'singular_name'         => _x( 'Película', 'Post Type Singular Name', 'Chocolita' ),
		'menu_name'             => __( 'Películas', 'Chocolita' ),
		'name_admin_bar'        => __( 'Película', 'Chocolita' ),
		'archives'              => __( 'Item Archives', 'Chocolita' ),
		'parent_item_colon'     => __( 'Parent Item:', 'Chocolita' ),
		'all_items'             => __( 'All Items', 'Chocolita' ),
		'add_new_item'          => __( 'Agregar Nueva Película', 'Chocolita' ),
		'add_new'               => __( 'Agregar Película', 'Chocolita' ),
		'new_item'              => __( 'Nueva Película', 'Chocolita' ),
		'edit_item'             => __( 'Editar Película', 'Chocolita' ),
		'update_item'           => __( 'Actualizar Película', 'Chocolita' ),
		'view_item'             => __( 'Ver Película', 'Chocolita' ),
		'search_items'          => __( 'Search Item', 'Chocolita' ),
		'not_found'             => __( 'Not found', 'Chocolita' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'Chocolita' ),
		'featured_image'        => __( 'Featured Image', 'Chocolita' ),
		'set_featured_image'    => __( 'Set featured image', 'Chocolita' ),
		'remove_featured_image' => __( 'Remove featured image', 'Chocolita' ),
		'use_featured_image'    => __( 'Use as featured image', 'Chocolita' ),
		'insert_into_item'      => __( 'Insert into item', 'Chocolita' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'Chocolita' ),
		'items_list'            => __( 'Items list', 'Chocolita' ),
		'items_list_navigation' => __( 'Items list navigation', 'Chocolita' ),
		'filter_items_list'     => __( 'Filter items list', 'Chocolita' ),
	);
	$rewrite = array(
		'slug'                  => 'pelicula',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Película', 'Chocolita' ),
		'description'           => __( 'Películas para Chocolita', 'Chocolita' ),
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
```

### Registro de "Custom Taxonomy" Género

Agregar al final de function.php

```php
function register_genre_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Géneros', 'Taxonomy General Name', 'Chocolita' ),
		'singular_name'              => _x( 'Género', 'Taxonomy Singular Name', 'Chocolita' ),
		'menu_name'                  => __( 'Géneros', 'Chocolita' ),
		'all_items'                  => __( 'All Items', 'Chocolita' ),
		'parent_item'                => __( 'Parent Item', 'Chocolita' ),
		'parent_item_colon'          => __( 'Parent Item:', 'Chocolita' ),
		'new_item_name'              => __( 'Agregar Género', 'Chocolita' ),
		'add_new_item'               => __( 'Agregar Nuevo Género', 'Chocolita' ),
		'edit_item'                  => __( 'Editar Género', 'Chocolita' ),
		'update_item'                => __( 'Actualizar Género', 'Chocolita' ),
		'view_item'                  => __( 'Ver Género', 'Chocolita' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'Chocolita' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'Chocolita' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'Chocolita' ),
		'popular_items'              => __( 'Popular Items', 'Chocolita' ),
		'search_items'               => __( 'Search Items', 'Chocolita' ),
		'not_found'                  => __( 'Not Found', 'Chocolita' ),
		'no_terms'                   => __( 'No items', 'Chocolita' ),
		'items_list'                 => __( 'Items list', 'Chocolita' ),
		'items_list_navigation'      => __( 'Items list navigation', 'Chocolita' ),
	);
	$rewrite = array(
		'slug'                       => 'genero',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
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
```
Duplicar index.php con un nuevo nombre front-page.php y le agregamos un WP_Query en la parte de contenido.

```php
$peliculas = new WP_Query(array(
	'post_type' => 'movie'
));

while ( $peliculas->have_posts() ) : 
	$peliculas->the_post(); ?>

	<div class="item">
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<img src="<?php echo get_field('imagen')['sizes']['thumbnail']; ?>">
		<?php the_content(); ?>
	</div>
	<hr>

<?php
endwhile;
wp_reset_postdata();
```
Duplicar single.php con un nuevo nombre single-movie.php y le rendirizamos los custom fields en la parte de contenido.

```php
while ( have_posts() ) : the_post(); ?>

	<article>
		<h2><?php the_title(); ?></h2>
		<p><?php the_terms($post->ID, 'genre'); ?></p>
		<?php the_content(); ?>

		<p>Director: <?php the_field('director'); ?></p>

		<p>Actores:</p>

			<?php
			if (have_rows('actores')) :
				echo '<ul>';
				while ( have_rows('actores')) : the_row();
					echo '<li>';
					the_sub_field('actor');
					echo '</li>';
				endwhile;
				echo '</ul>';
			endif;
			?>

		<p>Fecha: <?php the_field('fecha'); ?></p>

		<img width="300" src="<?php echo get_field('imagen')['url']; ?>">
		
		<div>
			<p>Trailer:</p>
			<?php the_field('trailer'); ?>
		</div>
	</article>
	
	<?php
	the_post_navigation();

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;

endwhile; // End of the loop.
```



