<?php
/**
 * Plugin Name: Paid Memberships Pro - Reason For Cancelling Add On
 * Plugin URI: https://www.paidmembershipspro.com/add-ons/pmpro-reason-cancelling/
 * Description: Adds a field to specify a reason for cancelling to the cancel page.
 * Version: 0.2
 * Author: Paid Memberships Pro
 * Author URI: https://www.paidmembershipspro.com
 * Text Domain: pmpro-reason-for-cancelling
 * Domain Path: /languages
 */

// use our cancel template
function pmpror4c_pages_custom_template_path( $templates, $page_name ) {		
	$templates[] = plugin_dir_path(__FILE__) . 'templates/' . $page_name . '.php';	

	return $templates;
}
add_filter( 'pmpro_pages_custom_template_path', 'pmpror4c_pages_custom_template_path', 10, 2 );

// make sure they enter a reason
function pmpror4c_init() {
	if ( ! empty( $_REQUEST['confirm'] ) && ! empty( $_REQUEST['membership_cancel'] ) && empty( $_REQUEST['reason'] ) ) {
		global $pmpro_msg, $pmpro_msgt;
		$_REQUEST['confirm'] = null;
		$pmpro_msg = __( 'Please enter a reason for cancelling.', 'pmpro-reason-for-cancelling' );
		$pmpro_msgt = 'pmpro_error';
	}
}
add_action( 'init', 'pmpror4c_init' );

// Save the reason to the last order.
function pmpror4c_save_reason_to_last_order( $level_id, $user_id, $cancel_level ) {

	if ( ! empty( $_REQUEST['reason'] ) && $level_id === 0 ) {
		$reason = wp_unslash( sanitize_text_field( $_REQUEST['reason'] ) );

		$order = new MemberOrder();
		if ( $order->getlastMemberOrder( $user_id, array("", "success", "cancelled"), $cancel_level ) ) {
			$order->notes .= __( 'Reason for cancelling:', 'pmpro-reason-for-cancelling' ) . ' ' . $reason;
			$order->saveOrder();
		}
	}
}
add_action( 'pmpro_after_change_membership_level', 'pmpror4c_save_reason_to_last_order', 10, 3 );

// add reason to cancel email
function pmpror4c_pmpro_email_body( $body, $email ) {
	if( !empty( $_REQUEST['reason'] ) ) {
		$reason = wp_unslash( sanitize_text_field( $_REQUEST['reason'] ) );
	} else {
		$reason = __( 'N/A', 'pmpro-reason-for-cancelling' );
	}

	// replace in standard templates
	if ( $email->template == 'cancel' || $email->template == 'cancel_admin' ) {
		$body = str_replace( 'has been cancelled.</p>', 'has been cancelled.</p><p>Reason: ' . $reason . '</p>', $body );
	}

	// or replace in custom template
	$body = str_replace( '!!reason!!', $reason, $body );

	return $body;
}
add_action( 'pmpro_email_body', 'pmpror4c_pmpro_email_body', 10, 2 );


function pmpro_cancel_reason_load_textdomain() {
	$plugin_rel_path = basename( dirname( __FILE__ ) ) . '/languages';
	load_plugin_textdomain( 'pmpro-reason-for-cancelling', false, $plugin_rel_path );
}
add_action( 'plugins_loaded', 'pmpro_cancel_reason_load_textdomain' );
