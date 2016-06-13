<?php
/**
 * Multiple Featured Module Pro
 * 
 * @author  Kyo (AKA Yasuhiro Sota)
 * @version 3.2.2
 * @license Commercial License
 * @package admin
 * @subpackage  admin.language.english.module
 */
// Heading
$_['heading_title']                    = 'Multiple Featured Module Pro';

// Text
$_['text_module']                       = 'Modules';
$_['text_success']                      = 'Success: The Multiple Featured configuration have been saved successfully!';
$_['text_content_top']                  = 'Content Top';
$_['text_content_bottom']               = 'Content Bottom';
$_['text_column_left']                  = 'Column Left';
$_['text_column_right']                 = 'Column Right';
$_['text_confirm_delete_product_list']  = 'This featured product list is currently linked to at least one module.' . '\r\n' .'Are you sure you want to delete it?' . '\r\n' .'Changes will not be saved until the form is submitted.';
$_['text_featured_content']             = 'Featured';
$_['text_add_featured_content']         = 'Add Featured Content';
$_['text_guest_users']                  = 'Guest Users';
$_['text_default']                      = '<b>(Default)</b>';
$_['text_check_all']                    = 'Check All';
$_['text_uncheck_all']                  = 'Uncheck All';
$_['text_random_products_0']            = 'Display products in a specific order as specified in the product list';
$_['text_random_products_1']            = 'Display products randomly by shuffling the partial list of products controlled by limit';
$_['text_random_products_2']            = 'Display products randomly by shuffling the whole product list';
$_['text_edit']                         = 'Edit Multiple Featured Module Pro';
$_['text_tab_filter_no_result']         = 'Your search did not match any tabs.';
$_['text_general']                      = 'General';

// Entry
$_['entry_name']                        = 'Module Name';
$_['entry_title']                       = 'Title';
$_['entry_title_link']                  = 'Link';
$_['entry_product']                     = 'Products';
$_['entry_incl_dab_prods']              = 'Include disabled products in autocomplete results';
$_['entry_product_list']                = 'Product List';
$_['entry_random_products']             = 'Random Product Display';
$_['entry_disp_oos_prods']              = 'Display out-of-stock products';
$_['entry_stores']                      = 'Stores';
$_['entry_access_levels']               = 'Access Levels';
$_['entry_template']                    = 'Template';
$_['entry_use_default_template']        = 'Use default template';
$_['entry_stylesheet']                  = 'Stylesheet';
$_['entry_use_default_stylesheet']      = 'Use default stylesheet';
$_['entry_javascript']                  = 'JavaScript';
$_['entry_params']                      = 'Parameters';
$_['entry_multi_featured_id']           = 'Featured Content';
$_['entry_limit']                       = 'Limit';
$_['entry_image']                       = 'Image (W x H) and Resize Type';
$_['entry_layout']                      = 'Layout';
$_['entry_position']                    = 'Position';
$_['entry_status']                      = 'Status';
$_['entry_sort_order']                  = 'Sort Order';
$_['entry_filter_tabs']                 = 'Enter a word to filter tabs';
$_['entry_width']                       = 'Image Width';
$_['entry_height']                      = 'Image Height';
$_['entry_cache_expire']                = 'Cache Expiry Time';

// Help
$_['help_name']                         = 'Enter a name for the module.';
$_['help_title']                        = 'Display title in module header.';
$_['help_title_link']                   = 'Creates a link for the title. Leave it blank if you do not want to specify.';
$_['help_product']                      = '(Autocomplete) Enter product name.';
$_['help_product_list']                 = 'Drag and drop to sort the list as necessary.';
$_['help_stores']                       = 'Configure what stores to show the featured products list.';
$_['help_access_levels']                = 'Specify which groups are able to view this content. You can have more control by adding a customer group.';
$_['help_template']                     = 'Determines whether to use the default template. You can create a new template by creating a new template from scratch, or by copying an existing template. The base path points to &#8220;catalog/view/theme/[YOUR_THEME]/template/module/&#8221.';
$_['help_stylesheet']                   = 'Determines whether to use the default stylesheet. You can optionally specify the path to your own CSS files; e.g., &#8220;catalog/view/theme/[THEME]/stylesheet/my-stylesheet.css&#8221. The base path points to your opencart root directory. Use the following tag for the currently selected theme: [THEME]. You can handle multiple files per line.';
$_['help_javascript']                   = 'JavaScript files can be added optionally. Specify the path to the files; e.g., &#8220;catalog/view/theme/[THEME]/javascript/my-javascript.js&#8221. The base path points to your opencart root directory. Use the following tag for the currently selected theme: [THEME]. You can handle multiple files per line.';
$_['help_params']                       = 'Optional parameters can be passed to a tpl template file in the format of key:value. You can access the value by using $params[&#39;key&#39;]. Multiple parameters per line.';
$_['help_cache_expire']                 = 'Use this value to specify the cache expiration time (in seconds) for product display. This defaults to 3600 seconds';

// Tab
$_['tab_featured_product_lists']        = 'Featured Product Lists';
$_['tab_config']                        = 'Configuration';
$_['tab_modules']                       = 'Modules';
$_['tab_layouts']                       = 'Layouts';

// Button
$_['button_save_and_close']             = 'Save &amp; Close';
$_['button_clear_filters']              = 'Clear filters';
$_['button_upgrade']                    = 'Upgrade';

// Error 
$_['error_warning_modules']             = 'Warning: Please check the form carefully for errors on the Modules Tab!';
$_['error_permission']                  = 'Warning: You do not have permission to modify module featured!';
$_['error_image']                       = 'Image width &amp; height dimensions required!';
$_['error_featured_id']                 = 'Featured Content required!';
$_['error_warning_template']            = 'Warning: Template does not exist. Please check for the error given on the tab: <b>%1$s</b> &gt; <b>%2$s</b>';
$_['error_template']                    = 'Template does not exist!';
$_['error_warning_name']                = 'Warning: Module Name must be between 3 and 64 characters! Please check for the error given on the tab: <b>%1$s</b> &gt; <b>%2$s</b>';
$_['error_name']                        = 'Module Name must be between 3 and 64 characters!';
$_['error_width']                       = 'Width required!';
$_['error_height']                      = 'Height required!';

$_['error_warning_multiple']            = 'Warning: Please check for the error given on the tab: <b>%1$s</b> &gt; <b>%2$s</b>';