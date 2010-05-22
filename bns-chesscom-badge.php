<?php
/*
Plugin Name: BNS Chess.com Badge
Plugin URI: http://buynowshop.com/plugins/bns-chesscom-badge
Description: Chess.com widget that dynamically displays the user's current rating with direct links to Chess.com
Version: 0.2
Author: Edward Caissie
Author URI: http://edwardcaissie.com/
License: GPL2
*/

/*  Copyright 2010  Edward Caissie  (email : edward.caissie@gmail.com)

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
*/

global $wp_version;
$exit_message = 'BNS Chess.com Badge requires WordPress version 2.8 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please Update!</a>';
if (version_compare($wp_version, "2.8", "<")) {
	exit ($exit_message);
}

/* Add BNS Chess.com Badge Style sheet */
add_action( 'wp_head', 'add_BNS_Chesscom_Badge_Header_Code' );

function add_BNS_Chesscom_Badge_Header_Code() {
  echo '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('url') . '/wp-content/plugins/bns-chesscom-badge/bns-chesscom-badge-style.css" />' . "\n";
}

/* Add function to the widgets_init hook. */
add_action( 'widgets_init', 'load_my_bns_chesscom_badge_widget' );

/* Function that registers our widget. */
function load_my_bns_chesscom_badge_widget() {
    register_widget( 'BNS_Chesscom_Badge_Widget' );
}

class BNS_Chesscom_Badge_Widget extends WP_Widget {

    function BNS_Chesscom_Badge_Widget() {
        /* Widget settings. */
        $widget_ops = array('classname' => 'bns-chesscom-badge', 'description' => __('Displays a Chess.com member badge.'));
        /* Widget control settings. */
	$control_ops = array('width' => 200, 'height' => 200, 'id_base' => 'bns-chesscom-badge');
	/* Create the widget. */
	$this->WP_Widget('bns-chesscom-badge', 'BNS Chess.com Badge', $widget_ops, $control_ops);
    }
    
    function widget( $args, $instance ) {
        
        extract( $args );
        /* User-selected settings. */
        $title = apply_filters('widget_title', $instance['title'] );
        $the_user = $instance['the_user'];
	$badge = $instance['badge'];
        
        /* Before widget (defined by themes). */
        echo $before_widget;
        /* Title of widget (before and after defined by themes). */
        if ( $title )
            echo $before_title . $title . $after_title;
            
        /* Display stuff based on widget settings. */
        $the_source = 'http://www.chess.com/api/get_user_info?username=';
        $user_source = $the_source . $the_user;
        $chess_user = file_get_contents($user_source);
        
        // Success+|<user_id>|<chess_title>|<username>|<online_status_image_url>|<country>|<country_image_url>|<last_login_date>|<best_rating>|<best_rating_type>|<games_in_progress_count>|<timeout_percent>|<is_friends>|<has_avatar>
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
            $avatar_url) = explode('|', $chess_user );
        ?>

	<?php /* Start badge choices */
	        switch ($badge) {
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
						<img src="http://cssjs.chesscomfiles.com/images/chesscom_logo.gif" border="0" />
					    </a>
					    <a href="http://www.chess.com?ref_id=<?php echo $user_id; ?>" rel="nofollow" style="font-size: 9px;"></a>
					</div>
					<div style="text-align: center; margin: 2px; color: #ffe; font-size: 9px;">
					    <strong>I <a href="http://www.chess.com" style="color: #ffc; text-decoration: none; font-size: 9px;">play chess</a> at Chess.com!</strong>
					</div>
					<div style="margin: 4px; background-color: #fff; padding: 6px; border: 1px solid #9ac567;"> <a href="http://www.chess.com/members/view/Cais?ref_id=<?php echo $user_id; ?>" rel="nofollow"><img src="<?php echo $avatar_url; ?>" width="30" height="30" style="float: left; margin: 0 4px 4px 0; border: 1px solid #666;" /></a><a href="http://www.chess.com/members/view/<?php echo $username; ?>?ref_id=<?php echo $user_id; ?>" rel="nofollow"><strong><?php echo $username; ?></strong></a><br />Rating: <strong><?php echo $best_rating; ?></strong><br /><br />
					    <div style="text-align:center; margin: 8px;">
						<a href="http://www.chess.com/echess/create_game.html?uid=<?php echo $user_id; ?>&ref_id=<?php echo $user_id; ?>" style="border-top: 2px solid #f7b15b; border-left: 2px solid #f7b15b; border-right: 2px solid #db8213; border-bottom: 2px solid #db8213; background-color: #ff9c21; color: #ffc; padding: 1px 2px; text-decoration: none; font-weight: bold; font-size: 14px;" rel="nofollow">Challenge me!</a>
					    </div>
					    <div style="text-align:center;">
						<a href="http://www.chess.com/home/game_archive.html?member=<?php echo $username; ?>&ref_id=<?php echo $user_id; ?>" rel="nofollow">View my games</a>
					    </div>
					</div>
				    </div>
				</div>
			<?php
		}
	/* End badge choices */ ?>
        
        <?php
        
        /* After widget (defined by themes). */
        echo $after_widget;
    }
    
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
      
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title']      = strip_tags( $new_instance['title'] );
        $instance['the_user']   = strip_tags( $new_instance['the_user'] );
	$instance['badge']	= $new_instance['badge'];
        
        return $instance;
    }
    
    function form( $instance ) {
        /* Set default widget settings. */
        $defaults = array(
            'title'     => __('Chess.com'),
            'the_user'  => '',
	    'badge'	=> 'default',
            );
        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
        <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>
        <p>
		<label for="<?php echo $this->get_field_id( 'the_user' ); ?>"><?php _e('Enter your Chess.com user name:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'the_user' ); ?>" name="<?php echo $this->get_field_name( 'the_user' ); ?>" value="<?php echo $instance['the_user']; ?>" style="width:100%;" />
        </p>
	<p>
		<label for="<?php echo $this->get_field_id( 'badge' ); ?>"><?php _e('Choose Badge Size:'); ?></label> 
		<select id="<?php echo $this->get_field_id( 'badge' ); ?>" name="<?php echo $this->get_field_name( 'badge' ); ?>" class="widefat">
			<option <?php if ( 'Default' == $instance['badge'] ) echo 'selected="selected"'; ?>>Default</option>
			<option <?php if ( '125x125' == $instance['badge'] ) echo 'selected="selected"'; ?>>125x125</option>
			<option <?php if ( '200x50' == $instance['badge'] ) echo 'selected="selected"'; ?>>200x50</option>
			<option <?php if ( '100x30' == $instance['badge'] ) echo 'selected="selected"'; ?>>100x30</option>
			<option <?php if ( '120x60' == $instance['badge'] ) echo 'selected="selected"'; ?>>120x60</option>
			<option <?php if ( '468x60' == $instance['badge'] ) echo 'selected="selected"'; ?>>468x60</option>
			<option <?php if ( '250x250' == $instance['badge'] ) echo 'selected="selected"'; ?>>250x250</option>
			<option <?php if ( '200x200' == $instance['badge'] ) echo 'selected="selected"'; ?>>200x200</option>
		</select>
	</p>
        <?php
    }
}
/* May 22, 2010 */ ?>