<?php
if (!function_exists('redux_init')):
	function redux_init() {

		$args = array();

		// For use with a tab example below
		$tabs = array();

		ob_start();

		$ct = wp_get_theme();
		$theme_data = $ct;
		$item_name = $theme_data->get('Name');
		$tags = $ct->Tags;
		$screenshot = $ct->get_screenshot();
		$class = $screenshot ? 'has-screenshot' : '';

		$customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'redux-framework-demo'), $ct->display('Name'));

		?>
		<div id="current-theme" class="<?php echo esc_attr($class);?>">
	<?php if ($screenshot):?>
				<?php if (current_user_can('edit_theme_options')):?>
				<a href="<?php echo wp_customize_url();?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title);?>">
					<img src="<?php echo esc_url($screenshot);?>" alt="<?php esc_attr_e('Current theme preview');?>" />
				</a>
	<?php endif;?>
			<img class="hide-if-customize" src="<?php echo esc_url($screenshot);?>" alt="<?php esc_attr_e('Current theme preview');?>" />
<?php endif;?>
<h4>
<?php echo $ct->display('Name');?>
		</h4>

		<div>
			<ul class="theme-info">
				<li><?php printf(__('By %s', 'redux-framework-demo'), $ct->display('Author'));?></li>
				<li><?php printf(__('Version %s', 'redux-framework-demo'), $ct->display('Version'));?></li>
				<li><?php echo '<strong>' . __('Tags', 'redux-framework-demo') . ':</strong> ';?><?php printf($ct->display('Tags'));?></li>
			</ul>
			<p class="theme-description"><?php echo $ct->display('Description');?></p>
<?php if ($ct->parent()) {
		printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>',
			__('http://codex.wordpress.org/Child_Themes', 'redux-framework-demo'),
			$ct->parent()->display('Name'));
	}?>
</div>

	</div>

<?php
$item_info = ob_get_contents();

	ob_end_clean();

	$sampleHTML = '';
	if (file_exists(dirname(__FILE__) . '/info-html.html')) {
		/** @global WP_Filesystem_Direct $wp_filesystem  */
		global $wp_filesystem;
		if (empty($wp_filesystem)) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}
		$sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
	}

	// BEGIN Sample Config

	// Setting dev mode to true allows you to view the class settings/info in the panel.
	// Default: true
	$args['dev_mode'] = false;

	// Set the icon for the dev mode tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: info-sign
	//$args['dev_mode_icon'] = 'info-sign';

	// Set the class for the dev mode tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	//$args['dev_mode_icon_class'] = '';

	// Set a custom option name. Don't forget to replace spaces with underscores!
	$args['opt_name'] = 'mk_settings';

	// Setting system info to true allows you to view info useful for debugging.
	// Default: false
	$args['system_info'] = true;

	// Set the icon for the system info tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: info-sign
	//$args['system_info_icon'] = 'info-sign';

	// Set the class for the system info tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	//$args['system_info_icon_class'] = 'icon-large';

	$theme = wp_get_theme();

	$args['display_name'] = $theme->get('Name');
	//$args['database'] = "theme_mods_expanded";
	$args['display_version'] = $theme->get('Version');

	// If you want to use Google Webfonts, you MUST define the api key.
	$args['google_api_key'] = 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII';

	// Define the starting tab for the option panel.
	// Default: '0';
	//$args['last_tab'] = '0';

	// Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
	// If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
	// If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
	// Default: 'standard'
	//$args['admin_stylesheet'] = 'standard';

	// Setup custom links in the footer for share icons

	// Enable the import/export feature.
	// Default: true
	//$args['show_import_export'] = false;

	// Set the icon for the import/export tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: refresh
	//$args['import_icon'] = 'refresh';

	// Set the class for the import/export tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	//$args['import_icon_class'] = '';

	/**
	 * Set default icon class for all sections and tabs
	 * @since 3.0.9
	 */
	//$args['default_icon_class'] = '';

	// Set a custom menu icon.
	//$args['menu_icon'] = '';

	// Set a custom title for the options page.
	// Default: Options
	$args['menu_title'] = __('Theme Settings', 'mk_framework');

	// Set a custom page title for the options page.
	// Default: Options
	$args['page_title'] = __('Theme Settings', 'mk_framework');

	// Set a custom page slug for options page (wp-admin/themes.php?page=***).
	// Default: redux_options
	$args['page_slug'] = 'theme_settings';

	//$args['default_show'] = false;
	//$args['default_mark'] = '*';

	// Set a custom page capability.
	// Default: manage_options
	//$args['page_cap'] = 'manage_options';

	// Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
	// Default: menu
	//$args['page_type'] = 'submenu';

	// Set the parent menu.
	// Default: themes.php
	// A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	//$args['page_parent'] = 'options-general.php';

	// Set a custom page location. This allows you to place your menu where you want in the menu order.
	// Must be unique or it will override other items!
	// Default: null
	//$args['page_position'] = null;

	// Set a custom page icon class (used to override the page icon next to heading)
	//$args['page_icon'] = 'icon-themes';

	// Set the icon type. Set to "iconfont" for Elusive Icon, or "image" for traditional.
	// Redux no longer ships with standard icons!
	// Default: iconfont
	//$args['icon_type'] = 'image';

	// Disable the panel sections showing as submenu items.
	// Default: true
	//$args['allow_sub_menu'] = false;

	// Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
	/*$args['help_tabs'][] = array(
	'id' => 'redux-opts-1',
	'title' => __('Theme Information 1', 'redux-framework-demo'),
	'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
	);
	$args['help_tabs'][] = array(
	'id' => 'redux-opts-2',
	'title' => __('Theme Information 2', 'redux-framework-demo'),
	'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
	);*/

	// Set the help sidebar for the options page.
	//$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo');

	// Add HTML before the form.
	/*if (!isset($args['global_variable']) || $args['global_variable'] !== false ) {
	if (!empty($args['global_variable'])) {
	$v = $args['global_variable'];
	} else {
	$v = str_replace("-", "_", $args['opt_name']);
	}
	$args['intro_text'] = sprintf( __('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'redux-framework-demo' ), $v );
	} else {
	$args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-demo');
	}*/

	// Add content after the form.
	//$args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'redux-framework-demo');

	// Set footer/credit line.
	//$args['footer_credit'] = __('<p>This text is displayed in the options panel footer across from the WordPress version (where it normally says \'Thank you for creating with WordPress\'). This field accepts all HTML.</p>', 'redux-framework-demo');

	$sections[] = array(
		'title' => __('General Settings', 'redux-framework-demo'),
		'desc' => __('', 'redux-framework-demo'),
		'icon' => 'el-icon-globe-alt',
		// 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
		'fields' => array(

			array(
				'id' => 'favicon',
				'type' => 'media',
				'url' => true,
				'title' => __('Upload Favicon', 'redux-framework-demo'),
				'mode' => false,
				'desc' => __('Using this option, You can upload your own custom favicon. This size should be 16X16 but if you want to support retina devices upload 32X32 png file.', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'default' => false,
			),
			array(
				'id' => 'logo',
				'type' => 'media',
				'url' => true,
				'title' => __('Upload Logo', 'redux-framework-demo'),
				'mode' => false,
				'desc' => __('', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'default' => false,
			),

			array(
				'id' => 'logo-retina',
				'type' => 'media',
				'url' => true,
				'title' => __('Upload Retina Logo', 'redux-framework-demo'),
				'mode' => false,
				'desc' => __('Please note that the image you are uploading should be exactly 2x size of the original logo you have uploaded in above option.', 'redux-framework-demo'),
				'subtitle' => __('Use this option if you want your logo appear crystal clean in retina devices(eg. macbook retina, ipad, iphone).', 'redux-framework-demo'),
				'default' => false,
			),

			array(
				'id' => 'logo-light',
				'type' => 'media',
				'url' => true,
				'title' => __('Upload Light Logo', 'redux-framework-demo'),
				'mode' => false,
				'desc' => __('', 'redux-framework-demo'),
				'subtitle' => __('This option will only be used if you have a transparent header in a page that you have chosen light skin for header elements.', 'redux-framework-demo'),
				'default' => false,
			),

			array(
				'id' => 'logo-light-retina',
				'type' => 'media',
				'url' => true,
				'title' => __('Upload Retina Light Logo', 'redux-framework-demo'),
				'mode' => false,
				'desc' => __('This option is for transparent header style logo in light skin. Please note that the image you are uploading should be exactly 2x size of the original logo you have uploaded in above option.', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'default' => false,
			),

			array(
				'id' => 'preloader-logo',
				'type' => 'media',
				'url' => true,
				'title' => __('Pre-loader Overlay Logo', 'redux-framework-demo'),
				'mode' => false,
				'desc' => __('This logo will be viewed in the pre-loader overlay. This overlay can be enabled form page meta option and mostly used for heavy pages with alot of content and images.', 'redux-framework-demo'),
				'subtitle' => __('Image size is up to you.', 'redux-framework-demo'),
				'default' => false,
			),

			array(
				'id' => 'mobile-logo',
				'type' => 'media',
				'url' => true,
				'title' => __('Upload Mobile Logo', 'redux-framework-demo'),
				'mode' => false,
				'subtitle' => __('This option comes handly when your logo is just too long for a mobile device and you would like to upload a shorter and smaller logo just to fit the header area.', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				'default' => false,
			),

			array(
				'id' => 'mobile-logo-retina',
				'type' => 'media',
				'url' => true,
				'title' => __('Upload Mobile Retina Logo', 'redux-framework-demo'),
				'mode' => false,
				'desc' => __('Please note that the image you are uploading should be exactly 2x size of the original logo you have uploaded in above option (Upload Mobile Logo).', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'default' => false,
			),

			array(
				'id' => 'res-nav-width',
				'type' => 'slider',
				'title' => __('Main Navigation Responsive Width', 'redux-framework-demo'),
				'subtitle' => __('The width Main navigation converts to responsive mode.', 'redux-framework-demo'),
				'desc' => __('Navigation item can vary from site to site and it totally depends on you to define a the best width Main Navigation convert to responsive mode. you can find the right value by just resizing the window to find the best fit coresponding to navigation items.', 'redux-framework-demo'),
				"default" => "1140",
				"min" => "600",
				"step" => "1",
				"max" => "1380",
			),
			array(
				'id' => 'grid-width',
				'type' => 'slider',
				'title' => __('Main grid Width', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				"default" => "1140",
				"min" => "960",
				"step" => "1",
				"max" => "1380",
			),
			array(
				'id' => 'content-width',
				'type' => 'slider',
				'title' => __('Content Width', 'redux-framework-demo'),
				'subtitle' => __('Using this option you can define the width of the content.', 'redux-framework-demo'),
				'desc' => __('please note that this option is in percent, lets say if you set it 60%, sidebar will occupy 40% of the main content space.', 'redux-framework-demo'),
				"default" => "70",
				"min" => "50",
				"step" => "1",
				"max" => "80",
			),
			array(
				'id' => 'side-dashboard',
				'type' => 'switch',
				'title' => __('Side Dashboard', 'redux-framework-demo'),
				'subtitle' => __('The sliding widgetized dashboard section.', 'redux-framework-demo'),
				'desc' => __('If you don\'t want this feature just disable it from this option.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'side-dashboard-icon',
				'type' => 'text',
				'title' => __('Side Dashboard Icon Class Name', 'redux-framework-demo'),
				'desc' => __("This option will give you the ability to add any icon you want to use for side dashboard trigger icon. <a target='_blank' href='" . admin_url('tools.php?page=icon-library') . "'>Click here</a> to get the icon class name.", 'redux-framework-demo'),
				'subtitle' => __("", 'redux-framework-demo'),
				'default' => '',
			),
			array(
				'id' => 'breadcrumb',
				'type' => 'switch',
				'title' => __('Breadcrumb', 'redux-framework-demo'),
				'subtitle' => __('Breadcrumbs will appear horizontally across the top of all pages below header.', 'redux-framework-demo'),
				'desc' => __('Using this option you can disable breadcrumbs throughout the site.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'smooth-scroll',
				'type' => 'switch',
				'title' => __('Smooth Scroll', 'redux-framework-demo'),
				'subtitle' => __('Adds easing movement in page scroll and modifys browser native scrollbar', 'redux-framework-demo'),
				'desc' => __('If you don\'t want this feature just disable it from this option.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'pages-comments',
				'type' => 'switch',
				'title' => __('Page Comments', 'redux-framework-demo'),
				'subtitle' => __('Option to globally enable/disable comments in pages.', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				"default" => 0,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'custom-sidebar',
				'type' => 'multi_text',
				'title' => __('Custom Sidebars', 'redux-framework-demo'),
				'validate' => 'no_special_chars',
				'subtitle' => __('Will create custom widget areas to help you make custom sidebars in pages & posts.', 'redux-framework-demo'),
				'desc' => __('No Special characters please! eg: "contact page 3"', 'redux-framework-demo')
			),
			array(
				'id' => 'typekit-id',
				'type' => 'text',
				'title' => __('Typekit Kit ID', 'redux-framework-demo'),
				'desc' => __("If you want to use typekit in your site simply enter The Type Kit ID you get from Typekit site. <a target='_blank' href='http://help.typekit.com/customer/portal/articles/6840-using-typekit-with-wordpress-com'>Read More</a>", 'redux-framework-demo'),
				'subtitle' => __("", 'redux-framework-demo'),
				'default' => '',
			),
			array(
				'id' => 'disable-quick-contact',
				'type' => 'switch',
				'title' => __('Quick Contact', 'redux-framework-demo'),
				'subtitle' => __('You can enable or disable Quick Contact Form using this option.', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				"default" => 0,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'skin-quick-contact',
				'type' => 'switch',
				'title' => __('Quick Contact Skin', 'redux-framework-demo'),
				'subtitle' => __('You can choose Quick Contact Form skin color.', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				"default" => 0,
				'on' => 'Light',
				'off' => 'Dark',
			),
		),
	);

	$sections[] = array(
		'title' => __('Header', 'redux-framework-demo'),
		'desc' => __('', 'redux-framework-demo'),
		'icon' => 'el-icon-website',
		// 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
		'fields' => array(
			array(
				'id' => 'header-structure',
				'type' => 'button_set',
				'title' => __('Header Structure', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				'options' => array('standard' => 'Standard', 'margin' => 'Margin', 'vertical' => 'Vertical'), //Must provide key => value pairs for radio options
				'default' => 'standard',
			),

			array(
				'id' => 'header-location',
				'type' => 'button_set',
				'required' => array('header-structure', 'equals', 'standard'),
				'title' => __('Header Location', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'desc' => __('Whether stay at the top or bottom of the screen.', 'redux-framework-demo'),
				'options' => array('top' => 'Top', 'bottom' => 'Bottom'), //Must provide key => value pairs for radio options
				'default' => 'top'
			),

			array(
				'id' => 'vertical-header-state',
				'type' => 'button_set',
				'required' => array('header-structure', 'equals', 'vertical'),
				'title' => __('Vertical Header State', 'redux-framework-demo'),
				'subtitle' => __('Choose vertical header defaut state.', 'redux-framework-demo'),
				'desc' => __('If condensed header chosen, header will be narrow by default and by clicking burger icon it will be expanded to reveal logo and navigation.', 'redux-framework-demo'),
				'options' => array('condensed' => 'Expandable', 'expanded' => 'Always Open'), //Must provide key => value pairs for radio options
				'default' => 'expanded'
			),
			array(
				'id' => 'header-vertical-width',
				'type' => 'slider',
				'required' => array('header-structure', 'equals', 'vertical'),
				'title' => __('Header Vertical Width?', 'redux-framework-demo'),
				'subtitle' => __('Default : 280px', 'redux-framework-demo'),
				'desc' => __('Using this option you can increase or decrease header width.', 'redux-framework-demo'),
				"default" => "280",
				"min" => "200",
				"step" => "1",
				"max" => "500",
			),
			array(
				'id' => 'header-padding',
				'type' => 'slider',
				'title' => __('Header Padding', 'redux-framework-demo'),
				'subtitle' => __('Top & Bottom. default : 30px', 'redux-framework-demo'),
				'desc' => __('Using this option you can increase or decrease header padding from its top and bottom.', 'redux-framework-demo'),
				"default" => "30",
				"min" => "0",
				"step" => "1",
				"max" => "200",
			),
			array(
				'id' => 'header-padding-vertical',
				'type' => 'slider',
				'required' => array('header-structure', 'equals', 'vertical'),
				'title' => __('Header Padding', 'redux-framework-demo'),
				'subtitle' => __('Left & Right. default : 30px', 'redux-framework-demo'),
				'desc' => __('Using this option you can increase or decrease header padding from its top and bottom.', 'redux-framework-demo'),
				"default" => "30",
				"min" => "0",
				"step" => "1",
				"max" => "100",
			),
			array(
				'id' => 'header-align',
				'type' => 'button_set',
				'title' => __('Header Align', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'desc' => __('Please note that this option does not work for vertical header style. Use below option instead', 'redux-framework-demo'),
				'options' => array('left' => 'Left', 'center' => 'Center', 'right' => 'Right'), //Must provide key => value pairs for radio options
				'default' => 'left'
			),
			array(
				'id' => 'nav-alignment', 
				'type' => 'button_set',
				'title' => __('Vertical Header Menu Align', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				'options' => array('left' => 'Left', 'center' => 'Center', 'right' => 'Right'), 
				'default' => 'left',
			),
			array(
				'id' => 'boxed-header',
				'type' => 'switch',
				'title' => __('Boxed Header', 'redux-framework-demo'),
				'subtitle' => __('Full screen wide header content or inside main grid?.', 'redux-framework-demo'),
				'desc' => __('If you want the cotent be stretched screen wide, disable this option.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'sticky-header',
				'type' => 'switch',
				'title' => __('Sticky Header', 'redux-framework-demo'),
				'subtitle' => __('Will make header stay in top of browser while scrolling down', 'redux-framework-demo'),
				'desc' => __('If you don\'t want this feature just disable it from this option.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'squeeze-sticky-header',
				'type' => 'switch',
				'title' => __('Squeeze Sticky Header', 'redux-framework-demo'),
				'subtitle' => __('This option to give you the control on whether to squeeze the sticky header or keep it same height as none-sticky.', 'redux-framework-demo'),
				'desc' => __('Disable this option if you dont want this feature.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'header-border-top',
				'type' => 'switch',
				'title' => __('Show Header Border Top?', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'header-search',
				'type' => 'switch',
				'title' => __('Header Search Form', 'redux-framework-demo'),
				'subtitle' => __('Will stay on right hand of main navigation.', 'redux-framework-demo'),
				'desc' => __('If you don\'t want this feature just disable it from this option.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'header-wpml',
				'type' => 'switch',
				'title' => __('Header Wpml Language Selector', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'desc' => __('If you don\'t want this feature just disable it from this option.', 'redux-framework-demo'),
				"default" => 2,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'page-title-pages',
				'type' => 'switch',
				'title' => __('Page Title : Pages', 'redux-framework-demo'),
				'subtitle' => __('This option will affect Pages.', 'redux-framework-demo'),
				'desc' => __('If you don\'t want to show page title section (title, breadcrumb) in Pages disable this option. this option will not affect archive, search, 404, category templates as well as blog and portfolio single posts.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				"title" => __("Main Navigation for Logged In User", "mk_framework"),
				"desc" => __("Please choose the menu location that you would like to show as global main navigation for logged in users. You should first <a target='_blank' href='" . admin_url('nav-menus.php') . "'>create menu</a> and then <a target='_blank' href='" . admin_url('nav-menus.php') . "?action=locations'>assign to menu locations</a>", "mk_framework"),
				"id" => "loggedin_menu",
				"default" => 'primary-menu',
				"options" => array(
					"primary-menu" => __('Primary Navigation', "mk_framework"),
					"second-menu" => __('Second Navigation', "mk_framework"),
					"third-menu" => __('Third Navigation', "mk_framework"),
					"fourth-menu" => __('Fourth Navigation', "mk_framework"),
					"fifth-menu" => __('Fifth Navigation', "mk_framework"),
					"sixth-menu" => __('Sixth Navigation', "mk_framework"),
					"seventh-menu" => __('Seventh Navigation', "mk_framework"),
				),
				"type" => "select"
			),
			array(
				'id' => 'header-social',
				'type' => 'switch',
				'title' => __('Header Social Networks', 'redux-framework-demo'),
				'subtitle' => __('Enable/Disable Header Social networks', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'header-social-facebook',
				'required' => array('header-social', 'equals', '1'),
				'type' => 'text',
				'title' => __('Facebook', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Header Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'header-social-twitter',
				'required' => array('header-social', 'equals', '1'),
				'type' => 'text',
				'title' => __('Twitter', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Header Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'header-social-rss',
				'required' => array('header-social', 'equals', '1'),
				'type' => 'text',
				'title' => __('RSS', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Header Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'header-social-dribbble',
				'required' => array('header-social', 'equals', '1'),
				'type' => 'text',
				'title' => __('Dribbble', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Header Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'header-social-pinterest',
				'required' => array('header-social', 'equals', '1'),
				'type' => 'text',
				'title' => __('Pinterest', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Header Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'header-social-instagram',
				'required' => array('header-social', 'equals', '1'),
				'type' => 'text',
				'title' => __('Instagram', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Header Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'header-social-google-plus',
				'required' => array('header-social', 'equals', '1'),
				'type' => 'text',
				'title' => __('Google Plus', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Header Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'header-social-linkedin',
				'required' => array('header-social', 'equals', '1'),
				'type' => 'text',
				'title' => __('Linkedin', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Header Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'header-social-youtube',
				'required' => array('header-social', 'equals', '1'),
				'type' => 'text',
				'title' => __('Youtube', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Header Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'header-social-tumblr',
				'required' => array('header-social', 'equals', '1'),
				'type' => 'text',
				'title' => __('Tumblr', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Header Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'header-social-behance',
				'required' => array('header-social', 'equals', '1'),
				'type' => 'text',
				'title' => __('Behance', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Header Social Networks', 'redux-framework-demo'),
				'default' => '',
			),
			array(
				'id' => 'header-social-WhatsApp',
				'required' => array('header-social', 'equals', '1'),
				'type' => 'text',
				'title' => __('WhatsApp', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Header Social Networks', 'redux-framework-demo'),
				'default' => '',
			),
			array(
				'id' => 'header-social-qzone',
				'required' => array('header-social', 'equals', '1'),
				'type' => 'text',
				'title' => __('qzone', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Header Social Networks', 'redux-framework-demo'),
				'default' => '',
			),
			array(
				'id' => 'header-social-vkcom',
				'required' => array('header-social', 'equals', '1'),
				'type' => 'text',
				'title' => __('vk.com', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Header Social Networks', 'redux-framework-demo'),
				'default' => '',
			),
			array(
				'id' => 'header-social-imdb',
				'required' => array('header-social', 'equals', '1'),
				'type' => 'text',
				'title' => __('IMDb', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Header Social Networks', 'redux-framework-demo'),
				'default' => '',
			),
			array(
				'id' => 'header-social-renren',
				'required' => array('header-social', 'equals', '1'),
				'type' => 'text',
				'title' => __('Renren', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Header Social Networks', 'redux-framework-demo'),
				'default' => '',
			),
			array(
				'id' => 'header-social-weibo',
				'required' => array('header-social', 'equals', '1'),
				'type' => 'text',
				'title' => __('Weibo', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Header Social Networks', 'redux-framework-demo'),
				'default' => '',
			),
		),
	);

	$sections[] = array(
		'title' => __('Footer', 'redux-framework-demo'),
		'desc' => __('', 'redux-framework-demo'),
		'icon' => 'el-icon-photo',
		// 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
		'fields' => array(

			array(
				'id' => 'footer',
				'type' => 'switch',
				'title' => __('Footer', 'redux-framework-demo'),
				'subtitle' => __('Will be located after content. Please note that sub footer will not be affected by this option.', 'redux-framework-demo'),
				'desc' => __('If you don\'t want to have footer section you can disable it.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'footer-layout',
				'required' => array('footer', 'equals', '1'),
				'type' => 'image_select',
				'title' => __('Footer Widget Area Columns', 'redux-framework-demo'),
				'subtitle' => __('Defines in which strcuture footer widget areas would be divided', 'redux-framework-demo'),
				'desc' => __('Please choose your footer widget area column strucutre.', 'redux-framework-demo'),
				'options' => array(
					'1' => array('alt' => '1 Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/column_1.png'),
					'2' => array('alt' => '2 Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/column_2.png'),
					'3' => array('alt' => '3 Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/column_3.png'),
					'4' => array('alt' => '4 Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/column_4.png'),
					'5' => array('alt' => '5 Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/column_5.png'),
					'6' => array('alt' => '6 Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/column_6.png'),
					'half_sub_half' => array('alt' => 'Half Sub Half Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/column_half_sub_half.png'),
					'half_sub_third' => array('alt' => 'Half Sub Third Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/column_half_sub_third.png'),
					'third_sub_third' => array('alt' => 'Third Sub Third Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/column_third_sub_third.png'),
					'third_sub_fourth' => array('alt' => 'Third Sub Fourth Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/column_third_sub_fourth.png'),
					'sub_half_half' => array('alt' => 'Sub Half Half Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/column_sub_half_half.png'),
					'sub_third_half' => array('alt' => 'Sub Third Half Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/column_sub_third_half.png'),
					'sub_third_third' => array('alt' => 'Sub Third Third Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/column_sub_third_third.png'),
					'sub_fourth_third' => array('alt' => 'Sub Fourth Third Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/column_sub_fourth_third.png'),

				),
				'default' => '4'
			),

			array(
				'id' => 'sub-footer',
				'type' => 'switch',
				'title' => __('Sub Footer', 'redux-framework-demo'),
				'subtitle' => __('Locates below footer.', 'redux-framework-demo'),
				'desc' => __('If you don\'t want to have sub footer section you can disable it.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'footer-copyright',
				'type' => 'textarea',
				'required' => array('sub-footer', 'equals', '1'),
				'title' => __('Sub Footer Copyright text', 'redux-framework-demo'),
				'subtitle' => __('You may write your site copyright information.', 'redux-framework-demo'),
				'desc' => '',
				'default' => 'Copyright All Rights Reserved'
			),

			array(
				'id' => 'social-facebook',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => __('Facebook', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Sub Footer Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'social-twitter',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => __('Twitter', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Sub Footer Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'social-rss',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => __('RSS', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Sub Footer Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'social-dribbble',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => __('Dribbble', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Sub Footer Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'social-pinterest',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => __('Pinterest', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Sub Footer Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'social-instagram',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => __('Instagram', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Sub Footer Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'social-google-plus',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => __('Google Plus', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Sub Footer Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'social-linkedin',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => __('Linkedin', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Sub Footer Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'social-youtube',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => __('Youtube', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Sub Footer Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'social-tumblr',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => __('Tumblr', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Sub Footer Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'social-behance',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => __('Behance', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Sub Footer Social Networks', 'redux-framework-demo'),
				'default' => '',
			),
			array(
				'id' => 'social-whatsapp',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => __('WhatsApp', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Sub Footer Social Networks', 'redux-framework-demo'),
				'default' => '',
			),
			array(
				'id' => 'social-wechat',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => __('Wechat', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Sub Footer Social Networks', 'redux-framework-demo'),
				'default' => '',
			),
			array(
				'id' => 'social-qzone',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => __('qzone', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Sub Footer Social Networks', 'redux-framework-demo'),
				'default' => '',
			),
			array(
				'id' => 'social-vkcom',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => __('vk.com', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Sub Footer Social Networks', 'redux-framework-demo'),
				'default' => '',
			),
			array(
				'id' => 'social-imdb',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => __('IMDb', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Sub Footer Social Networks', 'redux-framework-demo'),
				'default' => '',
			),
			array(
				'id' => 'social-renren',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => __('Renren', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Sub Footer Social Networks', 'redux-framework-demo'),
				'default' => '',
			),
			array(
				'id' => 'social-weibo',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => __('Weibo', 'redux-framework-demo'),
				'desc' => __('Including http://', 'redux-framework-demo'),
				'subtitle' => __('Sub Footer Social Networks', 'redux-framework-demo'),
				'default' => '',
			),

		),
	);

	$sections[] = array(
		'title' => __('Typography', 'redux-framework-demo'),
		'desc' => __('', 'redux-framework-demo'),
		'icon' => 'el-icon-font',
		'fields' => array(

			array(
				'id' => 'body-font',
				'type' => 'typography',
				'title' => __('Body Font', 'redux-framework-demo'),
				'compiler' => true, // Use if you want to hook in your own CSS compiler
				'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
				'font-backup' => true, // Select a backup non-google font in addition to a google font
				'font-style' => false, // Includes font-style and weight. Can use font-style or font-weight to declare
				'subsets' => true, // Only appears if google is true and subsets not set to false
				'font-size' => true,
				'line-height' => false,
				//'word-spacing'=>true, // Defaults to false
				//'letter-spacing'=>true, // Defaults to false
				'color' => false,
				'preview' => true, // Disable the previewer
				'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
				'units' => 'px', // Defaults to px
				'subtitle' => __('Choose your body font properties.', 'redux-framework-demo'),
				'default' => array(
					'font-family' => 'Open Sans',
					'google' => true,
					'font-size' => '13px',
				),
			),

			array(
				'id' => 'heading-font',
				'type' => 'typography',
				'title' => __('Headings Font', 'redux-framework-demo'),
				'compiler' => false, // Use if you want to hook in your own CSS compiler
				'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
				'font-backup' => false, // Select a backup non-google font in addition to a google font
				'font-style' => false, // Includes font-style and weight. Can use font-style or font-weight to declare
				'subsets' => true, // Only appears if google is true and subsets not set to false
				'font-size' => false,
				'line-height' => false,
				//'word-spacing'=>true, // Defaults to false
				//'letter-spacing'=>true, // Defaults to false
				'color' => false,
				'preview' => false, // Disable the previewer
				'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
				'units' => 'px', // Defaults to px
				'subtitle' => __('Choose your Heading fonts properties. <br>(will affect H1, H2, H3, H4, H5, H6)', 'redux-framework-demo'),
				'default' => array(
					'font-family' => '',
					'google' => true,
					'font-weight' => '600',
				),
			),

			array(
				'id' => 'widget-title',
				'type' => 'typography',
				'title' => __('Widgets Title', 'redux-framework-demo'),
				'compiler' => false, // Use if you want to hook in your own CSS compiler
				'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
				'font-backup' => false, // Select a backup non-google font in addition to a google font
				'font-style' => false, // Includes font-style and weight. Can use font-style or font-weight to declare
				'subsets' => false, // Only appears if google is true and subsets not set to false
				'font-size' => true,
				'line-height' => false,
				//'word-spacing'=>true, // Defaults to false
				//'letter-spacing'=>true, // Defaults to false
				'color' => false,
				'preview' => false, // Disable the previewer
				'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
				'units' => 'px', // Defaults to px
				'subtitle' => __('This will apply to all widget areas title including footer, sidebar and side dashboard', 'redux-framework-demo'),
				'default' => array(
					'font-family' => '',
					'google' => true,
					'font-size' => '13px',
					'font-weight' => 'bold',
				),
			),

			array(
				'id' => 'page-title-size',
				'type' => 'slider',
				'title' => __('Page Title Text Size', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				"default" => "18",
				"min" => "12",
				"step" => "1",
				"max" => "100",
			),
			array(
				'id' => 'p-text-size',
				'type' => 'slider',
				'title' => __('Paragraph Text Size', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				"default" => "13",
				"min" => "12",
				"step" => "1",
				"max" => "100",
			),
			array(
				'id' => 'p-line-height',
				'type' => 'slider',
				'title' => __('Paragraph Line Height', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				"default" => "26",
				"min" => "12",
				"step" => "1",
				"max" => "100",
			),

			array(
				'id' => 'main-nav-font',
				'type' => 'typography',
				'title' => __('Main Navigation Top level', 'redux-framework-demo'),
				'compiler' => false, // Use if you want to hook in your own CSS compiler
				'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
				'font-backup' => false, // Select a backup non-google font in addition to a google font
				'font-style' => false, // Includes font-style and weight. Can use font-style or font-weight to declare
				'subsets' => false, // Only appears if google is true and subsets not set to false
				'font-size' => true,
				'line-height' => false,
				//'word-spacing'=>true, // Defaults to false
				//'letter-spacing'=>true, // Defaults to false
				'color' => false,
				'preview' => false, // Disable the previewer
				'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
				'units' => 'px', // Defaults to px
				'subtitle' => __('', 'redux-framework-demo'),
				'default' => array(
					'font-family' => '',
					'google' => true,
					'font-size' => '12px',
					'font-weight' => 'bold',
				),
			),
			
			array(
				'id' => 'main-nav-item-space',
				'type' => 'slider',
				'title' => __('Main Menu Items Gutter Space', 'redux-framework-demo'),
				'subtitle' => __('Left & Right. default : 17px', 'redux-framework-demo'),
				'desc' => __('This Value will be applied as padding to left and right of the item.', 'redux-framework-demo'),
				"default" => "17",
				"min" => "0",
				"step" => "1",
				"max" => "100",
			),
			array(
				'id' => 'vertical-nav-item-space',
				'type' => 'slider',
				'required' => array('header-structure', 'equals', 'vertical'),
				'title' => __('Main Menu Items Top & Bottom Padding', 'redux-framework-demo'),
				'subtitle' => __('Top & Bottom. default : 10px', 'redux-framework-demo'),
				'desc' => __('This Value will be applied as padding to top and bottom of the item.', 'redux-framework-demo'),
				"default" => "10",
				"min" => "0",
				"step" => "1",
				"max" => "25",
			),
			array(
				'id' => 'main-nav-top-transform',
				'type' => 'button_set',
				'title' => __('Main Menu Top Level Text Transform', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				'options' => array('uppercase' => 'Uppercase', 'capitalize' => 'Capitalize', 'lowercase' => 'Lower Case'), 
				'default' => 'uppercase',
			),

			array(
				'id' => 'sub-nav-top-size',
				'type' => 'slider',
				'title' => __('Main Menu Sub Level Font Size', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				"default" => "12", 
				"min" => "10",
				"step" => "1",
				"max" => "50",
			),
			array(
				'id' => 'sub-nav-top-transform',
				'type' => 'button_set',
				'title' => __('Main Menu Sub Level Text Transform', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				'options' => array('uppercase' => 'Uppercase', 'capitalize' => 'Capitalize', 'lowercase' => 'Lower Case'), 
				'default' => 'uppercase',
			),
			array(
				'id' => 'sub-nav-top-weight',
				'type' => 'button_set',
				'title' => __('Main Menu Sub Level Font Weight', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				'options' => array('lighter' => 'Light (300)', 'normal' => 'Normal (400)', '500' => '500', '600' => '600', 'bold' => 'Bold (700)', 'bolder' => 'Bolder', '8000' => 'Extra Bold (800)', '900' => '900'), 
				'default' => 'normal',
			),
			array(
				'id' => 'typekit-info',
				'type' => 'info',
				'style' => 'warning',
				'desc' => __("Note: Adobe Typekit is a premium service. <a target='_blank' href='http://artbees.freshdesk.com/support/solutions/articles/1000126904'>Learn More</a>", 'redux-framework-demo'),
				'subtitle' => __("", 'redux-framework-demo'),
				'default' => '',
			),
			array(
				'id' => 'typekit-font-family',
				'type' => 'text',
				'title' => __('Choose a Typekit Font', 'redux-framework-demo'),
				'desc' => __("Type the name of the font family you have picked from typekit library.", 'redux-framework-demo'),
				'subtitle' => __("", 'redux-framework-demo'),
				'default' => '',
			),
			array(
				'id' => 'typekit-element-names',
				'type' => 'text',
				'title' => __('Add Typekit Elements Class Names.', 'redux-framework-demo'),
				'desc' => __("Add class names you want the Typekit apply the above font family. Add Class, ID or tag names (e.g. : body, p, #custom-id, .custom-class).", 'redux-framework-demo'),
				'subtitle' => __("", 'redux-framework-demo'),
				'default' => '',
			),
		),
	);

	$sections[] = array(
		'title' => __('Skin', 'redux-framework-demo'),
		'desc' => __('', 'redux-framework-demo'),
		'icon' => 'el-icon-tint',
		'fields' => array(

			array(
				'id' => 'accent-color',
				'type' => 'color',
				'title' => __('Accent Color', 'redux-framework-demo'),
				'subtitle' => __('Main color scheme. Choose a vivid and bold color.', 'redux-framework-demo'),
				'default' => '#ff4351',
				'validate' => 'color',
			),

			array(
				'id' => 'hover-overlay-color',
				'type' => 'color',
				'title' => __('Image Hover Overlay Color', 'redux-framework-demo'),
				'subtitle' => __('Image Hover Overlay Color will affect all images that have some overlay layer.', 'redux-framework-demo'),
				'default' => '#ff4351',
				'validate' => 'color',
			),

			array(
				'id' => 'body-txt-color',
				'type' => 'color',
				'title' => __('Body text Color', 'redux-framework-demo'),
				'subtitle' => __('Will affect all texts if no color is defined for them.', 'redux-framework-demo'),
				'default' => '#696969',
				'validate' => 'color',
			),
			array(
				'id' => 'heading-color',
				'type' => 'color',
				'title' => __('Headings Color', 'redux-framework-demo'),
				'subtitle' => __('Will affect all headings (h1,h2,h3,h4,h5,h6)', 'redux-framework-demo'),
				'default' => '#393836',
				'validate' => 'color',
			),
			array(
				'id' => 'link-color',
				'type' => 'link_color',
				'title' => __('Links Color', 'redux-framework-demo'),
				'subtitle' => __('Will affect all links color.', 'redux-framework-demo'),
				'regular' => true,
				'hover' => true,
				'default' => array(
					'regular' => '#333333',
					'hover' => '#ff4351',
				)
			),

			array(
				'id' => 'page-title-color',
				'type' => 'color',
				'title' => __('Page Title', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'default' => '#545454',
				'validate' => 'color',
			),

			array(
				'id' => 'dashboard-title-color',
				'type' => 'color',
				'title' => __('Dashboard Widget Title', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'default' => '#959595',
				'validate' => 'color',
			),

			array(
				'id' => 'dashboard-txt-color',
				'type' => 'color',
				'title' => __('Dashboard Widget Texts', 'redux-framework-demo'),
				'subtitle' => __('Will affect all texts in side dashboard widget (unless there is a color value for the specific option in theme styles)', 'redux-framework-demo'),
				'default' => '#6f6f6f',
				'validate' => 'color',
			),

			array(
				'id' => 'dashboard-link-color',
				'type' => 'link_color',
				'title' => __('Dashboard Widget Links', 'redux-framework-demo'),
				'subtitle' => __('Will affect all links in side dashboard section.', 'redux-framework-demo'),
				'regular' => true,
				'hover' => true,
				'default' => array(
					'regular' => '#afafaf',
					'hover' => '#ff4351',
				)
			),

			array(
				'id' => 'sidebar-title-color',
				'type' => 'color',
				'title' => __('Sidebar Widget Title', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'default' => '#555555',
				'validate' => 'color',
			),

			array(
				'id' => 'sidebar-txt-color',
				'type' => 'color',
				'title' => __('Sidebar Widget Texts', 'redux-framework-demo'),
				'subtitle' => __('Will affect all texts in sidebar widget (unless there is a color value for the specific option in theme styles)', 'redux-framework-demo'),
				'default' => '#666666',
				'validate' => 'color',
			),

			array(
				'id' => 'sidebar-link-color',
				'type' => 'link_color',
				'title' => __('Sidebar Widget Links', 'redux-framework-demo'),
				'subtitle' => __('Will affect all links in sidebar section.', 'redux-framework-demo'),
				'regular' => true,
				'hover' => true,
				'default' => array(
					'regular' => '#444',
					'hover' => '#ff4351',
				)
			),

			array(
				'id' => 'footer-title-color',
				'type' => 'color',
				'title' => __('Footer Widget Title', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'default' => '#959595',
				'validate' => 'color',
			),

			array(
				'id' => 'footer-txt-color',
				'type' => 'color',
				'title' => __('Footer Widget Texts', 'redux-framework-demo'),
				'subtitle' => __('Will affect all texts in footer widget (unless there is a color value for the specific option in theme styles)', 'redux-framework-demo'),
				'default' => '#6f6f6f',
				'validate' => 'color',
			),

			array(
				'id' => 'footer-link-color',
				'type' => 'link_color',
				'title' => __('Footer Widget Links', 'redux-framework-demo'),
				'subtitle' => __('Will affect all links in footer section.', 'redux-framework-demo'),
				'regular' => true,
				'hover' => true,
				'default' => array(
					'regular' => '#afafaf',
					'hover' => '#ff4351',
				)
			),

			array(
				'id' => 'footer-social-color',
				'type' => 'link_color',
				'title' => __('Sub-Footer Social Networks Color', 'redux-framework-demo'),
				'subtitle' => __('Will affect all social network icons in sub footer. you can set its active and hover values.', 'redux-framework-demo'),
				'regular' => true,
				'hover' => true,
				'default' => array(
					'regular' => '#666666',
					'hover' => '#ff4351',
				)
			),
			array(
				'id' => 'footer-socket-color',
				'type' => 'color',
				'title' => __('Sub-Footer Copyright Color', 'redux-framework-demo'),
				'subtitle' => __('Will affect sub footer left side copyright text.', 'redux-framework-demo'),
				'default' => '#666666',
				'validate' => 'color',
			),
			array(
				'id' => 'widget-title-divider',
				'type' => 'switch',
				'title' => __('Show Widget Title Divider?', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'desc' => __('If you dont want to show widget title divider disabled this option.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'main-nav-top-color',
				'type' => 'nav_color',
				'title' => __('Main Navigation Top Level', 'redux-framework-demo'),
				'subtitle' => __('Will affect main navigation top level links', 'redux-framework-demo'),
				'regular' => true,
				'hover' => true,
				'bg' => true,
				'bg-hover' => true,
				'default' => array(
					'regular' => '#666666',
					'hover' => '#ff4351',
					'bg' => '',
					'bg-hover' => '',
				)
			),

			array(
				'id' => 'main-nav-sub-bg',
				'type' => 'color',
				'title' => __('Main Navigation Sub Level Background Color', 'redux-framework-demo'),
				'subtitle' => __('This value will affect Sub level background color including mega menu.', 'redux-framework-demo'),
				'default' => '#191919',
				'validate' => 'color',
			),

			array(
				'id' => 'main-nav-sub-color',
				'type' => 'nav_color',
				'title' => __('Main Navigation Sub Level', 'redux-framework-demo'),
				'subtitle' => __('Will affect all links in sidebar section.', 'redux-framework-demo'),
				'regular' => true,
				'hover' => true,
				'bg' => true,
				'bg-hover' => true,
				'default' => array(
					'regular' => '#fff',
					'hover' => '#000',
					'bg' => '',
					'bg-hover' => '#ff4351',
				)
			),
			array(
				'id' => 'navigation-border-top',
				'type' => 'switch',
				'title' => __('Show Main Navigation Border Top?', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'header-search-icon-color',
				'type' => 'color',
				'title' => __('Header Search Icon Color', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'default' => '',
				'validate' => 'color',
			),

			array(
				'id' => 'preloader-txt-color',
				'type' => 'color',
				'title' => __('Preloader Text Color', 'redux-framework-demo'),
				'subtitle' => __('Will affect global site preloader text color.', 'redux-framework-demo'),
				'default' => '#444',
				'validate' => 'color',
			),

			array(
				'id' => 'preloader-bg-color',
				'type' => 'color',
				'title' => __('Preloader Backgroud Color', 'redux-framework-demo'),
				'subtitle' => __('Will affect global site preloader Background color.', 'redux-framework-demo'),
				'default' => '#fff',
				'validate' => 'color',
			),

			array(
				'id' => 'preloader-bar-color',
				'type' => 'color',
				'title' => __('Preloader Bar Color', 'redux-framework-demo'),
				'subtitle' => __('Will affect global site preloader Bar color.', 'redux-framework-demo'),
				'default' => '',
				'validate' => 'color',
			),

			array(
				'id' => 'custom-css',
				'type' => 'ace_editor',
				'title' => __('Custom CSS', 'redux-framework-demo'),
				'subtitle' => __('Add some quick css into this box.', 'redux-framework-demo'),
				'desc' => __('For larger scale css modifications use custom.css file in theme root or consider using a child theme.', 'redux-framework-demo'),
				'mode' => 'css',
				'theme' => 'monokai',
				'default' => "",
			),
			array(
				'id' => 'custom-js',
				'type' => 'ace_editor',
				'title' => __('Custom JS', 'redux-framework-demo'),
				'subtitle' => __('Script will be placed in an script tag in document footer', 'redux-framework-demo'),
				'mode' => 'javascript',
				'theme' => 'chrome',
				'desc' => 'For larger scale css modifications js custom.js file in theme root or consider using a child theme.',
				'default' => "jQuery(document).ready(function(){\n\n});",
			),

		),
	);

	$sections[] = array(
		'title' => __('Backgrounds', 'redux-framework-demo'),
		'desc' => __('In this section you will customize your website backgrounds.', 'redux-framework-demo'),
		'icon' => 'el-icon-brush',
		'fields' => array(

			array(
				'id' => 'body-layout',
				'type' => 'button_set',
				'title' => __('Site Layout', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				'options' => array('full' => 'Full Width', 'boxed' => 'Boxed'), //Must provide key => value pairs for radio options
				'default' => 'full',
			),

			array(
				'id' => 'body-bg',
				'type' => 'bg_selector',
				'required' => array('body-layout', 'equals', 'boxed'),
				'title' => __('Body Background', 'redux-framework-demo'),
				'subtitle' => __('Affects body background Properties, use this option when boxed layout is chosen.', 'redux-framework-demo'),
				'preset' => false,
				'default' => array(
					'url' => '',
					'color' => '#fff',
					'position' => '',
					'repeat' => 'repeat',
					'attachment' => 'scroll',
					'cover' => '',
				)
			),

			array(
				'id' => 'header-bg',
				'type' => 'bg_selector',
				'title' => __('Header Background', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'preset' => false,
				'default' => array(
					'url' => '',
					'color' => '#fff',
					'position' => '',
					'repeat' => 'repeat',
					'attachment' => 'scroll',
					'cover' => '',
				)
			),
			array(
				'id' => 'header-bottom-border',
				'type' => 'color',
				'title' => __('Header Bottom Border Color', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'default' => '#e6e6e6',
				'validate' => 'color',
			),

			array(
				'id' => 'page-title-bg',
				'type' => 'bg_selector',
				'title' => __('Page Title Background', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'preset' => false,
				'border' => true,
				'default' => array(
					'url' => '',
					'color' => '#fafafa',
					'position' => '',
					'repeat' => 'repeat',
					'attachment' => 'scroll',
					'cover' => '',
					'border' => '#eeeeee',
				)
			),

			array(
				'id' => 'page-bg',
				'type' => 'bg_selector',
				'title' => __('Page Background', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'preset' => false,
				'default' => array(
					'url' => '',
					'color' => '#fff',
					'position' => '',
					'repeat' => 'repeat',
					'attachment' => 'scroll',
					'cover' => '',
				)
			),

			array(
				'id' => 'footer-bg',
				'type' => 'bg_selector',
				'title' => __('Footer Background', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'preset' => false,
				'default' => array(
					'url' => '',
					'color' => '#191919',
					'position' => '',
					'repeat' => 'repeat',
					'attachment' => 'scroll',
					'cover' => '',
				)
			),

			array(
				'id' => 'sub-footer-bg',
				'type' => 'color',
				'title' => __('Sub Footer Background Color', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'default' => '#262626',
				'validate' => 'color',
			),

			array(
				'id' => 'dashboard-bg',
				'type' => 'color',
				'title' => __('Side Dashboard Background Color', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'default' => '#191919',
				'validate' => 'color',
			),

			array(
				'id' => 'breadcrumb-skin',
				'type' => 'select',
				'title' => __('Breadcrumb Skin', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'options' => array(
					'dark' => 'Dark',
					'light' => 'Light',

				),
				'default' => 'light',
			),

		),
	);

	$sections[] = array(
		'title' => __('Blog', 'redux-framework-demo'),
		'desc' => __('', 'redux-framework-demo'),
		'icon' => 'el-icon-pencil',
		'fields' => array(

			array(
				'id' => 'page-title-blog',
				'type' => 'switch',
				'title' => __('Page Title : Blog Posts', 'redux-framework-demo'),
				'subtitle' => __('This option will affect Blog single posts.', 'redux-framework-demo'),
				'desc' => __('If you don\'t want to show page title section (title, breadcrumb) in blog single posts disable this option.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				"title" => __("Previous & Next Arrows", "redux-framework-demo"),
				"subtitle" => __("Using this option you can turn on/off the navigation arrows when viewing the portfolio single page.", "mk_framework"),
				"id" => "blog_next_prev",
				"default" => 1,
				"type" => "switch",
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'blog-featured-image',
				'type' => 'switch',
				'title' => __('Blog Single Featured image, audio, video ', 'redux-framework-demo'),
				'subtitle' => __('Will completely disable Featued Image, Video and Audio players from blog single post.', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'blog-image-crop',
				'type' => 'switch',
				'title' => __('Featured image hard cropping', 'redux-framework-demo'),
				'subtitle' => __('This option will affect single blog post featrued image.', 'redux-framework-demo'),
				'desc' => __('If you want to disable automatic image cropping for featured image, disable this option. The original image size will be used. However it will be responsive and fit to container.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'blog-single-image-height',
				'required' => array('blog-image-crop', 'equals', '1'),
				'type' => 'slider',
				'title' => __('Single Post Featured Image Height', 'redux-framework-demo'),
				'subtitle' => __('This height applies to featured image and gallery post type slideshow..', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				"default" => "350",
				"min" => "100",
				"step" => "1",
				"max" => "1000",
			),

			array(
				'id' => 'blog-single-related-posts',
				'type' => 'switch',
				'title' => __('Related Projects', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'blog-single-about-author',
				'type' => 'switch',
				'title' => __('About Author Section', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'blog-single-social-share',
				'type' => 'switch',
				'title' => __('Blog Single Social Share', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'blog-single-comments',
				'type' => 'switch',
				'title' => __('Comments', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'archive-layout',
				'type' => 'image_select',
				'title' => __('Archive Layout', 'redux-framework-demo'),
				'subtitle' => __('Defines archive loop layout.', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				'options' => array(
					'left' => array('alt' => '1 Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/left_layout.png'),
					'right' => array('alt' => '2 Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/right_layout.png'),
					'full' => array('alt' => '3 Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/full_layout.png'),
				),
				'default' => 'right'
			),
			array(
				'id' => 'archive-loop-style',
				'type' => 'select',
				'title' => __('Archive Loop Style', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				"default" => 'classic',
				'options' => array(
					'classic' => __('Classic', 'mk_framework'),
					'masonry' => __('Masonry', 'mk_framework'),
					'tile' => __('Tile', 'mk_framework'),
					'thumb' => __('Thumb', 'mk_framework'),
					'list' => __('List', 'mk_framework'),
				),
				'default' => 'classic',
			),
			array(
				'id' => 'archive-page-title',
				'type' => 'switch',
				'title' => __('Archive Loop Page Title', 'redux-framework-demo'),
				'subtitle' => __('Using this option you can enable/disable page title section (including breadcrumbs)', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

		),
	);

	$sections[] = array(
		'title' => __('Portfolio', 'redux-framework-demo'),
		'desc' => __('', 'redux-framework-demo'),
		'icon' => 'el-icon-briefcase',
		'fields' => array(

			array(
				'id' => 'page-title-portfolio',
				'type' => 'switch',
				'title' => __('Page Title : Portfolio Posts', 'redux-framework-demo'),
				'subtitle' => __('This option will affect Portfolio single posts.', 'redux-framework-demo'),
				'desc' => __('If you don\'t want to show page title section (title, breadcrumb) in Portfolio single posts disable this option.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'portfolio-slug',
				'type' => 'text',
				'title' => __('Portfolio Slug', 'redux-framework-demo'),
				'subtitle' => __('If you modify this field please navigate to <a href="' . admin_url('options-permalink.php', 'https') . '">Permalinks</a> and hit the save button to update the permalink structure.', 'redux-framework-demo'),
				'desc' => __('Portfolio Slug is the text that is displyed in the URL (e.g. www.domain.com/<strong>portfolio-posts</strong>/morbi-et-diam-massa/). As shown in the example, it is set to "portfolio-posts" by default but you can change it to anything to suite your preference. However you should not have the same slug in any page or other post slug and if so the pagination will return 404 error naturally due to the internal conflicts.', 'redux-framework-demo'),
				'default' => 'portfolio-posts',
			),
			array(
				"title" => __("Previous & Next Arrows", "redux-framework-demo"),
				"subtitle" => __("Using this option you can turn on/off the navigation arrows when viewing the portfolio single page.", "mk_framework"),
				"id" => "portfolio_next_prev",
				"default" => '1',
				"type" => "switch",
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'portfolio-single-image',
				'type' => 'switch',
				'title' => __('Portfolio Single Featured Image', 'redux-framework-demo'),
				'subtitle' => __('Using this option you can disable/enable portfolio single featured image, gallyer slidshow or video.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'portfolio-image-crop',
				'type' => 'switch',
				'required' => array('portfolio-single-image', 'equals', '1'),
				'title' => __('Featured image hard cropping', 'redux-framework-demo'),
				'subtitle' => __('This option will affect single Portfolio post featrued image.', 'redux-framework-demo'),
				'desc' => __('If you want to disable automatic image cropping for featured image, disable this option. The original image size will be used. However it will be responsive and fit to container.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'Portfolio-single-image-height',
				'type' => 'slider',
				'required' => array('portfolio-single-image', 'equals', '1'),
				'title' => __('Featured Image Height', 'redux-framework-demo'),
				'subtitle' => __('This height applies to featured image and gallery post type slideshow..', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				"default" => "350",
				"min" => "100",
				"step" => "1",
				"max" => "1000",
			),

			array(
				'id' => 'portfolio-single-related',
				'type' => 'switch',
				'title' => __('Related Projects', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'portfolio-single-comments',
				'type' => 'switch',
				'title' => __('Comments', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				"default" => 0,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'portfolio-archive-loop-style',
				'type' => 'select',
				'title' => __('Portfolio Archive Loop Style', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				"default" => 'grid',
				'options' => array(
					"grid" => __("Grid", 'mk_framework'),
					"masonry" => __("Masonry", 'mk_framework'),
					"flip" => __("Flip", 'mk_framework'),
					"standard" => __("Standard", 'mk_framework'),
					"scroller" => __("Scroller", 'mk_framework')

				),
				'default' => 'classic',
			),

		),
	);

	$sections[] = array(
		'title' => __('Woocommerce', 'redux-framework-demo'),
		'desc' => __('', 'redux-framework-demo'),
		'icon' => 'el-icon-shopping-cart',
		'fields' => array(
			array(
				'id' => 'woo-shop-layout',
				'type' => 'image_select',
				'title' => __('Shop Layout', 'redux-framework-demo'),
				'subtitle' => __('Defines shop loop layout.', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				'options' => array(
					'left' => array('alt' => '1 Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/left_layout.png'),
					'right' => array('alt' => '2 Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/right_layout.png'),
					'full' => array('alt' => '3 Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/full_layout.png'),
				),
				'default' => 'right'
			),

			array(
				'id' => 'woo-loop-thumb-height',
				'type' => 'slider',
				'title' => __('Product Loop Image Height', 'redux-framework-demo'),
				'subtitle' => __('Using this option you can change the product loop image height.', 'redux-framework-demo'),
				'desc' => __('default : 330', 'redux-framework-demo'),
				"default" => "330",
				"min" => "100",
				"step" => "1",
				"max" => "1000",
			),
		    array(
		        "title" => __("Shop Loop Image Size", "redux-framework-demo"),
		        "id" => "woo_loop_image_size",
		        "default" => "crop",
		        "options" => array(
		            "crop" => __("Resize & Crop", "redux-framework-demo"),
		            "full" => __("Original Size", "redux-framework-demo"),
		            "large" => __("Large Size", "redux-framework-demo"),
		            "medium" => __("Medium Size", "redux-framework-demo"),
		        ),
		        "type" => "select"
		    ),
			array(
				'id' => 'woo-single-thumb-height',
				'type' => 'slider',
				'title' => __('Single Product Image Height', 'redux-framework-demo'),
				'subtitle' => __('Using this option you can change the single product image height.', 'redux-framework-demo'),
				'desc' => __('default : 800', 'redux-framework-demo'),
				"default" => "800",
				"min" => "100",
				"step" => "1",
				"max" => "1000",
			),
		    array(
		        "title" => __("Shop Single Product Image Size", "redux-framework-demo"),
		        "id" => "woo_single_image_size",
		        "default" => "crop",
		        "options" => array(
		            "crop" => __("Resize & Crop", "redux-framework-demo"),
		            "full" => __("Original Size", "redux-framework-demo"),
		            "large" => __("Large Size", "redux-framework-demo"),
		            "medium" => __("Medium Size", "redux-framework-demo"),
		        ),
		        "type" => "select"
		    ),

			array(
				'id' => 'woo-single-layout',
				'type' => 'image_select',
				'title' => __('Single Layout', 'redux-framework-demo'),
				'subtitle' => __('Defines shop single product layout.', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				'options' => array(
					'left' => array('alt' => '1 Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/left_layout.png'),
					'right' => array('alt' => '2 Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/right_layout.png'),
					'full' => array('alt' => '3 Column', 'img' => THEME_ADMIN_ASSETS_URI . '/img/full_layout.png'),
				),
				'default' => 'right'
			),

			array(
				'id' => 'checkout-box',
				'type' => 'switch',
				'title' => __('Header Checkout/Shopping Box', 'redux-framework-demo'),
				'subtitle' => __('Using This option you can remove header shopping box from header.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'woo-image-quality',
				'type' => 'button_set',
				'title' => __('Product Loops image quality', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				'options' => array('1' => 'Normal Size', '2' => 'Retina Compatible'), //Must provide key => value pairs for radio options
				'default' => '1'
			),

			array(
				'id' => 'woo-single-title',
				'type' => 'switch',
				'title' => __('Show Product Category as Product Single Title.', 'redux-framework-demo'),
				'subtitle' => __('If you want to show product category(if multiple only first will be used) as single product page title enable this option. having this option disabled shop page title will be used.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'woo-single-show-title',
				'type' => 'switch',
				'title' => __('Woocommerce Single Product Page Title', 'redux-framework-demo'),
				'subtitle' => __('Using this option you can disable/enable single product page title (including breadcrumbs).', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'woo-shop-loop-title',
				'type' => 'switch',
				'title' => __('Woocommerce Shop Loop Page Title', 'redux-framework-demo'),
				'subtitle' => __('Using this option you can disable/enable Shop product Loop title (including breadcrumbs).', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

		),
	);

	$sections[] = array(
		'title' => __('Third Party API', 'redux-framework-demo'),
		'desc' => __('', 'redux-framework-demo'),
		'icon' => 'el-icon-puzzle',
		'fields' => array(

			array(
				'id' => 'twitter-consumer-key',
				'type' => 'text',
				'title' => __('Twitter Consumer Key', 'redux-framework-demo'),
				'desc' => __('<ol style="list-style-type:decimal !important;">
  <li>Go to "<a href="https://dev.twitter.com/apps">https://dev.twitter.com/apps</a>," login with your twitter account and click "Create a new application".</li>
  <li>Fill out the required fields, accept the rules of the road, and then click on the "Create your Twitter application" button. You will not need a callback URL for this app, so feel free to leave it blank.</li>
  <li>Once the app has been created, click the "Create my access token" button.</li>
  <li>You are done! You will need the following data later on:</ol>', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'twitter-consumer-secret',
				'type' => 'text',
				'title' => __('Twitter Consumer Secret', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'twitter-access-token',
				'type' => 'text',
				'title' => __('Twitter Access Token', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'twitter-access-token-secret',
				'type' => 'text',
				'title' => __('Twitter Access Token Secret', 'redux-framework-demo'),
				'desc' => __('', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'flickr-api-key',
				'type' => 'text',
				'title' => __('Flickr API Key', 'redux-framework-demo'),
				'desc' => __('You can obtain your API key from <a href="http://www.flickr.com/services/api/misc.api_keys.html">Flickr The App Garden</a>', 'redux-framework-demo'),
				'subtitle' => __('You will need to fill this field if you want to use flickr widget or shrotcode', 'redux-framework-demo'),
				'default' => '',
			),

			array(
				'id' => 'google-analytics',
				'type' => 'text',
				'title' => __('Google Analytics ID', 'redux-framework-demo'),
				'desc' => __('Enter your Google Analytics ID here to track your site with Google Analytics.', 'redux-framework-demo'),
				'subtitle' => __('', 'redux-framework-demo'),
				'default' => '',
			),

		),
	);

	$sections[] = array(
		'title' => __('Manage Theme Speed', 'redux-framework-demo'),
		'desc' => __('', 'redux-framework-demo'),
		'icon' => 'el-icon-cogs',
		'fields' => array(
			array(
				'id' => 'minify-js',
				'type' => 'switch',
				'title' => __('Minify Java Script Files', 'redux-framework-demo'),
				'subtitle' => __('Minifies file to decrease the file size by 40%', 'redux-framework-demo'),
				'desc' => __('You can enable JS minification using this option. This option will only pickup the pre-minified JS files(theme-scripts-min.js & plugins.js). So use this option if you did not hack the JS files.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'minify-css',
				'type' => 'switch',
				'title' => __('Minify CSS Files', 'redux-framework-demo'),
				'subtitle' => __('Minifies file to decrease the file size by 40%', 'redux-framework-demo'),
				'desc' => __('You can enable CSS minification using this option. This option will only pickup the pre-minified CSS files. So use this option if you did not hack the CSS files.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'remove-js-css-ver',
				'type' => 'switch',
				'title' => __('Remove query string from Static Files', 'redux-framework-demo'),
				'subtitle' => __('Removes "ver" query string from JS and CSS files.', 'redux-framework-demo'),
				'desc' => __('For More info Please <a href="https://developers.google.com/speed/docs/best-practices/caching#LeverageProxyCaching">Read Here</a>.', 'redux-framework-demo'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

		),
	);

	/*
	$sections[] = array(
	'icon' => 'el-icon-info-sign',
	'title' => __( 'Theme Information', 'redux-framework-demo' ),
	'desc' => __( '<p class="description">This is the Description. Again HTML is allowed</p>', 'redux-framework-demo' ),
	'fields' => array(
	array(
	'id'=>'raw_new_info',
	'type' => 'raw',
	'content' => $item_info,
	)
	),
	);*/

	global $ReduxFramework;
	$ReduxFramework = new ReduxFramework($sections, $args, $tabs);

	// END Sample Config
}
add_action('init', 'redux_init');
endif;

/**

Custom function for filtering the sections array. Good for child themes to override or add to the sections.
Simply include this function in the child themes functions.php file.

NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
so you must use get_template_directory_uri() if you want to use any of the built in icons

 **/
if (!function_exists('redux_add_another_section')):
	function redux_add_another_section($sections) {
		//$sections = array();
		$sections[] = array(
			'title' => __('Section via hook', 'redux-framework-demo'),
			'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo'),
			'icon' => 'el-icon-paper-clip',
			// Leave this as a blank section, no options just some intro text set above.
			'fields' => array()
		);

		return $sections;
	}
	add_filter('redux/options/redux_demo/sections', 'redux_add_another_section');
// replace redux_demo with your opt_name
endif;
/**

Filter hook for filtering the args array given by a theme, good for child themes to override or add to the args array.

 **/
if (!function_exists('redux_change_framework_args')):
	function redux_change_framework_args($args) {
		//$args['dev_mode'] = true;

		return $args;
	}
	add_filter('redux/options/redux_demo/args', 'redux_change_framework_args');
// replace redux_demo with your opt_name
endif;
/**

Filter hook for filtering the default value of any given field. Very useful in development mode.

 **/
if (!function_exists('redux_change_option_defaults')):
	function redux_change_option_defaults($defaults) {
		$defaults['str_replace'] = "Testing filter hook!";

		return $defaults;
	}
	add_filter('redux/options/redux_demo/defaults', 'redux_change_option_defaults');
// replace redux_demo with your opt_name
endif;

/**

Custom function for the callback referenced above

 */
if (!function_exists('redux_my_custom_field')):
	function redux_my_custom_field($field, $value) {
		print_r($field);
		print_r($value);
	}
endif;

/**

Custom function for the callback validation referenced above

 **/
if (!function_exists('redux_validate_callback_function')):
	function redux_validate_callback_function($field, $value, $existing_value) {
		$error = false;
		$value = 'just testing';
		/*
		do your validation

		if(something) {
		$value = $value;
		} elseif(something else) {
		$error = true;
		$value = $existing_value;
		$field['msg'] = 'your custom error message';
		}
		 */

		$return['value'] = $value;
		if ($error == true) {
			$return['error'] = $field;
		}
		return $return;
	}
endif;
/**

This is a test function that will let you see when the compiler hook occurs.
It only runs if a field set with compiler=>true is changed.

 **/
if (!function_exists('redux_test_compiler')):
	function redux_test_compiler($options, $css) {
		echo "<h1>The compiler hook has run!";
		//print_r($options); //Option values
		print_r($css);//So you can compile the CSS within your own file to cache
		$filename = dirname(__FILE__) . '/avada' . '.css';

		global $wp_filesystem;
		if (empty($wp_filesystem)) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		if ($wp_filesystem) {
			$wp_filesystem->put_contents(
				$filename,
				$css,
				FS_CHMOD_FILE// predefined mode settings for WP files
			);
		}

	}
//add_filter('redux/options/redux_demo/compiler', 'redux_test_compiler', 10, 2);
	// replace redux_demo with your opt_name
endif;

/**

Remove all things related to the Redux Demo mode.

 **/
if (!function_exists('redux_remove_demo_options')):
	function redux_remove_demo_options() {

		// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
		if (class_exists('ReduxFrameworkPlugin')) {
			remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2);
		}

		// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
		remove_action('admin_notices', array(ReduxFrameworkPlugin::get_instance(), 'admin_notices'));

	}
//add_action( 'redux/plugin/hooks', 'redux_remove_demo_options' );
endif;
