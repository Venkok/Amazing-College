<?php

require get_theme_file_path('/inc/like-route.php');
require get_theme_file_path('/inc/search-route.php');

function university_custom_rest()
{
	register_rest_field('post', 'authorName', array(
		'get_callback' => function () {
			return get_the_author();
		}
	));
	register_rest_field('note', 'userNoteCount', array(
		'get_callback' => function () {
			return count_user_posts(get_current_user_id(), 'note');
		}
	));
}
add_action('rest_api_init', 'university_custom_rest');

function pageBanner($args = NULL)
{ # NULL makes argument optional cause it will always have some value (NULL or other)

	if (!$args['title']) {
		$args['title'] = get_the_title(); # if we didn't set argument mannualy for page - use get_the_title()
	}

	if (!$args['subtitle']) {
		$args['subtitle'] = get_field('page_banner_subtitle');
	}

	if (!$args['photo']) {
		if (get_field('page_banner_background_image') and !is_archive() and !is_home()) {
			$args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
		} else {
			$args['photo'] = get_theme_file_uri('/images/ocean.jpg');
		}
	}

?>
	<div class="page-banner">
		<div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);"></div>
		<div class="page-banner__content container container--narrow">
			<h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
			<div class="page-banner__intro">
				<p><?php echo $args['subtitle'] ?></p>
			</div>
		</div>
	</div>
<?php }

function university_files()
{
	#wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);
	wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
	#wp_enqueue_style('university_main_styles', get_stylesheet_uri(), NULL, microtime());
	wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');


	wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyBtQcG4KAwd9aiookHIHsCf5VOQurGJljU', NULL, '1.0', true);


	if (strstr($_SERVER['SERVER_NAME'], 'amazing-college.local')) {
		wp_enqueue_script('main-university-js', 'http://localhost:3000/bundled.js', NULL, '1.0', true);
	} else {
		wp_enqueue_script('our-vendors-js', get_theme_file_uri('/bundled-assets/vendors~scripts.aeac6d5597dbc5c84b5d.js'), NULL, '1.0', true);
		wp_enqueue_script('main-university-js', get_theme_file_uri('/bundled-assets/scripts.facb88fc6ac5890d3ca8.js'), NULL, '1.0', true);
		wp_enqueue_style('our-main-styles', get_theme_file_uri('/bundled-assets/styles.facb88fc6ac5890d3ca8.css'));
	}
	wp_localize_script('main-university-js', 'universityData', array(
		'root_url' => get_site_url(),
		'nonce' => wp_create_nonce('wp_rest') // whenever we successfully log in to WordPress, if we check the view source of the page, there will be a secret property named "nonce" that equals a randomly generated number that WordPress creates just for our user session
	));
}

add_action('wp_enqueue_scripts', 'university_files'); // Hey WP, I want to load some CSS or JS files

function university_features()
{
	/* register_nav_menu('headerMenuLocation', 'Header Menu Location'); // adding navigation menu to WP admin dashboard.
	register_nav_menu('footerLocationOne', 'Footer Location One');
	register_nav_menu('footerLocationTwo', 'Footer Location Two'); */
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_image_size('professorLandscape', 400, 260, true);
	add_image_size('professorPortrait', 480, 650, true);
	add_image_size('pageBanner', 1500, 350, true);
	add_image_size('slideImage', 1200, 800, true);

}

add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query)
{
	if (!is_admin() and is_post_type_archive('campus') and is_main_query()) {
		$query->set('posts_per_page', -1);
	}

	if (!is_admin() and is_post_type_archive('program') and is_main_query()) {
		$query->set('orderby', 'title');
		$query->set('order', 'ASC');
		$query->set('posts_per_page', -1);
	}

	if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) { # is_main_query: This function will only evaluate to TRUE if the query in question is the default you RL based query. So this way we never accidentally manipulate a custom query.
		$today = date('Ymd'); # be sure to use the same format as Return Format in Field settings!
		$query->set('meta_key', 'event_date'); # we look inside $query object's "set" method
		$query->set('orderby', 'meta_value_num');
		$query->set('order', 'ASC');
		$query->set('meta_query', array(
			array( # shows only if event date is greater than or equal to today's date 
				'key' => 'event_date',
				'compare' => '>=',
				'value' => $today,
				'type' => 'numeric'
			)
		));
	}
}

add_action('pre_get_posts', 'university_adjust_queries'); /* right before WordPress sends its query off to the database. It will give our function the last word.
It will give us a chance to adjust the query. Hence the name of the event pre get posts right before we get the posts with the query. */

// Redirect subscriber account out of Admin and onto Homepage
add_action('admin_init', 'redirectSubstoFrontend');

function redirectSubstoFrontend()
{
	$ourCurrentUser = wp_get_current_user();

	if (count($ourCurrentUser->roles) == 1 and $ourCurrentUser->roles[0] == 'subscriber') {
		wp_redirect(site_url('/'));
		exit;
	}
}

add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar()
{
	$ourCurrentUser = wp_get_current_user();

	if (count($ourCurrentUser->roles) == 1 and $ourCurrentUser->roles[0] == 'subscriber') {
		show_admin_bar(false);
	}
}

// Customize Login Screen

add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl()
{
	return esc_url(site_url('/'));
}

add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginCSS()
{
	wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
	#wp_enqueue_style('university_main_styles', get_stylesheet_uri(), NULL, microtime());
	wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_enqueue_style('our-main-styles', get_theme_file_uri('/bundled-assets/styles.facb88fc6ac5890d3ca8.css'));
}

add_filter('login_headertitle', 'OurLoginTitle');

function OurLoginTitle()
{
	return get_bloginfo('name');
}

// Force note posts to be private
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

function makeNotePrivate($data, $postarr) {
if($data['post_type'] == 'note') {
	if(count_user_posts(get_current_user_id(), 'note') > 4 AND !$postarr['ID']) {
		die("You have reached your note limit");
	}


	$data['post_content'] = sanitize_textarea_field($data['post_content']);
	$data['post_title'] = sanitize_text_field($data['post_title']);

}

	if($data['post_type'] == 'note' AND $data['post_status'] != 'trash') {
		$data['post_status'] = 'private';

	}

	return $data;
}