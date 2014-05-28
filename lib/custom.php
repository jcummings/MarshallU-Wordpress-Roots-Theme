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
add_action( 'admin_menu', 'remove_menu_pages' );
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
	<table>
		<tr>
		<td>
		<img src="'.get_stylesheet_directory_uri().'/assets/img/med-logo.png" /></td>
		<td>
	<p><a href="http://www.marshall.edu/webguide"><strong>Online Branding Standards and Resources</strong></a> provides Marshall University content creators with guidance on appropriate use of the Marshall University brand online.</p></td>
	</tr></table>
	
	<p><a href="http://twitter.github.com/bootstrap/"><strong>Bootstrap</strong></a> is a simple and flexible front-end framework for popular user interface components and interactions. <strong>It is also the toolkit on which the Marshall University websites are built upon.</strong></p>

	<p><a href="http://www.marshall.edu/lynda/"><strong>Lynda.com</strong></a> has an extensive collection of WordPress Tutorials designed for users of all experience levels. Simply log in with your MU ID username and password to get started.</p><p><a href="http://codex.wordpress.org/Main_Page"><strong>WordPress Codex</strong></a> is the online manual for WordPress and a living repository for WordPress information and documentation.</p><p><a href="http://docs.woothemes.com/document/wooslider/"><strong>WooSlider</strong></a> is a fully responsive content slider and is automatically activated when a WordPress site is created.</p>
	';
}
function add_muroots_dashboard_widget() {
	wp_add_dashboard_widget('muroots_dashboard_widget_coding', 'Marshall University Site Development Resources', 'muroots_dashboard_widget_coding');

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


add_filter( 'vfb_skip_empty_fields', 'vfb_filter_skip_empty_fields', 10, 2 );
function vfb_filter_skip_empty_fields( $setting, $form_id ){    
    return true;
}

function my_admin_theme_style() {
    wp_enqueue_style('my-admin-style', get_template_directory_uri() . '/assets/css/admin.css');
}

add_action('admin_enqueue_scripts', 'my_admin_theme_style');


// Custom admin dashboard header logo
add_action('admin_head', 'rvam_custom_admin_logo');
function rvam_custom_admin_logo() {
    echo '<style type="text/css">#icon-index { background-image: url('.get_template_directory_uri() .'/assets/img/custom-logo.png) !important; background-position: 0 0;}</style>';
}

// Modify the admin footer text
add_filter('admin_footer_text', 'rvam_modify_footer_admin');
function rvam_modify_footer_admin ()
{
    echo '<span id="footer-thankyou">Marshall University <a href="http://www.marshall.edu" target="_blank">Information Technology</a></span>';
}

// Add theme info box into WordPress Dashboard
add_action('wp_dashboard_setup', 'rvam_add_dashboard_widgets' );
function rvam_add_dashboard_widgets() {
    add_meta_box('wp_dashboard_widget', 'Theme Details', 'rvam_theme_info', 'dashboard', 'side', 'high');    
}
 
function rvam_theme_info() {
    echo "<ul>
	<li><strong>Developed By:</strong> John Cummings and Eden Parker</li>
	<li><strong>Website:</strong> <a href='http://www.marshall.edu'>www.marshall.edu</a></li>
	<li><strong>Contact:</strong> <a href='mailto:cumming7@marshall.edu'>john.cummings@marshall.edu</a></li>
	</ul>
	<hr/>
	<h4>Frequently Asked Questions about our theme</h4>
	<br/>
	<strong>Where is the Plugin and Theme Menu?</strong>
		<blockquote>
		  <p>Because there are several hundred sites in our system that share a variety of elements of the codebase, shared settings like plugins and themes are disabled for individual site administrators.  Don't worry though, there are a lot of popular plugins already installed and available, and getting a new one added for your site usually just requires an email to the service desk asking that we turn it on for you.</p><p>Theme installation and switching is disabled because....well, that was really the point of implementing a content management system.  It allows everyone to share common design elements so that there is some consistency throughout the MU website.</p>
		</blockquote>
		
		<hr/>
		<strong>How do I add a new user/change my password/edit my user profile/access the Users menu/etc.?</strong>
		<blockquote>
		  <p>The local account database is only used to match your username with the sites that you have access to.  All user information, including who has access to edit your site, is controlled by membership in various Active Directory groups.  All of our user authentication is also done via Active Directory, which is what enables you to access your site using your MUNET credentials.</p>
		<p>Even if the 'Users' menu were accessible, attempting to add users in this way would have no effect on their ability to access your site.  Users who need administrative access to a content management system site do need to make sure that their user account is in the right Active Directory group.  If you're not sure how to get this change made, just email the IT Service Desk, and they can open a ticket to have any user membership changes you need done for you.</p>
		</blockquote>
		
		<hr/>
		<strong>I really don't like the way that this color/menu/button/font/etc. looks. Is there any way I can change it?</strong>
		<blockquote>
		  <p>We do discourage individual sites from trying to develop their own 'look'.  While we understand each departments desire for a unique identity, our site template are designed with consistency for the end user in mind.  In addition, things like colors, font sizes, background gradients, and line spacing have been developed in accordance with accessibility guidelines, and all of the pages that are created through our system are immediately smart phone and tablet capable.  When you create a page, it will look similar regardless of the device a user is using to access it.</p><p>We offer full support for our official theme - if something goes wrong, we'll make sure to fix it as quickly as possible. While we will try to work with requests for custom theme/template development, anything beyond basic modifications will require discussion with the department so that the project can be scoped, appropriate resources allocated, and budgeted.</p>
		</blockquote>";
}

//Disable the user profile menu
add_action( 'admin_menu', 'stop_access_profile' );
function stop_access_profile() {
    remove_menu_page( 'profile.php' );
    remove_submenu_page( 'users.php', 'profile.php' );
    if(IS_PROFILE_PAGE === true) {
        header( 'Location: http://www.marshall.edu/editing-user-information/' ) ;
    }
}

//Change the upload folder by default
update_option('uploads_use_yearmonth_folders', 0);
	if (!is_multisite()) {
		update_option('upload_path', 'media');
	} 
	else {
	    update_option('upload_path', '');
	}

//Customize the Wordpress Admin Bar
function remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
    $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    //$wp_admin_bar->remove_menu('my-account');       // Remove the user details tab
    
    $wp_admin_bar->add_menu(array(
    	'parent'=>false,
    	'id'=>'get_help',
    	'title'=>__('Need help?'),
    	'href'=>''
    ));

	$serviceDeskURL = 'http://www.marshall.edu/inforesources/';
	$wp_admin_bar->add_menu(array(
	'parent' => 'get_help',
	'id' => 'service_desk',
	'title' => __('Contact the IT Service Desk'),
	'href' => $serviceDeskURL
	));
	
	$lyndaURL = 'http://lynda.marshall.edu';
	$wp_admin_bar->add_menu(array(
	'parent' => 'get_help',
	'id' => 'lynda_help',
	'title' => __('Lynda.com via lynda.marshall.edu'),
	'href' => $lyndaURL
	));	
	
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );



