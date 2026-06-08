<?php
/**
 * Template part for displaying posts.
 *
 * @package DinovaTheme
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		?>

		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php
				printf(
					/* translators: 1: Post date, 2: Post author. */
					esc_html__( 'Published on %1$s by %2$s', 'dinovatheme' ),
					'<time datetime="' . esc_attr( get_the_date( DATE_W3C ) ) . '">' . esc_html( get_the_date() ) . '</time>',
					esc_html( get_the_author() )
				);
				?>
			</div>
		<?php endif; ?>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail">
			<?php the_post_thumbnail( 'large' ); ?>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php
		if ( is_singular() ) {
			the_content();
		} else {
			the_excerpt();
		}

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'dinovatheme' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

	<footer class="entry-footer">
		<?php
		if ( ! is_singular() ) {
			printf(
				'<a href="%1$s">%2$s</a>',
				esc_url( get_permalink() ),
				esc_html__( 'Continue reading', 'dinovatheme' )
			);
		}
		?>
	</footer>
</article>
