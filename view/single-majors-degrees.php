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

                            ?><div class="courses">
                                <h2>Courses</h2><?php

                                the_field('courses');

                            ?></div><?php

                        }

                        ?>
                    </div>
                    <div class="columns small-12 medium-4 large-4 right"><div class="taxonomy"><?php

                        $department_terms = wp_get_post_terms( get_the_ID(), 'department' );
                        $dept_ids = array();

                        if( !empty($department_terms) ){
                            ?><h2>Departments</h2><p><?php
                            foreach ($department_terms as $key => $value) {
                                if($key > 0){
                                    echo '<br>';
                                }
                                echo $value->name;
                                $dept_ids[] = $value->term_id;
                            }
                            ?></p><?php
                        }

                        if( !empty( $dept_ids ) ){

                            ?><h2>Ranking</h2><?php

                            foreach ($dept_ids as $key => $value) {
                                echo htmlspecialchars_decode( get_option("taxonomy_{$value}_ranking") );
                            }

                        }

                        $degree_type_terms = wp_get_post_terms( get_the_ID(), 'degree-type' );
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
