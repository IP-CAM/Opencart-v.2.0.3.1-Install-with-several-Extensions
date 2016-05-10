<?php
    // Heading
    $_['heading_title']         = 'DIBS Payment Window';
    $_['text_edit']             = 'Edit DIBS Payment Window';
                                            
    // Text                                     
    $_['text_auto']             = 'Auto';
    $_['text_standard']         = 'DIBS Payment Window';
    $_['text_yes']              = 'yes';
    $_['text_no']               = 'no';
    $_['text_success']          = 'Success: You have modified DIBS account details!';
    $_['text_dempty']           = '-'; 
    $_['text_demail']           = 'Email';
    $_['text_dpaper']           = 'Paper';
    $_['text_payment']          = 'Payment';
    $_['text_da']               = 'Danish';
    $_['text_nl']               = 'Dutch';
    $_['text_en']               = 'English';
    $_['text_fo']               = 'Faroese';
    $_['text_fi']               = 'Finnish';
    $_['text_fr']               = 'French';
    $_['text_de']               = 'German';
    $_['text_it']               = 'Italian';
    $_['text_nor']              = 'Norwegian';
    $_['text_pl']               = 'Polish';
    $_['text_es']               = 'Spanish';
    $_['text_sv']               = 'Swedish';
    $_['text_dibspw']           = '<a onclick="window.open(\'http://dibspayment.com/\');">
                                       <img src="view/image/payment/dibspw.png" alt="DIBS" title="DIBS" style="border: none;" />
                                   </a>';
    $_['text_techsite']         = 'Detailed description of configuration parameters can be found on our <a href="http://tech.dibs.dk" target="_blank">Tech site</a>.';
    // Entry          
    $_['entry_status'] 	        = 'Status:';
    $_['entry_lang'] 	        = 'Language:';
    $_['entry_default_title']   = 'DIBS Payment Window';
    $_['entry_text_title']      = 'Title:';
    $_['entry_testmode']        = 'Testmode:';
    $_['entry_mid']             = 'Merchant ID:';
    
    $_['entry_pid']             = 'Partner ID:';
	
    $_['entry_paytype']         = 'Paytype:';
    $_['entry_default_paytype'] = '';
    $_['entry_fee']          	= 'Add fee:';
    $_['entry_capturenow']      = 'Capture now:';
    $_['entry_sort_order']   	= 'Sort Order:';
    $_['entry_hmac']          	= 'HMAC:';

    $_['entry_account']         = 'Account:';
    $_['entry_distr']        	= 'Distribution type:' .
                                  '<br /><span class="help">' . 
                                      'Only relevant for invoice payment types (DIBS PW only).' .
                                  '</span>';
    $_['entry_order_status_id'] = 'Order Status:';
    $_['entry_geo_zone_id']        = 'Geo Zone:';
    $_['entry_total']           = 'Total:<br /><span class="help">' . 
                                  'The checkout total the order must reach' .
                                  ' before this payment method becomes active.</span>';

    // Error
    $_['error_permission']      = 'Warning: You do not have permission to modify payment DIBS!';
    $_['error_warning']         = 'Warning: Please check the form carefully for errors!';
    $_['error_mid']             = 'Merchant ID Required!'; 
    $_['entry_logo']            = 'DIBS logo:'
                                    .
                                  '<br /><span class="help">' . 
                                  'How to use dibs logos, please read here: <a target="_blank" href="https://github.com/DIBS-Payment-Services/Opencart">https://github.com/DIBS-Payment-Services/Opencart</a> in Readme section '.
                                  '</span>';
    
    
    $_['column_action']         = 'Action';
    $_['column_return_status']  = 'Return status';
    $_['column_date_added']     = 'Date';
    $_['text_refund_amount']    = 'Refund amount';
    $_['button_capture']        = 'Capture';
    $_['text_capture_amount']   = 'Capture amount';
    $_['text_complete_capture'] = 'Capture all amount';
    $_['button_refund']         = 'Refund';
    $_['text_amount_captured']  = 'Captured amount';
    $_['text_amount_refunded']  = 'Refunded amount';
    $_['text_amount_auth']      = 'Authorized amount';
    $_['text_payment_info']     = 'Payment transactions';
    $_['button_void']           = 'Cancel';
    $_['text_confirm_void']     = 'Are you sure, you want to Cacel this transaction ?';
    $_['error_capture_amt']     = 'Incorrect amount';
    $_['column_amount']         = 'Amount';
    $_['text_transactions']     = 'Transactions';
    $_['hmac_is_empty_error']   = 'HMAC code is empty, please fill HMAC code field in Extensions->Payments \'DIBS Payment Window\'';
    $_['transaction_not_exists']= 'Transaction is not exists in table dibs_pw_results';
    $_['entry_card_description']    = 'Card payment description';
    $_['entry_invoice_description'] = 'Invoice payment description';
    $_['entry_card_title']          = 'Card payment ttitle';
    $_['entry_invoice_title']       = 'Invoice payment title';
    $_['entry_invoice_fee']         = 'Invoice fee';
    $_['entry_invoice_terms_lang']  = 'Invoice terms lang SE, NO';
    $_['entry_card_payment_enabled']  = 'Card payment enabled';
    $_['entry_invoice_payment_enabled']  = 'Invoice payment enabled';
    $_['entry_card_paytype']             = 'Card paytypes eg. VISA, MC';
    $_['entry_invoice_paytype']          = 'Invice paytypes eg. paypal, giropay';
    