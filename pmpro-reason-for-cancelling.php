<?php
/**
 * Plugin Name: Paid Memberships Pro - Reason For Cancelling Add On
 * Plugin URI: https://www.paidmembershipspro.com/add-ons/pmpro-reason-cancelling/
 * Description: Adds a field to specify a reason for cancelling to the cancel page.
 * Version: 1.1
 * Author: Paid Memberships Pro
 * Author URI: https://www.paidmembershipspro.com
 * Text Domain: pmpro-reason-for-cancelling
 * Domain Path: /languages
 */

 // Load functionality for PMPro v2.x.
 include_once( dirname( __FILE__ ) . '/includes/deprecated.php' );

/**
 * Add a reason field to the cancel page.
 *
 * Will only run on PMPro v3.0+.
 *
 * @since 1.0
 */
function pmpror4c_cancel_before_submit() {
	?>
	<p><?php esc_html_e( 'If so, please enter a reason for cancelling and click the button to confirm cancellation below.', 'pmpro-reason-for-cancelling' ); ?></p>
	<div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_divider' ) ); ?>"></div>
	<div id="pmpro_reason_for_cancelling" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_fields', 'pmpro_reason_for_cancelling' ) ); ?>">
		<div id="pmpro_cancel_reason_div" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-textarea pmpro_form_field-required' ) ); ?>">
			<label class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>" for="pmpro_cancel_reason">
				<?php esc_html_e( 'Reason for Cancelling', 'pmpro-reason-for-cancelling' ); ?>
				<span class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_asterisk' ) ); ?>"> <abbr title="<?php esc_attr_e( 'Required Field' ,'pmpro-reason-for-cancelling' ); ?>">*</abbr></span>
			</label>
			<textarea id="pmpro_cancel_reason" name="pmpro_cancel_reason" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-textarea pmpro_form_field-required' ) ); ?>"></textarea>
		</div> <!-- end pmpro_cancel_reason_div -->
	</div> <!-- end pmpro_reason_for_cancelling -->
	<?php
}
add_action( 'pmpro_cancel_before_submit', 'pmpror4c_cancel_before_submit' );

/**
 * Prevent cancellation if a reason is not provided.
 *
 * Will only run on PMPro v3.0+.
 *
 * @since 1.0
 *
 * @param bool $process_cancellation Whether the cancellation should be processed.
 * @return bool
 */
function pmpror4c_cancel_should_process( $process_cancellation ) {
	// If we are already halting this cancellation, bail.
	if ( empty( $process_cancellation ) ) {
		return false;
	}

	// Make sure a reason is provided.
	if ( empty( trim( $_REQUEST['pmpro_cancel_reason'] ) ) ) {
		pmpro_setMessage( __( 'Please enter a reason for cancelling.', 'pmpro-reason-for-cancelling' ), 'pmpro_error' );
		return false;
	}

	return true;
}
add_filter( 'pmpro_cancel_should_process', 'pmpror4c_cancel_should_process' );

/**
 * Add the reason to the cancellation confirmation email.
 *
 * @since 1.0
 *
 * @param string $body The email body.
 */
function pmpror4c_email_body( $body, $email ) {
	// Only use this function for PMPro v3.0+. Otherwise, use pmpror4c_pmpro_email_body().
	if ( ! class_exists( 'PMPro_Subscription') ) {
		return $body;
	}

	if ( ! empty( $_REQUEST['pmpro_cancel_reason'] ) ) {
		$reason = trim( wp_unslash( sanitize_text_field( $_REQUEST['pmpro_cancel_reason'] ) ) );
	} else {
		$reason = __( 'N/A', 'pmpro-reason-for-cancelling' );
	}

	// Replace in standard templates.
	if ( $email->template == 'cancel' || $email->template == 'cancel_admin' || $email->template == 'cancel_on_next_payment_date' || $email->template == 'cancel_on_next_payment_date_admin' ) {
		$body = str_replace( 'has been cancelled.</p>', 'has been cancelled.</p><p>Reason: ' . $reason . '</p>', $body );
	}

	// or replace in custom template
	$body = str_replace( '!!reason!!', $reason, $body );

	return $body;
}
add_action( 'pmpro_email_body', 'pmpror4c_email_body', 10, 2 );

/**
 * Save the reason to usermeta.
 *
 * Will only run on PMPro v3.0+.
 *
 * @since 1.0
 *
 * @param WP_User $user The user object that cancelled their membership.
 */
function pmpror4c_cancel_processed( $user ) {
	// Save the reason to usermeta.
	if ( ! empty( $user->ID ) && ! empty( $_REQUEST['pmpro_cancel_reason'] ) ) {
		add_user_meta( $user->ID, 'pmpror4c_reason', array(
			'timestamp' => time(),
			'levels'    => wp_unslash( sanitize_text_field( $_REQUEST['levelstocancel'] ) ),
			'reason'    => trim( wp_unslash( sanitize_text_field( $_REQUEST['pmpro_cancel_reason'] ) ) ),
		) );
	}
}
add_action( 'pmpro_cancel_processed', 'pmpror4c_cancel_processed', 10, 1 );

/**
 * Add a panel to the Edit Member dashboard page.
 *
 * @since 1.0
 *
 * @param array $panels Array of panels.
 * @return array
 */
function pmpror4c_member_edit_panels_reasons( $panels ) {
	// If the class doesn't exist and the abstract class does, require the class.
	if ( ! class_exists( 'PMPror4c_Member_Edit_Panel_Reasons' ) && class_exists( 'PMPro_Member_Edit_Panel' ) ) {
		require_once( dirname( __FILE__ ) . '/classes/pmpror4c-class-member-edit-panel-reasons.php' );
	}

	// If the class exists, add a panel.
	if ( class_exists( 'PMPror4c_Member_Edit_Panel_Reasons' ) ) {
		$panels[] = new PMPror4c_Member_Edit_Panel_Reasons();
	}

	return $panels;
}
add_filter( 'pmpro_member_edit_panels', 'pmpror4c_member_edit_panels_reasons' );

/**
 * Load the text domain for translation.
 *
 * @since 1.0
 */
function pmpror4c_load_textdomain() {
	load_plugin_textdomain( 'pmpro-reason-for-cancelling', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'pmpror4c_load_textdomain' );
