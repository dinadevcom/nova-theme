<?php
/**
 * The template for displaying comments.
 *
 * @package DinovaTheme
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$dinovatheme_comment_count = get_comments_number();

			printf(
				/* translators: %s: Comment count. */
				esc_html( _nx( '%s comment', '%s comments', $dinovatheme_comment_count, 'comments title', 'dinovatheme' ) ),
				esc_html( number_format_i18n( $dinovatheme_comment_count ) )
			);
			?>
		</h2>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
				)
			);
			?>
		</ol>

		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'dinovatheme' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>
</div>
