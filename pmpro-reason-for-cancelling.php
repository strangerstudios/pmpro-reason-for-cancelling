<?php
/*
Plugin Name: PMPro Reason For Cancelling
Plugin URI: http://www.paidmembershipspro.com/wp/pmpro-reason-for-cancelling/
Description: Adds a field to specify a reason for cancelling to the cancel page.
Version: .1.1
Author: Stranger Studios
Author URI: http://www.strangerstudios.com
*/

//use our checkout template
function pmpror4c_pmpro_pages_shortcode_cancel($content)
{
	ob_start();
	include(plugin_dir_path(__FILE__) . "templates/cancel.php");
	$temp_content = ob_get_contents();
	ob_end_clean();
	return $temp_content;
}
add_filter("pmpro_pages_shortcode_cancel", "pmpror4c_pmpro_pages_shortcode_cancel");

//make sure they enter a reason
function pmpror4c_init()
{
	if(!empty($_REQUEST['confirm']) && !empty($_REQUEST['membership_cancel']) && empty($_REQUEST['reason']))
	{
		global $pmpro_msg, $pmpro_msgt;
		$_REQUEST['confirm'] = NULL;
		$pmpro_msg = "Please enter a reason for cancelling.";
		$pmpro_msgt = "pmpro_error";
	}
}
add_action("init", "pmpror4c_init");

//add reason to cancel email
function pmpror4c_pmpro_email_body($body, $email)
{
	$reason = sanitize_text_field($_REQUEST['reason']);

	//replace in standard templates
	if($email->template == "cancel" || $email->template == "cancel_admin")
	{
		$body = str_replace("has been cancelled.</p>", "has been cancelled.</p><p>Reason: " . $reason . "</p>", $body);
	}
	
	//or replace in custom template
	$body = str_replace("!!reason!!", $reason, $body);
	
	return $body;
}
add_action("pmpro_email_body", "pmpror4c_pmpro_email_body", 10, 2);