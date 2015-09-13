<?php
/**
 * @file
 * This file contains all of the admin functions.
 *
 * For this module this is only the Admin page. For now.
 */

// Load our required file.
require_once plugin_dir_path(__FILE__) . 'adminfunctions.php';

/**
 * Here we define our groups, later on used to render our form "nicely".
 */
$groups = array(
  array(
    'group' => 'group_account',
    'title' => 'Account information',
  ),
  array(
    'group' => 'group_basic_config',
    'title' => 'Basic settings',
  ),
  array(
    'group' => 'group_woocommerce',
    'title' => 'Woocommerce settings',
  ),
  array(
    'group' => 'group_wpallimport',
    'title' => 'WP All Import settings',
  ),
  array(
    'group' => 'group_basic_data',
    'title' => 'Data settings',
  ),
  array(
    'group' => 'actions',
    'title' => 'Actions',
  ),
);
/**
 * Here we define a list of our fields.
 *
 * The array exists of 4 indexes; Group, name, info, type, length,
 * required, default.
 * Types: text, password, int, boolean.
 * required: TRUE/FALSE.
 */
$fields = array(
  array(
    'field_group'   => 'group_basic_config',
    'field_title'   => 'Language',
    'field_name'    => 'icecat_language',
    'field_type'    => 'text',
    'field_length'  => 2,
    'field_required' => FALSE,
    'field_default' => 'en',
    'field_info'    => 'This field is used to set the language of the fetched data.',
  ),
  array(
    'field_group'   => 'group_basic_config',
    'field_title'   => 'English as fallback',
    'field_name'    => 'icecat_fallback',
    'field_type'    => 'boolean',
    'field_length'  => 1,
    'field_required' => FALSE,
    'field_default' => 1,
    'field_info'    => 'When the product is not available in your language, we can try and download the english version.',
  ),
  array(
    'field_group'   => 'group_basic_config',
    'field_title'   => 'Download on save',
    'field_name'    => 'icecat_on_save',
    'field_type'    => 'boolean',
    'field_length'  => 1,
    'field_required' => FALSE,
    'field_default' => 1,
    'field_info'    => 'You can disable this if you only want to use wp all import.',
  ),
  array(
    'field_group'   => 'group_account',
    'field_title'   => 'Username',
    'field_name'    => 'icecat_username',
    'field_type'    => 'text',
    'field_length'  => 32,
    'field_required' => TRUE,
  ),
  array(
    'field_group'   => 'group_account',
    'field_title'   => 'Password',
    'field_name'    => 'icecat_password',
    'field_type'    => 'password',
    'field_length'  => 64,
    'field_required' => TRUE,
  ),
  array(
    'field_group'   => 'group_basic_data',
    'field_title'   => 'Update title',
    'field_name'    => 'icecat_update_title',
    'field_type'    => 'boolean',
    'field_length'  => 1,
    'field_required' => FALSE,
    'field_info'    => 'When checked, the product or page title will be updated.',
  ),
  array(
    'field_group'   => 'group_basic_data',
    'field_title'   => 'Update body',
    'field_name'    => 'icecat_update_body',
    'field_type'    => 'boolean',
    'field_length'  => 1,
    'field_required' => FALSE,
    'field_info'    => 'When checked, the product or page title will be updated.',
  ),
  array(
    'field_group'   => 'group_basic_data',
    'field_title'   => 'Download images',
    'field_name'    => 'icecat_download_images',
    'field_type'    => 'boolean',
    'field_length'  => 1,
    'field_required' => FALSE,
    'field_info'    => 'Download images from Icecat.',
  ),
  array(
    'field_group'   => 'group_basic_data',
    'field_title'   => 'Set Category',
    'field_name'    => 'icecat_set_category',
    'field_type'    => 'boolean',
    'field_length'  => 1,
    'field_required' => FALSE,
    'field_info'    => 'Set the product/page category automatically.',
  ),
  array(
    'field_group'   => 'group_basic_data',
    'field_title'   => 'Download specifications',
    'field_name'    => 'icecat_extra_specs',
    'field_type'    => 'boolean',
    'field_length'  => 1,
    'field_required' => FALSE,
    'field_info'    => 'If yes we will download specifications.',
  ),
  array(
    'field_group'   => 'group_basic_data',
    'field_title'   => 'Body specifications',
    'field_name'    => 'icecat_specs_body',
    'field_type'    => 'boolean',
    'field_length'  => 1,
    'field_required' => FALSE,
    'field_info'    => 'Add the specifications as body data.',
  ),
  array(
    'field_group'   => 'group_woocommerce',
    'field_title'   => 'Enable Woocommerce',
    'field_name'    => 'icecat_woocommerce',
    'field_type'    => 'boolean',
    'field_length'  => 1,
    'field_required' => FALSE,
    'field_info'    => 'Enable this plugin for Woocommerce.',
    'requiredplugin' => 'woocommerce/woocommerce.php',
  ),
  array(
    'field_group'   => 'group_woocommerce',
    'field_title'   => 'specifications as attributes',
    'field_name'    => 'icecat_specs_attributes',
    'field_type'    => 'boolean',
    'field_length'  => 1,
    'field_required' => FALSE,
    'field_info'    => 'This will download the specifications into the product attributes.',
    'requiredplugin' => 'woocommerce/woocommerce.php',
  ),
  array(
    'field_group'   => 'group_woocommerce',
    'field_title'   => 'Update sku',
    'field_name'    => 'icecat_set_sku',
    'field_type'    => 'boolean',
    'field_length'  => 1,
    'field_required' => FALSE,
    'field_info'    => 'This will update the product with the fetched sku.',
    'requiredplugin' => 'woocommerce/woocommerce.php',
  ),
  array(
    'field_group'   => 'group_wpallimport',
    'field_title'   => 'WP All Import',
    'field_name'    => 'icecat_wp_all_import',
    'field_type'    => 'boolean',
    'field_length'  => 1,
    'field_required' => FALSE,
    'field_info'    => 'Enables wp all import support.',
    'requiredplugin' => 'wp-all-import-pro/wp-all-import-pro.php',
  ),
  array(
    'field_group'   => 'group_wpallimport',
    'field_title'   => 'Multiple images',
    'field_name'    => 'icecat_wp_all_import_multiimage',
    'field_type'    => 'boolean',
    'field_length'  => 1,
    'field_required' => FALSE,
    'field_info'    => 'Set this to configure if allimport should download multiple images.',
    'requiredplugin' => 'wp-all-import-pro/wp-all-import-pro.php',
  ),
  array(
    'field_group'   => 'group_wpallimport',
    'field_title'   => 'Image amount',
    'field_name'    => 'icecat_image_amount',
    'field_type'    => 'text',
    'field_length'  => 3,
    'field_required' => FALSE,
    'field_default' => 0,
    'field_info'    => 'Set the amount of images to download. <strong>0 to download all</strong>.',
    'requiredplugin' => 'wp-all-import-pro/wp-all-import-pro.php',
  ),
  array(
    'field_group'   => 'actions',
    'field_title'   => 'Save settings',
    'field_name'    => 'Submit',
    'field_default' => 'Save',
    'field_type'    => 'submit',
  ),
);

/**
 * Frist we check if our form has been submitted.
 *
 * If so, we validate and save the data.
 */
if (form_is_submitted($fields)) {
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
