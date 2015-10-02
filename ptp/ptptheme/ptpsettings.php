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
    $option2 = 'ptpbulkimageimport';
    $hidden = 'ptpsettingshidden';

    $picsperrow = get_option($option1);

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden ]) && $_POST[ $hidden ] == 'Y' ) {
        // Read their posted value
        $picsperrow = $_POST[ $option1 ];
        $bulkimport = $_POST[ $option2 ];
        if (isset($bulkimport) && $bulkimport == 'on') {
            bulkimport();
        }

        // Save the posted value in the database
        if ( ! preg_match('/^\d{1,3}$/', $picsperrow)) {
            $picsperrow = 2;
        }
        update_option( $option1, $picsperrow );

        // Put a "settings saved" message on the screen
        print('<div class="updated"><p><strong>New values saved.</strong></p></div>');
    }

    print('<div class="wrap"><h2>' . __('Setup stuff', 'menu-test') . '</h2><table class="form-table">');
    print('<form name="form1" method="post" action="">');
    print('<input type="hidden" name="' . $hidden . '" value="Y">');
    print('<tr><th scope="row"><label for="' . $option1 . '">Pictures per row on main page:</label></th>');
    print('<td><input type="number" name="' . $option1 . '" value="' . $picsperrow . '" size="45" /></td></tr>');
    print('<tr><th scope="row"><label for="' . $option2 . '">Bulk import images?</label></th>');
    print('<td><input type="checkbox" name="' . $option2 . '" /></td></tr>');
    print('<tr><td colspan="2"><input type="submit" name="Submit" value="Save" class="button-primary"/></td></tr>');
    print('</form></table></div>');
}

function bulkimport() {
    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    // $dir = wp_upload_dir()['basedir'] . '/bulk';
    $dir = wp_upload_dir();
    $files = glob($dir['basedir'] . '/bulk/*');

    $count=0;

    foreach ($files as $file) {
        ++$count;
        // error_log($file);

       $post = array(
           'post_title' => $count,
           'post_content' => '',
           );

       $PID = wp_insert_post($post);
       $filetype = wp_check_filetype( basename($file), null );

       $attachment = array(
           'guid'           => $dir['url'] . '/' . basename($file), 
           'post_mime_type' => $filetype['type'],
           'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
           'post_content'   => '',
           'post_status'    => 'inherit'
       );
       // Insert the attachment.
       $attach_id = wp_insert_attachment( $attachment, $file, $PID);
       
       
       // Generate the metadata for the attachment, and update the database record.
       $attach_data = wp_generate_attachment_metadata($attach_id, $file);
       wp_update_attachment_metadata($attach_id, $attach_data);

    }

    // error_log(print_r($files, true));
}
/* ----------------------------------------------------------------------------------------------------------- */

