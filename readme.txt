=== Custom Types and Fields ===
Contributors: davidlinnard
Tags: Custom Types, Custom Fields
Requires at least: 3.0
Tested up to: 3.2
Stable tag: 0.1
License: GPLv2 or later

This plugin allows you to programmatically create new custom types or add custom fields to existing types.

== Description ==
All custom types must currently be created in code since this was the easiest way to create it. The plugin ties in to the standard Wordpress HTML and Image fields functionality within Wordpress. Select boxes, checkboxes and 
standard text fields can also be created.

By having content in the code, you can do things like create dropdowns of other content easily, as well as make migration between environments
easier (example code is supplied). 


== Installation ==

1) Upload the plugin to '/wp-content/plugins/' directory
2) Activate the plugin through the plugins 
3) Move the file "sample-types.php" to your active theme directory and rename it "types.php"
4) Update the file with any custom types you want to create

You will still need to create templates to go with your custom types:
http://codex.wordpress.org/Custom_Fields
http://codex.wordpress.org/Function_Reference/get_post_custom
http://codex.wordpress.org/Function_Reference/get_post_meta

== Changelog ==

= 0.1 = 
* Initial build

== Screenshots ==
1. /tags/0.1/screenshot-1.jpg
2. /tags/0.1/screenshot-2.jpg
3. /tags/0.1/screenshot-3.jpg


