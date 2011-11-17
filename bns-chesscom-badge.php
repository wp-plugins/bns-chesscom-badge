<?php
/*
Plugin Name: BNS Chess.com Badge
Plugin URI: http://buynowshop.com/plugins/bns-chesscom-badge
Description: Chess.com widget that dynamically displays the user's current rating with direct links to Chess.com
Version: 0.4
Author: Edward Caissie
Author URI: http://edwardcaissie.com/
License: GNU General Public License v2
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

/**
 * BNS Chess.com Badge
 *
 * Chess.com widget that dynamically displays the user's current rating with
 * direct links to Chess.com
 *
 * @package     BNS_Chesscom_Badge
 * @link        http://buynowshop.com/plugins/bns-chesscom-badge/
 * @link        https://github.com/Cais/bns-chesscom-badge/
 * @link        http://wordpress.org/extend/plugins/bns-chesscom-badge/
 * @version     0.4
 * @author      Edward Caissie <edward.caissie@gmail.com>
 * @copyright   Copyright (c) 2010-2011, Edward Caissie
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 2, as published by the
 * Free Software Foundation.
 *
 * You may NOT assume that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to:
 *
 *      Free Software Foundation, Inc.
 *      51 Franklin St, Fifth Floor
 *      Boston, MA  02110-1301  USA
 *
 * The license for this software can also likely be found here:
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Last revised November 16, 2011
 */

/**
 * Check installed WordPress version for compatibility
 *
 * @package     BNS_Chesscom_Badge
 * @since       0.1
 * @version     0.4
 * @internal    Version 2.8 being used in reference to `register_widget`
 *
 * Last revised November 16, 2011.
 * @todo    Check version compatibility after other updates are completed
 * @todo    Re-write to be i18n compatible
 */
global $wp_version;
$exit_message = 'BNS Chess.com Badge requires WordPress version 2.8 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please Update!</a>';
if ( version_compare( $wp_version, "2.8", "<" ) ) {
    exit ( $exit_message );
}

/**
 * BNS Chess.com Badge TextDomain
 * Make plugin text available for translation (i18n)
 *
 * @package:    BNS_Chesscom_Badge
 * @since:      0.4
 *
 * @internal    Note: Translation files are expected to be found in the plugin root folder / directory.
 * @internal    `bns-cb` is being used in place of `bns-chesscom-badge`
 */
load_plugin_textdomain( 'bns-cb' );
// End: BNS Chess.com Badge TextDomain

/**
 * Enqueue Plugin Scripts and Styles
 *
 * Adds plugin stylesheet and allows for custom stylesheet to be added by end-user.
 *
 * @package BNS_Chesscom_Badge
 * @since   0.3
 * @version 0.4
 *
 * Last revised November 16, 2011
 * @todo    Look at using the plugin version data for the version number in `wp_enqueue_style` rather than hard-coding a number
 */
function BNS_Chesscom_Scripts_and_Styles() {
        /* Scripts */
        /* Styles */
        wp_enqueue_style( 'BNS-Chesscom-Badge-Style', plugin_dir_url( __FILE__ ) . '/bns-chesscom-badge-style.css', array(), '0.4', 'screen' );
        if ( is_readable( plugin_dir_path( __FILE__ ) . 'bns-chesscom-badge-custom-style.css' ) ) { // Only enqueue if available
            wp_enqueue_style( 'BNS-Chesscom-Badge-Custom-Style', plugin_dir_url( __FILE__ ) . 'bns-chesscom-badge-custom-style.css', array(), '0.4', 'screen' );
        }
}
add_action( 'wp_enqueue_scripts', 'BNS_Chesscom_Scripts_and_Styles' );

/** Register widget */
function load_bnscb_widget() {
        register_widget( 'BNS_Chesscom_Badge_Widget' );
}
add_action( 'widgets_init', 'load_bnscb_widget' );

class BNS_Chesscom_Badge_Widget extends WP_Widget {
        function BNS_Chesscom_Badge_Widget() {
                /** Widget settings */
                $widget_ops = array('classname' => 'bns-chesscom-badge', 'description' => __( 'Displays a Chess.com member badge in a widget area; or, with a shortcode.', 'bns-cb' ) );
                /** Widget control settings */
                $control_ops = array('width' => 200, 'id_base' => 'bns-chesscom-badge');
                /** Create the widget */
                $this->WP_Widget('bns-chesscom-badge', 'BNS Chess.com Badge', $widget_ops, $control_ops);
        }

        function widget( $args, $instance ) {
                extract( $args );
                /** User-selected settings */
                $title = apply_filters( 'widget_title', $instance['title'] );
                $the_user = $instance['the_user'];
                $badge = $instance['badge'];

                /** @var    $before_widget  string - defined by theme */
                echo $before_widget;
                /** Widget $title, $before_widget, and $after_widget defined by theme */
                if ( $title )
                    /**
                     * @var $before_title   string - defined by theme
                     * @var $after_title    string - defined by theme
                     */
                    echo $before_title . $title . $after_title;

                /** @var $the_source - base URL of API to access user details */
                $the_source = 'http://www.chess.com/api/get_user_info?username=';
                /** @var $user_source - full API URL of user details */
                $user_source = $the_source . $the_user;
                /** @var $chess_user - holds data to be parsed for use by the plugin */
                $chess_user = file_get_contents( $user_source );

                /**
                 * @internal Contents of $chess_user: Success+|<user_id>|<chess_title>|<username>|<online_status_image_url>|<country>|<country_image_url>|<last_login_date>|<best_rating>|<best_rating_type>|<games_in_progress_count>|<timeout_percent>|<is_friends>|<has_avatar>
                 */
                list(
                        $success,
                        $user_id,
                        $chess_title,
                        $username,
                        $online_status_image_url,
                        $country,
                        $country_image_url,
                        $last_login_date,
                        $best_rating,
                        $best_rating_type,
                        $game_in_progress_count,
                        $timeout_percent,
                        $is_friends,
                        $has_avatar,
                        $avatar_url ) = explode( '|', $chess_user );

                /** Start badge choices */
                switch ( $badge ) {
                    case "125x125": ?>
                        <a href="http://www.chess.com?ref_id=<?php echo $user_id; ?>">
                            <img class="center" src="http://cssjs.chesscomfiles.com/images/badges/chesscom_badge_favorite_125x125.gif" alt="" width="125" height="125" />
                        </a>
                        <?php break;
                    case "200x50": ?>
                        <a href="http://www.chess.com?ref_id=<?php echo $user_id; ?>">
                            <img class="center" src="http://cssjs.chesscomfiles.com/images/badges/chesscom_badge_favorite_200x50.gif" alt="" width="200" height="50" />
                        </a>
                        <?php break;
                    case "100x30": ?>
                        <a href="http://www.chess.com?ref_id=<?php echo $user_id; ?>">
                            <img class="center" src="http://cssjs.chesscomfiles.com/images/badges/chesscom_badge_favorite_100x30.gif" alt="" width="100" height="30" />
                        </a>
                        <?php break;
                    case "120x60": ?>
                        <a href="http://www.chess.com?ref_id=<?php echo $user_id; ?>">
                            <img class="center" src="http://cssjs.chesscomfiles.com/images/badges/chesscom_badge_favorite_120x60.gif" alt="" width="120" height="60" />
                        </a>
                        <?php break;
                    case "468x60": ?>
                        <a href="http://www.chess.com?ref_id=<?php echo $user_id; ?>">
                            <img class="center" src="http://cssjs.chesscomfiles.com/images/badges/chesscom_badge_468x60_s.gif" alt="" width="468" height="60" />
                        </a>
                        <?php break;
                    case "250x250": ?>
                        <a href="http://www.chess.com?ref_id=<?php echo $user_id; ?>">
                            <img class="center" src="http://cssjs.chesscomfiles.com/images/badges/chesscom_badge_250x250_d.gif" alt="" width="250" height="250" />
                        </a>
                        <?php break;
                    case "200x200": ?>
                        <a href="http://www.chess.com?ref_id=<?php echo $user_id; ?>">
                            <img class="center" src="http://cssjs.chesscomfiles.com/images/badges/chesscom_badge_200x200_d.gif" alt="" width="200" height="200" />
                        </a>
                        <?php break;
                    case "Default":
                        default: ?>
                            <div style="border: 1px solid #000; width: 170px; overflow: hidden; font-family: Verdana, Arial, sans-serif; margin: 4px auto;">
                                <div style="border-top: 2px solid #9ac567; border-left: 2px solid #9ac567; border-right: 2px solid #224d00; border-bottom: 2px solid #224d00; background-color: #4a7521; font-size: 12px;">
                                    <div style="margin: 4px; background-color: #fff; padding: 4px; text-align: center; border: 1px solid #9ac567;">
                                        <a href="http://www.chess.com?ref_id=<?php echo $user_id; ?>" rel="nofollow" style="font-size: 9px;">
                                            <img src="http://cssjs.chesscomfiles.com/images/chesscom_logo.gif" alt="" border="0" />
                                        </a>
                                        <a href="http://www.chess.com?ref_id=<?php echo $user_id; ?>" rel="nofollow" style="font-size: 9px;"></a>
                                    </div>
                                    <div style="text-align: center; margin: 2px; color: #ffe; font-size: 9px;">
                                        <strong>I <a href="http://www.chess.com" style="color: #ffc; text-decoration: none; font-size: 9px;">play chess</a> at Chess.com!</strong>
                                    </div>
                                    <div style="margin: 4px; background-color: #fff; padding: 6px; border: 1px solid #9ac567;"> <a href="http://www.chess.com/members/view/Cais?ref_id=<?php echo $user_id; ?>" rel="nofollow"><img src="<?php echo $avatar_url; ?>" width="30" height="30" alt="" style="float: left; margin: 0 4px 4px 0; border: 1px solid #666;" /></a><a href="http://www.chess.com/members/view/<?php echo $username; ?>?ref_id=<?php echo $user_id; ?>" rel="nofollow"><strong><?php echo $username; ?></strong></a><br />Rating: <strong><?php echo $best_rating; ?></strong><br /><br />
                                        <div style="text-align:center; margin: 8px;">
                                            <a href="http://www.chess.com/echess/create_game.html?uid=<?php echo $user_id; ?>&ref_id=<?php echo $user_id; ?>" style="border: 2px solid #f7b15b; border-right-color: #db8213; border-bottom-color: #db8213; background-color: #ff9c21; color: #ffc; padding: 1px 2px; text-decoration: none; font-weight: bold; font-size: 14px;" rel="nofollow">Challenge me!</a>
                                        </div>
                                        <div style="text-align:center;">
                                            <a href="http://www.chess.com/home/game_archive.html?member=<?php echo $username; ?>&ref_id=<?php echo $user_id; ?>" rel="nofollow">View my games</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php }
                // End badge choices

                /** @var    $after_widget   string - defined by theme */
                echo $after_widget;
        }

        function update( $new_instance, $old_instance ) {
                $instance = $old_instance;
                /** Strip tags (if needed) and update the widget settings */
                $instance['title']      = strip_tags( $new_instance['title'] );
                $instance['the_user']   = strip_tags( $new_instance['the_user'] );
                $instance['badge']      = $new_instance['badge'];
                return $instance;
        }

        function form( $instance ) {
                /** Set default widget settings */
                $defaults = array(
                                'title'     => __( 'Chess.com', 'bns-cb' ),
                                'the_user'  => '',
                                'badge'     => 'default',
                            );
                $instance = wp_parse_args( (array) $instance, $defaults );
                ?>

                <p>
                    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'bns-cb' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id( 'the_user' ); ?>"><?php _e( 'Enter your Chess.com user name:', 'bns-cb' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'the_user' ); ?>" name="<?php echo $this->get_field_name( 'the_user' ); ?>" value="<?php echo $instance['the_user']; ?>" style="width:100%;" />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id( 'badge' ); ?>"><?php _e( 'Choose Badge Size:', 'bns-cb' ); ?></label>
                    <select id="<?php echo $this->get_field_id( 'badge' ); ?>" name="<?php echo $this->get_field_name( 'badge' ); ?>" class="widefat">
                        <option <?php selected( 'Default', $instance['badge'], true ); ?>>Default</option>
                        <option <?php selected( '125x125', $instance['badge'], true ); ?>>125x125</option>
                        <option <?php selected( '200x50', $instance['badge'], true ); ?>>200x50</option>
                        <option <?php selected( '100x30', $instance['badge'], true ); ?>>100x30</option>
                        <option <?php selected( '120x60', $instance['badge'], true ); ?>>120x60</option>
                        <option <?php selected( '468x60', $instance['badge'], true ); ?>>468x60</option>
                        <option <?php selected( '250x250', $instance['badge'], true ); ?>>250x250</option>
                        <option <?php selected( '200x200', $instance['badge'], true ); ?>>200x200</option>
                    </select>
                </p>
        <?php }
} // End class BNS_Chesscom_Badge_Widget

/**
 * BNS Chess.com Badge Shortcode Start
 * - May the Gods of programming protect us all!
 *
 * @param $atts
 *
 * @return ob_get_contents
 */
function bns_chess_shortcode( $atts ) {
        /** Get ready to capture the elusive widget output */
        ob_start();
        the_widget( 'BNS_Chesscom_Badge_Widget',
                    $instance = shortcode_atts( array(
                                                     'title'     => __( '', 'bns-cb' ),
                                                     'the_user'  => '',
                                                     'badge'     => 'default'
                                                ), $atts),
                    $args = array(
                            /** clear variables defined by theme for widgets */
                            $before_widget = '',
                            $after_widget = '',
                            $before_title = '',
                            $after_title = '',
                    )
        );
        /** Get the_widget output and put into its own container */
        $bns_chess_content = ob_get_contents();
        ob_end_clean();
        // All your snipes belong to us!
    
        return $bns_chess_content;
}
add_shortcode( 'bns_chess', 'bns_chess_shortcode' );
// BNS Chess.com Badge Shortcode End - Say your prayers ...
?>