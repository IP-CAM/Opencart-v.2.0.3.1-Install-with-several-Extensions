<?php

class ControllerPaymentPostforskott extends Controller {

	private $error 		= array();
	private $name 		= NULL;

	public function index() {

		// SET NAME
		$this->name = basename(__FILE__, '.php');

		// LOAD LANGUAGE
		$this->load->language('payment/' . $this->name);

		// SET META TITLE
		$this->document->setTitle($this->language->get('heading_title'));

		// LOAD SETTINGS
		$this->load->model('setting/setting');

		// IF POST
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			// SAVE SETTINGS
			$this->model_setting_setting->editSetting($this->name, $this->request->post);

			// SET SUCCESS MSG
			$this->session->data['success'] = $this->language->get('text_success');

			// REDIRECT TO MODULE LIST
			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));

		}

		// SET TITLE
		$data['heading_title'] 				= $this->language->get('heading_title');

		// SET TEXTS
		$data['text_edit'] 					= $this->language->get('text_edit');
		$data['text_enabled'] 				= $this->language->get('text_enabled');
		$data['text_disabled'] 				= $this->language->get('text_disabled');
		$data['text_all_zones'] 			= $this->language->get('text_all_zones');
		$data['text_none'] 					= $this->language->get('text_none');
		$data['text_select_all'] 			= $this->language->get('text_select_all');

		$data['entry_order_status'] 		= $this->language->get('entry_order_status');
		$data['entry_total_min'] 			= $this->language->get('entry_total_min');
		$data['entry_total_max'] 			= $this->language->get('entry_total_max');
		$data['entry_fee'] 					= $this->language->get('entry_fee');
		$data['entry_tax_class'] 			= $this->language->get('entry_tax_class');
		$data['entry_customer_group'] 		= $this->language->get('entry_customer_group');
		$data['entry_geo_zone'] 			= $this->language->get('entry_geo_zone');
		$data['entry_status'] 				= $this->language->get('entry_status');
		$data['entry_sort_order'] 			= $this->language->get('entry_sort_order');

		$data['help_total_min'] 			= $this->language->get('help_total_min');
		$data['help_total_max'] 			= $this->language->get('help_total_max');

		$data['tab_settings'] 				= $this->language->get('tab_settings');

		$data['button_save'] 				= $this->language->get('button_save');
		$data['button_cancel'] 				= $this->language->get('button_cancel');

		if (isset($this->error['warning'])) 	{ $data['error_warning'] = $this->error['warning']; }
		else 									{ $data['error_warning'] = ''; }

		// BREABCRUMBS
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('payment/' . $this->name, 'token=' . $this->session->data['token'], 'SSL')
		);

		// SET ACTION URL
		$data['action'] = $this->url->link('payment/' . $this->name, 'token=' . $this->session->data['token'], 'SSL');

		// SET CANCLE URL
		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		// LOAD MODEL AND GET ORDER STATUS
		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		// LOAD MODEL AND GET GEO ZONES
		$this->load->model('localisation/geo_zone');
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		// LOAD MODEL AND GET TAX CLASESS
		$this->load->model('localisation/tax_class');
		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		// LOAD CUSTOMER GROUP MODEL
		if ((float)VERSION>=2.1) 	{ $this->load->model('customer/customer_group'); }
		else 						{ $this->load->model('sale/customer_group'); }

		// ADD CUSTOMER GROUPS TO DATA
		if ((float)VERSION>=2.1) 	{ $data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups(); }
		else 						{ $data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups(); }

		// ADD FIELDS
		$fields = array(
			'total_min'				=> '0.01',
			'total_max'				=> '0',
			'fee'					=> '0',
			'tax_class_id'			=> '0',
			'customer_group_id'		=> '0',
			'geo_zone_id'			=> '0',
			'order_status_id'		=> $this->config->get('config_order_status_id'),
			'status'				=> '1',
			'sort_order'			=> '1',
		);

		// LOOP FIELDS
		foreach ($fields as $field => $default) {
			if     (isset($this->request->post[$this->name.'_'.$field])) 	{ $data[$this->name.'_'.$field] = $this->request->post[$this->name.'_'.$field]; }
			elseif ($this->config->has($this->name.'_'.$field)) 			{ $data[$this->name.'_'.$field] = $this->config->get($this->name.'_'.$field); }
			else 															{ $data[$this->name.'_'.$field] = $default; }
		}

		// LOAD COMMON CONTROLLERS
		$data['header'] 			= $this->load->controller('common/header');
		$data['column_left'] 		= $this->load->controller('common/column_left');
		$data['footer'] 			= $this->load->controller('common/footer');

		// SET OUTPUT
		$this->response->setOutput($this->load->view('payment/' . $this->name . '.tpl', $data));

	}

	protected function validate() {

		// CHECK PERMISSION
		if (!$this->user->hasPermission('modify', 'payment/' . $this->name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		// RETURN
		return !$this->error;

	}

}

?>
