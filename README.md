# Creando Temas Personalizados.

## Presentación.

- [custom-themes-managua2017.pdf](https://github.com/alexgordon25/wcmga2017/blob/master/presentacion/custom-themes-managua2017.pdf)

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

```
<?php
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
?>
```
Duplicar single.php con un nuevo nombre single-movie.php y le rendirizamos los custom fields en la parte de contenido.

```
<?php
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
?>
```



