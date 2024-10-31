<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
// create custom plugin settings menu
add_action( 'admin_menu', 'CPF_create_menu_for_postfilter_plugin' );
add_action( 'admin_enqueue_scripts', 'CPF_postfilter_plugin_assets' );
define( "CPF_PLUGIN_PATH", plugin_dir_path( __FILE__ ) );
define( "CPF_PAGE_SLUG", "post-filter-plugin-options" );
define( "CPF_PAGE_TITLE", __( "Post Filter Settings", 'postfilter' ) );
define( "CPF_MENU_TITLE", __( "Post Filter", 'postfilter' ) );
define( "CPF_ACCESS_CAP", "administrator" );
define( "CPF_NONCE_ACTION", "CPF_WP_NONCE" );
function CPF_plugin_load_plugin_textdomain() {
	load_plugin_textdomain( 'postfilter', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'CPF_plugin_load_plugin_textdomain' );
function CPF_create_menu_for_postfilter_plugin() {
	$icon_base64 = 'data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCI+CjxnPgoJPHBvbHlnb24gc3R5bGU9ImZpbGw6I0UwRjRGRjsiIHBvaW50cz0iMzkxLDEyMCAzOTEsMjQxIDEyMSwyNDEgMTIxLDAgMjcxLDAgMzAxLDkwICAiLz4KCTxwb2x5Z29uIHN0eWxlPSJmaWxsOiNCQkRDRkY7IiBwb2ludHM9IjM5MSwxMjAgMzkxLDI0MSAyNTYsMjQxIDI1NiwwIDI3MSwwIDMwMSw5MCAgIi8+Cgk8cG9seWdvbiBzdHlsZT0iZmlsbDojNjRFMURDOyIgcG9pbnRzPSI0NTEsMjkyLjI5OSAzMDEsNDQyLjI5OSAzMDEsNTEyIDIxMSw1MTIgMjExLDQ0Mi4yOTkgNjEsMjkyLjI5OSAxMzcuODAyLDI3MC4wOTkgICAgMjU2LDI2Ny43IDM2Mi44MDIsMjY1LjMgICIvPgoJPHBvbHlnb24gc3R5bGU9ImZpbGw6IzAwQzhDODsiIHBvaW50cz0iMzYyLjgwMiwyNjUuMyA0NTEsMjkyLjI5OSAzMDEsNDQyLjI5OSAzMDEsNTEyIDI1Niw1MTIgMjU2LDI2Ny43ICAiLz4KCTxyZWN0IHg9IjYxIiB5PSIyMjkuNiIgc3R5bGU9ImZpbGw6IzAwQzhDODsiIHdpZHRoPSIzOTAiIGhlaWdodD0iNjIuNjk5Ii8+Cgk8cmVjdCB4PSIyNTYiIHk9IjIyOS42IiBzdHlsZT0iZmlsbDojMUNBREI1OyIgd2lkdGg9IjE5NSIgaGVpZ2h0PSI2Mi42OTkiLz4KCTxnPgoJCTxyZWN0IHg9IjMxIiB5PSIyMTEiIHN0eWxlPSJmaWxsOiM2NEUxREM7IiB3aWR0aD0iNDUwIiBoZWlnaHQ9IjMwIi8+Cgk8L2c+Cgk8cmVjdCB4PSIyNTYiIHk9IjIxMSIgc3R5bGU9ImZpbGw6IzAwQzhDODsiIHdpZHRoPSIyMjUiIGhlaWdodD0iMzAiLz4KCTxnPgoJCTxnPgoJCQk8Zz4KCQkJCTxnPgoJCQkJCTxwYXRoIHN0eWxlPSJmaWxsOiM5QUJBREI7IiBkPSJNMzkxLDEyMEgyNzFWMGg1MS4yMTFMMzkxLDY4Ljc4OVYxMjB6Ii8+CgkJCQk8L2c+CgkJCTwvZz4KCQk8L2c+Cgk8L2c+Cgk8Zz4KCQk8cmVjdCB4PSIxODEiIHk9IjE1MCIgc3R5bGU9ImZpbGw6IzU3NUY2NDsiIHdpZHRoPSIxNTAiIGhlaWdodD0iMzAiLz4KCTwvZz4KCTxnPgoJCTxyZWN0IHg9IjE4MSIgeT0iOTAiIHN0eWxlPSJmaWxsOiM1NzVGNjQ7IiB3aWR0aD0iNjAiIGhlaWdodD0iMzAiLz4KCTwvZz4KCTxyZWN0IHg9IjI1NiIgeT0iMTUwIiBzdHlsZT0iZmlsbDojMzIzOTNGOyIgd2lkdGg9Ijc1IiBoZWlnaHQ9IjMwIi8+CjwvZz4KCgoKCgoKCgoKCgoKCgoKPC9zdmc+Cg==';

	//create new top-level menu
	add_menu_page(
		CPF_PAGE_TITLE,
		__( CPF_MENU_TITLE, 'postfilter' ),
		CPF_ACCESS_CAP,
		CPF_PAGE_SLUG,
		'postfilter_plugin_settings_page',
		$icon_base64
	);

	//create new sub menu
	add_submenu_page(
		CPF_PAGE_SLUG,
		CPF_PAGE_TITLE,
		__( 'Donate', 'postfilter' ),
		CPF_ACCESS_CAP,
		'post-filter-about',
		'postfilter_plugin_about_page'
	);

}


function postfilter_plugin_about_page() {
	include 'pf-about.php';
	wp_enqueue_style(
		'postfilter_main_style',
		esc_url( plugins_url( 'assets/main.css', __FILE__ ) ) );
}

function CPF_postfilter_plugin_assets( $hook ) {

	if ( $hook == "toplevel_page_post-filter-plugin-options" ) {
		wp_enqueue_style(
			'postfilter_main_style',
			esc_url( plugins_url( 'assets/main.css', __FILE__ ) ) );
		wp_enqueue_style(
			'postfilter_amaran_style',
			esc_url( plugins_url( 'assets/amaran.min.css', __FILE__ ) ) );
		$translation_array = array(
			'saving'     => __( 'Saving...', 'postfilter' ),
			'saved'      => __( 'Settings Saved!', 'postfilter' ),
			'emptyerror' => __( 'Don\'t leave anything empty!', 'postfilter' ),
			'faild'      => __( 'Faild', 'postfilter' )
		);

		wp_register_script( 'postfilter_main_js', esc_url( plugins_url( 'assets/main.js', __FILE__ ) ) );
		wp_localize_script( 'postfilter_main_js', 'postfilter_main_js', $translation_array );
		wp_enqueue_script( 'postfilter_main_js',
			esc_url( plugins_url( 'assets/main.js', __FILE__ ) ) );
		wp_enqueue_script( 'postfilter_amaran_js',
			esc_url( plugins_url( 'assets/jquery.amaran.min.js', __FILE__ ) ) );


	}

}

function CPF_saveSettings() {
    
	$wp_nonce     = sanitize_text_field( $_GET['wp_nonce'] );
	$nonce_check  = wp_verify_nonce( $wp_nonce, CPF_NONCE_ACTION );
	if ( $nonce_check == false ) {
		wp_nonce_ays( CPF_NONCE_ACTION );
	} else {
		$postTypes    = array_map( 'sanitize_text_field', $_GET['post_types'] );
		$words        = wp_kses_post( $_GET['words'] );
		$event        = sanitize_text_field( $_GET['event'] );
		$mode         = sanitize_text_field( $_GET['mode'] );
		$replace_word = wp_kses_post( $_GET['replace_word'] );

		if ( current_user_can( CPF_ACCESS_CAP ) ) {
			if ( sizeof( $postTypes ) > 0 && strlen( $words ) > 0 && strlen( $event ) > 0 ) {
                update_option( 'pf-settings',
					json_encode(
						array(
							'post_types'   => $postTypes,
							'words'        => $words,
							'action'       => $event,
							'replace_word' => $replace_word,
                            'mode'         => $mode
						) ) );
			}
		}
	}

}

function CPF_general_admin_notice() {

	$screen = get_current_screen();
	if ( ! strpos( $screen->id, "post-filter-plugin-options" ) && ! strpos( $screen->id, "post-filter-about" ) && ! get_option( "pf-settings" ) ) {
		echo '<div class="notice notice-warning is-dismissible">
             <p>' . sprintf( __( 'To use Post Filter, start from <a href="%s">Settings</a>.', 'postfilter' ), admin_url( 'admin.php?page=post-filter-plugin-options' ) ) . '</p>
         </div>';
	}

}

add_action( 'admin_notices', 'CPF_general_admin_notice' );


add_action( 'admin_post_save_postfilter_settings', 'CPF_saveSettings' );


function postfilter_plugin_settings_page() {
	$settings = null;
	if ( get_option( 'pf-settings' ) ) {
		global $settings;
		$settings = json_decode( get_option( 'pf-settings' ) );
	}
	$post_types = get_post_types();
	?>
    <div class="wrap CPF_settings_container">
        <span class="dashicons dashicons-admin-tools"></span>
        <h1><?php _e( 'Post Filter Settings', 'postfilter' ) ?></h1>

        <div class="post-filter-which-post-types">
            <p><?php _e( 'Which post types should be considered?', 'postfilter' ) ?></p>
            <select title="Post types" class="pv-post-typle-select" multiple>
				<?php
				foreach ( $post_types as $post_type ) {
					?>

                    <option <?php if ( $settings != null ) {
						foreach ( $settings->post_types as $postType ) {
							if ( $postType === $post_type ) {
								echo "selected";
								break;
							}
						}
					} ?>><?php echo $post_type ?></option>
					<?php
				}

				?>
            </select>


            <p class="pf_note"><?php _e( '* Select multiple options by pressing CTRL (Windows) or Command (Mac)', 'postfilter' ) ?></p>
        </div>
        <div class="post-filter-black-list margin-bottom-30">
            <p><?php _e( 'Which words should be filtered?', 'postfilter' ) ?></p>
            <br>
            <textarea rows="5" cols="60" placeholder="<?php _e( 'Enter words here...', 'postfilter' ); ?>"
                      id="pf-black-list"><?php if ( $settings != null ) {
					echo esc_html( $settings->words );
				} ?></textarea><br>
            <p class="pf_note"><?php _e( '* Seperate with comma', 'postfilter' ); ?></p>
        </div>
        <div class="post-filter-action-choices margin-bottom-30">
            <p><?php _e( 'What to do if detected?', 'postfilter' ) ?></p>
            <br>
            <input title="Alternative word option"
                   type="radio" <?php if ( $settings != null && $settings->action === 'replace' ) {
				echo "checked";
			} ?> name="action-choice" value="replace"><?php _e( 'Replace with', 'postfilter' ); ?>
            <input title="Alternative word" type="text" name="action-replace-word"
                   value="<?php if ( $settings != null ) {
				       echo esc_html( $settings->replace_word );
			       } ?>"><br>
            <input title="Draft option" type="radio" <?php if ( $settings != null && $settings->action === 'draft' ) {
				echo "checked";
			} ?> name="action-choice" value="draft"><?php _e( ' Move to Drafts', 'postfilter' ); ?><br>
        </div>
        <!--  Search mode section -->
        <div class="post-filter-search-modes margin-bottom-30">
            <p><?php _e( 'How to search for words?', 'postfilter' ) ?></p>
            <br>
            <input title="Choosing search mode"
                   type="radio" <?php if ( $settings != null && $settings->mode === 'strict' ) {
				echo "checked";
			} ?> name="search-mode-choice" value="strict"><?php _e( 'Strict mode', 'postfilter' ); ?>
            <div class="tooltip">❓
                <span class="tooltiptext"><?php _e( 'Finds "are" in "aware"', 'postfilter' ); ?></span>
            </div>
            <br>
            <input title="Words Only option" type="radio" <?php if ( $settings != null && $settings->mode === 'wordsOnly' ) {
				echo "checked";
			} ?> name="search-mode-choice" value="wordsOnly"><?php _e( ' Search for Words', 'postfilter' ); ?>
            <div class="tooltip">❓
                <span class="tooltiptext"><?php _e( 'Finds "are" in "How are you?"', 'postfilter' ); ?></span>
            </div>
            <br>
        </div>
        <input data-ajax-url="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
               onclick="pf_save_button_clicked()" type="button" class="button button-primary" name="pf_submit_button"
               value="<?php _e( 'Save Changes', 'postfilter' ) ?>">
        <input type="hidden" id="wp-nonce" value="<?php echo wp_create_nonce( CPF_NONCE_ACTION ) ?>">


    </div>
<?php } ?>