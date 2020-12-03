<?php get_header(); ?>

<?php 
    // Custom WP query queryblog
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args_queryblog = array(
        'post_type' => array('post'),
        'posts_per_page' => 1,
        'order' => 'DESC',
        'paged' => $paged,
    );

    $queryblog = new WP_Query( $args_queryblog );

    if ( $queryblog->have_posts() ) : 
?>
    <?php while ( $queryblog->have_posts() ) : $queryblog->the_post(); ?>
    <div>
        <a href="<?php the_permalink(); ?>" title="<?php echo the_title(); ?>"><?php echo the_title(); ?></a>
        <?php echo get_field('content'); ?>
    </div>
    <?php endwhile; ?>

    <?php wpbeginner_numeric_posts_nav(); ?>
<?php else : ?>

<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>