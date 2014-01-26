<?php 
	global $pmpro_msg, $pmpro_msgt, $pmpro_confirm;

	if($pmpro_msg) 
	{
?>
	<div class="pmpro_message <?php echo $pmpro_msgt?>"><?php echo $pmpro_msg?></div>
<?php
	}
?>

<?php if(!$pmpro_confirm) { ?>           

<form action="" method="post">

<p><?php _e('Are you sure you want to cancel your membership?', 'pmpro');?></p>

<p>
<?php _e('If so, please enter a reason for cancelling and click "Yes, cancel my account" below.'); ?><br />
<textarea name="reason"></textarea>
</p>

<p>	
	<input type="hidden" name="membership_cancel" value="1" />
	<input type="hidden" name="confirm" value="1" />
	<input type="submit" name="submit" value="<?php _e('Yes, cancel my account', 'pmpro');?>" />
	|
	<a class="pmpro_nolink nolink" href="<?php echo pmpro_url("account")?>"><?php _e('No, keep my account', 'pmpro');?></a>
</p>
<?php } else { ?>
	<p><a href="<?php echo get_home_url()?>"><?php _e('Click here to go to the home page.', 'pmpro');?></a></p>
<?php } ?>

</form>