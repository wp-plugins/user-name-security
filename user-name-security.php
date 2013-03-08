<?php
/*
Plugin Name:  User Name Security
Version:      1.0
Plugin URI:   http://www.seomix.fr
Description:  Prevents WordPress from showing User login and User ID. It filter User Nicename, Nickname and Display Name  in order to avoid showing real User Login. This plugin also filter the body_class function to remove User ID and Nicename in it.
Usage: No configuration necessary. Upload, activate and done.
Availables languages : en_EN, fr_FR
Tags: security, protect, user login, user nicename, user nickname, user display name, body_class
Author: Daniel Roch
Author URI: http://www.seomix.fr
Contributors: juliobox
Requires at least: 3.5
Tested up to: 3.5
License: GPL v3

User Name Security - SeoMix
Copyright (C) 2013, Daniel Roch - contact@seomix.fr

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
 Load Language Files 
 */
function seomix_sx_security_init()  {
  $location = dirname(plugin_basename(__FILE__)) . '/languages/';
  load_plugin_textdomain('sx-user-name-security', false, $location);
}
add_action('plugins_loaded', 'seomix_sx_security_init');


/**
  Filter body_class in order to hide User ID and User nicename
  * @var array $wp_classes holds every default classes for body_class function
  * @var array $extra_classes holds every extra classes for body_class function
  */
function seomix_sx_security_body_class( $wp_classes, $extra_classes ) {
  if ( is_author() ) {
      // Getting author Information
      $curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
      // Blacklist author-ID class
      $blacklist[] = 'author-'.$curauth->ID;
      // Blacklist author-nicename class
      $blacklist[] = 'author-'.$curauth->user_nicename;
      // Delete useless classes
      $wp_classes = array_diff( $wp_classes, $blacklist );
  }
  // Return all classes
  return array_merge( $wp_classes, (array) $extra_classes );}
add_filter( 'body_class', 'seomix_sx_security_body_class', 10, 2 );


/**
  When User is logged in, it forces Display name and Nickname to be different from User Login
  *
  */
function seomix_sx_security_users_change_displayname() {
  // Get Current User Object
  $current_user = wp_get_current_user();
  // Get Current User ID
  $userID = get_current_user_id();
  // Get Current User Display Name
  $displayname = $current_user->display_name;
  // Get current User Login
  $userlogin= $current_user->user_login;
  // Get current User nickName
  $usernickname= $current_user->nickname;
  // Random var in order to change User data
  $textlang = __('New user', 'sx-user-name-security');
  $final = $textlang." ".rand(0,999999);
  // if Display Name, User login and Nickname are equal, change them to random var
  if ($displayname == $userlogin && $usernickname == $userlogin) {
    update_user_meta($userID, 'nickname', $final);
    wp_update_user( array ('ID' => $userID, 'display_name' => $final) );
  }
  // if Display Name and User login are equal, change it to NickName
  elseif ($displayname == $userlogin) {
    wp_update_user( array ('ID' => $userID, 'display_name' => $usernickname) );
  }
  // if nickName and User login are equal, change it to Display Name
  elseif ($usernickname == $userlogin) {
    update_user_meta($userID, 'nickname', $displayname);
  }
}
add_action('wp_loaded','seomix_sx_security_users_change_displayname');


/**
  Detect user creation
  *
  * When a new user is created, creates a global var $seomix_var_new_login
  */
function seomix_sx_security_login_detector( $login ) {
  global $wpdb, $seomix_var_new_login;
  $seomix_var_new_login = !get_user_by( 'login', $login );
  return $login;
}
add_filter( 'pre_user_login', 'seomix_sx_security_login_detector' );


/**
  Filter data when registering
  *
  * When a new user is created, change User Nicename, Nickname and  Display Name
  *
  */
function seomix_sx_security_name_filter( $name, $for_nicename=false ) {
  global $seomix_var_new_login;
  // For Nickanme and Display Name
  $traduser = __('New user', 'sx-user-name-security');
  $rendu = $traduser." ".rand(0,999999); 
  //For Nicename
  $tradnicename = __('user', 'sx-user-name-security');
  $nicename = $tradnicename."-".rand(0,999999);
  // Apply Filters
  if( $seomix_var_new_login )
    $name = !$for_nicename ? $rendu : $nicename;
  return $name;}
add_filter( 'pre_user_nickname', 'seomix_sx_security_name_filter' );
add_filter( 'pre_user_display_name', 'seomix_sx_security_name_filter' );
add_filter( 'pre_user_nicename', create_function( '$u', 'return seomix_sx_security_name_filter($u,true);' ) );


?>