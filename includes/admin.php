<?php
/**
 * @file
 * This file contains all of the admin functions.
 *
 * For this module this is only the Admin page. For now.
 */

// If our helper function is not yet available, we include the file containing
// it. Make it so that it does not load twice.
if (!function_exists('renderForm')) {
  // Load our required file.
  require_once plugin_dir_path(__FILE__) . 'adminfunctions.php';
}

/**
 * Here we define our groups, later on used to render our form "nicely".
 */
$groups = [
  [
    'group' => 'group_account',
    'title' => __('Account information', 'icecat'),
  ],
  [
    'group' => 'group_basic_config',
    'title' => __('Basic settings', 'icecat'),
  ],
  [
    'group' => 'group_woocommerce',
    'title' => __('Woocommerce settings', 'icecat'),
  ],
  [
    'group' => 'group_wpallimport',
    'title' => __('WP All Import settings', 'icecat'),
  ],
  [
    'group' => 'group_basic_data',
    'title' => __('Data settings', 'icecat'),
  ],
  [
    'group' => 'actions',
    'title' => __('Actions', 'icecat'),
  ],
];
/**
 * Here we define a list of our fields.
 *
 * The array exists of 4 indexes; Group, name, info, type, length,
 * required, default.
 * Types: text, password, int, boolean.
 * required: TRUE/FALSE.
 */
$fields = [
  [
    'field_group' => 'group_basic_config',
    'field_title' => __('Language', 'icecat'),
    'field_name' => 'icecat_language',
    'field_type'  => 'text',
    'field_length' => 2,
    'field_required' => FALSE,
    'field_default' => 'en',
    'field_info' => __('This field is used to set the language of the fetched data.', 'icecat'),
  ],
  [
    'field_group' => 'group_basic_config',
    'field_title' => __('English as fallback', 'icecat'),
    'field_name' => 'icecat_fallback',
    'field_type' => 'boolean',
    'field_length' => 1,
    'field_required' => FALSE,
    'field_default' => 1,
    'field_info' => __('When the product is not available in your language, we can try and download the english version.', 'icecat'),
  ],
  [
    'field_group' => 'group_basic_config',
    'field_title' => __('Download on save', 'icecat'),
    'field_name' => 'icecat_on_save',
    'field_type' => 'boolean',
    'field_length' => 1,
    'field_required' => FALSE,
    'field_default' => 1,
    'field_info' => __('You can disable this if you only want to use wp all import.', 'icecat'),
  ],
  [
    'field_group' => 'group_account',
    'field_title' => __('Username', 'icecat'),
    'field_name' => 'icecat_username',
    'field_type' => 'text',
    'field_length' => 32,
    'field_required' => TRUE,
    'field_default' => '',
  ],
  [
    'field_group' => 'group_account',
    'field_title' => __('Password', 'icecat'),
    'field_name' => 'icecat_password',
    'field_type' => 'password',
    'field_length' => 64,
    'field_required' => TRUE,
    'field_default' => '',
  ],
  [
    'field_group' => 'group_basic_data',
    'field_title' => __('Update title', 'icecat'),
    'field_name' => 'icecat_update_title',
    'field_type' => 'boolean',
    'field_length' => 1,
    'field_required' => FALSE,
    'field_default' => 0,
    'field_info' => __('When checked, the product or page title will be updated.', 'icecat'),
  ],
  [
    'field_group' => 'group_basic_data',
    'field_title' => __('Disable on success', 'icecat'),
    'field_name' => 'icecat_disable_on_success',
    'field_type' => 'boolean',
    'field_length' => 1,
    'field_required' => FALSE,
    'field_default' => 0,
    'field_info' => __('When checked, the entity will be marked as "do not update" you can unmark it from the entity edit form', 'icecat'),
  ],
  [
    'field_group' => 'group_basic_data',
    'field_title' => __('Update body', 'icecat'),
    'field_name' => 'icecat_update_body',
    'field_type' => 'boolean',
    'field_length' => 1,
    'field_required' => FALSE,
    'field_default' => 0,
    'field_info' => __('When checked, the product or page title will be updated.', 'icecat'),
  ],
  [
    'field_group' => 'group_basic_data',
    'field_title' => __('Download images', 'icecat'),
    'field_name' => 'icecat_download_images',
    'field_type' => 'boolean',
    'field_length' => 1,
    'field_required' => FALSE,
    'field_default' => 0,
    'field_info' => __('Download images from Icecat.', 'icecat'),
  ],
  [
    'field_group' => 'group_basic_data',
    'field_title' => __('Set Category', 'icecat'),
    'field_name' => 'icecat_set_category',
    'field_type' => 'boolean',
    'field_length' => 1,
    'field_required' => FALSE,
    'field_default' => 0,
    'field_info' => __('Set the product/page category automatically.', 'icecat'),
  ],
  [
    'field_group' => 'group_basic_data',
    'field_title' => __('Download specifications', 'icecat'),
    'field_name' => 'icecat_extra_specs',
    'field_type' => 'boolean',
    'field_length' => 1,
    'field_required' => FALSE,
    'field_default' => 0,
    'field_info' => __('If yes we will download specifications.', 'icecat'),
  ],
  [
    'field_group' => 'group_basic_data',
    'field_title' => __('Body specifications', 'icecat'),
    'field_name' => 'icecat_specs_body',
    'field_type' => 'boolean',
    'field_length' => 1,
    'field_required' => FALSE,
    'field_default' => 0,
    'field_info' => __('Add the specifications as body data.', 'icecat'),
  ],
  [
    'field_group' => 'group_woocommerce',
    'field_title' => __('Enable Woocommerce', 'icecat'),
    'field_name' => 'icecat_woocommerce',
    'field_type' => 'boolean',
    'field_length' => 1,
    'field_required' => FALSE,
    'field_default' => 0,
    'field_info' => __('Enable this plugin for Woocommerce.', 'icecat'),
    'requiredplugin' => 'woocommerce/woocommerce.php',
  ],
  [
    'field_group' => 'group_woocommerce',
    'field_title' => __('specifications as attributes', 'icecat'),
    'field_name' => 'icecat_specs_attributes',
    'field_type' => 'boolean',
    'field_length' => 1,
    'field_required' => FALSE,
    'field_default' => 0,
    'field_info' => __('This will download the specifications into the product attributes.', 'icecat'),
    'requiredplugin' => 'woocommerce/woocommerce.php',
  ],
  [
    'field_group' => 'group_woocommerce',
    'field_title' => __('Update sku', 'icecat'),
    'field_name' => 'icecat_set_sku',
    'field_type' => 'boolean',
    'field_length' => 1,
    'field_required' => FALSE,
    'field_default' => 0,
    'field_info' => __('This will update the product with the fetched sku.', 'icecat'),
    'requiredplugin' => 'woocommerce/woocommerce.php',
  ],
  [
    'field_group' => 'group_wpallimport',
    'field_title' => __('WP All Import', 'icecat'),
    'field_name' => 'icecat_wp_all_import',
    'field_type' => 'boolean',
    'field_length' => 1,
    'field_required' => FALSE,
    'field_default' => 0,
    'field_info' => __('Enables wp all import support.', 'icecat'),
    'requiredplugin' => 'wp-all-import-pro/wp-all-import-pro.php',
  ],
  [
    'field_group' => 'group_wpallimport',
    'field_title' => __('Multiple images', 'icecat'),
    'field_name' => 'icecat_wp_all_import_multiimage',
    'field_type' => 'boolean',
    'field_length' => 1,
    'field_required' => FALSE,
    'field_default' => 0,
    'field_info' => __('Set this to configure if allimport should download multiple images.', 'icecat'),
    'requiredplugin' => 'wp-all-import-pro/wp-all-import-pro.php',
  ],
  [
    'field_group' => 'group_wpallimport',
    'field_title' => __('Image amount', 'icecat'),
    'field_name' => 'icecat_image_amount',
    'field_type' => 'text',
    'field_length' => 3,
    'field_required' => FALSE,
    'field_default' => '',
    'field_info' => __('Set the amount of images to download. <strong>0 to download all</strong>.', 'icecat'),
    'requiredplugin' => 'wp-all-import-pro/wp-all-import-pro.php',
  ],
  [
    'field_group' => 'actions',
    'field_title' => __('Save settings', 'icecat'),
    'field_name' => 'Submit',
    'field_default' => __('Save', 'icecat'),
    'field_type' => 'submit',
  ],
];

/**
 * Frist we check if our form has been submitted.
 *
 * If so, we validate and save the data.
 */
if (form_is_submitted($fields, 'icecat_hidden')) {
  // Update options.
  ?>
  <div class="updated">
      <p><strong>Icecat: </strong> <?php _e('Data has been saved.', 'icecat'); ?> </p>
  </div>
  <?php
}

/**
 * Always show our form.
 */
// Get our field defaults.
$fields = fields_set_default_values($fields);
// Open the form tag.
?>
<link href="<?php echo plugin_dir_url(__FILE__); ?>../assets/css/icecatadmin.css" rel="stylesheet">
<form name="icecat_settings_form" method="post" action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">
  <input type="hidden" name="icecat_hidden" id="icecat_hidden" value="Y" />
  <?php print renderForm($groups, $fields); ?>
</form>
