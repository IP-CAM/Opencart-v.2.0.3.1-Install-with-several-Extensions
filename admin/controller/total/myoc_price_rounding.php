<?php 
class ControllerTotalMyocPriceRounding extends Controller { 
	private $error = array(); 
	 
	public function index() { 
		$this->load->language('total/myoc_price_rounding');

		$this->document->setTitle($this->language->get('common_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			foreach($this->request->post as $key => $value) {
				$this->request->post['myoc_' . $key] = $value;
				unset($this->request->post[$key]);
			}
			$this->request->post['myoc_price_rounding_description'] = serialize($this->request->post['myoc_price_rounding_description']);
			$this->request->post['myoc_price_rounding_rule'] = serialize($this->request->post['myoc_price_rounding_rule']);
			
			$this->model_setting_setting->editSetting('myoc_price_rounding', $this->request->post);
		
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('total/myoc_price_rounding', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['heading_title'] = $this->language->get('common_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_display_difference'] = $this->language->get('text_display_difference');
		$data['text_display_total'] = $this->language->get('text_display_total');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_fixed'] = $this->language->get('text_fixed');
		$data['text_multiple'] = $this->language->get('text_multiple');
		$data['text_roundup'] = $this->language->get('text_roundup');
		$data['text_roundnear'] = $this->language->get('text_roundnear');
		$data['text_rounddown'] = $this->language->get('text_rounddown');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_edit'] = $this->language->get('text_edit');
		
		$data['tab_settings'] = $this->language->get('tab_settings');
		$data['tab_rounding_rules'] = $this->language->get('tab_rounding_rules');
		
		$data['column_store'] = $this->language->get('column_store');
		$data['column_customer_group'] = $this->language->get('column_customer_group');
		$data['column_currency'] = $this->language->get('column_currency');
		$data['column_from'] = $this->language->get('column_from');
		$data['column_to'] = $this->language->get('column_to');
		$data['column_rounding_method'] = $this->language->get('column_rounding_method');
		$data['column_rounding_direction'] = $this->language->get('column_rounding_direction');
		$data['column_rounding_value'] = $this->language->get('column_rounding_value');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_display'] = $this->language->get('entry_display');
		$data['entry_login'] = $this->language->get('entry_login');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
					
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_add_rule'] = $this->language->get('button_add_rule');
		
		$data['myoc_copyright'] = $this->language->get('myoc_copyright');

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} elseif (isset($this->error['rule'])) {
			$data['error_warning'] = $this->error['rule'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = array();
		}

   		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_total'),
			'href'      => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('common_title'),
			'href'      => $this->url->link('total/myoc_price_rounding', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('total/myoc_price_rounding', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('localisation/currency');
		$data['currencies'] = $this->model_localisation_currency->getCurrencies();

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('setting/store');
        $data['stores'] = $this->model_setting_store->getStores();

		$this->load->model('sale/customer_group');		
		$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		

		if (isset($this->request->post['price_rounding_status'])) {
			$data['price_rounding_status'] = $this->request->post['price_rounding_status'];
		} else {
			$data['price_rounding_status'] = $this->config->get('myoc_price_rounding_status');
		}
		
		if (isset($this->request->post['price_rounding_description'])) {
			$data['price_rounding_description'] = $this->request->post['price_rounding_description'];
		} else {
			$data['price_rounding_description'] = @unserialize($this->config->get('myoc_price_rounding_description'));
		}
		
		if (isset($this->request->post['price_rounding_display'])) {
			$data['price_rounding_display'] = $this->request->post['price_rounding_display'];
		} else {
			$data['price_rounding_display'] = $this->config->get('myoc_price_rounding_display');
		}
		
		if (isset($this->request->post['price_rounding_login'])) {
			$data['price_rounding_login'] = $this->request->post['price_rounding_login'];
		} else {
			$data['price_rounding_login'] = $this->config->get('myoc_price_rounding_login');
		}

		if (isset($this->request->post['price_rounding_sort_order'])) {
			$data['price_rounding_sort_order'] = $this->request->post['price_rounding_sort_order'];
		} else {
			$data['price_rounding_sort_order'] = $this->config->get('myoc_price_rounding_sort_order');
		}

		if (isset($this->request->post['price_rounding_rule'])) {
			$data['price_rounding_rule'] = $this->request->post['price_rounding_rule'];
		} else {
			$data['price_rounding_rule'] = @unserialize($this->config->get('myoc_price_rounding_rule'));
		}
																		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
				
		$this->response->setOutput($this->load->view('myoc/price_rounding.tpl', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'total/myoc_price_rounding')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['price_rounding_description'] as $language_id => $value) {
    		if(function_exists('utf8_strlen'))
    		{
	      		if ((utf8_strlen($value['title']) < 1) || (utf8_strlen($value['title']) > 255)) {
	        		$this->error['title'][$language_id] = $this->language->get('error_title');
	      		}
	      	} else {
	      		if ((strlen($value['title']) < 1) || (strlen($value['title']) > 255)) {
	        		$this->error['title'][$language_id] = $this->language->get('error_title');
	      		}
	      	}
    	}

		foreach ($this->request->post['price_rounding_rule'] as $rule) {
			if(!is_numeric($rule['range_from']) || !is_numeric($rule['range_to']) || !is_numeric($rule['nearest']))
			{
				$this->error['rule'] = $this->language->get('error_numeric');
				break;
			}
			if($rule['nearest'] <= 0)
			{
				$this->error['rule'] = $this->language->get('error_nearest');
				break;
			}
		}

		return !$this->error;
	}
}
?>