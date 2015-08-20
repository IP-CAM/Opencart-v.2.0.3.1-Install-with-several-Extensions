<?php

class ControllerPaymentInvoicePro extends Controller {

	private $name = NULL;

	public function index() {

		// SET NAME
		$this->name = basename(__FILE__, '.php');

		// LOAD LANGUAGE
		$this->language->load('payment/' . $this->name);

		// GET STATUS FOR SSN
		$data['ssn_status'] 			= $this->config->get($this->name . '_ssn');

		// GET REG EXP
		$data['reg_exp'] 				= $this->config->get($this->name . '_reg_exp');

		// GET STATUS FOR DESCRIPTION
		$data['description_status'] 	= $this->config->get($this->name . '_description_status');

		// ADD TEXT FOR SSN
		$data['entry_ssn'] 				= $this->language->get('entry_ssn');

		// ADD TEXT FOR SSN ERROR MESSAGE
		$data['error_ssn'] 				= $this->language->get('error_ssn');

		// ADD TEXT FOR DESCRIPTION
		$data['text_description'] 		= $this->language->get('text_description');

		// ADD TEXT FOR BUTTON
		$data['button_confirm'] 		= $this->language->get('button_confirm');

		// ADD ACTION FOR SUCCESS
		$data['continue'] 				= $this->url->link('checkout/success');

		// LOAD TEMPLATE
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/' . $this->name . '.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/' . $this->name . '.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/' . $this->name . '.tpl', $data);
		}

	}

	public function confirm() {

		// SET NAME
		$this->name = basename(__FILE__, '.php');

		// CHECK IF METHOD IS CORRECT
		if ($this->session->data['payment_method']['code'] == $this->name) {

			// LOAD MODEL
			$this->load->model('checkout/order');

			// CONFIRM ORDER
			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get($this->name . '_order_status_id'));

		}

	}

}

?>
