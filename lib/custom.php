<?php

// Custom functions
require_once locate_template('/lib/custom-install.php' );
include locate_template('/lib/theme-options.php' );
function enqueue_csesearchbox() {
	wp_register_script( 'csesearchbox', 'http://www.google.com/cse/brand?form=cse-search-box&amp;lang=en',
		array( 'jquery' ),
		'1.0' );
	wp_enqueue_script( 'csesearchbox', 'http://www.google.com/cse/brand?form=cse-search-box&amp;lang=en', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_csesearchbox' );

function enqueue_jsapi() {
	wp_register_script( 'jsapi', 'http://www.google.com/jsapi',
		array( 'jquery' ),
		'1.0' );
	wp_enqueue_script( 'jsapi', 'http://www.google.com/jsapi', array( 'jquery' ), '1.0', false );
}
add_action( 'wp_enqueue_scripts', 'enqueue_jsapi' );

//additional menus
function register_my_menus() {
  register_nav_menus(
    array(
	  'marshall-menu' => __( 'Marshall Menu'),
      'toolbar' => __( 'Toolbar' )
    )
  );
}
add_action( 'init', 'register_my_menus' );

// http://codex.wordpress.org/Function_Reference/register_sidebar
function roots_register_sidebars_footer() {
  $sidebars = array('Footer One', 'Footer Two', 'Footer Three');

  foreach($sidebars as $sidebar) {
    register_sidebar(
      array(
        'id'            => sanitize_title($sidebar),
        'name'          => __($sidebar, 'roots'),
        'description'   => __($sidebar, 'roots'),
        'before_widget' => '<section id="%1$s" class="well widget %2$s"><div class="widget-inner">',
        'after_widget'  => '</div></section>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>'
      )
    );
  }
}

add_action('widgets_init', 'roots_register_sidebars_footer');

// This function removes the Super Admin Menu from being visible to anyone who can't manage the network. 
add_action( 'admin_init', 'remove_menu_pages' );
function remove_menu_pages() {
// If the user does not have access to add new users
if(!current_user_can('manage_network')) {
// Remove the "Link Categories" menu under "Links"
remove_submenu_page( 'themes.php', 'mu_roots_super' );
remove_submenu_page( 'themes.php', 'themes.php' );
remove_submenu_page( 'users.php', 'user-new.php' );
}
}


//Customize the Dashboard Widgets
//Remove Default Widgets
// disable default dashboard widgets
function disable_default_dashboard_widgets() {

	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
	
}
add_action('admin_menu', 'disable_default_dashboard_widgets');

//Add custom widgets
function muroots_dashboard_widget_wordpress() {
	echo '<h4>WordPress Resources</h4><p><a href="http://www.marshall.edu/lynda/">Lynda.com</a> has an extensive collection of WordPress Tutorials designed for users of all experience levels. Simply log in with your MU ID username and password to get started.</p><p><a href="http://codex.wordpress.org/Main_Page">WordPress Codex</a> is the online manual for WordPress and a living repository for WordPress information and documentation.</p><p><a href="http://digwp.com/">Digging into WordPress</a> is a blog by Chris Coyier &amp; Jeff Starr with searchable content, quick tips, and copy &amp; pasteable code.</p>
	';
}
function muroots_dashboard_widget_coding() {
echo '<p><a href="http://www.html5rocks.com/en/">HTML5ROCKS</a> HTML5 includes the fifth revision of the HTML markup language, CSS3, and a series of JavaScript APIs. HTML5ROCKs is an open source and community driven collection of articles, tutorials, case studies, and demos that show you how to use the HTML5 features.</p>
<p><a href="http://twitter.github.com/bootstrap/">Bootstrap, from Twitter</a> is a simple and flexible HTML, CSS, and Javascript for popular user interface components and interactions. <strong>It is also the toolkit on which the Marshall University websites are being built upon.</strong></p>
<p><a href="http://www.rootstheme.com/">Roots Theme</a> is the base theme on which the MU Roots theme is built upon. This theme is a starting WordPress theme based on HTML5 Boilerplate &amp; Bootstrap from Twitter.</p>';
}
function add_muroots_dashboard_widget() {
	wp_add_dashboard_widget('muroots_dashboard_widget_wordpress', 'WordPress Resources', 'muroots_dashboard_widget_wordpress');
	wp_add_dashboard_widget('muroots_dashboard_widget_coding', 'Coding Resources', 'muroots_dashboard_widget_coding');

// Global the $wp_meta_boxes variable (this will allow us to alter the array)
global $wp_meta_boxes;
// Then we make a backup of your widget
$my_widget = $wp_meta_boxes['dashboard']['normal']['core']['muroots_dashboard_widget_coding'];
// We then unset that part of the array
unset($wp_meta_boxes['dashboard']['normal']['core']['muroots_dashboard_widget_coding']);
// Now we just add your widget back in
$wp_meta_boxes['dashboard']['side']['core']['muroots_dashboard_widget_coding'] = $my_widget;
}
add_action('wp_dashboard_setup', 'add_muroots_dashboard_widget');

// Add features images to pages
function kia_add_thumbnail(){

if ( ! is_front_page() ) {
the_post_thumbnail( 'full');
}
}
add_action('roots_pageheader_before','kia_add_thumbnail');

function myformatTinyMCE($in)
{
 $in['wpautop']=true;
 $in['remove_linebreaks']=false;
 $in['extended_valid_elements']='a[*],article[*],aside[*],audio[*],canvas[*],command[*],datalist[*],details[*],div[*],embed[*],figcaption[*],figure[*],footer[*],header[*],hgroup[*],keygen[*],mark[*],meter[*],nav[*],output[*],progress[*],section[*],source[*],summary,time[*],video[*],wbr,iframe[*]';
 return $in;
}
add_filter('tiny_mce_before_init', 'myformatTinyMCE');

if (!CUSTOM_TAGS) {
        $allowedposttags['iframe'] =  array (
                             'longdesc' => array(),
                             'name' => array(),
                             'src' => array(),
                             'frameborder' => array(),
                             'marginwidth' => array(),
                             'marginheight' => array(),
                             'scroll' => array(),
                             'scrolling' => array(),
                             'align' => array(),
                             'height' => array(),
                             'width' => array ()
                          );
		 $allowedposttags['a'] =  array (
	    				  'data-toggle'=>  array(),
						  'href' => array(),
						  'id' => array(),
						  'title' => array(),
						  'rel' => array(),
						  'rev' => array(),
						  'name' => array(),
			              'target' => array()
                          );
		 $allowedposttags['div'] =  array (
                          'align' => array(),
						  'class' => array(),
						  'dir' => array(),
	  					  'id'=> array(),
					      'lang' => array(),
						  'style' => array(),
						  'xml:lang' => array()
                          );				  				  

}