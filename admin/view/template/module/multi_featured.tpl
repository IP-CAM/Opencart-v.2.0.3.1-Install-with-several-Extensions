<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="#" data-redirect-after-save="save" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary">
          <i class="fa fa-save"></i>
        </a>
        <a href="#" data-redirect-after-save="save-and-close" data-toggle="tooltip" title="<?php echo $button_save_and_close; ?>" class="btn btn-info">
          <i class="fa fa-save"></i>
        </a>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default">
          <i class="fa fa-reply"></i>
        </a>
      </div>
      <h1><?php echo $heading_title; ?> <span class="version badge"><?php echo $version; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
          <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <!-- /.page-header -->
  
  <div class="container-fluid">

    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>

    <?php if ($error_warning_multiple): ?>
      <div class="alert alert-danger">
        <?php foreach ($error_warning_multiple as $key => $error): ?>
          <div><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning_multiple[$key]; ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($success) { ?>
      <div class="alert alert-success">
        <i class="fa fa-check-circle"></i>
        <?php echo $success; ?>
        <button class="close" data-dismiss="alert" type="button">×</button>
      </div>      
    <?php } ?>

    <div id="fountainG" class="ajax-loader">
      <div id="fountainG_1" class="fountainG"></div>
      <div id="fountainG_2" class="fountainG"></div>
      <div id="fountainG_3" class="fountainG"></div>
      <div id="fountainG_4" class="fountainG"></div>
      <div id="fountainG_5" class="fountainG"></div>
      <div id="fountainG_6" class="fountainG"></div>
      <div id="fountainG_7" class="fountainG"></div>
      <div id="fountainG_8" class="fountainG"></div>
    </div>
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>

      <div id="MultiFeatured" class="panel-body" style="display: none;">
        
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-multi_featured" class="form-horizontal">
          
          <input type="hidden" id="multi-featured-count" name="multi_featured_count" value="<?php echo $multi_featured_count; ?>" />
          
          <ul id="global-tabs" class="nav nav-tabs">
            <li class="active"><a href="#tab-content-featured-product-lists" data-toggle="tab"><i class="fa fa-list orange mrs"></i><?php echo $tab_featured_product_lists; ?></a></li>
            <li><a href="#tab-config" data-toggle="tab"><i class="fa fa-cog violet mrs"></i><?php echo $tab_config; ?></a></li>
            
            <?php if (version_compare(VERSION, '2.0', '<')) { // Deprecated and not being used. ?>
            <li><a href="#tab-content-module" data-toggle="tab"><i class="fa fa-puzzle-piece green mrs"></i><?php echo $tab_modules; ?></a></li>
            <?php } ?>
            
            <li><a href="<?php echo $link_to_layout; ?>" target="_blank"><i class="fa fa-th aqua-gray mrs"></i><?php echo $tab_layouts; ?></a></li>
          </ul>
          
          <div class="tab-content">
          
            <div class="tab-pane active" id="tab-content-featured-product-lists">
              
              <div class="row">

                <div id="vtabs" class="col-sm-3">
                  <div>
                    <input type="text" name="filter_tabs" value="" placeholder="<?php echo $entry_filter_tabs; ?>" id="entry-filter-tabs" class="form-control" autocomplete="off" />
                    <div id="tab-filter-no-result" class="alert alert-info fade in mts" role="alert" style="display: none;"><?php echo $text_tab_filter_no_result; ?></div>                    
                  </div>
                  
                  <ul id="tab-container" class="nav nav-tabs tabs-left"><!--<ul id="" class="tab-container nav nav-pills nav-stacked">-->
                    <?php $setting_row = 1; ?>
                    <?php foreach($multi_featured_settings as $featured_id => $setting) { ?>
                      <li class="<?php echo $featured_id == 1 ? "active" : ""; ?>">
                        <a href="#tab-multi-featured-<?php echo $featured_id; ?>" data-featured_id="<?php echo $featured_id; ?>">
                          <i class="fa fa-minus-circle red mrs"></i>
                          <span>
                            <?php if (isset($setting['name']) && $setting['name']) { ?>
                              <?php echo $setting['name']; ?>
                            <?php } else { ?>
                              <?php echo "{$text_featured_content} {$setting_row}"; ?>
                            <?php } ?>
                          </span>
                        </a>
                      </li>
                      <?php $setting_row++; ?>
                    <?php } ?>
                  </ul>

                  <div class="well well-sm">
                    <a class="add-featured-content btn btn-info btn-block">
                      <i class="fa fa-plus-circle mrs"></i> 
                      <?php echo $text_add_featured_content; ?>
                    </a>
                  </div>              
                </div>
                <!-- .col -->
                
                <hr class="hidden-lg hidden-md hidden-sm" />
                
                <div id="vtabs-content-container" class="col-sm-9">
                  
                  <?php foreach($multi_featured_settings as $featured_id => $setting) { ?>
                  
                    <div id="tab-multi-featured-<?php echo $featured_id; ?>" class="vtabs-content" data-featured_id="<?php echo $featured_id; ?>" style="display: <?php echo $featured_id == 1 ? "block;" : "none;"; ?>">
                      
                      <input type="hidden" class="input-hidden-module-id form-control" name="multi_featured_<?php echo $featured_id; ?>[module_id]" value="<?php echo $setting['module_id']; ?>" />
                      
                      <div class="form-group <?php echo (isset($error_name[$featured_id])) ? 'has-error' : ''; ?>">
                        <label class="col-sm-2 control-label" for="entry-name-<?php echo $featured_id; ?>">
                          <span data-toggle="tooltip" title="<?php echo $help_name; ?>"><?php echo $entry_name; ?></span>
                        </label>
                        <div class="col-sm-10">
                          <div class="row">
                            <div class="col-xs-6">
                              <input type="text" id="entry-name-<?php echo $featured_id; ?>" class="input-name form-control" name="multi_featured_<?php echo $featured_id; ?>[name]" value="<?php echo isset($setting['name']) ? $setting['name'] : ''; ?>" />
                              <?php if (isset($error_name[$featured_id])) { ?>
                                <div class="text-danger"><?php echo $error_name[$featured_id]; ?></div>
                              <?php } ?>                              
                            </div>
                          </div>                          
                        </div>
                      </div>
                      
                      <hr />
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="entry-title-<?php echo $featured_id; ?>-<?php echo $primary_language['language_id']; ?>">
                          <span data-toggle="tooltip" title="<?php echo $help_title; ?>"><?php echo $entry_title; ?></span>
                        </label>
                        <div class="col-sm-10">
                          <?php foreach ($languages as $language) { ?>
                            <div class="input-title-container">
                              <?php if (version_compare(VERSION, '2.2.0.0', '<')) { // for OpenCart 2.1.0.2 or earlier. ?>
                                <img class="img-flag" src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                              <?php } else { ?>
                                <img class="img-flag" src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />
                              <?php } ?>                              
                              <input type="text" id="entry-title-<?php echo $featured_id; ?>-<?php echo $language['language_id']; ?>" class="input-title form-control" name="multi_featured_<?php echo $featured_id; ?>[title][<?php echo $language['language_id']; ?>]" data-language_id="<?php echo $language['language_id']; ?>" value="<?php echo isset($setting['title'][$language['language_id']]) ? $setting['title'][$language['language_id']] : ''; ?>" />                        
                            </div>
                          <?php } ?>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="entry-title-link-<?php echo $featured_id; ?>">
                          <span data-toggle="tooltip" title="<?php echo $help_title_link; ?>"><?php echo $entry_title_link; ?></span>
                        </label>
                        <div class="col-sm-10">
                          <input type="text" id="entry-title-link-<?php echo $featured_id; ?>" class="input-title-link form-control" name="multi_featured_<?php echo $featured_id; ?>[title_link]" value="<?php echo $setting['title_link']; ?>" />
                        </div>
                      </div>
                      
                      <hr />
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="entry-product-autocomplete-<?php echo $featured_id; ?>">
                          <span data-toggle="tooltip" title="<?php echo $help_product; ?>"><?php echo $entry_product; ?></span>
                        </label>
                        <div class="col-sm-10">
                          <div class="row">
                            <div class="col-xs-6">
                              <input id="entry-product-autocomplete-<?php echo $featured_id; ?>" class="input-product-autocomplete form-control" type="text" name="product_<?php echo $featured_id; ?>" value="" placeholder="<?php echo $help_product; ?>" />
                            </div>
                          </div>

                          <div class="checkbox">
                            <input type="hidden" class="input-hidden-incl-dab-prods" name="multi_featured_<?php echo $featured_id; ?>[incl_dab_prods]" value="0" />
                            <label>
                              <input type="checkbox" class="input-checkbox-incl-dab-prods" name="multi_featured_<?php echo $featured_id; ?>[incl_dab_prods]" value="1" <?php echo ($setting['incl_dab_prods'] == 1 ? 'checked="checked"' : ''); ?> />
                              <?php echo $entry_incl_dab_prods; ?>
                            </label>                   
                          </div>
                          
                          <div class="space-6"></div>
                          
                          <div id="multi-featured-<?php echo $featured_id; ?>-product" class="well well-sm scrollbox scrollbox-multi-featured-product mb0">
                            <?php if ($setting['products']) { ?>
                              <?php 
                                $firstKey = array_search(reset($setting['products']), $setting['products']);
                                $lastKey = array_search(end($setting['products']), $setting['products']);
                              ?>
                              <?php foreach ($setting['products'] as $index => $product) { ?>
                                <div id="multi-featured-<?php echo $featured_id; ?>-product<?php echo $product['product_id']; ?>">
                                  <i class="ic-move-up fa fa-arrow-circle-up <?php echo ($index == $firstKey) ? 'gray' : 'green' ?>"></i>
                                  <i class="ic-move-down fa fa-arrow-circle-down <?php echo ($index == $lastKey) ? 'gray' : 'green' ?>"></i>
                                  <i class="ic-delete fa fa-minus-circle red"></i>
                                  <span><?php echo $product['name']; ?></span>
                                  <input type="hidden" value="<?php echo $product['product_id']; ?>" />
                                </div>
                              <?php } ?>
                            <?php } ?>
                          </div>

                          <input type="hidden" class="input-product form-control" name="multi_featured_<?php echo $featured_id; ?>[product]" value="<?php echo $setting['product']; ?>" />

                          <div class="disp-oos-prods checkbox">
                            <input type="hidden" class="input-hidden-disp-oos-prods" name="multi_featured_<?php echo $featured_id; ?>[disp_oos_prods]" value="0" />
                            <label>
                              <input type="checkbox" class="input-checkbox-disp-oos-prods" name="multi_featured_<?php echo $featured_id; ?>[disp_oos_prods]" value="1" <?php echo ($setting['disp_oos_prods'] == 1 ? 'checked="checked"' : ''); ?> /> 
                              <?php echo $entry_disp_oos_prods; ?>
                            </label>
                          </div>          

                        </div>
                      </div>              
                      
                      <hr />
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="entry-random-products-<?php echo $featured_id; ?>">
                          <?php echo $entry_random_products; ?>
                        </label>
                        <div class="col-sm-10">

                          <div class="radio">
                            <label>
                              <input type="radio" class="input-radio-random-products" name="multi_featured_<?php echo $featured_id; ?>[random_products]" value="0" <?php echo ($setting['random_products'] == 0 ? 'checked="checked"' : ''); ?> />
                              <?php echo $text_random_products_0; ?>
                            </label>
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="input-radio-random-products" name="multi_featured_<?php echo $featured_id; ?>[random_products]" value="1" <?php echo ($setting['random_products'] == 1 ? 'checked="checked"' : ''); ?> />
                              <?php echo $text_random_products_1; ?>
                            </label>
                          </div> 

                          <div class="radio">
                            <label>
                              <input type="radio" class="input-radio-random-products" name="multi_featured_<?php echo $featured_id; ?>[random_products]" value="2" <?php echo ($setting['random_products'] == 2 ? 'checked="checked"' : ''); ?> />
                              <?php echo $text_random_products_2; ?>
                            </label>                        
                          </div>

                        </div>
                      </div>
                      
                      <hr />
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="entry-stores-<?php echo $featured_id; ?>">
                          <span data-toggle="tooltip" title="<?php echo $help_stores; ?>"><?php echo $entry_stores; ?></span>
                        </label>
                        <div class="col-sm-10">
                          <div class="well well-sm scrollbox mbm">
                            <?php foreach ($stores as $store) { ?>
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" name="multi_featured_<?php echo $featured_id; ?>[stores][]" value="<?php echo $store['store_id']; ?>" <?php  if (isset($setting['stores']) && in_array($store['store_id'], $setting['stores'])) echo 'checked="checked"'; ?> />
                                <?php echo $store['name']; ?>
                              </label>
                            </div>
                            <?php } ?>
                          </div>

                          <div class="check-uncheck-all-container">
                            <a href="#" class="scrollbox-check-all btn btn-info btn-sm"><?php echo $text_check_all; ?></a>   
                            <a href="#" class="scrollbox-uncheck-all btn btn-warning btn-sm"><?php echo $text_uncheck_all; ?></a>
                          </div>

                        </div>
                      </div>                    
                      
                      <hr />
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="entry-access-levels-<?php echo $featured_id; ?>">
                          <span data-toggle="tooltip" title="<?php echo $help_access_levels; ?>"><?php echo $entry_access_levels; ?></span>
                        </label>
                        <div class="col-sm-10">
                          <div class="well well-sm scrollbox mbm">
                            <?php foreach ($customer_groups as $customer_group) { ?>
                            <div class="checkbox">
                              <?php if (isset($setting['access_levels']) && in_array($customer_group['customer_group_id'], $setting['access_levels'])) { ?>
                                <label>
                                  <input type="checkbox" name="multi_featured_<?php echo $featured_id; ?>[access_levels][]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
                                  <?php echo $customer_group['name']; ?>
                                </label>
                              <?php } else { ?>
                                <label>
                                  <input type="checkbox" name="multi_featured_<?php echo $featured_id; ?>[access_levels][]" value="<?php echo $customer_group['customer_group_id']; ?>" />
                                  <?php echo $customer_group['name']; ?>
                                </label>
                              <?php } ?>
                            </div>
                            <?php } ?>
                          </div>

                          <div class="check-uncheck-all-container">
                            <a href="#" class="scrollbox-check-all btn btn-info btn-sm"><?php echo $text_check_all; ?></a>   
                            <a href="#" class="scrollbox-uncheck-all btn btn-warning btn-sm"><?php echo $text_uncheck_all; ?></a>
                          </div>

                        </div>
                      </div>
                      
                      <hr />
                      
                      <div class="form-group <?php echo (isset($error_template[$featured_id])) ? 'has-error' : ''; ?>">
                        <label class="col-sm-2 control-label" for="entry-template-<?php echo $featured_id; ?>">
                          <span data-toggle="tooltip" title="<?php echo $help_template; ?>"><?php echo $entry_template; ?></span>
                        </label>
                        <div class="col-sm-10">
                          <input type="hidden" class="input-hidden-use-default-template" name="multi_featured_<?php echo $featured_id; ?>[use_default_template]" value="0" />
                          <label>
                            <input type="checkbox" class="input-checkbox-use-default-template" name="multi_featured_<?php echo $featured_id; ?>[use_default_template]" value="1" <?php echo ($setting['use_default_template'] == 1 ? 'checked="checked"' : ''); ?> /> 
                            <?php echo $entry_use_default_template; ?>
                          </label>
                          <div class="well well-sm">
                            <div class="input-template-container form-inline">
                              multi_featured<span class="input-template-underscore">_</span>
                              <input type="text" class="input-template form-control" name="multi_featured_<?php echo $featured_id; ?>[template]" value="<?php echo $setting['template']; ?>" />.tpl
                              <?php if (isset($error_template[$featured_id])) { ?>
                                <div class="error"><?php echo $error_template[$featured_id]; ?></div>
                              <?php } ?>  
                            </div>
                          </div>
                        </div>
                      </div>    
                      
                      <hr />
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="entry-stylesheet-<?php echo $featured_id; ?>">
                          <span data-toggle="tooltip" title="<?php echo $help_stylesheet; ?>"><?php echo $entry_stylesheet; ?></span>
                        </label>
                        <div class="col-sm-10">
                          <input type="hidden" class="input-hidden-use-default-stylesheet" name="multi_featured_<?php echo $featured_id; ?>[use_default_stylesheet]" value="0" />
                          <label>
                            <input type="checkbox" class="input-checkbox-use-default-stylesheet" name="multi_featured_<?php echo $featured_id; ?>[use_default_stylesheet]" value="1" <?php echo ($setting['use_default_stylesheet'] == 1 ? 'checked="checked"' : ''); ?> /> 
                            <?php echo $entry_use_default_stylesheet; ?>
                          </label>
                          <div class="textarea-stylesheet-container">
                            <textarea id="entry-stylesheet-<?php echo $featured_id; ?>" class="textarea-stylesheet form-control" name="multi_featured_<?php echo $featured_id; ?>[stylesheet]" rows="2"><?php echo isset($setting['stylesheet']) ? $setting['stylesheet'] : ''; ?></textarea>
                          </div>
                        </div>
                      </div>    

                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="entry-javascript-<?php echo $featured_id; ?>">
                          <span data-toggle="tooltip" title="<?php echo $help_javascript; ?>"><?php echo $entry_javascript; ?></span>
                        </label>
                        <div class="col-sm-10">
                          <textarea id="entry-javascript-<?php echo $featured_id; ?>" class="textarea-javascript form-control" name="multi_featured_<?php echo $featured_id; ?>[javascript]" rows="2"><?php echo isset($setting['javascript']) ? $setting['javascript'] : ''; ?></textarea>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="entry-params-<?php echo $featured_id; ?>">
                          <span data-toggle="tooltip" title="<?php echo $help_params; ?>"><?php echo $entry_params; ?></span>
                        </label>
                        <div class="col-sm-10">
                          <textarea id="entry-params-<?php echo $featured_id; ?>" class="textarea-params form-control" name="multi_featured_<?php echo $featured_id; ?>[params]" rows="2"><?php echo isset($setting['params']) ? $setting['params'] : ''; ?></textarea>
                        </div>
                      </div>
                      
                      <hr />   
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="entry-limit-<?php echo $featured_id; ?>">
                          <?php echo $entry_limit; ?>
                        </label>
                        <div class="col-sm-10">
                          <div class="row">
                            <div class="col-sm-6 col-md-4">
                              <input type="text" id="entry-limit-<?php echo $featured_id; ?>" class="input-limit form-control" name="multi_featured_<?php echo $featured_id; ?>[limit]" value="<?php echo isset($setting['limit']) ? $setting['limit'] : ''; ?>" />
                            </div>
                          </div>                          
                        </div>
                      </div>                      
                      
                      <div class="form-group <?php echo (isset($error_width[$featured_id])) ? 'has-error' : ''; ?>">
                        <label class="col-sm-2 control-label" for="entry-width-<?php echo $featured_id; ?>">
                          <?php echo $entry_width; ?>
                        </label>
                        <div class="col-sm-10">
                          <div class="row">
                            <div class="col-sm-6 col-md-4">
                              <input type="text" id="entry-width-<?php echo $featured_id; ?>" class="input-width form-control" name="multi_featured_<?php echo $featured_id; ?>[width]" value="<?php echo isset($setting['width']) ? $setting['width'] : ''; ?>" />
                              <?php if (isset($error_width[$featured_id])) { ?>
                                <div class="text-danger"><?php echo $error_width[$featured_id]; ?></div>
                              <?php } ?>  
                            </div>
                          </div>                          
                        </div>
                      </div>                      
                      
                      <div class="form-group <?php echo (isset($error_height[$featured_id])) ? 'has-error' : ''; ?>">
                        <label class="col-sm-2 control-label" for="entry-height-<?php echo $featured_id; ?>">
                          <?php echo $entry_height; ?>
                        </label>
                        <div class="col-sm-10">
                          <div class="row">
                            <div class="col-sm-6 col-md-4">
                              <input type="text" id="entry-height-<?php echo $featured_id; ?>" class="input-height form-control" name="multi_featured_<?php echo $featured_id; ?>[height]" value="<?php echo isset($setting['height']) ? $setting['height'] : ''; ?>" />
                              <?php if (isset($error_height[$featured_id])) { ?>
                                <div class="text-danger"><?php echo $error_height[$featured_id]; ?></div>
                              <?php } ?>  
                            </div>
                          </div>                          
                        </div>
                      </div>                      
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="entry-status-<?php echo $featured_id; ?>">
                          <?php echo $entry_status; ?>
                        </label>
                        <div class="col-sm-10">
                          <div class="row">
                            <div class="col-sm-6 col-md-4">
                              <select id="entry-status-<?php echo $featured_id; ?>" class="select-status form-control" name="multi_featured_<?php echo $featured_id; ?>[status]">
                                <?php if (isset($setting['status']) && $setting['status']) { ?>
                                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                  <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                  <option value="1"><?php echo $text_enabled; ?></option>
                                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                              </select>                      
                            </div>
                          </div>                          
                        </div>
                      </div>

                    </div>
                    <!-- /.vtabs-content -->
                  <?php } ?>
                </div>
                <!-- .col -->
              </div>
              <!-- /.row -->       

            </div>
            <!-- /.tab-pane -->
            
            
            <div class="tab-pane" id="tab-config">
              
              <fieldset>
                <legend><?php echo $text_general; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="select-status"><?php echo $entry_status; ?></label>
                  <div class="col-sm-4">
                    <select name="<?php echo $module_key .'_status';?>" id="select-status" class="form-control">
                      <?php if (${$module_key . '_status'}) { ?>
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
                  <label class="col-sm-2 control-label" for="input-cache-expire">
                    <span data-toggle="tooltip" title="<?php echo $help_cache_expire; ?>"><?php echo $entry_cache_expire; ?></span>
                  </label>
                  <div class="col-sm-4">
                    <input type="text" name="<?php echo $module_key . '_config[cache_expire]'; ?>" value="<?php echo ${$module_key . '_config'}['cache_expire']; ?>" placeholder="<?php echo $entry_cache_expire; ?>" id="input-cache-expire" class="form-control" />
                  </div>
                </div>
              </fieldset>
              
            </div>
            <!-- /.tab-pane -->            
            
            
            <?php if (version_compare(VERSION, '2.0', '<')) { // Deprecated and not being used. ?>
            
            <div class="tab-pane" id="tab-content-module">
              <div class="table-responsive">
                <table id="module" class="table table-striped table-bordered table-hover">
                  <colgroup></colgroup>
                  <colgroup></colgroup>
                  <colgroup width="80"></colgroup>
                  <colgroup width="160"></colgroup>
                  <colgroup width="160"></colgroup>
                  <colgroup></colgroup>
                  <thead>
                    <tr>
                      <td class="text-right">#</td>
                      <td class="text-left"><?php echo $entry_multi_featured_id; ?></td>
                      <td class="text-left"><?php echo $entry_limit; ?></td>
                      <td class="text-left"><?php echo $entry_image; ?></td>
                      <td class="text-left"><?php echo $entry_status; ?></td>
                      <td></td>
                    </tr>
                    <tr class="filter" style="display: none">
                      <td class="text-right"></td>
                      <td><input type="text" name="filter_module_featured_name" data-class=".select-module-featured-id" value="" class="form-control input-sm" /></td> 
                      <td><input type="text" name="filter_module_limit" data-class=".input-module-limit" value="" class="form-control input-sm" /></td>
                      <td>
                        <div class="row">
                          <div class="col-xs-6 prs">
                            <input type="text" name="filter_module_width" data-class=".input-module-width" value="" class="form-control input-sm" />
                          </div>
                          <div class="col-xs-6 pls">
                            <input type="text" name="filter_module_height" data-class=".input-module-height" value="" class="form-control input-sm" />
                          </div>
                        </div>
                      </td>
                      <td class="text-left">
                        <select name="filter_module_status" data-class=".select-module-status" class="form-control input-sm">
                          <option value="*"></option>
                          <option value="1"><?php echo $text_enabled; ?></option>
                          <option value="0"><?php echo $text_disabled; ?></option>
                        </select>
                      </td>
                      <td class="text-left">
                        <a id="button-clear-filters" class="btn btn-info" data-toggle="tooltip" title="<?php echo $button_clear_filters; ?>"><i class="fa fa-paint-brush"></i></a>
                      </td>
                    </tr>           
                  </thead>
                  <?php $module_row = 1; ?>
                  <?php foreach ($multi_featured_modules as $multi_featured_module) { ?>
                    <?php // debug( $multi_featured_module ); ?>
                    <tbody id="module-row<?php echo $module_row; ?>">
                      <tr>
                        <td class="text-right"><?php echo $module_row; ?></td>
                        <td class="text-left">
                          <select class="select-module-featured-id form-control input-sm" name="multi_featured_module[<?php echo $multi_featured_module['key']; ?>][featured_id]">
                            <option value=""></option>
                            <?php $setting_row = 1; ?>
                            <?php foreach($multi_featured_settings as $featured_id => $setting) { ?>
                              <option value="<?php echo $featured_id; ?>" <?php echo (isset($multi_featured_module['featured_id']) && $multi_featured_module['featured_id'] == $featured_id) ? 'selected="selected"' : ''; ?>><!--
                                --><?php echo (isset($setting['name']) && $setting['name']) ?  $setting['name'] : "{$text_featured_content} {$setting_row}"; ?><!--
                              --></option>
                              <?php $setting_row++; ?>
                            <?php } ?>                
                          </select>
                          <?php if (isset($error_featured_id[$multi_featured_module['key']])) { ?>
                            <div class="error"><?php echo $error_featured_id[$multi_featured_module['key']]; ?></div>
                          <?php } ?>                                            
                        </td>                                
                        <td class="text-left">
                          <input type="text" class="input-module-limit form-control input-sm" name="multi_featured_module[<?php echo $multi_featured_module['key']; ?>][limit]" value="<?php echo $multi_featured_module['limit']; ?>" />
                        </td>
                        <td class="text-left">
                          <div class="row">
                            <div class="col-xs-6 prs">                        
                              <input type="text" class="input-module-width form-control input-sm" name="multi_featured_module[<?php echo $multi_featured_module['key']; ?>][width]" value="<?php echo $multi_featured_module['width']; ?>" />
                            </div>
                            <div class="col-xs-6 pls">                        
                              <input type="text" class="input-module-height form-control input-sm" name="multi_featured_module[<?php echo $multi_featured_module['key']; ?>][height]" value="<?php echo $multi_featured_module['height']; ?>" />
                            </div>
                          </div>
                          <?php if (isset($error_image[$multi_featured_module['key']])) { ?>
                            <span class="error"><?php echo $error_image[$multi_featured_module['key']]; ?></span>
                          <?php } ?>
                        </td>
                        <td class="text-left">
                          <select class="select-module-status form-control input-sm" name="multi_featured_module[<?php echo $multi_featured_module['key']; ?>][status]">
                            <?php if ($multi_featured_module['status']) { ?>
                              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                              <option value="0"><?php echo $text_disabled; ?></option>
                            <?php } else { ?>
                              <option value="1"><?php echo $text_enabled; ?></option>
                              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                            <?php } ?>
                          </select>
                        </td>
                        <td class="text-left">
                          <a href="#" class="btn btn-danger" data-toggle="tooltip" title="<?php echo $button_remove; ?>"><i class="fa fa-minus-circle"></i></a>
                        </td>
                      </tr>
                    </tbody>
                    <?php $module_row++; ?>
                  <?php } ?>
                  <tfoot>
                    <tr>
                      <td colspan="5"></td>
                      <td class="text-left"><a id="button-add-module" class="btn btn-primary" data-toggle="tooltip" title="<?php echo $button_module_add; ?>"><i class="fa fa-plus-circle"></i></a></td>
                    </tr>
                  </tfoot>
                </table>        
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.tab-pane -->
            
            <?php } // for OpenCart 2.0.0.0 or earlier. ?>            
            
          </div>
          <!-- /.tab-content -->
        </form>

        <input type="hidden" id="token" name="token" value="<?php echo $token; ?>" />
        <input type="hidden" id="max-input-vars" name="max_input_vars" value="<?php echo $max_input_vars; ?>" />
        <input type="hidden" id="locked" name="locked" value="0" />
        <input type="hidden" id="module_id" name="module_id" value="<?php echo $module_id; ?>" />

      </div>
      <!-- /#multiFeatured -->
    </div>
    <!-- /.panel -->    
    
  </div>
  <!-- /.container-fluid -->    
</div>
<!-- /#content -->

<script type="text/javascript">//<![CDATA[
  $(function() {
    
    var options = {};
    
    options['oc_version'] = '<?php echo VERSION; ?>';
    
    // Translations
    options['translations'] = {
      'entry_name': '<?php echo $entry_name; ?>',
      'entry_title': '<?php echo $entry_title; ?>',
      'entry_title_link': '<?php echo $entry_title_link; ?>',
      'entry_product': '<?php echo $entry_product; ?>',
      'entry_incl_dab_prods': '<?php echo $entry_incl_dab_prods; ?>',
      'entry_product_list': '<?php echo $entry_product_list; ?>',
      'entry_disp_oos_prods': '<?php echo $entry_disp_oos_prods; ?>',
      'entry_random_products': '<?php echo $entry_random_products; ?>',
      'help_name': '<?php echo $help_name; ?>',
      'help_title': '<?php echo $help_title; ?>',
      'help_title_link': '<?php echo $help_title_link; ?>',
      'help_product': '<?php echo $help_product; ?>',
      'help_product_list': '<?php echo $help_product_list; ?>',
      'help_stores': '<?php echo $help_stores; ?>',
      'help_access_levels': '<?php echo $help_access_levels; ?>',
      'help_template': '<?php echo $help_template; ?>',
      'help_stylesheet': '<?php echo $help_stylesheet; ?>',
      'help_javascript': '<?php echo $help_javascript; ?>',
      'help_params': '<?php echo $help_params; ?>',
      'text_random_products_0': '<?php echo $text_random_products_0; ?>',
      'text_random_products_1': '<?php echo $text_random_products_1; ?>',
      'text_random_products_2': '<?php echo $text_random_products_2; ?>',
      'entry_stores': '<?php echo $entry_stores; ?>',
      'entry_access_levels': '<?php echo $entry_access_levels; ?>',
      'text_check_all': '<?php echo $text_check_all; ?>',
      'text_uncheck_all': '<?php echo $text_uncheck_all; ?>',
      'entry_template': '<?php echo $entry_template; ?>',
      'entry_use_default_template': '<?php echo $entry_use_default_template; ?>',
      'entry_stylesheet': '<?php echo $entry_stylesheet; ?>',
      'entry_use_default_stylesheet': '<?php echo $entry_use_default_stylesheet; ?>',
      'entry_javascript': '<?php echo $entry_javascript; ?>',
      'entry_params': '<?php echo $entry_params; ?>',
      'entry_limit': '<?php echo $entry_limit; ?>',
      'entry_width': '<?php echo $entry_width; ?>',
      'entry_height': '<?php echo $entry_height; ?>',
      'entry_status': '<?php echo $entry_status; ?>',
      'text_featured_content': '<?php echo $text_featured_content; ?>',
      'text_confirm_delete_product_list': '<?php echo $text_confirm_delete_product_list; ?>',
      'text_content_top': '<?php echo $text_content_top; ?>',
      'text_content_bottom': '<?php echo $text_content_bottom; ?>',
      'text_column_left': '<?php echo $text_column_left; ?>',
      'text_column_right': '<?php echo $text_column_right; ?>',
      'text_enabled': '<?php echo $text_enabled; ?>',
      'text_disabled': '<?php echo $text_disabled; ?>',
      'button_remove': '<?php echo $button_remove; ?>'
    }    
    
    // Languages
    var _languages = [];
    
    <?php if ($languages) { ?>
      <?php if (IS_MIJOSHOP) { ?>
        <?php foreach ($languages as $language) { ?>
          // MijoShop will automatically convert this to something like: "http://example.com/media/mod_languages/images/en.gif" 
          var _src = '<?php echo "src=\"view/image/flags/{$language['image']}\""; ?>';
          _languages.push({
            'language_id': '<?php echo $language['language_id']; ?>',
            'name': '<?php echo $language['name']; ?>',
            'src': _src.replace(/^src=\"(.*?)\"$/g, '$1') // Strip html tags and get a plain src only inside.
          });          
        <?php } ?>        
      <?php } else { ?>
        <?php foreach ($languages as $language) { ?>
          <?php if (version_compare(VERSION, '2.2.0.0', '<')) { // for OpenCart 2.1.0.2 or earlier. ?>
            _languages.push({
              'language_id': '<?php echo $language['language_id']; ?>',
              'name': '<?php echo $language['name']; ?>',
              'src': 'view/image/flags/<?php echo $language['image']; ?>' 
            });
          <?php } else { ?>
            _languages.push({
              'language_id': '<?php echo $language['language_id']; ?>',
              'name': '<?php echo $language['name']; ?>',
              'src': 'language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png' 
            });
          <?php } ?>
        <?php } ?>
      <?php } ?>
    <?php } ?>    
    
    options['languages'] = _languages;
    
    options['primary_language'] = <?php echo json_encode($primary_language); ?>;
    
    // Stores
    options['stores'] = <?php echo json_encode($stores); ?>;
    
    // Customer Groups
    options['customer_groups'] = <?php echo json_encode($customer_groups); ?>;
    
    // Image base URL
    // MijoShop will automatically convert this to "../components/com_mijoshop/opencart/admin/view/image/multi_featured/"
    options['image_base_url'] = 'view/image/multi_featured/';
    
    // Button class
    var _button_class = '';
    <?php if (IS_MIJOSHOP) { ?>
      // MijoShop will automatically convert this to "button_oc" 
      _button_class = '<?php echo "class=\"button\""; ?>'.replace(/^class=\"(.*?)\"$/g, '$1');
    <?php } else { ?>
      _button_class = 'button';
     <?php } ?>  
    options['button_class'] = _button_class;
    
    // Determine if it's running on MijoShop or not.
    options['is_mijoshop'] = <?php echo (int)IS_MIJOSHOP; ?>;
    
    // Default width and height for image input fields in the Modules section.
    options['module_image'] = {
      width: 200,
      height: 200
    };
    
    // Initialize the plugin
    $("#MultiFeatured").multiFeatured(options);

  });
//]]></script>

<?php echo $footer; ?>