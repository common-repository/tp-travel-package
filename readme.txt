=== TP Travel Package ===
Contributors: themepalace
Tags: Custom Post Type, Meta data, Travel
Donate link: http://themepalace.com
Requires at least: 4.7
Tested up to: 6.0
Stable tag: 1.0.4
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Enhance your travel sites more efficiently. Allow user to utilize post types and meta data on your site with TP Travel Package.


== Description ==
	A plugin to add custom post type ( Destination and Package ) and it's required meta fields for travel sites. This plugin is dedicated for travel themes.

= Template Overwrite =
	* Create a folder named "tp-travel-packagee" and do all the overwrites inside the folder as instructed below.
	* Archive Pages
		- you can overwrite all archive pages for post types available in this plugin. ie: tp-archive-package.php
	* Search Page
		- you can overwrite package search page for post types available in this plugin by tp-package-search.php
	* Single Pages
	- you can overwrite all single pages for post types available in this plugin. ie: tp-single-package.php

== Installation ==
	= Using The WordPress Dashboard =
	* Navigate to the 'Add New' in the plugins dashboard
	* Search for TP Education
	* Click Install Now
	* Activate the plugin on the Plugin dashboard
	= Uploading in WordPress Dashboard =
	* Navigate to the 'Add New' in the plugins dashboard
	* Navigate to the 'Upload' area
	* Select tp-education.zip from your computer
	* Click 'Install Now'
	* Activate the plugin in the Plugin dashboard
	= Using FTP =
	* Download tp-education.zip
	* Extract the tp-education directory to your computer
	* Upload the tp-education directory to the /wp-content/plugins/ directory
	* Activate the plugin in the Plugin dashboard
	= Setting Options =
	* Setting Page is located inside Default Settings Option
	* Enable and Disable Post Types Options As Per Need

== Screenshots ==
	1. Package Meta Fields
	2. Destination Meta Fields


== Functions to Call Meta Values ==

	= Destination Details =
	tp_destination_quote( $post_id = '' ); // Destination Quote
	tp_destination_rating_value( $post_id = '' ); // Destination Rating value in number
	tp_destination_rating( $post_id = '' ); // Destination Rating value in stars

	= Package Details =
	tp_package_quote( $post_id = '' ); // Package Quote
	tp_package_price( $post_id = '' ); // Package Price
	tp_package_pax( $post_id = '' ); // No of people for package
	tp_package_days( $post_id = '' ); // No of days for package
	tp_package_difficulty( $post_id = '' ); // Package Diffifulty
	tp_package_date( $post_id = '' ); // Package Departure
	tp_package_destination( $post_id = '' ); // Package Destinaiton
	tp_package_destination_link( $post_id = '' ); // Package Destinaiton with link


== Frequently Asked Questions ==
	= There is something cool you could add... =


== Files ==

	jQuery UI - v1.12.0
	License: https://jquery.org/license/ ( Copyright jQuery Foundation and other contributors; Licensed MIT )
	Source: http://jqueryui.com

== Changelog ==

= 1.0.4 =
* Tested upto WordPress v6.0

= 1.0.3 =
* Tested upto WordPress v5.8

= 1.0.2 =
* added data migration support for WP Travel Plugin

= 1.0.1 =
* Tested upto WordPress v4.9.4

= 1.0 =
* Initial release.


== Upgrade Notice ==

= 1.0 =
* Initial release.
