<?php
class ControllerSeoPowerPackAdvanced extends Controller {
	var $catalog_url;

	public function index() {

	}

	public function save_setting() {
		$result = array();

		if ($this->__hasPermission()) {

			$this->load->model('setting/setting');

			if ($this->request->get['dkey'] == 'google_analytics') {
				$this->model_setting_setting->editSettingValue('config', 'config_google_analytics', $this->request->post[$this->request->get['dkey']]['code']);

				if (isset($this->request->post[$this->request->get['dkey']]['status'])) {
					$this->model_setting_setting->editSettingValue('config', 'config_google_analytics_status', '1');
				} else {
					$this->model_setting_setting->editSettingValue('config', 'config_google_analytics_status', '0');
				}

			}

			$this->model_setting_setting->editSetting(
				'seo_pp_' . $this->request->get['data'],
				array(
					'seo_pp_' . $this->request->get['data'] => $this->request->post[$this->request->get['dkey']],
				)
			);

			$result = array('success' => 1);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($result));
	}

	private function __hasPermission() {
		if (!$this->user->hasPermission('modify', 'seo_power_pack/advanced')) {
			return false;
		}
		return true;
	}
}