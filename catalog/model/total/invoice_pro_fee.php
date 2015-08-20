<?php

class ModelTotalInvoiceProFee extends Model {

	private $error 	= array();
	private $name 	= NULL;
	private $pname 	= NULL;

	public function getTotal(&$total_data, &$total, &$taxes) {

		// SET NAME
		$this->name  = basename(__FILE__, '.php');
		$this->pname = str_replace('_fee', '', basename(__FILE__, '.php'));

		// IS ACTIVE?
		if (!$this->config->get($this->name . '_status')) { return false; }

		// LOAD LANGUAGE
		$this->language->load('total/' . $this->name);

		// IF PARENT IS SELECTED
		if ( (!isset($this->session->data['payment_method']['code'])) OR ($this->session->data['payment_method']['code'] != $this->pname) ) { return false; }

		// CHECK IF FEE IS SET
		if ( ($this->cart->getSubTotal()) AND ($this->config->get($this->pname . '_fee') > 0) ) {

			// MAKE ARRAY WITH DATA
			$total_data[] = array(
				'code'       => $this->name,
				'title'      => $this->language->get('text_' . $this->name),
				'value'      => $this->config->get($this->pname . '_fee'),
				'sort_order' => $this->config->get($this->name  . '_sort_order')
			);

			// CHECK IF CLASS TAX IS SET
			if ($this->config->get($this->pname . '_tax_class_id')) {

				// GET RATES
				$tax_rates = $this->tax->getRates($this->config->get($this->pname . '_fee'), $this->config->get($this->pname . '_tax_class_id'));

				// LOOP RATES
				foreach ($tax_rates as $tax_rate) {
					if (!isset($taxes[$tax_rate['tax_rate_id']])) 	{ $taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount']; }
					else 											{ $taxes[$tax_rate['tax_rate_id']] += $tax_rate['amount']; }
				}

			}

			// ADD FEE TO TOTAL
			$total += $this->config->get($this->pname . '_fee');

		}

	}

}
