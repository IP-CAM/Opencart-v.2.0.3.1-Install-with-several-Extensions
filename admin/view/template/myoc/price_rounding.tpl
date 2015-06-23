<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <style type="text/css">
  .scrollbox{
    width:auto;
    height:auto;
    max-height:100px;
  }
  </style>
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-sub-total" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-myoc-price-rounding" class="form-horizontal">
          <ul class="nav nav-tabs" id="tabs">
            <li><a href="#tab-settings" data-toggle="tab"><?php echo $tab_settings; ?></a></li>
            <li><a href="#tab-rules" data-toggle="tab"><?php echo $tab_rounding_rules; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane" id="tab-settings">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="price_rounding_status" id="input-status" class="form-control">
                    <option value="1"<?php if($price_rounding_status) { ?> selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                    <option value="0"<?php if(!$price_rounding_status) { ?> selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label"><?php echo $entry_title; ?></label>
                <div class="col-sm-10">
                  <?php foreach ($languages as $language) { ?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="price_rounding_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($price_rounding_description[$language['language_id']]) ? $price_rounding_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" class="form-control" />
                  </div>
                  <?php if (isset($error_title[$language['language_id']])) { ?>
                  <div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
                  <?php } ?>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-display"><?php echo $entry_display; ?></label>
                <div class="col-sm-10">
                  <select name="price_rounding_display" id="input-display" class="form-control">
                    <option value="diff"<?php if($price_rounding_display == 'diff') { ?> selected="selected"<?php } ?>><?php echo $text_display_difference; ?></option>
                    <option value="total"<?php if($price_rounding_display == 'total') { ?> selected="selected"<?php } ?>><?php echo $text_display_total; ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_login; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <input type="radio" name="price_rounding_login" value="1"<?php if ($price_rounding_login) { ?> checked="checked"<?php } ?> />
                    <?php echo $text_yes; ?>
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="price_rounding_login" value="0"<?php if (!$price_rounding_login) { ?> checked="checked"<?php } ?> />
                    <?php echo $text_no; ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="price_rounding_sort_order" value="<?php echo $price_rounding_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-rules">
              <table id="rules-tbl" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <td class="text-left"><?php echo $column_store; ?></td>
                    <td class="text-left"><?php echo $column_customer_group; ?></td>
                    <td class="text-left"><?php echo $column_currency; ?></td>
                    <td class="text-left"><?php echo $column_from; ?></td>
                    <td class="text-left"><?php echo $column_to; ?></td>
                    <td class="text-left"><?php echo $column_rounding_method; ?></td>
                    <td class="text-left"><?php echo $column_rounding_direction; ?></td>
                    <td class="text-right"><?php echo $column_rounding_value; ?></td>
                    <td></td>
                  </tr>
                </thead>
                <?php $rule_row = 0; ?>
                <?php if ($price_rounding_rule) { ?>
                <?php foreach ($price_rounding_rule as $rule) { ?>
                <tbody id="rule<?php echo $rule_row; ?>">
                  <tr>
                    <td class="text-left">
                      <div class="scrollbox">
                        <?php $class = 'even'; ?>
                        <div class="<?php echo $class; ?>">
                          <input type="checkbox" name="price_rounding_rule[<?php echo $rule_row; ?>][store][]" value="0"<?php if (!empty($rule['store']) && in_array('0', $rule['store'])) { ?> checked="checked"<?php } ?> id="rule<?php echo $rule_row; ?>_store0" />
                          <label for="rule<?php echo $rule_row; ?>_store0"><?php echo $text_default; ?></label>
                        </div>
                        <?php foreach ($stores as $store) { ?>
                        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                        <div class="<?php echo $class; ?>">
                          <input type="checkbox" name="price_rounding_rule[<?php echo $rule_row; ?>][store][]" value="<?php echo $store['store_id']; ?>"<?php if (!empty($rule['store']) && in_array($store['store_id'], $rule['store'])) { ?> checked="checked"<?php } ?> id="rule<?php echo $rule_row; ?>_store<?php echo $store['store_id']; ?>" />
                          <label for="rule<?php echo $rule_row; ?>_store<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></label>
                        </div>
                        <?php } ?>
                      </div></td>
                    <td class="text-left">
                      <div class="scrollbox">
                        <?php $class = 'even'; ?>
                        <?php foreach ($customer_groups as $customer_group) { ?>
                        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                        <div class="<?php echo $class; ?>">
                          <input type="checkbox" name="price_rounding_rule[<?php echo $rule_row; ?>][customer_group][]" value="<?php echo $customer_group['customer_group_id']; ?>"<?php if (!empty($rule['customer_group']) && in_array($customer_group['customer_group_id'], $rule['customer_group'])) { ?> checked="checked"<?php } ?> id="rule<?php echo $rule_row; ?>_customer_group<?php echo $customer_group['customer_group_id']; ?>" />
                          <label for="rule<?php echo $rule_row; ?>_customer_group<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></label>
                        </div>
                        <?php } ?>
                      </div></td>
                    <td class="text-left">
                      <div class="scrollbox">
                        <?php $class = 'even'; ?>
                        <?php foreach ($currencies as $currency) { ?>
                        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                        <div class="<?php echo $class; ?>">
                          <input type="checkbox" name="price_rounding_rule[<?php echo $rule_row; ?>][currency][]" value="<?php echo $currency['currency_id']; ?>"<?php if (!empty($rule['currency']) && in_array($currency['currency_id'], $rule['currency'])) { ?> checked="checked"<?php } ?> id="rule<?php echo $rule_row; ?>_currency<?php echo $currency['currency_id']; ?>" />
                          <label for="rule<?php echo $rule_row; ?>_currency<?php echo $currency['currency_id']; ?>"><?php echo $currency['code']; ?> (<?php echo $currency['symbol_left'] ? $currency['symbol_left'] : $currency['symbol_right']; ?>)</label>
                        </div>
                        <?php } ?>
                      </div></td>
                    <td class="text-left"><input type="text" name="price_rounding_rule[<?php echo $rule_row; ?>][range_from]" value="<?php echo $rule['range_from']; ?>" size="12" /></td>
                    <td class="text-left"><input type="text" name="price_rounding_rule[<?php echo $rule_row; ?>][range_to]" value="<?php echo $rule['range_to']; ?>" size="12" /></td>
                    <td class="text-left"><select name="price_rounding_rule[<?php echo $rule_row; ?>][rounding]">
                        <option value="fix"<?php if($rule['rounding'] == 'fix') { ?> selected="selected"<?php } ?>><?php echo $text_fixed; ?></option>
                        <option value="mux"<?php if($rule['rounding'] == 'mux') { ?> selected="selected"<?php } ?>><?php echo $text_multiple; ?></option>
                      </select>
                    </td>
                    <td class="text-left"><select name="price_rounding_rule[<?php echo $rule_row; ?>][direction]">
                        <option value="up"<?php if($rule['direction'] == 'up') { ?> selected="selected"<?php } ?>><?php echo $text_roundup; ?></option>
                        <option value="near"<?php if($rule['direction'] == 'near') { ?> selected="selected"<?php } ?>><?php echo $text_roundnear; ?></option>
                        <option value="down"<?php if($rule['direction'] == 'down') { ?> selected="selected"<?php } ?>><?php echo $text_rounddown; ?></option>
                      </select>
                    </td>
                    <td class="text-right"><input type="text" name="price_rounding_rule[<?php echo $rule_row; ?>][nearest]" value="<?php echo $rule['nearest']; ?>" size="12" />
                    <td class="text-right"><button type="button" onclick="$('#rule<?php echo $rule_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                  </tr>
                  <?php $rule_row++; ?>
                </tbody>
                <?php } ?>
                <?php } ?>
                <tfoot>
                  <tr>
                    <td class="text-right" colspan="9"><button type="button" onclick="addRule();" data-toggle="tooltip" title="<?php echo $button_add_rule; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </form>
        <div style="font-size:11px;color:#666;">
          <?php echo $myoc_copyright; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#tabs a:first').tab('show');

var rule_row = <?php echo $rule_row; ?>;

function addRule() {
  html  = '<tbody id="rule' + rule_row + '">';
  html += '  <tr>';
  html += '    <td class="text-left">';
  html += '       <div class="scrollbox">';
  <?php $class = 'even'; ?>
  html += '         <div class="<?php echo $class; ?>">';
  html += '           <input type="checkbox" name="price_rounding_rule[' + rule_row + '][store][]" value="0" checked="checked" id="rule' + rule_row + '_store0" />';
  html += '             <label for="rule' + rule_row + '_store0"><?php echo $text_default; ?></label>';
  html += '         </div>';
  <?php foreach ($stores as $store) { ?>
  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
  html += '         <div class="<?php echo $class; ?>">';
  html += '           <input type="checkbox" name="price_rounding_rule[' + rule_row + '][store][]" value="<?php echo $store['store_id']; ?>" id="rule' + rule_row + '_store' + rule_row + '" />';
  html += '           <label for="rule' + rule_row + '_store' + rule_row + '"><?php echo $store['name']; ?></label>';
  html += '         </div>';
  <?php } ?>
  html += '       </div></td>';
  html += '     <td class="text-left">';
  html += '       <div class="scrollbox">';
  <?php $class = 'even'; ?>
  <?php foreach ($customer_groups as $customer_group) { ?>
  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
  html += '         <div class="<?php echo $class; ?>">';
  html += '           <input type="checkbox" name="price_rounding_rule[' + rule_row + '][customer_group][]" value="<?php echo $customer_group['customer_group_id']; ?>" id="rule' + rule_row + '_customer_group<?php echo $customer_group['customer_group_id']; ?>" />';
  html += '           <label for="rule' + rule_row + '_customer_group<?php echo $customer_group['customer_group_id']; ?>"><?php echo addslashes($customer_group['name']); ?></label>';
  html += '         </div>';
  <?php } ?>
  html += '       </div></td>';
  html += '     <td class="text-left">';
  html += '       <div class="scrollbox">';
  <?php $class = 'even'; ?>
  <?php foreach ($currencies as $currency) { ?>
  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
  html += '         <div class="<?php echo $class; ?>">';
  html += '           <input type="checkbox" name="price_rounding_rule[' + rule_row + '][currency][]" value="<?php echo $currency['currency_id']; ?>" id="rule' + rule_row + '_currency<?php echo $currency['currency_id']; ?>" />';
  html += '           <label for="rule' + rule_row + '_currency<?php echo $currency['currency_id']; ?>"><?php echo addslashes($currency['code']); ?> (<?php echo addslashes($currency['symbol_left'] ? $currency['symbol_left'] : $currency['symbol_right']); ?>)</label>';
  html += '         </div>';
  <?php } ?>
  html += '       </div></td>';
  html += '    <td class="text-left"><input type="text" name="price_rounding_rule[' + rule_row + '][range_from]" value="" size="12" /></td>';
  html += '    <td class="text-left"><input type="text" name="price_rounding_rule[' + rule_row + '][range_to]" value="" size="12" /></td>';
  html += '    <td class="text-left"><select name="price_rounding_rule[' + rule_row + '][rounding]">';
  html += '      <option value="fix"><?php echo $text_fixed; ?></option>';
  html += '      <option value="mux"><?php echo $text_multiple; ?></option>';
  html += '    </select></td>';
  html += '    <td class="left"><select name="price_rounding_rule[' + rule_row + '][direction]">';
  html += '      <option value="up"><?php echo $text_roundup; ?></option>';
  html += '      <option value="near"><?php echo $text_roundnear; ?></option>';
  html += '      <option value="down"><?php echo $text_rounddown; ?></option>';
  html += '    </select></td>';
  html += '    <td class="text-right"><input type="text" name="price_rounding_rule[' + rule_row + '][nearest]" value="" size="12" /></td>';
  html += '    <td class="text-right"><button type="button" onclick="$(\'#rule' + rule_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '  </tr>';
  html += '</tbody>';
  
  $('#rules-tbl tfoot').before(html);
  
  rule_row++;
}
//--></script>
<?php echo $footer; ?>