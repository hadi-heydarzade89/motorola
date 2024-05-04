<?php
/**
 * Template part for displaying posts
 *
 * @package Pharmacy Shop
 * @subpackage pharmacy_shop
 */
?>

<?php $pharmacy_shop_column_layout = get_theme_mod( 'pharmacy_shop_sidebar_post_layout');
if($pharmacy_shop_column_layout == 'four-column' || $pharmacy_shop_column_layout == 'three-column' ){ ?>
  <div id="category-post">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <div class="page-box">
        <?php if (!is_single() && function_exists('get_post_gallery')) {
          $gallery = get_post_gallery(get_the_ID(), false);
          if ($gallery && isset($gallery['ids'])) { 
            $gallery_ids = explode(',', $gallery['ids']); ?>
            <div class="container entry-gallery">
              <div class="row">
                <?php $pharmacy_shop_max_images = min(count($gallery_ids), 4);
                for ($index = 0; $index < $pharmacy_shop_max_images; $index++) {
                  $id = $gallery_ids[$index];
                  $pharmacy_shop_image_url = wp_get_attachment_image_url($id, 'full'); ?>
                  <div class="col-md-6 mb-1 align-self-center">
                    <img class="img-fluid" src="<?php echo esc_url($pharmacy_shop_image_url); ?>" alt="Gallery Image <?php echo ($index + 1); ?>">
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php }
        } ?>
        <div class="box-content mt-2 text-center">
            <h4><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a></h4>
          <div class="box-info">
                <?php $pharmacy_shop_blog_archive_ordering = get_theme_mod('blog_meta_order', array('date', 'author', 'comment', 'category'));
                foreach ($pharmacy_shop_blog_archive_ordering as $pharmacy_shop_blog_data_order) : 
                  if ('date' === $pharmacy_shop_blog_data_order) : ?>
                    <i class="far fa-calendar-alt mb-1"></i><span class="entry-date"><?php echo get_the_date('j F, Y'); ?></span>
                  <?php elseif ('author' === $pharmacy_shop_blog_data_order) : ?>
                    <i class="fas fa-user mb-1"></i><span class="entry-author"><?php the_author(); ?></span>
                  <?php elseif ('comment' === $pharmacy_shop_blog_data_order) : ?>
                    <i class="fas fa-comments mb-1"></i><span class="entry-comments"><?php comments_number(__('0 Comments', 'pharmacy-shop'), __('0 Comments', 'pharmacy-shop'), __('% Comments', 'pharmacy-shop')); ?></span>
                    <?php elseif ('category' === $pharmacy_shop_blog_data_order) :?>
                          <i class="fas fa-list mb-1"></i><span class="entry-category"><?php pharmacy_shop_display_post_category_count(); ?></span>
                  <?php endif;
                endforeach; ?>
          </div>
          <p><?php echo esc_html(pharmacy_shop_excerpt_function());?></p>
          <?php if(get_theme_mod('pharmacy_shop_remove_read_button',true) != ''){ ?>
            <div class="readmore-btn">
              <a href="<?php echo esc_url( get_permalink() );?>" class="blogbutton-small" title="<?php esc_attr_e( 'Read More', 'pharmacy-shop' ); ?>"><?php echo esc_html(get_theme_mod('pharmacy_shop_read_more_text',__('Read More','pharmacy-shop')));?></a>
            </div>
          <?php }?>
        </div>
        <div class="clearfix"></div>
      </div>
    </article>
  </div>
<?php } else{ ?>
<div id="category-post">
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="page-box row">
      <?php $pharmacy_shop_post_layout = get_theme_mod( 'pharmacy_shop_post_layout','image-content');
      if($pharmacy_shop_post_layout == 'image-content'){ ?>
        <div class="col-lg-6 col-md-12 align-self-center">
          <?php if (!is_single() && function_exists('get_post_gallery')) {
            $gallery = get_post_gallery(get_the_ID(), false);
            if ($gallery && isset($gallery['ids'])) {  
              $gallery_ids = explode(',', $gallery['ids']); ?>
              <div class="container entry-gallery">
                <div class="row">
                  <?php $pharmacy_shop_max_images = min(count($gallery_ids), 4);
                  for ($index = 0; $index < $pharmacy_shop_max_images; $index++) {
                    $id = $gallery_ids[$index];
                    $pharmacy_shop_image_url = wp_get_attachment_image_url($id, 'full'); ?>
                    <div class="col-md-6 mb-1 align-self-center">
                      <img class="img-fluid" src="<?php echo esc_url($pharmacy_shop_image_url); ?>" alt="Gallery Image <?php echo ($index + 1); ?>">
                    </div>
                  <?php } ?>
                </div>
              </div>
            <?php }
          } ?>
        </div>
        <div class="box-content col-lg-6 col-md-12">
          <h4><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a></h4>
          <div class="box-info">
                <?php $pharmacy_shop_blog_archive_ordering = get_theme_mod('blog_meta_order', array('date', 'author', 'comment', 'category'));
                foreach ($pharmacy_shop_blog_archive_ordering as $pharmacy_shop_blog_data_order) : 
                  if ('date' === $pharmacy_shop_blog_data_order) : ?>
                    <i class="far fa-calendar-alt mb-1"></i><span class="entry-date"><?php echo get_the_date('j F, Y'); ?></span>
                  <?php elseif ('author' === $pharmacy_shop_blog_data_order) : ?>
                    <i class="fas fa-user mb-1"></i><span class="entry-author"><?php the_author(); ?></span>
                  <?php elseif ('comment' === $pharmacy_shop_blog_data_order) : ?>
                    <i class="fas fa-comments mb-1"></i><span class="entry-comments"><?php comments_number(__('0 Comments', 'pharmacy-shop'), __('0 Comments', 'pharmacy-shop'), __('% Comments', 'pharmacy-shop')); ?></span>
                    <?php elseif ('category' === $pharmacy_shop_blog_data_order) :?>
                          <i class="fas fa-list mb-1"></i><span class="entry-category"><?php pharmacy_shop_display_post_category_count(); ?></span>
                  <?php endif;
                endforeach; ?>
          </div>
          <p><?php echo esc_html(pharmacy_shop_excerpt_function());?></p>
          <?php if(get_theme_mod('pharmacy_shop_remove_read_button',true) != ''){ ?>
            <div class="readmore-btn">
              <a href="<?php echo esc_url( get_permalink() );?>" class="blogbutton-small" title="<?php esc_attr_e( 'Read More', 'pharmacy-shop' ); ?>"><?php echo esc_html(get_theme_mod('pharmacy_shop_read_more_text',__('Read More','pharmacy-shop')));?></a>
            </div>
          <?php }?>
        </div>
      <?php }
      else if($pharmacy_shop_post_layout == 'content-image'){ ?>
        <div class="box-content col-lg-6 col-md-12">
          <h4><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a></h4>
          <div class="box-info">
                <?php $pharmacy_shop_blog_archive_ordering = get_theme_mod('blog_meta_order', array('date', 'author', 'comment', 'category'));
                foreach ($pharmacy_shop_blog_archive_ordering as $pharmacy_shop_blog_data_order) : 
                  if ('date' === $pharmacy_shop_blog_data_order) : ?>
                    <i class="far fa-calendar-alt mb-1"></i><span class="entry-date"><?php echo get_the_date('j F, Y'); ?></span>
                  <?php elseif ('author' === $pharmacy_shop_blog_data_order) : ?>
                    <i class="fas fa-user mb-1"></i><span class="entry-author"><?php the_author(); ?></span>
                  <?php elseif ('comment' === $pharmacy_shop_blog_data_order) : ?>
                    <i class="fas fa-comments mb-1"></i><span class="entry-comments"><?php comments_number(__('0 Comments', 'pharmacy-shop'), __('0 Comments', 'pharmacy-shop'), __('% Comments', 'pharmacy-shop')); ?></span>
                    <?php elseif ('category' === $pharmacy_shop_blog_data_order) :?>
                          <i class="fas fa-list mb-1"></i><span class="entry-category"><?php pharmacy_shop_display_post_category_count(); ?></span>
                  <?php endif;
                endforeach; ?>
          </div>
          <p><?php echo esc_html(pharmacy_shop_excerpt_function());?></p>
          <?php if(get_theme_mod('pharmacy_shop_remove_read_button',true) != ''){ ?>
            <div class="readmore-btn">
              <a href="<?php echo esc_url( get_permalink() );?>" class="blogbutton-small" title="<?php esc_attr_e( 'Read More', 'pharmacy-shop' ); ?>"><?php echo esc_html(get_theme_mod('pharmacy_shop_read_more_text',__('Read More','pharmacy-shop')));?></a>
            </div>
          <?php }?>
        </div>
        <div class="col-lg-6 col-md-12 align-self-center pt-lg-0 pt-3">
          <?php if (!is_single() && function_exists('get_post_gallery')) {
            $gallery = get_post_gallery(get_the_ID(), false);
            if ($gallery && isset($gallery['ids'])) {  
              $gallery_ids = explode(',', $gallery['ids']); ?>
              <div class="container entry-gallery">
                <div class="row">
                  <?php $pharmacy_shop_max_images = min(count($gallery_ids), 4);
                  for ($index = 0; $index < $pharmacy_shop_max_images; $index++) {
                    $id = $gallery_ids[$index];
                    $pharmacy_shop_image_url = wp_get_attachment_image_url($id, 'full'); ?>
                    <div class="col-md-6 mb-1 align-self-center">
                      <img class="img-fluid" src="<?php echo esc_url($pharmacy_shop_image_url); ?>" alt="Gallery Image <?php echo ($index + 1); ?>">
                    </div>
                  <?php } ?>
                </div>
              </div>
            <?php }
          } ?>
        </div>
      <?php }?>
      <div class="clearfix"></div>
    </div>
  </article>
</div>
<?php } ?>