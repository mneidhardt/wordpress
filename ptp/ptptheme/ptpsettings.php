<?php
/* ------------------------------This enables users to set mailchimp host + api key in admin interface --------- */
add_action('admin_menu', 'ptpconfig_menu');

function ptpconfig_menu() {
    add_submenu_page('options-general.php',
                     'PTP Config',
                     'PTP Config',
                     'manage_options',
                     'ptpconfig_settings',
                     'ptpconfig_menufunc');
}

function ptpconfig_menufunc() {
    if ( ! current_user_can('manage_options')) {
        wp_die(__('Du har ikke rettigheder til denne side.'));
    }

    $option1 = 'ptppicsperrow';
    $option2 = 'ptpbulkimportsubdir';
    $option3 = 'ptpbulkimportcategory';
    $hidden1 = 'hidden1';
    $hidden2 = 'hidden2';

    $picsperrow = get_option($option1);

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden1 ]) && $_POST[ $hidden1 ] == 'Y' ) {
        // Read their posted value
        $picsperrow = $_POST[ $option1 ];
        if ( ! preg_match('/^\d{1,3}$/', $picsperrow)) {
            $picsperrow = 3;
        }
        update_option( $option1, $picsperrow );

        // Put a "settings saved" message on the screen
        print('<div class="updated"><p><strong>New values saved.</strong></p></div>');
    } elseif( isset($_POST[ $hidden2 ]) && $_POST[ $hidden2 ] == 'Y' ) {
        $result = bulkimport($_POST[$option2], $_POST[$option3]);
        print('<div class="updated"><p><strong>Attempted image import: ' . $result . '</strong></p></div>');
    }

    print('<div class="wrap"><h2>' . __('Setup stuff', 'menu-test') . '</h2><table class="form-table">');
    print('<form name="form1" method="post" action="">');
    print('<input type="hidden" name="' . $hidden1 . '" value="Y">');
    print('<tr><th scope="row"><label for="' . $option1 . '">Pictures per row on main page:</label></th>');
    print('<td><input type="number" name="' . $option1 . '" value="' . $picsperrow . '" size="45" /></td></tr>');
    print('<tr><td colspan="2"><input type="submit" name="Submit" value="Save" class="button-primary"/></td></tr>');
    print('</form></table><hr>');

    print('Bulk image import<br><table class="form-table">');
    print('<form name="form2" method="post" action="">');
    print('<input type="hidden" name="' . $hidden2 . '" value="Y">');
    print('<tr><th scope="row"><label for="' . $option2 . '">Location<br>(below uploads dir):</label></th>');
    print('<td><input type="text" name="' . $option2 . '" size="45" /></td></tr>');
    print('<tr><th scope="row"><label for="' . $option3 . '">Category</label></th>');
    print('<td><input type="text" name="' . $option3 . '" /></td></tr>');
    print('<tr><td colspan="2"><input type="submit" name="Import" value="Import" class="button-primary"/></td></tr>');
    print('</form></table></div>');
}

function bulkimport($subdir, $category) {
    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    $dir = wp_upload_dir();
    $files = glob($dir['basedir'] . "/bulk/$subdir/*");

    if (is_array($files) && sizeof($files) > 0) {
        asort($files);
        $count=0;
    
        foreach ($files as $file) {
            ++$count;
    
           $post = array(
               'post_title' => $category,
               'post_content' => '',
               'post_status' => 'publish',
               'post_category'  => array(get_cat_id($category))
               );
    
           $PID = wp_insert_post($post);
           $filetype = wp_check_filetype( basename($file), null );
    
           $attachment = array(
               'post_mime_type' => $filetype['type'],
               'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
               'post_content'   => '',
               'post_status'    => 'inherit',
           );
    
           // Insert the attachment.
           $attach_id = wp_insert_attachment( $attachment, $file, $PID);
           
           // Generate the metadata for the attachment, and update the database record.
           $attach_data = wp_generate_attachment_metadata($attach_id, $file);
           wp_update_attachment_metadata($attach_id, $attach_data);
           set_post_thumbnail($PID, $attach_id);
        }
    
        return('Imported ' . $count . ' files. Found ' . sizeof($files) . ' in ' . $subdir . ' Catg=' . $category);
    } else {
        return('Did not import anything.');
    }
}
/* ----------------------------------------------------------------------------------------------------------- */

