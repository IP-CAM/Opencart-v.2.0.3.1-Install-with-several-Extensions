<?php

class ControllerPaymentPostforskott extends Controller {

	private $name = NULL;

	public function index() {

		// SET NAME
		$this->name = basename(__FILE__, '.php');

		// LOAD LANGUAGE
		$this->language->load('payment/' . $this->name);

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
