<?php
class ModelPaymentCOD extends Model {
	public function getMethod($address, $total) {
		$this->load->language('payment/cod');

      $codFee = 0;
      if (($this->cart->getSubTotal() < $this->config->get('cod_fee_total')) && ($this->cart->getSubTotal() > 0)) {
        $codFee = trim($this->config->get('cod_fee_fee'));
        $percent = FALSE;
        if (substr($codFee, -1) === '%') {
          $codFee = $this->cart->getSubTotal() * (substr($codFee, 0, -1) / 100);
          $percent = TRUE;
        }
      }
      $text = $this->currency->format($this->tax->calculate($codFee, $this->config->get('cod_fee_tax_class_id'), $this->config->get('config_tax')));

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('cod_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('cod_total') > 0 && $this->config->get('cod_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('cod_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'cod',
				'title'      => sprintf($this->language->get('text_title'), $text),
				'terms'      => '',
				'sort_order' => $this->config->get('cod_sort_order')
			);
		}

		return $method_data;
	}
}