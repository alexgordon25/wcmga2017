<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Chocolita
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

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

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
