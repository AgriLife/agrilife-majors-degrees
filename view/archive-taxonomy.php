<?php
/**
 * The Template for displaying all keyword taxonomy posts
 */

// Queue styles
add_action( 'wp_enqueue_scripts', 'mjd_project_register_styles' );
add_action( 'wp_enqueue_scripts', 'mjd_project_enqueue_styles' );

function mjd_project_register_styles(){

	wp_register_style(
		'ag-majors-degrees-styles',
		AG_MAJDEG_DIR_URL . 'css/majors-degrees.css',
		array(),
		filemtime(AG_MAJDEG_DIR_PATH . 'css/majors-degrees.css'),
		'screen'
	);

}

function mjd_project_enqueue_styles(){

	wp_enqueue_style( 'ag-majors-degrees-styles' );

}

get_header();

?>
<div class="content-sidebar-wrap">
	<main id="genesis-content" class="content">
		<h1 class="entry-title"><a href="<?php echo get_post_type_archive_link( 'majors-and-degrees' ); ?>">Majors and Degrees tagged "<?php
		  $taxonomy = get_queried_object();
		  echo $taxonomy->name;
	  ?>"</a></h1><?php

		if( have_posts() ) :
			while( have_posts() ) : the_post();
				?>
				<header class="entry-header">
					<h2>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>
				</header>
				<div class="entry-content"><?php

					if( !empty( get_field('about_the_degree') ) ){

						$summary = wp_strip_all_tags( get_field('about_the_degree') );
						$summary = wp_trim_words( $summary, 55, '...' );
						echo '<p>' . $summary . '</p>';

					}

				?>
				</div><?php
			endwhile;
		endif;

		?>
		<div class="clearfix"></div>
		<div class="pagination">
		<?php
			echo paginate_links();
		?>
		</div>

	</main><!-- #content -->

	<?php get_sidebar(); ?>

</div><!-- #wrap -->

<?php get_footer(); ?>

