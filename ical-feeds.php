<?php
/*
Plugin Name: iCal Feeds
Plugin URI: http://maxime.sh/ical-feeds
Description: Generate a customizable iCal feed of your present and future blog posts.
Author: Maxime VALETTE
Author URI: http://maxime.sh
Version: 1.5
*/

define('ICALFEEDS_TEXTDOMAIN', 'icalfeeds');
define('ICALFEEDS_SLUG', 'icalfeeds');

if (function_exists('load_plugin_textdomain')) {
	load_plugin_textdomain(ICALFEEDS_TEXTDOMAIN, false, dirname(plugin_basename(__FILE__)).'/languages' );
}

add_action('admin_menu', 'icalfeeds_config_page');

function icalfeeds_config_page() {

	if (function_exists('add_submenu_page')) {

        add_submenu_page('options-general.php',
            __('iCal Feeds', ICALFEEDS_TEXTDOMAIN),
            __('iCal Feeds', ICALFEEDS_TEXTDOMAIN),
            'manage_options', ICALFEEDS_SLUG, 'icalfeeds_conf');

    }

}

function icalfeeds_conf() {

	$options = get_option('icalfeeds');

	if (!isset($options['icalfeeds_minutes'])) $options['icalfeeds_minutes'] = 60;
	if (!isset($options['icalfeeds_start_hours'])) $options['icalfeeds_start_hours'] = 0;
    	if (!isset($options['icalfeeds_start_minutes'])) $options['icalfeeds_start_minutes'] = 0;
	if (!isset($options['icalfeeds_secret'])) $options['icalfeeds_secret'] = 'changeme';
	if (!isset($options['icalfeeds_senable'])) $options['icalfeeds_senable'] = 0;
	if (!isset($options['icalfeeds_limit'])) $options['icalfeeds_limit'] = 50;
	if (!isset($options['icalfeeds_future'])) $options['icalfeeds_future'] = 0;

	$updated = false;

	if (isset($_POST['submit'])) {

		check_admin_referer('icalfeeds', 'icalfeeds-admin');

        if (isset($_POST['icalfeeds_minutes'])) {
            $icalfeeds_minutes = (int) $_POST['icalfeeds_minutes'];
        } else {
            $icalfeeds_minutes = 60;
        }
		
	if (isset($_POST['icalfeeds_start_hours'])) {
            $icalfeeds_start_hours = (int) $_POST['icalfeeds_start_hours'];
        } else {
            $icalfeeds_start_hours = 0;
        }
 
        if (isset($_POST['icalfeeds_start_minutes'])) {
            $icalfeeds_start_minutes = (int) $_POST['icalfeeds_start_minutes'];
        } else {
            $icalfeeds_start_minutes = 0;
        }

        if (isset($_POST['icalfeeds_secret'])) {
            $icalfeeds_secret = $_POST['icalfeeds_secret'];
        } else {
            $icalfeeds_secret = 'changeme';
        }

        if (isset($_POST['icalfeeds_senable'])) {
            $icalfeeds_senable = $_POST['icalfeeds_senable'];
        } else {
            $icalfeeds_senable = 0;
        }

        if (isset($_POST['icalfeeds_limit'])) {
            $icalfeeds_limit = $_POST['icalfeeds_limit'];
        } else {
            $icalfeeds_limit = 50;
        }
        
        if (isset($_POST['icalfeeds_future'])) {
            $icalfeeds_future = $_POST['icalfeeds_future'];
        } else {
            $icalfeeds_future = 0;
        }

		$options['icalfeeds_minutes'] = $icalfeeds_minutes;
		$options['icalfeeds_start_hours'] = $icalfeeds_start_hours;
        	$options['icalfeeds_start_minutes'] = $icalfeeds_start_minutes;
		$options['icalfeeds_secret']  = $icalfeeds_secret;
		$options['icalfeeds_senable'] = $icalfeeds_senable;
		$options['icalfeeds_limit']   = $icalfeeds_limit;
		$options['icalfeeds_future']  = $icalfeeds_future;

		update_option('icalfeeds', $options);

		$updated = true;

	}

    echo '<div class="wrap">';

    if ($updated) {

        echo '<div id="message" class="updated fade"><p>';
        _e('Configuration updated.', ICALFEEDS_TEXTDOMAIN);
        echo '</p></div>';

    }

    $timezone = get_option('timezone_string');

    if (empty($timezone)) {

        echo '<div id="message" class="error"><p>';
        _e('You have to define your current timezone (specify a city) in', ICALFEEDS_TEXTDOMAIN);
        echo ' <a href="options-general.php">'.__('Settings > General', ICALFEEDS_TEXTDOMAIN).'</a>';
        echo ".</p></div>";

    }

    echo '<h2>'.__('iCal Feeds Configuration', ICALFEEDS_TEXTDOMAIN).'</h2>';

    echo '<p>'.__('', ICALFEEDS_TEXTDOMAIN).'</p>';

    echo '<form action="'.admin_url('options-general.php?page=' . ICALFEEDS_SLUG).'" method="post" id="feeds-conf">';

    echo '<h3>'.__('Advanced Options', ICALFEEDS_TEXTDOMAIN).'</h3>';

    echo '<p><input id="icalfeeds_senable" name="icalfeeds_senable" type="checkbox" value="1"';
    if ($options['icalfeeds_senable'] == 1) echo ' checked';
    echo '/> <label for="icalfeeds_senable">'.__('Enable a secret parameter to view ALL future posts.', ICALFEEDS_TEXTDOMAIN).'</label></p>';

    echo '<h3><label for="icalfeeds_secret">'.__('Secret parameter value:', ICALFEEDS_TEXTDOMAIN).'</label></h3>';
    echo '<p><input type="text" id="icalfeeds_secret" name="icalfeeds_secret" value="'.$options['icalfeeds_secret'].'" style="width: 200px;" /></p>';

    echo '<h3><label for="icalfeeds_minutes">'.__('Time interval per post:', ICALFEEDS_TEXTDOMAIN).'</label></h3>';
    echo '<p><input type="number" id="icalfeeds_minutes" name="icalfeeds_minutes" value="'.$options['icalfeeds_minutes'].'" style="width: 50px; text-align: center;" /> '.__('minutes', ICALFEEDS_TEXTDOMAIN).'</p>';
	
    echo '<h3><label for="icalfeeds_minutes">'.__('Start Time per post:', ICALFEEDS_TEXTDOMAIN).'</label></h3>';
    echo '<p><input type="number" id="icalfeeds_start_hours" name="icalfeeds_start_hours" value="'.$options['icalfeeds_start_hours'].'" style="width: 50px; text-align: center;" min="0" max="23" /> : <input type="number" id="icalfeeds_start_minutes" name="icalfeeds_start_minutes" value="'.$options['icalfeeds_start_minutes'].'" style="width: 50px; text-align: center;" min="0" max="59" /> '.__('24-hour military time', ICALFEEDS_TEXTDOMAIN).'</p>';
    echo '<p><i>leave 0:0 to use time defined by publish date or custom date field.</i></p>';

    echo '<h3><label for="icalfeeds_limit">'.__('Number of blog posts:', ICALFEEDS_TEXTDOMAIN).'</label></h3>';
    echo '<p><input type="number" id="icalfeeds_limit" name="icalfeeds_limit" value="'.$options['icalfeeds_limit'].'" style="width: 50px; text-align: center;" /> '.__('blog posts', ICALFEEDS_TEXTDOMAIN).'</p>';

	echo '<h3><label for="icalfeeds_future">'.__('Number of future posts:', ICALFEEDS_TEXTDOMAIN).'</label></h3>';
    echo '<p><input type="number" id="icalfeeds_future" name="icalfeeds_future" value="'.$options['icalfeeds_future'].'" style="width: 50px; text-align: center;" /> '.__('future posts', ICALFEEDS_TEXTDOMAIN).'</p>';
    
    echo '<p class="submit" style="text-align: left">';
    wp_nonce_field('icalfeeds', 'icalfeeds-admin');
    echo '<input type="submit" name="submit" value="'.__('Save', ICALFEEDS_TEXTDOMAIN).' &raquo;" /></p></form>';

    echo '<h2>'.__('Main iCal feeds', ICALFEEDS_TEXTDOMAIN).'</h2>';

    echo '<p>'.__('You can use the below addresses to add in your iCal software:', ICALFEEDS_TEXTDOMAIN).'</p>';

    echo '<ul>';

    echo '<li><a href="'.site_url().'/?ical" target="_blank">'.site_url().'/?ical</a> — '.__('Public iCal feed', ICALFEEDS_TEXTDOMAIN).'</li>';

    if ($options['icalfeeds_senable'] == '1') {
        echo '<li><a href="'.site_url().'/?ical='.$options['icalfeeds_secret'].'" target="_blank">'.site_url().'/?ical='.$options['icalfeeds_secret'].'</a> — '.__('Private iCal feed', ICALFEEDS_TEXTDOMAIN).'</li>';
    }

    echo '</ul>';

    echo '<h2>'.__('Categories iCal feeds', ICALFEEDS_TEXTDOMAIN).'</h2>';

    echo '<ul>';

    $categories = get_categories();

    foreach ($categories as $category) {

        echo '<li><a href="'.site_url().'/?ical&amp;category='.$category->category_nicename.'" target="_blank">'.site_url().'/?ical&amp;category='.$category->category_nicename.'</a> — '.__('Public iCal feed for', ICALFEEDS_TEXTDOMAIN).' '.$category->cat_name.'</li>';

    }

	echo '</ul>';

	echo '<h2>'.__('Multiple categories iCal feeds', ICALFEEDS_TEXTDOMAIN).'</h2>';

	echo '<p>'.__('You can add multiple categories in only one URL. Just check the categories you want below:', ICALFEEDS_TEXTDOMAIN).'</p>';

	echo '<ul id="categoriesList">';

	foreach ($categories as $category) {

		echo '<li><input type="checkbox" id="' . $category->category_nicename . '"> <label for="' . $category->category_nicename . '">' . $category->cat_name . '</label>';

	}

	echo '</ul>';

	echo '<p id="categoriesUrl" style="display: none;">'.__('URL:', ICALFEEDS_TEXTDOMAIN).' <a href="'.site_url().'/?ical&amp;category=" data-baseUrl="'.site_url().'/?ical&amp;category=" target="_blank">'.site_url().'/?ical&amp;category=</a></p>';

	$args = array(
		'public'   => true,
		'_builtin' => false
	);

	$post_types = get_post_types($args);

	if (count($post_types)) {

		echo '<h2>'.__('Post Type iCal feeds', ICALFEEDS_TEXTDOMAIN).'</h2>';

		echo '<ul>';

		foreach ($post_types as $post_type) {

			echo '<li><a href="'.site_url().'/?ical&amp;posttype='.$post_type.'" target="_blank">'.site_url().'/?ical&amp;posttype='.$post_type.'</a> — '.__('Public iCal feed for', ICALFEEDS_TEXTDOMAIN).' '.$post_type.'</li>';

		}

	}

	echo '</ul>';

	echo '<h2>'.__('Custom Date iCal feed', ICALFEEDS_TEXTDOMAIN).'</h2>';

	echo '<p>'.__('You can use a custom date field instead of the default publish date. The Meta Key must exist in the Post Meta table.', ICALFEEDS_TEXTDOMAIN).'</p>';

	echo '<p>Example Date meta_key: "event_date"  <a href="'.site_url().'/?ical&datefield=event_date" target="_blank">'.site_url().'/?ical&datefield=event_date</a></p>';

	echo '<p>'.__('You can also use a custom end date field width enddatefield.', ICALFEEDS_TEXTDOMAIN).'</p>';

    echo '</div>';
    
    echo '<hr/>';
    
    echo '<p>You can let people know about your new iCal service by submitting it to the <a href="http://icalshare.com/?partner=ical-feeds-for-wordpress" rel="noopener" target="_blank">iCalShare.com directory</a>.';


	echo <<<HTML
<script>
jQuery(document).ready(function() {
	jQuery('#categoriesList li input').bind('change', function() {
		var url = jQuery('#categoriesUrl a').attr('data-baseUrl');
		var i = 0;
		jQuery('#categoriesList li input:checked').each(function() {
			if (i > 0) {
				url += ',';
			}
			url += jQuery(this).attr('id');
			i++;
		});
		if (i == 0) {
			jQuery('#categoriesUrl').hide();
		} else {
			jQuery('#categoriesUrl a').attr('href', url).html(url);
			jQuery('#categoriesUrl').show();
		}
	});
});
</script>
HTML;

}

function icalfeeds_feed() {

    global $wpdb;

	//Set defaults if no values exist
    $options = get_option('icalfeeds');
    if (!isset($options['icalfeeds_minutes'])) $options['icalfeeds_minutes'] = 60;
    if (!isset($options['icalfeeds_start_hours'])) $options['icalfeeds_start_hours'] = 0;
    if (!isset($options['icalfeeds_start_minutes'])) $options['icalfeeds_start_minutes'] = 0;
    if (!isset($options['icalfeeds_limit'])) $options['icalfeeds_limit'] = 50;
    if (!isset($options['icalfeeds_future'])) $options['icalfeeds_future'] = 0;


	//Get Post Type
	$post_type = 'post';
	if (isset($_GET['posttype'])) {
		$post_type = $_GET['posttype'];
	}

	//Set how many future posts to display
	$post_status = array( 'publish', 'future' );
	if ($_REQUEST['ical'] == $options['icalfeeds_secret']) {
	
		$future = date('Ymd', strtotime('+3650 day')); //10 years out
		
	} else {
		
		$future = date('Ymd', strtotime('+'.$options['icalfeeds_future'].' day'));
		
	}
	
	// Is a custom meta_key field being used for date
	if (isset($_GET['datefield'])) {
	
		$post_date_field = $_GET['datefield'];
		$post_order_by = array( 'meta_key' => $_GET['datefield'], 'meta_value'   => $future, 'meta_compare' => '<=', 'orderby' => 'meta_value' );
		
	} else {
	
		$post_date_field = 'pubDate';
		$post_order_by = array( 'before' => $future,'orderby' => 'post_date' );
	
	}
	
	//Custom End Date field
	if (isset($_GET['enddatefield'])) {
		$post_end_date_field = $_GET['enddatefield'];
	} else {
		$post_end_date_field = null;
	}

	// Get category IDs
    if (isset($_GET['category'])) {

        $categories = get_categories();
        $categoryIds = array(0);
		$niceNames = explode(',', $_GET['category']);

        foreach ($categories as $category) {

            if (in_array($category->category_nicename, $niceNames)) {

	            $categoryIds[] = $category->cat_ID;

            }

        }

    }

	// Set limit on posts retrieved
    $limit = $options['icalfeeds_limit'];
    if (isset($_GET['limit']) && is_numeric($_GET['limit'])) {
        $limit = $_GET['limit'];
    }


    // Construct query arguement
	if (isset($_GET['category'])) {

		$args = array(
			'post_type' 		=> $post_type,
			'post_status' 		=> $post_status,
			'posts_per_page'    => $limit,
			'cat' => implode(',', $categoryIds),
			'order'				=> 'DESC',
		) + $post_order_by;
		
		
	} else {

		$args = array(
			'post_type' 		=> $post_type,
			'post_status' 		=> $post_status,
			'posts_per_page'    => $limit,
			'order'				=> 'DESC',
		) + $post_order_by;

	}

	// Get posts
	$posts = new WP_Query( $args );
	
    $events = null;

    while ( $posts->have_posts() ) {
    	$posts->the_post();

	    if ($post_date_field !== 'pubDate') {
	    	
		    $start_time = date( 'Ymd\THis', strtotime( get_post_meta( get_the_ID(), $post_date_field, true ) ) - ( get_option( 'gmt_offset' ) * 3600 ) );
		    $end_time = date( 'Ymd\THis', strtotime( get_post_meta( get_the_ID(), $post_date_field, true ) ) - ( get_option( 'gmt_offset' ) * 3600 ) + ($options['icalfeeds_minutes'] * 60));
		    $modified_time = date( 'Ymd\THis', strtotime( get_post_meta( get_the_ID(), $post_date_field, true ) ) - ( get_option( 'gmt_offset' ) * 3600 ) );
		    
	    } else {

		    $start_time = date( 'Ymd\THis', get_post_time( 'U', true, get_the_ID() ) );
		    $end_time = date( 'Ymd\THis', get_post_time( 'U', true, get_the_ID() ) + ($options['icalfeeds_minutes'] * 60));
		    $modified_time = date( 'Ymd\THis', get_post_modified_time( 'U', true, get_the_ID() ) );
		   
	    }

        //$modified_time = date( 'Ymd\THis', get_post_modified_time( 'U', true, $post->ID ) );
        $summary = strip_tags( html_entity_decode( get_the_title() ) );
        $permalink = get_permalink(get_the_ID());
        $timezone = get_option('timezone_string');
        $guid = urlencode( get_the_guid(get_the_ID()) );
	$organizer = get_bloginfo( 'name' );
        
	    
	//Set Static Start & End Time
        if( $options['icalfeeds_start_hours'] > 0 || $options['icalfeeds_start_minutes'] > 0) {
            $start_time = date( 'Ymd\THis', strtotime( substr($start_time, 0, 8) .' '. $options['icalfeeds_start_hours'] .':'. $options['icalfeeds_start_minutes'] .':00' ) - ( get_option( 'gmt_offset' ) * 3600 ) );
            $end_time = date( 'Ymd\THis', strtotime( substr($end_time, 0, 8) .' '. $options['icalfeeds_start_hours'] .':'. $options['icalfeeds_start_minutes'] .':00' ) - ( get_option( 'gmt_offset' ) * 3600 )  + ($options['icalfeeds_minutes'] * 60) );
            $modified_time = date( 'Ymd\THis', strtotime( substr($modified_time, 0, 8) .' '. $options['icalfeeds_start_hours'] .':'. $options['icalfeeds_start_minutes'] .':00' ) - ( get_option( 'gmt_offset' ) * 3600 ) );
        }
	    
	//Use Custom End date if available
        if (null !== $post_end_date_field) {
		    $end_time = date( 'Ymd\THis', strtotime( get_post_meta( get_the_ID(), $post_end_date_field, true ) ) - ( get_option( 'gmt_offset' ) * 3600 ) );
	    }

	    $start_time = ":$start_time" . 'Z';
	    $end_time = ":$end_time" . 'Z';
	    $modified_time = ":$modified_time" . 'Z';

        $events .= <<<EVENT
BEGIN:VEVENT
UID:$guid
DTSTAMP$modified_time
DTSTART$start_time
DTEND$end_time
ORGANIZER:$organizer
SUMMARY:$summary
URL;VALUE=URI:$permalink
END:VEVENT

EVENT;

    }

    $blog_name = get_bloginfo('name');
    $blog_url = get_bloginfo('home');

    header('Content-Type: text/calendar; charset=utf-8');
    header('Content-Disposition: attachment; filename="blog_posts.ics"');

    $content = <<<CONTENT
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//$blog_name//NONSGML v1.0//EN
X-WR-CALNAME:{$blog_name}
X-ORIGINAL-URL:{$blog_url}
X-WR-CALDESC:Posts from {$blog_name}
CALSCALE:GREGORIAN
METHOD:PUBLISH
{$events}END:VCALENDAR
CONTENT;

    foreach (preg_split("/((\r?\n)|(\r\n?))/", $content) as $outline) {
    
        // Lines are limited to 75 characters, space introduce a wrapped line
        if (strlen($outline) > 75) {
            print(wordwrap($outline, 74, "\r\n ", true));
        } else {
            print($outline);
        }
        
        // CRLF line-endings
        print("\r\n");
    }

    exit;

}

// Init or not

if (isset($_REQUEST['ical'])) {

    add_action('init', 'icalfeeds_feed');

}


function icalfeeds_autodiscover_tag() {
    print('<link href="' . home_url('/?ical') . '" rel="alternative" type="text/calendar">');
}
add_action('wp_head', 'icalfeeds_autodiscover_tag');
