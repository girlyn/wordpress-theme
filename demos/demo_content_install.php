<?php
/*----------------------------------------------------------------------------*\
	DEMO IMPORTER
\*----------------------------------------------------------------------------*/
/* REGISTER PAGE */
add_action('admin_menu', 'mpcth_register_demo_install_page');
function mpcth_register_demo_install_page(){
	global $mpcth_options;

	if (isset($mpcth_options['mpcth_disable_demo_wizard']) && $mpcth_options['mpcth_disable_demo_wizard'] !== '1') {
		add_menu_page(__('Demo Install', 'mpcth'), __('Demo Install', 'mpcth'), 'manage_options', 'demo-install', 'mpcth_demo_install_page', 'dashicons-lightbulb', 201);

		add_action('admin_enqueue_scripts', 'mpcth_demo_install_scripts');
	}
}

/* ENQUEUE SCRIPTS */
function mpcth_demo_install_scripts($hook) {
	if ($hook != 'toplevel_page_demo-install')
		return;

	wp_enqueue_style('mpcth-demos-css', MPC_THEME_URI . '/css/demos.css');

	wp_enqueue_script('mpcth-demos-js', MPC_THEME_URI . '/js/demos.js', array('jquery'));
}

/* PAGE MARKUP */
function mpcth_demo_install_page() {
	$images_root = MPC_THEME_URI . '/images/demos/';

	$wordpress_importer_enabled = function_exists('wordpress_importer_init');

	$demos_images = array();
	$demos_images[] = array('img' => 'default.jpg',      'bg' => '',                   'anim' => ''  );
	$demos_images[] = array('img' => 'grid.jpg',         'bg' => '',                   'anim' => 'long'  );
	$demos_images[] = array('img' => 'shop.png',         'bg' => 'shop_bg.jpg',        'anim' => 'medium');
	$demos_images[] = array('img' => 'lookbook.jpg',     'bg' => '',                   'anim' => 'long'  );
	$demos_images[] = array('img' => 'top_parallax.jpg', 'bg' => '',                   'anim' => 'medium');
	$demos_images[] = array('img' => 'flex_slider.png',  'bg' => 'flex_slider_bg.jpg', 'anim' => 'long'  );
	$demos_images[] = array('img' => 'alternate.jpg',    'bg' => '',                   'anim' => 'medium');
	$demos_images[] = array('img' => 'contact.png',      'bg' => 'contact_bg.jpg',     'anim' => 'medium');
	$demos_images[] = array('img' => 'one_page.jpg',     'bg' => '',                   'anim' => 'longer');
	$demos_images[] = array('img' => 'photography.jpg',  'bg' => '',                   'anim' => 'medium');
	$demos_images[] = array('img' => 'real_estate.png',  'bg' => 'real_estate_bg.jpg', 'anim' => 'long'  );
	$demos_images[] = array('img' => 'creative.png',     'bg' => 'creative_bg.jpg',    'anim' => 'long'  );
	$demos_images[] = array('img' => 'restaurant.jpg',   'bg' => '',                   'anim' => 'medium');
	$demos_images[] = array('img' => 'corporate.png',    'bg' => 'corporate_bg.jpg',   'anim' => 'medium');
	$demos_images[] = array('img' => 'dance.jpg',        'bg' => '',                   'anim' => 'medium');
	$demos_images[] = array('img' => 'emporium.jpg',     'bg' => '',                   'anim' => '');
	$demos_images[] = array('img' => 'newell.jpg',       'bg' => '',                   'anim' => '');
	$demos_images[] = array('img' => 'manufactory.jpg',  'bg' => '',                   'anim' => '');
	$demos_images[] = array('img' => 'coming_soon.jpg',  'bg' => '',                   'anim' => '');
	$demos_images[] = array('img' => 'coming_soon_2.jpg','bg' => '',                   'anim' => '');
	$demos_images[] = array('img' => 'hypercube.jpg',    'bg' => '',                   'anim' => '');
	$demos_images[] = array('img' => 'lookbooks.jpg',    'bg' => '',                   'anim' => '');
	$demos_images[] = array('img' => 'sanders.jpg',		 'bg' => '',                   'anim' => '');
	$demos_images[] = array('img' => 'molise.jpg',		 'bg' => '',                   'anim' => '');
	$demos_images[] = array('img' => 'arboria.jpg',		 'bg' => '',                   'anim' => '');
?>
	<div id="mpcth_import_wizard" class="wrap">
		<h2><?php _e('Demo Install', 'mpcth'); ?></h2>
		<?php if ($wordpress_importer_enabled) { ?>
			<span class="mpcth-import-warning"><span class="dashicons dashicons-no-alt"></span><?php _e('Please disable <em>WordPress Importer</em> plugin and refresh this page.', 'mpcth'); ?></span>
		<?php } ?>
		<h3 class="install-steps"><?php _e('Step 1', 'mpcth'); ?><small>: <?php _e('Choose the demo.', 'mpcth'); ?></small></h3>
		<div id="mpcth_demos">
			<ul>
				<?php foreach ($demos_images as $demo) {?>
				<li class="preview-item <?php echo $demo['img'] == 'default.jpg' ? 'active' : ''; ?>" data-theme="<?php echo substr($demo['img'], 0, -4); ?>">
					<a href="#">
						<span class="image-bg" <?php echo empty($demo['bg']) ? '' : 'style="background-image: url(' . $images_root . $demo['bg'] . ');"'; ?>>
							<span class="image-wrap move-<?php echo $demo['anim']; ?>" style="background-image: url('<?php echo $images_root . $demo['img']; ?>');"></span>
						</span>
						<p class="install-option <?php echo $demo['img'] == 'default.jpg' ? 'active' : ''; ?>"><span class="dashicons dashicons-yes"></span><?php echo ucwords(str_replace('_', ' ', substr($demo['img'], 0, -4))); ?></p>
					</a>
				</li>
				<?php } ?>
			</ul>
		</div>

		<!-- Options -->
		<h3 class="install-steps"><?php _e('Step 2', 'mpcth'); ?><small>: <?php _e('Select the elements for import.', 'mpcth'); ?></small></h3>
		<div id="mpcth_options">
			<a id="mpcth_opt_content" class="install-option" href="#"><span class="dashicons dashicons-yes"></span><?php _e('Content', 'mpcth'); ?></a>
			<a id="mpcth_opt_widgets" class="install-option" href="#"><span class="dashicons dashicons-yes"></span><?php _e('Widgets', 'mpcth'); ?></a>
			<a id="mpcth_opt_panel" class="install-option" href="#"><span class="dashicons dashicons-yes"></span><?php _e('Panel settings', 'mpcth'); ?></a>
		</div>

		<!-- Buttons and messages -->
		<h3 class="install-steps"><?php _e('Step 3', 'mpcth'); ?><small>: <?php _e('Proceed with the import.', 'mpcth'); ?></small></h3>
		<span id="mpcth_import_success"><span class="dashicons dashicons-yes"></span><?php _e('All data was successfully imported.', 'mpcth'); ?></span>
		<span id="mpcth_import_process">
			<span class="spinner"></span>
			<span class="step step-backup"><?php _e('Creating backup...', 'mpcth'); ?></span>
			<span class="step step-content"><?php _e('Importing demo content...', 'mpcth'); ?> <span id="mpcth_import_content_progress_value">0%</span></span>
			<span class="step step-widgets"><?php _e('Importing widgets...', 'mpcth'); ?></span>
			<span class="step step-panel"><?php _e('Importing panel settings...', 'mpcth'); ?></span>
			<span id="mpcth_import_content_progress" class="move-quicker"></span>
		</span>
		<a id="mpcth_import" href="#" class="move-quicker"><?php _e('Begin import of', 'mpcth'); ?> <strong>Default</strong></a>
		<span id="mpcth_import_warning" class="move-quicker"><span class="dashicons dashicons-no-alt"></span><?php _e('You must select at least one option for import.', 'mpcth'); ?></span>
		<p class="move-quicker"><?php _e('The import might take a while (up to 20min depending on internet speed). It\'s importing the original demo content.' , 'mpcth'); ?></p>

		<!-- Backups -->
		<div id="mpcth_import_backups">
			<h3 class="install-steps"><?php _e('Backups', 'mpcth'); ?><small>: <?php _e('Your previous WordPress settings.', 'mpcth'); ?></small></h3>
			<ol><?php mpcth_import_backups_list(); ?></ol>
		</div>

		<!-- Exporter -->
		<?php /*<h3 class="install-steps"><?php _e('Exports', 'mpcth'); ?><small>: <?php _e('Current demo data export.', 'mpcth'); ?></small></h3>
		<ul>
			<li><a href="#" id="mpcth_export_demo_widgets">Export Demo Widgets</a></li>
			<li><a href="#" id="mpcth_export_demo_settings">Export Demo Settings</a></li>
		</ul> */ ?>
	</div>
<?php
}

/*----------------------------------------------------------------------------*\
	AJAX STEPS
\*----------------------------------------------------------------------------*/
/* PRE-IMPORT BACKUP */
add_action('wp_ajax_mpcth_import_step_backup', 'mpcth_import_step_backup');
function mpcth_import_step_backup() {
	$mpcth_import_backups_ids = get_option('mpcth_import_backups_ids');

	if (empty($mpcth_import_backups_ids))
		$mpcth_import_backups_ids = array();

	$current_time = (String)time();
	$mpcth_import_backup = mpcth_get_page_settings();

	array_unshift($mpcth_import_backups_ids, $current_time);
	update_option('mpcth_import_backups_ids', $mpcth_import_backups_ids);
	add_option('mpcth_import_backup_' . $current_time, $mpcth_import_backup);

	die(0);
}

/* CONTENT */
add_action('wp_ajax_mpcth_import_step_content_before', 'mpcth_import_step_content_before');
function mpcth_import_step_content_before() {
	if (! isset($_POST['theme']))
		die(0);

	$import_demo = $_POST['theme'];

//	mpcth_pre_import_settings($import_demo);

	$content_part = 0;
	$content = MPC_THEME_PATH . '/demos/data/' . $import_demo . '/content_' . str_pad(++$content_part, 2 , '0', STR_PAD_LEFT) . '.xml';

	while(file_exists($content)) {
		$content = MPC_THEME_PATH . '/demos/data/' . $import_demo . '/content_' . str_pad(++$content_part, 2 , '0', STR_PAD_LEFT) . '.xml';
	}

	die((string)$content_part);
}
add_action('wp_ajax_mpcth_import_step_content_part', 'mpcth_import_step_content_part');
function mpcth_import_step_content_part() {
	if (! isset($_POST['theme']) || ! isset($_POST['part']))
		die(0);

	$import_demo = $_POST['theme'];
	$content_part = $_POST['part'];

	mpcth_pre_import_settings($import_demo);

	if (! empty($content_part))
		$content_part = '_' . str_pad($content_part, 2 , '0', STR_PAD_LEFT);

	$content = MPC_THEME_PATH . '/demos/data/' . $import_demo . '/content' . $content_part . '.xml';
	if (file_exists($content)) {
		if($content_part != '') {
			// Register WooCommerce image sizes
			add_image_size('shop_thumbnail', 100, 100, 1);
			add_image_size('shop_catalog', 300, 400, 1);
			add_image_size('shop_single', 600, 800, 1);
		}

		if (! defined('WP_LOAD_IMPORTERS')) define('WP_LOAD_IMPORTERS', true);
		require_once(MPC_THEME_PATH . '/demos/inc/wordpress-importer.php');

		$wp_import = new WP_Import();
		$wp_import->fetch_attachments = true;
		$wp_import->import($content);
	} else {
		die('1');
	}

	die(0);
}
add_action('wp_ajax_mpcth_import_step_content_after', 'mpcth_import_step_content_after');
function mpcth_import_step_content_after() {
	if (! isset($_POST['theme']))
		die(0);

	mpcth_import_step_wp_menu();
	mpcth_import_step_wp_settings();

	die(0);
}

/* DEMO SETTINGS */
function mpcth_import_step_wp_settings() {
	$import_demo = $_POST['theme'];

	global $wpdb;

	// Data File - content
	$import_settings = mpcth_get_file_content($import_demo . '/settings.txt');

	if (empty($import_settings))
		die(0);

	// WordPress - pages
	update_option('show_on_front', $import_settings['show_on_front']);
	update_option('page_on_front', $import_settings['page_on_front']);

	// WooCommerce - pages
	update_option('woocommerce_shop_page_id', $import_settings['woocommerce']['woocommerce_shop_page_id']);
	update_option('woocommerce_myaccount_page_id', $import_settings['woocommerce']['woocommerce_myaccount_page_id']);
	update_option('woocommerce_cart_page_id', $import_settings['woocommerce']['woocommerce_cart_page_id']);
	update_option('woocommerce_checkout_page_id', $import_settings['woocommerce']['woocommerce_checkout_page_id']);
	update_option('yith_wcwl_wishlist_page_id', $import_settings['woocommerce']['yith_wcwl_wishlist_page_id']);

	// Quickview - change content setting
	$quickview_settings = get_option('jckqvsettings_settings');
	if (! empty($quickview_settings)) {
		$quickview_settings['popup_content_showdesc'] = 'short';
		update_option('jckqvsettings_settings', $quickview_settings);
	}

	// WooCommerce - settings
	update_option('yith_wcwl_button_position', $import_settings['woocommerce']['yith_wcwl_button_position']);
	update_option('shop_catalog_image_size', $import_settings['woocommerce']['shop_catalog_image_size']);
	update_option('shop_single_image_size', $import_settings['woocommerce']['shop_single_image_size']);
	update_option('shop_thumbnail_image_size', $import_settings['woocommerce']['shop_thumbnail_image_size']);

	// WooCommerce - taxonomies
	$attribute_taxonomies = $wpdb->get_results("SELECT attribute_label FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies", 'ARRAY_A');
	$current_attribute_values = array();
	foreach ($attribute_taxonomies as $attribute_taxonomy) {
		$current_attribute_values[] = $attribute_taxonomy['attribute_label'];
	}

	if(! empty($import_settings['woocommerce']['attributes']))
		$demo_attributes = $import_settings['woocommerce']['attributes'];
	else
		$demo_attributes = array();

	$attribute_taxonomies = array_diff($demo_attributes, $current_attribute_values);
	foreach ($attribute_taxonomies as $attribute_taxonomy) {
		$attribute = array(
			'attribute_label'   => $attribute_taxonomy,
			'attribute_name'    => ucwords($attribute_taxonomy),
			'attribute_type'    => 'select',
			'attribute_orderby' => 'menu_order',
		);

		$wpdb->insert($wpdb->prefix . 'woocommerce_attribute_taxonomies', $attribute);
	}

	delete_transient('wc_attribute_taxonomies');
	$attribute_taxonomies = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies");
	set_transient('wc_attribute_taxonomies', $attribute_taxonomies);

	// Refresh pages
	flush_rewrite_rules();
}

/* MENUS */
function mpcth_import_step_wp_menu() {
	$import_demo = $_POST['theme'];

	$menu_locations = get_theme_mod('nav_menu_locations');
	$main_menu = get_term_by('slug', 'demo-main-menu', 'nav_menu');
	$mobile_menu = get_term_by('slug', 'demo-main-menu', 'nav_menu');
	$secondary_menu = get_term_by('slug', 'demo-custom-menu', 'nav_menu');

	if ($main_menu)
		$menu_locations['mpcth_menu'] = $main_menu->term_id;
	if ($mobile_menu)
		$menu_locations['mpcth_mobile_menu'] = $mobile_menu->term_id;
	if ($secondary_menu)
		$menu_locations['mpcth_secondary_menu'] = $secondary_menu->term_id;

	set_theme_mod('nav_menu_locations', $menu_locations);
}

/* WIDGETS */
add_action('wp_ajax_mpcth_import_step_widgets', 'mpcth_import_step_widgets');
function mpcth_import_step_widgets() {
	if (! isset($_POST['theme']))
		die(0);

	$import_demo = $_POST['theme'];

	// Data File - content
	$import_settings = mpcth_get_file_content($import_demo . '/widgets.txt');

	if (empty($import_settings))
		die(0);

	// WordPress - remove wigets
	$widgets_settings = mpcth_get_used_widgets_settings();

	foreach ($widgets_settings as $name => $settings) {
		update_option('widget_' . $name, array());
	}

	// WordPress - update sidebars
	update_option('sidebars_widgets', $import_settings['sidebars_widgets']);

	// WordPress - add widgets
	foreach ($import_settings['widgets_settings'] as $name => $settings) {
		if ($name == 'nav_menu' || $name == 'dc_jqmegamenu_widget') {
			$settings = mpcth_update_menu_id($settings);
		}

		update_option('widget_' . $name, $settings);
	}

	die(0);
}

/* PANEL */
add_action('wp_ajax_mpcth_import_step_panel', 'mpcth_import_step_panel');
function mpcth_import_step_panel() {
	if (! isset($_POST['theme']))
		die(0);

	$mpcth_import_dir = MPC_THEME_PATH . '/demos/data/' . $_POST['theme'];

	$_FILES["import_settings_file"] = array();
	$_FILES["import_settings_file"]["name"] = 'panel.mps';
	$_FILES["import_settings_file"]["type"] = 'application/octet-stream';
	$_FILES["import_settings_file"]["tmp_name"] = $mpcth_import_dir . '/panel.mps';

	mpcth_import_settings(true);
	mpcth_update_custom_styles();

	die(0);
}

/* BACKUPS LIST */
add_action('wp_ajax_mpcth_import_backups_list', 'mpcth_import_backups_list');
function mpcth_import_backups_list() {
	$mpcth_import_backups_ids = get_option('mpcth_import_backups_ids');

	if (! empty($mpcth_import_backups_ids)) {
		foreach ($mpcth_import_backups_ids as $id) { ?>
			<li class="mpcth-backup-info" data-id="<?php echo $id; ?>">
				<?php echo __('Created on ', 'mpcth') . '<em>' . date('Y-m-d', $id) . '</em>' . __(' at ', 'mpcth') . '<em>' . date('H:i:s', $id) . '</em>'; ?>
				<a href="#" class="mpcth-backup-restore move-quicker" data-msg="<?php _e('Are you sure you want to RESTORE the backup?', 'mpcth'); ?>"><span class="dashicons dashicons-yes"></span><?php _e('Restore', 'mpcth'); ?></a>
				<a href="#" class="mpcth-backup-delete move-quicker" data-msg="<?php _e('Are you sure you want to DELETE the backup?', 'mpcth'); ?>"><span class="dashicons dashicons-no-alt"></span><?php _e('Delete', 'mpcth'); ?></a>
				<span class="spinner"></span>
			</li>
		<?php }
	} ?>
	<li class="mpcth-backup-info mpcth-no-backup" data-id="0">
		<?php _e('No backups available.', 'mpcth'); ?>
	</li>
	<?php

	if (isset($_POST['theme']))
		die(0); // Ajax callback end
}

/*----------------------------------------------------------------------------*\
	HELPERS
\*----------------------------------------------------------------------------*/
/* WOOCOMMERCE SETTINGS */
function mpcth_pre_import_settings($import_demo) {
	// Register WooCommerce taxonomies
	$demo_taxonomies = mpcth_get_file_content( $import_demo . '/settings.txt');

	if(! empty($demo_taxonomies['woocommerce']['attributes'])) {
		$product_attributes = $demo_taxonomies['woocommerce']['attributes'];

		foreach ($product_attributes as $attribute) {
			$attribute = 'pa_' . $attribute;
			if (! get_taxonomy($attribute)) {
				register_taxonomy( $attribute,
					apply_filters( 'woocommerce_taxonomy_objects_' . $attribute, array('product') ),
					apply_filters( 'woocommerce_taxonomy_args_' . $attribute, array(
						'hierarchical' => true,
						'show_ui' => false,
						'query_var' => true,
						'rewrite' => false,
					) )
				);
			}
		}
	}

	// Register WooCommerce image sizes
	// add_image_size('shop_thumbnail', 100, 100, 1);
	// add_image_size('shop_catalog', 300, 400, 1);
	// add_image_size('shop_single', 600, 800, 1);
}

/* DATA FILES */
function mpcth_get_file_content($file) {
	if (! isset($file)) return array();

	$file_dir = MPC_THEME_PATH . '/demos/data/' . $file;

	try {
		$file_content = file_get_contents($file_dir);
		$file_content = json_decode($file_content, true);
	} catch(Exception $e) {
		$file_content = array();
	}

	return $file_content;
}

/* WIDGET MENU ID */
function mpcth_update_menu_id($settings) {
	foreach ($settings as $key => $values) {
		if ($key == '_multiwidget') continue;

		$slug = $values['nav_menu'];
		$menu = get_term_by('slug', $slug, 'nav_menu');

		if (! empty($menu)) {
			$values['nav_menu'] = $menu->term_id;
			$settings[$key] = $values;
		}
	}

	return $settings;
}

/*----------------------------------------------------------------------------*\
	BACKUP
\*----------------------------------------------------------------------------*/
/* PAGE SETTINGS */
function mpcth_get_page_settings() {
	$mpcth_import_backup = array();

	$mpcth_import_backup['show_on_front'] = get_option('show_on_front');
	$mpcth_import_backup['page_on_front'] = get_option('page_on_front');
	$mpcth_import_backup['nav_menu_locations'] = get_theme_mod('nav_menu_locations');
	$mpcth_import_backup['sidebars_widgets'] = get_option('sidebars_widgets');
	$mpcth_import_backup['widgets_settings'] = mpcth_get_used_widgets_settings();
	$mpcth_import_backup['woocommerce'] = array(
		'yith_wcwl_button_position' => get_option('yith_wcwl_button_position'),
		'yith_wcwl_wishlist_page_id' => get_option('yith_wcwl_wishlist_page_id'),
		'woocommerce_shop_page_id' => get_option('woocommerce_shop_page_id'),
		'woocommerce_myaccount_page_id' => get_option('woocommerce_myaccount_page_id'),
		'woocommerce_cart_page_id' => get_option('woocommerce_cart_page_id'),
		'woocommerce_checkout_page_id' => get_option('woocommerce_checkout_page_id'),
		'shop_catalog_image_size' => get_option('shop_catalog_image_size'),
		'shop_single_image_size' => get_option('shop_single_image_size'),
		'shop_thumbnail_image_size' => get_option('shop_thumbnail_image_size'),
	);

	return $mpcth_import_backup;
}

/* WIDGET SETTINGS */
function mpcth_get_used_widgets_settings() {
	global $wp_registered_widget_controls;

	$widgets_names = array();
	$widgets_settings = array();

	foreach ($wp_registered_widget_controls as $widget) {
		$widgets_names[$widget['id_base']] = $widget['id_base'];
	}

	foreach ($widgets_names as $name) {
		$widget_settings = get_option('widget_' . $name);

		if(! empty($widget_settings))
			$widgets_settings[$name] = $widget_settings;
	}

	return $widgets_settings;
}

/* RESTORE BACKUP */
add_action('wp_ajax_mpcth_import_backup_restore', 'mpcth_import_backup_restore');
function mpcth_import_backup_restore() {
	if (! isset($_POST['id']))
		die(0);

	$id = $_POST['id'];
	$mpcth_import_backup = get_option('mpcth_import_backup_' . $id);

	if ($mpcth_import_backup) {
		set_theme_mod('nav_menu_locations', $mpcth_import_backup['nav_menu_locations']);

		update_option('show_on_front', $mpcth_import_backup['show_on_front']);
		update_option('page_on_front', $mpcth_import_backup['page_on_front']);
		update_option('sidebars_widgets', $mpcth_import_backup['sidebars_widgets']);

		foreach ($mpcth_import_backup['widgets_settings'] as $name => $settings) {
			update_option('widget_' . $name, $settings);
		}

		foreach ($mpcth_import_backup['woocommerce'] as $name => $settings) {
			update_option($name, $settings);
		}
	}

	die(0);
}

/* DELETE BACKUP */
add_action('wp_ajax_mpcth_import_backup_delete', 'mpcth_import_backup_delete');
function mpcth_import_backup_delete() {
	if (! isset($_POST['id']))
		die(0);

	$id = $_POST['id'];
	$mpcth_import_backups_ids = get_option('mpcth_import_backups_ids');
	$mpcth_import_backup = get_option('mpcth_import_backup_' . $id);
	$backups_index = array_search($id, $mpcth_import_backups_ids);

	if ($backups_index !== false) {
		unset($mpcth_import_backups_ids[$backups_index]);

		update_option('mpcth_import_backups_ids', $mpcth_import_backups_ids);
	}

	if (isset($mpcth_import_backup))
		delete_option('mpcth_import_backup_' . $id);

	die(0);
}

/*----------------------------------------------------------------------------*\
	DEMO EXPORTER
\*----------------------------------------------------------------------------*/
/* DEMO WIDGETS */
add_action('wp_ajax_mpcth_export_demo_widgets', 'mpcth_export_demo_widgets');
function mpcth_export_demo_widgets() {
	$widgets = mpcth_get_demo_widgets();

	header('Content-Disposition: attachment; filename="demo_widgets.txt"');

	echo $widgets;

	die(0);
}

function mpcth_get_demo_widgets() {
	// Widgets
	global $wp_registered_widget_controls;

	$widgets_names = array();
	$widgets_settings = array();

	foreach ($wp_registered_widget_controls as $widget) {
		$widgets_names[$widget['id_base']] = $widget['id_base'];
	}

	foreach ($widgets_names as $name) {
		$widget_settings = get_option('widget_' . $name);

		if ($name == 'nav_menu' || $name == 'dc_jqmegamenu_widget') {
			foreach ($widget_settings as $key => $values) {
				if ($key == '_multiwidget') continue;

				$id = $values['nav_menu'];
				$menu = get_term_by('id', $id, 'nav_menu');

				if (! empty($menu)) {
					$values['nav_menu'] = $menu->slug;
					$widget_settings[$key] = $values;
				}
			}
		}

		if(! empty($widget_settings))
			$widgets_settings[$name] = $widget_settings;
	}

	// Sidebars
	$sidebars_widgets = get_option('sidebars_widgets');

	unset($sidebars_widgets['wp_inactive_widgets']);
	unset($sidebars_widgets['array_version']);

	return json_encode(array('widgets_settings' => $widgets_settings, 'sidebars_widgets' => $sidebars_widgets));
}

/* DEMO SETTINGS */
add_action('wp_ajax_mpcth_export_demo_settings', 'mpcth_export_demo_settings');
function mpcth_export_demo_settings() {
	$settings = mpcth_get_demo_settings();

	header('Content-Disposition: attachment; filename="demo_settings.txt"');

	echo $settings;

	die(0);
}

function mpcth_get_demo_settings() {
	$settings = array();

	$settings['show_on_front'] = get_option('show_on_front');
	$settings['page_on_front'] = get_option('page_on_front');
	$settings['nav_menu_locations'] = get_theme_mod('nav_menu_locations');
	$settings['woocommerce'] = array(
		'yith_wcwl_button_position' => get_option('yith_wcwl_button_position'),
		'yith_wcwl_wishlist_page_id' => get_option('yith_wcwl_wishlist_page_id'),
		'woocommerce_shop_page_id' => get_option('woocommerce_shop_page_id'),
		'woocommerce_myaccount_page_id' => get_option('woocommerce_myaccount_page_id'),
		'woocommerce_cart_page_id' => get_option('woocommerce_cart_page_id'),
		'woocommerce_checkout_page_id' => get_option('woocommerce_checkout_page_id'),
		'shop_catalog_image_size' => get_option('shop_catalog_image_size'),
		'shop_single_image_size' => get_option('shop_single_image_size'),
		'shop_thumbnail_image_size' => get_option('shop_thumbnail_image_size'),
	);

	$attributes = array();
	if (function_exists('wc_get_attribute_taxonomies')) {
		$attributes = wc_get_attribute_taxonomies();
		$settings['woocommerce']['attributes'] = array();
	}
	foreach ($attributes as $attribute) {
		$settings['woocommerce']['attributes'][] = $attribute->attribute_name;
	}

	return json_encode($settings);
}