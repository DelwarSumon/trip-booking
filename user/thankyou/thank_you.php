		
<?php if(!empty($_SESSION['status'])){ $status = ($_SESSION['status'] == 'success') ? 'success' : 'danger'; ?>
	<div class="clr" style="height: 20px;"></div>
	<?php echo $_SESSION['msg']; ?>
	<div class="clr" style="height: 20px;"></div>
<?php 
unset($_SESSION['status']);
unset($_SESSION['msg']);
} ?>

		