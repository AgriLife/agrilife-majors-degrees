<?php
/**
 * The Template for displaying all people single posts
 */

// Queue styles
add_action( 'wp_enqueue_scripts', 'mjd_project_register_styles' );
add_action( 'wp_enqueue_scripts', 'mjd_project_enqueue_styles' );

function mjd_project_register_styles(){
	?><script>console.log("register");</script><?php
    wp_register_style(
        'extension-majors-degrees-styles',
        AG_MAJDEG_DIR_URL . 'css/majors-degrees.css',
        array(),
        '',
        'screen'
    );

}

function mjd_project_enqueue_styles(){

    wp_enqueue_style( 'extension-majors-degrees-styles' );

}

get_header();

?>
<div class="content-sidebar-wrap">
	<main class="content">
		<h1 class="entry-title"><a href="<?php echo get_post_type_archive_link( 'majors-and-degrees' ); ?>">Majors and Degrees Archive</a></h1><?php
		$tq = new WP_Query(array(
			'post_type' => 'majors-and-degrees',
			'tax_query' => array(
				array(
					'taxonomy' => 'keyword',
					'field'    => 'slug',
					'terms'    => 'test',
				),
			),
		));
		echo '<pre>';
		print_r($tq);
		echo '</pre>';
		if(have_posts()){
			echo 'true';
		} else {
			echo 'false';
		}
		if( have_posts() ) :
			while( have_posts() ) : the_post();
				?>
				<header class="entry-header">
					<h1>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h1>
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

</div><!-- #wrap -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>

