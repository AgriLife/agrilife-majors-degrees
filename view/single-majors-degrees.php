<?php
 /*Template Name: Research Project
 */
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
<<<<<<< HEAD
    wp_enqueue_style( 'majors-degrees-styles' );
=======

    wp_enqueue_style( 'majors-degrees-styles' );

>>>>>>> 4302b60c8b105fbd756c37266c63b9f7c494f634
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
                            ?><div class="rankings">
                                <h2>Courses</h2><?php
                                the_field('courses');
                            ?></div><?php
                        }
                        ?>
                    </div>
                    <div class="columns small-12 medium-4 large-4 rankings"><div class="rankings-wrap"><?php
                        if( !empty( get_field('rankings') ) ){
                            ?><h2>Rankings</h2><?php
                            the_field('rankings');
                        }
                    ?></div></div>
                </div>
            </div>
        </article>
    </div>
</div>
<?php
    endwhile;
endif;
get_footer(); ?>
