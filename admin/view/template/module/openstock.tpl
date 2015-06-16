<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-openstock" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-openstock" class="form-horizontal">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-status" data-toggle="tab"><?php echo $tab_status; ?></a></li>
        <li><a href="#tab-settings" data-toggle="tab"><?php echo $tab_settings; ?></a></li>
        <li><a href="#tab-repair" data-toggle="tab"><?php echo $tab_repair; ?></a></li>
        <li><a href="#tab-export" data-toggle="tab"><?php echo $tab_export; ?></a></li>
        <li><a href="#tab-import" data-toggle="tab"><?php echo $tab_import; ?></a></li>
        <li><a href="#tab-bulk" data-toggle="tab"><?php echo $tab_bulk; ?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab-status">
          <?php foreach ($problems as $key => $problem) { ?>
            <?php if ($problem['colour'] == 'green') { ?>
              <div class="alert alert-success os-<?php echo $key; ?>"><i class="fa fa-check-circle"></i> <?php echo $problem['text']; ?></div>
            <?php } elseif ($problem['colour'] == 'orange') { ?>
              <div class="alert alert-warning os-<?php echo $key; ?>"><i class="fa fa-exclamation-circle"></i> <?php echo $problem['text']; ?></div>
            <?php } elseif ($problem['colour'] == 'red') { ?>
              <div class="alert alert-danger os-<?php echo $key; ?>"><i class="fa fa-exclamation-circle"></i> <?php echo $problem['text']; ?></div>
            <?php } ?>
          <?php } ?>
          <fieldset>
            <legend><?php echo $status_title; ?></legend>
            <?php echo $module_installed; ?>
            <?php echo $module_support; ?>
          </fieldset>
        </div>
        <div class="tab-pane" id="tab-settings">
          <fieldset>
            <legend><?php echo $text_settings; ?></legend>
            <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_show_default_price; ?>"><?php echo $text_show_default_price; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($openstock_show_default_price) { ?>
                    <input type="radio" name="openstock_show_default_price" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="openstock_show_default_price" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$openstock_show_default_price) { ?>
                    <input type="radio" name="openstock_show_default_price" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="openstock_show_default_price" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_show_special_discount_tab; ?>"><?php echo $text_show_special_discount_tab; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($openstock_show_special_discount_tab) { ?>
                    <input type="radio" name="openstock_show_special_discount_tab" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="openstock_show_special_discount_tab" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$openstock_show_special_discount_tab) { ?>
                    <input type="radio" name="openstock_show_special_discount_tab" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="openstock_show_special_discount_tab" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label></div>
              </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_dependant_options; ?>"><?php echo $text_dependant_options; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($openstock_dependant_options) { ?>
                    <input type="radio" name="openstock_dependant_options" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="openstock_dependant_options" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$openstock_dependant_options) { ?>
                    <input type="radio" name="openstock_dependant_options" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="openstock_dependant_options" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label></div>
              </div>
            </fieldset>
            <fieldset>
              <legend><?php echo $text_defaults; ?></legend>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-openstock_default_stock"><?php echo $text_default_stock; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="openstock_default_stock" value="<?php echo $openstock_default_stock; ?>" id="input-openstock_default_stock" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-openstock_default_subtract"><?php echo $text_default_subtract; ?></label>
                <div class="col-sm-10">
                  <select name="openstock_default_subtract">
                    <?php if ($openstock_default_subtract) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-openstock_default_active"><?php echo $text_default_active; ?></label>
                <div class="col-sm-10">
                  <?php if ($openstock_default_active) { ?>
                  <input type="checkbox" class="openstock_default_active" name="openstock_default_active" value="1" checked="checked" />
                  <?php } else { ?>
                  <input type="checkbox" class="openstock_default_active" name="openstock_default_active" value="1" />
                  <?php } ?>
                </div>
              </div>
            </fieldset>
            <fieldset>
              <legend><?php echo $text_bulk_defaults_title; ?></legend>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-openstock_default_sku"><span data-toggle="tooltip" title="<?php echo $help_openstock_default_sku; ?>"><?php echo $text_default_sku; ?></span></label>
                <div class="col-sm-10">
                  <select name="openstock_default_sku">
                      <?php foreach ($openstock_default_sku_options as $key => $openstock_default_sku_option) { ?>
                        <?php if ($openstock_default_sku == $key) { ?>
                        <option value="<?php echo $key; ?>" selected="selected"><?php echo $openstock_default_sku_option; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $key; ?>"><?php echo $openstock_default_sku_option; ?></option>
                        <?php } ?>
                      <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-openstock_default_sku_delimiter"><span data-toggle="tooltip" title="<?php echo $help_openstock_default_sku_delimiter; ?>"><?php echo $text_default_sku_delimiter; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="openstock_default_sku_delimiter" value="<?php echo $openstock_default_sku_delimiter; ?>" id="input-openstock_default_sku_delimiter" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-openstock_default_sku_case"><span data-toggle="tooltip" title="<?php echo $help_openstock_default_sku_case; ?>"><?php echo $text_default_sku_case; ?></span></label>
                <div class="col-sm-10">
                  <select name="openstock_default_sku_case">
                      <?php foreach ($openstock_default_sku_case_options as $key => $openstock_default_sku_case_option) { ?>
                        <?php if ($openstock_default_sku_case == $key) { ?>
                        <option value="<?php echo $key; ?>" selected="selected"><?php echo $openstock_default_sku_case_option; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $key; ?>"><?php echo $openstock_default_sku_case_option; ?></option>
                        <?php } ?>
                      <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-openstock_default_sku_space"><span data-toggle="tooltip" title="<?php echo $help_openstock_default_sku_space; ?>"><?php echo $text_default_sku_space; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="openstock_default_sku_space" value="<?php echo $openstock_default_sku_space; ?>" id="input-openstock_default_sku_space" class="form-control" />
                </div>
              </div>
            </fieldset>
          </div>
          <div class="tab-pane" id="tab-repair">
            <fieldset>
              <legend><?php echo $repair_title; ?></legend>
              <?php echo $repair_desc; ?>
              <i class="fa fa-circle-o-notch fa-spin" id="image-repair" style="display:none;"> </i>
              <button type="button" onclick="repair();" id="button-repair" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-wrench"></i> <?php echo $repair_btn; ?></button>
            </fieldset>
          </div>
          <div class="tab-pane" id="tab-export">
            <fieldset>
              <legend><?php echo $export_title; ?></legend>
              <?php echo $module_export_text; ?>
              <button type="button" onclick="location = '<?php echo $export; ?>';" id="button-export" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-download"></i> <?php echo $button_export; ?></button>
            </fieldset>
          </div>
          <div class="tab-pane" id="tab-import">
            <fieldset>
              <legend><?php echo $import_title; ?></legend>
            </fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-filename"><span data-toggle="tooltip" title="<?php echo $help_import; ?>"><?php echo $label_import; ?></span></label>
              <div class="col-sm-10">
                <div class="input-group">
                  <span class="input-group-btn">
                  <button type="button" id="button-upload" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                  </span> </div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tab-bulk">
            <p><?php echo $text_bulk_ideal; ?></p>
            <p><?php echo $text_bulk; ?></p>
            <p><?php echo $text_bulk_explain; ?></p>
            <p><?php echo $text_bulk_defaults; ?></p>
            <p><?php echo $openstock_bulk_stock; ?></p>
            <p><?php echo $openstock_bulk_subtract; ?></p>
            <p><?php echo $openstock_bulk_active; ?></p>

            <p><?php echo $openstock_bulk_default_sku; ?></p>
            <p><?php echo $openstock_bulk_default_sku_delimiter; ?></p>
            <p><?php echo $openstock_bulk_default_sku_case; ?></p>
            <p><?php echo $openstock_bulk_default_sku_space; ?></p>
            <p><?php echo $sku_example; ?></p>
            <button type="button" onclick="bulk(1);" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-upload"></i> <?php echo $label_bulk; ?></button>
            <button type="button" onclick="bulk(0);" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-upload"></i> <?php echo $label_bulk_preview; ?></button>
            <br />
            <div class="os-bulk" style="margin-top: 15px; display: none;">
              <div>
                <span><?php echo $label_result; ?></span>
                <span class="os-bulk-result"></span>
              </div>
              <div>
                <span><?php echo $label_time; ?></span>
                <span class="os-bulk-time"></span>
              </div>
              <div>
                <span><?php echo $label_variants; ?></span>
                <span class="os-bulk-variants"></span>
              </div>
            </div>
          </div>
        </div>
    </form>
</div>
<script type="text/javascript"><!--
function repair(){
    $('#button-repair').hide();
    $('#image-repair').show();

    $.ajax({
        type: 'POST',
        url: 'index.php?route=module/openstock/repair&token=<?php echo $token; ?>',
        dataType: 'json',
        success: function(json) {
            alert(json['msg']);
            $('#button-repair').show();
            $('#image-repair').hide();
        },
        failure: function() {
            alert('Error');
            $('#button-repair').show();
            $('#image-repair').hide();
        },
        error: function() {
            alert('Error');
            $('#button-repair').show();
            $('#image-repair').hide();
        }
    });
}

function bulk(create) {
    $.ajax({
        type: 'POST',
        url: 'index.php?route=module/openstock/bulk&token=<?php echo $token; ?>&create='+create,
        dataType: 'json',
        beforeSend: function() {
            $('.os-bulk').show();
            $('.os-bulk-result').html('Loading...');
            $('.os-bulk-time').html('Loading...');
            $('.os-bulk-variants').html('Loading...');
        },
        success: function(data) {
            if (data.success) {
                $('.os-bulk-result').html('Success');
                $('.os-bulk-time').html(data['time_taken'] + ' seconds');
                $('.os-bulk-variants').html(data['created']);
            } else {
                $('.os-bulk-result').html(data.error);
                $('.os-bulk-time').html('N/A');
                $('.os-bulk-variants').html('N/A');
            }
        },
        failure: function() {
            $('.os-bulk-result').html('Failure');
        },
        error: function() {
            $('.os-bulk-result').html('Error');
        }
    });
}

$('#button-upload').on('click', function() {
	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	$('#form-upload input[name=\'file\']').on('change', function() {
		$.ajax({
			url: 'index.php?route=module/openstock/import&token=<?php echo $token; ?>',
			type: 'post',
			dataType: 'json',
			data: new FormData($(this).parent()[0]),
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
				$('#button-upload').button('loading');
			},
			complete: function() {
				$('#button-upload').button('reset');
			},
			success: function(json) {
				if (json['error']) {
					alert(json['error']);
				}

				if (json['success']) {
					alert(json['success']);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});
});
//--></script>
<?php echo $footer; ?>