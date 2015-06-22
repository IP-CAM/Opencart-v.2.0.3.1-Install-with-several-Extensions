<?php
// Text
$_['text_title']				= 'Klarna faktura - Betala inom 14 dagar';
$_['text_terms_fee']			= '<span id="klarna_invoice_toc"></span> (+%s)<script type="text/javascript">var terms = new Klarna.Terms.Invoice({el: \'klarna_invoice_toc\', eid: \'%s\', country: \'%s\', charge: %s});</script>';
$_['text_terms_no_fee']			= '<span id="klarna_invoice_toc"></span><script type="text/javascript">var terms = new Klarna.Terms.Invoice({el: \'klarna_invoice_toc\', eid: \'%s\', country: \'%s\'});</script>';
$_['text_additional']			= 'Klarna Invoice requires some additional information before they can proccess your order.';
$_['text_male']					= 'Man';
$_['text_female']				= 'Kvinna';
$_['text_year']					= 'År';
$_['text_month']				= 'Månad';
$_['text_day']					= 'Dag';
$_['text_comment']				= 'Klarna\'s faktura id: %s. ' . "\n" . '%s/%s: %.4f';

// Entry
$_['entry_gender']         		= 'Kön';
$_['entry_pno']            		= 'Personnummer';
$_['entry_dob']            		= 'Födelsedatum';
$_['entry_phone_no']       		= 'Telefonnummer';
$_['entry_street']         		= 'Adress';
$_['entry_house_no']       		= 'Husnummer';
$_['entry_house_ext']      		= 'Tilläggsuppgifter';
$_['entry_company']        		= 'Organisationsnummer';

// Help
$_['help_pno']					= 'Ange ditt personnummer här.';
$_['help_phone_no']				= 'Ange ditt telefonnummer.';
$_['help_street']				= 'Observera att leverans endast kan ske till den registrerade adressen när du betalar med Klarna.';
$_['help_house_no']				= 'Ange husnummer.';
$_['help_house_ext']			= 'Ange husbeteckning. T.ex. A, B, C';
$_['help_company']				= 'Ange företagets organisationsnummer';

// Error
$_['error_deu_terms']     		= 'Du måste godkänna sekretesspolicy från Klarna';
$_['error_address_match'] 		= 'Leverans och faktureringsadress måste stämma överrens om du vill använda Klarna faktura';
$_['error_network']       		= 'Ett fel uppstod vid anslutning till Klarna. Försök igen senare.';