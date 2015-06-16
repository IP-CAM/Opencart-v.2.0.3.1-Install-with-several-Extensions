<?php
$_['heading_title']                         = 'OpenStock 2 - variant stock control';
$_['text_module']                           = 'Modules';
$_['module_installed']                      = '<p>The OpenStock extension is installed.</p><p>To uninstall: remove the vQmod openstock.xml and openstock_customise.xml files and then click uninstall on modules page.</p>';
$_['module_support']                        = '<p>If you need support, first read the manual that came with the module and also our <a href="http://help.welfordmedia.co.uk/kb/openstock2" title="OpenStock knowledge base" target="_blank">OpenStock knowledge base</a>. If you still need help you must raise a support ticket <a href="http://help.welfordmedia.co.uk/" title="OpenStock Support" target="_BLANK">here</a></p>';
$_['module_export_text']                    = '<p>You can edit the SKU, Stock Level, Weight, Price and Status of existing variants.<br />Adding/removing variants is not supported.</p>';

$_['text_show_default_price']               = 'Show default price';
$_['text_show_special_discount_tab']        = 'Show "Special/Discount" tabs on product edit page';
$_['text_dependant_options']                = 'Use dependant options feature';
$_['text_settings']                         = 'Settings';
$_['text_success']                          = 'Success: You have modified module OpenStock!';
$_['error_permission']                      = 'Warning: You do not have permission to modify module OpenStock!';
$_['error_permission_products']             = 'Warning: You do not have permission to modify products!';

//Defaults
$_['text_defaults']                         = 'Defaults';
$_['text_bulk_defaults_title']              = 'Bulk Create Defaults';
$_['text_default_stock']                    = 'Stock:';
$_['text_default_subtract']                 = 'Subtract:';
$_['text_default_active']                   = 'Active:';
$_['text_default_sku']                      = 'SKU:';
$_['text_default_sku_delimiter']            = 'SKU Delimiter:';
$_['text_default_sku_case']                 = 'SKU Case:';
$_['text_default_sku_space']                = 'SKU Spacing:';

//Help
$_['help_show_default_price']               = 'Show default product\'s price on the product page';
$_['help_show_special_discount_tab']        = 'NOTE: This will NOT change the pricing of your product variants. These specials/discounts should only be used as a label around your site.';
$_['help_dependant_options']                = 'Dependant options will grey out inactive variants. It will also grey out out of stock variants if Stock Checkout is set to "No"';
$_['help_export']                           = 'This exports a CSV file';
$_['help_import']                           = 'Import the modified CSV file';
$_['help_openstock_default_sku']            = 'This is the format of the generated SKU. The delimiter is set below. Each Option Value will also be separated by this delimiter. Choosing blank will ignore the other SKU fields and just enter an empty SKU.';
$_['help_openstock_default_sku_delimiter']  = 'This is the separator between each element of the SKU.';
$_['help_openstock_default_sku_case']       = 'Option to convert the SKU to lowercase/uppercase.';
$_['help_openstock_default_sku_space']      = 'Option to convert the single spaces to alternative character(s).';

// Buttons
$_['button_cancel']                         = 'Return to modules';
$_['button_export']                         = 'Export';
$_['button_import']                         = 'Run Import';
$_['button_save']                           = 'Save';

//Tabs
$_['tab_status']                            = 'Status';
$_['tab_settings']                          = 'Settings';
$_['tab_repair']                            = 'Repair';
$_['tab_export']                            = 'Export';
$_['tab_import']                            = 'Import';
$_['tab_bulk']                              = 'Bulk Create Variants';

//Labels
$_['label_import']                          = 'Import';
$_['status_title']                          = 'Status';
$_['export_title']                          = 'Export Variants';
$_['import_title']                          = 'Import Variants';

$_['text_default_sku_option_0']             = 'Blank';
$_['text_default_sku_option_1']             = '{Product SKU}{Delimiter}{Incremental ID}';
$_['text_default_sku_option_2']             = '{Product Model}{Delimiter}{Incremental ID}';
$_['text_default_sku_option_3']             = '{Product SKU}{Delimiter}{Option Value Combination}';
$_['text_default_sku_option_4']             = '{Product Model}{Delimiter}{Option Value Combination}';

$_['text_default_sku_case_option_0']        = 'Default';
$_['text_default_sku_case_option_1']        = 'Convert to uppercase';
$_['text_default_sku_case_option_2']        = 'Convert to lowercase';
$_['text_sku_example']                      = 'SKU example based on the above options: %s';

$_['openstock_bulk_default_sku']            = 'SKU Format: %s';
$_['openstock_bulk_default_sku_delimiter']  = 'SKU Delimiter: %s';
$_['openstock_bulk_default_sku_case']       = 'SKU Case: %s';
$_['openstock_bulk_default_sku_space']      = 'SKU Spacing: %s';

//Notices - error
$_['notice_error_nofile']                   = 'File must be uploaded';
$_['notice_error_fail']                     = 'File upload failed';
$_['notice_error_notcsv']                   = 'You must upload the CSV file you downloaded';

//Notices - success
$_['notice_success']                        = 'File was uploaded';

$_['option_text_browse']                    = 'Browse';
$_['option_text_clear']                     = 'Clear';

//repair / upgrade
$_['repair_btn']                            = 'Repair';
$_['repair_title']                          = 'Repair / Upgrade';
$_['repair_desc']                           = '<p>If you have recently upgraded OpenStock or have been instructed to repair the tables you can use the button below.</p><p>This will check and repair your database table structure so it is working correctly.</p>';

$_['invalid_permission']                    = 'You don\'t have permissions to edit this module';
$_['lang_option_error']                     = 'Not all of your option groups have a unique sort order, this may cause you errors with products that use the groups.';
$_['lang_option_error_link']                = 'Click here to edit them';

//Bulk Create Variants
$_['text_bulk']                             = 'WARNING: Before using the bulk create variants feature, please take a full backup of your database.';
$_['text_bulk_explain']                     = 'This will modify ALL of your products which have options and that have "Has Options" set to "Yes - Regular".';
$_['text_bulk_defaults']                    = 'It will also use the defaults values set in the Settings tab so make sure these are correct before proceeding.';
$_['label_bulk']                            = 'Create';
$_['label_bulk_preview']                    = 'Preview';

$_['label_result']                          = 'Result: ';
$_['label_time']                            = 'Time Taken: ';
$_['label_variants']                        = 'Number of Variants Created: ';

$_['openstock_bulk_stock']                  = 'Stock: %s';
$_['openstock_bulk_subtract']               = 'Subtract: %s';
$_['openstock_bulk_active']                 = 'Active: %s';
$_['text_bulk_ideal']                       = 'This feature is built for new users of OpenStock that have a lot of option products.';

//Check Problems
$_['text_max_input_vars']                   = 'max_input_vars is currently set to %s. See <a href="%s" target="_blank">here</a> for more information on why this may need to be increased.';
$_['text_option_orders_red']                = 'Not all of your option groups have a unique sort order, this may cause you errors with products that use the groups. Click <a href="%s">here</a> to manually change these or click <button type="button" onclick="bulk_options();" id="button-bulk-options" class="btn btn-primary"><i class="fa fa-wrench"></i> here</button> to bulk change these.';
$_['text_custom_theme_orange']              = 'Using a custom theme may break OpenStock. See <a href="%s" target="_blank">here</a> for more information. If you have had your theme custom patched, please ignore this message.';
$_['text_vqmod_red']                        = 'vQmod needs to be installed to use OpenStock! See <a href="%s" target="_blank">here</a> for more information.';
$_['error_permission_options']              = 'Warning: You do not have permission to modify modify options!';

$_['text_checking_option_values']           = 'You cannot delete Options Values that are currently assigned to products. <br />';

$_['error_duplicate_sku_post']              = 'Duplicate SKUs used below. All SKUs must be unique.';
$_['error_duplicate_sku_db']                = 'SKU is already used in Product ID: %s. Please choose an alternative.';
$_['error_sku_length']                      = 'SKU must be greater than 1 and less than 50 characters!';