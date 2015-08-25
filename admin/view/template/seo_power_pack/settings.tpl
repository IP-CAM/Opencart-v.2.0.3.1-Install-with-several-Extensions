<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<form role="form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
		<div class="page-header">
			<div class="container-fluid">
				<h1><?php echo $heading_title; ?></h1>
				<ul class="breadcrumb">
					<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<div class="container-fluid">
			<?php if (isset($error_warning)) { ?>
			<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
			<?php } ?>
			<?php if (isset($success)) { ?>
			<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
			<?php } ?>
			<div class="panel panel-default">
				<div class="panel-body">
					<ul class="nav nav-tabs seo-pp-tabs" role="tablist">
                      	<li class="active"><a href="#main_settings" role="tab" data-toggle="tab"><?=$tab_text_main?></a></li>
                      	<li><a href="#product_settings" role="tab" data-toggle="tab"><?=$tab_text_products?></a></li>
                      	<li><a data-url="index.php?route=seo_power_pack/categories&token=<?=$token?>" href="#categories_settings" role="tab" data-toggle="tab"><?=$tab_text_categories?></a></li>
                      	<li><a data-url="index.php?route=seo_power_pack/manufacturers&token=<?=$token?>" href="#manufacturer_settings" role="tab" data-toggle="tab"><?=$tab_text_manufacturer?></a></li>
                      	<li><a data-url="index.php?route=seo_power_pack/informations&token=<?=$token?>" href="#information_settings" role="tab" data-toggle="tab"><?=$tab_text_information_pages?></a></li>
                      	<li><a data-url="index.php?route=seo_power_pack/duplicate_urls&token=<?=$token?>" href="#duplicate_urls_settings" role="tab" data-toggle="tab"><?=$tab_text_duplicate_url?></a></li>
                       	<li><a data-url="index.php?route=seo_power_pack/custom_urls&token=<?=$token?>" href="#custom_urls_settings" role="tab" data-toggle="tab"><?=$tab_text_custom_urls?></a></li>
                       	<li class="dropdown">
							<a href="#" data-toggle="dropdown" class="dropdown-toggle"><?=$txt_advanced?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#store_seo" role="tab" data-toggle="tab"><?=$txt_store?></a></li>
								<!--<li><a href="#social_seo" role="tab" data-toggle="tab"><?=$txt_social?></a></li>-->
								<li><a href="#webmaster-tool" role="tab" data-toggle="tab"><?=$txt_webmaster_tool?></a></li>
								<li><a href="#google-analytics" role="tab" data-toggle="tab"><?=$txt_google_analytics?></a></li>
								<li><a href="#sitemaps" role="tab" data-toggle="tab"><?=$txt_sitemaps?></a></li>
							</ul>
						</li>
                        <li><a href="#documentation" role="tab" data-toggle="tab" id="help_tab"><?=$tab_text_help?></a></li>
                       	<li><a href="#about_us" role="tab" data-toggle="tab" id="news_and_updates"><?=$tab_text_news_and_updates?></a></li>
                    </ul>
                    <div class="tab-content" style="padding-top:0px;">
                    	<div class="tab-pane in active" id="main_settings">
							<div class="well well-sm auto_settings">
	                    		<div class="form-group">
									<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$txt_auto_translate_seo_url_on_tip?>">
										<input type="radio" value="1" id="auto_translate_seo_url_1" name="auto_translate_seo_url" /> <?=$txt_auto_translate_seo_url_on?>
									</label>
									<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$txt_auto_translate_seo_url_off_tip?>">
										<input type="radio" value="0" id="auto_translate_seo_url_0" name="auto_translate_seo_url" /> <?=$txt_auto_translate_seo_url_off?>
									</label>  
								</div>
							</div>
                    		<div class="panel panel-primary">
                    			<div class="panel-heading"><h3><i class="fa fa-chevron-circle-up"></i><?=$txt_product_seo_settings?></h3></div>
                    			<div class="panel-body seo-setting-form">
                    				<div class="form-group">
                    					<label><?=$txt_meta_title?></label>
                    					<div class="row">
                    						<div class="col-md-9">
												<div class="input-group">
												    <input data-spliter=" " type="text" placeholder="<?=$phr_product_meta_title?>" value="<?=$seo_pp_product_meta_title?>" name="meta_title" id="meta_title" class="form-control">    
												    <div class="input-group-btn">
												        <button id="product_meta_title_gen" type="button" data="product_meta_title" class="generate btn btn-primary" data-toggle="tooltip" data-original-title="<?=$tip_product_meta_title_generate?>"><?=$txt_generate?></button>
												        <a id="product_meta_title_clr" href="#" data="product_meta_title" class="clear btn btn-danger" data-toggle="tooltip" data-original-title="<?=$tip_product_meta_title_clear?>"><?=$txt_clear;?></a>
												    </div>
												</div>
                    						</div>
                    						<div class="col-md-3">
                    							<div class="radio auto_settings">
	                    							<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_on?>">
														<input type="radio" value="1" id="auto_product_meta_title_1" name="auto_product_meta_title" /> <?=$txt_auto_on?>
													</label>
													<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_off?>">
														<input type="radio" value="0" id="auto_product_meta_title_0" name="auto_product_meta_title" /> <?=$txt_auto_off;?>
													</label>  
												</div>    
											</div>
                    					</div>
                    					<div class="allowed-tags">
	                     					<div class="well well-sm">
		                     					<p>
		                     					<a data="name"><?=$ptxt_name;?></a>
		                    					<a data="model"><?=$ptxt_model?></a>
		                    					<a data="price"><?=$ptxt_price?></a>
		                    					<a data="sku"><?=$ptxt_sku?></a>
		                    					<a data="upc"><?=$ptxt_upc?></a>
		                    					<a data="ean"><?=$ptxt_ean?></a>
		                    					<a data="jan"><?=$ptxt_jan?></a>
		                    					<a data="isbn"><?=$ptxt_isbn?></a>
		                    					<a data="mpn"><?=$ptxt_mpn?></a>
		                    					<a data="location"><?=$ptxt_location?></a>
		                     					<a data="manufacturer"><?=$ptxt_manufacturer?></a>
		                     					<a data="category"><?=$ptxt_category?></a></p>
		                     					<?=$note_product_meta_title?>
	                     					</div>
	                     					<div class="help-block"></div>
	                    				</div>                    					
                    				</div>

                    				<div class="form-group">
                    					<label><?=$txt_meta_keyword?></label>
                    					<div class="row">
                    						<div class="col-md-9">
												<div class="input-group">
												    <input data-spliter="," type="text" placeholder="<?=$phr_product_meta_keyword?>" value="<?=$seo_pp_product_meta_keyword?>" name="meta_keywords" id="meta_keywords" class="form-control">    
												    <div class="input-group-btn">
												        <button id="product_meta_keyword_gen" type="button" data="product_meta_keyword" class="generate btn btn-primary" data-toggle="tooltip" data-original-title="<?=$tip_product_meta_keyword_generate?>"><?=$txt_generate?></button>
												        <a id="product_meta_keyword_clr" href="#" data="product_meta_keyword" class="clear btn btn-danger" data-toggle="tooltip" data-original-title="<?=$tip_product_meta_keyword_clear?>"><?=$txt_clear;?></a>
												    </div>
												</div>
                    						</div>
                    						<div class="col-md-3">
                    							<div class="radio auto_settings">
	                    							<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_on?>">
														<input type="radio" value="1" id="auto_product_meta_keyword_1" name="auto_product_meta_keyword" /> <?=$txt_auto_on?>
													</label>
													<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_off?>">
														<input type="radio" value="0" id="auto_product_meta_keyword_0" name="auto_product_meta_keyword" /> <?=$txt_auto_off;?>
													</label>  
												</div>    
											</div>
                    					</div>
	                    				<div class="allowed-tags">
	                     					<div class="well well-sm">
		                     					<p>
		                     					<a data="name"><?=$ptxt_name;?></a>
		                    					<a data="model"><?=$ptxt_model?></a>
		                    					<a data="price"><?=$ptxt_price?></a>
		                    					<a data="sku"><?=$ptxt_sku?></a>
		                    					<a data="upc"><?=$ptxt_upc?></a>
		                    					<a data="ean"><?=$ptxt_ean?></a>
		                    					<a data="jan"><?=$ptxt_jan?></a>
		                    					<a data="isbn"><?=$ptxt_isbn?></a>
		                    					<a data="mpn"><?=$ptxt_mpn?></a>
		                    					<a data="location"><?=$ptxt_location?></a>
		                     					<a data="manufacturer"><?=$ptxt_manufacturer?></a>
		                     					<a data="category"><?=$ptxt_category?></a></p>
		                     					<?=$note_product_meta_keyword?>
	                     					</div>
	                     					<div class="help-block"></div>
	                    				</div>                  					
                    				</div>
                    				

                    				<div class="form-group">
                    					<label><?=$txt_meta_description?></label>
                    					<div class="row">
                    						<div class="col-md-9">
												<div class="input-group">
												    <input data-spliter=" " type="text" placeholder="<?=$phr_product_meta_description?>" value="<?=$seo_pp_product_meta_description?>" name="meta_description" id="meta_description" class="form-control">    
												    <div class="input-group-btn">
												        <button id="product_meta_description_gen" type="button" data="product_meta_description" class="generate btn btn-primary" data-toggle="tooltip" data-original-title="<?=$tip_product_meta_desc_generate?>"><?=$txt_generate?></button>
												        <a id="product_meta_description_clr" href="#" data="product_meta_description" class="clear btn btn-danger" data-toggle="tooltip" data-original-title="<?=$tip_product_meta_desc_clear?>"><?=$txt_clear;?></a>
												    </div>
												</div>
                    						</div>
                    						<div class="col-md-3">
                    							<div class="radio auto_settings">
	                    							<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_on?>">
														<input type="radio" value="1" id="auto_product_meta_description_1" name="auto_product_meta_description" /> <?=$txt_auto_on?>
													</label>
													<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_off?>">
														<input type="radio" value="0" id="auto_product_meta_description_0" name="auto_product_meta_description" /> <?=$txt_auto_off;?>
													</label>  
												</div>    
											</div>
                    					</div>  
                    					<div class="allowed-tags">
	                     					<div class="well well-sm">
		                     					<p>
		                     					<a data="name"><?=$ptxt_name;?></a>
		                    					<a data="model"><?=$ptxt_model?></a>
		                    					<a data="price"><?=$ptxt_price?></a>
		                    					<a data="sku"><?=$ptxt_sku?></a>
		                    					<a data="upc"><?=$ptxt_upc?></a>
		                    					<a data="ean"><?=$ptxt_ean?></a>
		                    					<a data="jan"><?=$ptxt_jan?></a>
		                    					<a data="isbn"><?=$ptxt_isbn?></a>
		                    					<a data="mpn"><?=$ptxt_mpn?></a>
		                    					<a data="location"><?=$ptxt_location?></a>
		                     					<a data="manufacturer"><?=$ptxt_manufacturer?></a>
		                     					<a data="category"><?=$ptxt_category?></a></p>
		                     					<?=$note_product_meta_description?>
	                     					</div>
	                     					<div class="help-block"></div>
	                    				</div>                					
                    				</div>

                    				<div class="form-group">
                    					<label><?=$txt_product_image_name_seo_optimiser?></label>
                    					<div class="row">
                    						<div class="col-md-9">
												<div class="input-group">
												    <input data-spliter=" " type="text" placeholder="<?=$phr_product_image_name_seofrdly?>" value="<?=$seo_pp_product_image_name_pattern?>" name="product_image_name_pattern" id="product_image_name_pattern" class="form-control">    
												    <div class="input-group-btn">
												        <button id="product_image_name_pattern_gen" type="button" data="product_image_name_pattern" class="generate btn btn-primary" data-toggle="tooltip" data-original-title="<?=$tip_product_img_name_generate?>"><?=$btn_rename?></button>
												        <a id="product_image_name_pattern_clr" href="#" data="product_image_name_pattern" class="clear btn btn-danger" data-toggle="tooltip" data-original-title="<?=$tip_product_img_name_clear?>"><?=$txt_clear;?></a>
												    </div>
												</div>
                    						</div>
                    						<div class="col-md-3">
                    							<div class="radio auto_settings">
	                    							<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_on?>">
														<input type="radio" value="1" id="auto_product_image_name_pattern_1" name="auto_product_image_name_pattern" /> <?=$txt_auto_on?>
													</label>
													<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_off?>">
														<input type="radio" value="0" id="auto_product_image_name_pattern_0" name="auto_product_image_name_pattern" /> <?=$txt_auto_off;?>
													</label>  
												</div>    
											</div>
                    					</div>
                    					<div class="allowed-tags">
	                     					<div class="well well-sm">
		                     					<p>
		                     					<a data="name"><?=$ptxt_name;?></a>
		                    					<a data="model"><?=$ptxt_model?></a>
		                    					<a data="price"><?=$ptxt_price?></a>
		                    					<a data="sku"><?=$ptxt_sku?></a>
		                    					<a data="upc"><?=$ptxt_upc?></a>
		                    					<a data="ean"><?=$ptxt_ean?></a>
		                    					<a data="jan"><?=$ptxt_jan?></a>
		                    					<a data="isbn"><?=$ptxt_isbn?></a>
		                    					<a data="mpn"><?=$ptxt_mpn?></a>
		                    					<a data="location"><?=$ptxt_location?></a>
		                     					<a data="manufacturer"><?=$ptxt_manufacturer?></a>
		                     					<a data="category"><?=$ptxt_category?></a></p>
		                     					<?=$note_product_image_name_seofrdly?>
	                     					</div>
	                     					<div class="help-block"></div>
	                    				</div>                    					
                    				</div>
  
                    				<div class="form-group">
                    					<label><?=$txt_product_tags?></label>
                    					<div class="row">
                    						<div class="col-md-9">
												<div class="input-group">
												    <input data-spliter="," type="text" placeholder="<?=$phr_product_tag?>" value="<?=$seo_pp_product_tags?>" name="product_tags" id="product_tags" class="form-control">    
												    <div class="input-group-btn">
												        <button id="product_tags_gen" type="button" data="product_tags" class="generate btn btn-primary" data-toggle="tooltip" data-original-title="<?=$tip_product_tag_generate?>"><?=$txt_generate?></button>
												        <a id="product_tags_clr" href="#" data="product_tags" class="clear btn btn-danger" data-toggle="tooltip" data-original-title="<?=$tip_product_tag_clear?>"><?=$txt_clear;?></a>
												    </div>
												</div>
                    						</div>
                    						<div class="col-md-3">
                    							<div class="radio auto_settings">
	                    							<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_on?>">
														<input type="radio" value="1" id="auto_product_tags_1" name="auto_product_tags" /> <?=$txt_auto_on?>
													</label>
													<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_off?>">
														<input type="radio" value="0" id="auto_product_tags_0" name="auto_product_tags" /> <?=$txt_auto_off;?>
													</label>  
												</div>    
											</div>
                    					</div> 
	                    				<div class="allowed-tags">
	                     					<div class="well well-sm">
		                     					<p>
		                     					<a data="name"><?=$ptxt_name;?></a>
		                    					<a data="model"><?=$ptxt_model?></a>
		                    					<a data="price"><?=$ptxt_price?></a>
		                    					<a data="sku"><?=$ptxt_sku?></a>
		                    					<a data="upc"><?=$ptxt_upc?></a>
		                    					<a data="ean"><?=$ptxt_ean?></a>
		                    					<a data="jan"><?=$ptxt_jan?></a>
		                    					<a data="isbn"><?=$ptxt_isbn?></a>
		                    					<a data="mpn"><?=$ptxt_mpn?></a>
		                    					<a data="location"><?=$ptxt_location?></a>
		                     					<a data="manufacturer"><?=$ptxt_manufacturer?></a>
		                     					<a data="category"><?=$ptxt_category?></a></p>
		                     					<?=$note_product_tag?>
	                     					</div>
	                     					<div class="help-block"></div>
	                    				</div>                  					
                    				</div>

                    				<div class="form-group">
                    					<label><?=$txt_seo_keyword?></label>
                    					<div class="row">
                    						<div class="col-md-9">
												<div class="input-group">
												    <input data-spliter="-" type="text" placeholder="<?=$phr_product_seo_keyword?>" value="<?=$seo_pp_product_seo_url?>" name="product_url" id="product_url" class="form-control">    
												    <div class="input-group-btn">
												        <button id="product_seo_url_gen" type="button" data="product_seo_url" class="generate btn btn-primary" data-toggle="tooltip" data-original-title="<?=$tip_product_seo_keyword_generate?>"><?=$txt_generate?></button>
												        <a id="product_seo_url_clr" href="#" data="product_seo_url" class="clear btn btn-danger" data-toggle="tooltip" data-original-title="<?=$tip_product_seo_keyword_clear?>"><?=$txt_clear;?></a>
												    </div>
												</div>
                    						</div>
                    						<div class="col-md-3">
                    							<div class="radio auto_settings">
	                    							<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_on?>">
														<input type="radio" value="1" id="auto_product_seo_url_1" name="auto_product_seo_url" /> <?=$txt_auto_on?>
													</label>
													<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_off?>">
														<input type="radio" value="0" id="auto_product_seo_url_0" name="auto_product_seo_url" /> <?=$txt_auto_off;?>
													</label>  
												</div>    
											</div>
                    					</div>  
                    					<div class="allowed-tags">
	                     					<div class="well well-sm">
		                     					<p>
		                     					<a data="id"><?=$ptxt_id?></a>
		                     					<a data="name"><?=$ptxt_name;?></a>
		                    					<a data="model"><?=$ptxt_model?></a>
		                    					<a data="price"><?=$ptxt_price?></a>
		                    					<a data="sku"><?=$ptxt_sku?></a>
		                    					<a data="upc"><?=$ptxt_upc?></a>
		                    					<a data="ean"><?=$ptxt_ean?></a>
		                    					<a data="jan"><?=$ptxt_jan?></a>
		                    					<a data="isbn"><?=$ptxt_isbn?></a>
		                    					<a data="mpn"><?=$ptxt_mpn?></a>
		                    					<a data="location"><?=$ptxt_location?></a>
		                     					<a data="manufacturer"><?=$ptxt_manufacturer?></a>
		                     					<a data="category"><?=$ptxt_category?></a></p>
		                     					<?=$note_product_seo_keyword?>
	                     					</div>
	                     					<div class="help-block"></div>
	                    				</div>                   					
                    				</div>

                    				<div class="form-group">
                    					<label><?=$txt_related_products_auto_generate?></label>
                    					<div class="row">
                    						<div class="col-md-9">
												<div class="input-group">
												    <input data-spliter="," type="text" placeholder="<?=$phr_product_related_products?>" value="<?=$seo_pp_product_relpro?>" name="product_relpro" id="product_relpro" class="form-control">    
												    <div class="input-group-btn">
												        <button id="product_relpro_gen" type="button" data="product_relpro" class="generate btn btn-primary" data-toggle="tooltip" data-original-title="<?=$tip_product_related_products_generate?>"><?=$txt_generate?></button>
												        <a id="product_relpro_clr" href="#" data="product_relpro" class="clear btn btn-danger" data-toggle="tooltip" data-original-title="<?=$tip_product_related_products_clear?>"><?=$txt_clear;?></a>
												    </div>
												</div>
                    						</div>
                    						<div class="col-md-3">
                    							<div class="radio auto_settings">
	                    							<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_on?>">
														<input type="radio" value="1" id="auto_product_relpro_1" name="auto_product_relpro" /> <?=$txt_auto_on?>
													</label>
													<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_off?>">
														<input type="radio" value="0" id="auto_product_relpro_0" name="auto_product_relpro" /> <?=$txt_auto_off;?>
													</label>  
												</div>    
											</div>
                    					</div> 
	                    				<div class="allowed-tags"><p><?=$note_product_related_products?></p></div>                  					
                    				</div>
                    			</div>
                    		</div>
                			<script type="text/javascript">
							// I found this somewhere on the intertubes, and optimized it

							if(typeof($.fn.insertAtCaret) == 'undefined'){
								$.fn.insertAtCaret = function(myValue) {
									return this.each(function() {
										var me = this;
										if (document.selection) { // IE
											me.focus();
											sel = document.selection.createRange();
											sel.text = myValue;
											me.focus();
										} else if (me.selectionStart || me.selectionStart == '0') { // Real browsers
											var startPos = me.selectionStart, endPos = me.selectionEnd, scrollTop = me.scrollTop;
											me.value = me.value.substring(0, startPos) + myValue + me.value.substring(endPos, me.value.length);
											me.focus();
											me.selectionStart = startPos + myValue.length;
											me.selectionEnd = startPos + myValue.length;
											me.scrollTop = scrollTop;
										} else {
											me.value += myValue;
											me.focus();
										}
									});
								};	
							}


							$(function(){
								$('.allowed-tags').hide();
								$('.seo-setting-form .form-control').bind('focus', function(){
									$('.allowed-tags').hide();
									$(this).closest('div.row').next('.allowed-tags').show();
									$(this).closest('.input-group').find('button.generate').html('<?=$txt_generate?>').removeClass('btn-success');
									$(this).closest('.input-group').find('a.clear').html('<?=$txt_clear?>').removeClass('btn-success').addClass('btn-danger');
								});

								$('.seo-setting-form input.form-control').keyup(function(){
									preview_ele = $(this).closest('.form-group').find('div.help-block').addClass('alert alert-success');
    								//$(this).val($(this).val().replace(/ /g,'').replace(/\]/g,' ]').replace(/\[/g,'[ '));
    								preview_ele.html('<b><?=$txt_example?> </b>'+$(this).val().split(' ][ ').join($(this).data('spliter')).replace('[ ','').replace(' ]',''));
            					});

            					$('.allowed-tags a').each(function(){
            						$(this).attr('href','#').attr('onclick','return false;').addClass('btn btn-primary btn-xs');
            						$(this).bind('click', function(){
            							var input_ele = $(this).closest('div.allowed-tags').prev('div.row').find('input.form-control');
            							var preview_ele = $(this).closest('div.allowed-tags').find('div.help-block').addClass('alert alert-success');
            							var insert_val = '[ '+$(this).attr('data')+' ]';
            							if(input_ele.val().indexOf(insert_val) > -1){
            								alert('<?=$js_warning_tag_already_added?>');
            							} else {
            								input_ele.insertAtCaret(insert_val);
            								//input_ele.val(input_ele.val().replace(/ /g,'').replace(/\]/g,' ]').replace(/\[/g,'[ '));
            								preview_ele.html('<b><?=$txt_example?> </b>'+input_ele.val().split(' ][ ').join(input_ele.data('spliter')).replace('[ ','').replace(' ]',''));
            							}
            						});
            					});

								/* Generate Button */
								$('button.generate').bind('click', function(){
									var generate_ele = $(this);
									if(generate_ele.closest('.input-group').find('.form-control').val().length > 0){
										generate_ele.html('<i class="fa fa-spinner fa-spin"></i> <?=$txt_generate?>').prop('disabled', true);
										$.ajax({
											type:'post',
											cache:false,
											async: true,
											url:"<?=$do_action_url?>".replace('&amp;','&'),
											dataType: 'json',
											data:'action=generate&data='+generate_ele.attr('data')+'&pattern='+generate_ele.closest('.input-group').find('.form-control').val(),
											success:function(response){
												if(parseInt(response.completed,10) == 1){

												}
	    										$('#'+response.data+'_gen').html('Completed').addClass('btn-success').animate({color:'green'}, 
												        410, 
												        'swing', 
												        function(){
												        	$(this).html('<i class="fa fa-thumbs-up"></i> <?=$txt_generate?>').removeClass('btn-success').prop('disabled', false);
												        }
											        );
	  										}
	  									});										
									} else {
										$.notify('<?=$js_warning_please_enter_pattern?>','warn');
										generate_ele.closest('.input-group').find('.form-control').focus();
									}
								});

								/* Clear Button */
								$('a.clear').attr('onclick','return false;').bind('click', function(){
									var clear_ele = $(this);
									clear_ele.html('<i class="fa fa-spinner fa-spin"></i> Clear').prop('disabled', true);
									$.ajax({
										type:'post',
										cache:false,
										async: true,
										url:"<?=$do_action_url?>".replace('&amp;','&'),
										dataType: 'json',
										data:'action=clear&data='+clear_ele.attr('data')+'&pattern='+clear_ele.closest('.input-group').find('.form-control').val(),
										success:function(response){
    										if(parseInt(response.completed,10) == 1){
													
											}
    										$('#'+response.data+'_clr').html('Completed').addClass('btn-success').animate({color:'green'}, 
											        410, 
											        'swing', 
											        function(){
											        	$(this).html('<i class="fa fa-thumbs-up"></i> <?=$txt_clear?>').removeClass('btn-success').prop('disabled', false);
											        }
										        );
  										}
  									});
								});

								$('.tab-content .panel-body').hide();
								$('.tab-content .panel-body:first').show();
								$('#meta_title').focus();
								$('.panel-heading').bind('click', function(){
									var status = false;

									if($(this).next().is(':visible')){
										status = true;
									}

									$('.tab-content .panel-body').hide();

									if(status){
										$(this).find('.fa').removeClass('fa-chevron-circle-down').addClass('fa-chevron-circle-up');
										$(this).next().hide();
									} else {
										$(this).find('.fa').removeClass('fa-chevron-circle-up').addClass('fa-chevron-circle-down');
										$(this).next().show();
									}

								}).css('cursor','pointer');
            				});
            				</script>

            				<!-- Category -->
            				<div class="panel panel-primary">
                    			<div class="panel-heading"><h3><i class="fa fa-chevron-circle-up"></i><?=$txt_category_seo_settings?></h3></div>
                    			<div class="panel-body seo-setting-form">
                    				<div class="form-group">
                    					<label><?=$txt_seo_keyword?></label>
                    					<div class="row">
                    						<div class="col-md-9">
												<div class="input-group">
												    <input data-spliter=" " type="text" placeholder="<?=$phr_category_seo_keyword?>" value="<?=$seo_pp_category_seo_url?>" name="category_seo_url" id="category_seo_url" class="form-control">    
												    <div class="input-group-btn">
												        <button id="category_seo_url_gen" type="button" data="category_seo_url" class="generate btn btn-primary" data-toggle="tooltip" data-original-title="<?=$tip_category_seo_keyword_generate?>"><?=$txt_generate?></button>
												        <a id="category_seo_url_clr" href="#" data="category_seo_url" class="clear btn btn-danger" data-toggle="tooltip" data-original-title="<?=$tip_category_seo_keyword_clear?>"><?=$txt_clear;?></a>
												    </div>
												</div>
                    						</div>
                    						<div class="col-md-3">
                    							<div class="radio auto_settings">
	                    							<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_on?>">
														<input type="radio" value="1" id="auto_category_seo_url_1" name="auto_category_seo_url" /> <?=$txt_auto_on?>
													</label>
													<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_off?>">
														<input type="radio" value="0" id="auto_category_seo_url_0" name="auto_category_seo_url" /> <?=$txt_auto_off;?>
													</label>  
												</div>    
											</div>
                    					</div> 
                    					<div class="allowed-tags">
	                     					<div class="well well-sm">
		                     					<p>
		                     					<a data="id"><?=$ptxt_id?></a>
		                     					<a data="name"><?=$ptxt_name;?></a>
		                    					</p>
		                     					<?=$note_category_seo_keyword?>
	                     					</div>
	                     					<div class="help-block"></div>
	                    				</div>                 					
                    				</div>

                    				<div class="form-group">
                    					<label><?=$txt_meta_title?></label>
                    					<div class="row">
                    						<div class="col-md-9">
												<div class="input-group">
												    <input data-spliter=" " type="text" placeholder="<?=$phr_category_meta_tag_title?>" value="<?=$seo_pp_category_meta_tag_title?>" name="category_meta_tag_title" id="category_meta_tag_title" class="form-control">    
												    <div class="input-group-btn">
												        <button id="category_meta_tag_title_gen" type="button" data="category_meta_tag_title" class="generate btn btn-primary" data-toggle="tooltip" data-original-title="<?=$tip_category_meta_title_generate?>"><?=$txt_generate?></button>
												        <a id="category_meta_tag_title_clr" href="#" data="category_meta_tag_title" class="clear btn btn-danger" data-toggle="tooltip" data-original-title="<?=$tip_category_meta_title_clear?>"><?=$txt_clear;?></a>
												    </div>
												</div>
                    						</div>
                    						<div class="col-md-3">
                    							<div class="radio auto_settings">
	                    							<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_on?>">
														<input type="radio" value="1" id="auto_category_meta_tag_title_1" name="auto_category_meta_tag_title" /> <?=$txt_auto_on?>
													</label>
													<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_off?>">
														<input type="radio" value="0" id="auto_category_meta_tag_title_0" name="auto_category_meta_tag_title" /> <?=$txt_auto_off;?>
													</label>  
												</div>    
											</div>
                    					</div>
                    					<div class="allowed-tags">
	                     					<div class="well well-sm">
		                     					<p>
		                     					<a data="name"><?=$ptxt_name;?></a>
		                    					</p>
		                     					<?=$note_category_meta_tag_title?>
	                     					</div>
	                     					<div class="help-block"></div>
	                    				</div>                   					
                    				</div>

                    				<div class="form-group">
                    					<label><?=$txt_meta_description?></label>
                    					<div class="row">
                    						<div class="col-md-9">
												<div class="input-group">
												    <input data-spliter=" " type="text" placeholder="<?=$phr_category_meta_tag_description?>" value="<?=$seo_pp_category_meta_tag_description?>" name="category_meta_tag_description" id="category_meta_tag_description" class="form-control">    
												    <div class="input-group-btn">
												        <button id="category_meta_tag_description_gen" type="button" data="category_meta_tag_description" class="generate btn btn-primary" data-toggle="tooltip" data-original-title="<?=$tip_category_meta_desc_generate?>"><?=$txt_generate?></button>
												        <a id="category_meta_tag_description_clr" href="#" data="category_meta_tag_description" class="clear btn btn-danger" data-toggle="tooltip" data-original-title="<?=$tip_category_meta_desc_clear?>"><?=$txt_clear;?></a>
												    </div>
												</div>
                    						</div>
                    						<div class="col-md-3">
                    							<div class="radio auto_settings">
	                    							<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_on?>">
														<input type="radio" value="1" id="auto_category_meta_tag_description_1" name="auto_category_meta_tag_description" /> <?=$txt_auto_on?>
													</label>
													<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_off?>">
														<input type="radio" value="0" id="auto_category_meta_tag_description_0" name="auto_category_meta_tag_description" /> <?=$txt_auto_off;?>
													</label>  
												</div>    
											</div>
                    					</div>    
                    					<div class="allowed-tags">
	                     					<div class="well well-sm">
		                     					<p>
		                     					<a data="name"><?=$ptxt_name;?></a>
		                    					<a data="description" data-toggle="tooltip" data-original-title="<?=$tip_tag_meta_desc?>"><?=$ptxt_desc?></a>
		                    					<a data="sub_categories" data-toggle="tooltip" data-original-title="uses direct subcategory names"><?=$ptxt_subcats?></a>
		                    					</p>
		                    					<?=$note_category_meta_tag_description?>
	                     					</div>
	                     					<div class="help-block"></div>
	                    				</div>               					
                    				</div>

                    				<div class="form-group">
                    					<label><?=$txt_meta_keyword?></label>
                    					<div class="row">
                    						<div class="col-md-9">
												<div class="input-group">
												    <input data-spliter="," type="text" placeholder="<?=$phr_category_meta_tag_keyword?>" value="<?=$seo_pp_category_meta_tag_keywords?>" name="category_meta_tag_keywords" id="category_meta_tag_keywords" class="form-control">    
												    <div class="input-group-btn">
												        <button id="category_meta_tag_keywords_gen" type="button" data="category_meta_tag_keywords" class="generate btn btn-primary" data-toggle="tooltip" data-original-title="<?=$tip_category_meta_keyword_generate?>"><?=$txt_generate?></button>
												        <a id="category_meta_tag_keywords_clr" href="#" data="category_meta_tag_keywords" class="clear btn btn-danger" data-toggle="tooltip" data-original-title="<?=$tip_category_meta_keyword_clear?>"><?=$txt_clear;?></a>
												    </div>
												</div>
                    						</div>
                    						<div class="col-md-3">
                    							<div class="radio auto_settings">
	                    							<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_on?>">
														<input type="radio" value="1" id="auto_category_meta_tag_keywords_1" name="auto_category_meta_tag_keywords" /> <?=$txt_auto_on?>
													</label>
													<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_off?>">
														<input type="radio" value="0" id="auto_category_meta_tag_keywords_0" name="auto_category_meta_tag_keywords" /> <?=$txt_auto_off;?>
													</label>  
												</div>    
											</div>
                    					</div> 
                    					<div class="allowed-tags">
	                     					<div class="well well-sm">
		                     					<p>
		                     					<a data="name"><?=$ptxt_name;?></a>
		                    					<a data="sub_categories" data-toggle="tooltip" data-original-title="uses direct subcategory names"><?=$ptxt_subcats?></a>
		                    					</p>
		                     					<?=$note_category_meta_tag_keyword?>
	                     					</div>
	                     					<div class="help-block"></div>
	                    				</div>                   					
                    				</div>
                    			</div>
                    		</div>

                    		<!-- Manufacturer  -->
            				<div class="panel panel-primary">
                    			<div class="panel-heading"><h3><i class="fa fa-chevron-circle-up"></i><?=$txt_manufacturers_seo_settings?></h3></div>
                    			<div class="panel-body seo-setting-form">
                    				<div class="form-group">
                    					<label><?=$js_seo_keyword?></label>
                    					<div class="row">
                    						<div class="col-md-9">
												<div class="input-group">
												    <input data-spliter=" " type="text" placeholder="<?=$phr_manufacturer_seo_keyword?>" value="<?=$seo_pp_manufacturers_seo_url?>" name="manufacturers_seo_url" id="manufacturers_seo_url" class="form-control">    
												    <div class="input-group-btn">
												        <button id="manufacturers_seo_url_gen" type="button" data="manufacturers_seo_url" class="generate btn btn-primary" data-toggle="tooltip" data-original-title="<?=$tip_manufacturers_seo_keyword_generate?>"><?=$txt_generate?></button>
												        <a id="manufacturers_seo_url_clr" href="#" data="manufacturers_seo_url" class="clear btn btn-danger" data-toggle="tooltip" data-original-title="<?=$tip_manufacturers_seo_keyword_clear?>"><?=$txt_clear;?></a>
												    </div>
												</div>
                    						</div>
                    						<div class="col-md-3">
                    							<div class="radio auto_settings">
	                    							<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_on?>">
														<input type="radio" value="1" id="auto_manufacturers_seo_url_1" name="auto_manufacturers_seo_url" /> <?=$txt_auto_on?>
													</label>
													<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_off?>">
														<input type="radio" value="0" id="auto_manufacturers_seo_url_0" name="auto_manufacturers_seo_url" /> <?=$txt_auto_off;?>
													</label>  
												</div>    
											</div>
                    					</div> 
                    					<div class="allowed-tags">
	                     					<div class="well well-sm">
		                     					<p>
		                     					<a data="id"><?=$ptxt_id?></a>
		                     					<a data="name"><?=$ptxt_name;?></a>
		                    					</p>
		                     					<?=$note_manufacturer_seo_keyword?>
	                     					</div>
	                     					<div class="help-block"></div>
	                    				</div>                 					
                    				</div>
                    			</div>
                    		</div>

                    		<!-- Information  -->
            				<div class="panel panel-primary">
                    			<div class="panel-heading"><h3><i class="fa fa-chevron-circle-up"></i><?=$txt_information_seo_settings?></h3></div>
                    			<div class="panel-body seo-setting-form">
                    				<div class="form-group">
                    					<label><?=$txt_seo_keyword?></label>
                    					<div class="row">
                    						<div class="col-md-9">
												<div class="input-group">
												    <input data-spliter=" " type="text" placeholder="<?=$phr_information_seo_keyword?>" value="<?=$seo_pp_information_seo_url?>" name="information_seo_url" id="information_seo_url" class="form-control">    
												    <div class="input-group-btn">
												        <button id="information_seo_url_gen" type="button" data="information_seo_url" class="generate btn btn-primary" data-toggle="tooltip" data-original-title="<?=$tip_information_seo_keyword_generate?>"><?=$txt_generate?></button>
												        <a id="information_seo_url_clr" href="#" data="information_seo_url" class="clear btn btn-danger" data-toggle="tooltip" data-original-title="<?=$tip_information_seo_keyword_clear?>"><?=$txt_clear;?></a>
												    </div>
												</div>
                    						</div>
                    						<div class="col-md-3">
                    							<div class="radio auto_settings">
	                    							<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_on?>">
														<input type="radio" value="1" id="auto_information_seo_url_1" name="auto_information_seo_url" /> <?=$txt_auto_on?>
													</label>
													<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_off?>">
														<input type="radio" value="0" id="auto_information_seo_url_0" name="auto_information_seo_url" /> <?=$txt_auto_off;?>
													</label>  
												</div>    
											</div>
                    					</div>   
                    					<div class="allowed-tags">
	                     					<div class="well well-sm">
		                     					<p>
		                     					<a data="id"><?=$ptxt_id?></a>
		                     					<a data="title"><?=$ptxt_title?></a>
		                    					</p>
		                     					<?=$note_information_seo_keyword?>
	                     					</div>
	                     					<div class="help-block"></div>
	                    				</div>                					
                    				</div>

                    				<div class="form-group">
                    					<label><?=$txt_meta_title?></label>
                    					<div class="row">
                    						<div class="col-md-9">
												<div class="input-group">
												    <input data-spliter=" " type="text" placeholder="<?=$phr_information_meta_title?>" value="<?=$seo_pp_information_meta_title?>" name="information_meta_title" id="information_meta_title" class="form-control">    
												    <div class="input-group-btn">
												        <button id="information_meta_title_gen" type="button" data="information_meta_title" class="generate btn btn-primary" data-toggle="tooltip" data-original-title="<?=$tip_information_meta_title_generate?>"><?=$txt_generate?></button>
												        <a id="information_meta_title_clr" href="#" data="information_meta_title" class="clear btn btn-danger" data-toggle="tooltip" data-original-title="<?=$tip_information_meta_title_clear?>"><?=$txt_clear;?></a>
												    </div>
												</div>
                    						</div>
                    						<div class="col-md-3">
                    							<div class="radio auto_settings">
	                    							<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_on?>">
														<input type="radio" value="1" id="auto_information_meta_title_1" name="auto_information_meta_title" /> <?=$txt_auto_on?>
													</label>
													<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_off?>">
														<input type="radio" value="0" id="auto_information_meta_title_0" name="auto_information_meta_title" /> <?=$txt_auto_off;?>
													</label>  
												</div>    
											</div>
                    					</div>  
                    					<div class="allowed-tags">
	                     					<div class="well well-sm">
		                     					<p>
		                     					<a data="title"><?=$ptxt_title?></a>
		                    					</p>
		                     					<?=$note_information_meta_title?>
	                     					</div>
	                     					<div class="help-block"></div>
	                    				</div>                					
                    				</div>

                    				<div class="form-group">
                    					<label><?=$txt_meta_description?></label>
                    					<div class="row">
                    						<div class="col-md-9">
												<div class="input-group">
												    <input data-spliter=" " type="text" placeholder="<?=$phr_information_meta_tag_description?>" value="<?=$seo_pp_information_meta_desc?>" name="information_meta_desc" id="information_meta_desc" class="form-control">    
												    <div class="input-group-btn">
												        <button id="information_meta_desc_gen" type="button" data="information_meta_desc" class="generate btn btn-primary" data-toggle="tooltip" data-original-title="<?=$tip_information_meta_desc_generate?>"><?=$txt_generate?></button>
												        <a id="information_meta_desc_clr" href="#" data="information_meta_desc" class="clear btn btn-danger" data-toggle="tooltip" data-original-title="<?=$tip_information_meta_desc_clear?>"><?=$txt_clear;?></a>
												    </div>
												</div>
                    						</div>
                    						<div class="col-md-3">
                    							<div class="radio auto_settings">
	                    							<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_on?>">
														<input type="radio" value="1" id="auto_information_meta_desc_1" name="auto_information_meta_desc" /> <?=$txt_auto_on?>
													</label>
													<label class="checkbox-inline" data-toggle="tooltip" data-original-title="<?=$tip_auto_off?>">
														<input type="radio" value="0" id="auto_information_meta_desc_0" name="auto_information_meta_desc" /> <?=$txt_auto_off;?>
													</label>  
												</div>    
											</div>
                    					</div>  
                    					<div class="allowed-tags">
	                     					<div class="well well-sm">
		                     					<p>
		                     					<a data="title"><?=$ptxt_title?></a>
		                     					<a data="description" data-toggle="tooltip" data-original-title="<?=$tip_tag_meta_desc?>"><?=$ptxt_desc?></a>
		                    					</p>
		                     					<?=$note_information_meta_tag_description?>
	                     					</div>
	                     					<div class="help-block"></div>
	                    				</div>                					
                    				</div>
                    			</div>
                    		</div>
                    	</div>

                    	<div class="tab-pane" id="product_settings">
                    		<ul class="nav nav-tabs products-lang-tabs" role="tablist">
                    			<?php foreach ($languages as $language) { ?>
                    				<li><a data-lang="<?=$language['language_id'];?>" data-url="index.php?route=seo_power_pack/products&token=<?=$token?>&language_id=<?=$language['language_id'];?>" href="#pro_lang_<?=$language['language_id'];?>" role="tab" data-toggle="tab">
                    				<img title="<?=$language['name'];?>" src="view/image/flags/<?=$language['image'];?>">
                    				<?=$language['name'];?>
                    				</a></li>
                    			<?php } ?>	
		                    </ul>
		                    <div class="tab-content">
		                    	<?php foreach ($languages as $language) { ?>
                    				<div id="pro_lang_<?=$language['language_id'];?>" class="tab-pane list-container"></div>
                    			<?php } ?>	
                    		</div>
                    	</div>

                    	<div class="tab-pane" id="categories_settings">
                    		<ul class="nav nav-tabs categories-lang-tabs" role="tablist">
                    			<?php foreach ($languages as $language) { ?>
                    				<li><a data-lang="<?=$language['language_id'];?>" data-url="index.php?route=seo_power_pack/categories&token=<?=$token?>&language_id=<?=$language['language_id'];?>" href="#cat_lang_<?=$language['language_id'];?>" role="tab" data-toggle="tab">
                    				<img title="<?=$language['name'];?>" src="view/image/flags/<?=$language['image'];?>">
                    				<?=$language['name'];?>
                    				</a></li>
                    			<?php } ?>	
		                    </ul>
		                    <div class="tab-content">
		                    	<?php foreach ($languages as $language) { ?>
                    				<div id="cat_lang_<?=$language['language_id'];?>" class="tab-pane list-container"></div>
                    			<?php } ?>	
                    		</div>
                    	</div>

                    	<div class="tab-pane" id="manufacturer_settings">
                    		<ul class="nav nav-tabs manufacturers-lang-tabs" role="tablist">
                    			<li><a data-lang="0" data-url="index.php?route=seo_power_pack/manufacturers&token=<?=$token?>&language_id=0" href="#man_lang_0" role="tab" data-toggle="tab"><?=$txt_list?></a></li>
		                    </ul>
		                    <div class="tab-content">
                   				<div id="man_lang_0" class="tab-pane list-container"></div>
                    		</div>
                    	</div>

                    	<div class="tab-pane" id="information_settings">
                    		<ul class="nav nav-tabs informations-lang-tabs" role="tablist">
                    			<?php foreach ($languages as $language) { ?>
                    				<li><a data-lang="<?=$language['language_id'];?>" data-url="index.php?route=seo_power_pack/informations&token=<?=$token?>&language_id=<?=$language['language_id'];?>" href="#info_lang_<?=$language['language_id'];?>" role="tab" data-toggle="tab">
                    				<img title="<?=$language['name'];?>" src="view/image/flags/<?=$language['image'];?>">
                    				<?=$language['name'];?>
                    				</a></li>
                    			<?php } ?>	
		                    </ul>
		                    <div class="tab-content">
		                    	<?php foreach ($languages as $language) { ?>
                    				<div id="info_lang_<?=$language['language_id'];?>" class="tab-pane list-container"></div>
                    			<?php } ?>	
                    		</div>
                    	</div>

                    	<div class="tab-pane" id="duplicate_urls_settings">
							<ul class="nav nav-tabs durls-lang-tabs" role="tablist">
								<li><a data-lang="0" data-url="index.php?route=seo_power_pack/duplicate_urls&token=<?=$token?>&language_id=0" href="#durls_lang_0" role="tab" data-toggle="tab"><?=$txt_no_language?></a></li>
                    			<?php foreach ($languages as $language) { ?>
                    				<li><a data-lang="<?=$language['language_id'];?>" data-url="index.php?route=seo_power_pack/duplicate_urls&token=<?=$token?>&language_id=<?=$language['language_id'];?>" href="#durls_lang_<?=$language['language_id'];?>" role="tab" data-toggle="tab">
                    				<img title="<?=$language['name'];?>" src="view/image/flags/<?=$language['image'];?>">
                    				<?=$language['name'];?>
                    				</a></li>
                    			<?php } ?>	
		                    </ul>
		                    <div class="tab-content">
		                    	<div id="durls_lang_0" class="tab-pane list-container"></div>
		                    	<?php foreach ($languages as $language) { ?>
                    				<div id="durls_lang_<?=$language['language_id'];?>" class="tab-pane list-container"></div>
                    			<?php } ?>	
                    		</div>
                    	</div>
                    	<div class="tab-pane" id="custom_urls_settings">
                    		<!-- Add New Seo URL -->
                    		<div id="addnewseourl" class="form-vertical">
                    			<div class="panel panel-default">
                    				<div class="panel-heading">
                    				<?=$txt_add_new_seo_url?>
                    				</div>
                    				<div class="panel-body" style="display:none;">
										<div class="form-group">
		                    				<label><?=$txt_route?></label>
		                    				<input class="form-control" type="text" id="new_route" name="new_route" value="" placeholder="account/login" />
		                    			</div>
										<?php foreach ($languages as $language) { ?>
	                    				<div class="form-group">
		                    				<label><img title="<?=$language['name'];?>" src="view/image/flags/<?=$language['image'];?>">
	                    				<?=$language['name'];?> | <?=$txt_seo_keyword_need_2b_unique?></label>
		                    				<input data-lid="<?=$language['language_id'];?>" class="form-control i-seo_keywords" placeholder="login" type="text" name="new_seo_keyword[<?=$language['language_id'];?>]" value="" />
		                    			</div>
	                    				<?php } ?>	

		                    			<a href="#" class="btn btn-primary" onclick="saveNewSeoUrl(); return false;"><?=$txt_save?></a>
		                    			<a href="#" class="btn btn-default" onclick="$('#addnewseourl .panel-body').hide(); return false;"><?=$txt_cancel?></a>
                    				</div>
                    			</div>
                    		</div>
                    		<br />
                    		<script type="text/javascript">
                    		function saveNewSeoUrl(){
                    			var validation = true;
                    			if($.trim($('#new_route').val()).length < 1){
                    				alert('<?=$js_route_cannot_be_empty?>');
                    				$('#new_route').focus();
                    				return false;
                    			}

                    			$('.i-seo_keywords').each(function(){
									if($.trim($(this).val()).length < 1){
	                    				alert('<?=$js_seo_keyword_cannot_be_empty?>');
	                    				$(this).focus();
	                    				validation = false;
	                    				return false;
	                    			}
                    			});

                    			if(validation){
                    				$('#addnewseourl a').prop('disabled', true);
							        $.ajax({
										type:'post',
										cache:false,
										async: true,
										url:'index.php?route=seo_power_pack/custom_urls/addnew&token=<?=$token?>',
										data:$('#addnewseourl input').serialize(),
										dataType: 'json',
										success:function(response){
											if(response.success){
												$('#new_route').val('');
												$('.i-seo_keywords').val('');
												$('#new_route').focus();
												$('#addnewseourl .panel-body').prepend('<div class="alert alert-success"><?=$js_successfully_added?></a>');
												setTimeout(function(){
													$('#addnewseourl .panel-body .alert').remove();
												},5000);
											} else {
												$.notify(response.error,"warn");
												$('#new_route').focus();
											}

											$('#addnewseourl a').prop('disabled', false);
										}
									});	                    				
                    			}

                    		}
                    		</script>
                    		<!-- Add New Seo URL -->
							<ul class="nav nav-tabs curls-lang-tabs" role="tablist">
								<li><a data-lang="0" data-url="index.php?route=seo_power_pack/custom_urls&token=<?=$token?>&language_id=0" href="#curls_lang_0" role="tab" data-toggle="tab"><?=$txt_no_language?></a></li>
                    			<?php foreach ($languages as $language) { ?>
                    				<li><a data-lang="<?=$language['language_id'];?>" data-url="index.php?route=seo_power_pack/custom_urls&token=<?=$token?>&language_id=<?=$language['language_id'];?>" href="#curls_lang_<?=$language['language_id'];?>" role="tab" data-toggle="tab">
                    				<img title="<?=$language['name'];?>" src="view/image/flags/<?=$language['image'];?>">
                    				<?=$language['name'];?>
                    				</a></li>
                    			<?php } ?>	
		                    </ul>
		                    <div class="tab-content">
		                    	<div id="curls_lang_0" class="tab-pane list-container"></div>
		                    	<?php foreach ($languages as $language) { ?>
                    				<div id="curls_lang_<?=$language['language_id'];?>" class="tab-pane list-container"></div>
                    			<?php } ?>	
                    		</div>
                    	</div>
                    	<div class="tab-pane" id="about_us">&nbsp;</div>
                        <div class="tab-pane" id="documentation">&nbsp;</div>
                        <div class="tab-pane" id="store_seo">
                        	<h3 class="h3heading"><?=$txt_store_seo_settings?></h3>
                        	<p class="alert alert-info" style="margin-top:-20px;"><?=$txt_store_note?></p>
							<ul class="nav nav-tabs store-lang-tabs" role="tablist">
                    			<?php foreach ($languages as $language) { ?>
                    				<li><a data-lang="<?=$language['language_id'];?>" data-url="index.php?route=seo_power_pack/advanced&rd=store&token=<?=$token?>&language_id=<?=$language['language_id'];?>" href="#store_lang_<?=$language['language_id'];?>" role="tab" data-toggle="tab">
                    				<img title="<?=$language['name'];?>" src="view/image/flags/<?=$language['image'];?>">
                    				<?=$language['name'];?>
                    				</a></li>
                    			<?php } ?>	
		                    </ul>
		                    <div class="tab-content">
		                    	<?php 
		                    	foreach ($languages as $language) { ?>
                    				<div id="store_lang_<?=$language['language_id'];?>" class="tab-pane list-container">
										<div class="form-group">
											<label><?=$txt_meta_title?></label>
											<input type="text" class="form-control" value="" id="store_<?=$language['language_id'];?>_mt" name="store[<?=$language['language_id'];?>][mt]" />
 										</div>
										<div class="row">
 											<div class="col-sm-8">
		 										<div class="form-group">
													<label><?=$txt_meta_description?></label>
													<input type="text" class="form-control" value="" id="store_<?=$language['language_id'];?>_md" name="store[<?=$language['language_id'];?>][md]" />
												</div>		
 											</div>
 											<div class="col-sm-4">
 												<label>&nbsp;</label>
 												<div class="alert alert-info"><?=$tip_tag_meta_desc?></div>	
 											</div>
 										</div>
 										<div class="form-group">
											<label><?=$txt_meta_keyword?></label>
											<input type="text" class="form-control" value="" id="store_<?=$language['language_id'];?>_mk" name="store[<?=$language['language_id'];?>][mk]" />
										</div>
                    				</div>
                    			<?php } ?>	
                    			<div class="well well-sm">
                    				<a id="save-store-settings" href="#" class="btn btn-primary" onclick="return false;"><?=$txt_save?></a>
                    			</div>
                    		</div>

							<script type="text/javascript">
								$(function(){
									<?php 
									if(is_array($seo_pp_store_settings) && !empty($seo_pp_store_settings)){ 
										foreach($seo_pp_store_settings as $language_id => $seo_pp_store_setting){
									?>
										$('#store_<?=$language_id?>_mt').val('<?=str_replace("'","\'",html_entity_decode($seo_pp_store_setting['mt']))?>');
										$('#store_<?=$language_id?>_mk').val('<?=str_replace("'","\'",html_entity_decode($seo_pp_store_setting['mk']))?>');
										$('#store_<?=$language_id?>_md').val('<?=str_replace("'","\'",html_entity_decode($seo_pp_store_setting['md']))?>');
									<?php 
										}
									} 
									?>
									$('#store_seo .nav-tabs a:first').tab('show');
									$('#save-store-settings').bind('click', function(){
										
										if($(this).text() != '<?=$txt_processing?>'){
											$(this).text('<?=$txt_processing?>');
											$.ajax({
												type:'post',
												cache:false,
												async: true,
												url:'index.php?route=seo_power_pack/advanced/save_setting&dkey=store&data=store_settings&token=<?=$token?>',
												data: $('#store_seo .tab-content :input').serialize(),
												dataType: 'json',
												success:function(response){
													if(typeof(response.success) !='undefined'){
														$.notify('<?=$js_saved_successfully?>','success');
													} else {
														$.notify('<?=$js_save_failed?>','warn');
													}

													$('#save-store-settings').text('<?=$txt_save?>');
												}
											});		
										}
										
									});
								});
							</script>

                        </div>
                        <div class="tab-pane" id="social_seo">
                        	<h3 class="h3heading"><?=$txt_social_settings?></h3>

                        	<div class="row">
                        		<div class="col-sm-4">
		                        	<h3><i class="fa fa-facebook"></i> <?=$txt_facebook?></h3>
		                        	<div class="form-group">
		                        		 <div class="checkbox">
		                        		 	<label><input type="checkbox" id="social_facebook" name="social[facebook]" value="1" /> <b><?=$txt_enable_facebook_open_graph?></b></label>
		                        		 </div>
		                        	</div>	
                        		</div>
                        		<div class="col-sm-4">
		                        	<h3><i class="fa fa-twitter"></i> <?=$txt_twitter?></h3>
		                    		<div class="form-group">
		                        		 <div class="checkbox">
		                        		 	<label><input type="checkbox" id="social_twitter" name="social[twitter]" value="1" /> <b><?=$txt_enable_twitter_card?></b></label>
		                        		 </div>
		                        	</div>
		                			<div class="form-group">
										<label><?=$txt_twitter_content_creator?></label>
										<input placeholder="<?=$txt_twitter_content_creator_ph?>" type="text" class="form-control" value="" id="social_twitter_card_cc" name="social[twitter_card_cc]" />
									</div>
									<div class="form-group">
										<label><?=$txt_twitter_card_footer?></label>
										<input placeholder="<?=$txt_twitter_card_footer_ph?>" type="text" class="form-control" value="" id="social_twitter_card_fs" name="social[twitter_card_fs]" />
									</div>	
                        		</div>
                        		<div class="col-sm-4">
		                        	<h3><i class="fa fa-google-plus"></i> <?=$txt_gplus?></h3>
		                        	<div class="form-group">
		                        		 <div class="checkbox">
		                        		 	<label><input id="social_gplus" type="checkbox" name="social[gplus]" value="1" /> <b><?=$txt_enable_google_plus_meta_data?></b></label>
		                        		 </div>
		                        	</div>	
                        		</div>
                        	</div>

                        	<div class="well well-sm">
                    			<a id="save-social-settings" href="#" class="btn btn-primary" onclick="return false;"><?=$txt_save?></a>
                    		</div>

                    		<script type="text/javascript">
                    		$(function(){

                    			<?php 
									if(is_array($seo_pp_social_settings) && !empty($seo_pp_social_settings)){ 
										foreach($seo_pp_social_settings as $socialkey => $seo_pp_social_setting){
									?>
										if($('#social_<?=$socialkey?>').attr('type') == 'checkbox'){
											$('#social_<?=$socialkey?>').prop('checked', true);
										} else {
											$('#social_<?=$socialkey?>').val('<?=str_replace("'","\'",html_entity_decode($seo_pp_social_setting))?>');
										}
								<?php 
									}
								} 
								?>

                    			$('#save-social-settings').bind('click', function(){
									if($(this).text() != '<?=$txt_processing?>'){
										$(this).text('<?=$txt_processing?>');
										$.ajax({
											type:'post',
											cache:false,
											async: true,
											url:'index.php?route=seo_power_pack/advanced/save_setting&dkey=social&data=social_settings&token=<?=$token?>',
											data: $('#social_seo :input').serialize(),
											dataType: 'json',
											success:function(response){
												if(typeof(response.success) !='undefined'){
													$.notify('<?=$js_saved_successfully?>','success');
												} else {
													$.notify('<?=$js_save_failed?>','warn');
												}

												$('#save-social-settings').text('<?=$txt_save?>');
											}
										});		
									}
								});
							});
                    		</script>
                        </div>
                        <div class="tab-pane" id="webmaster-tool">
                        	<h3 class="h3heading"><?=$txt_webmaster_tool_settings?></h3>

                        	<div class="row">
                        		<div class="col-sm-6">
	                        		<div class="form-group">
										<label><?=$txt_google_site_verification_code?></label>
										<input type="text" class="form-control" value="<?=$seo_pp_webmaster_tools?>" id="webmaster_tools" name="webmaster_tools" />
									</div>
									<div class="well well-sm">
		                    			<a id="save-webmaster_tools-settings" href="#" class="btn btn-primary" onclick="return false;"><?=$txt_save?></a>
		                    		</div>
                        		</div>
                        		<div class="col-sm-6">
                        			<img src="view/image/seo-power-pack/web-master-tool-hint.jpg" alt="webmaster-tool" class="img-responsive" />
                        		</div>
                        	</div>

                    		<script type="text/javascript">
                    		$(function(){
                    			$('#save-webmaster_tools-settings').bind('click', function(){
									if($(this).text() != '<?=$txt_processing?>'){
										$(this).text('<?=$txt_processing?>');
										$.ajax({
											type:'post',
											cache:false,
											async: true,
											url:'index.php?route=seo_power_pack/advanced/save_setting&dkey=webmaster_tools&data=webmaster_tools&token=<?=$token?>',
											data: $('#webmaster-tool :input').serialize(),
											dataType: 'json',
											success:function(response){
												if(typeof(response.success) !='undefined'){
													$.notify('<?=$js_saved_successfully?>','success');
												} else {
													$.notify('<?=$js_save_failed?>','warn');
												}

												$('#save-webmaster_tools-settings').text('<?=$txt_save?>');
											}
										});		
									}
								});
							});
                    		</script>
                        </div>
                        <div class="tab-pane" id="google-analytics">
                        	<h3 class="h3heading"><?=$txt_google_analytics?></h3>
							
							<div class="row">
                        		<div class="col-sm-6">
	                        		<div class="form-group">
										<label><?=$txt_google_analytics_code?></label>
										<textarea rows="10" class="form-control" id="google_analytics_code" name="google_analytics[code]"><?=(isset($seo_pp_google_analytics['code']))?$seo_pp_google_analytics['code']:''?></textarea>
									</div>
									<div class="form-group">
		                        		 <div class="checkbox">
		                        		 	<label><input type="checkbox" id="google_analytics_status" name="google_analytics[status]" value="1" /> <b><?=$txt_enable_google_analytics?></b></label>
		                        		 </div>
		                        	</div>
									<div class="well well-sm">
		                    			<a id="save-google_analytics-settings" href="#" class="btn btn-primary" onclick="return false;"><?=$txt_save?></a>
		                    		</div>
                        		</div>
                        		<div class="col-sm-6">
                        			<img src="view/image/seo-power-pack/google-analystic-help.jpg" alt="webmaster-tool" class="img-responsive" />
                        		</div>
                        	</div>
                    		<script type="text/javascript">
                    		$(function(){
                    			<?php if(isset($seo_pp_google_analytics['status'])){ ?>
                    				$('#google_analytics_status').prop('checked', true);
                    			<?php } ?>

                    			$('#save-google_analytics-settings').bind('click', function(){
									if($(this).text() != '<?=$txt_processing?>'){
										$(this).text('<?=$txt_processing?>');
										$.ajax({
											type:'post',
											cache:false,
											async: true,
											url:'index.php?route=seo_power_pack/advanced/save_setting&dkey=google_analytics&data=google_analytics&token=<?=$token?>',
											data: $('#google-analytics :input').serialize(),
											dataType: 'json',
											success:function(response){
												if(typeof(response.success) !='undefined'){
													$.notify('<?=$js_saved_successfully?>','success');
												} else {
													$.notify('<?=$js_save_failed?>','warn');
												}

												$('#save-google_analytics-settings').text('<?=$txt_save?>');
											}
										});		
									}
								});
							});
                    		</script>
                        </div>
                        <div class="tab-pane" id="sitemaps">
                        	<h3 class="h3heading"><?=$txt_sitemaps?></h3>
                        	<div class="row">
                        		<div class="col-sm-3">
                        			<p>
									<a id="generate-sitemap-btn" href="#" class="btn btn-primary" onclick="return false;"><?=$txt_generate_sitemaps?></a>
									</p>
									<p><?=$txt_sitemaps_note?></p>	
                        		</div>
                        		<div class="col-sm-9">
                        			<div id="sitemap_feeds">&nbsp;</div>
                        		</div>
                        	</div>
							

							<script type="text/javascript">
                    		$(function(){
                    			load_sitemaps();
                    			$('#generate-sitemap-btn').bind('click', function(){
									if($(this).text() != '<?=$txt_processing?>'){
										$(this).text('<?=$txt_processing?>');
										$.ajax({
											type:'get',
											cache:false,
											async: true,
											url:'../index.php?route=seo_power_pack/sitemap/generate_sitemaps&token=<?=$token?>',
											dataType: 'json',
											success:function(response){
												$('#generate-sitemap-btn').text('<?=$txt_generate_sitemaps?>');
												load_sitemaps();
											}
										});		
									}
								});
							});

							function load_sitemaps(){
								$.ajax({
									type:'get',
									cache:false,
									async: true,
									url:'../index.php?route=seo_power_pack/sitemap/get_all&token=<?=$token?>',
									dataType: 'json',
									success:function(response){
										var sitemap_html = '<table class="table table-hover table-striped">';
										for(var i=0;i<response.length;i++){
											sitemap_html += '<tr><td><a href="'+response[i].url+'" target="_blank">'+response[i].url+'</a></td></tr>';
										}
										sitemap_html += '</table>';

										$('#sitemap_feeds').html(sitemap_html);
									}
								});		
							}
                    		</script>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</form>
</div>

<!-- Modal -->
<div class="modal fade" id="editCustomUrl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?=$txt_close?></span></button>
        <h4 class="modal-title" id="myModalLabel"><?=$txt_edit_custom_url?></h4>
      </div>
      <div class="modal-body">
      <form id="editCustomUrlForm" method="post" onsubmit="return false;">
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=$txt_close?></button>
        <button type="button" class="btn btn-primary" onclick="updateCustomUrl($(this)); return false;"><?=$txt_save_changes?></button>
      </div>
    </div>
  </div>
</div>
<?php /* Tab Retain On Refresh */ ?>
<script type="text/javascript">
$(document).ready(function() {
	$('.seo-pp-tabs a').bind('click',function(){
		location.hash = $(this).attr('href').substr(1);
	});

    if (location.hash !== '') $('a[href="' + location.hash + '"]').tab('show');
    return $('a[data-toggle="tab"]').on('shown', function(e) {
      return location.hash = $(e.target).attr('href').substr(1);
    });
});
</script>
<?php /* Tab Retain On Refresh */ ?>

<script type="text/javascript">
$(function(){
	$('.auto_settings input[type="radio"]').bind('click', function(){
		$.ajax({
			type:'get',
			cache:false,
			async: true,
			url:'index.php?route=seo_power_pack/settings/auto_settings&token=<?=$token?>&auto_field='+$(this).attr('name')+'&auto_field_value='+$(this).val(),
			dataType: 'json',
			success:function(response){
				ele.find('.fa:first').remove();
				renderByType('custom_urls', response);
			}
		});	
	});

	$('#auto_information_meta_title_<?=intval($seo_pp_auto_information_meta_title)?>').prop('checked', true);
	$('#auto_information_meta_desc_<?=intval($seo_pp_auto_information_meta_desc)?>').prop('checked', true);
	$('#auto_information_seo_url_<?=intval($seo_pp_auto_information_seo_url)?>').prop('checked', true);

	$('#auto_manufacturers_seo_url_<?=intval($seo_pp_auto_manufacturers_seo_url)?>').prop('checked', true);

	$('#auto_category_meta_tag_keywords_<?=intval($seo_pp_auto_category_meta_tag_keywords)?>').prop('checked', true);
	$('#auto_category_meta_tag_description_<?=intval($seo_pp_auto_category_meta_tag_description)?>').prop('checked', true);
	$('#auto_category_meta_tag_title_<?=intval($seo_pp_auto_category_meta_tag_title)?>').prop('checked', true);
	$('#auto_category_seo_url_<?=intval($seo_pp_auto_category_seo_url)?>').prop('checked', true);

	$('#auto_product_relpro_<?=intval($seo_pp_auto_product_relpro)?>').prop('checked', true);
	$('#auto_product_seo_url_<?=intval($seo_pp_auto_product_seo_url)?>').prop('checked', true);
	$('#auto_product_tags_<?=intval($seo_pp_auto_product_tags)?>').prop('checked', true);
	$('#auto_product_image_name_pattern_<?=intval($seo_pp_auto_product_image_name_pattern)?>').prop('checked', true);
	$('#auto_product_meta_description_<?=intval($seo_pp_auto_product_meta_description)?>').prop('checked', true);
	$('#auto_product_meta_keyword_<?=intval($seo_pp_auto_product_meta_keyword)?>').prop('checked', true);
	$('#auto_product_meta_title_<?=intval($seo_pp_auto_product_meta_title)?>').prop('checked', true);

	$('#auto_translate_seo_url_<?=intval($seo_pp_auto_translate_seo_url)?>').prop('checked', true);

});

function addBadge(href_val, rec_total){
	if($('a[href=#'+href_val+']:first .badge').length){
		$('a[href=#'+href_val+']:first .badge').text(rec_total);
	} else {
		$('a[href=#'+href_val+']:first').append(' <span class="badge">'+rec_total+'</span>');
	}
}

/* News and Updates */
$(function(){
	$('a#news_and_updates').bind('click', function(){
		$('#about_us').html('<iframe style="border: 0 none;height: 800px;width: 100%;" src="http://webby-blog.com/extension-news-and-update.html?'+(new Date().getTime())+'"></iframe>');
	});
        
    	$('a#help_tab').bind('click', function(){
		$('#documentation').html('<iframe style="border: 0 none;height: 800px;width: 100%;" src="http://webby-blog.com/seo-power-pack-update.html?'+(new Date().getTime())+'"></iframe>');
	});
});
/* News and Updates */
/* Custom Url Listing */
$(function(){
	$('.curls-lang-tabs a').bind('dblclick', function(){
		var ele = $(this);
		if(!(ele.html().indexOf('<i class="fa fa-spinner fa-spin"></i>') >-1)){
			ele.prepend('<i class="fa fa-spinner fa-spin"></i>');
		}
		var paging_url = $(this).data('url');
		$.ajax({
			type:'post',
			cache:false,
			async: true,
			url:paging_url+'&tab_container='+$(this).attr('href').replace('#',''),
			dataType: 'json',
			success:function(response){
				ele.find('.fa:first').remove();
				renderByType('custom_urls', response);
			}
		});			
	});	
	$('.curls-lang-tabs a').bind('click', function(){
		if(typeof($(this).data('url'))!='undefined' && $.trim($($(this).attr('href')).html()).length == 0){
			var ele = $(this);
			if(!(ele.html().indexOf('<i class="fa fa-spinner fa-spin"></i>') >-1)){
				ele.prepend('<i class="fa fa-spinner fa-spin"></i>');
			}
			var paging_url = $(this).data('url');
			$.ajax({
				type:'post',
				cache:false,
				async: true,
				url:paging_url+'&tab_container='+$(this).attr('href').replace('#',''),
				dataType: 'json',
				success:function(response){
					ele.find('.fa:first').remove();
					renderByType('custom_urls', response);
				}
			});			
		}
	});	

	$('.curls-lang-tabs a:first').trigger('click');
});

// Makes tooltips work on ajax generated content
$(document).ajaxStart(function() {
	$('[data-toggle=\'tooltip\']').tooltip('hide');
});

function editSEOUrlAlias(url_alias_id){
	$('#editCustomUrlForm').html('<h1><i class="fa fa-spinner fa-spin"></i> <?=$txt_loading?></h1>');
	$.ajax({
		type:'post',
		cache:false,
		async:true,
		url:'index.php?route=seo_power_pack/custom_urls/get_ua&token=<?=$token?>&url_alias_id='+url_alias_id,
		dataType: 'json',
		success:function(response){
			createEditForm(response);
		}
	});			
}

function updateCustomUrl(ele){
	if(!(ele.find('.fa').length>0)){
		ele.prepend('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
			type:'post',
			cache:false,
			async:true,
			url:'index.php?route=seo_power_pack/custom_urls/update_ua&token=<?=$token?>',
			dataType: 'json',
			data:$( "#editCustomUrlForm" ).serialize(),
			success:function(response){
				ele.find('.fa').remove();
				$('#editCustomUrl').modal('toggle');
				$('div#custom_urls_settings button.filter-list').each(function(){
					$(this).trigger('click');
				});
				$.notify('<?=$js_successfully_updated?>',"success");
			}
		});			
	}
}

function createEditForm(response){
	$('#editCustomUrlForm').html('<table class="table table-striped table-hover"><thead><tr><th>Query</th><th><?=$js_seo_keyword?></th></tr></thead><tbody><tr><td>'+response.url_alias.query+'</td><td>'+response.url_alias.keyword+'</td></tr></tbody></table>');
	$('#editCustomUrlForm').append('<input name="uef_url_alias_id" id="uef_url_alias_id" type="hidden" class="form-control" value="'+response.url_alias.url_alias_id+'" /></div>');
	$.each(response.languages, function(k,v){
		$('#editCustomUrlForm').append('<div class="form-group"><label><?=$js_enter_keyword_in?> <img title="'+v.name+'" src="view/image/flags/'+v.image+'"> '+v.name+'</label><input id="uef_url_alias_lang_'+v.language_id+'" name="uef_url_alias_lang_'+v.language_id+'" type="text" class="form-control" value="" /></div>');
	});

	$.each(response.records, function(k,v){
		$('#uef_url_alias_lang_'+k).val(v.keyword);
	});
}

function renderCustomUrlsTable(response, tab_container, lang_id){
	addBadge(response.tab_container, response.total);
	if(response.custom_urls.length > 0){
		var finput_class = ' type="text" class="form-control input-sm finput" ';

		html = '<div class="table-responsive"><table class="table table-hover table-striped table-bordered">';
		html+= '	<thead>';
		html+= '		<tr>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="ua.query"><?=$js_url_params?></th>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="ua.keyword"><?=$js_keyword_or_seo_keyword?></th>';
		html+= '			<th nowrap="nowrap">Action</th>';
		html+= '		</tr>';
		html+= '		<tr>';
		html+= '			<th><input value="'+response.filter_params+'" id="filter_params-'+lang_id+'" '+finput_class+' /></th>';
		html+= '			<th><input value="'+response.filter_keyword+'" id="filter_keyword-'+lang_id+'" '+finput_class+' /></th>';
		html+= '			<th><div class="btn-group filter-btns" role="group"><button class="btn btn-primary btn-sm filter-list" type="button"><?=$js_filter?></button><button class="btn btn-default btn-sm filter-list-clear" type="button"><?=$js_clear_or_refresh?></button></div></th>';
		html+= '		</tr>';
		html+= '	</thead>';
		html+= '	<tbody id="curls-items-'+lang_id+'">';
		html+= '	</tbody>';
		html+= '	<tfoot>';
		html+= '		<tr>';
		html+= '			<th colspan="5"><div id="curls-paging-'+lang_id+'" class="index-pagination"></div></th>';
		html+= '		</tr>';
		html+= '	</tfoot>';
		html+= '</table></div>';

		tab_container.html(html);

		$.each(response.custom_urls, function(k,v){
			html= '<tr id="curls-'+v.url_alias_id+'">';
			html+= '	<td data="dua_query" data-input="text">'+v.query+'</td>';
			html+= '	<td class="inplace_edit" data="cua_keyword" data-input="text">'+v.keyword+'</td>';
			html+= '	<td><a href="#" onclick="editSEOUrlAlias('+v.url_alias_id+'); return false;" data-toggle="modal" data-target="#editCustomUrl"><i class="fa fa-edit"></i> <?=$js_edit?></a>&nbsp;|&nbsp;<a href="#" class="text-danger" onclick="deleteSEOUrlAlias($(this),'+v.url_alias_id+'); return false;"><i class="fa fa-trash"></i> <?=$js_delete?></a></td>';
			html+= '</tr>';
			$('#curls-items-'+lang_id).append(html);
		});


		$('#curls-items-'+lang_id+' .inplace_edit').bind('click', function(){
			var input_name = $(this).attr('data')+$(this).closest('.list-container').attr('id').replace('curls_lang_','-')+$(this).closest('tr').attr('id');
			
			if($('#'+input_name).length == 0){

				var text = $(this).text().replace('"','');

				if($(this).data('input') == 'text'){
					$(this).html('<input type="text" class="form-control input-sm" id="'+input_name+'" name="'+input_name+'" value="'+text+'" />');
				}

				$('#'+input_name).bind('keypress', function(e){
					var p = e.which;
					if(p==13){
						$(this).unbind('blur');

						var curr_input = $(this);
						var language_id = $(this).closest('.list-container').attr('id').replace('curls_lang_','');
						var field_name = curr_input.closest('td').attr('data');
						var field_value =curr_input.val();
						var url_alias_id = curr_input.closest('tr').attr('id').replace('curls-','');

						inputSaving(curr_input);

						$.ajax({
							type:'post',
							cache:false,
							async: true,
							url:'index.php?route=seo_power_pack/custom_urls/update&token=<?=$token?>&fn='+field_name+'&fv='+field_value+'&language_id='+language_id+'&url_alias_id='+url_alias_id,
							dataType: 'json',
							success:function(response){
								if(typeof(response.success)!='undefined'){
									curr_input.closest('td').text(curr_input.val());	
								}
							}
						});	
					}
				});

				$('#'+input_name).bind('blur', function(){
					var curr_input = $(this);
					var language_id = $(this).closest('.list-container').attr('id').replace('curls_lang_','');
					var field_name = curr_input.closest('td').attr('data');
					var field_value =curr_input.val();
					var url_alias_id = curr_input.closest('tr').attr('id').replace('curls-','');

					inputSaving(curr_input);

					$.ajax({
						type:'post',
						cache:false,
						async: true,
						url:'index.php?route=seo_power_pack/custom_urls/update&token=<?=$token?>&fn='+field_name+'&fv='+field_value+'&language_id='+language_id+'&url_alias_id='+url_alias_id,
						dataType: 'json',
						success:function(response){
							if(typeof(response.success)!='undefined'){
								curr_input.closest('td').text(curr_input.val());	
							}
						}
					});	
				});
			}
		});
	}
}
/* Custom Url Listing */
/* Duplicate Url Listing */
$(function(){
	$('.durls-lang-tabs a').bind('dblclick', function(){
		var ele = $(this);
		if(!(ele.html().indexOf('<i class="fa fa-spinner fa-spin"></i>') >-1)){
			ele.prepend('<i class="fa fa-spinner fa-spin"></i>');
		}
		var paging_url = $(this).data('url');
		$.ajax({
			type:'post',
			cache:false,
			async: true,
			url:paging_url+'&tab_container='+$(this).attr('href').replace('#',''),
			dataType: 'json',
			success:function(response){
				ele.find('.fa:first').remove();
				renderByType('duplicate_urls', response);
			}
		});			
	});	
	$('.durls-lang-tabs a').bind('click', function(){
		if(typeof($(this).data('url'))!='undefined' && $.trim($($(this).attr('href')).html()).length == 0){
			var ele = $(this);
			if(!(ele.html().indexOf('<i class="fa fa-spinner fa-spin"></i>') >-1)){
				ele.prepend('<i class="fa fa-spinner fa-spin"></i>');
			}
			var paging_url = $(this).data('url');
			$.ajax({
				type:'post',
				cache:false,
				async: true,
				url:paging_url+'&tab_container='+$(this).attr('href').replace('#',''),
				dataType: 'json',
				success:function(response){
					ele.find('.fa:first').remove();
					renderByType('duplicate_urls', response);
				}
			});			
		}
	});	
	$('.durls-lang-tabs a:first').trigger('click');
});

function deleteSEOUrlAlias(ele, url_alias_id){
	if(confirm('<?=$js_are_you_sure_you_want_to_delete?>')){
		ele.closest('tr').fadeOut('slow');
		$.ajax({
			type:'post',
			cache:false,
			async: true,
			url:'index.php?route=seo_power_pack/duplicate_urls/delete&token=<?=$token?>&url_alias_id='+url_alias_id,
			dataType: 'json',
			success:function(response){
				if(typeof(response.success)!='undefined'){
					var href_val = ele.closest('div.list-container').attr('id');
					var badge_ele = $('a[href=#'+href_val+']:first span.badge');

					if(badge_ele.length){
						badge_ele.text(parseInt(badge_ele.text(), 10)-1);
					}
					ele.closest('tr').remove();

					if($('#'+href_val).closest('div#duplicate_urls_settings').length){
						removeNonDuplicatesRowFrom('#'+href_val, badge_ele);
					}
					$.notify('<?=$js_deleted_successfully?>', "success");
				} else {
					ele.closest('tr').fadeIn('slow');
				}
			}
		});			
	}
}

function removeNonDuplicatesRowFrom(divEleId, badge_ele){
	$(divEleId+' tr td:first').each(function(){
		var curr_query = $.trim($(this).text());
		var curr_keyword = $.trim($(this).next().text());
		var req = new RegExp(curr_query,"g");
		var qcount = ($(divEleId).text().match(req) || []).length;

		var rek = new RegExp(curr_keyword,"g");
		var kcount = ($(divEleId).text().match(rek) || []).length;

		if(qcount == 1 && kcount==1){
			$(this).closest('tr').remove();
			if(badge_ele.length){
				badge_ele.text(parseInt(badge_ele.text(), 10)-1);
			}
		}
	});
}

function renderDuplicateUrlsTable(response, tab_container, lang_id){
	addBadge(response.tab_container, response.total);
	if(response.duplicate_urls.length > 0){
		var finput_class = ' type="text" class="form-control input-sm finput" ';

		html = '<div class="table-responsive"><table class="table table-hover table-striped table-bordered">';
		html+= '	<thead>';
		html+= '		<tr>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="ua.query"><?=$js_url_params?></th>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="ua.keyword"><?=$js_keyword_or_seo_keyword?></th>';
		html+= '			<th nowrap="nowrap">Action</th>';
		html+= '		</tr>';
		html+= '		<tr>';
		html+= '			<th><input value="'+response.filter_params+'" id="filter_params-'+lang_id+'" '+finput_class+' /></th>';
		html+= '			<th><input value="'+response.filter_keyword+'" id="filter_keyword-'+lang_id+'" '+finput_class+' /></th>';
		html+= '			<th><div class="btn-group filter-btns" role="group"><button class="btn btn-primary btn-sm filter-list" type="button"><?=$js_filter?></button><button class="btn btn-default btn-sm filter-list-clear" type="button"><?=$js_clear_or_refresh?></button></div></th>';
		html+= '		</tr>';
		html+= '	</thead>';
		html+= '	<tbody id="durls-items-'+lang_id+'">';
		html+= '	</tbody>';
		html+= '	<tfoot>';
		html+= '		<tr>';
		html+= '			<th colspan="5"><div id="durls-paging-'+lang_id+'" class="index-pagination"></div></th>';
		html+= '		</tr>';
		html+= '	</tfoot>';
		html+= '</table></div>';

		tab_container.html(html);

		$.each(response.duplicate_urls, function(k,v){
			html= '<tr id="durls-'+v.url_alias_id+'">';
			html+= '	<td data="dua_query" data-input="text">'+v.query+'</td>';
			html+= '	<td class="inplace_edit" data="dua_keyword" data-input="text">'+v.keyword+'</td>';
			html+= '	<td><a href="#" onclick="deleteSEOUrlAlias($(this),'+v.url_alias_id+'); return false;" class="text-danger"><i class="fa fa-trash"></i> <?=$js_delete?></a></td>';
			html+= '</tr>';
			$('#durls-items-'+lang_id).append(html);
		});


		$('#durls-items-'+lang_id+' .inplace_edit').bind('click', function(){
			var input_name = $(this).attr('data')+$(this).closest('.list-container').attr('id').replace('durls_lang_','-')+$(this).closest('tr').attr('id');
			
			if($('#'+input_name).length == 0){

				var text = $(this).text().replace('"','');

				if($(this).data('input') == 'text'){
					$(this).html('<input type="text" class="form-control input-sm" id="'+input_name+'" name="'+input_name+'" value="'+text+'" />');
				}

				$('#'+input_name).bind('keypress', function(e){
					var p = e.which;
					if(p==13){
						$(this).unbind('blur');

						var curr_input = $(this);
						var language_id = $(this).closest('.list-container').attr('id').replace('durls_lang_','');
						var field_name = curr_input.closest('td').attr('data');
						var field_value =curr_input.val();
						var url_alias_id = curr_input.closest('tr').attr('id').replace('durls-','');

						inputSaving(curr_input);

						$.ajax({
							type:'post',
							cache:false,
							async: true,
							url:'index.php?route=seo_power_pack/duplicate_urls/update&token=<?=$token?>&fn='+field_name+'&fv='+field_value+'&language_id='+language_id+'&url_alias_id='+url_alias_id,
							dataType: 'json',
							success:function(response){
								if(typeof(response.success)!='undefined'){
									curr_input.closest('td').text(curr_input.val());	
								}
							}
						});	
					}
				});

				$('#'+input_name).bind('blur', function(){
					var curr_input = $(this);
					var language_id = $(this).closest('.list-container').attr('id').replace('durls_lang_','');
					var field_name = curr_input.closest('td').attr('data');
					var field_value =curr_input.val();
					var url_alias_id = curr_input.closest('tr').attr('id').replace('durls-','');

					inputSaving(curr_input);

					$.ajax({
						type:'post',
						cache:false,
						async: true,
						url:'index.php?route=seo_power_pack/duplicate_urls/update&token=<?=$token?>&fn='+field_name+'&fv='+field_value+'&language_id='+language_id+'&url_alias_id='+url_alias_id,
						dataType: 'json',
						success:function(response){
							if(typeof(response.success)!='undefined'){
								curr_input.closest('td').text(curr_input.val());	
							}
						}
					});	
				});
			}
		});
	}
}
/* Duplicate Url Listing */
/* Information Listing */
$(function(){
	$('.informations-lang-tabs a').bind('dblclick', function(){
		var ele = $(this);
		if(!(ele.html().indexOf('<i class="fa fa-spinner fa-spin"></i>') >-1)){
			ele.prepend('<i class="fa fa-spinner fa-spin"></i>');
		}
		var paging_url = $(this).data('url');
		$.ajax({
			type:'post',
			cache:false,
			async: true,
			url:paging_url+'&tab_container='+$(this).attr('href').replace('#',''),
			dataType: 'json',
			success:function(response){
				ele.find('.fa:first').remove();
				renderByType('informations', response);
			}
		});			
	});	
	$('.informations-lang-tabs a').bind('click', function(){
		if(typeof($(this).data('url'))!='undefined' && $.trim($($(this).attr('href')).html()).length == 0){
			var ele = $(this);
			if(!(ele.html().indexOf('<i class="fa fa-spinner fa-spin"></i>') >-1)){
				ele.prepend('<i class="fa fa-spinner fa-spin"></i>');
			}
			var paging_url = $(this).data('url');
			$.ajax({
				type:'post',
				cache:false,
				async: true,
				url:paging_url+'&tab_container='+$(this).attr('href').replace('#',''),
				dataType: 'json',
				success:function(response){
					ele.find('.fa:first').remove();
					renderByType('informations', response);
				}
			});			
		}
	});	
	$('.informations-lang-tabs a:first').trigger('click');
});
function renderInformationTable(response, tab_container, lang_id){
	addBadge(response.tab_container, response.total);
	if(response.informations.length > 0){
		var finput_class = ' type="text" class="form-control input-sm finput" ';

		html = '<div class="table-responsive"><table class="table table-hover table-striped table-bordered">';
		html+= '	<thead>';
		html+= '		<tr>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="info.name"><?=$js_title?></th>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="info.meta_title"><?=$js_meta_title?></th>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="info.meta_keyword"><?=$js_meta_keyword?></th>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="info.meta_description"><?=$js_meta_desc?></th>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="u.keyword"><?=$js_seo_keyword?></th>';
		html+= '		</tr>';
		html+= '		<tr>';
		html+= '			<th><input value="'+response.filter_name+'" id="info-filter_name-'+lang_id+'" '+finput_class+' /></th>';
		html+= '			<th><input value="'+response.filter_meta_title+'" id="info-filter_meta_title-'+lang_id+'" '+finput_class+' /></th>';
		html+= '			<th><input value="'+response.filter_meta_keyword+'" id="info-filter_meta_keyword-'+lang_id+'" '+finput_class+' /></th>';
		html+= '			<th><input value="'+response.filter_meta_description+'" id="info-filter_meta_description-'+lang_id+'" '+finput_class+' /></th>';
		html+= '			<th><div class="btn-group filter-btns" role="group"><button class="btn btn-primary btn-sm filter-list" type="button"><?=$js_filter?></button><button class="btn btn-default btn-sm filter-list-clear" type="button"><?=$js_clear_or_refresh?></button></div></th>';
		html+= '		</tr>';
		html+= '	</thead>';
		html+= '	<tbody id="information-items-'+lang_id+'">';
		html+= '	</tbody>';
		html+= '	<tfoot>';
		html+= '		<tr>';
		html+= '			<th colspan="5"><div id="information-paging-'+lang_id+'" class="index-pagination"></div></th>';
		html+= '		</tr>';
		html+= '	</tfoot>';
		html+= '</table></div>';

		tab_container.html(html);

		$.each(response.informations, function(k,v){
			html= '<tr id="info-'+v.information_id+'">';
			html+= '	<td class="inplace_edit" data="info_name" data-input="text">'+v.title+'</td>';
			html+= '	<td class="inplace_edit" data="info_mt" data-input="text">'+v.meta_title+'</td>';
			html+= '	<td class="inplace_edit" data="info_mk" data-input="text">'+v.meta_keyword+'</td>';
			html+= '	<td class="inplace_edit" data="info_md" data-input="text">'+v.meta_description+'</td>';
			html+= '	<td class="inplace_edit" data="info_seo" data-input="text">'+v.seo_keyword+'</td>';
			html+= '</tr>';
			$('#information-items-'+lang_id).append(html);
		});


		$('#information-items-'+lang_id+' .inplace_edit').bind('click', function(){
			var input_name = $(this).attr('data')+$(this).closest('.list-container').attr('id').replace('info_lang_','-')+$(this).closest('tr').attr('id');
			
			if($('#'+input_name).length == 0){

				var text = $(this).text().replace('"','');

				if($(this).data('input') == 'text'){
					$(this).html('<input type="text" class="form-control input-sm" id="'+input_name+'" name="'+input_name+'" value="'+text+'" />');
				} else if($(this).data('input') == 'textarea'){
					$(this).html('<textarea class="form-control input-sm" id="'+input_name+'" name="'+input_name+'">'+text+'</textarea>');
				}

				$('#'+input_name).bind('keypress', function(e){
					var p = e.which;
					if(p==13){
						$(this).unbind('blur');

						var curr_input = $(this);
						var language_id = $(this).closest('.list-container').attr('id').replace('info_lang_','');
						var field_name = curr_input.closest('td').attr('data');
						var field_value =curr_input.val();
						var information_id = curr_input.closest('tr').attr('id').replace('info-','');

						inputSaving(curr_input);

						$.ajax({
							type:'post',
							cache:false,
							async: true,
							url:'index.php?route=seo_power_pack/informations/update&token=<?=$token?>&fn='+field_name+'&fv='+field_value+'&language_id='+language_id+'&information_id='+information_id,
							dataType: 'json',
							success:function(response){
								if(typeof(response.success)!='undefined'){
									curr_input.closest('td').text(curr_input.val());	
								}
							}
						});	
					}
				});

				$('#'+input_name).bind('blur', function(){
					var curr_input = $(this);
					var language_id = $(this).closest('.list-container').attr('id').replace('info_lang_','');
					var field_name = curr_input.closest('td').attr('data');
					var field_value =curr_input.val();
					var information_id = curr_input.closest('tr').attr('id').replace('info-','');

					inputSaving(curr_input);

					$.ajax({
						type:'post',
						cache:false,
						async: true,
						url:'index.php?route=seo_power_pack/informations/update&token=<?=$token?>&fn='+field_name+'&fv='+field_value+'&language_id='+language_id+'&information_id='+information_id,
						dataType: 'json',
						success:function(response){
							if(typeof(response.success)!='undefined'){
								curr_input.closest('td').text(curr_input.val());	
							}
						}
					});	
				});
			}
		});
	}
}
/* Information Listing */
/* Manufacturers Listing */
$(function(){
	$('.manufacturers-lang-tabs a').bind('dblclick', function(){
		var ele = $(this);
		if(!(ele.html().indexOf('<i class="fa fa-spinner fa-spin"></i>') >-1)){
			ele.prepend('<i class="fa fa-spinner fa-spin"></i>');
		}
		var paging_url = $(this).data('url');
		$.ajax({
			type:'post',
			cache:false,
			async: true,
			url:paging_url+'&tab_container='+$(this).attr('href').replace('#',''),
			dataType: 'json',
			success:function(response){
				ele.find('.fa:first').remove();
				renderByType('manufacturers', response);
			}
		});			
	});	
	$('.manufacturers-lang-tabs a').bind('click', function(){
		if(typeof($(this).data('url'))!='undefined' && $.trim($($(this).attr('href')).html()).length == 0){
			var ele = $(this);
			if(!(ele.html().indexOf('<i class="fa fa-spinner fa-spin"></i>') >-1)){
				ele.prepend('<i class="fa fa-spinner fa-spin"></i>');
			}
			var paging_url = $(this).data('url');
			$.ajax({
				type:'post',
				cache:false,
				async: true,
				url:paging_url+'&tab_container='+$(this).attr('href').replace('#',''),
				dataType: 'json',
				success:function(response){
					ele.find('.fa:first').remove();
					renderByType('manufacturers', response);
				}
			});			
		}
	});	
	$('.manufacturers-lang-tabs a:first').trigger('click');
});
function renderManufacturerTable(response, tab_container, lang_id){
	addBadge(response.tab_container, response.total);
	if(response.manufacturers.length > 0){
		var finput_class = ' type="text" class="form-control input-sm finput" ';

		html = '<div class="table-responsive"><table class="table table-hover table-striped table-bordered">';
		html+= '	<thead>';
		html+= '		<tr>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="m.name"><?=$js_name?></th>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="u.keyword"><?=$js_seo_keyword?></th>';
		html+= '		</tr>';
		html+= '		<tr>';
		html+= '			<th><input value="'+response.filter_name+'" id="man-filter_name-'+lang_id+'" '+finput_class+' /></th>';
		html+= '			<th><div class="btn-group filter-btns" role="group"><button class="btn btn-primary btn-sm filter-list" type="button"><?=$js_filter?></button><button class="btn btn-default btn-sm filter-list-clear" type="button"><?=$js_clear_or_refresh?></button></div></th>';
		html+= '		</tr>';
		html+= '	</thead>';
		html+= '	<tbody id="manufacturer-items-'+lang_id+'">';
		html+= '	</tbody>';
		html+= '	<tfoot>';
		html+= '		<tr>';
		html+= '			<th colspan="2"><div id="manufacturer-paging-'+lang_id+'" class="index-pagination"></div></th>';
		html+= '		</tr>';
		html+= '	</tfoot>';
		html+= '</table></div>';

		tab_container.html(html);

		$.each(response.manufacturers, function(k,v){
			html= '<tr id="man-'+v.manufacturer_id+'">';
			html+= '	<td class="inplace_edit" data="man_name" data-input="text">'+v.name+'</td>';
			html+= '	<td class="inplace_edit" data="man_seo" data-input="text">'+v.seo_keyword+'</td>';
			html+= '</tr>';
			$('#manufacturer-items-'+lang_id).append(html);
		});


		$('#manufacturer-items-'+lang_id+' .inplace_edit').bind('click', function(){
			var input_name = $(this).attr('data')+$(this).closest('.list-container').attr('id').replace('man_lang_','-')+$(this).closest('tr').attr('id');
			
			if($('#'+input_name).length == 0){

				var text = $(this).text().replace('"','');

				if($(this).data('input') == 'text'){
					$(this).html('<input type="text" class="form-control input-sm" id="'+input_name+'" name="'+input_name+'" value="'+text+'" />');
				} else if($(this).data('input') == 'textarea'){
					$(this).html('<textarea class="form-control input-sm" id="'+input_name+'" name="'+input_name+'">'+text+'</textarea>');
				}

				$('#'+input_name).bind('keypress', function(e){
					var p = e.which;
					if(p==13){
						$(this).unbind('blur');

						var curr_input = $(this);
						var language_id = $(this).closest('.list-container').attr('id').replace('man_lang_','');
						var field_name = curr_input.closest('td').attr('data');
						var field_value =curr_input.val();
						var manufacturer_id = curr_input.closest('tr').attr('id').replace('man-','');

						inputSaving(curr_input);

						$.ajax({
							type:'post',
							cache:false,
							async: true,
							url:'index.php?route=seo_power_pack/manufacturers/update&token=<?=$token?>&fn='+field_name+'&fv='+field_value+'&language_id='+language_id+'&manufacturer_id='+manufacturer_id,
							dataType: 'json',
							success:function(response){
								if(typeof(response.success)!='undefined'){
									curr_input.closest('td').text(curr_input.val());	
								}
							}
						});	
					}
				});

				$('#'+input_name).bind('blur', function(){
					var curr_input = $(this);
					var language_id = $(this).closest('.list-container').attr('id').replace('man_lang_','');
					var field_name = curr_input.closest('td').attr('data');
					var field_value =curr_input.val();
					var manufacturer_id = curr_input.closest('tr').attr('id').replace('man-','');

					inputSaving(curr_input);

					$.ajax({
						type:'post',
						cache:false,
						async: true,
						url:'index.php?route=seo_power_pack/manufacturers/update&token=<?=$token?>&fn='+field_name+'&fv='+field_value+'&language_id='+language_id+'&manufacturer_id='+manufacturer_id,
						dataType: 'json',
						success:function(response){
							if(typeof(response.success)!='undefined'){
								curr_input.closest('td').text(curr_input.val());	
							}
						}
					});	
				});
			}
		});
	}
}
/* Manufacturers Listing */
/* Categories Listing */
$(function(){
	$('.categories-lang-tabs a').bind('dblclick', function(){
		var ele = $(this);
		if(!(ele.html().indexOf('<i class="fa fa-spinner fa-spin"></i>') >-1)){
			ele.prepend('<i class="fa fa-spinner fa-spin"></i>');
		}
		var paging_url = $(this).data('url');
		$.ajax({
			type:'post',
			cache:false,
			async: true,
			url:paging_url+'&tab_container='+$(this).attr('href').replace('#',''),
			dataType: 'json',
			success:function(response){
				ele.find('.fa:first').remove();
				renderByType('categories', response);
			}
		});			
	});	
	$('.categories-lang-tabs a').bind('click', function(){
		if(typeof($(this).data('url'))!='undefined' && $.trim($($(this).attr('href')).html()).length == 0){
			var ele = $(this);
			if(!(ele.html().indexOf('<i class="fa fa-spinner fa-spin"></i>') >-1)){
				ele.prepend('<i class="fa fa-spinner fa-spin"></i>');
			}
			var paging_url = $(this).data('url');
			$.ajax({
				type:'post',
				cache:false,
				async: true,
				url:paging_url+'&tab_container='+$(this).attr('href').replace('#',''),
				dataType: 'json',
				success:function(response){
					ele.find('.fa:first').remove();
					renderByType('categories', response);
				}
			});			
		}
	});	
	$('.categories-lang-tabs a:first').trigger('click');
});
function renderCategoryTable(response, tab_container, lang_id){
	addBadge(response.tab_container, response.total);
	if(response.categories.length > 0){

		var finput_class = ' type="text" class="form-control input-sm finput" ';

		html = '<div class="table-responsive"><table class="table table-hover table-striped table-bordered">';
		html+= '	<thead>';
		html+= '		<tr>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="cd.name"><?=$js_name?></th>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="cd.meta_title"><?=$js_meta_title?></th>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="cd.meta_keyword"><?=$js_meta_keyword?></th>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="cd.meta_description"><?=$js_meta_desc?></th>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="u.keyword"><?=$js_seo_keyword?></th>';
		html+= '		</tr>';
		html+= '		<tr>';
		html+= '			<th><input value="'+response.filter_name+'" id="cat-filter_name-'+lang_id+'" '+finput_class+' /></th>';
		html+= '			<th><input value="'+response.filter_meta_title+'" id="cat-filter_meta_title-'+lang_id+'" '+finput_class+' /></th>';
		html+= '			<th><input value="'+response.filter_meta_keyword+'" id="cat-filter_meta_keyword-'+lang_id+'" '+finput_class+' /></th>';
		html+= '			<th><input value="'+response.filter_meta_description+'" id="cat-filter_meta_description-'+lang_id+'" '+finput_class+' /></th>';
		html+= '			<th><div class="btn-group filter-btns" role="group"><button class="btn btn-primary btn-sm filter-list" type="button"><?=$js_filter?></button><button class="btn btn-default btn-sm filter-list-clear" type="button"><?=$js_clear_or_refresh?></button></div></th>';
		html+= '		</tr>';
		html+= '	</thead>';
		html+= '	<tbody id="category-items-'+lang_id+'">';
		html+= '	</tbody>';
		html+= '	<tfoot>';
		html+= '		<tr>';
		html+= '			<th colspan="5"><div id="category-paging-'+lang_id+'" class="index-pagination"></div></th>';
		html+= '		</tr>';
		html+= '	</tfoot>';
		html+= '</table></div>';

		tab_container.html(html);

		$.each(response.categories, function(k,v){
			html= '<tr id="cat-'+v.category_id+'">';
			html+= '	<td class="inplace_edit" data="cat_name" data-input="text">'+v.name+'</td>';
			html+= '	<td class="inplace_edit" data="cat_mt" data-input="text">'+v.meta_title+'</td>';
			html+= '	<td class="inplace_edit" data="cat_mk" data-input="text">'+v.meta_keyword+'</td>';
			html+= '	<td class="inplace_edit" data="cat_md" data-input="text">'+v.meta_description+'</td>';
			html+= '	<td class="inplace_edit" data="cat_seo" data-input="text">'+v.seo_keyword+'</td>';
			html+= '</tr>';
			$('#category-items-'+lang_id).append(html);
		});


		$('#category-items-'+lang_id+' .inplace_edit').bind('click', function(){
			var input_name = $(this).attr('data')+$(this).closest('.list-container').attr('id').replace('cat_lang_','-')+$(this).closest('tr').attr('id');
			
			if($('#'+input_name).length == 0){

				var text = $(this).text().replace('"','');

				if($(this).data('input') == 'text'){
					$(this).html('<input type="text" class="form-control input-sm" id="'+input_name+'" name="'+input_name+'" value="'+text+'" />');
				} else if($(this).data('input') == 'textarea'){
					$(this).html('<textarea class="form-control input-sm" id="'+input_name+'" name="'+input_name+'">'+text+'</textarea>');
				}

				$('#'+input_name).bind('keypress', function(e){
					var p = e.which;
					if(p==13){
						$(this).unbind('blur');

						var curr_input = $(this);
						var language_id = $(this).closest('.list-container').attr('id').replace('cat_lang_','');
						var field_name = curr_input.closest('td').attr('data');
						var field_value =curr_input.val();
						var category_id = curr_input.closest('tr').attr('id').replace('cat-','');
						
						inputSaving(curr_input);

						$.ajax({
							type:'post',
							cache:false,
							async: true,
							url:'index.php?route=seo_power_pack/categories/update&token=<?=$token?>&fn='+field_name+'&fv='+field_value+'&language_id='+language_id+'&category_id='+category_id,
							dataType: 'json',
							success:function(response){
								if(typeof(response.success)!='undefined'){
									curr_input.closest('td').text(curr_input.val());	
								}
							}
						});	
					}
				});

				$('#'+input_name).bind('blur', function(){
					var curr_input = $(this);
					var language_id = $(this).closest('.list-container').attr('id').replace('cat_lang_','');
					var field_name = curr_input.closest('td').attr('data');
					var field_value =curr_input.val();
					var category_id = curr_input.closest('tr').attr('id').replace('cat-','');

					inputSaving(curr_input);

					$.ajax({
						type:'post',
						cache:false,
						async: true,
						url:'index.php?route=seo_power_pack/categories/update&token=<?=$token?>&fn='+field_name+'&fv='+field_value+'&language_id='+language_id+'&category_id='+category_id,
						dataType: 'json',
						success:function(response){
							if(typeof(response.success)!='undefined'){
								curr_input.closest('td').text(curr_input.val());	
							}
						}
					});	
				});
			}
		});
	}
}
/* Categories Listing */
/* Product Listing */
$(function(){
	$('.products-lang-tabs a').bind('dblclick', function(){
		var ele = $(this);
		if(!(ele.html().indexOf('<i class="fa fa-spinner fa-spin"></i>') >-1)){
			ele.prepend('<i class="fa fa-spinner fa-spin"></i>');
		}
		var paging_url = $(this).data('url');
		$.ajax({
			type:'post',
			cache:false,
			async: true,
			url:paging_url+'&tab_container='+$(this).attr('href').replace('#',''),
			dataType: 'json',
			success:function(response){
				ele.find('.fa:first').remove();
				renderByType('products', response);
			}
		});			
	});	
	$('.products-lang-tabs a').bind('click', function(){
		if(typeof($(this).data('url'))!='undefined' && $.trim($($(this).attr('href')).html()).length == 0){
			var ele = $(this);
			if(!(ele.html().indexOf('<i class="fa fa-spinner fa-spin"></i>') >-1)){
				ele.prepend('<i class="fa fa-spinner fa-spin"></i>');
			}
			var paging_url = $(this).data('url');
			$.ajax({
				type:'post',
				cache:false,
				async: true,
				url:paging_url+'&tab_container='+$(this).attr('href').replace('#',''),
				dataType: 'json',
				success:function(response){
					ele.find('.fa:first').remove();
					renderByType('products', response);
				}
			});			
		}
	});	
	$('.products-lang-tabs a:first').trigger('click');
});
function renderProductTable(response, tab_container, lang_id){
	addBadge(response.tab_container, response.total);
	if(response.products.length > 0){
		var finput_class = ' type="text" class="form-control input-sm finput" ';

		html = '<div class="table-responsive"><table class="table table-hover table-striped table-bordered">';
		html+= '	<thead>';
		html+= '		<tr>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="pd.name"><?=$js_name?></th>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="pd.meta_title"><?=$js_meta_title?></th>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="pd.meta_keyword"><?=$js_meta_keyword?></th>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="pd.meta_description"><?=$js_meta_desc?></th>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="pd.tag"><?=$js_tags?></th>';
		html+= '			<th nowrap="nowrap" class="ob" data-sortby="u.keyword"><?=$js_seo_keyword?></th>';
		html+= '		</tr>';
		html+= '		<tr>';
		html+= '			<th><input value="'+response.filter_name+'" id="pro-filter_name-'+lang_id+'" '+finput_class+' /></th>';
		html+= '			<th><input value="'+response.filter_meta_title+'" id="pro-filter_meta_title-'+lang_id+'" '+finput_class+' /></th>';
		html+= '			<th><input value="'+response.filter_meta_keyword+'" id="pro-filter_meta_keyword-'+lang_id+'" '+finput_class+' /></th>';
		html+= '			<th><input value="'+response.filter_meta_description+'" id="pro-filter_meta_description-'+lang_id+'" '+finput_class+' /></th>';
		html+= '			<th><input value="'+response.filter_tag+'" id="pro-filter_tag-'+lang_id+'" '+finput_class+' /></th>';
		html+= '			<th><div class="btn-group filter-btns" role="group"><button class="btn btn-primary btn-sm filter-list" type="button"><?=$js_filter?></button><button class="btn btn-default btn-sm filter-list-clear" type="button"><?=$js_clear_or_refresh?></button></div></th>';
		html+= '		</tr>';
		html+= '	</thead>';
		html+= '	<tbody id="product-items-'+lang_id+'">';
		html+= '	</tbody>';
		html+= '	<tfoot>';
		html+= '		<tr>';
		html+= '			<th colspan="6"><div id="product-paging-'+lang_id+'" class="index-pagination"></div></th>';
		html+= '		</tr>';
		html+= '	</tfoot>';
		html+= '</table></div>';

		tab_container.html(html);

		$.each(response.products, function(k,v){
			html= '<tr id="pro-'+v.product_id+'">';
			html+= '	<td class="inplace_edit" data="pro_name" data-input="text" data-toggle="tooltip" data-original-title="<?=$js_image_name?> '+v.image+'">'+v.name+'</td>';
			html+= '	<td class="inplace_edit" data="pro_mt" data-input="text">'+v.meta_title+'</td>';
			html+= '	<td class="inplace_edit" data="pro_mk" data-input="text">'+v.meta_keyword+'</td>';
			html+= '	<td class="inplace_edit" data="pro_md" data-input="text">'+v.meta_description+'</td>';
			html+= '	<td class="inplace_edit" data="pro_tag" data-input="text">'+v.tag+'</td>';
			html+= '	<td class="inplace_edit" data="pro_seo" data-input="text">'+v.seo_keyword+'</td>';
			html+= '</tr>';
			$('#product-items-'+lang_id).append(html);
		});


		$('#product-items-'+lang_id+' .inplace_edit').bind('click', function(){
			var input_name = $(this).attr('data')+$(this).closest('.list-container').attr('id').replace('pro_lang_','-')+$(this).closest('tr').attr('id');
			
			if($('#'+input_name).length == 0){

				var text = $(this).text().replace('"','');

				if($(this).data('input') == 'text'){
					$(this).html('<input type="text" class="form-control input-sm" id="'+input_name+'" name="'+input_name+'" value="'+text+'" />');
				} else if($(this).data('input') == 'textarea'){
					$(this).html('<textarea class="form-control input-sm" id="'+input_name+'" name="'+input_name+'">'+text+'</textarea>');
				}

				$('#'+input_name).bind('keypress', function(e){
					var p = e.which;
					if(p==13){
						$(this).unbind('blur');

						var curr_input = $(this);
						var language_id = $(this).closest('.list-container').attr('id').replace('pro_lang_','');
						var field_name = curr_input.closest('td').attr('data');
						var field_value =curr_input.val();
						var product_id = curr_input.closest('tr').attr('id').replace('pro-','');

						inputSaving(curr_input);

						$.ajax({
							type:'post',
							cache:false,
							async: true,
							url:'index.php?route=seo_power_pack/products/update&token=<?=$token?>&fn='+field_name+'&fv='+field_value+'&language_id='+language_id+'&product_id='+product_id,
							dataType: 'json',
							success:function(response){
								if(typeof(response.success)!='undefined'){
									curr_input.closest('td').text(curr_input.val());	
								}
							}
						});	
					}
				});

				$('#'+input_name).bind('blur', function(){
					var curr_input = $(this);
					var language_id = $(this).closest('.list-container').attr('id').replace('pro_lang_','');
					var field_name = curr_input.closest('td').attr('data');
					var field_value =curr_input.val();
					var product_id = curr_input.closest('tr').attr('id').replace('pro-','');

					inputSaving(curr_input);
					
					$.ajax({
						type:'post',
						cache:false,
						async: true,
						url:'index.php?route=seo_power_pack/products/update&token=<?=$token?>&fn='+field_name+'&fv='+field_value+'&language_id='+language_id+'&product_id='+product_id,
						dataType: 'json',
						success:function(response){
							if(typeof(response.success)!='undefined'){
								curr_input.closest('td').text(curr_input.val());	
							}
						}
					});	
				});
			}
		});
	}
}
/* Product Listing */
function inputSaving(curr_input){
	if(!(curr_input.closest('td').find('.fa:first').length>0)){
		curr_input.closest('td').append('<i class="fa fa-spinner fa-spin"></i>');	
	}
}
function renderByType(type, response){
	switch(type){
		case 'products':
		if(typeof(response.products)!='undefined'){

			$('#'+response.tab_container).html('');

			renderProductTable(response, $('#'+response.tab_container), response.language_id);
			createPagination(
				response.paging_url, 
				response.limit, 
				response.page, 
				response.total,
				'#product-items-'+response.language_id,
				'#product-paging-'+response.language_id,
				'product-pageno-'+response.language_id,
				'products'
			);

			processOrderBy(response.ob_url,response.paging_url,'products','#'+response.tab_container);

			$('#'+response.tab_container+' input.finput').bind('keypress',function(e){
				var p = e.which;
				if(p==13){
					$(this).closest('tr').find('button.filter-list:first').trigger('click');
				}
			});

			$('#'+response.tab_container+' button.filter-list').bind('click', function(){

				var language_id = $(this).closest('.list-container').attr('id').replace('pro_lang_','');

				var url_filter = [];
				url_filter.push('language_id='+language_id);

				$(this).closest('tr').find('input').each(function(){
					if($.trim($(this).val()).length > 0){
						url_filter.push($(this).attr('id').replace('pro-','').replace('-'+language_id,'')+'='+encodeURI($(this).val()));	
					}
				});

				var curr_btn = $(this);
				curr_btn.prepend('<i class="fa fa-spinner fa-spin"></i> ').prop('disabled', true);
				$.ajax({
					type:'post',
					cache:false,
					async: true,
					url:'index.php?route=seo_power_pack/products&tab_container='+$(this).closest('.list-container').attr('id')+'&token=<?=$token?>&'+url_filter.join('&'),
					dataType: 'json',
					success:function(response){
						curr_btn.html(curr_btn.html().replace('<i class="fa fa-spinner fa-spin"></i> ','')).prop('disabled', false);
						renderByType('products', response);
					}
				});	
			});

			$('#'+response.tab_container+' button.filter-list-clear').bind('click', function(){
				var language_id = $(this).closest('.list-container').attr('id').replace('pro_lang_','');
				var curr_btn = $(this);
				curr_btn.prepend('<i class="fa fa-spinner fa-spin"></i> ').prop('disabled', true);
				$.ajax({
					type:'post',
					cache:false,
					async: true,
					url:'index.php?route=seo_power_pack/products&tab_container='+$(this).closest('.list-container').attr('id')+'&token=<?=$token?>&language_id='+language_id,
					dataType: 'json',
					success:function(response){
						curr_btn.html(curr_btn.html().replace('<i class="fa fa-spinner fa-spin"></i> ','')).prop('disabled', false);
						renderByType('products', response);
					}
				});	
			});


		} else {
			$('#'+response.tab_container).html('<div class="alert alert-warning"><?=$js_no_products?></div>');
			addBadge(response.tab_container, response.total);
		}
		break;

		case 'categories':
		if(typeof(response.categories)!='undefined'){

			$('#'+response.tab_container).html('');

			renderCategoryTable(response, $('#'+response.tab_container), response.language_id);
			createPagination(
				response.paging_url, 
				response.limit, 
				response.page, 
				response.total,
				'#category-items-'+response.language_id,
				'#category-paging-'+response.language_id,
				'category-pageno-'+response.language_id,
				'categories'
			);

			processOrderBy(response.ob_url,response.paging_url,'categories','#'+response.tab_container);

			$('#'+response.tab_container+' input.finput').bind('keypress',function(e){
				var p = e.which;
				if(p==13){
					$(this).closest('tr').find('button.filter-list:first').trigger('click');
				}
			});

			$('#'+response.tab_container+' button.filter-list').bind('click', function(){

				var language_id = $(this).closest('.list-container').attr('id').replace('cat_lang_','');

				var url_filter = [];
				url_filter.push('language_id='+language_id);

				$(this).closest('tr').find('input').each(function(){
					if($.trim($(this).val()).length > 0){
						url_filter.push($(this).attr('id').replace('cat-','').replace('-'+language_id,'')+'='+encodeURI($(this).val()));	
					}
				});

				var curr_btn = $(this);
				curr_btn.prepend('<i class="fa fa-spinner fa-spin"></i> ').prop('disabled', true);
				$.ajax({
					type:'post',
					cache:false,
					async: true,
					url:'index.php?route=seo_power_pack/categories&tab_container='+$(this).closest('.list-container').attr('id')+'&token=<?=$token?>&'+url_filter.join('&'),
					dataType: 'json',
					success:function(response){
						curr_btn.html(curr_btn.html().replace('<i class="fa fa-spinner fa-spin"></i> ','')).prop('disabled', false);
						renderByType('categories', response);
					}
				});	
			});

			$('#'+response.tab_container+' button.filter-list-clear').bind('click', function(){
				var language_id = $(this).closest('.list-container').attr('id').replace('cat_lang_','');
				var curr_btn = $(this);
				curr_btn.prepend('<i class="fa fa-spinner fa-spin"></i> ').prop('disabled', true);
				$.ajax({
					type:'post',
					cache:false,
					async: true,
					url:'index.php?route=seo_power_pack/categories&tab_container='+$(this).closest('.list-container').attr('id')+'&token=<?=$token?>&language_id='+language_id,
					dataType: 'json',
					success:function(response){
						curr_btn.html(curr_btn.html().replace('<i class="fa fa-spinner fa-spin"></i> ','')).prop('disabled', false);
						renderByType('categories', response);
					}
				});	
			});


		} else {
			$('#'+response.tab_container).html('<div class="alert alert-warning"><?=$js_no_categories?></div>');
			addBadge(response.tab_container, response.total);
		}
		break;

		case 'manufacturers':
		if(typeof(response.manufacturers)!='undefined'){

			$('#'+response.tab_container).html('');

			renderManufacturerTable(response, $('#'+response.tab_container), response.language_id);
			createPagination(
				response.paging_url, 
				response.limit, 
				response.page, 
				response.total,
				'#manufacturer-items-'+response.language_id,
				'#manufacturer-paging-'+response.language_id,
				'manufacturer-pageno-'+response.language_id,
				'manufacturers'
			);

			processOrderBy(response.ob_url,response.paging_url,'manufacturers','#'+response.tab_container);

			$('#'+response.tab_container+' input.finput').bind('keypress',function(e){
				var p = e.which;
				if(p==13){
					$(this).closest('tr').find('button.filter-list:first').trigger('click');
				}
			});

			$('#'+response.tab_container+' button.filter-list').bind('click', function(){

				var language_id = $(this).closest('.list-container').attr('id').replace('man_lang_','');

				var url_filter = [];
				url_filter.push('language_id='+language_id);

				$(this).closest('tr').find('input').each(function(){
					if($.trim($(this).val()).length > 0){
						url_filter.push($(this).attr('id').replace('man-','').replace('-'+language_id,'')+'='+encodeURI($(this).val()));	
					}
				});

				var curr_btn = $(this);
				curr_btn.prepend('<i class="fa fa-spinner fa-spin"></i> ').prop('disabled', true);
				$.ajax({
					type:'post',
					cache:false,
					async: true,
					url:'index.php?route=seo_power_pack/manufacturers&tab_container='+$(this).closest('.list-container').attr('id')+'&token=<?=$token?>&'+url_filter.join('&'),
					dataType: 'json',
					success:function(response){
						curr_btn.html(curr_btn.html().replace('<i class="fa fa-spinner fa-spin"></i> ','')).prop('disabled', false);
						renderByType('manufacturers', response);
					}
				});	
			});

			$('#'+response.tab_container+' button.filter-list-clear').bind('click', function(){

				var language_id = $(this).closest('.list-container').attr('id').replace('man_lang_','');
				var curr_btn = $(this);
				curr_btn.prepend('<i class="fa fa-spinner fa-spin"></i> ').prop('disabled', true);
				$.ajax({
					type:'post',
					cache:false,
					async: true,
					url:'index.php?route=seo_power_pack/manufacturers&tab_container='+$(this).closest('.list-container').attr('id')+'&token=<?=$token?>&language_id='+language_id,
					dataType: 'json',
					success:function(response){
						curr_btn.html(curr_btn.html().replace('<i class="fa fa-spinner fa-spin"></i> ','')).prop('disabled', false);
						renderByType('manufacturers', response);
					}
				});	
			});


		} else {
			$('#'+response.tab_container).html('<div class="alert alert-warning"><?=$js_no_manufacturers?></div>');
			addBadge(response.tab_container, response.total);
		}
		break;

		case 'informations':
		if(typeof(response.informations)!='undefined'){

			$('#'+response.tab_container).html('');

			renderInformationTable(response, $('#'+response.tab_container), response.language_id);
			createPagination(
				response.paging_url, 
				response.limit, 
				response.page, 
				response.total,
				'#information-items-'+response.language_id,
				'#information-paging-'+response.language_id,
				'information-pageno-'+response.language_id,
				'informations'
			);

			processOrderBy(response.ob_url,response.paging_url,'informations','#'+response.tab_container);

			$('#'+response.tab_container+' input.finput').bind('keypress',function(e){
				var p = e.which;
				if(p==13){
					$(this).closest('tr').find('button.filter-list:first').trigger('click');
				}
			});

			$('#'+response.tab_container+' button.filter-list').bind('click', function(){

				var language_id = $(this).closest('.list-container').attr('id').replace('info_lang_','');

				var url_filter = [];
				url_filter.push('language_id='+language_id);

				$(this).closest('tr').find('input').each(function(){
					if($.trim($(this).val()).length > 0){
						url_filter.push($(this).attr('id').replace('info-','').replace('-'+language_id,'')+'='+encodeURI($(this).val()));	
					}
				});

				var curr_btn = $(this);
				curr_btn.prepend('<i class="fa fa-spinner fa-spin"></i> ').prop('disabled', true);
				$.ajax({
					type:'post',
					cache:false,
					async: true,
					url:'index.php?route=seo_power_pack/informations&tab_container='+$(this).closest('.list-container').attr('id')+'&token=<?=$token?>&'+url_filter.join('&'),
					dataType: 'json',
					success:function(response){
						curr_btn.html(curr_btn.html().replace('<i class="fa fa-spinner fa-spin"></i> ','')).prop('disabled', false);
						renderByType('informations', response);
					}
				});	
			});

			$('#'+response.tab_container+' button.filter-list-clear').bind('click', function(){
				var language_id = $(this).closest('.list-container').attr('id').replace('info_lang_','');
				var curr_btn = $(this);
				curr_btn.prepend('<i class="fa fa-spinner fa-spin"></i> ').prop('disabled', true);
				$.ajax({
					type:'post',
					cache:false,
					async: true,
					url:'index.php?route=seo_power_pack/informations&tab_container='+$(this).closest('.list-container').attr('id')+'&token=<?=$token?>&language_id='+language_id,
					dataType: 'json',
					success:function(response){
						curr_btn.html(curr_btn.html().replace('<i class="fa fa-spinner fa-spin"></i> ','')).prop('disabled', false);
						renderByType('informations', response);
					}
				});	
			});


		} else {
			$('#'+response.tab_container).html('<div class="alert alert-warning"><?=$js_no_informations?></div>');
			addBadge(response.tab_container, response.total);
		}
		break;

		case 'duplicate_urls':
		if(typeof(response.duplicate_urls)!='undefined'){

			$('#'+response.tab_container).html('');

			renderDuplicateUrlsTable(response, $('#'+response.tab_container), response.language_id);
			createPagination(
				response.paging_url, 
				response.limit, 
				response.page, 
				response.total,
				'#durls-items-'+response.language_id,
				'#durls-paging-'+response.language_id,
				'durls-pageno-'+response.language_id,
				'duplicate_urls'
			);

			processOrderBy(response.ob_url,response.paging_url,'duplicate_urls','#'+response.tab_container);

			$('#'+response.tab_container+' input.finput').bind('keypress',function(e){
				var p = e.which;
				if(p==13){
					$(this).closest('tr').find('button.filter-list:first').trigger('click');
				}
			});

			$('#'+response.tab_container+' button.filter-list').bind('click', function(){

				var language_id = $(this).closest('.list-container').attr('id').replace('durls_lang_','');

				var url_filter = [];
				url_filter.push('language_id='+language_id);

				$(this).closest('tr').find('input').each(function(){
					if($.trim($(this).val()).length > 0){
						url_filter.push($(this).attr('id').replace('durls-','').replace('-'+language_id,'')+'='+encodeURI($(this).val()));	
					}
				});

				var curr_btn = $(this);
				curr_btn.prepend('<i class="fa fa-spinner fa-spin"></i> ').prop('disabled', true);
				$.ajax({
					type:'post',
					cache:false,
					async: true,
					url:'index.php?route=seo_power_pack/duplicate_urls&tab_container='+$(this).closest('.list-container').attr('id')+'&token=<?=$token?>&'+url_filter.join('&'),
					dataType: 'json',
					success:function(response){
						curr_btn.html(curr_btn.html().replace('<i class="fa fa-spinner fa-spin"></i> ','')).prop('disabled', false);
						renderByType('duplicate_urls', response);
					}
				});	
			});

			$('#'+response.tab_container+' button.filter-list-clear').bind('click', function(){
				var language_id = $(this).closest('.list-container').attr('id').replace('durls_lang_','');
				var curr_btn = $(this);
				curr_btn.prepend('<i class="fa fa-spinner fa-spin"></i> ').prop('disabled', true);
				$.ajax({
					type:'post',
					cache:false,
					async: true,
					url:'index.php?route=seo_power_pack/duplicate_urls&tab_container='+$(this).closest('.list-container').attr('id')+'&token=<?=$token?>&language_id='+language_id,
					dataType: 'json',
					success:function(response){
						curr_btn.html(curr_btn.html().replace('<i class="fa fa-spinner fa-spin"></i> ','')).prop('disabled', false);
						renderByType('duplicate_urls', response);
					}
				});	
			});


		} else {
			$('#'+response.tab_container).html('<div class="alert alert-warning"><?=$js_no_duplicate_urls?></div>');
			addBadge(response.tab_container, response.total);
		}
		break;

		case 'custom_urls':
		if(typeof(response.custom_urls)!='undefined'){

			$('#'+response.tab_container).html('');

			renderCustomUrlsTable(response, $('#'+response.tab_container), response.language_id);
			createPagination(
				response.paging_url, 
				response.limit, 
				response.page, 
				response.total,
				'#curls-items-'+response.language_id,
				'#curls-paging-'+response.language_id,
				'curls-pageno-'+response.language_id,
				'custom_urls'
			);

			processOrderBy(response.ob_url,response.paging_url,'custom_urls','#'+response.tab_container);

			$('#'+response.tab_container+' input.finput').bind('keypress',function(e){
				var p = e.which;
				if(p==13){
					$(this).closest('tr').find('button.filter-list:first').trigger('click');
				}
			});

			$('#'+response.tab_container+' button.filter-list').bind('click', function(){

				var language_id = $(this).closest('.list-container').attr('id').replace('curls_lang_','');

				var url_filter = [];
				url_filter.push('language_id='+language_id);

				$(this).closest('tr').find('input').each(function(){
					if($.trim($(this).val()).length > 0){
						url_filter.push($(this).attr('id').replace('curls-','').replace('-'+language_id,'')+'='+encodeURI($(this).val()));	
					}
				});

				var curr_btn = $(this);
				curr_btn.prepend('<i class="fa fa-spinner fa-spin"></i> ').prop('disabled', true);
				$.ajax({
					type:'post',
					cache:false,
					async: true,
					url:'index.php?route=seo_power_pack/custom_urls&tab_container='+$(this).closest('.list-container').attr('id')+'&token=<?=$token?>&'+url_filter.join('&'),
					dataType: 'json',
					success:function(response){
						curr_btn.html(curr_btn.html().replace('<i class="fa fa-spinner fa-spin"></i> ','')).prop('disabled', false);
						renderByType('custom_urls', response);
					}
				});	
			});

			$('#'+response.tab_container+' button.filter-list-clear').bind('click', function(){
				var language_id = $(this).closest('.list-container').attr('id').replace('curls_lang_','');
				var curr_btn = $(this);
				curr_btn.prepend('<i class="fa fa-spinner fa-spin"></i> ').prop('disabled', true);
				$.ajax({
					type:'post',
					cache:false,
					async: true,
					url:'index.php?route=seo_power_pack/custom_urls&tab_container='+$(this).closest('.list-container').attr('id')+'&token=<?=$token?>&language_id='+language_id,
					dataType: 'json',
					success:function(response){
						curr_btn.html(curr_btn.html().replace('<i class="fa fa-spinner fa-spin"></i> ','')).prop('disabled', false);
						renderByType('custom_urls', response);
					}
				});	
			});


		} else {
			$('#'+response.tab_container).html('<div class="alert alert-warning"><?=$js_no_custom_urls?></div>');
			addBadge(response.tab_container, response.total);
		}
		break;

		default: break;
	}
}


</script>

<!-- Place this tag after the last widget tag. -->
<script type="text/javascript">
function processOrderBy(ob_url, curr_url, renderType, container){
	$(container+' .ob').each(function(){
		var sortby = $(this).data('sortby');
		var label = $(this).text();
		var direction = 'ASC';
		
		if(curr_url.indexOf('sort='+sortby) > -1){
			if(curr_url.indexOf('order=ASC') > -1){
				$(this).html('<a data-load-text="'+label+'" onclick="return false;" href="'+ob_url+'&sort='+sortby+'&order=DESC"><i class="fa fa-chevron-circle-up"></i> '+label+'</a>');
			} else {
				$(this).html('<a data-load-text="'+label+'" onclick="return false;" href="'+ob_url+'&sort='+sortby+'&order=ASC"><i class="fa fa-chevron-circle-down"></i> '+label+'</a>');
			}
		} else {
			$(this).html('<a data-load-text="'+label+'" onclick="return false;" href="'+ob_url+'&sort='+sortby+'&order='+direction+'">'+label+'</a>');
		}
	});

	$(container+' .ob a').bind('click',function(e){
		var ele = $(this);
		ele.removeClass('fa').addClass('fa');

		$('.ob a').each(function(){
			$(this).text($(this).text());
		})

		ele.html('<i class="fa fa-spinner"></i> '+ele.text());
		
		$.ajax({
			type: "POST",
			cache: false,
			async: true,
			url: ele.attr('href')+'&ajax=1',
			beforeSend:function (XMLHttpRequest) {
				if(ele.attr('href').indexOf('=ASC')>-1)
					ele.find('i:first').addClass('fa-spin');
				else
					ele.find('i:first').addClass('icon-spin-reverse');
			}, 
			complete:function (XMLHttpRequest, textStatus) {
				if(ele.attr('href').indexOf('=ASC')>-1)
					ele.find('i:first').removeClass('fa-spin');
				else
					ele.find('i:first').removeClass('icon-spin-reverse');
			}, 
			success: function(response) {
				renderByType(renderType, response);
				scrollTop();
			}
		});
	});
}

/* Pagniation Script */
function createPagination(url, limit, currpage, total_records,updated_div,pagination_div, page_no, renderType){

	var currpage = parseInt(currpage, 10);
	var limit = parseInt(limit, 10);
	var total_records = parseInt(total_records, 10);
	
	if(total_records == 0){
		return false;
	}

	var no_of_page = (total_records / limit);

	if(no_of_page > parseInt(no_of_page, 10)){
		no_of_page = parseInt(no_of_page, 10) + 1;
	}
	
	/* No of page need to display */
	var display_numbers = 5;
	
	/* Set Numbers To Display */
	var display_pages_start = 1
	var display_pages_end = display_numbers;
	
	if(currpage <= display_numbers){
		if(no_of_page >= display_numbers ){
			display_pages_start = 1
			display_pages_end = display_numbers;
		} else {
			display_pages_start = 1
			display_pages_end = no_of_page;
		}
	} else {
		display_pages_start = currpage - parseInt(display_numbers/2, 10);
		if(display_pages_start < 1){
			display_pages_start = 1;
		}
	
		display_pages_end = currpage + parseInt(display_numbers/2, 10);
		if(display_pages_end > no_of_page){
			display_pages_end = no_of_page;
		}
	}
	
	if(display_pages_end > display_numbers){
		if(display_pages_end-display_pages_start < display_numbers){
			display_pages_start = display_pages_start - (display_numbers - ((display_pages_end+1)-display_pages_start));
		}
	}

	/* Page Info */
	$(pagination_div).html('<span class="badge cpage">Page: <input data-max="'+no_of_page+'" data-content="'+updated_div+'" data-url="'+url+'" type="text" value="'+currpage+ '" id="'+page_no+'" name="'+page_no+'" class="page_no" /> / '+no_of_page+'</span>');

	$('#'+page_no).bind('keypress',function(e){
		var p = e.which;

		if(p==13 && parseInt($('#'+page_no).val(), 10) > 0){
			if(parseInt($('#'+page_no).val(), 10) <= parseInt($('#'+page_no).attr('data-max'), 10)){
				$.ajax({
					type: "POST",
					cache: false,
					async: true,
					url: $('#'+page_no).attr('data-url')+'&ajax=1&page='+parseInt($('#'+page_no).val(), 10),
					beforeSend:function (XMLHttpRequest) {
						$('#'+page_no).addClass('fa fa-spinner fa-spin');
					}, 
					complete:function (XMLHttpRequest, textStatus) {
						$('#'+page_no).removeClass('fa fa-spinner fa-spin');
					}, 
					success: function(response) {
						renderByType(renderType, response);
						scrollTop();
					}
				});
			} else {
				$.notify('<?=$js_warning_please_enter_a_page_number?>','warn');
			}
		}
	});
	
	/* Previous and First Page */
	if(currpage > 1){
		if((currpage-1) > 1){
			var urlfinal = url+'&page=1';
			$(pagination_div).append(createBMIUrl(urlfinal, '&laquo;','b',updated_div));
		} else {
			$(pagination_div).append(createHiddenBMIUrl('&laquo;'));
		}
		var urlfinal = url+'&page='+(currpage-1);
		$(pagination_div).append(createBMIUrl(urlfinal, '&lsaquo;','b',updated_div));
	} else {
		if((currpage-1) > 1){
			var urlfinal = url+'&page=1';
			$(pagination_div).append(createBMIUrl(urlfinal, '&laquo;','b',updated_div));
		} else {
			$(pagination_div).append(createHiddenBMIUrl('&laquo;'));
		}
		$(pagination_div).append(createHiddenBMIUrl('&lsaquo;'));
	}

	/* Display Numbers */
	if(display_numbers > 0){
		for(var i=display_pages_start; i<=display_pages_end; i++){
			if(currpage == i){
				$(pagination_div).append(createBMIUrlCurr(i));
			} else {
				var urlfinal = url+'&page='+i;
				$(pagination_div).append(createBMIUrl(urlfinal, i,'',updated_div));
			}
		}
	}
	
	/* Next and Last Page */
	if(currpage < no_of_page){
		var urlfinal = url+'&page='+(currpage + 1);
		$(pagination_div).append(createBMIUrl(urlfinal, '&rsaquo;','b',updated_div));
		
		if((currpage + 1) < no_of_page){
			var urlfinal = url+'&page='+ no_of_page;
			$(pagination_div).append(createBMIUrl(urlfinal, '&raquo;','b',updated_div));
		} else {
			$(pagination_div).append(createHiddenBMIUrl('&raquo;'));
		}
	} else {
		$(pagination_div).append(createHiddenBMIUrl('&rsaquo;'));

		if((currpage + 1) < no_of_page){
			var urlfinal = url+'&page='+ no_of_page;
			$(pagination_div).append(createBMIUrl(urlfinal, '&raquo;','b',updated_div));
		} else {
			$(pagination_div).append(createHiddenBMIUrl('&raquo;'));
		}		
	}
	
	$(pagination_div+' a').bind('click',function(e){
		var ele = $(this);
		$.ajax({
			type: "POST",
			cache: false,
			async: true,
			dataType: 'json',
			url: ele.attr('href')+'&ajax=1',
			beforeSend:function (XMLHttpRequest) {
				ele.addClass('fa-spin');
			}, 
			complete:function (XMLHttpRequest, textStatus) {
				ele.removeClass('fa-spin');
			}, 
			success: function(response) {
				renderByType(renderType, response);
				scrollTop();
			}
		});
	});
}
function scrollTop(){
	$('html,body').animate({
          scrollTop: 100
    }, 1000);
}
function createBMIUrlCurr(txt){
	return '<span class="page-current">'+txt+'</span>';
}
function createHiddenBMIUrl(txt){
	return '<a class="nplf lgtgray" href="#" onclick="return false;">'+txt+'</a>';
}
function createBMIUrl(url, txt, big,updated_div){
	if(big.length > 0){
		return '<a class="btn-xs nplf" data-load-text="" data-content="'+updated_div+'" href="'+url+'" onclick="return false;">'+txt+'</a>';
	} else {
		return '<a class="btn-xs" data-load-text="" data-content="'+updated_div+'" href="'+url+'" onclick="return false;">'+txt+'</a>';
	}
}
</script>
<style type="text/css">
.page-header {
	border-bottom: 0 solid #eee;
	margin: 0;
	padding-bottom: 0;
}
.tab-content{
	padding: 20px 0;
}
.panel-heading .fa{
	margin-right: 5px;
}
.panel-heading h3 {
  font-size: 16px;
  line-height: 24px;
  margin: 0;
}
.allowed-tags{
	padding-top: 5px;
}
.help-block{
	font-size: 13px;
}
.well-sm {
    border-radius: 3px;
    margin-bottom: 5px;
    padding: 9px;
}
#index-pagination {
    color: #676767;
    float: right;
    font-family: arial;
    font-size: 13px;
    line-height: 24px;
}
.index-pagination span.cpage {
    float: left;
    font-size: 11px;
    font-weight: normal;
    height: 24px;
    line-height: 24px;
    margin: 0;
    padding: 0 10px;
}
.index-pagination a, .index-pagination .page-current {
  display: inline-block;
  float: left;
  font-size: 16px;
  line-height: 24px;
  outline: medium none;
  padding: 0 5px;
  text-align: center;
}
.index-pagination .page-current {
	color: #555555;
	float: left;
	font-weight: bold;
}
.index-pagination a.nplf {
    font-size: 22px;
    line-height: 22px;
    margin-top: -1px;
}
.index-pagination a:hover, .index-pagination a:focus {
    outline: medium none;
    text-decoration: none;
}
body .index-pagination span.cpage input {
	border: 0 none;
	color: #444;
	font-size: 11px;
	font-weight: normal;
	line-height: 16px;
	width: 25px;
	text-align: center;
}
.index-pagination a.lgtgray {
    color: #DDDDDD;
}
.index-pagination .pageno {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
    border: 0 none;
    color: #454545;
    padding: 0;
    text-align: center;
    transition: all 300ms ease 0s;
    width: 16px;
	line-height: 11px;
}
.index-pagination #pageno:focus, .index-pagination #pageno:hover {
    background: none repeat scroll 0 0 #FFFFFF;
    width: 22px;
}
.filter-btns{
	width: 160px;
}
.h3heading{
	border-bottom: 5px solid #ececec;
	font-weight: bold;
	margin-bottom: 30px;
	padding-bottom: 10px;
}
.page-header h1 {
  color: #f15d22;
  float: left;
  font-size: 13px;
  font-weight: bold;
  margin-top: 14px;
  text-transform: uppercase;
}
.page-header h1:before{ 
	content: "Webby ";
	color:#ae2218;
}
.breadcrumb {
  margin: 11px 0 0;
}
.icon-spin-reverse {
	display: inline-block;
	-moz-animation: spin-reverse 2s infinite linear;
	-o-animation: spin-reverse 2s infinite linear;
	-webkit-animation: spin-reverse 2s infinite linear;
	animation: spin-reverse 2s infinite linear;
}

@-moz-keyframes spin-reverse {
	0% { -moz-transform: rotate(0deg); }
	100% { -moz-transform: rotate(-359deg); }
}
@-webkit-keyframes spin-reverse {
	0% { -webkit-transform: rotate(0deg); }
	100% { -webkit-transform: rotate(-359deg); }
}
@-o-keyframes spin-reverse {
	0% { -o-transform: rotate(0deg); }
	100% { -o-transform: rotate(-359deg); }
}
@-ms-keyframes spin-reverse {
	0% { -ms-transform: rotate(0deg); }
	100% { -ms-transform: rotate(-359deg); }
}
@keyframes spin-reverse {
	0% { transform: rotate(0deg); }
	100% { transform: rotate(-359deg); }
}
#social_seo .col-sm-4{
	padding-bottom: 30px;
}
#social_seo .col-sm-4 > h3 {
	border-bottom: 1px solid #a9a9a9;
	font-weight: bold;
	margin-bottom: 30px;
	padding-bottom: 10px;
}
</style>
<?php echo $footer; ?>