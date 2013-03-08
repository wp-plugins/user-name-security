=== User Name Security - By SeoMix ===

Plugin Name:  User Name Security
Version:      1.0
Plugin URI:   http://www.seomix.fr
Description:  Prevents WordPress from showing User login and User ID. It filter User Nicename, Nickname and Display Name  in order to avoid showing real User Login. This plugin also filter the body_class function to remove User ID and Nicename in it.
Usage: No configuration necessary. Upload, activate and done.
Availables languages : en_EN, fr_FR
Tags: security, protect, user login, user nicename, user nickname, user display name, body_class
Author: Confridin
Author URI: http://www.seomix.fr
Contributors: juliobox
Requires at least: 3.5
Tested up to: 3.5
Stable tag: trunk
License: GPL v3

User Name Security prevents WordPress from showing your real Login, by overriding User Nicename, Nickname and Display Name and th body_class function.

== Description ==

WordPress automaticaly uses User login to fill in User Display Name. WordPress also allows everyone to use the same value for Nickanme, Display Name and Login. A hacker may use this information to find your login. And the body_class function also shows to everyone your User ID and Nicename ont author pages.

Once activated, User Name Security will prevent WordPress from showing those informations

**Features include**

Body_class function :

* Removes User ID from body_class function (author pages)
* Removes User Nicename from body_class function (author pages)

User informations :

* When user is logged in, the plugin changes Display Name and Nickname to random value if they are equal to User login
* If not, it changes Display Name to Nickname or Nickname to Display Name if one of them is equal to User login

New Registration :
* Display Name and Nickname are changed to random value during user registration.
* Nicename is also changed to a random value : profil-5651646 for french users and user-5651646 for english (with a random number)

All functions are translated into french or english.

Thanks to Julio Potier for his help : http://www.boiteaweb.fr/

You can find me here : http://www.seomix.fr

== Installation ==

No configuration is necessary. Upload, activate and done.

== Screenshots ==

No screenshots available - code only.

== Changelog ==

**2013/03/08**

* first release

== Frequently Asked Questions ==

= Do I need to do anything else for this to work? =

No : just install it ;)