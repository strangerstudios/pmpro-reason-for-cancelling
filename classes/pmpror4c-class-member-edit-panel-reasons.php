<?php

class PMPror4c_Member_Edit_Panel_Reasons extends PMPro_Member_Edit_Panel {
	/**
	 * Set up the panel.
	 */
	public function __construct() {
		$this->slug = 'pmpror4c-reasons';
		$this->title = __( 'Cancellation Reasons', 'pmpro-reason-for-cancelling' );
	}

	/**
	 * Display the panel contents.
	 */
	protected function display_panel_contents() {
		// Get the user being edited.
		$user = self::get_user();

		// Get all reasons for this user.
		$reasons = get_user_meta( $user->ID, 'pmpror4c_reason', false );

		// If there are no reasons, display a message and return.
		if ( empty( $reasons ) ) {
			?>
			<p><?php esc_html_e( 'This user has not submitted any reasons for cancelling.', 'pmpro-reason-for-cancelling' ); ?></p>
			<?php
			return;
		}

		// Order reasons by timestamp in descending order.
		usort( $reasons, function( $a, $b ) {
			return $b['timestamp'] - $a['timestamp'];
		} );

		// Display the reasons in a table.
		?>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Date', 'pmpro-reason-for-cancelling' ); ?></th>
					<th><?php esc_html_e( 'Cancelled Level(s)', 'pmpro-reason-for-cancelling' ); ?></th>
					<th><?php esc_html_e( 'Reason', 'pmpro-reason-for-cancelling' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ( $reasons as $reason ) {
					?>
					<tr>
						<td><?php echo esc_html( date_i18n( get_option( 'date_format' ), $reason['timestamp'] ) ); ?></td>
						<td>
							<?php
							// $reason['levels'] will be 'all' or a string of level IDs separated by '+'.
							if ( 'all' === $reason['levels'] ) {
								esc_html_e( 'All Levels', 'pmpro-reason-for-cancelling' );
							} else {
								$level_ids = explode( '+', $reason['levels'] );
								$level_names = array();
								foreach ( $level_ids as $level_id ) {
									$level = pmpro_getLevel( $level_id );
									if ( ! empty( $level ) ) {
										$level_names[] = $level->name;
									}
								}
								esc_html_e( implode( ', ', $level_names ) );
							}
							?>
						</td>
						<td><?php echo esc_html( $reason['reason'] ); ?></td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
		<?php
	}
}
