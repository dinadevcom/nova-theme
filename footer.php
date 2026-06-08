<?php
/**
 * The footer for DinovaTheme.
 *
 * @package DinovaTheme
 */

?>
<footer class="site-footer">
	<div class="site-footer__inner">
		<p>
			<?php
			printf(
				/* translators: %s: Site name. */
				esc_html__( 'Copyright %s', 'dinovatheme' ),
				esc_html( get_bloginfo( 'name' ) )
			);
			?>
		</p>
		<p>
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'dinovatheme' ) ); ?>">
				<?php esc_html_e( 'Proudly powered by WordPress', 'dinovatheme' ); ?>
			</a>
		</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
