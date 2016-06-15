<?php
class ControllerModuleCustomFooter extends Controller {
	private $error = array();

	public function index() {
		$data = $this->load->language('module/custom_footer');

		$this->document->setTitle($this->language->get('document_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('custom_footer', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->document->addStyle('view/javascript/colorpicker/css/bootstrap-colorpicker.min.css');
		$this->document->addScript('view/javascript/colorpicker/js/bootstrap-colorpicker.min.js');

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/custom_footer', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('module/custom_footer', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['custom_footer'])) {
			$data['custom_footer'] = $this->request->post['custom_footer'];
		} else {
			$data['custom_footer'] = $this->config->get('custom_footer');
		} 
		
		$data['catalog_url'] = HTTP_CATALOG;
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/custom_footer.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/custom_footer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}