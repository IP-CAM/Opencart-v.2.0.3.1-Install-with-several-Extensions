<?php
ini_set('memory_limit', '124M');
#set_time_limit(0);
class ControllerSeoPowerPackCustomUrls extends Controller {

	public function index() {
		$this->load->language('seo_power_pack/settings');
		$this->load->model('setting/setting');
		$this->load->model('seo_power_pack/seo_urls');

		$filter_fields = array(
			'page'           => 1,
			'limit'          => $this->config->get('config_limit_admin'),
			'language_id'    => $this->config->get('config_language_id'),
			'sort'           => 'ua.keyword',
			'order'          => 'ASC',
			'filter_keyword' => '',
			'filter_params'  => '',
			'tab_container'  => '',
		);

		if (!isset($this->request->get['language_id'])) {
			$this->request->get['language_id'] = 0;
		}

		$url    = array();
		$ob_url = array();
		foreach ($filter_fields as $field_name => $field_default) {
			if (isset($this->request->get[$field_name])) {
				$data[$field_name] = $this->request->get[$field_name];
			} else {
				$data[$field_name] = $field_default;
			}

			if (!empty($data[$field_name])) {
				if ($field_name != 'page') {
					$url[] = $field_name . '=' . $data[$field_name];

					if ($field_name != 'sort' && $field_name != 'order') {
						$ob_url[] = $field_name . '=' . $data[$field_name];
					}
				}
			}
		}

		$url[]    = 'token=' . $this->session->data['token'];
		$ob_url[] = 'token=' . $this->session->data['token'];

		$data['paging_url'] = 'index.php?route=seo_power_pack/custom_urls&' . implode('&', $url);
		$data['ob_url']     = 'index.php?route=seo_power_pack/custom_urls&' . implode('&', $ob_url);

		$filter_data = array(
			'filter_keyword' => $data['filter_keyword'],
			'filter_params'  => $data['filter_params'],
			'sort'           => $data['sort'],
			'order'          => $data['order'],
			'start'          => ($data['page'] - 1) * $data['limit'],
			'limit'          => $data['limit'],
		);

		$data['total'] = $this->model_seo_power_pack_seo_urls->getTotalCustomUrls($filter_data, $data['language_id']);

		$results = $this->model_seo_power_pack_seo_urls->getCustomUrls($filter_data, $data['language_id']);

		foreach ($results as $result) {
			$data['custom_urls'][] = array(
				'url_alias_id' => $result['url_alias_id'],
				'query'        => $result['query'],
				'keyword'      => $result['keyword'],
				'language_id'  => $result['language_id'],
			);
		}

		$data['token'] = $this->session->data['token'];

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}

	function addnew() {
		if (!$this->__hasPermission()) {
			exit;
		}
		$this->load->model('seo_power_pack/seo_urls');

		$inserted = 0;
		if (isset($this->request->post['new_route']) && isset($this->request->post['new_seo_keyword'])) {
			foreach ($this->request->post['new_seo_keyword'] as $language_id => $seo_keyword) {
				$inserted += $this->model_seo_power_pack_seo_urls->addNewUrlAlias(
					$this->request->post['new_route'],
					$seo_keyword,
					$language_id
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');

		if (intval($inserted) > 0) {
			$this->response->setOutput(json_encode(array('success' => ($inserted > 0))));
		} else {
			$this->response->setOutput(json_encode(array('error' => 'Record already exists')));
		}

	}

	function update() {
		if (!$this->__hasPermission()) {
			exit;
		}
		$this->load->model('seo_power_pack/seo_urls');

		if (isset($this->request->get['fn'])) {
			switch ($this->request->get['fn']) {
				case 'cua_keyword':
				case 'dua_keyword':
					$this->model_seo_power_pack_seo_urls->updateUrlAlias(
						$this->request->get['url_alias_id'],
						$this->request->get['fv']
					);
					break;
				default:
					# code...
					break;
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode(array('success' => 1)));
	}

	function delete() {
		if (!$this->__hasPermission()) {
			exit;
		}
		$this->load->model('seo_power_pack/seo_urls');
		$this->model_seo_power_pack_seo_urls->deleteUrlAlias(
			$this->request->get['url_alias_id']
		);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode(array('success' => 1)));
	}

	function get_ua() {
		$this->load->model('seo_power_pack/seo_urls');
		$this->load->model('seo_power_pack/settings');

		$data['languages'] = $this->model_seo_power_pack_settings->getActiveLanguages();

		$data['url_alias'] = $this->model_seo_power_pack_seo_urls->getUrlAliasById(
			$this->request->get['url_alias_id']
		);

		foreach ($data['languages'] as $language) {
			$data['records'][$language['language_id']] = $this->model_seo_power_pack_seo_urls->getUrlAliasByQuery(
				$data['url_alias']['query'],
				$language['language_id']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}

	function update_ua() {
		if (!$this->__hasPermission()) {
			exit;
		}
		if (isset($this->request->post['uef_url_alias_id']) && intval($this->request->post['uef_url_alias_id']) > 0) {
			$this->load->model('seo_power_pack/seo_urls');
			$this->load->model('seo_power_pack/settings');

			$data['languages'] = $this->model_seo_power_pack_settings->getActiveLanguages();

			$data['url_alias'] = $this->model_seo_power_pack_seo_urls->getUrlAliasById(
				$this->request->post['uef_url_alias_id']
			);

			$this->model_seo_power_pack_seo_urls->deleteUrlAliasByQuery(
				$data['url_alias']['query']
			);

			foreach ($data['languages'] as $language) {
				$this->model_seo_power_pack_seo_urls->addNewUrlAlias(
					$data['url_alias']['query'],
					trim($this->request->post['uef_url_alias_lang_' . $language['language_id']]),
					$language['language_id']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode(array('success' => 1)));
	}

	private function __hasPermission() {
		if (!$this->user->hasPermission('modify', 'seo_power_pack/custom_urls')) {
			return false;
		}
		return true;
	}
}