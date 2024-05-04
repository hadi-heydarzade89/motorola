<?php
/**
 * Template part for displaying home page content
 *
 * @package Pharmacy Shop
 * @subpackage pharmacy_shop
 */

?>

<div id="main-content" class="container py-5">
  	<?php while ( have_posts() ) : the_post(); ?>
  		<?php the_content(); ?>
  	<?php endwhile; // end of the loop. ?>
</div>
