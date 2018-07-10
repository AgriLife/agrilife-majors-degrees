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
		<h1 class="entry-title"><a href="<?php echo get_post_type_archive_link( 'majors-and-degrees' ); ?>">Majors and Degrees</a></h1><?php

		$taxonomy = get_queried_object();

		$shortcode = sprintf( '[search_form_majors_and_degrees heading="%s" value="%s"]',
			'Search: ',
			$taxonomy->name
		);

	  echo do_shortcode( $shortcode );

		if( have_posts() ) :
			while( have_posts() ) : the_post();
				?>
				<div class="about-the-degree"><header class="entry-header">
					<h2<?php

		        $department_terms = wp_get_post_terms( get_the_ID(), 'department' );
		        $degree_type_terms = wp_get_post_terms( get_the_ID(), 'degree-type' );
            $has_meta_terms = !empty($department_terms) || !empty( $degree_type_terms ) ? true : false;

            // If has meta to show below the header, render class name.
            if( $has_meta_terms ){
                echo ' class="has-terms"';
            }

          ?>><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php

            // Show the meta
            if( $has_meta_terms ){

              ?><div class="meta-terms"><?php

              if( !empty($degree_type_terms) ){

                foreach ($degree_type_terms as $key => $value){

                  $name = $value->name;
                  $length = count($degree_type_terms);
                  $space = '';

                  if($key > 0){

                    $space .= $length > 2 ? ', ' : ' ';

                    if($key === $length - 1){
                      $space .= 'and ';
                    }

                  }

                  if($key === $length - 1){
                    $name .= ' Degree';
                  }

                  $deg = sprintf('%s<span>%s</span>',
                    $space,
                    $name
                  );

                  echo $deg;

                }

              }

              if( !empty($department_terms) ){

                if( !empty( $degree_type_terms ) ){

                  echo ', ';

                }

                foreach ($department_terms as $key => $value){

                  $space = $key < 1 ? '' : ', ';

                  $dept_name = $value->name . ' Department';

                  $link = get_option('taxonomy_' . $value->term_id . '_department-page');

                  if( !empty( $link ) ){
                    $dept_name = '<a href="' . $link . '">' . $dept_name . '</a>';
                  }

                  $dept = sprintf('%s<span>%s</span>',
                    $space,
                    $dept_name
                  );

                  echo $dept;

                }

              }

              ?></div><?php

            }

          ?>
				</header>
				<div class="entry-content"><?php

					if( !empty( get_field('about_the_degree') ) ){

						$summary = wp_strip_all_tags( get_field('about_the_degree') );
						$summary = wp_trim_words( $summary, 55, '...' );
						echo '<p>' . $summary . '</p>';

					}

				?>
				</div></div><?php
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

