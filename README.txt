= DinovaTheme =

DinovaTheme is a lightweight, Elementor-first WordPress theme designed for clean starter styling before demo import.

== Description ==

DinovaTheme keeps the theme layer small and standards-focused. It provides WordPress theme essentials, clean typography, simple layout styling, RTL support, threaded comments, menus, custom logo support, featured images, and Elementor compatibility hooks.

The theme is designed to pair with a future companion demo importer plugin. Demo import should live in a plugin, not in the theme, so the theme remains portable and suitable for WordPress.org review.

== Requirements ==

* WordPress 6.4 or higher
* PHP 7.4 or higher
* Elementor is recommended for full page-building workflows

== Installation ==

1. Upload the theme folder to `/wp-content/themes/`.
2. Activate DinovaTheme from Appearance > Themes.
3. Install Elementor for the intended page-building experience.

== Demo Import Plan ==

The planned demo workflow is:

1. A companion plugin provides starter-site browsing and import.
2. Demo metadata is fetched from a separate service controlled by the theme author.
3. The plugin imports Elementor templates, pages, menus, media, and settings.
4. The theme itself stays lightweight and does not depend on bundled demo content.

== Copyright ==

DinovaTheme, Copyright 2026 dinadevcom.
DinovaTheme is distributed under the terms of the GNU GPL v2 or later.

== Changelog ==

= 0.1.0 =
* Initial theme skeleton.
