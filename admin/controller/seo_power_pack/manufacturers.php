<?php
ini_set('memory_limit', '124M');
set_time_limit(0);
class ControllerSeoPowerPackManufacturers extends Controller {

	public function index() {
		$this->load->language('seo_power_pack/settings');
		$this->load->model('setting/setting');
		$this->load->model('seo_power_pack/manufacturers');

		$filter_fields = array(
			'page'          => 1,
			'limit'         => $this->config->get('config_limit_admin'),
			'language_id'   => $this->config->get('config_language_id'),
			'sort'          => 'm.name',
			'order'         => 'ASC',
			'filter_name'   => '',
			'tab_container' => '',
		);

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

		$data['paging_url'] = 'index.php?route=seo_power_pack/manufacturers&' . implode('&', $url);
		$data['ob_url']     = 'index.php?route=seo_power_pack/manufacturers&' . implode('&', $ob_url);

		$filter_data = array(
			'filter_name' => $data['filter_name'],
			'sort'        => $data['sort'],
			'order'       => $data['order'],
			'start'       => ($data['page'] - 1) * $data['limit'],
			'limit'       => $data['limit'],
		);

		$data['total'] = $this->model_seo_power_pack_manufacturers->getTotalManufacturers($filter_data);

		$results = $this->model_seo_power_pack_manufacturers->getManufacturers($filter_data);

		foreach ($results as $result) {
			$data['manufacturers'][] = array(
				'manufacturer_id' => $result['manufacturer_id'],
				'name'            => $result['name'],
				'seo_keyword'     => $this->model_seo_power_pack_manufacturers->getUrlAlias($result['manufacturer_id']),
			);
		}

		$data['token'] = $this->session->data['token'];

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}

	function update() {
		if (!$this->__hasPermission()) {
			exit;
		}

		$this->load->model('seo_power_pack/settings');

		if (isset($this->request->get['fn'])) {
			$value_arr[$this->request->get['language_id']] = trim($this->request->get['fv']);
			switch ($this->request->get['fn']) {
				case 'man_name':
					$this->model_seo_power_pack_settings->updateManufacturerName(
						$this->request->get['manufacturer_id'],
						$this->request->get['fv']
					);
					break;
				case 'man_seo':
					$this->model_seo_power_pack_settings->addManufacturerSEOUrl(
						$this->request->get['manufacturer_id'],
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

	private function __hasPermission() {
		if (!$this->user->hasPermission('modify', 'seo_power_pack/manufacturers')) {
			return false;
		}
		return true;
	}
}