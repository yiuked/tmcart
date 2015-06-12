<?php
if(isset($errors) AND is_array($errors) AND count($errors)>0){
?>
	<div class="error">
		<p>
		<?php
		if(count($errors) > 1){
		?>
			There are <?php echo count($errors);?> errors
		<?php }else{ ?>
			There is <?php echo count($errors);?> error
		<?php }?>
		</p>
		
		<ol>
		<?php 
			foreach($errors as $k=>$error){
		?>
			<li><?php echo $error;?></li>
		<?php } ?>
		</ol>
	</div>
<?php
}
?>