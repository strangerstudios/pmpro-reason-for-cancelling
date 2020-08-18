<?php
/**
 * Overrides ../wp-content/plugins/paid-memberships-pro/templates/cancel.php
 */
global $pmpro_msg, $pmpro_msgt, $pmpro_confirm;

if ( $pmpro_msg ) {
?>
<div class="pmpro_message <?php echo esc_html( $pmpro_msgt ); ?>"><?php echo esc_html( $pmpro_msg ); ?></div>
<?php
}
?>

<?php if ( ! $pmpro_confirm ) { ?>           

<form action="" method="post">

<p><?php esc_html_e( 'Are you sure you want to cancel your membership?', 'pmpro-reason-for-cancelling' ); ?></p>
<p>
<?php esc_html_e( 'If so, please enter a reason for cancelling and click "Yes, cancel my account" below.', 'pmpro-reason-for-cancelling' ); ?><br />
<textarea name="reason"></textarea>
</p>

<p>	
	<input type="hidden" name="membership_cancel" value="1" />
	<input type="hidden" name="confirm" value="1" />
	<input type="submit" name="submit" value="<?php esc_html_e( 'Yes, cancel my account', 'pmpro-reason-for-cancelling' ); ?>" />
	|
	<a class="pmpro_nolink nolink" href="<?php echo pmpro_url( 'account' ); ?>"><?php esc_html_e( 'No, keep my account', 'pmpro-reason-for-cancelling' ); ?></a>
</p>
<?php } else { ?>
	<p><a href="<?php echo get_home_url(); ?>"><?php esc_html_e( 'Click here to go to the home page.', 'pmpro-reason-for-cancelling' ); ?></a></p>
<?php } ?>

</form>
