<?php
/*
Plugin Name: Facebook Button by BestWebSoft
Plugin URI: https://bestwebsoft.com/products/wordpress/plugins/facebook-like-button/
Description: Add Facebook Like, Share and Profile buttons to WordPress posts, pages and widgets.
Author: BestWebSoft
Text Domain: facebook-button-plugin
Domain Path: /languages
Version: 2.60
Author URI: https://bestwebsoft.com/
License: GPLv2 or later
*/

/*  Copyright 2018  BestWebSoft  ( https://support.bestwebsoft.com )

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Add menu pages */
if ( ! function_exists( 'fcbkbttn_admin_menu' ) ) {
	function fcbkbttn_admin_menu() {
		global $submenu, $fcbkbttn_plugin_info, $wp_version;
		if ( ! is_plugin_active( 'facebook-button-pro/facebook-button-pro.php') &&
            ! is_plugin_active( 'facebook-button-plus/facebook-button-plus.php')
        ) {
            $settings = add_menu_page(
                    __( 'Facebook Button Settings', 'facebook-button-plugin' ),
                    'Facebook Button', 'manage_options',
                    'facebook-button-plugin.php',
                    'fcbkbttn_settings_page',
                    'dashicons-facebook-alt'
            );
            add_submenu_page(
                    'facebook-button-plugin.php',
                    __( 'Facebook Button Settings', 'facebook-button-plugin' ),
                    __( 'Settings', 'facebook-button-plugin' ),
                    'manage_options',
                    'facebook-button-plugin.php',
                    'fcbkbttn_settings_page'
            );
            add_submenu_page(
                    'facebook-button-plugin.php',
                    'BWS Panel',
                    'BWS Panel',
                    'manage_options',
                    'fcbkbttn-bws-panel',
                    'bws_add_menu_render'
            );
            if ( isset( $submenu['facebook-button-plugin.php'] ) ) {
                $submenu['facebook-button-plugin.php'][] = array(
                    '<span style="color:#d86463"> ' . __( 'Upgrade to Pro', 'facebook-button-plugin' ) . '</span>',
                    'manage_options',
                    'https://bestwebsoft.com/products/wordpress/plugins/facebook-like-button/?k=427287ceae749cbd015b4bba6041c4b8&pn=78&v=' . $fcbkbttn_plugin_info["Version"] . '&wp_v=' . $wp_version
                );
            }
		    add_action( 'load-' . $settings, 'fcbkbttn_add_tabs' );
		}
	}
}
/* end fcbkbttn_admin_menu */

if ( ! function_exists( 'fcbkbttn_plugins_loaded' ) ) {
	function fcbkbttn_plugins_loaded() {
		/* Internationalization, first(!) */
		load_plugin_textdomain( 'facebook-button-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
}

/* Initialization */
if ( ! function_exists( 'fcbkbttn_init' ) ) {
	function fcbkbttn_init() {
		global $fcbkbttn_plugin_info, $fcbkbttn_lang_codes, $fcbkbttn_options;

		if ( empty( $fcbkbttn_plugin_info ) ) {
			if ( ! function_exists( 'get_plugin_data' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}
			$fcbkbttn_plugin_info = get_plugin_data( __FILE__ );
		}

		/* add general functions */
		require_once( dirname( __FILE__ ) . '/bws_menu/bws_include.php' );
		bws_include_init( plugin_basename( __FILE__ ) );

		bws_wp_min_version_check( plugin_basename( __FILE__ ), $fcbkbttn_plugin_info, '3.9' );/* check compatible with current WP version ##*/

		/* Get options from the database */
		if ( ! is_admin() || ( isset( $_GET['page'] ) && ( "facebook-button-plugin.php" == $_GET['page'] || "social-buttons.php" == $_GET['page'] ) ) ) {
			/* Get/Register and check settings for plugin */
			fcbkbttn_settings();

			$fcbkbttn_lang_codes = array(
				"af_ZA" => 'Afrikaans', "ar_AR" => '??????????????', "az_AZ" => 'Az??rbaycan dili', "be_BY" => '????????????????????', "bg_BG" => '??????????????????', "bn_IN" => '???????????????', "bs_BA" => 'Bosanski', "ca_ES" => 'Catal??', "cs_CZ" => '??e??tina', "cy_GB" => 'Cymraeg', "da_DK" => 'Dansk', "de_DE" => 'Deutsch', "el_GR" => '????????????????', "en_US" => 'English', "en_PI" => 'English (Pirate)', "eo_EO" => 'Esperanto', "es_CO" => 'Espa??ol (Colombia)', "es_ES" => 'Espa??ol (Espa??a)', "es_LA" => 'Espa??ol', "et_EE" => 'Eesti', "eu_ES" => 'Euskara', "fa_IR" => '??????????', "fb_LT" => 'Leet Speak', "fi_FI" => 'Suomi', "fo_FO" => 'F??royskt', "fr_CA" => 'Fran??ais (Canada)', "fr_FR" => 'Fran??ais (France)', "fy_NL" => 'Frysk', "ga_IE" => 'Gaeilge', "gl_ES" => 'Galego', "gn_PY" => "Ava??e'???", "gu_IN" => '?????????????????????', "he_IL" => '??????????', "hi_IN" => '??????????????????', "hr_HR" => 'Hrvatski', "hu_HU" => 'Magyar', "hy_AM" => '??????????????', "id_ID" => 'Bahasa Indonesia', "is_IS" => '??slenska', "it_IT" => 'Italiano', "ja_JP" => '?????????', "jv_ID" => 'Basa Jawa', "ka_GE" => '?????????????????????', "kk_KZ" => '??????????????', "km_KH" => '???????????????????????????', "kn_IN" => '???????????????', "ko_KR" => '?????????', "ku_TR" => 'Kurd??', "la_VA" => 'lingua latina', "lt_LT" => 'Lietuvi??', "lv_LV" => 'Latvie??u', "mk_MK" => '????????????????????', "ml_IN" => '??????????????????', "mn_MN" => '????????????', "mr_IN" => '???????????????', "ms_MY" => 'Bahasa Melayu', "nb_NO" => 'Norsk (bokm??l)', "ne_NP" => '??????????????????', "nl_BE" => 'Nederlands (Belgi??)', "nl_NL" => 'Nederlands', "nn_NO" => 'Norsk (nynorsk)', "pa_IN" => '??????????????????', "pl_PL" => 'Polski', "ps_AF" => '????????', "pt_BR" => 'Portugu??s (Brasil)', "pt_PT" => 'Portugu??s (Portugal)', "ro_RO" => 'Rom??n??', "ru_RU" => '??????????????', "sk_SK" => 'Sloven??ina', "sl_SI" => 'Sloven????ina', "sq_AL" => 'Shqip', "sr_RS" => '????????????', "sv_SE" => 'Svenska', "sw_KE" => 'Kiswahili', "ta_IN" => '???????????????', "te_IN" => '??????????????????', "tg_TJ" => '????????????', "th_TH" => '?????????????????????', "tl_PH" => 'Filipino', "tr_TR" => 'T??rk??e', "uk_UA" => '????????????????????', "ur_PK" => '????????', "uz_UZ" => "O'zbek", "vi_VN" => 'Ti???ng Vi???t', "zh_CN" => '??????(??????)', "zh_HK" => '??????(??????)', "zh_TW" => '??????(??????)'
			);

			if ( ! is_admin() ) {
				add_filter( 'the_content', 'fcbkbttn_display_button' );
				if ( isset( $fcbkbttn_options['display_for_excerpt'] ) && ! empty( $fcbkbttn_options['display_for_excerpt'] ) ) {
					add_filter( 'the_excerpt', 'fcbkbttn_display_button' );
				}
			}
		}
	}
}
/* End function init */

/* Function for admin_init */
if ( ! function_exists( 'fcbkbttn_admin_init' ) ) {
	function fcbkbttn_admin_init() {
		/* Add variable for bws_menu */
		global $bws_plugin_info, $fcbkbttn_plugin_info, $bws_shortcode_list;

		/* Function for bws menu */
		if ( empty( $bws_plugin_info ) ) {
			$bws_plugin_info = array( 'id' => '78', 'version' => $fcbkbttn_plugin_info["Version"] );
		}

		/* add Facebook to global $bws_shortcode_list */
		$bws_shortcode_list['fcbkbttn'] = array( 'name' => 'Facebook Button' );

	}
}
/* end fcbkbttn_admin_init */

if ( ! function_exists( 'fcbkbttn_settings' ) ) {
	function fcbkbttn_settings() {
		global $fcbkbttn_options, $fcbkbttn_plugin_info;

		/* Install the option defaults */
		if ( ! get_option( 'fcbkbttn_options' ) ) {
			$options_default = fcbkbttn_get_options_default();
			add_option( 'fcbkbttn_options', $options_default );
		}

		/* Get options from the database */
		$fcbkbttn_options = get_option( 'fcbkbttn_options' );

		if ( ! isset( $fcbkbttn_options['plugin_option_version'] ) || $fcbkbttn_options['plugin_option_version'] != $fcbkbttn_plugin_info["Version"] ) {
			$fcbkbttn_options['hide_premium_options'] = array();

			fcbkbttn_plugin_activate();

			$options_default = fcbkbttn_get_options_default();
			$fcbkbttn_options = array_merge( $options_default, $fcbkbttn_options );
			$fcbkbttn_options['plugin_option_version'] = $fcbkbttn_plugin_info["Version"];

			update_option( 'fcbkbttn_options', $fcbkbttn_options );
		}
	}
}

if ( ! function_exists( 'fcbkbttn_get_options_default' ) ) {
	function fcbkbttn_get_options_default() {
		global $fcbkbttn_plugin_info;

		$options_default = array(
			'plugin_option_version'		=>	$fcbkbttn_plugin_info["Version"],
			'display_settings_notice'	=>	1,
			'first_install'				=>	strtotime( "now" ),
			'suggest_feature_banner'	=>	1,
			'link'						=>	'',
			'my_page'					=>	1,
			'like'						=>	1,
			'layout_like_option'		=>	'standard',
			'layout_share_option'		=>	'button_count',
			'like_action'				=>	'like',
			'color_scheme'				=>	'light',
			'share'						=>	0,
			'faces'						=>	0,
			'width'						=>	225,
			'size'						=>	'small',
			'where'						=>	array( 'before' ),
			'display_option'			=>	'standard',
			'count_icon'				=>	1,
			'extention'					=>	'png',
			'fb_img_link'				=>	plugins_url( "images/standard-facebook-ico.png", __FILE__ ),
			'locale'					=>	'en_US',
			'html5'						=>	0,
			'use_multilanguage_locale'	=>	0,
			'display_for_excerpt'		=>	0,
			'location'					=>	'left',
			'id'						=>	1443946719181573
		);
		return $options_default;
	}
}

/**
* Function for activation
*/
if ( ! function_exists( 'fcbkbttn_plugin_activate' ) ) {
	function fcbkbttn_plugin_activate() {
		/* registering uninstall hook */
		if ( is_multisite() ) {
			switch_to_blog( 1 );
			register_uninstall_hook( __FILE__, 'fcbkbttn_delete_options' );
			restore_current_blog();
		} else {
			register_uninstall_hook( __FILE__, 'fcbkbttn_delete_options' );
		}
	}
}

/* Function formed content of the plugin's admin page. */
if ( ! function_exists( 'fcbkbttn_settings_page' ) ) {
	function fcbkbttn_settings_page() {
		require_once( dirname( __FILE__ ) . '/includes/class-fcbkbttn-settings.php' );
		$page = new Fcbkbttn_Settings_Tabs( plugin_basename( __FILE__ ) ); ?>
		<div class="wrap">
			<h1><?php _e( 'Facebook Button Settings', 'facebook-button-plugin' ); ?></h1>
			<noscript>
				<div class="error below-h2">
					<p><strong><?php _e( "Please, enable JavaScript in your browser.", 'facebook-button-plugin' ); ?></strong></p>
				</div>
			</noscript>
			<?php $page->display_content(); ?>
		</div>
	<?php }
}

/* Generate content for the buttons. */
if ( ! function_exists( 'fcbkbttn_button' ) ) {
	function fcbkbttn_button() {
		global $post, $fcbkbttn_options;

        if ( isset( $post->ID ) ) {
            $permalink_post = get_permalink( $post->ID );
        }

        $if_large = '';
        if ( $fcbkbttn_options['size'] == 'large' ) {
            $if_large = 'fcbkbttn_large_button';
        }

        if ( 'right' == $fcbkbttn_options['location'] ) {
            $button = '<div class="fcbkbttn_buttons_block" id="fcbkbttn_right">';
        } elseif ( 'middle' == $fcbkbttn_options['location'] ) {
            $button = '<div class="fcbkbttn_buttons_block" id="fcbkbttn_middle">';
        } elseif ( 'left' == $fcbkbttn_options['location'] ) {
            $button = '<div class="fcbkbttn_buttons_block" id="fcbkbttn_left">';
        }
        if ( ! empty( $fcbkbttn_options['my_page'] ) ) {
            $button .= '<div class="fcbkbttn_button">
                            <a href="https://www.facebook.com/' . $fcbkbttn_options['link'] . '" target="_blank">
                                <img src="' . $fcbkbttn_options['fb_img_link'] . '" alt="Fb-Button" />
                            </a>
                        </div>';
        }

        $location_share = ( 'right' == $fcbkbttn_options['location'] && "standard" == $fcbkbttn_options['layout_like_option'] ) ? 1 : 0;

        if ( ! empty( $fcbkbttn_options['share'] ) && ! empty( $location_share ) ) {
            $button .= '<div class="fb-share-button ' . $if_large . ' " data-href="' . $permalink_post . '" data-type="' . $fcbkbttn_options['layout_share_option'] . '" data-size="' . $fcbkbttn_options['size'] . '"></div>';
        }

        if ( ! empty( $fcbkbttn_options['like'] ) ) {
            $button .= '<div class="fcbkbttn_like ' . $if_large . '">';

            if ( ! empty( $fcbkbttn_options['html5'] ) ) {
                $button .= '<div class="fb-like fb-like-'. $fcbkbttn_options['layout_like_option'] .'" data-href="' . $permalink_post . '" data-colorscheme="' . $fcbkbttn_options['color_scheme'] . '" data-layout="' . $fcbkbttn_options['layout_like_option'] . '" data-action="' . $fcbkbttn_options['like_action'] . '" ';
                if ( 'standard' == $fcbkbttn_options['layout_like_option'] ) {
                    $button .= ' data-width="' . $fcbkbttn_options['width'] . 'px"';
                    $button .= ( ! empty( $fcbkbttn_options['faces'] ) ) ? " data-show-faces='true'" : " data-show-faces='false'";
                }
                $button .= ' data-size="' . $fcbkbttn_options['size'] . '"';
                $button .= '></div></div>';
            } else {
                $button .= '<fb:like href="' . $permalink_post . '" action="' . $fcbkbttn_options['like_action'] . '" colorscheme="' . $fcbkbttn_options['color_scheme'] . '" layout="' . $fcbkbttn_options['layout_like_option'] . '" ';
                if ( 'standard' == $fcbkbttn_options['layout_like_option'] ) {
                    $button .= ( ! empty( $fcbkbttn_options['faces'] ) ) ? "show-faces='true'" : "show-faces='false'";
                    $button .= ' width="' . $fcbkbttn_options['width'] . 'px"';
                }

                $button .= ' size="' . $fcbkbttn_options['size'] . '"';
                $button .= '></fb:like></div>';
            }
        }
        if ( ! empty( $fcbkbttn_options['share'] ) && empty( $location_share ) ) {
            $button .= '<div class="fb-share-button ' . $if_large . ' " data-href="' . $permalink_post . '" data-type="' . $fcbkbttn_options['layout_share_option'] . '" data-size="' . $fcbkbttn_options['size'] . '"></div>';
        }

        $button .= '</div>';

        return $button;
	}
}

/* Function taking from array 'fcbkbttn_options' necessary information to create Facebook Button and reacting to your choise in plugin menu - points where it appears. */
if ( ! function_exists( 'fcbkbttn_display_button' ) ) {
	function fcbkbttn_display_button( $content ) {
	    global $post;
		if ( isset( $post ) ) {
            if ( is_feed() ) {
                return $content;
            }

            global $fcbkbttn_options;

            $button = apply_filters( 'fcbkbttn_button_in_the_content', fcbkbttn_button() );
            /* Indication where show Facebook Button depending on selected item in admin page. */
            if ( ! empty( $fcbkbttn_options['where'] ) && in_array( 'before', $fcbkbttn_options['where'] ) ) {
                $content = $button . $content;
            }
            if ( ! empty( $fcbkbttn_options['where'] ) && in_array( 'after', $fcbkbttn_options['where'] ) ) {
                $content .= $button;
            }
		}
		return $content;
	}
}

/* Function 'fcbkbttn_shortcode' is used to create content for Facebook Button shortcode. */
if ( ! function_exists( 'fcbkbttn_shortcode' ) ) {
	function fcbkbttn_shortcode( $content ) {
		global $post, $fcbkbttn_options, $fcbkbttn_shortcode_add_script;

		if ( isset( $post->ID ) ) {
			$permalink_post	= get_permalink( $post->ID );
		}

		$button = fcbkbttn_button();

		if ( ( ! empty( $fcbkbttn_options['like'] ) || ! empty( $fcbkbttn_options['share'] ) ) && isset( $permalink_post ) ) {
			$fcbkbttn_shortcode_add_script = true;
		}
		return $button;
	}
}

/* add shortcode content  */
if ( ! function_exists( 'fcbkbttn_shortcode_button_content' ) ) {
	function fcbkbttn_shortcode_button_content( $content ) { ?>
		<div id="fcbkbttn" style="display:none;">
			<fieldset>
				<?php _e( 'Add Facebook buttons to your page or post', 'facebook-button-plugin' ); ?>
			</fieldset>
			<input class="bws_default_shortcode" type="hidden" name="default" value="[fb_button]" />
			<div class="clear"></div>
		</div>
	<?php }
}

/* Functions adds some right meta for Facebook */
if ( ! function_exists( 'fcbkbttn_meta' ) ) {
	function fcbkbttn_meta() {
		global $fcbkbttn_options, $post;
		if ( ! empty( $fcbkbttn_options['like'] ) || ! empty( $fcbkbttn_options['share'] ) ) {
			if ( is_singular() ) {
				$image = '';
				if ( has_post_thumbnail( get_the_ID() ) ) {
					$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
					$image = $image[0];
				}

				$description = ( has_excerpt() ) ? get_the_excerpt() : strip_tags( substr( $post->post_content, 0, 200 ) );

				$url 			= apply_filters( 'fcbkbttn_meta_url', esc_attr( get_permalink() ) );
				$description	= apply_filters( 'fcbkbttn_meta_description',  esc_attr( $description ) );
				$title 			= apply_filters( 'fcbkbttn_meta_title', esc_attr( get_the_title() ) );
				$site_name 		= apply_filters( 'fcbkbttn_meta_site_name', esc_attr( get_bloginfo() ) );
				$meta_image 	= apply_filters( 'fcbkbttn_meta_image', esc_url( $image ) );
				print "\n" . '<!-- fcbkbttn meta start -->';
				print "\n" . '<meta property="og:url" content="' . $url . '"/>';
				print "\n" . '<meta property="og:title" content="' . $title . '"/>';
				print "\n" . '<meta property="og:site_name" content="' . $site_name . '"/>';
				if ( ! empty( $image ) ) {
					print "\n" . '<meta property="og:image" content="' . $meta_image . '"/>';
				}
				if ( ! empty( $description ) ) {
					print "\n" . '<meta property="og:description" content="' . $description . '"/>';
				}
				print "\n" . '<!-- fcbkbttn meta end -->';
			}
		}
	}
}

if ( ! function_exists( 'fcbkbttn_get_locale' ) ) {
	function fcbkbttn_get_locale() {
		global $fcbkbttn_options, $fcbkbttn_lang_codes, $mltlngg_current_language;
		if ( ! empty( $fcbkbttn_options['use_multilanguage_locale'] ) && isset( $mltlngg_current_language ) ) {
			if ( array_key_exists( $mltlngg_current_language, $fcbkbttn_lang_codes ) ) {
				$fcbkbttn_locale = $mltlngg_current_language;
			} else {
				$locale_from_multilanguage = explode( '_', $mltlngg_current_language );
				if ( is_array( $locale_from_multilanguage ) && array_key_exists( $locale_from_multilanguage[0], $fcbkbttn_lang_codes ) ) {
					$fcbkbttn_locale = $locale_from_multilanguage[0];
				} else {
					foreach ( $fcbkbttn_lang_codes as $language_key => $language ) {
						$locale = explode( '_', $language_key );
						if ( $locale_from_multilanguage[0] == $locale[0] ) {
							$fcbkbttn_locale = $language_key;
							break;
						}
					}
				}
			}
		}
		if ( empty( $fcbkbttn_locale ) ) {
			$fcbkbttn_locale = $fcbkbttn_options['locale'];
		}

		return $fcbkbttn_locale;
	}
}

if ( ! function_exists( 'fcbkbttn_footer_script' ) ) {
	function fcbkbttn_footer_script() {
		global $fcbkbttn_options, $fcbkbttn_shortcode_add_script;

		if ( isset( $fcbkbttn_shortcode_add_script ) ||
			( ( ! empty( $fcbkbttn_options['like'] ) || ! empty( $fcbkbttn_options['share'] ) ) && ! empty( $fcbkbttn_options['where'] ) )
			|| defined( 'BWS_ENQUEUE_ALL_SCRIPTS' ) ) { ?>
			<div id="fb-root"></div>
            <script>
                window.fbAsyncInit = function() {
                    FB.init({
                        appId            : <?php echo $fcbkbttn_options['id']; ?>,
                        autoLogAppEvents : true,
                        xfbml            : true,
                        version          : 'v3.2'
                    });
                };

                (function(d, s, id){
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) {return;}
                    js = d.createElement(s); js.id = id;
                    js.src = "https://connect.facebook.net/<?php echo fcbkbttn_get_locale(); ?>/sdk.js";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            </script>
		<?php }
	}
}

if ( ! function_exists( 'fcbkbttn_pagination_callback' ) ) {
	function fcbkbttn_pagination_callback( $content ) {
		$content .= "if (typeof( FB ) != 'undefined' && FB != null ) { FB.XFBML.parse(); }";
		return $content;
	}
}

if ( ! function_exists( 'fcbkbttn_enqueue_scripts' ) ) {
	function fcbkbttn_enqueue_scripts() {
		if ( isset( $_GET['page'] ) && ( "facebook-button-plugin.php" == $_GET['page'] || "social-buttons.php" == $_GET['page'] ) ) {
			bws_enqueue_settings_scripts();
			bws_plugins_include_codemirror();
			wp_enqueue_script( 'fcbkbttn_script', plugins_url( 'js/admin-script.js', __FILE__ ), array( 'jquery' ) );
			wp_enqueue_style( 'fcbkbttn_stylesheet', plugins_url( 'css/style.css', __FILE__ ) );
		} elseif ( ! is_admin() ) {
			wp_enqueue_style( 'fcbkbttn_stylesheet', plugins_url( 'css/style.css', __FILE__ ) );
			wp_enqueue_script( 'fcbkbttn_script', plugins_url( 'js/script.js', __FILE__ ), array( 'jquery' ) );
		}
	}
}

/* Functions creates other links on plugins page. */
if ( ! function_exists( 'fcbkbttn_action_links' ) ) {
	function fcbkbttn_action_links( $links, $file ) {
		if ( ! is_network_admin() ) {
			/* Static so we don't call plugin_basename on every plugin row. */
			static $this_plugin;
			if ( ! $this_plugin ) {
				$this_plugin = plugin_basename( __FILE__ );
			}
			if ( $file == $this_plugin ) {
				$settings_link = '<a href="admin.php?page=facebook-button-plugin.php">' . __( 'Settings', 'facebook-button-plugin' ) . '</a>';
				array_unshift( $links, $settings_link );
			}
		}
		return $links;
	}
}
/* End function fcbkbttn_action_links */

if ( ! function_exists ( 'fcbkbttn_links' ) ) {
	function fcbkbttn_links( $links, $file ) {
		$base = plugin_basename( __FILE__ );
		if ( $file == $base ) {
			if ( ! is_network_admin() ) {
				$links[] = '<a href="admin.php?page=facebook-button-plugin.php">' . __( 'Settings', 'facebook-button-plugin' ) . '</a>';
			}
			$links[] = '<a href="https://support.bestwebsoft.com/hc/en-us/sections/200538939" target="_blank">' . __( 'FAQ', 'facebook-button-plugin' ) . '</a>';
			$links[] = '<a href="https://support.bestwebsoft.com">' . __( 'Support', 'facebook-button-plugin' ) . '</a>';
		}
		return $links;
	}
}
/* End function fcbkbttn_links */

/* add help tab  */
if ( ! function_exists( 'fcbkbttn_add_tabs' ) ) {
	function fcbkbttn_add_tabs() {
		$screen = get_current_screen();
		$args = array(
			'id'			=> 'fcbkbttn',
			'section'		=> '200538939'
		);
		bws_help_tab( $screen, $args );
	}
}

if ( ! function_exists ( 'fcbkbttn_plugin_banner' ) ) {
	function fcbkbttn_plugin_banner() {
		global $hook_suffix, $fcbkbttn_plugin_info;
		if ( 'plugins.php' == $hook_suffix ) {
			/*pls show banner go pro */
			global $fcbkbttn_options;
			if ( empty( $fcbkbttn_options ) ) {
				$fcbkbttn_options = get_option( 'fcbkbttn_options' );
			}

			if ( isset( $fcbkbttn_options['first_install'] ) && strtotime( '-1 week' ) > $fcbkbttn_options['first_install'] ) {
				bws_plugin_banner( $fcbkbttn_plugin_info, 'fcbkbttn', 'facebook-like-button', '45862a4b3cd7a03768666310fbdb19db', '78', 'facebook-button-plugin' );
			}

			/* show banner go settings pls*/
			if ( ! is_network_admin() ) {
				bws_plugin_banner_to_settings( $fcbkbttn_plugin_info, 'fcbkbttn_options', 'facebook-button-plugin', 'admin.php?page=facebook-button-plugin.php' );
			}
		}
		if ( isset( $_REQUEST['page'] ) && 'facebook-button-plugin.php' == $_REQUEST['page'] ) {
			bws_plugin_suggest_feature_banner( $fcbkbttn_plugin_info, 'fcbkbttn_options', 'facebook-button-plugin' );
		}
	}
}

/* Function for delete options */
if ( ! function_exists( 'fcbkbttn_delete_options' ) ) {
	function fcbkbttn_delete_options() {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		$all_plugins = get_plugins();

		if ( ! array_key_exists( 'bws-social-buttons/bws-social-buttons.php', $all_plugins ) &&
			! array_key_exists( 'bws-social-buttons-pro/bws-social-buttons-pro.php', $all_plugins ) &&
			! array_key_exists( 'facebook-button-pro/facebook-button-pro.php', $all_plugins ) &&
			! array_key_exists( 'facebook-button-plus/facebook-button-plus.php', $all_plugins )
        ) {
			/* delete custom images if no PRO version */
			$upload_dir = wp_upload_dir();
			$fcbkbttn_cstm_mg_folder = $upload_dir['basedir'] . '/facebook-image/';
			if ( is_dir( $fcbkbttn_cstm_mg_folder ) ) {
				$fcbkbttn_cstm_mg_files = scandir( $fcbkbttn_cstm_mg_folder );
				foreach ( $fcbkbttn_cstm_mg_files as $value ) {
					@unlink ( $fcbkbttn_cstm_mg_folder . $value );
				}
				@rmdir( $fcbkbttn_cstm_mg_folder );
			}

			if ( function_exists( 'is_multisite' ) && is_multisite() ) {
				global $wpdb;
				$old_blog = $wpdb->blogid;
				/* Get all blog ids */
				$blogids = $wpdb->get_col( "SELECT `blog_id` FROM $wpdb->blogs" );
				foreach ( $blogids as $blog_id ) {
					switch_to_blog( $blog_id );
					delete_option( 'fcbkbttn_options' );
				}
				switch_to_blog( $old_blog );
			} else {
				delete_option( 'fcbkbttn_options' );
			}
		}

		require_once( dirname( __FILE__ ) . '/bws_menu/bws_include.php' );
		bws_include_init( plugin_basename( __FILE__ ) );
		bws_delete_plugin( plugin_basename( __FILE__ ) );
	}
}
/* Plugin uninstall function */
register_activation_hook( __FILE__, 'fcbkbttn_plugin_activate' );
/* Calling a function add administrative menu. */
add_action( 'admin_menu', 'fcbkbttn_admin_menu' );
/* Initialization ##*/
add_action( 'plugins_loaded', 'fcbkbttn_plugins_loaded' );
add_action( 'init', 'fcbkbttn_init' );
add_action( 'admin_init', 'fcbkbttn_admin_init' );
/* Adding stylesheets */
add_action( 'wp_enqueue_scripts', 'fcbkbttn_enqueue_scripts' );
add_action( 'admin_enqueue_scripts', 'fcbkbttn_enqueue_scripts' );
/* Adding front-end stylesheets */
add_action( 'wp_head', 'fcbkbttn_meta' );
add_action( 'wp_footer', 'fcbkbttn_footer_script' );
add_filter( 'pgntn_callback', 'fcbkbttn_pagination_callback' );
/* Add shortcode and plugin buttons */
add_shortcode( 'fb_button', 'fcbkbttn_shortcode' );
/* custom filter for bws button in tinyMCE */
add_filter( 'bws_shortcode_button_content', 'fcbkbttn_shortcode_button_content' );
/*## Additional links on the plugin page */
add_filter( 'plugin_action_links', 'fcbkbttn_action_links', 10, 2 );
add_filter( 'plugin_row_meta', 'fcbkbttn_links', 10, 2 );
/* Adding banner */
add_action( 'admin_notices', 'fcbkbttn_plugin_banner' );