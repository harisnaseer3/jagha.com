=== Infinite Scroll and Ajax Load More ===
Contributors: arpit-patel
Tags: infinite, infinite Scroll, infinite scrolling, load more, scroll
Requires at least: 3.5
Tested up to: 5.3
Stable tag: 3.8
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Infinite Scroll or Load more the post by the button click without paginations. 

== Description ==

Forgot the next page click and wait for the load list of the posts on the next page.

By using the Infinite scrolling you can list out all post on the same page by just scrolling the page down.

The another choice is you put the "Load More" button by using the shortcode, by click on the load more button some list of post are display on the same page.

This plugin use in the all the listing page of the blog like archive, category and author.

= Features =

Fully customizable to adapt to your site and theme.
Override the template loop file in your theme and you can change layout of the posts listing.
For the Infinite scrolling just install the plugin, make setting and just scroll.
You can change the loader image from the settings.
For the Infinite scrolling you can add the class names for the selector.
Also for the load more button you can change the button color and text.


== Installation ==

Easiest way:
1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Plugin Name screen to configure the plugin

== Frequently Asked Questions ==
 
= How to override the template loop file. =
For the override create the a folder "ajax-load-more".
Go to the "wp-content/plugins/infinite-scroll-ajax-load-more/templates" from here copy "content-loop.php" file and paste in your theme ajax-load-more folder.
Now you can make the change in the "content-loop.php" file located in theme.
 
= Where to put shortcode? =
Put the shortcode after the end of while loop and remove the pagination code. you can put this code in index.php, archive.php 
do_shortcode('[ajax-loadmore-button]');

== Screenshots ==

1. Infinite Scroll setting.
2. Infinite Scroll screen.
3. Infinite Scroll show more post screen.
4. Ajax Load more button screen.
5. Ajax Load more button show more post screen.


== Changelog ==

= 1.0 =
First version