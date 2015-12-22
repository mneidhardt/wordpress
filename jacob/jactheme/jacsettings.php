<?php
add_action('admin_menu', 'jacconfig_menu');

function jacconfig_menu() {
    add_submenu_page('options-general.php',
                     'Jac Config',
                     'Jac Config',
                     'manage_options',
                     'jacconfig_settings',
                     'jacconfig_menufunc');
}

function jacconfig_menufunc() {
    if ( ! current_user_can('manage_options')) {
        wp_die(__('Du har ikke rettigheder til denne side.'));
    }

    $option1 = 'jacfbtoken';
    $hidden1 = 'hidden1';
    $hidden2 = 'hidden2';

    $jacfbtoken = get_option($option1);

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden1 ]) && $_POST[ $hidden1 ] == 'Y' ) {
        // Read their posted value
        $jacfbtoken = $_POST[ $option1 ];
        update_option( $option1, $jacfbtoken );

        // Put a "settings saved" message on the screen
        print('<div class="updated"><p><strong>New values saved.</strong></p></div>');
    } elseif (isset($_POST[ $hidden2 ]) && $_POST[ $hidden2 ] == 'Y' ) {
        createPage('Artikler');
        createPage('Boger');
        createPage('Foredrag');
        createPage('Radio');
        createPage('Kontakt');
    }

    print('<div class="wrap"><h2>' . __('Setup stuff', 'menu-test') . '</h2><table class="form-table">');
    print('<form name="form1" method="post" action="">');
    print('<input type="hidden" name="' . $hidden1 . '" value="Y">');
    print('<tr><th scope="row"><label for="' . $option1 . '">Facebook token:</label></th>');
    print('<td><input type="text" name="' . $option1 . '" value="' . $jacfbtoken . '" size="45" /></td></tr>');
    print('<tr><td colspan="2"><input type="submit" name="Submit" value="Save" class="button-primary"/></td></tr>');
    print('</form></table><hr>');

    print('<table class="form-table">');
    print('<form name="form2" method="post" action="">');
    print('<input type="hidden" name="' . $hidden2 . '" value="Y">');
    print('<tr><td>Default pages</td><td><input type="submit" name="Create" value="Create" class="button-primary"/></td></tr>');
    print('</form></table></div>');
}

function createPage($type) {
    $post = array(
        'post_title' => $type,
        'post_content' => 'Never delete this page',
        'post_status' => 'publish',
        'post_type'  => 'page'
        );

    $PID = wp_insert_post($post);
}
