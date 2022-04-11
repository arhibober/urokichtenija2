<?php
/**
 * Bhari functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bhari
 */

/**
 * Define constants
 */
define( 'BHARI_VERSION', '1.0.4.9' );
define( 'BHARI_URI', get_template_directory_uri() );
define( 'BHARI_DIR', get_template_directory() );
define( 'BHARI_SUPPORT_FONTAWESOME', true );
define( 'BHARI_POSTMETA_SUPPORT_AUTHOR_IMAGE', true );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
if ( ! function_exists( 'bhari_setup' ) ) :

	/**
	 * Bhari setup
	 */
	function bhari_setup() {

		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Bhari, use a find and replace
		 * to change 'bhari' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'bhari' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Indicate widget sidebars can use selective refresh in the Customizer.
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
			'primary' => esc_html__( 'Primary', 'bhari' ),
			)
		);

		/*
            * Switch default core markup for search form, comment form, and comments
            * to output valid HTML5.
            */
		add_theme_support(
			'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background', apply_filters(
				'bhari_custom_background_args', array(
				'default-color' => 'f1f1f1',
				'default-image' => '',
				)
			)
		);

		// Added editor style support.
		add_editor_style( 'assets/css/editor-style.css' );

		/**
		 * Set the content width in pixels, based on the theme's design and stylesheet.
		 *
		 * Priority 0 to make it available to lower priority callbacks.
		 *
		 * @global int $content_width
		 */
		$GLOBALS['content_width'] = apply_filters( 'bhari_content_width', 640 );

		/**
		 * Added starter content
		 */
		add_theme_support(
			'starter-content', array(
				'widgets' => array(
					'sidebar-1' => array(
						'search',
						'recent-posts',
						'recent-comments',
						'archives',
						'categories',
						'meta',
					),
					'sidebar-2' => array(
						'text_about',
						'calendar',
						'text_business_info',
					),
				),
			)
		);

		/**
		 * Enable support for custom logo.
		 *
		 * @since 1.0.4.8
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-height' => true,
		) );
	}

	add_action( 'after_setup_theme', 'bhari_setup' );

endif;

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
if ( ! function_exists( 'bhari_widgets_init' ) ) :

	/**
	 * Bhari Widgets
	 */
	function bhari_widgets_init() {
		register_sidebar(
			array(
			'name'          => esc_html__( 'Right Sidebar', 'bhari' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'bhari' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
			)
		);
		register_sidebar(
			array(
			'name'          => esc_html__( 'Left Sidebar', 'bhari' ),
			'id'            => 'sidebar-2',
			'description'   => esc_html__( 'Add widgets here.', 'bhari' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
			)
		);
	}
	add_action( 'widgets_init', 'bhari_widgets_init' );
endif;

/**
 * Generate asset URL depend on RTL & SCRIPT_DEBUG.
 *
 * E.g. For request bhari_asset_url( 'editor-style', 'css' );
 * Load one of the below file depends on RTL & SCRIPTS_DEBUG check.
 *
 * NOTE: RTL support is now just for ONLY theme style.css file.
 *
 *    style.min.css         Load normally.
 *    style.min-rtl.css     Load if RTL is on.
 *
 *    style.css             Load if SCRIPT_DEBUG is true.
 *    style-rtl.css         Load if SCRIPT_DEBUG & RTL are true.
 */

if ( ! function_exists( 'bhari_asset_url' ) ) :

	/**
	 * Generate asset URL depend on RTL & SCRIPT_DEBUG.
	 *
	 * How to use?
	 *
	 * @param  string  $file_name       Asset ( CSS / JS ) file name.
	 * @param  string  $type            Asset type either CSS or JS.
	 * @param  boolean $has_rtl_support Use argument for RTL support.
	 * @param  boolean $dir_path        Use argument for loading admin assets.
	 * @return string            URL of asset depend on RTL & SCRIPT_DEBUG.
	 */
	function bhari_asset_url( $file_name = '', $type = '', $has_rtl_support = false, $dir_path = '' ) {

		/**
		 * Load admin assets
		 */
		switch ( $dir_path ) {
			case 'vendor':
				$unmin_url     = '/assets/vendor/' . $type . '/' . $file_name . '.' . $type;
				$min_url       = '/assets/vendor/' . $type . '/' . $file_name . '.min.' . $type;
				$unmin_url_rtl = '/assets/vendor/' . $type . '/rtl/' . $file_name . '-rtl.' . $type;
				$min_url_rtl   = '/assets/vendor/' . $type . '/rtl/' . $file_name . '-rtl.min.' . $type;
			break;
			case 'admin':
				$unmin_url     = '/inc/assets/' . $type . '/' . $file_name . '.' . $type;
				$min_url       = '/inc/assets/' . $type . '/min/' . $file_name . '.min.' . $type;
				$unmin_url_rtl = '/inc/assets/' . $type . '/rtl/' . $file_name . '-rtl.' . $type;
				$min_url_rtl   = '/inc/assets/' . $type . '/min/rtl/' . $file_name . '-rtl.min.' . $type;
			break;
			default:
				$unmin_url     = '/assets/' . $type . '/' . $file_name . '.' . $type;
				$min_url       = '/assets/' . $type . '/min/' . $file_name . '.min.' . $type;
				$unmin_url_rtl = '/assets/' . $type . '/rtl/' . $file_name . '-rtl.' . $type;
				$min_url_rtl   = '/assets/' . $type . '/min/rtl/' . $file_name . '-rtl.min.' . $type;
			break;
		}

		// Load unminified assets.
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {

			$asset_url = $unmin_url; // Load unminified assets.

			if ( $has_rtl_support && is_rtl() ) {
				$asset_url = $unmin_url_rtl; // Load unminified RTL assets.
			}

			// Load minified assets.
		} else {

			$asset_url = $min_url; // Load minified assets.

			if ( $has_rtl_support && is_rtl() ) {
				$asset_url = $min_url_rtl; // Load minified RTL assets.
			}
		}

		return BHARI_URI . $asset_url;
	}
endif;

/**
 * Enqueue scripts and styles.
 */
if ( ! function_exists( 'bhari_scripts' ) ) :

	/**
	 * Bhari Scripts
	 */
	function bhari_scripts() {

		/**
		 * Theme Assets
		 */
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Unminified & Individual files.
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {

			// CSS.
			wp_enqueue_style( 'bhari-core-css', get_stylesheet_uri() );
			wp_style_add_data( 'bhari-core-css', 'rtl', 'replace' );

			// JS.
			wp_enqueue_script( 'bhari-navigation', BHARI_URI . '/assets/js/navigation.js', array( 'jquery' ), BHARI_VERSION, true );
			wp_enqueue_script( 'bhari-skip-link-focus-fix', BHARI_URI . '/assets/js/skip-link-focus-fix.js', array( 'jquery' ), BHARI_VERSION, true );

			// Minified & Combined single files.
		} else {

			// CSS.
			if ( is_rtl() ) {
				wp_enqueue_style( 'bhari-core-css', BHARI_URI . '/assets/css/min/rtl/style.min-rtl.css' );
			} else {
				wp_enqueue_style( 'bhari-core-css', BHARI_URI . '/assets/css/min/style.min.css' );
			}

			// JS.
			wp_enqueue_script( 'bhari-core-js', BHARI_URI . '/assets/js/min/style.min.js', array( 'jquery' ), array( 'jquery' ), BHARI_VERSION, true );
		}

		/**
		 * External assets.
		 */
		if ( BHARI_SUPPORT_FONTAWESOME ) {
			wp_enqueue_style( 'font-awesome', bhari_asset_url( 'font-awesome', 'css', '', 'vendor' ) );
		}
	}
	add_action( 'wp_enqueue_scripts', 'bhari_scripts' );

endif;

/**
 * Theme Hook Alliance hook stub list.
 */
require BHARI_DIR . '/inc/hooks.php';

/**
 * Implement the Custom Header feature.
 */
require BHARI_DIR . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require BHARI_DIR . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require BHARI_DIR . '/inc/extras.php';

/**
 * Customizer additions.
 */
require BHARI_DIR . '/inc/customizer/customizer.php';

/**
 * Load compatibility files for 3rd party plugins.
 */
require BHARI_DIR . '/inc/compatibility/jetpack.php';

/* "Хлебные крошки" для WordPress
 * автор: Dimox
 * версия: 2018.10.05
 * лицензия: MIT
*/
function dimox_breadcrumbs ()
{
	/* === ОПЦИИ === */
	$text ["home"] = "Главная"; // текст ссылки "Главная"
	$text ["category"] = "%s"; // текст для страницы рубрики
	$text ["search"] = 'Результаты поиска по запросу "%s"'; // текст для страницы с результатами поиска
	$text ["tag"] = 'Записи с тегом "%s"'; // текст для страницы тега
	$text ["author"] = 'Статьи автора %s'; // текст для страницы автора
	$text ["404"] = "Ошибка 404"; // текст для страницы 404
	$text ["page"] = "Страница %s"; // текст 'Страница N'
	$text ["cpage"] = 'Страница комментариев %s'; // текст 'Страница комментариев N'
	$wrap_before = '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">'; // открывающий тег обертки
	$wrap_after = "</div><!-- .breadcrumbs -->"; // закрывающий тег обертки
	$sep = '<span class="breadcrumbs__separator"> › </span>'; // разделитель между "крошками"
	$before = '<span class="breadcrumbs__current">'; // тег перед текущей "крошкой"
	$after = "</span>"; // тег после текущей "крошки"
	$show_on_home = 0; // 1 - показывать "хлебные крошки" на главной странице, 0 - не показывать
	$show_home_link = 1; // 1 - показывать ссылку "Главная", 0 - не показывать
	$show_current = 1; // 1 - показывать название текущей страницы, 0 - не показывать
	$show_last_sep = 1; // 1 - показывать последний разделитель, когда название текущей страницы не отображается, 0 - не показывать
	/* === КОНЕЦ ОПЦИЙ === */
	global $post;
	$home_url = home_url ("/");
	$link = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	$link .= '<a class="breadcrumbs__link" href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a>';
	$link .= '<meta itemprop="position" content="%3$s" />';
	$link .= "</span>";
	$parent_id = ($post) ? $post->post_parent : "";
	$home_link = sprintf ($link, $home_url, $text ["home"], 1);
	if ((is_home ()) || (is_front_page ()))
	{
		if ($show_on_home)
			echo $wrap_before.$home_link.$wrap_after;
	}
	else
	{
		$position = 0;
		echo $wrap_before;
		if ($show_home_link)
		{
			$position += 1;
			echo $home_link;
		}
    if (is_category ())
	{
		$parents = get_ancestors (get_query_var ("cat"), "category");
		foreach (array_reverse ($parents) as $cat)
		{
			$position += 1;
			if ($position > 1)
				echo $sep;
			echo sprintf ($link, get_category_link ($cat), get_cat_name ($cat), $position);
		}
		if (get_query_var ("paged"))
		{
			$position += 1;
			$cat = get_query_var ("cat");
			echo $sep.sprintf ($link, get_category_link ($cat), get_cat_name ($cat), $position );
			echo $sep.$before.sprintf ($text ["page"], get_query_var ("paged")).$after;
		}
		else
		{
			if ($show_current)
			{
				if ($position >= 1)
					echo $sep;
				echo $before.sprintf ($text ["category"], single_cat_title ("", false)).$after;
			}
			elseif ($show_last_sep) echo $sep;
      }
    }
		elseif ( is_search ())
		{
			if (($show_home_link) && ($show_current) || (!$show_current) && ($show_last_sep))
				echo $sep;
			if ($show_current)
				echo $before.sprintf ($text ["search"], get_search_query ()) . $after;
		}
		elseif (is_year ())
		{
			if ($show_home_link && $show_current)
				echo $sep;
			if ($show_current)
				echo $before.get_the_time ("Y").$after;
			elseif ($show_home_link && $show_last_sep)
				echo $sep;
		}
		elseif (is_month ())
		{
			if ($show_home_link)
				echo $sep;
			$position += 1;
			echo sprintf ($link, get_year_link (get_the_time ("Y")), get_the_time ("Y"), $position);
			if ($show_current)
				echo $sep.$before.get_the_time ("F").$after;
			elseif ($show_last_sep)
				echo $sep;
    }
	elseif (is_day ())
	{
		if ($show_home_link)
			echo $sep;
		$position += 1;
		echo sprintf ($link, get_year_link (get_the_time ("Y")), get_the_time ("Y"), $position).$sep;
		$position += 1;
		echo sprintf ($link, get_month_link (get_the_time ("Y"), get_the_time ("m")), get_the_time ("F"), $position);
		if ($show_current)
			echo $sep.$before.get_the_time ("d").$after;
		elseif ($show_last_sep)
			echo $sep;
    }
	elseif ((is_single ()) && (!is_attachment ()))
	{
		if (get_post_type () != "post")
		{
			$position += 1;
			$post_type = get_post_type_object (get_post_type ());
			if ($position > 1)
				echo $sep;
			echo sprintf ($link, get_post_type_archive_link ($post_type->name), $post_type->labels->name, $position);
			if ($show_current)
				echo $sep.$before.get_the_title ().$after;
			elseif ($show_last_sep)
				echo $sep;
		}
		else
		{
			$cat = get_the_category (); $catID = $cat[0]->cat_ID;
			$parents = get_ancestors ($catID, "category");
			$parents = array_reverse ($parents);
			$parents [] = $catID;
			foreach ($parents as $cat)
			{
				$position += 1;
				if ($position > 1)
					echo $sep;
				echo sprintf ($link, get_category_link ($cat), get_cat_name ($cat), $position);
			}
			if (get_query_var ("cpage"))
			{
				$position += 1;
				echo $sep.sprintf ($link, get_permalink (), get_the_title (), $position).$sep.$before.sprintf ($text ["cpage"], get_query_var ("cpage")).$after;
			}
			else
			{
				if ($show_current)
					echo $sep.$before.get_the_title ().$after;
				elseif ($show_last_sep)
					echo $sep;
			}
		}
    }
	elseif (is_post_type_archive ())
	{
		$post_type = get_post_type_object (get_post_type ());
		if (get_query_var ("paged"))
		{
			$position += 1;
			if ($position > 1)
				echo $sep;
			echo sprintf ($link, get_post_type_archive_link ($post_type->name), $post_type->label, $position).$sep.$before.sprintf ($text ["page"], get_query_var ("paged")). $after;
		}
		else
		{
        if ($show_home_link && $show_current)
			echo $sep;
        if ($show_current)
			echo $before.$post_type->label.$after;
        elseif ($show_home_link && $show_last_sep)
			echo $sep;
      }
    }
	elseif (is_attachment ())
	{
		$parent = get_post ($parent_id);
		$cat = get_the_category ($parent->ID);
		$catID = $cat [0]->cat_ID;
		$parents = get_ancestors ($catID, "category");
		$parents = array_reverse( $parents );
		$parents[] = $catID;
		foreach ($parents as $cat)
		{
			$position += 1;
			if ($position > 1)
				echo $sep;
			echo sprintf ($link, get_category_link ($cat), get_cat_name ($cat), $position);
		}
		$position += 1;
		echo $sep.sprintf ($link, get_permalink ($parent), $parent->post_title, $position);
		if ($show_current)
			echo $sep.$before.get_the_title (). $after;
		elseif ($show_last_sep)
			echo $sep;
    }
	elseif (is_page () && !$parent_id)
	{
		if ($show_home_link && $show_current) echo $sep;
		if ($show_current)
			echo $before.get_the_title ().$after;
      elseif ($show_home_link && $show_last_sep)
		echo $sep;
    }
	elseif (is_page () && $parent_id)
	{
		$parents = get_post_ancestors (get_the_ID ());
		foreach (array_reverse ($parents) as $pageID)
		{
			$position += 1;
			if ($position > 1)
				echo $sep;
			echo sprintf ($link, get_page_link ($pageID), get_the_title ($pageID), $position);
		}
		if ($show_current)
			echo $sep.$before.get_the_title ().$after;
		elseif ($show_last_sep)
			echo $sep;
    }
	elseif (is_tag ())
	{
		if (get_query_var ("paged"))
		{
			$position += 1;
			$tagID = get_query_var ("tag_id");
			echo $sep.sprintf ($link, get_tag_link ($tagID), single_tag_title ("", false ), $position).$sep.$before.sprintf ($text ["page"], get_query_var ( "paged")).$after;
		}
		else
		{
			if ($show_home_link && $show_current)
				echo $sep;
			if ($show_current)
				echo $before.sprintf ($text ["tag"], single_tag_title ("", false)).$after;
			elseif ($show_home_link && $show_last_sep)
				echo $sep;
		}
    }
	elseif (is_author ())
	{
		$author = get_userdata (get_query_var ("author"));
		if (get_query_var ("paged"))
		{
			$position += 1;
			echo $sep.sprintf ($link, get_author_posts_url ($author->ID), sprintf ($text ["author"], $author->display_name), $position).$sep.$before.sprintf ($text ["page"], get_query_var ("paged")).$after;
		}
		else
		{
			if ($show_home_link && $show_current)
				echo $sep;
			if ($show_current)
				echo $before.sprintf ($text ["author"], $author->display_name).$after;
			elseif ($show_home_link && $show_last_sep)
				echo $sep;
		}
    }
	elseif (is_404 ())
	{
		if ($show_home_link && $show_current)
			echo $sep;
		if ($show_current)
			echo $before.$text ["404"].$after;
		elseif ($show_last_sep)
			echo $sep;
    }
	elseif ((has_post_format ()) && ! (is_singular ()))
	{
		if ($show_home_link && $show_current)
			echo $sep;
		echo get_post_format_string (get_post_format ());
    }
    echo $wrap_after;
  }
} // end of dimox_breadcrumbs()

add_filter
(
	"bbp_no_breadcrumb",
	function ($arg)
	{
		return true;
	}
);

/**
 * Adds default OpenGraph image.
 * Christoph Nahr 2014-02-28
 * @param array $tags Array of OpenGraph tags.
 * @return Specified array, possibly modified.
 */
function add_default_image( $tags ) {
 
    // replace blank Jetpack default image with site header
    //if ( $tags['og:image'][0] == "http://wordpress.com/i/blank.jpg" ) {
        unset( $tags['og:image'][0] );
        $tags['og:image'][0] = 'http://localhost/urokichtenija1/wp-content/uploads/2018/12/47243298_268709827330125_3799730212124491776_n.jpg';
    //}
 
    // always remove useless HTTPS image tags
    unset( $tags['og:image:secure_url'] );
 
    return $tags;
}
add_filter( 'jetpack_open_graph_tags', 'add_default_image' );