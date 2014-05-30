<?php

add_action('admin_init', 'mu_roots_theme_options_init_fn' );
add_action( 'admin_menu', 'mu_roots_theme_menu');

function mu_roots_theme_menu() {
	add_theme_page( 'MU Roots Theme Options',
	'MU Roots Theme',
	'manage_options',
	'mu_roots_theme',
	'mu_roots_theme_options' );

}
function mu_roots_theme_options_init_fn(){
	add_settings_field('mu_roots_mission_textarea',
		'Mission Input',
		'mu_roots_mission_fn',
		'mu_roots_theme',
		'default');
	add_settings_field('mu_roots_overseer_email',
		'Site Overseer',
		'mu_roots_overseer_fn',
		'mu_roots_theme',
		'default');
	add_settings_field('mu_roots_mission_url_drop',
		'Mission Page',
		'mu_roots_page_fn',
		'mu_roots_theme',
		'default');
	add_settings_field('mu_roots_css',
		'Custom CSS',
		'mu_roots_css_fn',
		'mu_roots_super',
		'default');
	add_settings_field('mu_roots_js',
		'Custom JS',
		'mu_roots_js_fn',
		'mu_roots_super',
		'default');
	register_setting('mu_roots_theme_options',
		'mu_roots_theme_options',
		'mu_roots_options_validate' );
}
function mu_roots_mission_fn() {
	$options = get_option('mu_roots_theme_options');
	echo "<textarea id='mu_roots_mission_textarea' name='mu_roots_theme_options[mu_roots_mission_textarea]' rows='4' cols='40'>{$options['mu_roots_mission_textarea']}</textarea>";
}
function mu_roots_css() {
	$options = get_option('mu_roots_theme_options');
	echo "<textarea id='mu_roots_css' name='mu_roots_theme_options[mu_roots_css]' rows='4' cols='40'>" . mu_roots_get_options('css') . "</textarea>";
}
function mu_roots_js() {
	$options = get_option('mu_roots_theme_options');
	echo "<textarea id='mu_roots_js' name='mu_roots_theme_options[mu_roots_js]' rows='4' cols='40'>" . mu_roots_get_options('js') . "</textarea>";
}

function mu_roots_page_fn() { 
	$options = get_option('mu_roots_theme_options');
	echo "<select id='mu_roots_mission_url_drop' name='mu_roots_theme_options[mu_roots_mission_url_drop]'>";
  	echo "<option value='{$options['mu_roots_mission_url_drop']}'>--</option>";
	echo "<option value=''>None</option>";

	$pages = get_pages();
  		foreach ( $pages as $page ) {
  		$href = get_page_link($page->ID);
		$option = '<option value="' . get_page_link( $page->ID ) . '" name="mu_roots_theme_options[' . $page->post_title . ']">' . $page->post_title . '</option>';
		echo $option;
  }
 		echo "</select>" ;
}
function mu_roots_overseer_fn() {
	$options = get_option('mu_roots_theme_options');
	echo "<input id='mu_roots_overseer_email' name='mu_roots_theme_options[mu_roots_overseer_email]' type='text' maxlength='40' value='{$options['mu_roots_overseer_email'] }'>";
}

function current_mission() {
	 if (mu_roots_get_options('mission_url_page') != '')  {
	 	return mu_roots_get_options('mission_url_page');
	 }
	elseif (mu_roots_get_options('mission_url') != '') {
		return mu_roots_get_options('mission_url');
	}
	else {
		
	}
	
}
function mu_roots_theme_options() {
	if ( !current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have succifient permissions to access this page.' ) );
	}
	 ?>

<div class="wrap">
	<div id="icon-options-general" class="icon32"><br />
	</div>
	<h2>MU Roots General Theme Options</h2>
	<form action="options.php" method="post">
		<?php settings_fields('mu_roots_theme_options'); ?>
		<p class="submit">
		<table class="form-table">
			<tbody>
				<tr valign='top'>
					<th scope='row'><label for='mu_roots_mission_textarea'>Mission:</label></th>
					<td><?php echo mu_roots_mission_fn(); ?></td>
				</tr>
				<tr valign='top'>
					<th scope='row'>Expanded Mission Statement<br />
					</th>
					<td><label for='mu_roots_mission_url_drop'>Choose from a List of Pages:</label>
						<?php echo mu_roots_page_fn(); ?>
						</td>
				</tr>
				<tr valign='top'>
					<th scope='row'>Current Expanded Mission Statement URL:</th>
					<td><?php echo current_mission(); ?></td>
				</tr>
				<tr valign='top'>
					<th scope='row'><label for='mu_roots_overseer_email'>Designated Overseer:</label></th>
					<td><?php echo mu_roots_overseer_fn(); ?></td>
				</tr>
			</tbody>
		</table>
		<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
	</form>
	</p>
       
</div>
<?php 


}


// Validate user data for some/all of your input fields
function mu_roots_options_validate($input) {
	// Check our textbox option field contains no HTML tags - if so strip them out
	$input['mu_roots_mission_textarea'] =  wp_filter_nohtml_kses($input['mu_roots_mission_textarea']);	
	$input['mu_roots_overseer_email'] = wp_filter_nohtml_kses($input['mu_roots_overseer_email']);
	$input['mu_roots_mission_url_drop'] = wp_filter_nohtml_kses($input['mu_roots_mission_url_drop']);
	$input['mu_roots_css'] =  wp_filter_nohtml_kses($input['mu_roots_css']);	

	return $input; // return validated input
}
$mu_roots_expanded_options = array();
$expanded_options = get_option( 'mu_roots_theme_options' );
$mu_roots_expanded_options['css'] = $expanded_options['mu_roots_css'];
$mu_roots_expanded_options['js'] = $expanded_options['mu_roots_js'];
$mu_roots_expanded_options['overseer_email'] = $expanded_options['mu_roots_overseer_email'];
$mu_roots_expanded_options['mission'] = $expanded_options['mu_roots_mission_textarea'];
$mu_roots_expanded_options['mission_url'] = $expanded_options['mu_roots_mission_url'];
$mu_roots_expanded_options['mission_url_page'] = $expanded_options['mu_roots_mission_url_drop'];

function mu_roots_get_options($key)
{
	global $mu_roots_expanded_options;
	return (isset($mu_roots_expanded_options[$key])) ? $mu_roots_expanded_options[$key] : '';	
}
function hero_box() {
	 if ( mu_roots_get_options('mission') != '' && is_front_page() )  {
  echo '<hr />
      <p>' . mu_roots_get_options('mission');
if (current_mission() != ''){
		echo '<a class="btn btn-small btn-primary pull-right" href="'. current_mission() .'">Read More</a>'; 
	  }
	  	  echo '</p>';
  }
}
add_action ( 'hero_unit_hook', 'hero_box', 11);
?>
<?php 
//mu_roots Super Admin Theme Options Page 
//add_action('admin_init', 'mu_roots_super_options_init_fn' );

add_action( 'admin_menu', 'mu_roots_admin_menu');

function mu_roots_admin_menu() {
add_theme_page( 'MU Roots Theme Super Admin',
	'MU Roots Super Admin',
	'manage_options',
	'mu_roots_super',
	'mu_roots_super_admin_options' );
}

function mu_roots_super_admin_options() {
	if ( !current_user_can( 'manage_network' ) ) {
			wp_die( __( 'You do not have succifient permissions to access this page.' ) );
	}
	?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br />
	</div>
	<h2>MU Roots Super Admin Options</h2>
<form action="options.php" method="post">
			<?php settings_fields('mu_roots_theme_options'); ?>
		<p class="submit">
		<table class="form-table">
			<tbody>
				<tr>
                <td colspan="2">
                <p><strong>To add custom css, simply include the css code without the style tags--this code will automatically be wrapped in the appropriate tags and placed in the header.</strong></p>
                </td>
                </tr>
                <tr valign='top'>
					<th scope='row'><label for='mu_roots_css_hook'>Custom CSS:</label></th>
					<td><?php echo mu_roots_css(); ?></td></tr>
				</tr>
                  <tr>
                <td colspan="2">
                <hr />
                </td>
                </tr>
                <tr>
                <td colspan="2">
                <p><strong>To add custom js, simply include the js code without the script tags--this code will automatically be wrapped in a no-conflict function and placed in the header.</strong></p>
                </td>
                </tr>
                <tr valign='top'>
					<th scope='row'><label for='mu_roots_js_hook'>Custom JS:</label></th>
					<td><?php echo mu_roots_js(); ?></td></tr>
				</tr>
			</tbody>
		</table>
		<br />
		<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
	</form>
	</p>
</div>
<?php
}

?>
<?php
	function custom_css_init() {
		$css_options = mu_roots_get_options('css');
		if($css_options != '') {
			echo '<style type="text/css">';
			echo $css_options;
			echo '</style>';
		}
	}
add_action ( 'wp_head',  'custom_css_init', 10);
	function custom_js_init() {
		$js_options = mu_roots_get_options('js');
		if($js_options != '') {
			echo '<script type="text/javascript">
			(function($) {
';
			echo $js_options;
			echo '})(jQuery);</script>';
		}
	}
add_action ( 'wp_head',  'custom_js_init', 10);
	?>
