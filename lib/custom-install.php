<?php

if (is_admin() && isset($_GET['activated']) && 'themes.php' == $GLOBALS['pagenow']) {
  wp_redirect(admin_url('themes.php?page=theme_activation_options'));
  exit;
}

function roots_theme_activation_options_init() {
  if (roots_get_theme_activation_options() === false) {
    add_option('roots_theme_activation_options', roots_get_default_theme_activation_options());
  }

  register_setting(
    'roots_activation_options',
    'roots_theme_activation_options',
    'roots_theme_activation_options_validate'
  );
}

add_action('admin_init', 'roots_theme_activation_options_init');

function roots_activation_options_page_capability($capability) {
  return 'edit_theme_options';
}

add_filter('option_page_capability_roots_activation_options', 'roots_activation_options_page_capability');

function roots_theme_activation_options_add_page() {
  $roots_activation_options = roots_get_theme_activation_options();
  if (!$roots_activation_options['first_run']) {
    $theme_page = add_theme_page(
      __('Theme Activation', 'roots'),
      __('Theme Activation', 'roots'),
      'edit_theme_options',
      'theme_activation_options',
      'roots_theme_activation_options_render_page'
    );
  } else {
    if (is_admin() && isset($_GET['page']) && $_GET['page'] === 'theme_activation_options') {
      global $wp_rewrite;
      $wp_rewrite->flush_rules();
      wp_redirect(admin_url('themes.php'));
      exit;
    }
  }

}

add_action('admin_menu', 'roots_theme_activation_options_add_page', 50);

function roots_get_default_theme_activation_options() {
  $default_theme_activation_options = array(
    'first_run'                       => false,
    'create_navigation_menus'         => false,
    'add_pages_to_primary_navigation' => false,
  );

  return apply_filters('roots_default_theme_activation_options', $default_theme_activation_options);
}

function roots_get_theme_activation_options() {
  return get_option('roots_theme_activation_options', roots_get_default_theme_activation_options());
}

function roots_theme_activation_options_render_page() { ?>

  <div class="wrap">
    <?php screen_icon(); ?>
    <h2><?php printf(__('%s Theme Activation', 'roots'), wp_get_theme() ); ?></h2>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">

      <?php
        settings_fields('roots_activation_options');
        $roots_activation_options = roots_get_theme_activation_options();
        $roots_default_activation_options = roots_get_default_theme_activation_options();
      ?>

      <input type="hidden" value="1" name="roots_theme_activation_options[first_run]" />
      <input type="hidden" value="1" name="roots_theme_activation_options[add_pages_to_primary_navigation]]" />

      <table class="form-table">

       <tr valign="top"><th scope="row"><?php _e('Create navigation menu?', 'roots'); ?></th>
          <td>
            <fieldset><legend class="screen-reader-text"><span><?php _e('Create navigation menu?', 'roots'); ?></span></legend>
              <select name="roots_theme_activation_options[create_navigation_menus]" id="create_navigation_menus">
                <option selected="selected" value="yes"><?php echo _e('Yes', 'roots'); ?></option>
                <option value="no"><?php echo _e('No', 'roots'); ?></option>
              </select>
              <br />
              <small class="description"><?php printf(__('Create the Primary Navigation menu and set the location', 'roots')); ?></small>
            </fieldset>
          </td>
        </tr>
		<tr valign="top"><th scope="row"><?php _e('Add pages to menu?', 'roots'); ?></th>
          <td>
            <fieldset><legend class="screen-reader-text"><span><?php _e('Add pages to menu?', 'roots'); ?></span></legend>
              <select name="roots_theme_activation_options[add_pages_to_primary_navigation]" id="add_pages_to_primary_navigation">
                <option selected="selected" value="yes"><?php echo _e('Yes', 'roots'); ?></option>
                <option value="no"><?php echo _e('No', 'roots'); ?></option>
              </select>
              <br />
              <small class="description"><?php printf(__('Add all current published pages to the Primary Navigation', 'roots')); ?></small>
            </fieldset>
          </td>
        </tr>

      </table>

      <?php submit_button(); ?>
    </form>
  </div>

<?php }

function roots_theme_activation_options_validate($input) {
  $output = $defaults = roots_get_default_theme_activation_options();

  if (isset($input['first_run'])) {
    if ($input['first_run'] === '1') {
      $input['first_run'] = true;
    }
    $output['first_run'] = $input['first_run'];
  }

  if (isset($input['create_navigation_menus'])) {
    if ($input['create_navigation_menus'] === 'yes') {
      $input['create_navigation_menus'] = true;
    }
    if ($input['create_navigation_menus'] === 'no') {
      $input['create_navigation_menus'] = false;
    }
    $output['create_navigation_menus'] = $input['create_navigation_menus'];
  }

  if (isset($input['add_pages_to_primary_navigation'])) {
    if ($input['add_pages_to_primary_navigation'] === 'yes') {
      $input['add_pages_to_primary_navigation'] = true;
    }
    if ($input['add_pages_to_primary_navigation'] === 'no') {
      $input['add_pages_to_primary_navigation'] = false;
    }
    $output['add_pages_to_primary_navigation'] = $input['add_pages_to_primary_navigation'];
  }

  return apply_filters('roots_theme_activation_options_validate', $output, $input, $defaults);
}

function roots_theme_activation_action() {
  $roots_theme_activation_options = roots_get_theme_activation_options();

  if ($roots_theme_activation_options['create_navigation_menus']) {
    $roots_theme_activation_options['create_navigation_menus'] = false;

    $roots_nav_theme_mod = false;
	         if (!has_nav_menu('marshall-menu')) {
                $tertiary_nav_id                            = wp_create_nav_menu('Marshall Menu', array(
                    'slug' => 'marshall-menu'
                ));
                $activation_nav_theme_mod['marshall-menu'] = $tertiary_nav_id;
            }
            if (!has_nav_menu('toolbar')) {
                $secondary_nav_id                    = wp_create_nav_menu('Toolbar', array(
                    'slug' => 'toolbar'
                ));
                $activation_nav_theme_mod['toolbar'] = $secondary_nav_id;
            }
            if (!has_nav_menu('primary_navigation')) {
                $primary_nav_id                                = wp_create_nav_menu('Primary Navigation', array(
                    'slug' => 'primary_navigation'
                ));
                $activation_nav_theme_mod['primary_navigation'] = $primary_nav_id;
            }
            if ($activation_nav_theme_mod) {
                set_theme_mod('nav_menu_locations', $activation_nav_theme_mod);
            }
            
            $secondary_nav         = wp_get_nav_menu_object('Toolbar');
            $primary_nav          = wp_get_nav_menu_object('Primary Navigation');
	        $tertiary_nav           = wp_get_nav_menu_object('Marshall Menu');
            $secondary_nav_term_id = (int) $secondary_nav->term_id;
            $primarys_nav_term_id   = (int) $primary_nav->term_id;
            $tertiary_nav_term_id  = (int) $tertiary_nav->term_id;
            $menu_items            = wp_get_nav_menu_items($primary_nav_term_id);
            $toolbarmenuitems      = wp_get_nav_menu_items($secondary_nav_term_id);
            $tertiarymenuitems     = wp_get_nav_menu_items($tertiary_nav_term_id);
            function getpostidfromslug($custompageid)
            {
                $page = get_page_by_title($custompageid, 'OBJECT', 'nav_menu_item');
                return $page->ID;
            }
            if (!$tertiarymenuitems || empty($tertiarymenuitems)) {
                $tertiarymenuitems = array(
                    $about = array(
                        'long_name' => 'About Marshall',
                        'url' => 'http://www.marshall.edu/landing/about/'
                    ),
                    $admissions = array(
                        'long_name' => 'Future Students',
                        'url' => 'http://www.marshall.edu/landing/futurestudents/'
                    ),
                    $success = array(
                        'long_name' => 'Academics',
                        'url' => 'http://www.marshall.edu/landing/academics/'
                    ),
                    $discover = array(
                        'long_name' => 'Discover MU',
                        'url' => 'http://www.marshall.edu/landing/discover/'
                    ),
                    $community = array(
                        'long_name' => 'Community',
                        'url' => 'http://www.marshall.edu/landing/community/'
                        
                    ),
					 $athletics = array(
                        'long_name' => 'Athletics',
                        'url' => 'http://www.herdzone.com/'
                        
                    ),
                    $innovation = array(
                        'long_name' => 'Research',
                        'url' => 'http://www.marshall.edu/landing/research/'
                        
                    ),
                    $global = array(
                        'long_name' => 'Global',
                        'url' => 'http://www.marshall.edu/landing/global/'
                        
                    )
                );
                foreach ($tertiarymenuitems as $tertiarymenuitem) {
                    $item = array(
                        'menu-item-object' => 'custom',
                        'menu-item-title' => wp_strip_all_tags($tertiarymenuitem[long_name]),
                        'menu-item-type' => 'custom',
                        'menu-item-url' => $tertiarymenuitem[url],
                        'menu-item-status' => 'publish',
                        'menu-item-attr-title' => wp_strip_all_tags($tertiarymenuitem[long_name])
                    );
                    wp_update_nav_menu_item($tertiary_nav_term_id, 0, $item);
                }
            }
            if (!$toolbarmenuitems || empty($toolbarmenuitems)) {
                $toolbarmenuitems = array(
                    $current = array(
                        'long_name' => 'Current Students',
                        'url' => 'http://www.marshall.edu/students/'
                    ),
                    $faculty = array(
                        'long_name' => 'Faculty & Staff',
                        'url' => 'http://www.marshall.edu/facultystaff/'
                    ),
                    $emergency = array(
                        'long_name' => '<i class="icon-emergency"></i> Emergency Info',
                        'url' => 'http://www.marshall.edu/emergency/'
                    ),
                    $mutools = array(
                        'long_name' => 'MU Tools',
                        'url' => 'http://www.marshall.edu/siteindex.asp'
                    )
                    
                );
                foreach ($toolbarmenuitems as $toolbarmenuitem) {
                    $item = array(
                        'menu-item-object' => 'custom',
                        'menu-item-title' => $toolbarmenuitem[long_name],
                        'menu-item-type' => 'custom',
                        'menu-item-url' => $toolbarmenuitem[url],
                        'menu-item-status' => 'publish',
                        'menu-item-attr-title' => wp_strip_all_tags($toolbarmenuitem[long_name])
                    );
                    wp_update_nav_menu_item($secondary_nav_term_id, 0, $item);
                }
                $menuitemschildren = array(
                    $muonline = array(
                        'long_name' => 'MUOnLine',
                        'url' => 'http://www.marshall.edu/muonline'
                        
                    ),
                    $mymu = array(
                        'long_name' => 'MyMU',
                        'url' => 'http://mymu.marshall.edu/'
                        
                    ),
                    $phonedirectory = array(
                        'long_name' => 'Phone Directory',
                        'url' => 'http://www.marshall.edu/phonebook.asp'
                        
                    ),
                    $siteindex = array(
                        'long_name' => 'A-Z Site Index',
                        'url' => 'http://www.marshall.edu/siteindex.asp'
                        
                    ),
                    $cashtrack = array(
                        'long_name' => 'Cash Track',
                        'url' => 'https://epay.marshall.edu/secure/cgi/ebill.cgi'
                        
                    ),
                    $events = array(
                        'long_name' => 'Event Calendar',
                        'url' => 'http://events.marshall.edu/'
                        
                    )					
                );
                foreach ($menuitemschildren as $menuitemschild) {
                    $item = array(
                        'menu-item-object' => 'custom',
                        'menu-item-title' => wp_strip_all_tags($menuitemschild[long_name]),
                        'menu-item-type' => 'custom',
                        'menu-item-url' => $menuitemschild[url],
                        'menu-item-parent-id' => getpostidfromslug('MU Tools'),
                        'menu-item-status' => 'publish',
                        'menu-item-attr-title' => wp_strip_all_tags($menuitemschild[long_name])
                    );
                    wp_update_nav_menu_item($secondary_nav_term_id, 0, $item);
                }
            }
            
        }

  if ($roots_theme_activation_options['add_pages_to_primary_navigation']) {
    $roots_theme_activation_options['add_pages_to_primary_navigation'] = false;
        $primary_nav                                                 = wp_get_nav_menu_object('Primary Navigation');
        $primary_nav_term_id                                         = (int) $primary_nav->term_id;
        $menu_items                                                  = wp_get_nav_menu_items($primary_nav_term_id);
		if (!$menu_items || empty($menu_items)) {		
		    $top_pages = get_pages('parent=0');
            foreach ($top_pages as $top_page) {
                $item = array(
					'menu-item-object-id' => $top_page->ID,
					'menu-item-object' => 'page',
					'menu-item-title' => $top_page->post_title,
          			'menu-item-type' => 'post_type',
                    'menu-item-status' => 'publish',

                );
                wp_update_nav_menu_item($primary_nav_term_id, 0, $item);
            }
			
        }
    }

  update_option('roots_theme_activation_options', $roots_theme_activation_options);
}

add_action('admin_init','roots_theme_activation_action');

function roots_deactivation_action() {
  update_option('roots_theme_activation_options', roots_get_default_theme_activation_options());
}

add_action('switch_theme', 'roots_deactivation_action');