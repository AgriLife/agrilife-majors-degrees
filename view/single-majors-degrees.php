<?php
 /*Template Name: Research Project
 */

// Queue assets
add_action( 'wp_enqueue_scripts', 'mjd_project_register' );
add_action( 'wp_enqueue_scripts', 'mjd_project_enqueue' );

function mjd_project_register(){

    wp_register_style(
        'majors-degrees-project-styles',
        AG_MAJDEG_DIR_URL . 'css/research-project.css',
        array(),
        '',
        'screen'
    );

}

function mjd_project_enqueue(){

    wp_enqueue_style( 'majors-degrees-project-styles' );

}

get_header();
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
?>
<div id="primary">
    <div id="content" role="main">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header row"><div class="columns">
                <h1><?php the_title(); ?></h1>
            </div></header>
            <div class="entry-content">
                <div class="row">
                    <div class="columns small-12 medium-7 large-7"><?php

                        $fields = get_fields();
                        if( !empty( get_field('about_the_degree') ) ){

                            ?><div class="about-the-degree">
                                <h2>About The Degree</h2><?php

                                the_field('about_the_degree');

                            ?></div><?php

                        }

                        if( !empty( get_field('careers') ) ){

                            ?><div class="careers">
                                <h2>Careers</h2><?php

                                the_field('careers');

                            ?></div><?php

                        }

                        if( !empty( get_field('courses') ) ){

                            ?><div class="rankings">
                                <h2>Courses</h2><?php

                                the_field('courses');

                            ?></div><?php

                        }

                        ?>
                    </div>
                    <div class="columns small-12 medium-5 large-5"><?php

                        if( !empty( get_field('rankings') ) ){

                            ?><h2>Rankings</h2><?php

                            the_field('rankings');

                        }

                    ?></div>
                </div>
            </div>
        </article>
    </div>
</div>
<?php
    endwhile;
endif;
get_footer(); ?>
