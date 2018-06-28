<?php

// Queue assets
add_action( 'wp_enqueue_scripts', 'mjd_project_register' );
add_action( 'wp_enqueue_scripts', 'mjd_project_enqueue' );

function mjd_project_register(){

    wp_register_style(
        'majors-degrees-styles',
        AG_MAJDEG_DIR_URL . 'css/majors-degrees.css',
        array(),
        filemtime(AG_MAJDEG_DIR_PATH . 'css/majors-degrees.css'),
        'screen'
    );

}

function mjd_project_enqueue(){

    wp_enqueue_style( 'majors-degrees-styles' );

}

get_header();
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        $keyword_terms = wp_get_post_terms(get_the_ID(), 'keyword');
        $department_terms = wp_get_post_terms( get_the_ID(), 'department' );
        $degree_type_terms = wp_get_post_terms( get_the_ID(), 'degree-type' );

?>
<div id="primary">
    <div id="content" role="main">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header row"><div class="columns"><?php
                if( !empty( get_field('header_image') ) ):
                ?><div class="image-wrap"><img src="<?php the_field('header_image'); ?>"><?php
                endif; ?>
                <h1><span><?php the_title(); ?></span></h1><?php
                if( !empty( get_field('header_image') ) ){ ?></div><?php } ?>
            </div></header>
            <div class="entry-content">
                <div class="row">
                    <div class="columns small-12 medium-8 large-8"><?php

                        if( !empty( get_field('about_the_degree') ) ){

                            $has_meta_terms = !empty($department_terms) || !empty( $degree_type_terms ) ? true : false;

                            ?><div class="about-the-degree">
                                <h2<?php
                                // If has meta to show below the header, render class name.
                                if( $has_meta_terms ){
                                    echo ' class="has-terms"';
                                }
                                ?>>About The Degree</h2><?php

                                // Show the meta
                                if( $has_meta_terms ){

                                    ?><div class="meta-terms"><?php

                                    if( !empty($department_terms) ){

                                        foreach ($department_terms as $key => $value){

                                            $space = $key < 1 ? '' : ', ';

                                            $dept = sprintf('%s<span>%s</span>',
                                                $space,
                                                $value->name
                                            );

                                            echo $dept;

                                        }

                                    }

                                    if( !empty($degree_type_terms) ){

                                        if( !empty( $department_terms ) ){

                                            echo ', ';

                                        }

                                        foreach ($degree_type_terms as $key => $value){

                                            $space = $key < 1 ? '' : ', ';

                                            $deg = sprintf('%s<span>%s</span>',
                                                $space,
                                                $value->name
                                            );

                                            echo $deg;

                                        }

                                    }

                                    ?></div><?php

                                }

                                ?><?php

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

                            ?><div class="courses">
                                <h2>Courses</h2><?php

                                the_field('courses');

                            ?></div><?php

                        }

                        ?>
                    </div>
                    <div class="columns small-12 medium-4 large-4 right"><div class="taxonomy"><?php

                        $dept_ids = array();

                        if( !empty($department_terms) ){
                            ?><h2>Departments</h2><p><?php
                            foreach ($department_terms as $key => $value) {
                                if($key > 0){
                                    echo '<br>';
                                }
                                $dept = $value->name;
                                $link = get_option('taxonomy_' . $value->term_id . '_department-page');
                                if( !empty( $link ) ){
                                    $dept = '<a href="' . $link . '">' . $dept . '</a>';
                                }

                                echo $dept;
                                $dept_ids[] = $value->term_id;
                            }
                            ?></p><?php
                        }

                        $ranking = get_option('taxonomy_' . $dept_ids[0] . '_ranking');

                        if( !empty( $ranking ) ){

                            ?><h2>Ranking</h2><?php


                            $ranking = $ranking ? stripslashes( $ranking ) : '';
                            $ranking = html_entity_decode( $ranking );

                            echo $ranking;

                        }

                        if( !empty($degree_type_terms) ){
                            ?><h2>Degree Types</h2><p><?php
                            foreach ($degree_type_terms as $key => $value) {
                                if($key > 0){
                                    echo '<br>';
                                }
                                echo $value->name;
                            }
                            ?></p><?php
                        }

                        ?></div><?php

                        $contact = get_option('taxonomy_' . $dept_ids[0] . '_contact');

                        if( !empty( $contact ) ){

                            ?><div class="advisor-link-wrap"><a class="button" href="<?php
                                echo htmlspecialchars_decode( $contact );
                            ?>"><span class="line1">Want to know more?</span><span class="line2">Contact an Advisor</span></a></div><?php

                        }

                        // Add related posts
                        $tax_query = array(
                            'taxonomy' => 'keyword',
                            'field'    => 'slug',
                            'terms'    => array()
                        );

                        foreach ($keyword_terms as $key => $term) {
                            $tax_query['terms'][] = $term->slug;
                        }

                        $related_query_args = array(
                            'post_type'          => 'majors-and-degrees',
                            'post_status'        => 'any',
                            'posts_per_page'     => -1,
                            'orderby'            => 'title',
                            'order'              => 'ASC',
                            'tax_query'          => $tax_query
                        );

                        $related_query = new WP_Query( $related_query_args );

                        if( $related_query->have_posts() ){

                            echo '<div class="related-posts"><h2>Related Posts</h2>';
                            $output = array();

                            foreach ($related_query->posts as $key => $post) {

                                $output[] = sprintf('<a href="%s">%s</a>',
                                    get_permalink( $post->ID ),
                                    $post->post_title
                                );

                            }

                            echo implode(', ', $output);
                            echo '</div>';
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
