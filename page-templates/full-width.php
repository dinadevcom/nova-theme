<?php
/**
 * Template Name: Full Width
 * Template Post Type: page
 *
 * @package DinovaTheme
 */

get_header();
?>

<main id="primary" class="site-main dinova-full-width">
	<?php
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>
</main>

<?php
get_footer();
