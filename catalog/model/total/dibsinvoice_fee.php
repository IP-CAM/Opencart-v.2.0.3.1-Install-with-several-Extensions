<?php
class ModelTotalDibsinvoiceFee extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
        if(isset($this->session->data['payment_method']['code']) 
                && $this->session->data['payment_method']['code']  == 'dibspw') {
                        
                    if( isset($this->session->data['payment_method']['dibspw_paytype']) 
                            && $this->session->data['payment_method']['dibspw_paytype'] == 'invoice' ) {
                            
                        if($this->config->get('dibspw_invoice_fee')) {
                            
                            $title = 'DIBS Invoice Fee';
                            
                            if($_SESSION['currency'] == 'SEK') {
                                $title = 'Fakturaavgift';
                            }
                            
                            if( $_SESSION['currency'] == 'NOK' ) {
                                $title = 'Fakturagebyr';
                            }
                            
                            $total_data[] = array(
                                    'code'       => 'dibsinvoice_fee',
                                    'title'      => $title,
                                    'text'       => $this->format($this->config->get('dibspw_invoice_fee')),
                                    'value'      => $this->config->get('dibspw_invoice_fee')/$this->currency->getValue(),
                                    'sort_order' => 4
                            );
                            $total += $this->config->get('dibspw_invoice_fee') / $this->currency->getValue();

                      }
                    }
                        
            }
               
	}
        
        
        public function format($number, $currency = '', $value = '', $format = true) {
                $symbol_left   = $this->currency->getSymbolLeft();
		$symbol_right  = $this->currency->getSymbolRight();
		$decimal_place = $this->currency->getDecimalPlace();

		$value = $number;

		$string = '';

		if (($symbol_left) && ($format)) {
			$string .= $symbol_left;
		}

		if ($format) {
			$decimal_point = $this->language->get('decimal_point');
		} else {
			$decimal_point = '.';
		}

		if ($format) {
			$thousand_point = $this->language->get('thousand_point');
		} else {
			$thousand_point = '';
		}

		$string .= number_format(round($value, (int)$decimal_place), (int)$decimal_place, $decimal_point, $thousand_point);

		if (($symbol_right) && ($format)) {
			$string .= $symbol_right;
		}

		return $string;
	}
}
?>