<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-custom_footer" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-custom_footer" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="custom_footer[status]" id="input-status" class="form-control">
                <?php if ($custom_footer['status']) { ?>
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
                <label class="col-sm-2 control-label" for="input-footer_full_width"><?php echo $entry_footer_full_width; ?></label>
                <div class="col-sm-10">
                   <select name="custom_footer[footer_full_width]" id="input-footer_full_width" class="form-control">
                    <?php if ($custom_footer['footer_full_width']) { ?>
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
                <label class="col-sm-2 control-label" for="input-footer_bg_color"><?php echo $entry_footer_bg_color; ?></label>
                <div class="col-sm-4 input-group wowcolorpicker">
                  <input name="custom_footer[footer_bg_color]" type="text" id="input-footer_bg_color" class="form-control" value="<?php echo isset($custom_footer['footer_bg_color']) ? $custom_footer['footer_bg_color'] : '#303030';?>" />
                  <span class="input-group-addon"><i></i></span> </div>
              </div>
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-footer_heading_font_color"><?php echo $entry_footer_heading_font_color; ?></label>
                <div class="col-sm-4 input-group wowcolorpicker">
                  <input name="custom_footer[footer_heading_font_color]" type="text" id="input-footer_heading_font_color" class="form-control" value="<?php echo isset($custom_footer['footer_heading_font_color']) ? $custom_footer['footer_heading_font_color'] : '#FFF';?>" />
                  <span class="input-group-addon"><i></i></span> </div>
              </div>
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-footer_link_color"><?php echo $entry_footer_link_color; ?></label>
                <div class="col-sm-4 input-group wowcolorpicker">
                  <input name="custom_footer[footer_link_color]" type="text" id="input-footer_link_color" class="form-control" value="<?php echo isset($custom_footer['footer_link_color']) ? $custom_footer['footer_link_color'] : '#ccc';?>" />
                  <span class="input-group-addon"><i></i></span> </div>
              </div>
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-footer_link_hover_color"><?php echo $entry_footer_link_hover_color; ?></label>
                <div class="col-sm-4 input-group wowcolorpicker">
                  <input name="custom_footer[footer_link_hover_color]" type="text" id="input-footer_link_hover_color" class="form-control" value="<?php echo isset($custom_footer['footer_link_hover_color']) ? $custom_footer['footer_link_hover_color'] : '#FFF';?>" />
                  <span class="input-group-addon"><i></i></span> </div>
              </div>
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-footer_hr_status"><?php echo $entry_footer_hr_status; ?></label>
                <div class="col-sm-10">
                   <select name="custom_footer[footer_hr_status]" id="input-footer_hr_status" class="form-control">
                    <?php if ($custom_footer['footer_hr_status']) { ?>
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
                <label class="col-sm-2 control-label" for="input-footer_hr_color"><?php echo $entry_footer_hr_color; ?></label>
                <div class="col-sm-4 input-group wowcolorpicker">
                  <input name="custom_footer[footer_hr_color]" type="text" id="input-footer_hr_color" class="form-control" value="<?php echo isset($custom_footer['footer_hr_color']) ? $custom_footer['footer_hr_color'] : '#FFF';?>" />
                  <span class="input-group-addon"><i></i></span> </div>
              </div>
 			  
			  <?php for($x=1;$x<=2;$x++) { ?>
			  <div class="form-group">
			  	<label class="col-sm-2 control-label" for="input-footer_extra_heading_title<?php echo $x;?>"><?php echo $entry_footer_extra_heading_title; ?> <?php echo $x;?></label>
                <div class="col-sm-4">
                  <input name="custom_footer[footer_extra_heading_title<?php echo $x;?>]" type="text" id="input-footer_extra_heading_title<?php echo $x;?>" class="form-control" value="<?php echo isset($custom_footer['footer_extra_heading_title'.$x]) ? $custom_footer['footer_extra_heading_title'.$x] : 'Contact '.$x;?>" />
                </div>
				
                <label class="col-sm-2 control-label" for="input-footer_extra_heading_status<?php echo $x;?>"><?php echo $entry_footer_extra_heading_status; ?> <?php echo $x;?></label>
                <div class="col-sm-4">
                   <select name="custom_footer[footer_extra_heading_status<?php echo $x;?>]" id="input-footer_extra_heading_status<?php echo $x;?>" class="form-control">
                    <?php if ($custom_footer['footer_extra_heading_status'.$x]) { ?>
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
                <label class="col-sm-2 control-label" for="input-footer_extra_text<?php echo $x;?>"><span data-toggle="tooltip" title="<?php echo $help_footer_extra_text; ?>"><?php echo $entry_footer_extra_text; ?> <?php echo $x;?></span> </label>
                <div class="col-sm-10">
                  <?php $footer_extra_text = '<p>Wow Theme</p><p>royal avenue</p><p>Miami-12345</p><p>openweb.softtech@gmail.com</p>'; ?>
				  <textarea name="custom_footer[footer_extra_text<?php echo $x;?>]" placeholder="<?php echo $entry_footer_extra_text.$x; ?>" id="input-footer_extra_text<?php echo $x;?>"><?php echo isset($custom_footer['footer_extra_text'.$x]) ? $custom_footer['footer_extra_text'.$x] : $footer_extra_text; ?></textarea>
                 </div>
              </div>
			  <?php } ?>
			  
			   
			  <br />
              <hr />
              <hr />
              <br />
			  
			  <div class="form-group">
                <label class="col-sm-5 control-label" for="input-custom_footer_link"><h2><?php echo $entry_custom_footer_link; ?></h2></label>
              </div>
			  <?php for($i=1; $i<=10; $i++) { ?>
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-custom_footer_link<?php echo $i;?>"><?php echo $entry_custom_footer_link.$i; ?></label>
                <div class="col-sm-3">
					<p><?php echo $entry_custom_footer_link_name.$i; ?></p>
                  <input name="custom_footer[custom_footer_link_name<?php echo $i;?>]" type="text" id="input-custom_footer_link_name<?php echo $i;?>" class="form-control" value="<?php echo isset($custom_footer['custom_footer_link_name'.$i]) ? $custom_footer['custom_footer_link_name'.$i] : $entry_custom_footer_link_name.$i;?>" /> </div>
				<div class="col-sm-3">	
					<p><?php echo $entry_custom_footer_link_display_in.$i; ?></p>			  
				  <select name="custom_footer[custom_footer_link_display_in<?php echo $i;?>]" id="input-custom_footer_link_display_in<?php echo $i;?>" class="form-control">
                    <option  <?php if (isset($custom_footer['custom_footer_link_display_in'.$i]) && $custom_footer['custom_footer_link_display_in'.$i] == 'information') { ?> selected="selected" <?php } ?> value="information">Information</option>
                    <option  <?php if (isset($custom_footer['custom_footer_link_display_in'.$i]) && $custom_footer['custom_footer_link_display_in'.$i] == 'customer_service') { ?> selected="selected" <?php } ?> value="customer_service">Customer Service</option>
					<option  <?php if (isset($custom_footer['custom_footer_link_display_in'.$i]) && $custom_footer['custom_footer_link_display_in'.$i] == 'extras') { ?> selected="selected" <?php } ?> value="extras">Extras</option>
					<option  <?php if (isset($custom_footer['custom_footer_link_display_in'.$i]) && $custom_footer['custom_footer_link_display_in'.$i] == 'my_account') { ?> selected="selected" <?php } ?> value="my_account">My Account</option>
					<option  <?php if (isset($custom_footer['custom_footer_link_display_in'.$i]) && $custom_footer['custom_footer_link_display_in'.$i] == 'footer_extra_heading_1') { ?> selected="selected" <?php } ?> value="footer_extra_heading_1"><?php echo $entry_footer_extra_heading_title.'1';?></option>
					<option  <?php if (isset($custom_footer['custom_footer_link_display_in'.$i]) && $custom_footer['custom_footer_link_display_in'.$i] == 'footer_extra_heading_2') { ?> selected="selected" <?php } ?> value="footer_extra_heading_2"><?php echo $entry_footer_extra_heading_title.'2';?></option>					
                  </select>
				</div>
				<div class="col-sm-3">
				  <p><?php echo $entry_custom_footer_link_status.$i; ?></p>			  
				  <select name="custom_footer[custom_footer_link_status<?php echo $i;?>]" id="input-custom_footer_link_status<?php echo $i;?>" class="form-control">
                    <?php if ($custom_footer['custom_footer_link_status'.$i]) { ?>
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
                <label class="col-sm-2 control-label" for="input-custom_footer_link_url<?php echo $i;?>"><?php echo $entry_custom_footer_link_url.$i; ?></label>
                <div class="col-sm-10">
                  <input name="custom_footer[custom_footer_link_url<?php echo $i;?>]" type="text" id="input-custom_footer_link_url<?php echo $i;?>" class="form-control" value="<?php echo isset($custom_footer['custom_footer_link_url'.$i]) ? $custom_footer['custom_footer_link_url'.$i] : $catalog_url;?>" /> </div>
              </div>
 			  <?php } ?>
			  
			  <br />
              <hr />
              <hr />
              <br />
			  <div class="form-group">
                <label class="col-sm-5 control-label" for="input-subchild_menu_hover_font_color"><h2><?php echo $entry_footer_google_map; ?></h2></label>
              </div>
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-footer_google_map_status"><?php echo $entry_footer_google_map_status; ?></label>
                <div class="col-sm-10">
                  <select name="custom_footer[footer_google_map_status]" id="input-footer_google_map_status" class="form-control">
                    <?php if ($custom_footer['footer_google_map_status']) { ?>
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
                <label class="col-sm-2 control-label" for="input-footer_google_map_position"><?php echo $entry_footer_google_map_position; ?></label>
                <div class="col-sm-10">
                  <?php if (!isset($custom_footer['footer_google_map_position'])) { $custom_footer['footer_google_map_position'] = 'bottom'; } ?>
                  <select name="custom_footer[footer_google_map_position]" id="input-footer_google_map_position" class="form-control">
                    <option  <?php if ($custom_footer['footer_google_map_position'] == 'top') { ?> selected="selected" <?php } ?> value="top">Top</option>
                    <option  <?php if ($custom_footer['footer_google_map_position'] == 'bottom') { ?> selected="selected" <?php } ?> value="bottom">Bottom</option>
                  </select>
                </div>
              </div>
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-footer_google_map_embed_text"><span data-toggle="tooltip" title="<?php echo $help_footer_google_map_embed; ?>"><?php echo $entry_footer_google_map_embed_text; ?></span> </label>
                <div class="col-sm-10">
                  <?php $footer_google_map_embed_text = ''; ?>
                  <textarea rows="8" name="custom_footer[footer_google_map_embed_text]" id="input-footer_google_map_embed_text" class="form-control"><?php echo isset($custom_footer['footer_google_map_embed_text']) ? $custom_footer['footer_google_map_embed_text'] : $footer_google_map_embed_text; ?></textarea>
                </div>
              </div>
			  
			  <br />
              <hr />
              <hr />
              <br />
			  
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-footer_custom_content_status"><?php echo $entry_footer_custom_content_status; ?></label>
                <div class="col-sm-10">
                  <select name="custom_footer[footer_custom_content_status]" id="input-footer_custom_content_status" class="form-control">
                    <?php if ($custom_footer['footer_custom_content_status']) { ?>
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
                    <label class="col-sm-2 control-label" for="input-footer_custom_content"><?php echo $entry_footer_custom_content; ?></label>
                    <div class="col-sm-10">
                      <textarea name="custom_footer[footer_custom_content]" placeholder="<?php echo $entry_footer_custom_content; ?>" id="input-footer_custom_content"><?php echo isset($custom_footer['footer_custom_content']) ? $custom_footer['footer_custom_content'] : ''; ?></textarea>
                    </div>
                  </div>
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-footer_powered_by_text_status"><?php echo $entry_footer_powered_by_text_status; ?></label>
                <div class="col-sm-10">
                  <select name="custom_footer[footer_powered_by_text_status]" id="input-footer_powered_by_text_status" class="form-control">
                    <?php if ($custom_footer['footer_powered_by_text_status']) { ?>
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
                <label class="col-sm-2 control-label" for="input-footer_powered_by_text"><?php echo $entry_footer_powered_by_text; ?> </label>
                <div class="col-sm-10">
                  <?php $footer_powered_by_text = '<p>Powered By <a href="http://www.opencart.com">OpenCart</a><br> Your Store &copy; 2015</p>'; ?>
                  <textarea rows="5" name="custom_footer[footer_powered_by_text]" id="input-footer_powered_by_text" class="form-control"><?php echo isset($custom_footer['footer_powered_by_text']) ? $custom_footer['footer_powered_by_text'] : $footer_powered_by_text; ?></textarea>
                </div>
              </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
<script>
$(function(){ $('.wowcolorpicker').colorpicker(); });
$('#input-footer_custom_content').summernote({height: 300});
$('#input-footer_powered_by_text').summernote({height: 300});

for(var x=1;x<=2;x++)
{
	$('#input-footer_extra_text'+x).summernote({height: 200});
}
</script>