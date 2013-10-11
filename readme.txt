=== SX User Name Security - By SeoMix ===

Plugin Name:  SX User Name Security
Version:      1.0
Plugin URI:   http://www.seomix.fr
Description:  Prevents WordPress from showing User login and User ID. "User Name Security" filters User Nicename, Nickname and Display Name in order to avoid showing real User Login. This plugin also filters the body_class function to remove User ID and Nicename in it.
Usage: No configuration necessary. Upload, activate and done.
Availables languages : en_EN, fr_FR
Tags: security, protect, user login, user nicename, user nickname, user display name, body_class
Author: Confridin
Author URI: http://www.seomix.fr
Contributors: Confridin, secupress, juliobox
Requires at least: 3.5
Tested up to: 3.5
Stable tag: trunk
License: GPL v3

SX User Name Security prevents WordPress from showing your real Login to everyone, by overriding User Nicename, Nickname and Display Name and the body_class function.

== Description ==

WordPress automaticaly uses User login to fill in the "User Display Name". WordPress also allows everyone to use the same value for Nickanme, Display Name and Login. A hacker can easily use your "NickName" or "Display Name" to find your real login. The body_class function also shows to everyone your User ID and Login on author pages.

Once activated, SX User Name Security will prevent WordPress from showing those informations

**Features include**

Body_class function :

* Removes User ID from body_class function (author pages)
* Removes User Nicename from body_class function (author pages)

User informations :

* When user is logged in, the plugin changes "Display Name" and "Nickname" to a random value if they are equal to user login
* If not, it changes "Display Name" to "Nickname" or "Nickname" to "Display Name" if one of them is equal to user login

New Registration :

* Display Name and Nickname are changed to random value during user registration.
* Nicename is also changed to a random value : profil-5651646 for french users and user-5651646 for english (with a random number)

All functions are translated into french or english.

You can find me here : http://www.seomix.fr, and here is the french official post about this plugin : http://www.seomix.fr/user-name-security/

== Installation ==

No configuration is necessary. Upload, activate and done.

== Screenshots ==

1. "SX User Name Security" hides your author nicename and ID (body_class function).
2. When a user Nickname or Display Name are equals to Login, the plugin uses a random value instead.
3. During registration, WordPress won't use the same Display Name and Login for new users : "SX User Name Security" uses a random value.

== Changelog ==

**2013/03/08**

* first release

== Frequently Asked Questions ==

= Do I need to do anything else for this to work? =

No : just install it ;)