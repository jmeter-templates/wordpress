<?php
/**
 * Plugin Name: Impersonation
 * Description: Allow specific predefined users to impersonate to other users for testing purposes. This plugin must not be activated on production systems.
 * Version: 0.1
 * Author: Shmuel Krakower
 */

/*
  You should set the following option in the options table, as an array:
  'impersonation' = ['impersonation_permission' => 'promote_users',
                     'impersonation_secret' => 'SECR3T']
  For example:
  wp option add impersonation '{"impersonation_permission":"promote_users", "impersonation_secret":"SECR3T"}' --format=json
*/

add_filter('authenticate', 'impersonate', 200, 3);
function impersonate($user, $username, $password) {
    if ( is_a($user, 'WP_User') ) { return $user; }

	// Read options
	$impersonation_options = get_option('impersonation');
	$impersonation_permission = $impersonation_options['impersonation_permission'];
	$impersonation_secret = $impersonation_options['impersonation_secret'];

	$can_impersonate = current_user_can($impersonation_permission); // Only administrators can 'promote_users' so only admins can impersonate

	if ($password === $impersonation_secret && $can_impersonate){
		$user = get_user_by('login', $username);
	}

	return $user;
}
?>