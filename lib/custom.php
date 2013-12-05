<?php

// Custom functions

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
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'normal' );
}
add_action('admin_menu', 'disable_default_dashboard_widgets');

//Add custom widgets
function muroots_dashboard_widget_coding() {
	echo '
	<p><a href="http://www.marshall.edu/webguide"><strong>Online Branding Standards and Resources</strong></a> provides Marshall University content creators with guidance on appropriate use of the Marshall University brand online.</p>
	<p><a href="http://twitter.github.com/bootstrap/"><strong>Bootstrap</strong></a> is a simple and flexible front-end framework for popular user interface components and interactions. <strong>It is also the toolkit on which the Marshall University websites are built upon.</strong></p>
	<p><a href="http://www.rootstheme.com/"><strong>Roots Theme</strong></a> is the base theme on which the MU Roots theme is built upon. This theme is a starting WordPress theme based on HTML5 Boilerplate &amp; Bootstrap from Twitter.</p>
	<p><a href="http://www.marshall.edu/lynda/"><strong>Lynda.com</strong></a> has an extensive collection of WordPress Tutorials designed for users of all experience levels. Simply log in with your MU ID username and password to get started.</p><p><a href="http://codex.wordpress.org/Main_Page"><strong>WordPress Codex</strong></a> is the online manual for WordPress and a living repository for WordPress information and documentation.</p>
	<p><a href="http://docs.woothemes.com/document/wooslider/"><strong>WooSlider</strong></a> is a fully responsive content slider and is automatically activated when a WordPress site is created.</p>
	';
}
function add_muroots_dashboard_widget() {
	wp_add_dashboard_widget('muroots_dashboard_widget_coding', 'Marshall University WordPress Resources', 'muroots_dashboard_widget_coding');

// Global the $wp_meta_boxes variable (this will allow us to alter the array)
global $wp_meta_boxes;
// Then we make a backup of your widget
$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
$mu_dashboard_backup = array('muroots_dashboard_widget_coding' => $normal_dashboard['muroots_dashboard_widget_coding']);

// We then unset that part of the array
unset($normal_dashboard['muroots_dashboard_widget_coding']);

// Now we just add your widget back in
	$sorted_dashboard = array_merge( $mu_dashboard_backup, $normal_dashboard );
	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
}
add_action('wp_dashboard_setup', 'add_muroots_dashboard_widget');


// Add features images to pages
if ( function_exists( 'add_theme_support' ) ) { 
add_theme_support( 'post-thumbnails');
set_post_thumbnail_size( 150, 150, true ); // default Post Thumbnail dimensions (cropped)
// additional image sizes
// delete the next line if you do not need additional image sizes
}
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'masthead-image', 1170, 300, true ); //(cropped)
}

function masthead_add_thumbnail(){
if ( has_post_thumbnail() && is_page()) {
echo '<section><p>';
the_post_thumbnail( 'masthead-image', array('class' => 'img-rounded aligncenter'));
echo '</p></section>';
}
}
add_action('masthead_hook','masthead_add_thumbnail');

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

//Functions for modifying the default login pages
function my_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_bloginfo( 'template_directory' ) ?>/images/mulogo.png);
            padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );


function my_login_logo_url() {
    return 'http://www.marshall.edu';
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Marshall University';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

function my_login_stylesheet() { ?>
    <link rel="stylesheet" id="custom_wp_admin_css"  href="<?php echo get_bloginfo( 'stylesheet_directory' ) . '/assets/css/style-login.css'; ?>" type="text/css" media="all" />
<?php }
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );