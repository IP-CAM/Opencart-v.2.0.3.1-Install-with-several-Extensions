<?php $name = basename(__FILE__, '.tpl'); ?>

<?php if ($description_status) { ?>
	<div class="well well-sm well-invoice-pro text-center">
		<?php echo $text_description; ?>
	</div>
<?php } ?>

<?php if ($ssn_status) { ?>
	<form class="form-horizontal">
		<div class="form-group required">
			<label class="col-sm-2 control-label" for="input-ssn"><?php echo $entry_ssn; ?></label>
			<div class="col-sm-10">
				<input name="ssn" id="input-ssn" class="form-control" />
			</div>
		</div>
	</form>
<?php } ?>

<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" />
  </div>
</div>

<script type="text/javascript"><!--
	$('#button-confirm').on('click', function() {

		<?php if (($ssn_status) AND ($reg_exp)) { ?>

			$('.text-danger').remove();

			if ($('#input-ssn').val().match(<?php echo $reg_exp; ?>)) {

			}
			else {

				$('#input-ssn').after('<div class="text-danger"><?php echo $error_ssn; ?></div>');
				return false;

			}

		<?php } ?>

		$.ajax({
			type: 'get',
			url: 'index.php?route=payment/<?php echo $name; ?>/confirm',
			cache: false,
			beforeSend: function() {
				$('#button-confirm').button('loading');
			},
			complete: function() {
				$('#button-confirm').button('reset');
			},
			success: function() {
				location = '<?php echo $continue; ?>';
			}
		});
	});
//--></script>
