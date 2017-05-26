<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Chocolita
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

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

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
