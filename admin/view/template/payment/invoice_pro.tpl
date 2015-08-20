<?php echo $header; ?>
<?php echo $column_left; ?>

<div id="content">

	<div class="page-header">
		<div class="container-fluid">

			<div class="pull-right">
				<button type="submit" form="form-filter" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>

			<h1><?php echo $heading_title; ?></h1>

			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>

		</div>
	</div>

	<div class="container-fluid">

		<?php if ($error_warning) { ?>
			<div class="alert alert-danger">
				<i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
		<?php } ?>

		<div class="panel panel-default">
			<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
		</div>

		<div class="panel-body">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-filter" class="form-horizontal">

				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab-settings" data-toggle="tab"><?php echo $tab_settings; ?></a></li>
				</ul>

				<div class="tab-content">

					<div class="tab-pane active" id="tab-settings">

						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-total_min"><span data-toggle="tooltip" title="<?php echo $help_total_min; ?>"><?php echo $entry_total_min; ?></span></label>
							<div class="col-sm-10">
								<input name="invoice_pro_total_min" id="input-total_min" class="form-control" value="<?php echo $invoice_pro_total_min; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-total_max"><span data-toggle="tooltip" title="<?php echo $help_total_max; ?>"><?php echo $entry_total_max; ?></span></label>
							<div class="col-sm-10">
								<input name="invoice_pro_total_max" id="input-total_max" class="form-control" value="<?php echo $invoice_pro_total_max; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-fee"><?php echo $entry_fee; ?></label>
							<div class="col-sm-10">
								<input name="invoice_pro_fee" id="input-fee" class="form-control" value="<?php echo $invoice_pro_fee; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-reg_exp"><span data-toggle="tooltip" title="<?php echo $help_reg_exp; ?>"><?php echo $entry_reg_exp; ?></span></label>
							<div class="col-sm-10">
								<input name="invoice_pro_reg_exp" id="input-reg_exp" class="form-control" value="<?php echo $invoice_pro_reg_exp; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-ssn"><?php echo $entry_ssn; ?></label>
							<div class="col-sm-10">
								<select name="invoice_pro_ssn" id="input-ssn" class="form-control">
									<?php if ($invoice_pro_ssn) { ?>
										<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
										<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
										<option value="1"><?php echo $text_enabled; ?></option>
										<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-tax_class_id"><?php echo $entry_tax_class; ?></label>
							<div class="col-sm-10">
								<select name="invoice_pro_tax_class_id" id="input-tax_class_id" class="form-control">
									<option value="0"><?php echo $text_none; ?></option>
									<?php foreach ($tax_classes as $tax_class) { ?>
										<?php if ($tax_class['tax_class_id'] == $invoice_pro_tax_class_id) { ?>
											<option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-customer_group_id"><?php echo $entry_customer_group; ?></label>
							<div class="col-sm-10">
								<select name="invoice_pro_customer_group_id" id="input-customer_group_id" class="form-control">
									<option value="0"><?php echo $text_select_all; ?></option>
									<?php foreach ($customer_groups as $customer_group) { ?>
										<?php if ($customer_group['customer_group_id'] == $invoice_pro_customer_group_id) { ?>
											<option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-geo_zone_id"><?php echo $entry_geo_zone; ?></label>
							<div class="col-sm-10">
								<select name="invoice_pro_geo_zone_id" id="input-geo_zone_id" class="form-control">
									<option value="0"><?php echo $text_all_zones; ?></option>
									<?php foreach ($geo_zones as $geo_zone) { ?>
										<?php if ($geo_zone['geo_zone_id'] == $invoice_pro_geo_zone_id) { ?>
											<option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-description_status"><?php echo $entry_description_status; ?></label>
							<div class="col-sm-10">
								<select name="invoice_pro_description_status" id="input-description_status" class="form-control">
									<?php if ($invoice_pro_status) { ?>
										<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
										<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
										<option value="1"><?php echo $text_enabled; ?></option>
										<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-order_status_id"><?php echo $entry_order_status; ?></label>
							<div class="col-sm-10">
								<select name="invoice_pro_order_status_id" id="input-order_status_id" class="form-control">
									<?php foreach ($order_statuses as $order_status) { ?>
										<?php if ($order_status['order_status_id'] == $invoice_pro_order_status_id) { ?>
											<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
							<div class="col-sm-10">
								<select name="invoice_pro_status" id="input-status" class="form-control">
									<?php if ($invoice_pro_status) { ?>
										<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
										<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
										<option value="1"><?php echo $text_enabled; ?></option>
										<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-sort_order"><?php echo $entry_sort_order; ?></label>
							<div class="col-sm-10">
								<input name="invoice_pro_sort_order" id="input-sort_order" class="form-control" value="<?php echo $invoice_pro_sort_order; ?>" />
							</div>
						</div>

					</div>

				</div>

			</form>
		</div>

	</div>

</div>

<?php echo $footer; ?>
