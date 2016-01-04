<div class="side-heading"><?php echo $lang['TOP_AFFILIATES'];?></div>
<div class="collapse" id="add-contact">
	<form method="post" action="../data/add-contact" class="add-contact-form">
		<input type="text" name="name" placeholder="<?php echo $lang['NAME'];?>">
		<input type="text" name="email" placeholder="<?php echo $lang['EMAIL'];?>">
		<input type="submit" class="btn btn-success btn-xs" value="<?php echo $lang['ADD'];?>">
	</form>
</div>
<?php contact_list($owner, $domain_path); ?>
