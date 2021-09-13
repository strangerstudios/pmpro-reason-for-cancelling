<?php
/**
 * Template: Cancel
 *
 * Overrides ../wp-content/plugins/paid-memberships-pro/templates/cancel.php
 *
 * @version 2.0
 *
 * @author Paid Memberships Pro
 */
global $pmpro_msg, $pmpro_msgt, $pmpro_confirm, $current_user, $wpdb;

if ( isset( $_REQUEST['levelstocancel'] ) && $_REQUEST['levelstocancel'] !== 'all' ) {
	//convert spaces back to +
	$_REQUEST['levelstocancel'] = str_replace( array( ' ', '%20' ), '+', $_REQUEST['levelstocancel'] );

	//get the ids
	$old_level_ids = array_map( 'intval', explode( "+", preg_replace( "/[^0-9al\+]/", "", $_REQUEST['levelstocancel'] ) ) );

} elseif ( isset( $_REQUEST['levelstocancel'] ) && $_REQUEST['levelstocancel'] == 'all') {
	$old_level_ids = 'all';
} else {
	$old_level_ids = false;
}
?>
<div id="pmpro_cancel" class="<?php echo pmpro_get_element_class( 'pmpro_cancel_wrap', 'pmpro_cancel' ); ?>">
	<?php
		if ( $pmpro_msg ) {
			?>
			<div class="<?php echo pmpro_get_element_class( 'pmpro_message ' . $pmpro_msgt, $pmpro_msgt ); ?>"><?php echo $pmpro_msg?></div>
			<?php
		}
	?>
	<?php
		if ( ! $pmpro_confirm ) {
			if ( $old_level_ids ) {
				?>
				<form action="" method="post">
				<?php
				if ( ! is_array( $old_level_ids ) && $old_level_ids == "all" ) {
					?>
					<p><?php _e( 'Are you sure you want to cancel your membership?', 'pmpro-reason-for-cancelling' ); ?></p>
					<?php
				} else {
					$level_names = $wpdb->get_col( "SELECT name FROM $wpdb->pmpro_membership_levels WHERE id IN('" . implode( "','", $old_level_ids ) . "')" );
					?>
					<p><?php printf( _n( 'Are you sure you want to cancel your %s membership?', 'Are you sure you want to cancel your %s memberships?', count( $level_names ), 'pmpro-reason-for-cancelling' ), pmpro_implodeToEnglish( $level_names ) ); ?></p>
					<?php
				}
				?>
				<p>
				<?php esc_html_e( 'If so, please enter a reason for cancelling and click "Yes, cancel my account" below.', 'pmpro-reason-for-cancelling' ); ?><br />
				<textarea name="reason"></textarea>
				</p>

				<p>	
					<input type="hidden" name="membership_cancel" value="1" />
					<input type="hidden" name="confirm" value="1" />
					<input type="submit" name="submit" value="<?php esc_attr_e( 'Yes, cancel my account', 'pmpro-reason-for-cancelling' ); ?>" />
					|
					<a class="pmpro_nolink nolink" href="<?php echo pmpro_url( 'account' ); ?>"><?php esc_html_e( 'No, keep my account', 'pmpro-reason-for-cancelling' ); ?></a>
				</p>
				<?php
			} else {
				if($current_user->membership_level->ID) {
					?>
					<h2><?php _e( "My Memberships", 'pmpro-reason-for-cancelling' );?></h2>
					<table class="<?php echo pmpro_get_element_class( 'pmpro_table' ); ?>" width="100%" cellpadding="0" cellspacing="0" border="0">
						<thead>
							<tr>
								<th><?php _e( "Level", 'pmpro-reason-for-cancelling' );?></th>
								<th><?php _e( "Expiration", 'pmpro-reason-for-cancelling' ); ?></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$current_user->membership_levels = pmpro_getMembershipLevelsForUser( $current_user->ID );
								foreach( $current_user->membership_levels as $level ) {
								?>
								<tr>
									<td class="<?php echo pmpro_get_element_class( 'pmpro_cancel-membership-levelname' ); ?>">
										<?php echo $level->name?>
									</td>
									<td class="<?php echo pmpro_get_element_class( 'pmpro_cancel-membership-expiration' ); ?>">
									<?php
										if($level->enddate) {
											$expiration_text = date_i18n( get_option( 'date_format' ), $level->enddate );
   										} else {
   											$expiration_text = "---";
										}
       									 
										echo apply_filters( 'pmpro_account_membership_expiration_text', $expiration_text, $level );
									?>
									</td>
									<td class="<?php echo pmpro_get_element_class( 'pmpro_cancel-membership-cancel' ); ?>">
										<a href="<?php echo pmpro_url( "cancel", "?levelstocancel=" . $level->id )?>"><?php _e( "Cancel", 'pmpro-reason-for-cancelling' );?></a>
									</td>
								</tr>
								<?php
								}
							?>
						</tbody>
					</table>
					<div class="<?php echo pmpro_get_element_class( 'pmpro_actions_nav' ); ?>">
						<a href="<?php echo pmpro_url( "cancel", "?levelstocancel=all" ); ?>"><?php _e( "Cancel All Memberships", 'pmpro-reason-for-cancelling' );?></a>
					</div>
					<?php
				}
			}
		}
		else
		{
			?>
			<p class="<?php echo pmpro_get_element_class( 'pmpro_cancel_return_home' ); ?>"><a href="<?php echo get_home_url()?>"><?php _e( 'Click here to go to the home page.', 'pmpro-reason-for-cancelling' );?></a></p>
			<?php
		}
	?>
</div> <!-- end pmpro_cancel, pmpro_cancel_wrap -->
