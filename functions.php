<?php
/**
 * Moviesites 
 *
 * @link https://www.linkedin.com/in/ksenia-shaldaeva-126955298/
 *
 * @package Moviesites
 * @since Moviesites 1.0
 */

 /*Base settings*/

function moviesites_setup()
{
	load_theme_textdomain('moviesites');

	add_theme_support('title-tag');
	add_theme_support('custom-logo', array(
		'height'=>39,
		'width' => 130,
		'flex-height' => true));
	add_theme_support('post-thumbnails', array('movie' ));
	add_theme_support('html5', array('search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption'));
	register_nav_menu ('Main','Main menu');
	set_post_thumbnail_size(300,450);
}

function moviesites_scripts() {
	wp_enqueue_style('style-css', get_stylesheet_uri() );
	wp_enqueue_script('loadmore-script', get_template_directory_uri() . '/assets/loadmore.js',    array(), '', array('strategy' => 'defer') );
	wp_enqueue_script('ajax-search', get_template_directory_uri() . '/assets/ajax-search.js', array(), '', array('strategy' => 'defer'));
	wp_enqueue_script('sort-movies', get_template_directory_uri() . '/assets/sort-movies.js', array(), '', array('strategy' => 'defer'));
	wp_enqueue_script( 'wp-api' );
}

//Including basic scripts and styles
add_action( 'wp_enqueue_scripts', 'moviesites_scripts' );
//Enable additional settings
add_action ('after_setup_theme','moviesites_setup');


/* Create new post type*/
add_action( 'init', 'register_post_types_movies' );

function register_post_types_movies(){

	register_post_type( 'movie', [
		'label'  => null,
		'labels' => [
			'name'               => 'Movies', 
			'singular_name'      => 'Movie', 
			'add_new'            => 'Add movie', 
			'add_new_item'       => 'Addition movie', 
			'edit_item'          => 'Editing movie', 
			'new_item'           => 'New movie', 
			'view_item'          => 'Look movie', 
			'search_items'       => 'Find movie', 
			'not_found'          => 'Not found', 
			'not_found_in_trash' => 'Not found in trash', 
			'parent_item_colon'  => '', 
			'menu_name'          => 'Movies', 
		],
		'description'            => '',
		'public'                 => true,
		'publicly_queryable' => true,
		'show_in_menu'           => true, 
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-format-video',
		'hierarchical'        => false,
		'supports'            => [ 'title', 'editor', 'thumbnail','comments'],
		'taxonomies'          => [],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	] );

}

//Adding metaboxes for a movies post type
 function true_add_metaboxes() {
 
    //metabox for date create
	add_meta_box(
		'date_create', 
		__('Date create movie', 'moviesites' ), 
		'date_create_callback', 
		'movie', 
		'normal', 
		'default' 
	);
	//metabox for rating
	add_meta_box(
		'rating', 
		__('Rating movie', 'moviesites' ), 
		'rating_callback', 
		'movie', 
		'normal', 
		'default' 
	);
 
}

//Callback function for metabox date create
function date_create_callback( $post ) {
	$date_create = get_post_meta( $post->ID, 'date_create', true );
	$metabox = <<<EOT
		<label for="date_create"> %s </label> 
		<input type="number" step="1" min="1895"  id="date_create" name="date_create" value="%s" style="%s">
		EOT;
	echo sprintf($metabox, __( 'Date create:', 'moviesites' ), esc_attr( $date_create ),'');
}
//Callback function for metabox rating
function rating_callback( $post ) {
	$rating = get_post_meta( $post->ID, 'rating', true );
	$metabox = <<<EOT
		<label for="rating"> %s </label>
		<input type="number" step="0.1" min="0" max="5" id="rating" name="rating" value="%s" style="%s">
		EOT;
	echo sprintf($metabox, __( 'Rating movie:', 'moviesites' ), esc_attr( $rating ),'');
}

//checking metaboxes when saving a movie
function true_save_meta( $post_id, $post ) {
 
	// check type post
	if( 'movie' !== $post->post_type ) {
		return $post_id;
	}

	//need to check for the correctness of the link
	if( isset( $_POST[ 'date_create' ]) && is_numeric($_POST[ 'date_create']) ) {
		update_post_meta( $post_id, 'date_create', sanitize_text_field( $_POST[ 'date_create' ] ) );
	}
	if( isset( $_POST[ 'rating' ]) && is_numeric($_POST[ 'rating']) ) {
		update_post_meta( $post_id, 'rating', sanitize_text_field( $_POST[ 'rating' ] ) );
	}

	return $post_id;
 
}
//Adding metaboxes for a new post type
add_action( 'add_meta_boxes',  'true_add_metaboxes' );

//Enable metabox checking when saving a movie
add_action( 'save_post', 'true_save_meta', 10, 2 );


/*button load more*/
if( wp_doing_ajax() ) {
add_action('wp_ajax_loadmore', 'true_loadmore');
add_action('wp_ajax_nopriv_loadmore', 'true_loadmore');
}

function true_loadmore()
{
    $paged = !empty($_POST['paged']) ? $_POST['paged'] : 1;
	$paged ++;
    $args = array(
			'paged' => $paged,
			'posts_per_page' => 3,
			'post_type' => 'movie',
			'post_status'  => 'publish',);
			
    query_posts($args);
 
    while (have_posts()) : the_post();
		/*Movies cards */
        get_template_part('template/movie-card');
    endwhile;
    die;
}

/*ajax search*/
if( wp_doing_ajax() ) {
add_action("wp_ajax_nopriv_ajax_search", "ajax_search");
add_action("wp_ajax_ajax_search", "ajax_search");
}
function ajax_search()
{
    $args = array(
        "post_type"      => "movie", // Post type: movie
        "post_status"    => "publish",
        "order"          => "DESC",
        "orderby"        => "date",
        "s"              => $_POST["term"],
        "posts_per_page" => 5
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) : $query->the_post();
			/*template items result*/
            get_template_part("template/loop-search-item");
        endwhile;
    } else {
        echo '<li class="result-search-item">'. __('Not found').'</li>';
    }
    exit;
}

/*Let's collect all the films we have from years*/

function all_metadata_movies($key){
	if ($key){
		$args = array(
				'post_type' => 'movie',
				'post_status'  => 'publish');			
		query_posts($args);
	
		while (have_posts()) : the_post();
			$array_meta_data[] = get_post_meta( get_the_ID(), $key, true );
		endwhile;
		/*comb the array by removing duplicates and sorting it*/
		if($array_meta_data){
			$array_meta_data = array_values(array_unique($array_meta_data));
			arsort($array_meta_data, SORT_REGULAR);
		}
		return $array_meta_data;
	}
}

/*ajax sort movies*/
if( wp_doing_ajax() ) {
	add_action("wp_ajax_nopriv_sort_movies", "ajax_sort");
	add_action("wp_ajax_sort_movies", "ajax_sort");
	}
	function ajax_sort()
	{
		/*checking whether it is necessary to sort by years*/
		if ($_POST["years"]){
			$date_create = array(
				'key' => 'date_create',
				'value' => $_POST["years"],
				'compare' => '='
			);
		}
		/*checking whether it is necessary to sort by rating*/
		if ($_POST["rating"]){
			$rating = array(
				'key' => 'rating',
				'value' => array( (float)$_POST["rating"], (float)$_POST["rating"]+0.9),
				'compare' => 'BETWEEN',
			);
		}
		/*When sorting, all films matching the description will be displayed without pagination*/
		$sort = array (
				'posts_per_page' => '-1' ,
				'post_type' => 'movie',
				'post_status'  => 'publish',
				'meta_key' => 'rating',
				'meta_query' => array(
					'relation' => 'AND',
					$rating,$date_create
				),
				'orderby' => 'meta_value',
				'order'   => 'ASC',
		);
		

		$query = new WP_Query( $sort);
		if ($query->have_posts()) {
			while ($query->have_posts()) : $query->the_post();
				/*template items result*/
				get_template_part('template/movie-card');
			endwhile;
		} else {
			echo __('Sorry, no movies');
		}
		exit;
	}