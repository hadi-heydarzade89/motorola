<?php
/**
 * Template part for displaying posts
 *
 * @package Pharmacy Shop
 * @subpackage pharmacy_shop
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="box-info">
        <?php $pharmacy_shop_blog_archive_ordering = get_theme_mod('blog_meta_order', array('date', 'author', 'comment'));
        foreach ($pharmacy_shop_blog_archive_ordering as $pharmacy_shop_blog_data_order) : 
            if ('date' === $pharmacy_shop_blog_data_order) : ?>
              <i class="far fa-calendar-alt"></i><span class="entry-date"><?php echo get_the_date('j F, Y'); ?></span>
            <?php elseif ('author' === $pharmacy_shop_blog_data_order) : ?>
              <i class="fas fa-user"></i><span class="entry-author"><?php the_author(); ?></span>
            <?php elseif ('comment' === $pharmacy_shop_blog_data_order) : ?>
              <i class="fas fa-comments"></i><span class="entry-comments"><?php comments_number(__('0 Comments', 'pharmacy-shop'), __('0 Comments', 'pharmacy-shop'), __('% Comments', 'pharmacy-shop')); ?></span>
              <?php elseif ('category' === $pharmacy_shop_blog_data_order) :?>
                <i class="fas fa-list mb-1"></i><span class="entry-category"><?php pharmacy_shop_display_post_category_count(); ?></span>
            <?php endif;
        endforeach; ?>
    </div>
    <hr>
    <div class="box-content">
        <?php the_content(); ?>
        <?php if(get_theme_mod('pharmacy_shop_remove_tags',true) != ''){ 
            $tags = get_the_tags(); // Retrieve the post's tags
             custom_output_tags(); 
        }?>
        <?php if(get_theme_mod('pharmacy_shop_remove_category',true) != ''){ 
            if(has_category()){ 
                echo '<div class="post_category mt-3"> Category: ';
                the_category(', ');
                echo '</div>';
            }
        }?>
        <?php if( get_theme_mod( 'pharmacy_shop_remove_comment',true) != ''){ 
        // If comments are open or we have at least one comment, load up the comment template
        if ( comments_open() || '0' != get_comments_number() )
        comments_template();
        }


        if ( is_singular( 'attachment' ) ) {
            // Parent post navigation.
            the_post_navigation( array(
                'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'pharmacy-shop' ),
            ) );
        } elseif ( is_singular( 'post' ) ) {
            // Previous/next post navigation.
            the_post_navigation( array(
                'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next:', 'pharmacy-shop' ) . '</span> ' .
                    '<span class="post-title">%title</span>',
                'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous:', 'pharmacy-shop' ) . '</span> ' .
                    '<span class="post-title">%title</span>',
            ) );
        } ?>
        <div class="clearfix"></div>
    </div>
    <div class="mt-5"><?php get_template_part( 'template-parts/post/related-post'); ?></div>
</article>