<?php
/**
 * Template Name: Motorola Blank Page
 * Template Post Type: page
 *
 * A completely blank page template.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); // This is necessary to include any scripts, styles, or meta information added by WordPress plugins. ?>
</head>
<body <?php body_class(); ?>>
<header id="masthead" class="header-blank-motorolla stick-this site-header d-flex justify-content-center">
    <p style="color: black;">ایران موتورولا</p>
    
</header>
<?php
// Start the loop to display the page content
if (have_posts()) :
    while (have_posts()) : the_post();
        the_content(); // Output the content from the WordPress editor
    endwhile;
endif;
?>

<?php wp_footer(); // This is necessary to include scripts and functions hooked into wp_footer. ?>
</body>
</html>
