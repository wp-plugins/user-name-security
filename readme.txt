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

User Name Security prevents WordPress from showing your real Login, by overriding User Nicename, Nickname and Display Name

== Description ==

WordPress automaticaly uses User login to fill in User Display Name. It also allows everyone to use the same value for Nickanme, Display Name and login. A hacker may use this information to guess your login. And the body_class function alos show to everyone the User ID and User Nicename.

Once activated, User Name Security will prevent WordPress from showing those informations

**Features include**

* Removes User ID from body_class function (author pages)
* Removes User Nicename from body_class function (author pages)
* When user is logged in, change Display Name and Nickname to random value if they are equal to User login
* When user is logged in, change Display Name to Nickname if it is equal to User login
* When user is logged in, change Nickname to Display Name if it is equal to User login
* When a new registration is completed, changes Display Name and Nickname to random value
* When a new registration is completed, changes Nicename to random value : exemple profil-5651646 (random number)

Random is available in English and French. For exemple :
* New User 2513787 (random number)
* Nouvel utilisateur 2513787 (random number)

== Installation ==

No configuration is necessary. Upload, activate and done.

== Screenshots ==

No screenshots available - code only.

== Changelog ==

**2013/03/01**

* first release

== Frequently Asked Questions ==

= Do I need to do anything else for this to work? =

No : just install it ;)