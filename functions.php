<?php
/**
 * DinovaTheme functions and definitions.
 *
 * @package DinovaTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DINOVATHEME_VERSION', '0.1.0' );
define( 'DINOVATHEME_PATH', get_template_directory() );
define( 'DINOVATHEME_URI', get_template_directory_uri() );

if ( ! function_exists( 'dinovatheme_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for WordPress features.
	 */
	function dinovatheme_setup() {
		load_theme_textdomain( 'dinovatheme', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'html5', array( 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'search-form' ) );
		add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 240, 'flex-height' => true, 'flex-width' => true ) );
		add_theme_support( 'align-wide' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'editor-styles' );

		add_editor_style( 'style.css' );

		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary Menu', 'dinovatheme' ),
			)
		);
	}
}
add_action( 'after_setup_theme', 'dinovatheme_setup' );

/**
 * Sets the content width in pixels.
 */
function dinovatheme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'dinovatheme_content_width', 1120 );
}
add_action( 'after_setup_theme', 'dinovatheme_content_width', 0 );

/**
 * Enqueues scripts and styles.
 */
function dinovatheme_scripts() {
	wp_enqueue_style( 'dinovatheme-style', get_stylesheet_uri(), array(), DINOVATHEME_VERSION );
	wp_style_add_data( 'dinovatheme-style', 'rtl', 'replace' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dinovatheme_scripts' );

/**
 * Adds Elementor compatibility hooks when Elementor is active.
 */
function dinovatheme_elementor_support() {
	add_theme_support( 'elementor' );
	add_theme_support( 'elementor-header-footer' );
}
add_action( 'after_setup_theme', 'dinovatheme_elementor_support' );

if ( is_admin() ) {
	require_once DINOVATHEME_PATH . '/inc/admin/welcome.php';
}
