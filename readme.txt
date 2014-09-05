=== BNS Chess.com Badge ===
Contributors: cais
Donate link: http://buynowshop.com
Tags: Chess.com, dynamic ratings, shortcode, widget-only
Requires at least: 2.8
Tested up to: 4.0
Stable tag: 0.6.3
License: GNU General Public License v2
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html

Dynamically displays a Chess.com user's current rating.

== Description ==

Chess.com "badge" that dynamically displays, in a widget area or with a shortcode, the user's current rating with direct links to Chess.com

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `bns-chesscom-badge.php` to the `/wp-content/plugins/` directory
2. Activate through the 'Plugins' menu.
3. Read http://wpfirstaid.com/2009/12/plugin-installation/

-- or -

1. Go to 'Plugins' menu under your Dashboard
2. Click on the 'Add New' link
3. Search for bns-chesscom-badge
4. Install.
5. Activate through the 'Plugins' menu.
6. Read http://wpfirstaid.com/2009/12/plugin-installation/

= Shortcode: bns_chess =
Parameters are very similar to the plugin:

*   'title'     => __( '' )
*   'the_user'  => ''
*   'badge'     => 'default'

Current badge sizes: 125x125, 200x50, 100x30, 120x60, 468x60, 250x250, 200x200, and the default.

NB: Use the shortcode at your own risk!

== Frequently Asked Questions ==
= How can I get support for this plugin? =

Please note, support may be available on the WordPress Support forums; but, it may be faster to visit http://buynowshop.com/plugins/bns-chesscom-badge/ and leave a comment with the issue you are experiencing.

= Do I have to do anything besides enter my user name? =

No. The plugin will retrieve all the necessary details based on the user name entered.

== Screenshots ==

1. The option panel.

== Other Notes ==
* Copyright 2010-2014  Edward Caissie  (email : edward.caissie@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License version 2,
  as published by the Free Software Foundation.

  You may NOT assume that you can use any other version of the GPL.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

  The license for this software can also likely be found here:
  http://www.gnu.org/licenses/gpl-2.0.html

== Upgrade Notice ==
* Please stay current with your WordPress installation, your active theme, and your plugins.

== Changelog ==
= 0.6.3 =
* Released May 2014
* Update compatibility version
* Update copyright years

= 0.6.2 =
* Released September 2013
* Added third parameter to `shortcode_atts` for automatic filter creation

= 0.6.1 =
* Release May 2013
* Version number compatibility updates

= 0.6 =
* Release February 2013
* Refactor code into class structure
* Added sanity check if user name is present

= 0.5 =
* Release November 2012
* Added conditional check to displaying online statuses or not
* Added CSS wrappers and styles for online status text
* Removed load_plugin_textdomain as redundant

= 0.4.2 =
* documentation updates
* added license reference to 'readme.txt'
* programmatically add version number to enqueue calls

= 0.4.1 =
* confirmed compatible with WordPress 3.4
* inline css optimizations

= 0.4 =
* released November 2011
* confirmed compatible with WordPress 3.3
* added phpDoc Style documentation
* added i18n support
* added conditional enqueue of `bns-chesscom-badge-custom-style.css` stylesheet

= 0.3 =
* released June 2011
* confirm compatible with WordPress version 3.2-beta2-18085
* enqueue style sheet
* note minimum required version as 2.8 for the use of `register_widget` et al.
* added shortcode functionality

= 0.2.1 =
* released December 11, 2010
* Confirmed compatible with WordPress 3.1 (beta)

= 0.2 =
* Release date: May 22, 2010
* Added options for all current (as of May 22, 2010) badge sizes available from Chess.com

= 0.1 =
* Initial release.