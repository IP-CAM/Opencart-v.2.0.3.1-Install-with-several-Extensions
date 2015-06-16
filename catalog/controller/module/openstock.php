<?php
class ControllerModuleOpenstock extends Controller {
	public function option() {
		$this->load->model('module/openstock');
		$json = array();

		$show = array();
		$options = array();
		$hide = array();

		foreach ($this->request->post['option'] as $product_option_id => $product_option_value_id) {
			if ($product_option_value_id != '') {
				$show[$product_option_value_id] = $product_option_value_id;
				$options[$product_option_id] = $product_option_value_id;
				$product_option_values = $this->db->query("SELECT `product_option_value_id` FROM " . DB_PREFIX . "product_option_value WHERE `product_option_id` = '" . (int)$product_option_id . "' AND `product_option_value_id` != '" . (int)$product_option_value_id . "'")->rows;
				foreach ($product_option_values as $product_option_value) {
					$hide[$product_option_value['product_option_value_id']] = $product_option_value['product_option_value_id'];
				}
			}
		}

		$product_variants = $this->model_module_openstock->getVariants($this->request->post['product_id']);

		$variants = array();
		foreach ($product_variants as $product_variant) {
			$variants[$product_variant['product_option_variant_id']] = array();

			foreach ($product_variant['variant_values'] as $variant_value) {
				if (!$product_variant['active']) {
					$available = false;
				} elseif ($product_variant['stock'] <= 0 && !$this->config->get('config_stock_checkout')) {
					$available = false;
				} else {
					$available = true;
				}

				$variants[$product_variant['product_option_variant_id']]['available'] = $available;
				$variants[$product_variant['product_option_variant_id']]['values'][] = $variant_value['product_option_value_id'];
			}
		}

		foreach ($variants as $variant) {
			if (!array_diff($options, $variant['values'])) {
				foreach ($variant['values'] as $variant_value) {
					if ($variant['available']) {
						$show[$variant_value] = $variant_value;
					}
				}
			}
		}

		foreach ($variants as $variant) {
			foreach ($variant['values'] as $variant_value) {
				if (!$variant['available'] && !in_array($variant_value, $show)) {
					$hide[$variant_value] = $variant_value;
				}
			}
		}

		$json['show'] = array_values($show);
		$json['hide'] = array_values($hide);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function variant() {
		$this->language->load('module/openstock');

		$json = array();

		if (!$this->request->post['ids'] || !$this->request->post['product_id']) {
			$json['error'] = $this->language->get('text_id_missing');
		} else {
			$this->load->model('module/openstock');
			$this->load->model('catalog/product');
			$this->load->model('tool/image');

			$product = $this->model_catalog_product->getProduct($this->request->post['product_id']);
			$variant = $this->model_module_openstock->getVariantByOptionValues($this->request->post['ids'], $this->request->post['product_id']);

			if ($variant) {
				$discounts = $this->model_module_openstock->getVariantDiscounts($this->request->post['product_id'], $variant['product_option_variant_id']);

				if ($discounts) {
					$variant['discount'] = array();

					foreach ($discounts as $discount) {
						$variant['discount'][] = array(
							'quantity' => $discount['quantity'],
							'price' => $this->currency->format($this->tax->calculate($discount['price'], $product['tax_class_id'], $this->config->get('config_tax')))
						);
					}
				}

				$special = $this->model_module_openstock->getVariantSpecial($this->request->post['product_id'], $variant['product_option_variant_id']);

				if ($special) {
					$variant['special'] = $this->currency->format($this->tax->calculate($special['price'], $product['tax_class_id'], $this->config->get('config_tax')));
				}

				$variant['tax'] = $this->currency->format($special ? $special['price'] : $variant['price']);

				$variant['price'] = $this->currency->format($this->tax->calculate($variant['price'], $product['tax_class_id'], $this->config->get('config_tax')));

				if ($variant['image']) {
					$variant['pop'] = $this->model_tool_image->resize($variant['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
					$variant['thumb'] = $this->model_tool_image->resize($variant['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
				} else {
					$variant['pop'] = '';
					$variant['thumb'] = '';
				}

				$json['data'] = $variant;

				if (($variant['stock'] > 0 || $variant['subtract'] == 0) && $variant['active'] == 1) {
					if ($variant['subtract'] == 0 || $this->config->get('config_stock_display') == 0) {
						$json['success'] = $this->language->get('text_in_stock_avail');
					} else {
						$json['success'] = sprintf($this->language->get('text_in_stock'), $variant['stock']);
					}
				} elseif ($variant['active'] != 1) {
					$json['notactive'] = $this->language->get('combination_not_avail');
				} else {
					$json['nostockcheckout'] = $this->config->get('config_stock_checkout');
					$json['nostock'] = $product['stock_status'];
				}
			} else {
				$json['error'] = $this->language->get('combination_not_avail');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

}

?>