<?php
/**
 * Admin welcome screen and recommended plugin helpers.
 *
 * @package DinovaTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Stores the recommended plugin list.
 *
 * @return array[]
 */
function dinovatheme_recommended_plugins() {
	return array(
		array(
			'name'        => esc_html__( 'Elementor Website Builder', 'dinovatheme' ),
			'description' => esc_html__( 'Build pages, landing sections, headers, footers, and visual layouts with DinovaTheme.', 'dinovatheme' ),
			'slug'        => 'elementor',
			'file'        => 'elementor/elementor.php',
			'required'    => true,
		),
		array(
			'name'        => esc_html__( 'Contact Form 7', 'dinovatheme' ),
			'description' => esc_html__( 'Add simple contact forms for starter sites and imported demos.', 'dinovatheme' ),
			'slug'        => 'contact-form-7',
			'file'        => 'contact-form-7/wp-contact-form-7.php',
			'required'    => false,
		),
		array(
			'name'        => esc_html__( 'WooCommerce', 'dinovatheme' ),
			'description' => esc_html__( 'Enable shop demos and ecommerce layouts when you need store features.', 'dinovatheme' ),
			'slug'        => 'woocommerce',
			'file'        => 'woocommerce/woocommerce.php',
			'required'    => false,
		),
	);
}

/**
 * Shows the welcome prompt again after activating the theme.
 */
function dinovatheme_set_welcome_notice() {
	update_option( 'dinovatheme_show_welcome_notice', 'yes' );
}
add_action( 'after_switch_theme', 'dinovatheme_set_welcome_notice' );

/**
 * Dismisses the welcome prompt.
 */
function dinovatheme_dismiss_welcome_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to do this.', 'dinovatheme' ) );
	}

	check_admin_referer( 'dinovatheme_dismiss_welcome_notice' );
	update_option( 'dinovatheme_show_welcome_notice', 'no' );

	wp_safe_redirect( wp_get_referer() ? wp_get_referer() : admin_url() );
	exit;
}
add_action( 'admin_action_dinovatheme_dismiss_welcome_notice', 'dinovatheme_dismiss_welcome_notice' );

/**
 * Registers the welcome admin page.
 */
function dinovatheme_register_welcome_page() {
	add_theme_page(
		esc_html__( 'DinovaTheme', 'dinovatheme' ),
		esc_html__( 'DinovaTheme', 'dinovatheme' ),
		'manage_options',
		'dinovatheme',
		'dinovatheme_render_welcome_page'
	);
}
add_action( 'admin_menu', 'dinovatheme_register_welcome_page' );

/**
 * Enqueues admin styling.
 *
 * @param string $hook The current admin hook.
 */
function dinovatheme_admin_assets( $hook ) {
	$screen = get_current_screen();

	if ( 'appearance_page_dinovatheme' === $hook || ( $screen && in_array( $screen->id, array( 'dashboard', 'themes' ), true ) ) ) {
		wp_enqueue_style( 'dinovatheme-admin', DINOVATHEME_URI . '/assets/admin/welcome.css', array(), DINOVATHEME_VERSION );
	}
}
add_action( 'admin_enqueue_scripts', 'dinovatheme_admin_assets' );

/**
 * Renders the activation welcome prompt.
 */
function dinovatheme_welcome_notice() {
	if ( ! current_user_can( 'manage_options' ) || 'yes' !== get_option( 'dinovatheme_show_welcome_notice', 'no' ) ) {
		return;
	}

	$screen = get_current_screen();

	if ( ! $screen || ! in_array( $screen->id, array( 'dashboard', 'themes' ), true ) ) {
		return;
	}

	$page_url    = admin_url( 'themes.php?page=dinovatheme' );
	$dismiss_url = wp_nonce_url( admin_url( 'admin.php?action=dinovatheme_dismiss_welcome_notice' ), 'dinovatheme_dismiss_welcome_notice' );
	?>
	<div class="notice dinovatheme-welcome-notice">
		<a class="dinovatheme-welcome-notice__dismiss" href="<?php echo esc_url( $dismiss_url ); ?>">
			<span class="screen-reader-text"><?php esc_html_e( 'Dismiss welcome notice', 'dinovatheme' ); ?></span>
		</a>
		<div class="dinovatheme-welcome-notice__content">
			<p class="dinovatheme-eyebrow"><?php esc_html_e( 'DinovaTheme setup', 'dinovatheme' ); ?></p>
			<h2><?php esc_html_e( 'Thanks for installing DinovaTheme!', 'dinovatheme' ); ?></h2>
			<p><?php esc_html_e( 'DinovaTheme is a lightweight Elementor-first theme. Install the recommended plugins to unlock visual building, starter demos, forms, and shop layouts.', 'dinovatheme' ); ?></p>
			<a class="button button-primary button-hero" href="<?php echo esc_url( $page_url ); ?>">
				<?php esc_html_e( 'View Recommended Plugins', 'dinovatheme' ); ?>
			</a>
		</div>
		<div class="dinovatheme-welcome-notice__visual" aria-hidden="true">
			<div class="dinovatheme-builder-frame">
				<div class="dinovatheme-builder-sidebar"></div>
				<div class="dinovatheme-builder-canvas">
					<span></span>
					<strong></strong>
					<em></em>
				</div>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'admin_notices', 'dinovatheme_welcome_notice' );

/**
 * Checks whether a recommended plugin is active.
 *
 * @param string $plugin_file Plugin file path.
 * @return bool
 */
function dinovatheme_is_plugin_active( $plugin_file ) {
	if ( ! function_exists( 'is_plugin_active' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	return is_plugin_active( $plugin_file );
}

/**
 * Checks whether a recommended plugin is installed.
 *
 * @param string $plugin_file Plugin file path.
 * @return bool
 */
function dinovatheme_is_plugin_installed( $plugin_file ) {
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	$plugins = get_plugins();

	return isset( $plugins[ $plugin_file ] );
}

/**
 * Builds the install or activate action markup.
 *
 * @param array $plugin Plugin data.
 * @return string
 */
function dinovatheme_get_plugin_action( $plugin ) {
	if ( dinovatheme_is_plugin_active( $plugin['file'] ) ) {
		return '<span class="dinovatheme-plugin-status dinovatheme-plugin-status--active">' . esc_html__( 'Active', 'dinovatheme' ) . '</span>';
	}

	if ( dinovatheme_is_plugin_installed( $plugin['file'] ) ) {
		$activate_url = wp_nonce_url(
			admin_url( 'plugins.php?action=activate&plugin=' . rawurlencode( $plugin['file'] ) ),
			'activate-plugin_' . $plugin['file']
		);

		return '<a class="button button-primary" href="' . esc_url( $activate_url ) . '">' . esc_html__( 'Activate', 'dinovatheme' ) . '</a>';
	}

	$install_url = wp_nonce_url(
		self_admin_url( 'update.php?action=install-plugin&plugin=' . rawurlencode( $plugin['slug'] ) ),
		'install-plugin_' . $plugin['slug']
	);

	return '<a class="button button-primary" href="' . esc_url( $install_url ) . '">' . esc_html__( 'Install', 'dinovatheme' ) . '</a>';
}

/**
 * Renders the welcome admin page.
 */
function dinovatheme_render_welcome_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$plugins = dinovatheme_recommended_plugins();
	?>
	<div class="wrap dinovatheme-admin-page">
		<section class="dinovatheme-admin-hero">
			<div>
				<p class="dinovatheme-eyebrow"><?php esc_html_e( 'DinovaTheme setup', 'dinovatheme' ); ?></p>
				<h1><?php esc_html_e( 'Recommended plugins', 'dinovatheme' ); ?></h1>
				<p><?php esc_html_e( 'Install the plugins that match your site. Elementor is recommended for the full DinovaTheme experience; the other plugins are optional and only needed for matching demos.', 'dinovatheme' ); ?></p>
			</div>
		</section>

		<div class="dinovatheme-plugin-list">
			<?php foreach ( $plugins as $plugin ) : ?>
				<div class="dinovatheme-plugin-card">
					<div class="dinovatheme-plugin-card__body">
						<div class="dinovatheme-plugin-card__icon" aria-hidden="true">
							<?php echo esc_html( strtoupper( substr( $plugin['name'], 0, 1 ) ) ); ?>
						</div>
						<div>
							<h2><?php echo esc_html( $plugin['name'] ); ?></h2>
							<p><?php echo esc_html( $plugin['description'] ); ?></p>
							<?php if ( ! empty( $plugin['required'] ) ) : ?>
								<span class="dinovatheme-plugin-label"><?php esc_html_e( 'Recommended', 'dinovatheme' ); ?></span>
							<?php else : ?>
								<span class="dinovatheme-plugin-label dinovatheme-plugin-label--optional"><?php esc_html_e( 'Optional', 'dinovatheme' ); ?></span>
							<?php endif; ?>
						</div>
					</div>
					<div class="dinovatheme-plugin-card__action">
						<?php echo wp_kses_post( dinovatheme_get_plugin_action( $plugin ) ); ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}
