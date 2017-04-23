<?php
/**
 * @file
 * This file contains the functions used in admin.php.
 */

/**
 * Function to render our form.
 */
function renderForm($groups, $fields) {
  // Set the counter.
  $row = 0;
  // Open up our row.
  $render = '<div class="wrap">';
  $render .= '<h1>' . __('Icecat settings', 'icecat') . '</h1>';
  // Loop our groups.
  foreach ($groups as $group) {
    // Render the group.
    $render .= renderGroup(
      $group['group'],
      $group['title'],
      $fields
    );
    // Increment count.
    $row++;
    // Close if 2 rows.
    if ($row == 2) {
      $render .= '</div><div class="row">';
      $row = 0;
    }
  }
  // Close the open row.
  $render .= '</div>';
  // Return our render.
  return $render;
}

/**
 * Function to render our Groups.
 */
function renderGroup($group, $group_title, $fields) {
  // Title.
  $render = '<h2 class="title">' . __($group_title, 'icecat') . '</h2>';
  // Open up our div.
  $render .= '<table class="form-table">';
  // Loop our fields, if group matches, render it.
  foreach ($fields as $field) {
    if ($field['field_group'] == $group) {
      $render .= renderField($field);
    }
  }
  // Close our div.
  $render .= '</table>';
  // Return our render.
  return $render;
}

/**
 * Function to render our Fields.
 */
function renderField($field) {
  // Init our return value.
  $render = NULL;
  // Render fields.
  if (isset($field['field_type'])) {

    // Default render prefix.
    $render .= '<tr>';
    $render .= '<th>' . __($field['field_title']) . '</th>';
    $render .= '<td>';
    // Case: Textfield.
    if ($field['field_type'] == 'text' || $field['field_type'] == 'password') {
      // Opening tag.
      $render .= '<input type="' . $field['field_type'] . '" ';
      $render .= 'name="' . $field['field_name'] . '" ';
      // Only if we have a default value.
      if (isset($field['field_default'])) {
        $render .= 'value="' . $field['field_default'] . '" ';
      }
      $render .= 'size="' . $field['field_length'] . '" class="regular-text">';

    }

    // Case: Checkboxes.
    if ($field['field_type'] == 'boolean') {

      if (isset($field['field_default']) && $field['field_default'] == 1) {
        $checked = 'checked="checked"';
      }
      else {
        $checked = NULL;
      }

      $render .= '<label><input type="checkbox" ';
      $render .= 'name="' . $field['field_name'] . '" ';
      $render .= $checked . '>';
    }

    // Case: Selectlist.
    if ($field['field_type'] == 'select' && isset($field['field_options'])) {

      $render .= '<select ';
      $render .= 'name="' . $field['field_name'] . '">';

      foreach ($field['field_options'] as $key => $value) {
        if ($key == $field['field_default']) {
          $render .= '<option selected="selected" value="' . $key . '">' . $value . '</option>';
        }
        else {
          $render .= '<option value="' . $key . '">' . $value . '</option>';
        }
      }
      $render .= '</select>';
    }

    // Case: Save button.
    if ($field['field_type'] == 'submit') {
      $render .= '<p class="submit">';
      $render .= '<input type="submit" class="button button-primary" ';
      $render .= 'name="' . $field['field_name'] . '" ';
      $render .= 'value="' . $field['field_default'] . '">';
      $render .= '</p>';
    }

    // If set render the description.
    if (isset($field['field_info']) && $field['field_info'] != '') {
      if ($field['field_type'] !== 'boolean') {
        $render .= '<p class="description">';
      }
      $render .= __($field['field_info']);
      if ($field['field_type'] !== 'boolean') {
        $render .= '</p>';
      }
    }

    if ($field['field_type'] === 'boolean') {
      $render .= '</label>';
    }

    // Close our div.
    $render .= '</td></tr>';
  }
  // Return our render.
  return $render;

}

/**
 * This function simply checks if we have a form submission.
 */
function form_is_submitted($fields, $checker) {
  // Check if the required post fields are available.
  if (isset($_POST[$checker]) && $_POST[$checker] == "Y") {
    foreach ($fields as $key => $field) {
      if ($field['field_name'] !== 'Submit') {
        // If our field is in the post.
        if (isset($_POST[$field['field_name']])) {
          $value = $_POST[$field['field_name']];
        }
        else {
          $value = 'off';
        }
        if (!update_option($field['field_name'], $value) && !get_option($field['field_name'])) {
          add_option($field['field_name'], $value);
        }
      }
    }
    return TRUE;
  }
  else {
    return FALSE;
  }
}

/**
 * Function to set the saved values.
 */
function fields_set_default_values($fields) {
  $boolean_fields = array('boolean');
  // Loop over our fields, and process the data we allready have.
  foreach ($fields as $key => $field) {
    // We dont need to check buttons.
    if ($field['field_type'] !== 'submit') {
      // Check if on/off should be 1/0.
      $is_boolean = in_array($field['field_type'], $boolean_fields);
      if ($is_boolean && get_option($field['field_name']) == 'on') {
        $value = 1;
      }
      elseif ($is_boolean && get_option($field['field_name']) == 'off') {
        $value = 0;
      }
      else {
        $value = get_option($field['field_name'], $field['field_default']);
      }
      $fields[$key]['field_default'] = $value;
    }
  }
  // Return the updated array.
  return $fields;
}
