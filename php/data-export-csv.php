<?php 

/** Call /data-export-csv.php?query=posts */
/** @param query=posts(tags,users) to define type of content
  * @param file=true to save data to file / false by default
  * @return csv data
  */
require_once( "./wp-load.php" );
require_once( "./wp-admin/admin.php" );

header( 'Content-Type: application/json' );
$inFile = $_GET['file'];
if( $inFile == 'true' ){
	header( "Content-Disposition: attachment; filename=\"report.csv\";" );
	header( "Content-Transfer-Encoding: binary" );
}
$contentType = $_GET['query'];
ob_end_clean();
switch ( $contentType ){
	case "blogs" :
		get_all_blogs();
		break;
	case "pages" :
		get_all_pages();
		break;
	case "posts" :
		get_all_posts();
		break;
	case "tags" :
		get_all_tags();
		break;
	case "users" :
		get_all_users();
		break;
	case "administrators" :
		get_all_users("administrator");
		break;
	case "authors" :
		get_all_users("author");
		break;
	case "contributors" :
		get_all_users("contributor");
		break;
	case "editors" :
		get_all_users("editor");
		break;
	case "subscribers" :
		get_all_users("subscriber");
		break;
	default:
		//echo " This value of parameter 'query' is not supported ";
		break;
}

function get_all_posts(){
    $sites =  wp_get_sites();
    foreach ( $sites as $site ) :
        switch_to_blog( $site['blog_id'] );
        get_all_posts_on_site();
    endforeach;
}

function get_all_posts_on_site(){
    $result = '';
    $max = 10000;
    $count_posts = wp_count_posts();
    $published_posts = $count_posts->publish;
    $posts_to_get = min($published_posts, $max);
    $site_url =  get_site_option( 'siteurl' );
    $myposts = get_posts(array( 'posts_per_page' => $posts_to_get )); //get_posts returns only published posts by default
    foreach( $myposts as $post ) :
        setup_postdata( $post );
        print_as_string( array( get_the_title( $post->ID ), "/" . str_replace( $site_url, '', get_permalink( $post->ID ) )));
        wp_reset_postdata();
    endforeach;
}

function get_all_users( $role ){
    $result = '';
    $max = '10000';
    if ( $role === '' ){
        $users = get_users('number=' . $max);
    }
    else{
        $users = get_users('number=' . $max . '&role=' . $role );
    }
    foreach( $users as $user ) :
        print_as_string (array($user->ID, $user->user_login, $user->user_email, $user->display_name, $user->first_name, $user->last_name));
    endforeach;
}

function get_all_tags(){
    $result = '';
    $tags = (array) get_tags( array( 'get' => 'all' ) );
    foreach($tags as $tag) :
       print_as_string(array( $tag->term_id, $tag->name ));
    endforeach;
}

function get_all_blogs(){
	// Not implemented
}

function get_all_pages(){
	// Not implemented
}

function print_as_string( $array ){
    $result = '';
    $delimeter = "\t";
    foreach( $array as $item ) :
        $result .= $item;
        $result .= $delimeter;
    endforeach;
    $result = trim( $result, $delimeter );
    $result = trim( $result );
    $result .= "\n";
    echo $result;
}

 ?>
