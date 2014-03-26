<?php
/*
Plugin Name:  SX User Name Security
Version:      2.0
Plugin URI:   http://www.seomix.fr
Description:  Prevents WordPress from showing User login and User ID. "User Name Security" filters User Nicename, Nickname and Display Name in order to avoid showing real User Login. This plugin also filters the body_class function to remove User ID and Nicename in it.
Availables languages: en_EN, fr_FR
Tags: security, protect, user login, user nicename, user nickname, user display name, body_class
Author: Daniel Roch
Author URI: http://www.seomix.fr
Contributors: juliobox, secupress
Requires at least: 3.1
Tested up to: 3.9
License: GPL v3

User Name Security - SeoMix
Copyright (C) 2013-2014, Daniel Roch - contact@seomix.fr

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
  * Security
*/
defined( 'ABSPATH' ) || die( 'Cheatin&#8217; uh?' );

/**
 * Load Language Files 
 */
add_action( 'plugins_loaded', 'seomix_sx_security_init' );
function seomix_sx_security_init()
{
	$location = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
	load_plugin_textdomain( 'sx-user-name-security', false, $location );
}

/**
 * Show every author on plugin Page
 */
add_filter( 'plugin_row_meta', 'seomix_sx_plugin_row_meta', 10, 2 );
function seomix_sx_plugin_row_meta( $plugin_meta, $plugin_file )
{
	// Is it this plugin?
	if( plugin_basename( __FILE__ ) == $plugin_file ){
		// Keep the last idem
		$last = end( $plugin_meta );
		// Keep the metas
		$plugin_meta = array_slice( $plugin_meta, 0, -2 );
		$a = array();
		// Who are we?
		$authors = array(
			array(  'name'=>'Daniel Roch', 'url'=>'http://www.seomix.fr/' ),
			array(  'name'=>'Julio Potier', 'url'=>'http://www.boiteaweb.fr' ),
			array(  'name'=>'SecuPress', 'url'=>'http://blog.secupress.fr' ),
		);
		// Create the new links
		foreach( $authors as $author )
		{
			$a[] = '<a href="' . $author['url'] . '" title="' . esc_attr__( 'Visit author homepage' ) . '">' . $author['name'] . '</a>';
		}
		// Create the string
		$a = sprintf( __( 'By %s' ), wp_sprintf( '%l', $a ) );
		// Replace back the metas
		$plugin_meta[] = $a;
		// Replace back the last item
		$plugin_meta[] = $last;
	}
	return $plugin_meta;
}

/**
  * Filter body_class in order to hide User ID and User nicename
  * @var array $wp_classes holds every default classes for body_class function
  * @var array $extra_classes holds every extra classes for body_class function
  */
add_filter( 'body_class', 'seomix_sx_security_body_class', 10, 2 );
function seomix_sx_security_body_class( $wp_classes, $extra_classes )
{
	if ( is_author() ) {
		// Getting author Information
		$curauth = get_query_var( 'author_name' ) ? get_user_by( 'slug', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );
		// Blacklist author-ID class
		$blacklist[] = 'author-'.$curauth->ID;
		// Blacklist author-nicename class
		$blacklist[] = 'author-'.$curauth->user_nicename;
		// Delete useless classes
		$wp_classes = array_diff( $wp_classes, $blacklist );
	}
	// Return all classes
	return array_merge( $wp_classes, (array)$extra_classes );
}


/**
  * When User is logged in, it forces Display name and Nickname to be different from User Login
  *
  */
add_action( 'init', 'seomix_sx_security_users_change_displayname' );
function seomix_sx_security_users_change_displayname()
{
	if( is_user_logged_in() ) {
		// Get Current User Object
		global $current_user;
		// Get Current User ID
		$userID = $current_user->ID;
		// Get Current User Display Name
		$displayname = $current_user->display_name;
		// Get current User Login
		$userlogin= $current_user->user_login;
		// Get current User nickName
		$usernickname= $current_user->nickname;
		// Random var in order to change User data
		$newname = seomix_sx_congolexicomatisation();
		// if Display Name, User login and Nickname are equal, change them to random var
		if( $displayname == $userlogin && $usernickname == $userlogin ) {
			update_user_meta( $userID, 'nickname', $newname );
			wp_update_user( array ('ID' => $userID, 'display_name' => $newname ) );
		}
		// if Display Name and User login are equal, change it to NickName
		elseif( $displayname == $userlogin) {
			wp_update_user( array ('ID' => $userID, 'display_name' => $usernickname ) );
		}
		// if nickName and User login are equal, change it to Display Name
		elseif( $usernickname == $userlogin ) {
			update_user_meta( $userID, 'nickname', $displayname );
		}
	}
}

/**
  * Detect user creation
  *
  * When a new user is created, creates a global var $seomix_var_new_login
  */
add_filter( 'pre_user_login', 'seomix_sx_security_login_detector' );
function seomix_sx_security_login_detector( $login ) {
	// Creata a global var to be used in seomix_sx_security_name_filter()
	global $seomix_var_new_login;
	// Do this user already exists?
	$seomix_var_new_login = !get_user_by( 'login', $login );
	// Do not modify, just return it.
	return $login;
}

/**
  * Filter data when registering and modification
  *
  * When a new user is created or modified, change User Nicename, Nickname and  Display Name
  *
  */
add_filter( 'pre_user_display_name', 'seomix_sx_security_name_filter' );
add_filter( 'pre_user_nickname', 'seomix_sx_security_name_filter' );
add_filter( 'pre_user_nicename', 'seomix_sx_security_name_filter' );
function seomix_sx_security_name_filter( $name )
{
	// Test if user can be found by its nickname/display name/nicename
	$user_test = get_user_by( 'login', $name );
	// Found!
	if( is_a( $user_test, 'WP_User' ) )
	{
		// Create a static to be used betweent the 3 hooks
		static $_name;
		// Not set yet, do it
  		if( !$_name ) {
  			// Generate the name, see below
			$_name = seomix_sx_congolexicomatisation();
		}
		// Use it now
		$name = $_name;
		// If we are in the nicename hook AND login==nicename + new user, use the generated new name sanitized
		if( 'pre_user_nicename' == current_filter() && $GLOBALS['seomix_var_new_login'] ) {
			$name = sanitize_key( $name );
		}
	}
	return $name;
}

/**
  *
  * This function will check if an admin notice has to be shown
  *
  */
add_action( 'admin_init', 'seomix_sx_check_nicename' );
function seomix_sx_check_nicename()
{
	global $current_user;
	// Get current User Login
	$userlogin = $current_user->user_login;
	// Get current User NiceName
	$nicename = $current_user->user_nicename;

	// If the nicename is equal to login
	if( $nicename==$userlogin ) {
		// Var to check if sf-author-url-control is installed (active or not)
		$is_installed__sf_author_url_control = get_plugins( '/sf-author-url-control' ); 
		// Var to check if sf-author-url-control is active
		$is_active__sf_author_url_control = is_plugin_active( 'sf-author-url-control/sf-author-url-control.php' );
		// we add the action right now
		add_action( 'admin_notices', 'seomix_sx_alert' );
		// create a global var, so i can read it in seomix_sx_alert()
		global $seomix_sx_reason;
		// If the current user can install plugins (like admin)
		if( current_user_can( 'install_plugins' ) ) {
			// if sf-author-url-control installed but not active?
			if( $is_installed__sf_author_url_control && !$is_active__sf_author_url_control ) {
				$seomix_sx_reason = 'install_not_active';
			// if sf-author-url-control not installed?
			}elseif( !$is_installed__sf_author_url_control  ) {
				$seomix_sx_reason = 'not_installed';
			// sf-author-url-control is active, so change your nicename
			}else{
				$seomix_sx_reason = 'change_your_nicename';
			}
		// or the current user can not install plugins (like subscriber, author, contributor, editor)
		}else{
			// if sf-author-url-control not installed or not active?
			if( !$is_installed__sf_author_url_control || !$is_active__sf_author_url_control ) {
				$seomix_sx_reason = 'install_or_active';
			// sf-author-url-control is active, so change your nicename
			}elseif( $is_active__sf_author_url_control ) {
				$seomix_sx_reason = 'change_your_nicename';
			}
		}
	}
}

/**
  *
  * This function will show the admin notice for current_user_can( 'install_plugins' )
  *
  */
// no hook here, see seomix_sx_check_nicename()
function seomix_sx_alert()
{
	global $seomix_sx_reason;
	// URL for installation of sf-author-url-control
	$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=sf-author-url-control' ), 'install-plugin_sf-author-url-control' );
	// URL for activation of sf-author-url-control
	$active_url = wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin=sf-author-url-control%2Fsf-author-url-control.php' ), 'activate-plugin_sf-author-url-control/sf-author-url-control.php' );
	// URL for sf-author-url-control settings
	$change_url = self_admin_url( 'profile#user_nicename' );
?>
	<div class="error">
	<p><b>SX User Name Security</b><br>
	<?php _e( 'Your <code>login</code> and your <code>nicename</code> <em>(used in URLs)</em> are the same and this is not secure. We don\'t want to force the change of this because it can lead to a 404 error. WordPress do not permit this edit easily.', 'sx-user-name-security' ); ?>
	<br>
	<?php
		// depending on the reason, what do we have to say?
		switch ( $seomix_sx_reason ) {
			case 'not_installed':
				printf( __( 'We recommand you to install <a href="%s">SF Author Url Control</a>. Then <a href="%s">activate it</a> and finally <a href="%s">change your nicename</a>.', 'sx-user-name-security' ), $install_url, $active_url, $change_url );
			break;
			case 'install_not_active':
				printf( __( 'You have already installed <b>SF Author Url Control</b>. Now please, <a href="%s">activate it</a> then <a href="%s">change your nicename</a>.', 'sx-user-name-security' ), $active_url, $change_url );
			break;
			case 'install_or_active':
				printf( __( 'To do this, please <a href="mailto:%s">ask the administrator</a> to install and activate the following plugin: <a href="http://wordpress.org/plugins/sf-author-url-control/">SF Author Url Control</a>. Thank you.', 'sx-user-name-security' ), get_option( 'admin_email' ) );
			break;
			case 'change_your_nicename':
				printf( __( 'You are already using <b>SF Author Url Control</b>. Now please <a href="%s">change your nicename</a>.', 'sx-user-name-security' ), $change_url );
			break;
		}
	?>
	</p></div>
<?php
}

/**
  *
  * This function will generate a random name, human readable #fun
  *
  */
function seomix_sx_congolexicomatisation( $count=8 ) // Thanks to Eddy Malou
{
	$v = array_flip( str_split( 'aaeeiou' ) );
	$c = array_flip( str_split( 'bcdfgjlmnprstv' ) );
	$name = '';
	for( $i=1; $i<=$count; $i++ ) { 
		if( ceil($count/2)==$i ) {
			$name .= ' '.array_rand( $c ).'. '.array_rand( $v );
		}
		$name .= array_rand( $c ).array_rand( $v );
	}
	return ucwords( $name );
}
//EOF.