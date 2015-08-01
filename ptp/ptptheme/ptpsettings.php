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
    $hidden = 'ptpsettingshidden';

    $picsperrow = get_option($option1);

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden ]) && $_POST[ $hidden ] == 'Y' ) {
        // Read their posted value
        $picsperrow = $_POST[ $option1 ];

        // Save the posted value in the database
        update_option( $option1, $picsperrow );

        // Put a "settings saved" message on the screen
        print('<div class="updated"><p><strong>New values saved.</strong></p></div>');
    }

    print('<div class="wrap"><h2>' . __('Setup stuff', 'menu-test') . '</h2><table class="form-table">');
    print('<form name="form1" method="post" action="">');
    print('<input type="hidden" name="' . $hidden . '" value="Y">');
    print('<tr><th scope="row"><label for="' . $option1 . '">Pictures per row on main page:</label></th>');
    print('<td><input type="text" name="' . $option1 . '" value="' . $picsperrow . '" size="45" /></td></tr>');
    print('<tr><td colspan="2"><input type="submit" name="Submit" value="Save" class="button-primary"/></td></tr>');
    print('</form></table></div>');
}
/* ----------------------------------------------------------------------------------------------------------- */

