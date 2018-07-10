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

                $header_image = get_field('header_image');

                if( !empty( $header_image ) ):

                    $size_urls = $header_image['sizes'];

                    $srcset = sprintf( '%s 720w, %s 1110w, %s 2220w',
                        $size_urls['majors-and-degrees-header-medium'],
                        $size_urls['majors-and-degrees-header-large'],
                        $size_urls['majors-and-degrees-header-max']
                    );

                    $sizes = sprintf('%s, %s, %s',
                        '(max-width: 720px) 720px',
                        '(max-width: 1200px) 1110px',
                        '2220px'
                    );

                    $header_image_output = sprintf( '<div class="image-wrap"><img src="%s" srcset="%s" sizes="%s">',
                        $size_urls['majors-and-degrees-header-max'],
                        $srcset,
                        $sizes
                    );

                    echo $header_image_output;

                endif; ?>
                <h1><span><?php the_title(); ?></span></h1><?php
                if( !empty( $header_image ) ){ ?></div><?php } ?>
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

                                    if( !empty($degree_type_terms) ){

                                        foreach ($degree_type_terms as $key => $value){

                                            $space = $key < 1 ? '' : ', ';

                                            $deg = sprintf('%s<span>%s Degree</span>',
                                                $space,
                                                $value->name
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

                        foreach ($department_terms as $key => $value) {
                            $dept_ids[] = $value->term_id;
                        }

                        $ranking = get_option('taxonomy_' . $dept_ids[0] . '_ranking');

                        if( !empty( $ranking ) ){

                            ?><h2>Ranking</h2><?php


                            $ranking = $ranking ? stripslashes( $ranking ) : '';
                            $ranking = html_entity_decode( $ranking );

                            echo $ranking;

                        }

                        ?></div><?php

                        $contact = get_option('taxonomy_' . $dept_ids[0] . '_contact');

                        if( !empty( $contact ) ){

                            ?><div class="advisor-link-wrap"><a class="button" href="<?php
                                echo htmlspecialchars_decode( $contact );
                            ?>"><span class="line1">Want to know more?</span><span class="line2">Contact an Advisor</span></a></div><?php

                        }

                        /* Add related posts
                         * Related posts are currently defined as:
                         * Any post which shares two of this post's keywords
                         */
                        // Get an array of tax slugs
                        $keywords = array_map(create_function('$o', 'return $o->slug;'), $keyword_terms);

                        if( count( $keywords ) > 1 ){

                            $tax_query = array(
                                'relation' => 'OR'
                            );

                            // Make an array of every combination of two terms
                            function two_combo_picker($arr, $temp_string, &$collect) {
                                foreach($arr as $key => $item){
                                    foreach($arr as $key2 => $item2){
                                        if($key !== $key2){
                                            $to_add = array(
                                                $arr[$key],
                                                $item2
                                            );
                                            sort($to_add);
                                            if(!in_array($to_add, $collect)){
                                                $collect[] = $to_add;
                                            }
                                        }
                                    }
                                }
                            }

                            $collection = array();
                            two_combo_picker($keywords, "", $collection);

                            foreach ($collection as $key => $terms) {

                                $tax_query[] = array(
                                    'taxonomy' => 'keyword',
                                    'field'    => 'slug',
                                    'terms'    => $terms,
                                    'operator' => 'AND'
                                );

                            }

                        } else {

                            $tax_query = array(
                                'taxonomy' => 'keyword',
                                'field'    => 'slug',
                                'terms'    => array()
                            );

                            foreach ($keyword_terms as $key => $term) {

                                $tax_query['terms'][] = $term->slug;

                            }

                        }

                        $post_limit = 5;
                        $related_query_args = array(
                            'post_type'          => 'majors-and-degrees',
                            'post_status'        => 'any',
                            'posts_per_page'     => -1,
                            'orderby'            => 'title',
                            'order'              => 'ASC',
                            'tax_query'          => $tax_query,
                            'post__not_in'       => array( get_the_ID() ),
                            'posts_per_page'     => $post_limit
                        );

                        $related_query = new WP_Query( $related_query_args );
                        $related_posts = $related_query->have_posts() ? $related_query->posts : array();
                        $related_posts_length = $related_query->have_posts() ? count( $related_posts ) : 0;

                        if( $related_posts_length < $post_limit ){

                            $related_query_args['posts_per_page'] = $post_limit - $related_posts_length;
                            $related_query_args['tax_query'] = array(
                                'taxonomy' => 'keyword',
                                'field'    => 'slug',
                                'terms'    => $keywords
                            );

                            $related_query = new WP_Query( $related_query_args );

                            if( $related_query->have_posts ){
                                $related_posts = array_merge( $related_query->posts, $related_posts );
                            }
                        }

                        if( count( $related_posts ) > 0 ){

                            echo '<div class="related-posts"><h2>Related Posts</h2>';

                            // List the related post links
                            $output = array();

                            foreach ($related_query->posts as $key => $post) {

                                $output[] = sprintf('<a href="%s">%s</a>',
                                    get_permalink( $post->ID ),
                                    $post->post_title
                                );

                            }

                            echo implode('   |   ', $output);

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
