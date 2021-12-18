<?php
/* Author: seodr. | seo-doktorn.se */

function lw_acf_init() {
	acf_update_setting('google_api_key', 'AIzaSyB_OBJT9VmXrBvBfWZ4vYbJg5bEHpxZsS8');
}
add_action('acf/init', 'lw_acf_init');

/*------------------------------------*\
   THEME SUPPORT
\*------------------------------------*/

if (!isset($content_width)){$content_width = 1000;}
if (function_exists('add_theme_support')){
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
    add_image_size('large', 1000, '', true);
    add_image_size('thumbnail', 150, 150, true);
    add_image_size('custom-size', 1200, 600, true);
    add_image_size('square-size', 500, 500, true);
	add_image_size('flowthumb', 500, 325, true);
    add_theme_support('automatic-feed-links'); /* Enable post & comment RSS feed links to head */
    load_theme_textdomain('seodr', get_template_directory() . '/languages');
}
// Add thumbnail sizes to media library
add_filter( 'image_size_names_choose', 'wpshout_custom_sizes' );
function wpshout_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'square-size' => __( 'Kvadrat' ),
		'custom-size' => __( 'Anpassad rektangel' ),
    ) );
}

//--- REMOVE ACTIONS & FILTERS FROM WP INSTALLATION ---\\

remove_action('wp_head', 'feed_links_extra', 3); /* Remove links to the extra feeds such as category feeds */
remove_action('wp_head', 'feed_links', 2); /* Remove links to the general feeds: Post and Comment Feed */
remove_action('wp_head', 'rsd_link'); /* Remove link to the Really Simple Discovery service endpoint, EditURI link */
remove_action('wp_head', 'wlwmanifest_link'); /* Remove link to the Windows Live Writer manifest file. */
remove_action('wp_head', 'index_rel_link'); /* Remove Index link */
remove_action('wp_head', 'parent_post_rel_link', 10, 0); /* Remove Prev link */
remove_action('wp_head', 'start_post_rel_link', 10, 0); /* Remove Start link */
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); /* Remove relation links for posts adjacent to current post. */
remove_action('wp_head', 'wp_generator'); /* Remove the XHTML generator generated on the wp_head hook, WP version */
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_filter('the_excerpt', 'wpautop'); /* Remove <p> tags from Excerpt altogether */

/*------------------------------------*\
   FUNCTIONS WITH ACTIONS & FILTERS
\*------------------------------------*/

//--- NAVIGATIONS ---\\

function seodr_nav(){
	wp_nav_menu( array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu flex',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul class="flex">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
	) );
}
add_action('init', 'register_seodr_menu');
function register_seodr_menu(){
    register_nav_menus(array(
        'header-menu' => __('Huvudmeny', 'seodr'), 
		'extra-menu' => __('Toppmeny', 'seodr'),
        'sidebar-menu' => __('Sidofältsmeny', 'seodr'), 
    ));
}

//--- LOAD AND ENQUEUE ---\\

add_action('init', 'seodr_header_scripts');
function seodr_header_scripts(){
	if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
	  	wp_register_script('tinyscript', get_template_directory_uri() . '/assets/js/tinyslider.js', array('jquery'), '2.9.2'); 
        wp_enqueue_script('tinyscript'); /* Tiny Slider  */
        wp_register_script('themescript', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.4');
        wp_enqueue_script('themescript'); /* Theme Script  */
	}
}
add_action('wp_enqueue_scripts', 'seodr_styles');
function seodr_styles(){
	wp_register_style('tinystyle', get_template_directory_uri() . '/assets/css/tinyslider.css', array(), '', 'all');
    wp_enqueue_style('tinystyle'); /* Tiny Slider  */
    wp_register_style('icons', get_template_directory_uri() . '/assets/css/icons.css', array(), '1.2', 'all');
    wp_enqueue_style('icons'); /* Icons  */
    wp_register_style('style', get_template_directory_uri() . '/style.css', array(), '1.9', 'all');
    wp_enqueue_style('style'); /* Theme Style  */
    wp_register_style('menu', get_template_directory_uri() . '/assets/css/menu.css', array(), '1.9', 'all');
    wp_enqueue_style('menu'); /* Menu Style  */
    


    // -> Kartrelaterat
    wp_enqueue_style( 'lw-theme-css', get_template_directory_uri() . '/dist/main.css', filemtime( get_template_directory() . '/dist/main.css' ) );
    $vendors_js = glob(__DIR__ . '/dist/vendors*.js');
    if ( $vendors_js ) {
        wp_enqueue_script( 'lw-theme-vendors-js', get_template_directory_uri() . '/dist/'. basename($vendors_js[0]), array('jquery'), filemtime( get_template_directory() . '/dist/'.basename($vendors_js[0]) ), true );
    }
    $main_js = glob(__DIR__ . '/dist/main*.js');
    if ( $main_js ) {
        wp_enqueue_script( 'lw-theme-main-js', get_template_directory_uri() . '/dist/'. basename($main_js[0]), array('jquery'), filemtime( get_template_directory() . '/dist/'.basename($main_js[0]) ), true );
    }
    $runtime_js = glob(__DIR__ . '/dist/runtime*.js');
    if ( $runtime_js ) {
        wp_enqueue_script( 'lw-theme-runtime-js', get_template_directory_uri() . '/dist/'. basename($runtime_js[0]), array('jquery'), filemtime( get_template_directory() . '/dist/'.basename($runtime_js[0]) ), true );
    }

    wp_localize_script('lw-theme-main-js', 'lwGlobal', array(
		'homeUrl' => home_url(),
        'templateDir' => get_template_directory_uri(),
		'adminUrl' => admin_url( 'admin-ajax.php' )
    ));

    // Kartrelaterat <-
}

$user = wp_get_current_user();
if (strpos($user->user_email, '@lightweb.se') !== false) {
    add_filter( 'show_admin_bar', '__return_false' );
}

//--- HTML5BLANK SPECIFICS ---\\

// Remove surrounding <div> from WP Navigation
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); 
function my_wp_nav_menu_args($args = ''){ $args['container'] = false; return $args; }

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var){return is_array($var) ? array() : '';}

// Remove invalid rel attribute values in the categorylist
add_filter('the_category', 'remove_category_rel_from_category_list');
function remove_category_rel_from_category_list($thelist){return str_replace('rel="category tag"', 'rel="tag"', $thelist);}

// Add page slug to body class
add_filter('body_class', 'add_slug_to_body_class');
function add_slug_to_body_class($classes){
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes); if ($key > -1) {unset($classes[$key]);}
    } 
	elseif (is_page()) {$classes[] = sanitize_html_class($post->post_name);
    } 
	elseif (is_singular()) {$classes[] = sanitize_html_class($post->post_name);
    }
    return $classes;
}

// Remove wp_head() injected Recent Comment styles
add_action('widgets_init', 'my_remove_recent_comments_style');
function my_remove_recent_comments_style(){
    global $wp_widget_factory;
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'],'recent_comments_style'));
}

// Pagination for paged posts with Next and Previous Links
add_action('init', 'seodr_pagination');
function seodr_pagination(){
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Remove 'text/css' from our enqueued stylesheet
add_filter('style_loader_tag', 'seodr_style_remove');
function seodr_style_remove($tag){return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10);
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10);
function remove_thumbnail_dimensions( $html ){$html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html); return $html;}

// Custom Gravatar in Settings > Discussion
add_filter('avatar_defaults', 'seodrgravatar');
function seodrgravatar ($avatar_defaults){
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
add_action('get_header', 'enable_threaded_comments');
function enable_threaded_comments(){
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {wp_enqueue_script('comment-reply');}
    }
}

// Custom Comments Callback
function seodrcomments($comment, $args, $depth){
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
	if ( 'div' == $args['style'] ) {$tag = 'div';$add_below = 'comment';} else {$tag = 'li';$add_below = 'div-comment';}
?>
    <!-- HEADS UP! starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?><div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php endif; ?>
	<div class="comment-author vcard">
		<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
		<?php printf(__('<cite class="fn">%s</cite> <span class="says">säger:</span>'), get_comment_author_link()) ?>
	</div>
	<?php if ($comment->comment_approved == '0') : ?>
		<em class="comment-awaiting-moderation"><?php _e('Din kommentar väntar på granskning.') ?></em>
		<br />
	<?php endif; ?>
	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php printf( __('%1$s på %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Redigera)'),'  ','' );
		?>
	</div>
	<?php comment_text() ?>
	<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

//--- SIDEBARS AND WIDGETS ---\\

add_filter('widget_text', 'do_shortcode'); /* Allow shortcodes in Dynamic Sidebar */
add_filter('widget_text', 'shortcode_unautop'); /* Remove <p> tags in Dynamic Sidebars */

if (function_exists('register_sidebar')){
    register_sidebar(array(
        'name' => __('Sidfot 1', 'seodr'),
        'description' => __('Kolumn 1 inuti sidfoten', 'seodr'),
        'id' => 'footer-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
    register_sidebar(array(
        'name' => __('Sidfot 2', 'seodr'),
        'description' => __('Kolumn 2 inuti sidfoten', 'seodr'),
        'id' => 'footer-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
    register_sidebar(array(
        'name' => __('Sidfot 3', 'seodr'),
        'description' => __('Kolumn 3 inuti sidfoten', 'seodr'),
        'id' => 'footer-area-3',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

add_action( 'init', 'create_posttype_faq' );
function create_posttype_faq() {
    register_post_type( 'kunskap',
        array(
            'labels' => array(
                'name' => __('Kunskapsbank'),
                'singular_name' => __('Kunskap'),
            ),
            'public' => true,
            'rewrite' => array( 'slug' => 'kunskap/%kategori%', 'with_front' => false ),
            'has_archive' => 'kunskap',
			'menu_icon'   => 'dashicons-book-alt',
            'supports' => array('title', 'editor', 'thumbnail'),
			'menu_position' => 3,
        )
    );
}
add_action( 'init', 'create_my_taxonomies_faq', 0 );
function create_my_taxonomies_faq() {
    register_taxonomy(
        'kategori',
        'kunskap',
        array(
            'labels' => array(
                'name' => 'Kategori',
            ),
            'show_ui' => true,
            'rewrite' => array('slug' => 'kunskap', 'with_front' => false),
            'show_tagcloud' => false,
            'hierarchical' => true,
            'show_admin_column' => true
        )
    );
}

add_action( 'init', 'create_posttype_team' );
function create_posttype_team() {
    register_post_type( 'karriar',
        array(
            'labels' => array(
                'name' => __('Lediga tjänster'),
                'singular_name' => __('Jobb'),
            ),
            'public' => true,
            'rewrite' => array( 'slug' => 'karriar', 'with_front' => false ),
            'has_archive' => 'karriar',
			'menu_icon'   => 'dashicons-businessman',
            'supports' => array('title', 'editor', 'thumbnail'),
			'menu_position' => 3,
        )
    );
}

add_action( 'init', 'create_posttype_ref' );
function create_posttype_ref() {
    register_post_type( 'referenser',
        array(
            'labels' => array(
                'name' => __('Referenser'),
                'singular_name' => __('Referens'),
            ),
            'public' => true,
            'rewrite' => array( 'slug' => 'referenser', 'with_front' => false ),
            'has_archive' => 'referenser',
			'menu_icon'   => 'dashicons-tickets-alt',
            'supports' => array('title', 'editor', 'thumbnail'),
			'menu_position' => 3,
        )
    );
}

add_action( 'init', 'create_posttype_kon' );
function create_posttype_kon() {
    register_post_type( 'kontakt',
        array(
            'labels' => array(
                'name' => __('Kontaktpersoner'),
                'singular_name' => __('Kontaktperson'),
            ),
            'public' => true,
            'rewrite' => array('slug' => 'kontakt/%lan%', 'with_front' => false ),
            'has_archive' => 'kontakt',
			'menu_icon'   => 'dashicons-testimonial',
            'supports' => array('title', 'thumbnail'),
			'menu_position' => 3,
        )
    );
}
add_action( 'init', 'create_my_taxonomies_kon', 0 );
function create_my_taxonomies_kon() {
    register_taxonomy(
        'lan',
        'kontakt',
        array(
            'labels' => array(
                'name' => 'Län och orter',
            ),
            'show_ui' => true,
            //'rewrite' => array('hierarchical' => true, 'slug' => 'kontakt', 'with_front' => false),
            'rewrite' => array('slug' => 'kontakt', 'with_front' => false),
			'hierarchical' => true,
            'show_tagcloud' => false,
            'show_admin_column' => true
        )
    );
}

add_action( 'init', 'create_posttype_app' );
function create_posttype_app() {
    register_post_type( 'applikationer',
        array(
            'labels' => array(
                'name' => __('Applikationer'),
                'singular_name' => __('Applikation'),
            ),
            'public' => true,
            'rewrite' => array( 'slug' => 'applikationer', 'with_front' => false ),
            'has_archive' => 'applikationer',
			'menu_icon'   => 'dashicons-admin-tools',
            'supports' => array('title', 'editor', 'thumbnail'),
			'menu_position' => 3,
        )
    );
}

/* TIP: Copy & paste the if-statement for each post type within this function below, for a more compressed file */
add_filter( 'post_type_link', 'wpa_show_permalinks', 1, 2 );
function wpa_show_permalinks( $post_link, $post ){
    if ( is_object( $post ) && $post->post_type == 'kunskap' ){
        $terms = wp_get_object_terms( $post->ID, 'kategori' );
        if( $terms ){return str_replace( '%kategori%' , $terms[0]->slug , $post_link );}
    }
	if ( is_object( $post ) && $post->post_type == 'kontakt' ){
		$terms = wp_get_object_terms( $post->ID, 'lan' );
        if( $terms ){return str_replace( '%lan%' , $terms[0]->slug , $post_link );}
    }
    return $post_link;
}

/* CUSTOM URL FOR 'KONTAKT' 
add_action( 'wp_loaded', 'add_clinic_permastructure' );
function add_clinic_permastructure() {
	global $wp_rewrite;
		add_permastruct( 'lan', 'kontakt/%lan%', false );

	add_permastruct( 'kontakt', 'kontakt/%lan%/%kontakt%', false );
}
add_filter( 'post_type_link', 'recipe_permalinks', 10, 2 );
function recipe_permalinks( $permalink, $post ) {
	if ( $post->post_type !== 'kontakt' )
		return $permalink;
	$terms = get_the_terms( $post->ID, 'lan' );
	if ( ! $terms )
		return str_replace( '%lan%/', '', $permalink );
	$post_terms = array();
	foreach ( $terms as $term )
		$post_terms[] = $term->slug;
	return str_replace( '%lan%', implode( ',', $post_terms ) , $permalink );
}
/* CUSTOM URL FOR 'LÄN' 
add_filter( 'term_link', 'add_term_parents_to_permalinks', 10, 2 );
function add_term_parents_to_permalinks( $permalink, $term ) {
	$term_parents = get_term_parents( $term );
	$permlink = '';
	if (!$term_parents)
		return $permalink;
	foreach ( $term_parents as $term_parent )
		$permlink = str_replace( $term->slug, $term_parent->slug . '/' . $term->slug, $permalink );
	return $permlink;
}
function get_term_parents( $term, &$parents = array() ) {
	$parent = get_term( $term->parent, $term->taxonomy );
	if ( is_wp_error( $parent ) )
		return $parents;
	$parents[] = $parent;
	if ( $parent->parent )
		get_term_parents( $parent, $parents );
    return $parents;
}*/


/*------------------------------------*\
	EGNA FUNKTIONER
\*------------------------------------*/

//--- HIDE ACF FOR ALL BUT DEVELOPER ---\\
add_filter('acf/settings/show_admin', 'my_acf_show_admin');
function my_acf_show_admin($show) {
    $admins = array('seodr tech', 'wplightweb');
    $current_user = wp_get_current_user();
    return (in_array($current_user->user_login, $admins));
}

//--- HIDE THEME- AND PLUGIN EDITOR FOR ALL BUT DEVELOPER ---\\
add_action('admin_menu', 'hide_menu', 100);
function hide_menu() {
 $current_user = wp_get_current_user();
 $theuser = $current_user->user_login;
    if($theuser != 'seodr tech' && $theuser != 'wplightweb') {
        /* Remove the theme editor and theme options submenus */
        remove_submenu_page( 'themes.php', 'themes.php' );
        remove_submenu_page( 'themes.php', 'theme-editor.php' );
        remove_submenu_page( 'themes.php', 'theme_options' );
		remove_menu_page( 'plugins.php' );
    }
}

//--- HIDE HEADER/MENU ACF-FIELD FOR ALL BUT DEVELOPER ---\\
add_action('admin_footer', 'my_admin_hide_cf');
function my_admin_hide_cf() {
 $current_user = wp_get_current_user();
 $theuser = $current_user->user_login;
    if($theuser != 'seodr tech' && $theuser != 'wplightweb') {
        echo '
	   <style>
	   #acf-group_607d4a8c5069d {display:none}
	   </style>';
    }
}

//--- ALLOW SVG ---\\
add_action('admin_head', 'fix_svg' );
add_filter('upload_mimes', 'cc_mime_types' );
add_filter('wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
		global $wp_version; if ( $wp_version !== '4.7.1' ) {return $data;}
		$filetype = wp_check_filetype( $filename, $mimes ); 
		return ['ext' => $filetype['ext'],'type' => $filetype['type'],'proper_filename' => $data['proper_filename']];
}, 10, 4 );

function cc_mime_types( $mimes ){$mimes['svg'] = 'image/svg+xml';return $mimes;}
function fix_svg() {
  echo '<style type="text/css">.attachment-266x266, .thumbnail img {width: 100% !important;height: auto !important;}</style>';
}

//--- ACF OPTIONS PAGE ---\\
if( function_exists('acf_add_options_page') ) {   
    acf_add_options_page(array(
		'icon_url' => 'dashicons-admin-settings',
		'position' => 2, 
		'page_title' => 'Generella inställningar', 
		'menu_title' => 'Generella inställningar',
	));
	acf_add_options_sub_page(array(
        'page_title'     => 'Arkiv Kunskapsbank',
        'menu_title'    => 'Redigera kunskapsarkiv',
        'parent_slug'    => 'edit.php?post_type=kunskap',
    ));
	acf_add_options_sub_page(array(
        'page_title'     => 'Arkiv Aktuellt',
        'menu_title'    => 'Redigera arkiv',
        'parent_slug'    => 'edit.php',
    ));
	acf_add_options_sub_page(array(
        'page_title'     => 'Arkiv Karriär',
        'menu_title'    => 'Redigera karriärsarkiv',
        'parent_slug'    => 'edit.php?post_type=karriar',
    ));
	acf_add_options_sub_page(array(
        'page_title'     => 'Arkiv Referenser',
        'menu_title'    => 'Redigera referensarkiv',
        'parent_slug'    => 'edit.php?post_type=referenser',
    ));
	acf_add_options_sub_page(array(
        'page_title'     => 'Arkiv Kontakt',
        'menu_title'    => 'Redigera kontaktarkiv',
        'parent_slug'    => 'edit.php?post_type=kontakt',
    ));
	acf_add_options_sub_page(array(
        'page_title'     => 'Arkiv Applikationer',
        'menu_title'    => 'Redigera applikationsarkiv',
        'parent_slug'    => 'edit.php?post_type=applikationer',
    ));
}

//--- ADD CUSTOM STYLES TO THE WP EDITOR ---\\
add_filter( 'mce_buttons_2', 'add_style_select_buttons' );
add_filter( 'tiny_mce_before_init', 'my_custom_styles' );
add_action('init', 'custom_editor_styles');

function add_style_select_buttons( $buttons ) {array_unshift( $buttons, 'styleselect' );return $buttons;}
function my_custom_styles( $init_array ) {  
    $style_formats = array(  
        array(  
            'title' => 'Ingress',  
            'block' => 'span',  
            'classes' => 'ingress',
            'wrapper' => true,
        ),  
        array(  
            'title' => 'Tunn rubrik',  
            'block' => 'span',  
            'classes' => 'thinner',
            'wrapper' => true,
        ),  
		array(  
            'title' => 'Mindre rubrik',  
            'block' => 'span',  
            'classes' => 'smaller',
            'wrapper' => true,
        ),  
		array(  
            'title' => 'Överrubrik',  
            'block' => 'span',  
            'classes' => 'upper',
            'wrapper' => true,
        ),  
		array(  
            'title' => 'Blå text',  
            'inline' => 'span',  
            'classes' => 'blue-text',
            'wrapper' => true,
        ),  
    );  
    $init_array['style_formats'] = json_encode( $style_formats );  
    return $init_array;   
} 
function custom_editor_styles() {add_editor_style('/assets/css/custom-wysiwyg.css');}

//--- MEGA MENU PICS ---\\
// add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2);
// function my_wp_nav_menu_objects( $items, $args ) {    
//     foreach( $items as &$item ) {
//         $pic = get_field('picture', $item);
//         $size = 'square-size';
//         $thumb = $pic['sizes'][ $size ];
// 		$desc = get_field('desc', $item);
//         if( $pic ) {
// 			$item->title = '<img data-no-lazy="1" src="'.$thumb.'"/><div><span class="col-f-1">' . $item->title . '</span><p>' . $desc . '</p></div>';
// 		}
//     }
//     return $items; 
// }

//--- SIDEBAR MENU HEADING ---\\

add_filter('wp_nav_menu_items', 'sidebaradd', 10, 2);

function sidebaradd( $items, $args ) {
	$menu = wp_get_nav_menu_object($args->menu);
	$head = get_field('menu_head', $menu);
		if ($head){
			$menuhead = '</ul><span class="menuhead pad-b-s primary-bg col-f-1">'.$head.'</span><ul class="menu side">';
			$items = $menuhead . $items;
		}
	return $items;
}

//--- MAKE THE SEARCH TO INCLUDE ACF FIELDS ---\\
add_filter('posts_join', 'cf_search_join' );
add_filter('posts_where', 'cf_search_where' );
add_filter('posts_distinct', 'cf_search_distinct' );

function cf_search_join( $join ) {
    global $wpdb; if ( is_search() ) {
		$join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
	} return $join;
}
function cf_search_where( $where ) {
    global $pagenow, $wpdb; if ( is_search() ) {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
    }return $where;
}
function cf_search_distinct( $where ) {global $wpdb; if ( is_search() ) {return "DISTINCT";} return $where;}

//--- CREATE CUSTOM EXCERPTS ---\\
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)

function seodr_excerpt($length_callback = '', $more_callback = ''){
    global $post;
    if (function_exists($length_callback)) {add_filter('excerpt_length', $length_callback);}
    if (function_exists($more_callback)) {add_filter('excerpt_more', $more_callback);}
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}
function ordinary($length){return 26;} //Add to theme with seodr_excerpt('ordinary');

/* CUSTOM "VIEW ARTICLE" LINK TO POST
add_filter('excerpt_more', 'seodr_view_article');
function seodr_view_article($more){global $post; return ' <span class="more">[...]</span><div class="col-f-1"><span class="view-article btn btn-secondary" href="' . get_permalink($post->ID) . '">' . __('Läs mer', 'seodr') . '</span></div>';}*/

//--- CUSTOM "VIEW ARTICLE" LINK TO POST ---\\
add_filter('excerpt_more', 'seodr_view_article');
function seodr_view_article($more){global $post; return ' <span class="more">[...]</span>';}

//--- CUSTOM EXCERPT FOR ACF ---\\
function acf_excerpt() {
    global $post;
    if( have_rows('flexible_content') ): while ( have_rows('flexible_content') ) : the_row(); 
        if( get_row_layout() == 'colsec' ): 
            $col_1 = get_sub_field('kolumn_1');
            $col_2 = get_sub_field('kolumn_2');
            $col_3 = get_sub_field('kolumn_3');
            $col_4 = get_sub_field('kolumn_4');
            $text7 = $col_1['text'];
            $text8 = $col_2['text'];
            $text9 = $col_3['text'];
            $text10 = $col_4['text'];
    endif; endwhile; endif;
    $text = $text7 . ' ' . $text8 . ' ' . $text9 . ' ' . $text10;
    if ( '' != $text ) {
        $text = strip_shortcodes( $text );
        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]>', $text);
        $regex = '#(<h([1-6])[^>]*>)\s?(.*)?\s?(<\/h\2>)#';
        $text = preg_replace($regex,'', $text);
        $excerpt_length = 10; // 10 words
        $text = wp_trim_words( $text, $excerpt_length, $excerpt_more );   
    }
    return apply_filters('the_excerpt', $text);
} /* Add to theme with "echo acf_excerpt();" – CANNOT be added within flexible-content.php */

//--- CHANGE TINY MCE BUTTONS ---\\
add_filter( 'mce_buttons', 'jivedig_remove_tiny_mce_buttons_from_editor');
add_filter( 'mce_buttons_2', 'jivedig_remove_tiny_mce_buttons_from_kitchen_sink');

function jivedig_remove_tiny_mce_buttons_from_editor( $buttons ) {
    $remove_buttons = array('wp_more','fullscreen','dfw','wp_adv',);
    foreach ( $buttons as $button_key => $button_value ) {
        if ( in_array( $button_value, $remove_buttons ) ) {unset( $buttons[ $button_key ] );}
    }return $buttons;
}
function jivedig_remove_tiny_mce_buttons_from_kitchen_sink( $buttons ) {
    $remove_buttons = array('forecolor','pastetext','outdent','indent','undo','redo','hr','wp_help',);
    foreach ( $buttons as $button_key => $button_value ) {
        if ( in_array( $button_value, $remove_buttons ) ) {unset( $buttons[ $button_key ] );}
    }return $buttons;
}

//--- WP COLOR SCHEME EDIT ---\\
/* Remove color picker for users */
//if(is_admin()) {remove_action("admin_color_scheme_picker", "admin_color_scheme_picker");}
/* New colors */
add_action('admin_init', 'add_color_schemes');
function add_color_schemes() {
	$dir = get_stylesheet_directory_uri();
	$blogname = get_bloginfo( 'name' );
	wp_admin_css_color(
		'seodr', $blogname, $dir . '/assets/css/colors.min.css', array('#004d49','#0b6661', '#d4eee1', '#e06677')
	);
}
// Set default for new users
add_action('user_register', 'set_default_admin_color');
function set_default_admin_color($user_id) {
    $args = array('ID' => $user_id, 'admin_color' => 'seodr');
    wp_update_user( $args );
}

//--- RANK MATH FIX FOR GUTENBERG ---\\
add_filter( 'rank_math/gutenberg/enabled', '__return_false' );

//--- RANK MATH LOWER PRIORITY (ORDER) ---\\
add_filter( 'rank_math/metabox/priority', function( $priority ) {return 'low';});

//--- REMOVE GUTENBERG ON CERTAIN POST TYPES AND WIDGET AREA ---\\
add_filter( 'use_widgets_block_editor', '__return_false' );
add_filter('use_block_editor_for_post_type', 'prefix_disable_gutenberg', 10, 2);
function prefix_disable_gutenberg($current_status, $post_type){
    if ($post_type === 'page') return false;
	if ($post_type === 'post') return false;
    return $current_status;
}

//--- REMOVE EDITOR, THE_CONTENT, ON CERTAIN POST TYPES ---\\
add_action( 'admin_head', 'hide_editor' );
function hide_editor() {
	$template_file = basename( get_page_template() );
	if($template_file == 'page.php'){
		remove_post_type_support('page', 'editor');
	}
}

//--- ACF ADMIN CSS + WIDTHEN TERM FIELDS ---\\
add_action( 'admin_head-term.php', 'wpse_pageeditor' );
add_action( 'admin_head-edit-tags.php', 'wpse_pageeditor' );
add_action( 'acf/input/admin_head', 'wpse_pageeditor');
add_action( 'admin_head-profile.php', 'wpse_pageeditor' );
function wpse_pageeditor() { ?>
<style type="text/css">
	/* Hide ACF direct links */
		.acf-postbox:hover>.hndle .acf-hndle-cog, #editor .postbox>.postbox-header .handle-actions .acf-hndle-cog, .acf-postbox>.postbox-header:hover .acf-hndle-cog{display: none;}
	/* General */
		#edittag, .rank-math-metabox-frame {max-width: none;}
		.edit-tags-php .term-description-wrap, .term-php .term-description-wrap, .edit-tags-php .acf-fields{display: none;}
		.term-php h2{background: #d4eee1;padding: 20px;}
		.term-php tr.acf-field{border:20px solid #fff;background:#fff;}
		.term-php .acf-tab-group li.active a{background:#fff;}
		.term-php .form-table>tbody>.acf-tab-wrap td{padding-bottom:0;}
		.flex {display:-webkit-flex; display:-ms-flexbox; display:flex; -webkit-flex-wrap:wrap; -ms-flex-wrap:wrap; flex-wrap:wrap;} 
		.acf-fields>.acf-field.zero {padding:0;}
		#editor .postbox-header:hover, a, .dismissButton{color: #0b6661;}	
		.dismissButton:hover{background: #f9f9f9;border: 1px solid #333;}
		.acf-fc-popup a:hover{background:#0b6661;}
		.acf-fields>.acf-field{padding:8px 10px; min-height: unset !important;}
		.postbox .handle-order-higher:focus, .postbox .handle-order-lower:focus, .postbox .handlediv:focus{box-shadow:0 0 0 1px #a6ccc0, 0 0 2px 1px #a6ccc0;}
		.postbox-header + .inside > .acf-field-flexible-content {padding: 10px 30px;}
		.postbox-header{border-bottom: 1px solid #fff;border-top: 15px solid #fff;}
		.acf-flexible-content .layout {border: 1px solid #0b6661;}
		.acf-kolumn{background: #f3fbf5;}
		.acf-flexible-content .layout{background: #f0f0f0;}
		div.mce-edit-area, div.mce-edit-area iframe {height: 150px;overflow-y: scroll;resize:vertical;}
		#editor .postbox-header, #poststuff .postbox-header, #poststuff h2 {font-size:20px; border-top: 0;}
	#poststuff .postbox-header {border-bottom: 1px solid #c3c4c7;}
		#editor #acf_after_title-sortables .postbox-header, #poststuff #acf_after_title-sortables .postbox-header, 
		#poststuff .acf-postbox .postbox-header, #poststuff #acf_after_title-sortables h2, #poststuff .acf-postbox h2 {background:#d4eee1;}
		.acf-field.acf-field-group > .acf-label:first-of-type {font-size: 1.2rem;text-align:center;padding-top:10px;}
		.acf-field-group .acf-fields, .acf-field-flexible-content {background: #fff;}
		.acf-switch.-on, .acf-flexible-content .layout .acf-fc-layout-handle, .acf-field-object.open>.handle{
			border-color: #0b6661; background: #0b6661; color: #fff;
		}
		.acf-icon.-collapse:before{color:#afbdb8;}
		.acf-field-message .acf-kolumn{flex:1;min-width:0;}
		.acf-flexible-content .layout .acf-fc-layout-handle{padding:17px 10px;}
        .acf-flexible-content .layout .acf-fc-layout-controls{top:17px;}
		.acf-gallery.ui-resizable{height:200px !important;}
	/* Tab */
		.acf-tab-wrap.-left .acf-tab-group li a, .acf-tab-wrap.-left .acf-tab-group li a:hover {color:#e06677;}
	/* Message field */
		.realmsg{
			font-family: serif; font-size: 16px; color:#e06677; text-align: center; line-height: 1.4;
			box-shadow:inset 0 0 0 1px #e06677; border-radius: 30px; margin: 15px !important; background:#fff;
		}
		.realmsg p{font-size: 14px;}
		.realmsg .acf-label {margin-bottom:0;}
		.color-preview li {flex:1;margin:1px;}
		.color-preview li span{
			font-size: 8px; text-align: center; font-weight: bold; border-radius: 3px;
			border: 1px solid rgba(0,0,0,0.1); line-height: 1.1; letter-spacing: -0.2px;
			-ms-hyphens: auto; -webkit-hyphens: auto; hyphens: auto;
			padding: 2px; width: 100%; height: 24px; 
			-ms-align-items:center; align-items:center;
			-webkit-justify-content: center; -ms-justify-content: center; justify-content: center;
		}
		.color-preview .cp-white {background-color: #fff;}
		.color-preview .cp-dark {background-color:#3f567e; color:#fff;}
		.color-preview .cp-primary {background-color: #f2fafc;}
		.color-preview .cp-secondary {background-color: #f5f7f9;}
		.color-preview .cp-turq {background-color: #aedfeb;}
		.color-preview .cp-blue {background-color: #cae0ec;}
	/* Button Group */
		.acf-button-group {width: 100%; display: -webkit-flex;display: -ms-flexbox;display: flex; -webkit-flex-wrap: wrap;-ms-flex-wrap: wrap;flex-wrap: wrap;}
		.acf-button-group label.selected{border-color:#0b6661; background:#d4eee1; color:#0b6661;}
		.acf-button-group label{flex: auto;padding: 4px;}
		.acf-field-group .acf-button-group label{padding: 4px 8px;flex: 1;}
		.acf-button-group label:hover, .acf-input select:focus {border-color: #e06677;background: #fff;color: #e06677;}
	/* Input Range Field */
		input[type=range] {width:300px;background-color:transparent;-webkit-appearance:none;}
		input[type=range]::-webkit-slider-runnable-track {background:#ccc;border-radius:6px;height:6px;}
		input[type=range]::-webkit-slider-thumb {margin-top:-6px;width:18px;height:18px;background:#e06677;border-radius:18px;-webkit-appearance:none;}
		input[type=range]::-moz-range-track {background:#ccc;border-radius:6px;height:6px;}
		input[type=range]::-moz-range-thumb {width:18px;height:18px;background:#e06677;border-radius:18px;}
		input[type=range]::-ms-track {background:transparent;border-color:none;color:transparent;height:6px;}
		input[type=range]::-ms-fill-lower {background:#ccc;border-radius:6px;}
		input[type=range]::-ms-fill-upper {background:#ccc;border-radius:6px;}
		input[type=range]::-ms-thumb {width:18px;height:18px;background:#e06677;border-radius:18px;margin-top:0px;}
		@supports (-ms-ime-align:auto) {input[type=range] {margin: 0;}}	 
	/* Switch, True/False */
		.acf-switch .acf-switch-on, .acf-field-object.open>.handle{text-shadow: none;}
		.acf-switch:hover, .acf-switch.-focus, .acf-switch.-on:hover, .acf-switch .acf-switch-slider, .acf-switch:hover .acf-switch-slider, .acf-switch.-focus .acf-switch-slider{border-color: #0b6661;color:#0b6661;}
	/* Date picker */
		.acf-ui-datepicker .ui-state-active, .acf-ui-datepicker .ui-widget-content .ui-state-active, 
		.acf-ui-datepicker .ui-widget-header .ui-state-active, .acf-ui-datepicker .ui-state-highlight.ui-state-active{
			border: 1px solid #e06677 !important;background: #e06677 !important;
		}
		.ui-datepicker-month, .ui-datepicker-year, .wp-core-ui select:focus{ box-shadow: none; border-color:#000;}
		.wp-person a:focus .gravatar, a:focus, a:focus .media-icon img{box-shadow:none;}
		.acf-ui-datepicker .ui-state-hover, .acf-ui-datepicker .ui-widget-content .ui-state-hover,
		.acf-ui-datepicker .ui-widget-header .ui-state-hover, .acf-ui-datepicker .ui-state-focus,
		.acf-ui-datepicker .ui-widget-content .ui-state-focus, .acf-ui-datepicker .ui-widget-header .ui-state-focus,
		.acf-ui-datepicker .ui-state-highlight.ui-state-hover{
			border:1px solid #d4eee1 !important;
			background:#d4eee1 !important;
			color: #0b6661;
			box-shadow: none;
		}
	/* Relationship */
		.acf-relationship .list .acf-rel-item:hover {background:#e06677;}
	/* Accordion */
		.acf-accordion .acf-accordion-title label{font-size: 17px;}
	/* Hide fields in user profile */
		.user-url-wrap, .user-facebook-wrap, .user-instagram-wrap, .user-linkedin-wrap, .user-myspace-wrap, 
		.user-pinterest-wrap, .user-soundcloud-wrap, .user-tumblr-wrap, .user-twitter-wrap, .user-youtube-wrap, 
		.user-wikipedia-wrap, .user-description-wrap, #application-passwords-section, #your-profile h2 {display:none;}
		.form-table th {padding:15px 10px 15px 0;}
	/*Force MCE-formats */
	    .mce-container-body.mce-stack-layout .mce-toolbar + .mce-toolbar {display:block !important;}
</style>
<?php } 

//--- CHANGE "POSTS" TO "NEWS" IN ADMIN VIEW ---\\
add_action( 'admin_menu', 'change_post_menu_label' );
function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Aktuellt';
    $submenu['edit.php'][5][0] = 'Aktuellt';
    echo '';
}

//--- CUSTOM WP-ADMIN LOGIN LOGO ---\\
add_action( 'login_enqueue_scripts', 'my_login_logo' );
function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
        background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo.svg);
		height: 70px;
		width: auto;
		background-size: contain;
		background-repeat: no-repeat;
        }
    </style>
<?php }


//--- SET SCRIPT LOADING TO DEFER ---\\
if (!is_admin()) { 
	add_filter( 'script_loader_tag', 'js_defer_attr', 10 );
	function js_defer_attr($tag){
		# Do not add defer to these scripts
		$scripts_to_exclude = array('script-name1.js', 'script-name2.js');
		foreach($scripts_to_exclude as $exclude_script){
				if(true == strpos($tag, $exclude_script ) )
				return $tag;	
		}
		# Add defer to all remaining scripts
		return str_replace(' src', ' defer src', $tag);
		}
}

//--- SHORTCODES ---\\
function shortcode_1() { 
	ob_start();
	$taxonomies = get_terms(array('taxonomy' => 'lan', 'hide_empty' => false, 'parent'=>0,));
	if (!empty($taxonomies)) :
		echo '<select onchange="location = this.value;"><option value="">Filtrera efter län ...</option>';
		foreach($taxonomies as $t){
			echo '<option value="'. esc_url(get_term_link($t)) .'">'. esc_html( $t->name ) .'</option>';
		}
		echo '</select>';
	endif;
	return ob_get_clean();
}
add_shortcode('kontorlista', 'shortcode_1'); 

function francksmap(){
    return '<svg version="1.1" id="map" viewBox="0 0 270.7 638.1" xml:space="preserve">
	<g id="varmland" data-filter="varmlands-lan"><polygon class="st0" points="79.5,422.9 73.9,419 73.2,414.9 72.6,412.9 71.1,413 71.8,419.4 65.6,410.7 62.6,404.4 60.2,404.1 57.9,402.3 56.6,398.3 53.7,392.9 53.1,391.1 51.7,391 51,387 41,375.5 39.6,372.7 37.4,372.4 31.7,373.6 33.8,379.6 33.6,381.7 34.6,386.5 37.1,391 36.9,393.2 38.9,397.1 38.8,402.1 36.1,406.1 36.7,412.6 35.8,415.1 34.2,419.3 32.6,420.5 31.8,422.6 28.8,423.9 27.2,425.6 24.8,425.9 22.8,425.1 20.1,427.5 21.6,430.4 21.6,433.2 20.2,434.8 19.4,436.4 16.8,436.9 15.5,439.2 16.4,443.9 16.9,448.8 17.6,450.8 17.5,454.1 20.9,453 21.7,453.8 21.6,452.9 28.5,453.1 29.2,456.8 30,457.1 32.6,456.6 33.6,459.5 34.4,459.7 36.2,456.7 39.3,458.3 41.2,460.1 41.2,462.5 41.2,462.5 41.2,464.1 42.8,463.6 42.9,465.4 45,465.1 45.6,466.9 46.9,467 47.4,471.6 49.9,473.1 51.1,472.1 50.4,464.9 49.2,460.2 47.9,456.6 49.2,455.3 49.2,451.9 49.9,453 50.8,454 52.3,453.8 51.7,452.4 52.4,451.4 54.7,451.1 56,452.8 57.5,456.1 59.3,454.3 60,452.1 62.1,451.2 63.3,453.2 64.9,451.8 66.6,453.2 68.1,454.1 70.1,454.1 70.8,458.3 69.2,461.5 67.8,464.2 67.7,466.8 68.5,467.1 69.6,465.3 71.3,464 72.6,465.1 71.8,467.1 74,467.1 74.3,467.6 76.1,464.5 75,461.7 75.5,460.5 75.2,458.3 76.1,454.5 76.1,454 77.6,450.3 79.5,448.3 78.1,445.3 79,443.1 79.7,443.4 79.7,441.8 78.9,438 79.3,436.5 77.8,433.7 79.3,432.8 78.9,430.6 79.3,427.5 78.2,427.1 77,424.4 80,423.3 "/></g>
	<g id="gavleborg" data-filter="gavleborgs-lan"><polygon class="st0" points="147.5,341.9 146.8,340.7 146.8,337.9 145.2,336.2 146.1,332.1 147.7,329.3 148.4,323 145.1,322.1 143.2,322.4 141.1,321.5 140.1,322.1 137.4,321.4 136,321.6 133.6,320.2 127.4,318.7 121.5,318.5 117.6,318.7 116.8,317.8 108.1,313.7 105.1,313.9 101.7,316.9 101.9,319.9 103.2,320.9 103.6,324.4 96.4,329.9 96.9,332 96.8,334.5 96.8,336.7 95.4,335.6 92.2,335.3 91.6,337.7 90.1,334.8 88.5,335.7 87.7,334.2 84,339.8 83.4,346.7 87.4,348.1 88.1,351.2 87.7,352.2 88.8,352 90,352.6 92.5,352.4 95.3,352.9 97.8,346.5 100,352.5 109.5,366.1 110,370.4 111.6,373.4 115.2,375.5 120.2,376 122.6,382 126.4,386.3 125.7,389.2 124.3,390.3 124.7,391.7 122.5,395 120.9,395.5 122.4,398.4 123.4,398.7 124.1,400.4 126.3,404.7 128.9,405.4 130.6,406.8 130.8,408.5 131.8,409 132,411.6 133.7,413.1 133.3,413.7 135,413.6 136.9,411.8 136.5,410.8 137.4,409.6 141.9,410.4 144.2,408.4 144.2,402.9 146.4,400.9 147.3,392.4 144.2,390.8 147.1,388 144.6,385.6 145.2,383.2 142.7,378.6 144,376.3 142.2,374.9 142.5,373.8 141.8,367.1 143.4,365.5 144.1,362.6 141.4,359.4 141,357 142.6,354.2 141.1,350.9 142.4,348.4 143.4,345.9 144.4,343.6 146.7,344.6 147.5,346.2 148.9,346.8 149.6,342.8 "/></g>
	<g id="gotland" data-filter="gotlands-lan"><polygon class="st0" points="197.9,514.1 196.5,514.3 194.4,513.6 192.6,514.8 192.2,516.7 190.9,517.7 187.4,517.1 186.4,518.1 185.4,521.2 183.7,517.6 182.4,518.4 181.2,519.4 180.8,521.3 179.6,521.7 178.2,522.2 176.9,523.3 176.2,526.2 174.4,529.7 172.8,532.1 171.4,532.7 169.5,535.2 169.1,537 169.7,539.2 170.2,541.7 171.2,542.9 170.9,545.9 169.6,547.4 169.3,549.2 170.7,549.6 170.7,553.2 171.4,553.9 172.6,554.7 172.2,557.4 172.8,557.7 174.4,556.4 174.7,557.5 174.1,558.9 172.4,559.9 172.2,561.9 170.9,565.1 172.6,565.2 175.3,563.3 177.1,560.7 175.7,560.2 175.6,557.2 178.1,555.2 177.1,554.7 180.6,551.9 181,550.9 183.8,549.9 184.7,548.2 183.6,547.5 183.6,546.1 185.2,543.3 186.8,542.8 188.8,542.1 189.5,540.1 187.9,539.7 186.3,538.6 185.2,536.4 185.9,535 186.2,532.2 185.3,531.6 186.1,528.3 186.2,525.8 187.6,526.7 189.4,526.6 189.6,523.7 191.1,523.6 191,521.9 191.8,521.3 193.4,520.3 194.2,518.4 193.8,517.2 194.3,516.6 195.8,516 197.6,515.9 198.3,515.1 "/></g>
	<g id="kronoberg" data-filter="kronobergs-lan"><polygon class="st0" points="111.3,561.6 109.9,559.6 107.9,558.8 107.1,556.8 104.4,555.6 105,553.9 104.7,553.6 101.2,552.2 97.1,552.9 96.2,552.2 96.6,553.6 94.4,553.5 94,554 92.8,554.8 92,555 91.4,556.2 88.9,556.4 88.4,553.6 87.7,552.8 86.3,552.1 85.2,552.1 83.8,552.9 82.4,553.1 81.9,553.8 81.2,553.7 81,554.9 78.9,555.4 75.9,555.4 75.8,559.2 75.3,559.9 75.5,561.1 77.2,563.2 75.5,567.2 73.7,568.2 72,567.2 70.8,564.3 70.6,562.5 69.7,560.9 69.2,561.3 67.9,559.8 67,559.5 65.4,559.9 65.1,561 62.5,562.2 61.4,559.2 60.3,559.1 59.7,559.5 59.2,562.1 59.4,563.3 58.2,566.9 57.2,566.6 57,567.1 54.7,567.2 53.1,568.5 52.5,567.7 50.2,568.4 49.6,568.1 49.2,568.5 49.6,571.7 49.6,575.1 50.7,576.5 51.4,578.9 51.7,580.1 52.4,580.8 53.2,583.9 52.5,585.7 53,586.6 52.6,587.5 53.1,587.9 54.8,588 57.9,587.3 60.2,586.3 62.2,586.4 63.8,585.6 65.8,585.6 66.5,584.4 66.8,582.7 68.8,582.6 69.7,583.9 71.6,584.5 72,584 76.6,585.3 79.4,586.4 81.5,586.7 83.4,589.2 84.2,589.6 86.6,590.1 88.2,590.7 88.7,590.3 90,587.7 91.7,586.4 95.3,586.4 95.5,587.4 95.8,587.4 96,586.5 97.9,585.2 98.9,586.1 99.3,585.7 99.5,583 100.2,582.4 100,580.3 101.4,578.5 101.2,577.5 101.5,575.6 99.6,572.1 102.7,570.9 104.7,570.6 104.9,569.9 103.9,567 103.9,565.6 105.7,564.8 108.2,565.7 109.2,565.4 111.6,565.2 112.2,563.4 "/></g>
	<g id="norrbotten" data-filter="norrbottens-lan"><path class="st0" d="M267.8,136.2l-0.8-2.8l-1.8-2.8v-1.2l-0.6-0.7v-1.6l-1.4-0.1l-2.6-0.8l-2.5-5.7l0.6-4.1l-1.1-1.6v-1.2l1.2-0.9v-1.5l1.4-0.6l-0.2-1.5l1.1-1.4l-0.4-3.2l0.2-1.6l-0.5-3.7l0.2-1.3l1.1,0.3l0.1-1.8l-0.8-1.6l-2-2.3l-0.2-1.9l-1.1-0.6l-0.3-1.4l-1-0.2l-1.9-2.1l-0.4-2.3l-2.2-3.1l0.4-1.6l-0.6-1.1l0.3-2.1l2.2-0.9l0.6-2.5l-0.9-0.3l-0.2-1.9l0.4-1.6l-1.2-1.2l-0.6,0.8l-2.7-1.1l-0.6,0.8l-1.8-1.5l1.1-2.4l-0.6-1.2h0.9l0.3-2.9l-1.6-2.6l-0.2-4.8l-0.5-1.8l0.4-3.1l1.9-1.1l-0.5-2.6l-1.5-0.2l-0.6-1.8h-1.1l-0.4-1.2h-1.2l-1.4-3.5l-1.2-1.2l-1.6,0.9l-0.8-1.3l0.1-1.8l-0.2-1.6l-1.5-1.2l-0.3-1.6l-1.9-0.9l-0.6-0.1l-1.9-0.9l-0.1-1.2l-0.9-0.6l-0.4,0.8l-1.9-1.1l-0.7-0.9l-0.6,0.5l-3.4-1.5l-0.8,0.9l-0.8-1.4l-1.4,0.4h-1.8l-1.8-0.5l-0.4-1.2l-0.1-1.4l-3-1.7l-2.2,0.1l0.1-1.5l-1.9-1.4l-1.9-0.6l-1.4-0.7l-0.4-2.9l-1.1-0.5l-0.9,0.6l-1.2-2.3l-4.1-3.5l-1.4,0.2l-1.4-1.6l0.8-1.1l0.3-0.9l-1-0.4l-1.5-1.8L191.6,0l-7.9,1.4l3.8,5.2l0.8,5.1l-1.4,6.1l-2.3,3.8l-2.1,2l5.1,2.4l-5.2,6.6l-16.3-5.6l-6.4,1.1l-3.6-3.1l-4.8,2.3l-0.1,6.1l1.7,9.8l-3.5,9.1l-0.4,1.5l-4.6-3.4L138,47l-1.6,3.1l-7.4,5.6l-1,0.9l-3.1,13.4l-1.9,3.8l-3.9,0.8l-1.5,4l5,8.8l0.7,2.9l-0.9,6.9l-4.9,4.2l-1.9,2.4l-6.7,13l-4.6,5.2l1,4.5l7.8,3l13.9,11l3.9,0.1l17.3,17.6l2.3,0.9l8,2.4l1.1,2.2l0.8,0.6l2.7,0.7l2,1.2l1,1.1l2,0l1.8,0.7l0.4,1.2l0.9,0.5l0.7,1.1l1.5,0.8l2.5,0.9l0,0.4l5.5,3.8l-1,1.7l0,0l1.4,0.9l0.9,1l2.4-1.5l0.7-0.8l4.3-9.6l18.6,7.5l11.3,1.2l0.6,2.1l3.3,1.7l0.7-2l-1.1-4.4l1.7-1.3l0.2-1.4l-4.6-2.9l0.8-1.4l2.9-1.2l3.1,0.2l2.1-0.9l1.2-2.2l-2.6-2.7l3.2-0.2l2.1-0.1l-0.1-1.9l1.1-0.5l2.4,0.7l0.9-0.5l-1.2-2l-0.6-2.3l-0.6-2.7l-0.2-3.3l0.4-3.1l1.9-0.9l1.6,2.3l0.1,1.7l2.2-0.2l1.9,2.2l1.4,0.5l-0.1-1.6l-2.1-2.1l-0.8-3.9l0.6-0.7l1.6,0.9l1.4,3.3l3.6,1.4l2.1,1.8l0.8-3.7l0.8-1.4l1.2,0.5l2.9,0.9l0.8-2.2l2.2,1l1.3-0.6l0.2-1.2l1.3,0.1l1.8,1.3l5.8-1.2L267.8,136.2z M163.8,160.4l-4.4-1.4l-1.2-0.8l-1.8,0.6l-2-5.8l-3-4.3l-0.9,2.6l-1.6,0.1l-0.4-2.9l0.7-1.7l-0.2-1.6l-2.1-2.9l2.2-1.1l1.6-0.7l-2.2-2.1l-2.4-2.6l-3-1.3l-0.2-2.1l-2.5-3.3l-4.9-2.9l0.5-1.3l4.4,2.1l2.1,2.5l2.3,2.3l2.1,2.3l3,1.5l1.1,2.8l1.8,1.8l1.7-0.8l1.1,1.3l-0.7,1.1l-2.8,0.6l0.9,2.9l-0.8,2.5l5,6.1l2.4-0.1l1.5,0.9l-0.3,2l1,1.2l2,1.5L163.8,160.4z"/></g>
	<g id="vasterbotten" data-filter="vasterbottens-lan"><polygon class="st0" points="227.4,210.2 225.8,210.5 224.8,206.8 222.9,204.8 220.6,204.5 219.1,202.1 220.1,200.8 219.9,196.9 216.2,196.7 215,194.1 217.3,194.5 219.7,191.1 218.9,188.8 221.2,187.8 223.6,182.3 223.4,182.6 219.4,180.5 218.9,178.8 208.4,177.7 191.1,170.6 187.3,179.1 186.2,180.3 182.5,182.5 180.7,180.6 179,179.6 178.9,178.2 179.4,177.3 175.8,174.8 174.7,175.1 174.5,173.9 172.8,173.2 170.9,172.1 170.2,171.1 169.1,170.5 168.8,169.4 167.9,169.1 165.6,169.1 164.1,167.6 162.5,166.7 159.8,166 158.5,164.9 157.5,163 155.5,162.4 150.1,160.7 147.4,159.7 130.4,142.4 126.6,142.3 112.3,131 105.8,128.5 106.1,131.1 97.7,137.5 96.6,137.6 88.2,138 89.9,152.8 88,158.4 86.9,169.6 86.8,176.2 84.2,178.7 83.5,182.9 89.7,188.4 90.9,188.9 92,190.5 93.7,192.6 93.6,194.3 94.3,195.3 96.1,195.4 98.3,198.6 98.5,200.9 101.8,202.5 104.7,207.1 104,207.6 104.2,208 106,207.5 106,210 107.7,211.5 110.9,209.8 112.5,214.7 112.6,216.8 118.1,220.4 118.2,223 120.8,222.7 131.9,235.1 134.1,237.4 142.1,239 150.8,240.3 164.9,234.3 168.3,237.5 167.3,239.9 168.1,241.9 170.3,242.2 173.3,242.8 174.2,243.9 176.2,243.5 178.2,245.8 183.3,253.4 183.4,255.4 186.2,260.2 186.4,260.2 188.2,259.4 186.8,256.5 187.8,255.1 190.2,257.4 192.2,260.9 193.9,259.7 193.1,257.2 193.7,256.2 196.8,252.1 198.6,252.2 198.8,249.9 201,250.2 204.4,250 204.9,248.6 206.7,248.5 207.1,245.1 208.7,242.9 211.7,242.4 213.1,239.6 214.4,235.9 215.9,230.8 216.4,226.2 218.7,223.2 221.3,219.6 225.3,216.2 227.6,211.9 "/></g>
	<g id="jamtland" data-filter="jamtlands-lan"><path class="st0" d="M36,282l-2.8,4.1l0.8,7.1l-2.1,6.1l4,15l7.4,2.4l4.4-0.2l3.5,4.7l2,2.8l1.7,1.9l3.7-1.8l0.7,3.2l2.5,1l-4.4,4l3.6,4.5l2.2,4.6l-0.2,1.9l0,0.1l0.4-0.3l7,1.3l1.8,0.7l4.9,0.3l3.8,1.1l0.4,0.4l0.5-0.5l0.7-7.3l5.3-8l1.3,2.4l1.6-0.9l0.5,1l4.1,0.3l0.1-1.9l-0.8-2.8l7.3-5.6l-0.2-2l-1.3-0.9l-0.2-2.7l-2.1,1.5l-5.8-3.4l-1.5-3.7l-1.6-0.4l-1.1-5.1h1.2l-0.4-2l-0.1-4l4.1-0.8l4.2,0.5l0.8,0.9l1.7-1.2l7.4-1l8.1-4l3.5,0.8l2.7-1.1l1.4,0.4l0.3-1.8l1.8-2.5l4.3-5.7l5.4-0.8l-7-8.4l-10.4-9.3l0.1-2.6l-0.2-0.1l-2.8,1.1l-0.4-5.5l0.3-1.7l-4.9-6.2l4.3-1.6l1.9,1.2l2.2-1.9l3.1,1.5l1.1-1.1l1.7,0.9l3.2-1.4l-0.7-3.8l0.3-3.8l3.1-7.1l-9.5-10.6l-3.5,0.4l-0.1-3.4l-5.4-3.6l-0.2-2.9l-0.9-2.8l-1.5,0.8l0.2,3.6l-1.4-0.1l-0.6-3.5l-2.4-2.1v-1.2l-1.2,0.4l-0.5-1.3l-1.4-0.9l1.4-0.9l-1.9-3.1l-3.7-1.8l-0.2-2.8l-1.6-2.2l-1.7-0.1l-1.5-1.9l0.1-1.8l-1.4-1.6l-0.9-1.3l-1.1-0.4l-5.6-5.1l-2.4,3.1l-11.5,21.6l4.9,3.7l3.2,1.1l0.9,1.1l0.1,2.9l0.4,9.6l-4.3,8.6l-5.1-1.8l-8.6-2.1l-2.1-0.5l-6.4,1.9l-4.5,3.4l-6.6,9.8l-1.4,1.7l-0.6,2.6l-3.1,3.3l1.1,5.3l-5.4,9.1L36,282z M78,269.4l2.8,1.2l2.1,1.9l1.4-0.4l2.3,1.4l-2.5-0.3l-0.3,1.2l1.4,1.2l1.1,0.5l-1.2,0.6l-1.6,0.6l0.2,2.8l0.6,3.3l0.7,4.9l-1,3.6l-1.3-0.8l-1.2-3.6l1.4-0.3l0.1-3.2l-1.1-3.6l-0.4-2.2l-2-1.6l-2.5-0.9l-1.6-1.6l2.1-0.1l-2.9-5.6L78,269.4z"/></g>
	<g id="vasternorrland" data-filter="vasternorrlands-lan"><polygon class="st0" points="181.9,255.8 181.8,253.9 177,246.6 175.6,245.1 173.6,245.5 172.5,244.2 170,243.7 167.1,243.3 165.6,239.9 166.5,237.9 164.6,236.1 151,241.9 141.8,240.4 133.3,238.8 130.8,236.1 128.1,242.3 127.9,245.7 128.8,250.5 123.8,252.7 122.4,251.9 121.3,253 118.1,251.4 115.9,253.4 113.6,252 111.9,252.6 115.9,257.8 115.6,259.9 115.8,263.2 117.3,262.6 118.9,263.4 118.8,266.3 128.8,275.2 137.6,285.8 130.2,286.9 126.2,292.1 124.7,294.3 124.1,297.4 121.6,296.7 119,297.8 115.5,297 107.6,300.9 100.4,301.9 97.9,303.6 96.6,302.2 93.1,301.8 90.5,302.2 90.6,305 91.2,308.5 90.1,308.5 90.6,310.9 91.9,311.2 93.6,315.1 98.1,317.8 104.5,312.5 108.4,312.2 117.7,316.5 118.3,317.2 121.5,317 127.8,317.2 134.1,318.8 136.3,320 137.4,319.8 139.9,320.5 141,319.8 143.4,320.9 145.2,320.6 149,321.6 149.4,320.7 151.2,320.2 151.9,318.1 148.6,317.2 146.8,314.4 147.2,312.6 148.9,312.1 148.4,308.4 146.1,307.6 146.1,306.4 147.9,305.6 149.6,308.9 152.8,309.6 152.2,307.4 153.8,305.9 155.9,307.1 157.1,303.6 160.4,300.9 158.4,299.3 159.9,298 162.1,294.4 159.2,294.7 158.9,293.1 161.6,293.6 164.6,290.5 163.2,289.2 164.3,288.3 166.8,290.1 168.9,286.4 169.9,283.1 166.4,282.6 166.8,281.2 168.6,281.1 168.8,278.9 170.9,274.6 173.2,274.7 177.6,271.6 179.4,272.8 181,270.8 181.1,266.9 183.4,266.2 184.2,259.8 "/></g>
	<g id="uppsala" data-filter="uppsala-lan"><polygon class="st0" points="148.8,392.4 147.8,401.6 145.7,403.5 145.7,409.1 142.4,412 138.4,411.3 138.7,412.1 135.6,415.1 134.9,415.1 135.2,418.5 134.4,418.8 134.9,421.2 134.6,422.1 136.4,423.6 136.8,426.8 136.5,427.5 137.8,429.2 136.5,432.2 135.8,433.2 136.5,434.6 138.5,437.5 139.4,442.3 139.8,442.7 140.7,442.2 142.8,441.7 146.2,443.2 148.8,445.4 148.8,445 146.9,441.1 147.7,439.5 150.7,438.1 151.2,440.9 151.2,440.3 151.7,439 152,438.7 151.8,438.4 153.5,436.8 153.2,434.8 155.8,435.3 157.1,435.3 157.6,435.9 158.4,435.5 158.7,435.5 161.6,434.4 162.7,433.5 163.2,433.5 164.2,432.5 164.5,432.7 165.4,429.6 169.5,428.5 170.5,427.4 171,421.2 169.4,419.1 172.5,418.1 172.9,416.4 174.5,412.5 174.5,412.1 175.9,412.1 176.6,410.9 175.6,409.1 173.7,407.5 175.6,407.3 175.9,405.8 174.3,405.3 172.6,402.6 171.7,398.5 170.9,398.9 170.8,400.9 171.8,404.9 171,405.9 168.8,405.3 164.8,401.9 162.2,398.6 161.9,395.6 160.1,394.4 157.4,395.6 156.1,397.8 154.4,398.2 153.1,394.9 153.1,392.4 "/></g>
	<g id="sodermanland" data-filter="sodermanlands-lan"><polygon class="st0" points="155.6,473.1 152.6,470.9 152.5,470.1 149.1,470.2 146.8,467 147.1,462.7 145.8,460.4 145.4,457.7 146.4,456.5 145.6,454.7 147,453.7 146.9,453.2 145.6,452.9 147.2,450.8 146.5,449.2 144.2,448.7 144,448.9 145,452.3 141.7,452.5 140.5,448.7 141.1,447.4 140.5,447 140.2,447.1 139.7,449.3 136.5,447.9 135.3,448.4 133.5,448.6 131,449.3 128.9,448.9 126.6,449.4 122.8,449.6 122.8,449.9 124,450.8 123.5,452.9 120,453.7 117.7,453.3 116.8,453 115.5,454.1 114.8,455 116.9,455.1 118.4,456.3 122.7,454.9 125,455.1 123.5,457.8 121.1,458.8 118.6,459 117.1,459.7 114.9,460.5 114.7,462 113.1,463.5 112,463.4 112.1,464.6 109.5,464.9 108.5,466.6 108.1,468.2 108.4,468.8 110.2,469.5 111.5,466.7 113.6,467.8 114.1,469.1 116.1,470.5 118.6,471.6 119.7,473.8 121.2,475.5 122.7,475.8 123.5,477 126.2,482.2 130.2,482.4 133.9,483.6 135.9,486.5 136.6,486.6 138.6,486.8 141.2,485.9 141.2,484.9 139.2,484.3 140.2,483.8 141.6,483.9 143.1,484.9 144.1,483.2 142.9,482.1 141.2,480.6 142.8,479.9 144,481.2 145.2,481.1 147.7,481.7 148.7,480.5 150.2,480.8 150.6,478.8 151.2,478.9 151.7,479 152.9,478.8 152.2,478.1 152.6,475.1 154.2,476.4 155,475.9 154.4,474.6 155.6,473.4"/></g>
	<g id="stockholm" data-filter="stockholms-lan"><polygon class="st0" points="175.5,462.7 174.3,464.1 173.3,464.6 173.2,464.8 173.4,464.8 173.4,465 172.8,465.9 172.9,466.1 173.2,466 173.2,466.2 173.1,466.3 172.9,466.6 172.8,466.8 172.8,467.4 173.3,467.6 173.9,467.4 174,467.8 174.3,467.8 174.6,467.4 174.7,465.8 175.3,465.1 175.3,464.5 175.9,464 176.1,463.6 175.6,462.6 	"/><polygon class="st0" points="172.6,469.2 172.4,469.6 171.6,470.1 171.2,469.9 169.8,470.8 169.5,471 168.8,471.6 168.2,472.1 168.3,472.4 168.5,472.4 168.9,472.2 169.2,471.8 169.4,472 169.4,472.4 170.1,472.4 170.3,472.2 170.6,472 170.9,471.8 171.3,471.9 172.1,471.5 171.8,471.2 171.4,470.9 171.6,470.6 172.9,469.9 173.1,469.7 173.1,469.2 172.9,469"/><polygon class="st0" points="180.4,454.5 180.3,454.2 178.7,454.8 177,455 177,455.2 177.3,455.5 177.2,455.8 177,455.8 176.2,455.4 176,455.1 175.5,454.8 174.9,454.6 174.2,454.8 173.9,454.5 174.1,454.1 174.5,453.4 174.6,453.2 174.4,453 174.7,452.8 174.7,452.5 173.9,451.8 173.4,451.6 172.6,451.8 172.2,451.6 171.8,451.7 171.3,451.6 170.3,451.7 170.2,452.1 170,452.2 169.4,452.5 169.4,453.6 169.4,453.9 169.4,454.1 169.8,454.3 170.3,454.4 170.8,454.1 171.1,453.8 171.2,453.5 171.3,452.8 171.9,452.9 172.2,453 172.7,452.9 172.9,453.1 172.8,453.4 172.4,453.6 172.2,453.8 172.4,454.5 172.2,454.7 172.1,454.9 172.4,455.1 173.2,455.1 173.6,455.8 174.1,456 174.3,456.7 174.9,457.1 175.4,457.1 175.8,457.8 176.8,458.1 177,457.9 177.3,457.6 177.7,457.4 177.7,456.9 178.3,456.7 178.6,456.4 178.9,456.2 179.4,456.1 179.3,455.9"/><polygon class="st0" points="167.9,468.9 167.9,468.6 168.1,468.4 168.4,468.5 168.6,468.3 168.5,467.9 168.7,467.6 169.1,467.5 169.4,467.3 169.5,467.1 169.2,467.1 168.4,466.9 167.8,467.2 167,467.2 166.8,467.4 166.6,467.7 166.6,467.8 166.6,468.1 166.6,468.4 166.1,468.9 166,469.1 166.1,469.7 165.9,470 166.1,470.1 166.4,469.9 166.6,469.8 166.8,469.2 167.1,469.1 167.2,469.3 167.3,469.7 167.6,469.9 168,469.8 168.2,469.5"/><polygon class="st0" points="151.4,450.9 151.5,451.1 151.9,451.5 152.1,451.9 152.1,452.2 152.3,452.8 152.7,453.1 153,453.2 153.2,452.9 153.1,452.4 153.1,452.1 153.2,451.8 153.2,451.4 153,451.2 152.7,450.2 152.4,449.9 152.3,449.6 152,449.5 151.5,449.7 151.4,450.1 151.5,450.3 151.5,450.6"/><polygon class="st0" points="155.6,473.1 155.6,473.4 155.7,473.2"/><polygon class="st0" points="167.1,451.8 167.5,452.4 168,452.6 168.6,452.6 168.9,452.4 169.2,452.2 169.4,451.9 169.2,451.7 169.2,451.6 169.3,451.4 169.7,451.4 169.9,451.3 169.8,451.1 169.4,450.9 169.1,451.1 168.9,451.1 168.2,450.9 167.6,450.6 167.1,450.4 166.7,450.4 166.5,450.5 166.5,450.7 166.6,450.9 166.9,451 167.1,451.2 167.1,451.6"/><polygon class="st0" points="157.2,449.9 157.5,449.9 157.6,449.8 157.1,449.3 156.7,449.1 156.4,449.3 156,449.1 155.5,448.5 155.2,448.3 154.8,447.9 154.5,448.1 154.4,448.2 154.6,448.4 154.6,448.9 155.2,450.2 155.4,451 155.9,452 156.5,452.9 156.9,453.7 157.3,453.7 157.5,453.9 157.8,454.4 158.5,454.6 158.9,454.4 159.1,454.1 159.1,453.7 158.8,453.4 158.9,453.1 158.9,452.4 158.8,451.9 158.5,451.4 158.4,451.2 157.8,450.5 157.6,450.6 157.7,450.9 157.5,451.1 157.2,450.9 156.9,450.4 157,450.1"/><polygon class="st0" points="160.5,454.6 160.9,454.7 161.2,454.4 161.3,453.9 161.4,453.7 161.6,453.6 161.5,453.2 161.2,453.2 161,453.1 160.7,452.5 160.3,452.3 159.8,452.4 159.7,452.6 159.5,453.1 159.6,453.4 160.2,454.1"/><polygon class="st0" points="154.1,449.1 153.6,449.2 153.3,449.3 152.9,449.6 153,450.1 153.1,450.6 153.2,450.9 153.5,451 153.7,450.9 153.9,450.9 154.3,451.9 154.6,452.1 154.9,452.1 155,452.4 154.9,452.8 155.2,452.9 155.3,453.6 155.2,453.9 155.2,454.2 155.4,454.5 155.8,454.7 156.7,455.1 157.7,455.9 158.6,455.9 158.9,455.9 159.1,456.1 159.8,456.3 160.4,456 160.5,455.9 160.4,455.6 159.6,455.2 159.7,455 159.4,454.9 158.8,455.2 158.5,455.1 157.9,454.9 157.1,454.4 156.6,454 155.9,453.9 155.4,452.1 154.4,449.1"/><polygon class="st0" points="177.1,445.7 176.8,445.6 176.7,445.2 176.4,445.2 176.1,445.3 176,445.8 176.2,445.9 176.3,446.1 176.2,446.6 176.3,446.9 176.7,447.1 176.8,447.4 176.8,448 176.8,448.3 177.2,448.2 177.4,447.8 177.5,447.2 177.6,447 177.9,447 178.1,446.8 178.1,446.2 177.9,445.6 178,445.2 178.2,445.1 178.5,445.1 178.9,444.9 179.1,444.4 179.4,443.8 179.6,443.5 180,443.4 180,443.2 179.8,443.1 179.7,442.6 179.4,442.6 179.4,442.4 179.6,442.1 179.3,442 178.9,442.2 178.8,442.5 177.7,443.1 177.6,443.6 177.2,443.9 177.1,444.1 177.1,444.4 176.9,444.7 176.9,444.8 177.2,444.9 177.4,444.9 177.3,445.3"/><polygon class="st0" points="185.2,451.8 185.6,451.6 185.5,451.3 185.2,451.2 185.1,451.2 184.8,451.6 184.7,451.9 184.6,452.5 184.5,453.1 184.3,453.4 185.1,453.4 185.3,453.2 185.1,452.9 185,452.6 185.2,452.1"/><polygon class="st0" points="184.4,449.4 184.6,449.1 184.9,448.8 185.2,448.4 185.3,447.9 185.6,447.9 185.8,447.7 185.8,447.3 185.6,447.1 185.3,447.1 185,447.1 184.6,447.2 184.2,447.6 184.1,447.9 184.1,448.2 184.2,448.7 184.1,449 183.9,449.4 183.8,449.8 184,449.9 184.4,449.6"/><polygon class="st0" points="183.9,440.1 185,440.2 185.1,439.1 186.4,438.9 186.4,438 185.1,437.4 183.8,438.2 182.7,440.1 181.5,441.2 181.9,441.6"/><polygon class="st0" points="186.5,448.5 186.1,448.4 185.8,448.6 185.8,448.9 185.4,449.1 185.6,449.4 185.6,450.3 185.7,450.6 186.1,450.6 186.2,450.3 186.1,449.5 186.6,448.8"/><polygon class="st0" points="171.9,448.5 172.5,448.4 172.4,448.2 172.1,448.1 171.8,447.8 171.6,447.8 171.4,448 171.3,448.3 171.2,448.8 171.5,449"/><polygon class="st0" points="188.4,432.4 186.1,431.7 186,429.7 187.7,429.7 188.6,427.2 187.1,425.9 184.8,424.3 183.1,421.4 181.9,417.2 181,416.6 181.3,413.6 179.4,411.8 179.2,414.1 178.5,415.6 177,415.2 174.7,414.7 174.2,417 173.8,419.2 171.9,419.9 173.4,421.8 172.4,422.1 172,428.1 170.3,429.8 166.6,430.8 165.6,434.4 165.1,434.4 164.6,434.6 164.4,434.4 163.8,435 163.2,435 162.5,435.6 162.1,435.9 161.6,435.9 159.8,436.7 159.9,437 159.4,437.2 159.2,437.1 158.7,437 158.1,437.3 157.9,438 157.4,437.9 157.2,437.4 156.7,437.2 156.4,436.8 155.7,436.8 155,436.7 155.1,437.6 154.5,437.9 153.8,438.6 154,438.8 153.7,439.4 153.3,439.4 153,439.8 152.7,440.6 152.8,441.4 153.7,442.2 153.6,442.9 153.6,443.2 153.7,443.5 153.4,444.2 153.1,444.5 152.8,444.8 152.7,445.1 152.8,445.4 153.7,446.4 153.9,446.3 153.8,446 153.9,445.7 154.2,445.6 154.4,445.9 154.4,446.8 154.5,447.2 154.9,447.2 155,446.9 154.8,446.6 154.8,446.3 155.1,445.9 155.6,445.9 156.1,446.3 156.5,446.6 156.6,447 156.8,447.3 156.9,448.1 157.2,448.2 157.6,448.3 157.6,448.6 157.8,448.6 158.1,448.2 158.1,447.3 158.2,446.5 158.5,446.4 158.8,447.1 159.1,446.9 159.4,447.1 159.2,447.4 159.2,447.6 159.1,447.7 158.7,449.2 158.6,449.8 158.8,450.1 159,450.4 159.2,450.8 160.1,451.6 160.7,452.2 161.6,452.8 161.8,453.2 162.1,453.4 162.5,453.5 162.9,453.9 163.2,453.9 163.6,453.8 163.7,453.2 163.8,452.8 163.8,452.6 163.9,452.6 164.4,453.1 164.8,453.3 165.2,453.3 165.7,453.2 165.6,453.6 165.6,453.6 165.1,453.8 164.5,453.9 164,453.9 163.8,454.1 163.2,454.2 162.8,454.5 162.3,454.7 161.9,455 161.4,455.3 161.2,455.8 161.4,456.1 161.4,457.4 161.2,457.8 161.1,457.4 160.9,456.9 160.4,456.6 159.6,456.6 159,456.8 158.5,456.6 158,457 157.5,456.5 157.2,456 156.7,455.7 156,455.5 156,455.8 155.5,455.9 155.2,455.7 154.8,455.9 154.7,456.3 154.8,456.6 155,456.8 155.1,457.1 155.2,458.1 155.6,458.9 155.5,459.2 155.1,459.2 154.9,458.8 154.5,457.8 154.2,456.9 153.9,456.5 153.4,456.5 151.5,455.5 150.8,454.7 150.5,454.7 149.9,454.2 149.7,454.2 149.5,453.9 149.1,454 149.2,454.4 149.4,454.6 149.4,455.8 149.5,456.1 150.3,457.4 150.4,457.8 149.6,457.4 149.1,457.2 148.4,457.2 147.7,457.4 147.7,457.4 147,458.2 147.3,460.1 148.6,462.4 148.3,466.6 149.8,468.7 153.9,468.6 154,470.1 156,471.6 156.5,471.7 156.9,471.9 157.2,471.6 157.4,470.8 157.3,469.3 157.1,467.1 157.1,466.5 156.7,466.2 156.4,466.5 156.2,467.3 156.2,467.9 155.8,468.8 155.6,469 155.4,468.4 155.3,466.5 155.8,465.8 155.7,465.5 155.4,465.2 155.4,464.9 155.6,464.7 156.2,464.2 156.1,464 156.2,463.7 156.4,463.8 156.7,463.7 156.8,463.5 156.8,463 156.7,462.3 156.2,461.6 156.2,461.2 156.4,460.9 156.6,461.1 156.8,461.5 156.9,462 157.1,462.2 157.3,463.6 157.1,464.4 157.1,465 157.1,465.8 157.5,465.8 158.2,465.6 158.2,465 158.1,464.1 158.2,463.8 159.1,463.2 159,463.7 159.2,464.3 158.9,464.5 158.7,465.1 158.8,465.6 158.6,465.9 158.2,466.5 158.2,467 158.6,467.7 158.8,469.1 158.6,469.6 158.6,469.9 158.9,470.3 158.8,472.1 158.7,472.4 158.9,472.8 159.4,473.4 160,474.5 160.6,475.7 160.5,476.4 160.2,476.9 159.8,477.5 159.8,478 161.2,477.5 161.8,475.2 162.2,474.9 162.6,473.7 163.1,473.1 163.6,472.7 163.9,471.6 163.6,470.1 164,469 164.1,468.6 164.2,468.1 164.4,468.3 164.5,468.8 164.7,468.7 164.8,468.5 164.8,468.1 164.5,466.9 164.6,466.7 164.9,466.8 164.9,467.1 165.2,467.2 165.4,467 165.4,466.6 165.6,466.2 165.9,466 166.5,465.9 166.8,465.8 166.9,465.4 167.1,465.1 167.8,464.9 167.9,464.6 169,464.2 169.4,463.9 169.5,463.6 169.3,463.4 169.5,463.1 169.8,462.9 170.3,462.8 170.6,463 170.6,463.2 170.4,463.4 170.1,463.4 169.9,463.6 169.8,463.9 169.9,464.1 169.9,464.3 169.6,464.4 169.2,464.8 169.2,465.1 169.3,465.3 169.6,465.2 169.9,464.8 170.5,464.5 171.7,464.1 172.1,463.7 172,463.4 170.9,463.5 171.2,462.8 171.9,462.5 172.2,462.3 172.6,462.4 172.8,462.4 173.4,461.8 173.6,461.8 173.7,462 173.9,462 174.2,461.8 174.6,461.6 175.1,460.4 174.9,460.3 174.5,460.4 174.1,460.6 173.4,460.2 173.1,459.9 173.2,459.4 173.8,459.1 173.9,458.8 173.5,458 173.1,457.9 172.8,457.8 172.3,457.3 171.1,456.4 170.5,456.4 170.3,456.2 170.2,456.1 170.4,455.9 170.8,455.9 171.6,456.1 172.1,456.2 172.3,456.1 172.2,455.8 171.9,455.6 171.3,455.5 171.2,455.2 171,454.8 170.6,454.6 170.1,454.7 169.2,454.7 169.1,454.4 169,453.7 169,453.1 168.8,453.1 168.4,453.4 167.5,453.8 167,453.9 166.6,453.9 166,453.8 165.7,453.6 165.7,453.6 165.9,453.4 165.8,453.2 166.2,453.1 166.7,453.6 167.1,453.6 167.4,453.4 167.4,453.1 167.1,452.6 166.4,452.1 165.5,451.1 166.1,450.4 166.2,449.8 166.2,449.1 166.4,448.9 166.7,448.6 166.6,448.3 167.3,447.8 167.6,447.6 167.7,448.1 167.8,448.3 168.1,448.3 168.6,448 168.8,448.1 168.8,448.4 168.8,448.8 168.6,448.9 168.1,448.8 167.9,449.1 167.9,449.6 167.9,450.1 168.4,450.2 168.8,450.3 169.1,450.5 170.4,450.4 171,450.2 171.2,449.9 171,449.8 170.4,449.8 170.4,449.6 170.6,449.4 170.8,449.2 170.4,448.8 170.2,448.5 169.8,448.6 169.5,448.5 169.4,448.3 169.5,448.1 169.9,448 170.3,448.2 170.8,448.1 171.1,447.8 171.2,447.4 171.1,447.2 170.8,447.1 170.4,446.9 170.6,446.7 171,446.6 171.2,446.9 171.4,447 171.7,446.9 172,446.9 172.1,447.2 172.5,447.1 172.8,447.2 173.1,447.1 173.6,446.3 173.6,446.1 173.7,445.9 174.2,445.8 174.6,445.4 174.9,444.8 175.1,444.7 176,443.6 176.4,443.6 176.6,443.2 177.4,442.7 178.1,442.2 178.6,441.9 179.4,441.3 180.7,439.1 181,436.6 183.7,435.1 187.4,435.4 188.7,434.4"/><polygon class="st0" points="175.8,448.9 175.3,448.8 175,448.8 174.8,448.9 174.5,448.9 174.3,449 174.4,449.2 174.5,449.4 174.8,449.6 174.9,449.8 175.1,450.2 175.1,450.6 174.9,451.1 174.9,451.4 174.9,451.6 175.1,451.9 175.2,452.1 175.2,452.5 175,453.7 175,454.1 175.3,454.2 175.6,454.2 176.4,454.8 176.9,454.6 178.1,454.4 178.7,454.2 179,453.9 179.1,453.4 179.2,452.9 178.9,452.5 178.4,452.2 177.8,452 177.2,452.1 177.1,451.8 177.6,451.7 178.1,451.6 178.3,451.7 178.6,451.6 178.8,451.4 178.8,451.1 178.6,450.9 178.3,450.9 177.9,451.1 176.3,450.1 175.9,449"/><polygon class="st0" points="179.9,453.9 180.1,454 180.4,453.9 180.9,453.5 181.3,453.2 181.4,452.8 181.4,452.1 181.4,451.6 181.1,451.1 180.5,450.7 180.2,450.9 179.9,450.5 179.1,450.8 179.8,451.9 180,452.6 180,453.1"/><polygon class="st0" points="182.3,454.1 181.7,454.6 181.4,454.9 181.2,455.4 181.2,455.9 181.4,455.9 181.8,455.8 182.2,455.9 182.5,455.6 182.6,455 183.1,454.4 182.6,454"/><polygon class="st0" points="180.9,458.6 181.1,458 180.8,457.9 180.6,458.2 180.4,458.5 179.9,459.4 179.8,459.8 180.2,459.4 180.6,459.2 181.1,459 181.4,458.9 181.8,458.7 181.9,458.2 181.6,458.2"/></g>
	<g id="vastmanland" data-filter="vastmanlands-lan"><polygon class="st0" points="137.1,438.1 135.2,435.4 134.1,433.1 135.3,431.4 136.1,429.4 134.8,427.6 135.2,426.6 135,424.4 132.7,422.5 133.4,421.1 132.7,417.9 133.6,417.5 133.4,415.2 133.2,415.2 133.4,415.2 130,415.5 130,416.7 127.5,418.4 126.3,420.5 120.8,421.1 118.5,420 118.9,418 118.5,417.8 116.7,417.5 116,415.7 114.5,416.9 112.4,416.5 112.2,417.2 111.5,417.6 111.6,418.7 110.6,420.7 111.5,422 110.2,427.7 107.2,426.5 106.6,426.5 105.8,428.3 104.2,430.1 104.3,430.7 105.8,431.5 107.3,436.7 106.5,438.7 108.5,438.5 109,442 109,443.5 112.3,443.2 110.8,446.3 111.2,446.6 111.4,451.4 109.1,451.3 109.9,453 109.8,453.1 111.9,453.2 112.5,454.3 112.6,454.3 113.2,455.6 113.2,455.6 114.9,453.6 116.6,452.1 117.9,452.6 119.9,452.9 122.9,452.2 123.1,451.1 122,450.2 122.1,448.9 118.8,449.2 118.1,447.2 120.8,447.3 122.4,446.4 124.4,447.3 127.2,446.6 128.1,445.4 129.6,443.8 128.8,442.4 130.4,441.6 132.1,442.8 133.5,444.7 135.4,443.9 136,442.8 138,443 "/></g>
	<g id="dalarna" data-filter="dalarnas-lan"><path class="st0" d="M130.4,409.9l-0.9-0.5l-0.3-1.8l-1-0.8l-2.9-0.8l-2.5-5l-0.5-1.1l-1-0.3l-2.5-5l2.8-0.9l1.5-2.3l-0.5-1.7l1.8-1.4l0.4-1.6l-3.6-4.1l-2.1-5.3l-4.4-0.5l-4.3-2.4l-1.9-3.8l-0.5-4.1l-9.4-13.5l-0.9-2.4l-1.5,3.9l-3.9-0.7l-2.6,0.2l-1.1-0.5l-3.4,0.7l1.3-3.2l-0.4-1.9l-3.6-1.2l-1.2,1.2l-1.2-1.2l-3.4-1l-4.8-0.2l-2-0.8l-6.1-1.1l-1.1,0.8l-1.2-1.8l0.2-2.1l-2-4.2l-4.3-5.2l3.6-3.3l-1-0.4l-0.5-2.1l-3.1,1.5l-2.5-2.8l-2-2.9l-3-4.1l-3.9,0.2l-6.7-2.2l-4.5,24.7l5.7,7.6l3.2-0.1l5.8,10.2l-1,5.2l-1.2,2.8l-1.9,1.4l-0.7,4.4l0.5,2.3l10.2,11.7l0.6,3.2l1.2,0.1l0.9,2.9l2.8,5.2l1.2,3.8l1.6,1.2l2.8,0.3l3.4,7l2.7,3.8l-0.4-3.7h1.6l0.4,1.4l2.2-0.2l1.1,3.2l0.6,3.6l5.1,3.5l0.2-1.5l5.1,0.8l-0.5-3.2l2.9-1.8l3.1-0.3l0.3,2.6l0.2,0.2l2-1.2l0.8,1.2l1.2-0.2l1.7,2.7l2.1,1.7l2.7,3.1l1.5,2.7l0.8-0.9l1.1-2.5l1.9,0.1l1.6,0.6l0.8-3.4l-1.1-1.5l1.2-2.4l-0.1-1.6l0.9-0.6l0.6-1.5l2.6,0.6l1.7-1.4l1.2,0.4l0.8,1.9l1.2,0.2l1.5,0.9l-0.4,1.9l0.9,0.4l4.3-0.4l1-1.8l2.1-1.4l0.1-1.4l1.2-0.5l2.4-0.2l-1.6-1.4L130.4,409.9z M95.2,383.8l-1.8,0.7l-0.4,3.6l-1.3-3.3l-3.9,1.9l-1.4-2.2l-2.3-3.1l1.8,0.1l1.1-0.6l-1.1-1.2l-1.7-0.2l-0.2-1.8l1.1-1.1l1.9,2.8h1.3l3.6,3.7l1.7-1.1l1.2-1.1l1.9,1.3L95.2,383.8z"/></g>
	<g id="v-gotaland" data-filter="vastra-gotalands-lan"><polygon class="st0" points="13.2,509.3 13.5,509.2 13.8,508.8 13.9,508.3 13.4,508.1 13.4,508.7"/><polygon points="13.1,509.1 12.9,508.2 12.6,509"/><polygon class="st0" points="7.7,509.7 8.2,509.1 8.6,508.4 8.8,507.8 9.2,507.2 10,506.8 10.6,507.1 11.2,507.6 11.7,507.9 11.6,508.6 12.1,508.7 12.6,508 13.1,507.7 13.4,507.6 14.1,507.6 14.9,507.5 15.2,506.7 15.3,505.5 15.2,504.6 15.4,503.8 15.8,503 15.6,502.4 15.1,501.8 14.7,501.4 14.2,501 14.1,500.2 14.1,499.4 13.2,499.2 12.7,499.3 11.9,499.8 11.8,500.4 11.8,501.1 11.6,501.6 11.3,501.6 10.7,501.5 10.2,501.6 9.6,502.2 9.1,502.9 8.4,503.2 7.9,503.6 7.2,503.8 6.8,504.1 6.3,504.4 5.7,504.4 5.1,504.2 4.4,505.1 3.9,506.2 4.2,506.1 4.6,505.5 5.1,505.6 5.2,506.1 5.6,506.6 6.1,507.3 6.5,507.9 6.3,508.5 5.9,509.1 5.7,509.3 6.1,509.7 6.6,509.2 6.8,509.6 7.2,509.8"/><polygon class="st0" points="16,533.5 16,533.5 16,533.5"/><polygon class="st0" points="9.1,517.4 8.2,518.6 8.9,519.2 10.8,518.3 11.1,517.3 10.1,517.2"/><polygon class="st0" points="8.3,514.6 8.3,515.4 8.4,515.8 9.2,515.8 9.5,515.4 9.8,514.9 10.1,514.6 10.6,514.4 11,514.2 11,513.9 11.2,513.3 11.4,512.5 11.9,512.6 12,513.1 12.4,513.1 12.8,512.8 13,512.1 13.1,511 13,510.2 12.6,509.7 11.8,510.2 11.4,509.9 11.7,509.4 11.8,508.9 11.3,508.6 10.9,508.5 10.6,508.7 10.1,509.9 9.8,510.2 9.3,510.3 7.9,510.1 7.6,510.2 7.2,510.4 6.9,511.1 6.9,511.5 7.1,511.9 7.6,512 8.6,511.9 8.6,512.3 8.6,512.6 7.9,512.7 7.6,512.8 7.5,513.2 7.6,513.9 7.7,514.2 7.9,514.3"/><polygon class="st0" points="10.1,524.2 9.6,524.6 9.5,525.4 9.1,525.4 9,525.8 9.2,526 9.1,526.4 8.5,526.4 8.6,526.8 9.8,527.8 10,527.6 10.2,527.1 10.2,526.2 10.5,525.4 10.8,524.8 10.5,524"/><polygon class="st0" points="8.6,522.2 7.9,524.6 8.3,524.8 9.4,523.4"/><polygon class="st0" points="16.2,530.4 16.1,532.4 16.1,532.8 18,532.8 18.5,533.4 20.6,533 22.1,532.5 24.6,531 26.6,533.6 26.2,535.4 26.5,536.2 26.7,537.3 26.5,538.3 26.5,538.3 27,538.5 27.6,539.3 28,541.1 27.4,544.1 28.2,545.1 28.1,546.7 28.7,546.6 29.3,544.7 33.1,544 34.8,544.5 37.1,546.6 38.3,547.5 40.4,547.7 41.3,550.1 40.6,550.5 40.7,551.6 41.8,551.4 43.8,552.1 43.6,552.7 43.9,552.5 44.6,553 45.3,552.1 45.9,549.9 47.1,548.3 47.9,548.6 48.4,546.4 50.5,546 50.9,545.1 51.8,544.9 51.8,543.9 53.4,543.1 54,541.6 57.2,536.9 58.1,536.2 58.4,535.3 58.2,533.3 58.4,531.8 59.7,531.2 59.9,530.5 59.2,528.8 59.4,527.1 60.3,525.8 60.3,522.4 60.5,520.6 59.6,518.1 59.7,515.6 61,514.1 61.6,512.2 62.9,511.9 63.9,512.5 64.6,512 67.2,513.2 67.3,513.8 68.7,513.4 68.8,512.9 69.8,511.6 69.9,507.5 72.4,507.8 72.6,506.5 73.4,504.7 74.2,501.2 76,499 78.6,493.2 79.6,492.7 80.5,490.3 80.7,488.5 80.8,486.3 82.4,484.9 84.2,484 85.1,483 84.6,481.8 84.1,481.8 83.5,483.5 81.1,484.3 80.8,482.8 79.2,482.8 79,479.3 78,479.2 75.6,476.9 76.6,475.4 75.5,474.5 74.6,469.4 73.6,467.9 72,467.9 69.2,470 69.4,471.1 68.9,473.6 67.9,475.8 66.4,477.2 65.2,476.4 61.1,475.6 60.6,477.1 62,478.5 62.2,480.2 63.3,479.5 65.1,478.9 65.9,479.4 65.2,480.5 63,482.4 61.4,482.8 59.2,482.8 57.1,484.1 54.8,484.8 52.6,486.3 51.9,488.7 51.4,490.8 50.2,491.6 48.3,491.3 47.4,490.6 48.8,486.2 49.8,483.3 48.8,482.4 47.1,482.1 44.4,486.2 42.8,487.9 42.9,488.8 41.4,491.1 38.4,491.6 36.6,493.7 36.7,494.8 34.9,495.4 35.5,492.7 34.1,492.5 31.9,495.6 30.6,495.3 29.7,495.9 27.4,495.5 27.6,494.1 29.1,492.1 31,490.9 32.6,489 33.7,487 35.1,485.2 36.3,484.2 35.9,483.4 33.4,483.1 32.3,481.8 32.2,479.1 34,476.4 36.1,473.3 36.6,469.8 37.5,468.4 39.7,464.6 39.7,460.8 38.4,459.6 36.8,458.7 35.1,461.4 32.5,460.8 31.6,458.3 29.8,458.7 27.9,457.9 27.2,454.6 23.2,454.4 23.6,457.9 20.5,454.7 17.4,455.8 15.9,456.9 15.6,460.8 16,461.7 14.2,464.4 13.2,466.7 13.2,468.2 12.4,470.2 8.9,471.7 7.7,470.8 7.6,469.7 8.1,465.3 6.1,460.8 5.1,460.5 4.1,461.1 3.5,461.4 2.5,461.6 0.3,465.1 0.2,467.1 0.4,467.7 1.1,468.6 1.1,469.1 0.8,469.2 0.2,468.9 0.1,469.1 0,469.8 0.8,472.2 0.9,473.3 0.6,477.4 2.2,480.5 3.3,484.6 2.2,486.1 3.3,490.6 3.4,491.2 3.5,491.9 3.3,492.4 2.8,492.8 2.5,492.7 2.4,492 1.9,492.1 1.7,492.8 1.7,493.6 1.8,494.2 1.9,494.8 1.2,495.6 1.3,496 2.1,496 3,495.5 3.2,495 3.6,495.1 3.8,495.5 4.4,495.8 5.1,495.1 5.1,496.5 5.8,496.3 5.6,497.3 5.3,498.1 5.8,498.4 6.3,498.6 6.1,499.4 5.7,499.8 5.8,500.1 6.8,500 7.3,499.5 7.9,498.6 8.5,498.2 8.5,499.4 8.1,500 7.5,500.7 6.9,501.1 6.1,501.2 5.8,501.8 5.1,502.9 5.2,503.2 6.3,503.2 7.5,502.9 8.4,502.6 9,501.8 9.4,500.9 10.2,500.8 10.8,500.4 11.4,499.7 12.1,498.6 13,498.7 13.2,498.2 12.8,497.6 13.8,497.6 14.8,497.9 16.3,497.9 15.3,499.1 15.1,499.6 15.9,500.9 16.3,501.9 16.3,502.9 17.1,502.9 17,503.7 16.4,504.3 15.9,504.5 16,505.6 15.9,506.8 15.4,507.5 14.9,508.2 14.5,508.8 14.6,509.8 14.7,510.8 14.6,511.8 14.2,512.9 13,514.2 12.8,514.8 12.8,515.4 13.1,515.9 12.2,517.4 12,518.3 11.7,518.9 11.2,519.6 11,520.2 11.3,520.7 11.8,521.2 12,521.6 12.1,522.6 12.4,522.8 13.1,522.6 13.6,522.6 13.3,524.1 12.4,524.4 11.6,524.8 11.1,525.4 11.1,525.9 11.2,526.2 11.6,526.9 12,527 12.3,527 12.6,526.9 12.8,526.2 13.1,526.1 13.5,526.3 13.9,527.1 15,526.8 15.4,527.1 16.1,526.8 16.6,526.8 14.8,527.8 14.6,528.2 14.6,528.6 15.3,530.6 15.6,530.7 16.1,529.9"/></g>
	<g id="orebro" data-filter="orebro-lan"><polygon class="st0" points="111.3,463.1 111.2,462.6 108.5,462.2 107.2,460.4 108.2,459 106.3,456.6 103.1,457.7 99.8,456.3 99.7,455.1 103,455.2 106.1,454.2 107.6,454.6 108.2,453.1 106.8,449.6 109.8,449.8 109.8,447.3 109,446.6 109.8,444.9 107.6,445.1 107.5,442.1 107.2,440.1 105.8,440.3 104.7,439 105.8,436.6 104.6,432.6 102.8,431.6 102.7,429.6 100.9,426.4 98.4,423.5 96.3,421.9 95,419.8 93.9,420 93.3,419.2 91.6,420.2 90.1,419 89.9,417.2 88.6,417.4 86.9,418.5 87.5,422.8 81.2,421.8 81.8,424.3 79.1,425.2 79.4,425.9 80.9,426.6 80.4,430.6 80.9,433.6 79.8,434.3 80.9,436.3 80.4,438 81.2,441.7 81.3,445.6 79.8,445 79.8,445.2 81.3,448.6 78.9,451.1 77.6,454.3 77.6,454.8 76.7,458.4 77,460.7 76.6,461.8 77.7,464.6 75.7,468.3 76,468.8 76.9,473.6 78.6,475 77.5,476.7 78.6,477.8 80.4,477.9 80.6,481.3 82.2,481.3 82.3,482.3 82.4,482.3 83.1,480.3 85.6,480.3 86.6,482.7 88.2,481.7 89.7,478.4 91.2,477.4 91.2,479.9 92.1,479.6 92.2,480.9 92.5,479.6 93.6,477.6 95.2,475.6 96.5,475.5 98.3,473.3 101,474.9 102,474.4 102.1,473.7 104.5,473.7 104.6,473.6 103.7,471.9 106.6,468.6 106.5,468.5 107.2,465.9 108.6,463.6 110.5,463.3 110.5,462.9 "/></g>
	<g id="ostergotland" data-filter="ostergotlands-lan"><polygon class="st0" points="134.2,498.8 133.6,497.2 131.4,496.5 130.6,495.3 131.8,495.4 134.4,495.9 137,494.9 138.8,492.1 136.9,490.2 134.1,488 130.6,486.4 127,486.2 126.5,488.3 125.2,486.7 123.2,487.5 122.4,487.1 122.5,485.6 123.4,484.7 125.9,485.1 127.6,485.1 130.8,485.9 133.3,486.3 134,486.4 133,484.9 129.8,483.8 125.2,483.7 122.2,477.8 121.8,477.2 120.4,476.8 118.5,474.6 117.5,472.8 115.3,471.7 112.8,470 112.4,468.9 112.2,468.8 110.9,471.4 107.4,470 107.4,470 105.5,472.1 106.4,473.6 105.3,475.2 103.3,475.2 102.8,477.3 102.1,476 100.9,476.6 98.7,475.2 97.2,477 95.9,477.1 94.8,478.5 93.9,480.3 93.4,482.1 91.2,483.3 90.9,486.4 89.2,488.4 90.9,489.8 92.3,490.1 93.1,490.8 91.6,491.8 90.7,494.1 89.2,494.8 88.1,493.6 87.1,494.1 87,495.6 84.2,497.9 83.8,499.4 83.3,501 83.6,502 83,503 82.4,506.1 82.8,509.9 85.8,509.4 87.4,509.1 87.6,510.5 88.7,510.2 90,507.6 93.2,509.3 94.4,513.9 95.2,516.1 93.9,517.7 93.4,518.9 93.7,519.9 95.7,522.4 95.3,523.9 96,526.5 96.6,527.8 99.3,527.5 101.9,528.1 102,527.3 103.1,525.9 104.4,526.1 104.8,524.9 106,523.8 105.7,522.1 108.8,521.4 112.1,522.5 112.3,523.5 113.7,522.7 114.9,523.6 117,521.6 117.6,521.5 116.5,517.8 117.5,517 115.7,514.4 116.2,511.1 119.6,511 120.2,512.1 120.2,512.1 119.7,510.7 120.7,509.6 123.1,507.5 124.3,508.8 126.2,507.9 128.3,510.5 128.9,509.4 131.3,510.7 132.6,515.6 133.7,515.8 135,514.9 134.3,513.4 135.9,512.4 133.9,510.4 133.5,509 135.8,510 136.9,506.9 135.6,504.9 133.5,503.4 137.6,502.6 138.4,500.4 136.6,498.9 "/></g>
	<g id="blekinge" data-filter="blekinge-lan"><polygon class="st0" points="116.7,595.3 115.5,594.4 113,594.5 111.2,593.3 109.7,590.2 108.3,589.8 107.6,588.4 107.3,587.6 106.1,587.7 105.4,586 104.7,585.8 104.4,587.3 101.6,586.2 100.5,586.6 99.1,588.2 97.8,587.1 97.3,587.5 97,588.9 94.3,588.9 94.1,587.9 92.2,587.9 91.2,588.7 89.9,591.2 88.4,592.5 86.1,591.5 83.6,591 82.4,590.4 80.6,588.1 79.6,588 78.2,590.3 76.9,590.7 76.4,592.4 77.4,595.5 77.6,597.1 78.3,597.4 80.1,597.1 81,599.1 81.5,604.9 80.4,605.4 80.1,606.8 81,607.6 82.4,608.3 84.1,608.4 85.6,606.8 84,605.1 83.1,602.9 83,601 84.4,601.3 85.4,601.4 87.4,601.1 90,601 91.8,600.9 92.8,599.8 93.8,600.9 95.5,601 97.8,600.6 98.9,600.2 99.4,602.2 101.2,601.2 101.9,600.1 103.1,601.4 104.1,600.4 105.8,599.8 106.6,600.4 109.2,599.9 110.5,601.1 110.1,602.4 108.4,604 109.6,604.4 111.6,603.2 113.3,604.8 114.9,601.3 116,600.6 117.4,597.7 118.2,594.6 "/></g>
	<g id="kalmar" data-filter="kalmar-lan"><polygon class="st0" points="145.3,547.1 144.9,545.3 144.1,545.7 143.6,545 142.6,545.9 141.2,547.9 141,550.2 140.8,551.7 139.8,552.3 140.1,553.9 139.4,556.2 138.3,558.7 137.6,560.6 136.6,561.6 135.8,563.9 135,566.8 133.5,566.8 132.5,567.6 131.6,570.4 130.3,573.1 128.8,577 128.3,579.4 127,581.8 126.8,583.6 127,588.4 127.5,588.6 127.4,596 127.9,596.8 127.7,599.2 129.4,597.7 130.2,595.1 131.8,591.1 131.4,589.6 132.5,587 133.2,584.1 133.4,582 134.8,580.6 134.6,579.6 135,577.1 136.9,570.2 138.1,569.9 138.8,568.2 138.7,566.8 139.2,565.7 139.3,562.5 140.7,561.2 140.1,559.8 141.1,559.8 141.9,556.6 143.2,553.9 143.8,553.2 143.8,550.4 143.4,549.4 144.1,547.8"/><polygon class="st0" points="133.9,520.9 135.3,522.1 135.8,519.3 135.4,516.4 134.1,517.4 131.4,516.9 130,511.7 129.5,511.4 128.6,513.3 125.8,509.7 123.9,510.6 123,509.6 121.7,510.7 121.4,511.1 122.2,513.4 119.3,513.7 118.7,512.5 117.5,512.5 117.3,514.1 119.5,517.3 118.2,518.3 119.5,522.8 117.7,523 115,525.5 113.6,524.5 111.3,525.7 110.8,523.6 108.7,523 107.4,523.3 107.6,524.3 106.1,525.7 105.5,527.8 103.8,527.5 103.5,527.9 103.2,529.6 103.6,530.3 105.1,530.7 109.4,534 107.5,536.4 108.2,537 108.7,539 107.9,539.8 107.7,543 105.6,541.6 105.2,541.9 105.3,544.2 105,545 105.5,547.3 104.2,548.2 104.3,549.9 105,550.4 105.8,552.6 106.7,553.5 106.2,554.8 108.2,555.6 109.1,557.7 110.9,558.4 112.6,560.9 113.8,563.3 112.8,566.6 109.4,566.9 108.1,567.2 105.8,566.4 105.4,566.5 105.4,566.9 106.4,569.8 106,572 102.9,572.4 101.7,572.9 103,575.3 102.7,577.4 103.1,578.8 101.5,580.8 101.8,583 101,583.7 100.9,584.9 101.6,584.6 103.2,585.2 103.5,583.7 106.5,584.8 107,586.1 108.3,586 109,587.8 109.3,588.6 110.7,589 112.4,592.2 113.5,593 115.9,592.9 116.9,593.6 118.6,592.7 119.2,589.9 120.2,586.8 121.2,585.7 121.9,583.6 122.8,583.2 122.8,581 123.1,579.6 124.2,577.4 126.1,576.9 127.1,572.2 128.2,573.2 129,572.2 128.3,571.1 127.4,571.6 128.1,567.4 128.7,564.9 128.6,562.9 129.4,560.4 131.7,557 129.6,556 128.6,553 129.5,551.2 129.1,548.9 131,547.4 130.7,544.9 132.4,544.9 133.4,542.4 134.2,539.6 133.6,537.9 131.4,535.2 133.6,535 134.5,534.2 134.5,532.7 132.9,533.3 132,532.1 132.7,530.3 134.1,529.4 134.1,527.2 132.2,525.9 130.1,522.9 131.8,520.4"/></g>
	<g id="skane" data-filter="skane-lan"><polygon class="st0" points="79.5,599.3 79.3,598.8 78.1,599 76.2,598.1 75.9,595.7 74.8,592.5 75.6,589.4 77.3,589 78.1,587.5 76.2,586.7 72.6,585.7 72.1,586.2 68.8,585.2 68.1,584.2 67.8,585.1 66.6,587.1 64.1,587.1 62.5,587.9 60.5,587.8 58.3,588.7 54.9,589.5 52.4,589.4 51.7,588.6 51.1,589.2 49.9,589.1 48.2,590.1 45.1,593.1 43.5,591.8 39.6,591.1 37.6,590.6 38.4,587.9 36.7,586.8 36.1,587.1 34.8,586.1 33.1,585.4 31.9,585.9 30.6,586.9 30.7,588.8 32.1,589.2 33.3,590.3 33.9,592 35.1,593.3 35.8,594.8 35.2,596.2 34.2,596.9 33.6,596.7 32.8,596.4 32,596.4 31.4,595.4 29.4,594.2 27.1,592.6 25.9,592.8 26.9,593.6 27.8,595.1 28.1,596.6 28.5,599.4 28.8,600.2 29.6,601.2 30.6,602.9 31.9,604.4 32.9,606.4 33.3,608.7 34.7,612.9 36.5,613.4 37,615.1 37.1,617.5 36.8,617.8 36.4,618.2 36.8,618.9 37.6,618.6 37.9,619.2 37.6,619.8 38,619.9 38.6,619.9 39.6,620.7 40,621 40.3,621.9 40.3,622.3 39.9,623.2 39.9,623.6 39.9,624.1 39.8,624.6 38.7,624.9 37.9,625.4 36.5,626.2 36,626.8 36,627.6 36.1,628.8 36.6,630.1 36.9,630.9 37.2,631.7 37.1,632.8 36.7,633.8 36.4,634.4 35.8,634.2 35,633.9 34.8,632.9 34.6,632.6 33.2,635.4 34.8,634.9 35.3,635 35.7,635.4 36.1,635.4 36.2,635.1 36.6,634.9 37.4,634.7 38.4,635.4 39.6,636.2 40.2,636.2 41.2,636.1 43.6,636.7 44.9,637.4 45.6,637.7 46.4,637.6 46.9,638.1 48.1,637.3 49.1,637.2 50,636.6 50.9,636.2 53.8,636.4 55.2,634.6 56.6,634.6 57.6,634 60.6,634.2 62.3,633.9 63.4,634.3 66.1,636.4 67.2,636.2 69.5,636.6 70,635.8 71.4,633.2 73.3,631.2 74.2,629.4 73.9,627.4 72.5,626.1 72.1,623.4 70.5,622.4 70.1,619.3 70.4,616.1 72.4,612.6 73.5,612.1 74.4,610 76.4,608.8 77.4,606.9 78.6,606.5 79,604.4 79.9,604 "/></g>
	<g id="halland" data-filter="hallands-lan"><polygon class="st0" points="56.3,562 55.3,560 55.8,558.5 54.4,557.7 53.2,558 53,557 50.5,556.5 48.1,557.5 47.6,557.2 47.5,557.9 44.1,560.8 42.8,556.5 42.7,554.6 42.8,554.6 41.8,553.9 42,553.1 41.7,553 39.3,553.5 39.1,549.7 39.5,549.5 39.3,549.1 37.8,549 36.2,547.8 34,545.8 33,545.5 30.5,546 29.8,547.9 26.4,548.5 26.7,545.5 25.8,544.4 26.4,541.1 26.2,539.9 26.1,539.8 25.3,539.5 24.9,538.3 25.2,537.2 25,536.5 24.6,535.6 25,533.9 24.3,533 22.7,533.9 20.9,534.5 17.9,535 17.3,534.3 16,534.3 16,535.1 16.1,536.3 15.4,538.1 15.1,539 15.2,539.8 16.1,542 16.4,542.8 17.1,543.1 17.5,542.9 17.8,542.2 18.4,539.9 18.8,538.8 19.3,538.3 19.8,538.6 20,539.6 19.9,541.8 19.2,543.5 19.6,543.9 20.4,543.8 20.8,544.2 21,545.8 21.1,547 19.9,547.6 19.8,549.4 21.2,551.4 22.4,553.4 22.6,556.1 23.4,557.9 24.5,558.8 25.2,560.4 25.2,561.6 24.8,563.1 26,564.6 27.9,565.4 29.8,566.9 31.2,568.2 31.1,570.5 31.9,573 32.8,574.9 33.8,577.1 35.2,577.2 36.6,576.3 38.1,577.2 38.8,579.6 39.1,581.6 38.9,583.9 38.4,585.2 38,585.8 40.1,587.2 39.5,589.5 39.9,589.7 44.1,590.4 45,591.1 47.4,588.9 49.6,587.5 50.6,587.7 51.1,587.2 51.3,586.7 50.8,585.8 51.6,583.8 51,581.6 50.3,580.8 50,579.3 49.3,577.2 48.1,575.6 48.1,571.7 47.6,567.9 49.4,566.2 50.4,566.8 53.1,566 53.4,566.4 54.2,565.7 55.9,565.6 56.2,564.7 57.2,565 57.9,563.1 57.8,562.6 "/></g>
	<g id="jonkoping" data-filter="jonkopings-lan"><polygon class="st0" points="105.4,536.6 107.3,534.3 104.5,532.1 102.6,531.7 101.7,529.9 101.7,529.6 99.2,529 95.6,529.4 94.6,527 93.8,523.9 94.1,522.8 92.3,520.6 91.8,518.8 92.6,516.9 93.5,515.8 92.9,514.3 91.9,510.3 90.7,509.7 89.8,511.6 86.3,512.2 86.1,510.8 82.6,511.4 81,510.7 79.2,513.5 78.8,515.4 76.3,517 74.6,520.1 74.1,522.2 73.8,524.9 72.6,525.1 71.8,525.6 71.1,525.1 71.4,523.2 71,521.3 70.3,520.7 70.5,517.3 71.6,515.5 72.5,512.4 72.9,509.4 71.4,509.2 71.3,512.1 70.2,513.5 70,514.6 66.1,515.8 65.8,514.2 64.8,513.7 64,514.3 62.8,513.6 62.4,514.9 61.2,516.2 61.1,517.9 62.1,520.5 61.8,522.5 61.7,526.3 60.9,527.6 60.8,528.6 61.5,530.5 60.9,532.3 59.8,532.8 59.8,533.3 59.9,535.5 59.4,537.2 58.2,538 55.3,542.3 54.6,544.2 53.3,544.8 53.3,546.1 51.9,546.4 51.5,547.3 49.7,547.7 49,550.6 47.6,550.1 47.3,550.5 46.7,552.8 44.9,555.1 44.7,555 44.3,555.4 44.3,556.4 44.9,558.2 46.1,557.1 46.5,554.9 48.2,555.8 50.3,554.9 52.7,555.4 54.1,554 54.4,556.1 54.7,556.1 57.5,557.9 56.9,559.9 57.4,560.8 57.9,561 58.3,558.5 60,557.5 62.5,557.9 63.3,560.1 63.8,559.9 64.1,558.7 67,558 68.8,558.5 69.4,559.2 70.1,558.7 72,562 72.2,564 73.2,566.2 73.7,566.5 74.3,566.1 75.5,563.4 74.1,561.7 73.8,559.6 74.3,558.8 74.5,553.9 76.4,553.9 78.8,553.9 79.7,553.7 79.9,551.9 81.2,552.2 81.6,551.7 83.3,551.5 84.8,550.6 86.7,550.6 88.7,551.7 89.8,553 90.1,554.8 90.4,554.8 90.9,553.7 92.2,553.4 93,552.9 93.6,551.9 94.3,552 93.3,550.4 96.4,550.4 97.5,551.3 101.4,550.7 103.9,551.7 103.8,551.3 102.8,550.6 102.7,547.4 103.8,546.7 103.4,544.9 103.8,543.9 103.7,541.2 105.6,539.7 106.3,540.2 106.4,539.2 107,538.5 106.8,537.9 "/></g></svg>';
}
add_shortcode('map', 'francksmap'); 

//--- LOAD MORE BUTTON ---\\
function misha_my_load_more_scripts() {
	global $wp_query; 
 	wp_register_script( 'my_loadmore', get_template_directory_uri() . '/assets/js/myloadmore.js', array('jquery') );
	wp_localize_script( 'my_loadmore', 'misha_loadmore_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages
	) );
 	wp_enqueue_script( 'my_loadmore' );
}
add_action( 'wp_enqueue_scripts', 'misha_my_load_more_scripts' );

function misha_loadmore_ajax_handler(){
 	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';
 	query_posts( $args );
 
	get_template_part('loop');
	die;
}
add_action('wp_ajax_loadmore', 'misha_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'misha_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}
