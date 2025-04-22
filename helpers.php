<?php

if( !function_exists('horizon_the_icon')) {
	/**
	 * Get the SVG icon and print it.
	 *
	 * @param string $icon_name Name of the icon file without the .svg extension.
	 * @return mixed
	 */
	function horizon_the_icon($icon_name = '') {
		// Set the path to the icons directory
		$icons_directory = get_template_directory() . '/icons/';
		
		// Construct the full path to the icon file
		$icon_file = $icons_directory . $icon_name . '.svg';
		
		// Check if the icon file exists
		if (file_exists($icon_file)) {
			// Get the contents of the icon file
			$icon_contents = file_get_contents($icon_file);
			
			// Print the contents of the icon file
			echo $icon_contents;
		}

		echo '';
	}
}

if( !function_exists('horizon_get_browser')) {
	/**
	 * horizon_get_browser
	 *
	 * Returns the name of the current browser.
	 *
	 * @since   HORIZON 5.0.0
	 *
	 * @return  string
	 */
	function horizon_get_browser() {

		// Check server var.
		if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$agent = sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] );

			// Loop over search terms.
			$browsers = array(
				'Firefox' => 'firefox',
				'Trident' => 'msie',
				'MSIE'    => 'msie',
				'Edge'    => 'edge',
				'Chrome'  => 'chrome',
				'Safari'  => 'safari',
			);
			foreach ( $browsers as $k => $v ) {
				if ( strpos( $agent, $k ) !== false ) {
					return $v;
				}
			}
		}

		// Return default.
		return '';
	}
}

if ( ! function_exists( 'horizon_add_admin_link' ) ) {
	/**
	 * Append menu item to menus.
	 *
	 * @param [type] $items
	 * @param [type] $args
	 * @return void
	 */
	function horizon_add_admin_link( $items, $args ) {
		
		if( $args->theme_location == 'primary' ) {
			$temporary = $items;
			$account = '';
            $user_verify = get_user_meta(get_current_user_id(), '_user_verify', true );
            $user_agree_to_guidelines = get_user_meta(get_current_user_id(), '_user_agree_to_guidelines', true ); 

			if( is_user_logged_in() ):

                if( '1' === $user_agree_to_guidelines && '1' === $user_verify ) { 
                    $account .= '
                        <li id="menu-item-create-post" class="menu-item menu-item-create-post">
                            <a href="/wp-admin/edit.php" alt="Create post">Create post</a>
                        </li>';
                }

				$account .= '
					<li id="menu-item-account" class="menu-item menu-item-account">
						<a href="/account" alt="Account">Account</a>
					</li>
					<li id="menu-item-logout" class="menu-item menu-item-logout">
						<a href="'.wp_logout_url( home_url() . '?logout=true' ) . '" alt="Logout">Logout</a>
					</li>';
		
			else:
				$account .= '
					<li id="menu-item-login" class="menu-item menu-item-login">
						<a href="/login" alt="Log in">Log in</a>
					</li>
                    <li id="menu-item-signup" class="menu-item menu-item-signup">
						<a href="/signup" alt="Sign up">Sign up</a>
					</li>';
			endif;

			$items = $temporary . $account;

		}

		return $items;
	}

	add_filter('wp_nav_menu_items', 'horizon_add_admin_link', 10, 2);
}

if( !function_exists('horizon_hex_to_rgba')) {
    /**
     * Convert hex color to rgba.
     *
     * @param string $hex
     * @param integer $opacity
     * @return string
     */
    function horizon_hex_to_rgba($hex, $opacity = 1) {
        // Remove the hash if it exists
        $hex = str_replace('#', '', $hex);

        // Handle short hex codes like #abc
        if (strlen($hex) == 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        // Convert hex values to RGB
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Ensure opacity is between 0 and 1
        $opacity = min(max($opacity, 0), 1);

        // Return the RGBA color string
        return "rgba($r, $g, $b, $opacity)";
    }
}

if ( ! function_exists( 'horizon_line_to_break' ) ) {
	/**
	 * Helper function to convert pipe \ to break
	 * Example Line 1\line 2
	 *
	 * @param string $title contains title.
	 *
	 * @return string
	 */
	function horizon_line_to_break( $title = '' ) {
		return ! empty( $title ) ? str_replace( '\\', '<br>', $title ) : '';
	}
}

if ( ! function_exists( 'horizon_line_to_span' ) ) {
	/**
	 * Helper function to wrap string encapsulated into pipes to span
	 * Example: hello I'm a |span|
	 *
	 * @param string $title contains title.
	 *
	 * @return string
	 */
	function horizon_line_to_span( $title = '',  $class='' ) {
		return ! empty( $title ) ? preg_replace( '/\|(.+?)\|/', '<span class="'.$class.'">$1</span>', $title ) : '';
	}
}

if ( ! function_exists( 'horizon_line_to_span_and_break' ) ) {
	/**
	 * Helper function to wrap string encapsulated into pipes to span and convert pipe \ to break
	 * Example: hello I'm a Line 1\|span|
	 *
	 * @param string $title contains title.
	 *
	 * @return string
	 */
	function horizon_line_to_span_and_break( $title = '', $class = '' ) {
		return horizon_line_to_break( horizon_line_to_span( $title, $class ) );
	}
}


if ( ! function_exists( 'horizon_reading_time' ) ) {
	/**
	 * Get post reading time.
	 *
	 * @param $id
	 * @return string
	 * @since 1.0.0
	 */
	function horizon_reading_time( $length = 200, $post_id = null ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		if ( ! $post_id ) {
			return false;
		}

		$content = get_post_field( 'post_content', $post_id );
		$wordCount = str_word_count( strip_tags( $content ) );
		$readingTime = ceil( $wordCount / $length );
		$timer = " minutes";

		if( $readingTime == 1 ) {
			$timer = " minute";
		}

		return $readingTime . ' ' . $timer . ' ' . 'of reading';
	}
}
