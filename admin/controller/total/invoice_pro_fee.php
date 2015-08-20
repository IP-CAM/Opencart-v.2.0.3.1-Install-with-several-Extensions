<?php

class ControllerTotalInvoiceProFee extends Controller {

	private $error 		= array();
	private $name 		= NULL;

	public function index() {

		// SET NAME
		$this->name = basename(__FILE__, '.php');

		// LOAD LANGUAGE
		$this->load->language('total/' . $this->name);

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
			$this->response->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));

		}

		$data['heading_title'] 			= $this->language->get('heading_title');

		$data['text_edit'] 				= $this->language->get('text_edit');
		$data['text_enabled'] 			= $this->language->get('text_enabled');
		$data['text_disabled'] 			= $this->language->get('text_disabled');

		$data['entry_status'] 			= $this->language->get('entry_status');
		$data['entry_sort_order'] 		= $this->language->get('entry_sort_order');

		$data['tab_settings'] 				= $this->language->get('tab_settings');

		$data['button_save'] 			= $this->language->get('button_save');
		$data['button_cancel'] 			= $this->language->get('button_cancel');

		if (isset($this->error['warning'])) 	{ $data['error_warning'] = $this->error['warning']; }
		else 									{ $data['error_warning'] = ''; }

		// BREABCRUMBS
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_total'),
			'href' => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('total/' . $this->name, 'token=' . $this->session->data['token'], 'SSL')
		);

		// SET ACTION URL
		$data['action'] = $this->url->link('total/' . $this->name, 'token=' . $this->session->data['token'], 'SSL');

		// SET CANCLE URL
		$data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

		// ADD FIELDS
		$fields = array(
			'status'				=> '1',
			'sort_order'			=> '3',
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
		$this->response->setOutput($this->load->view('total/' . $this->name . '.tpl', $data));

	}

	protected function validate() {

		// CHECK PERMISSION
		if (!$this->user->hasPermission('modify', 'total/' . $this->name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		// RETURN
		return !$this->error;

	}

}
