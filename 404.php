<?php
/**
 * The template for displaying 404 pages.
 *
 * @package DinovaTheme
 */

get_header();
?>

<main id="primary" class="site-main">
	<section class="not-found">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Page not found', 'dinovatheme' ); ?></h1>
		</header>
		<div class="page-content">
			<p><?php esc_html_e( 'The page you are looking for does not exist. Try searching for the right content.', 'dinovatheme' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</section>
</main>

<?php
get_footer();
