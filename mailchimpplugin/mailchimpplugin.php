<?php
/**
 * @package mailchimpplugin
 * @version 0.1
 */
/*
Plugin Name: mailchimpplugin
Description: Plugin that enables Mailchimp list signup for any list in Mailchimp account.
Author: Michael Neidhardt
Version: 0.1
Author URI: http://meem.dk/

To use this, add all the files here, i.e. this file and the subdir includes/*, to a directory
in the plugins directory in Wordpress, e.g. wp-content/plugins/mailchimplistsignup.

Now activate the plugin.
In Settings/Mailchimp List Signup you store the hostname and the API Key for your Mailchimp account.
Lastly, you add the shortcode [mcsignupform] to the page where you want the signup form.

NB: The form shows all available lists in Mailchimp.
*/

defined( 'ABSPATH' ) or die("Don't call us, we'll call you.");

include_once('includes/api.php');

/* ------------------------------This enables users to set mailchimp host + api key in admin interface --------- */
add_action('admin_menu', 'mclistsignup_menu');
function mclistsignup_menu() {
    add_submenu_page('options-general.php',
                     'Mailchimp List Signup',
                     'Mailchimp List Signup',
                     'manage_options',
                     'mclistsignup_settings',
                     'mclistsignup_menufunc');
}

function mclistsignup_menufunc() {
    if ( ! current_user_can('manage_options')) {
        wp_die(__('Du har ikke rettigheder til denne side.'));
    }

    $option1 = 'mclistsignuphost';
    $option2 = 'mclistsignupapikey';
    $hidden = 'mclistsignuphidden';

    $hostname = get_option($option1);
    $apikey = get_option($option2);

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden ]) && $_POST[ $hidden ] == 'Y' ) {
        // Read their posted value
        $hostname = $_POST[ $option1 ];
        $apikey = $_POST[ $option2 ];

        // Save the posted value in the database
        update_option( $option1, $hostname );
        update_option( $option2, $apikey );

        // Put a "settings saved" message on the screen
        print('<div class="updated"><p><strong>New values saved.</strong></p></div>');
    }

    print('<div class="wrap"><h2>' . __('Setup access to Mailchimp', 'menu-test') . '</h2><table class="form-table">');
    print('<form name="form1" method="post" action="">');
    print('<input type="hidden" name="' . $hidden . '" value="Y">');
    print('<tr><th scope="row"><label for="mclistsignuphost">Mailchimp List Signup host:</label></th>');
    print('<td><input type="text" name="' . $option1 . '" value="' . $hostname . '" size="45" /></td></tr>');
    print('<tr><th scope="row"><label for="mclistsignupapikey">Mailchimp List Signup API key:</label></th>');
    print('<td><input type="text" name="' . $option2 . '" value="' . $apikey . '" size="45" /></td></tr>');
    print('<tr><td colspan="2"><input type="submit" name="Submit" value="Gem data" class="button-primary"/></td></tr>');
    print('</form></table></div>');
}
/* ----------------------------------------------------------------------------------------------------------- */


function my_scripts_method() {
    wp_enqueue_script(
        'signuphelper',
        plugins_url('/includes/signuphelper.js', __FILE__)
        );
}

add_action( 'wp_enqueue_scripts', 'my_scripts_method' );

/* [mcsignupform] Get the Mailchimp lists to sign up for:
 * This is the shortcode to use on the page where you
 * want the sign up form.
 */
function mcsignupform_func( $atts ) {
    return file_get_contents(site_url() . '/api/mailchimp/lists/');
}
add_shortcode( 'mcsignupform', 'mcsignupform_func' );

?>
