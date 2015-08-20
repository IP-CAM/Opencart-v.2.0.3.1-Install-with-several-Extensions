<?php

class ModelPaymentInvoicePro extends Model {

	private $name = NULL;

	public function getMethod($address, $total) {

		// SET NAME
		$this->name = basename(__FILE__, '.php');

		// LOAD LANGUAGE
		$this->language->load('payment/' . $this->name);

		// GET GEO ZONES
		$query = $this->db->query("
			SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE
			geo_zone_id = '" . (int)$this->config->get($this->name . '_geo_zone_id') . "' AND
			country_id 	= '" . (int)$address['country_id'] . "' AND
			(zone_id 	= '" . (int)$address['zone_id'] . "' OR
			zone_id 	= '0')"
		);

		// SET DEFAULT CUSTOMER GROUP
		 $customer_group_id = 0;

		// CHECK IF CUSTOMER IS LOGGED
		if ($this->customer->isLogged()) {

			// LOAD MODEL
			$this->load->model('account/customer');

			// GET CUSTOMER DATA
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());

			// GET CUSTOMER GROUP ID FROM DATA
			$customer_group_id = $customer_info['customer_group_id'];

		}
		elseif (isset($this->session->data['guest'])) {

			// GET CUSTOMER GROUP ID FROM SESSION
			$customer_group_id = $this->session->data['guest']['customer_group_id'];

		}

		// STATUS
		$status = true;

		// CHECK IF TOTAL IS MORE THEN MINIMUM
		if ( ($this->config->get($this->name . '_total_min') > 0) && ($this->config->get($this->name . '_total_min') > $total) ) 							{ $status = false; }

		// CHECK IF TOTAL IS MORE THEN MAXIMUM
		if ( ($this->config->get($this->name . '_total_max') > 0) && ($this->config->get($this->name . '_total_max') < $total) ) 							{ $status = false; }

		// CHECK IF GEO ZONE IS SET AND CORRECT
		if ( ($this->config->get($this->name . '_geo_zone_id')) && (!$query->num_rows) )																	{ $status = false; }

		// CHECK IF CUSTOMER GROUP IS SET AND CORRECT
		if ( ($this->config->get($this->name . '_customer_group_id')) && ($this->config->get($this->name . '_customer_group_id') != $customer_group_id) )	{ $status = false; }

		// MAKE ARRAY
		$method_data = array();

		// IF STATUS IS OK
		if ($status) {

			// GET FEE
			$fee = ($this->config->get($this->name . '_fee')) ? $this->config->get($this->name . '_fee') : 0;

			// GET TITLE AND ADD FEE
			$title = sprintf($this->language->get('text_title'), $this->currency->format($this->tax->calculate($fee, $this->config->get($this->name . '_tax_class_id'))));

			// ADD METHOD
			$method_data = array(
				'code'       => $this->name,
				'title'      => $title,
				'terms'      => '',
				'sort_order' => $this->config->get($this->name . '_sort_order')
			);
		}

		// RETURN METHOD
		return $method_data;

	}

}
?>
