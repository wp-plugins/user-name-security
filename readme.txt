=== SX User Name Security ===

Plugin Name:  SX User Name Security
Version:      2.0
Plugin URI:   http://www.seomix.fr
Description:  Prevents WordPress from showing User login and User ID. "User Name Security" filters User Nicename, Nickname and Display Name in order to avoid showing real User Login. This plugin also filters the body_class function to remove User ID and Nicename in it.
Usage: No configuration necessary. Upload, activate and done.
Availables languages : en_EN, fr_FR
Tags: security, protect, protection, login, user, users, nicename, nickname, display name, user id, user login, user nicename, user nickname, user display name, body_class
Author: Confridin
Author URI: http://www.seomix.fr
Contributors: Confridin, juliobox, secupress
Requires at least: 3.1
Tested up to: 3.9
Stable tag: trunk
License: GPL v3

SX User Name Security prevents WordPress from showing your real Login to everyone, by overriding User Nicename, Nickname and Display Name and the body_class function.

== Description ==

WordPress automaticaly uses "User login" to fill in the "User Display Name". WordPress also allows everyone to use the same value for Nickname, Display Name and Login. A hacker can easily use your "NickName" or "Display Name" to find your real login. The body_class function also shows to everyone your User ID and Login on author pages.

Once activated, SX User Name Security will prevent WordPress from showing those informations

**Features**

Body_class function :

* Removes User ID from body_class function (author pages)
* Removes User Nicename from body_class function (author pages)

User informations :

* When user is logged in, the plugin changes "Display Name" and "Nickname" to a random value if they are equal to user login
* If not, it changes "Display Name" to "Nickname" or "Nickname" to "Display Name" if one of them is equal to user login

New Registration :

* Display Name and Nickname are changed to random value during user registration.
* Nicename is also changed to a random value like : 'Ticibe T. Aduvoguripe', 'Lagubo N. Agigerovibe' or 'Datela N. Orejadavino'. The Nicename is used to generate the user permalink on the front-end. ;)

All functions are translated into french or english.

You can find me here : http://www.seomix.fr, and here is 2 french official posts about this plugin : http://www.seomix.fr/user-name-security/ and http://blog.secupress.fr/user-name-security-cachez-login-utilisateurs-61.html
The english one : http://blog.secupress.fr/en/user-name-security-hide-user-login-67.html

== Installation ==

No configuration is necessary. Upload, activate and done. Every previous user has to visit his profile once in order to hide login informations (an administrator can also simply save again previous users).

== Screenshots ==

1. "SX User Name Security" hides your author nicename and ID (body_class function).
2. When a user Nickname or Display Name are equals to Login, the plugin uses a random value instead.
3. During registration, WordPress won't use the same Display Name and Login for new users : "SX User Name Security" uses a random value.

== Changelog ==

**2014/03/26**

* Code improvement
* Bug fixes (in some cases, user "Display Name" and "Login" were not modified)
* Now an administrator can also trigger every function by saving a user (you don't have to wait every user to log-in)
* New alerts (admin notices)

**2013/03/08**

* first release

== Frequently Asked Questions ==

= Do I need to do anything else for this to work? =

It's better to use http://wordpress.org/plugins/sf-author-url-control/ combined with this plugin to also change current author permalinks (in order to hide login information).