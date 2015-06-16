<?php
class ControllerModuleOpenstock extends Controller {
    private $error = array();

    public function index() {
        $this->load->model('module/openstock');

        $data = array_merge(array(), $this->load->language('module/openstock'));

        $this->document->setTitle($data['heading_title']);

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('openstock', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

        if (isset($this->session->data['error'])) {
            $data['error'] = $this->session->data['error'];
            unset($this->session->data['error']);
        } else {
            $data['error'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('module/openstock', 'token=' . $this->session->data['token'], 'SSL'),
        );

        $data['token']          = $this->session->data['token'];
        $data['cancel']         = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        $data['export']         = $this->url->link('module/openstock/export', 'token=' . $this->session->data['token'], 'SSL');
        $data['import']         = $this->url->link('module/openstock/import', 'token=' . $this->session->data['token'], 'SSL');
        $data['option_link']    = $this->url->link('catalog/option', 'token=' . $this->session->data['token'], 'SSL');
        $data['knowledge_base'] = 'http://help.welfordmedia.co.uk/kb/openstock';

        $data['problems']       = $this->model_module_openstock->checkProblems();

        $data['action'] = $this->url->link('module/openstock', 'token=' . $this->session->data['token'], 'SSL');
        $data['openstock_show_default_price'] = $this->config->get('openstock_show_default_price');
        $data['openstock_show_special_discount_tab'] = $this->config->get('openstock_show_special_discount_tab');
        $data['openstock_dependant_options'] = $this->config->get('openstock_dependant_options');

		if (isset($this->request->post['openstock_default_stock'])) {
			$data['openstock_default_stock'] = $this->request->post['openstock_default_stock'];
		} elseif ($this->config->get('openstock_default_stock')) {
			$data['openstock_default_stock'] = $this->config->get('openstock_default_stock');
		} else {
            $data['openstock_default_stock'] = '0';
        }

		if (isset($this->request->post['openstock_default_subtract'])) {
      		$data['openstock_default_subtract'] = $this->request->post['openstock_default_subtract'];
    	} else {
      		$data['openstock_default_subtract'] = $this->config->get('openstock_default_subtract');
    	}

		if (isset($this->request->post['openstock_default_active'])) {
      		$data['openstock_default_active'] = $this->request->post['openstock_default_active'];
    	} else {
      		$data['openstock_default_active'] = $this->config->get('openstock_default_active');
    	}

		if (isset($this->request->post['openstock_default_sku'])) {
      		$data['openstock_default_sku'] = $this->request->post['openstock_default_sku'];
    	} else {
      		$data['openstock_default_sku'] = $this->config->get('openstock_default_sku');
    	}

        $data['openstock_default_sku_options'] = array();
        $data['openstock_default_sku_options']['blank']             = $this->language->get('text_default_sku_option_0');
        $data['openstock_default_sku_options']['sku_increment']     = $this->language->get('text_default_sku_option_1');
        $data['openstock_default_sku_options']['model_increment']   = $this->language->get('text_default_sku_option_2');
        $data['openstock_default_sku_options']['sku_combination']   = $this->language->get('text_default_sku_option_3');
        $data['openstock_default_sku_options']['model_combination'] = $this->language->get('text_default_sku_option_4');

		if (isset($this->request->post['openstock_default_sku_delimiter'])) {
      		$data['openstock_default_sku_delimiter'] = $this->request->post['openstock_default_sku_delimiter'];
    	} else {
      		$data['openstock_default_sku_delimiter'] = $this->config->get('openstock_default_sku_delimiter');
    	}

		if (isset($this->request->post['openstock_default_sku_case'])) {
      		$data['openstock_default_sku_case'] = $this->request->post['openstock_default_sku_case'];
    	} else {
      		$data['openstock_default_sku_case'] = $this->config->get('openstock_default_sku_case');
    	}

        $data['openstock_default_sku_case_options'] = array();
        $data['openstock_default_sku_case_options']['default']   = $this->language->get('text_default_sku_case_option_0');
        $data['openstock_default_sku_case_options']['uppercase'] = $this->language->get('text_default_sku_case_option_1');
        $data['openstock_default_sku_case_options']['lowercase'] = $this->language->get('text_default_sku_case_option_2');

		if (isset($this->request->post['openstock_default_sku_space'])) {
      		$data['openstock_default_sku_space'] = $this->request->post['openstock_default_sku_space'];
    	} else {
      		$data['openstock_default_sku_space'] = $this->config->get('openstock_default_sku_space');
    	}

        $data['openstock_bulk_stock'] = sprintf($this->language->get('openstock_bulk_stock'), $this->config->get('openstock_default_stock'));

        if ($this->config->get('openstock_default_subtract') == '0') {
            $data['openstock_bulk_subtract'] = sprintf($this->language->get('openstock_bulk_subtract'), $this->language->get('text_no'));
        } else {
            $data['openstock_bulk_subtract'] = sprintf($this->language->get('openstock_bulk_subtract'), $this->language->get('text_yes'));
        }

        if ($this->config->get('openstock_default_active') == '0') {
            $data['openstock_bulk_active'] = sprintf($this->language->get('openstock_bulk_active'), $this->language->get('text_no'));
        } else {
            $data['openstock_bulk_active'] = sprintf($this->language->get('openstock_bulk_active'), $this->language->get('text_yes'));
        }

        $data['openstock_bulk_default_sku'] = sprintf($this->language->get('openstock_bulk_default_sku'), $data['openstock_default_sku_options'][$this->config->get('openstock_default_sku')]);
        $data['openstock_bulk_default_sku_delimiter'] = sprintf($this->language->get('openstock_bulk_default_sku_delimiter'), $this->config->get('openstock_default_sku_delimiter'));
        $data['openstock_bulk_default_sku_case'] = sprintf($this->language->get('openstock_bulk_default_sku_case'), $data['openstock_default_sku_case_options'][$this->config->get('openstock_default_sku_case')]);
        $data['openstock_bulk_default_sku_space'] = sprintf($this->language->get('openstock_bulk_default_sku_space'), $this->config->get('openstock_default_sku_space'));

        $data['sku_example'] = sprintf($this->language->get('text_sku_example'), $this->model_module_openstock->skuExample());

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/openstock.tpl', $data));
    }

    public function postProduct($product_id) {
		if ($this->validate()) {
            $this->load->model('module/openstock');
            $this->load->model('catalog/product');

            $product_info = $this->model_catalog_product->getProduct($product_id);

            $this->db->query("DELETE FROM `" . DB_PREFIX . "product_option_variant_special` WHERE `product_id` = '" . (int)$product_id. "'");
            $this->db->query("DELETE FROM `" . DB_PREFIX . "product_option_variant_discount` WHERE `product_id` = '" . (int)$product_id. "'");

            if ($product_info['has_option'] == '1') {
                $this->db->query("UPDATE `" . DB_PREFIX . "product_option_value` SET subtract = '0', price = '0.000', quantity = '0' WHERE product_id = '" . (int)$product_id . "'");

                $all_variants = $this->model_module_openstock->calculateVariants($product_id);

                if (isset($this->request->post['variant'])) {
                    foreach ($this->request->post['variant'] as $variant_id => $variant) {
                        if (array_key_exists($variant['variant_string'], $all_variants)) {
                            unset($all_variants[$variant['variant_string']]);

                            $this->db->query("
                                UPDATE `" . DB_PREFIX . "product_option_variant`
                                SET
                                     `product_id`    = '" . (int)$product_id . "',
                                     `sku`           = '" . $this->db->escape($variant['sku']) . "',
                                     `stock`         = '" . (int)$variant['stock'] . "',
                                     `active`        = '" . (int)$variant['active'] . "',
                                     `subtract`      = '" . (int)$variant['subtract'] . "',
                                     `price`         = '" . (float)$variant['price'] . "',
                                     `image`         = '" . $this->db->escape($variant['image']) . "',
                                     `weight`        = '" . $this->db->escape($variant['weight']) . "'
                                WHERE
                                     `product_option_variant_id`  = '" . (int)$variant_id . "'
                            ");

                            foreach ($variant['variant_values'] as $sort_order => $variant_value) {
                                $this->db->query("
                                    UPDATE `" . DB_PREFIX . "product_option_variant_value`
                                    SET
                                         `product_option_variant_id`  = '" . (int)$variant_id . "',
                                         `product_option_value_id`    = '" . (int)$variant_value['product_option_value_id'] . "',
                                         `product_id`                 = '" . (int)$product_id . "',
                                         `sort_order`                 = '" . (int)$sort_order . "'
                                    WHERE
                                         `product_option_variant_value_id` = '" . (int)$variant_value['product_option_variant_value_id'] . "'
                                ");
                            }

                            if (isset($variant['discounts'])) {
                                foreach ($variant['discounts'] as $discount) {
                                    $this->db->query("
                                        INSERT INTO `" . DB_PREFIX . "product_option_variant_discount`
                                        SET
                                            `product_option_variant_id`     = '" . (int)$variant_id . "',
                                            `product_id`                    = '" . (int)$product_id . "',
                                            `customer_group_id`             = '" . (int)$discount['customer_group_id'] . "',
                                            `quantity`                      = '" . (int)$discount['quantity'] . "',
                                            `price`                         = '" . (float)$discount['price'] . "',
                                            `date_start`                    = '" . $this->db->escape($discount['date_start']) . "',
                                            `date_end`                      = '" . $this->db->escape($discount['date_end']) . "'
                                    ");
                                }
                            }

                            if (isset($variant['specials'])) {
                                foreach ($variant['specials'] as $special) {
                                    $this->db->query("
                                        INSERT INTO " . DB_PREFIX . "product_option_variant_special
                                        SET
                                            `product_option_variant_id`     = '" . (int)$variant_id . "',
                                            `product_id`                    = '" . (int)$product_id . "',
                                            `customer_group_id`             = '" . (int)$special['customer_group_id'] . "',
                                            `price`                         = '" . (float)$special['price'] . "',
                                            `date_start`                    = '" . $this->db->escape($special['date_start']) . "',
                                            `date_end`                      = '" . $this->db->escape($special['date_end']) . "'
                                    ");
                                }
                            }
                        } else {
                            $this->db->query("DELETE FROM `" . DB_PREFIX . "product_option_variant` WHERE `product_option_variant_id` = '" . (int)$variant_id . "' AND `product_id` = '" . (int)$product_id . "'");
                            $this->db->query("DELETE FROM `" . DB_PREFIX . "product_option_variant_value` WHERE `product_option_variant_id` = '" . (int)$variant_id . "' AND `product_id` = '" . (int)$product_id . "'");
                        }
                    }
                }

                foreach ($all_variants as $new_variant) {
                    $this->db->query("
                        INSERT INTO `" . DB_PREFIX . "product_option_variant`
                        SET
                            `product_id`    = '" . (int)$product_id . "',
                            `sku`           = '',
                            `stock`         = '" . (int)$this->config->get('openstock_default_stock') . "',
                            `active`        = '" . (int)$this->config->get('openstock_default_active') . "',
                            `subtract`      = '" . (int)$this->config->get('openstock_default_subtract') . "',
                            `price`         = '0.00',
                            `image`         = '',
                            `weight`        = '0.00'
                    ");

                    $variant_id = $this->db->getLastId();

                    $i = 1;
                    foreach ($new_variant as $new_variant_value) {
                        $this->db->query("
                            INSERT INTO `" . DB_PREFIX . "product_option_variant_value`
                            SET
                                `product_option_variant_id`  = '" . (int)$variant_id . "',
                                `product_option_value_id`    = '" . (int)$new_variant_value . "',
                                `product_id`                 = '" . (int)$product_id . "',
                                `sort_order`                 = '" . (int)$i++ . "'
                        ");
                    }
                }
            } elseif ($product_info['has_option'] == '0') {
                $this->db->query("DELETE FROM `" . DB_PREFIX . "product_option` WHERE `product_id` = '" . (int)$product_id . "'");
                $this->db->query("DELETE FROM `" . DB_PREFIX . "product_option_value` WHERE `product_id` = '" . (int)$product_id . "'");
            } elseif ($product_info['has_option'] == '2') {
                $this->db->query("DELETE FROM `" . DB_PREFIX . "product_option_variant` WHERE `product_id` = '" . (int)$product_id. "'");
                $this->db->query("DELETE FROM `" . DB_PREFIX . "product_option_variant_value` WHERE `product_id` = '" . (int)$product_id. "'");
            }
        }
    }

    public function deleteProduct($product_id) {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "product_option_variant` WHERE `product_id` = '" . (int)$product_id. "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "product_option_variant_value` WHERE `product_id` = '" . (int)$product_id. "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "product_option_variant_special` WHERE `product_id` = '" . (int)$product_id. "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "product_option_variant_discount` WHERE `product_id` = '" . (int)$product_id. "'");
    }

    public function install() {
        if ($this->user->hasPermission('modify', 'extension/module')) {
            if (version_compare(VERSION, '2.0.0.0', '==')) {
                $event_model = array(
                    'load' => 'tool/event',
                    'use'  => 'model_tool_event'
                );

                $event = array(
                    'add'    => 'post.admin.add.product',
                    'edit'   => 'post.admin.edit.product',
                    'delete' => 'post.admin.delete.product'
                );
            } elseif (version_compare(VERSION, '2.0.1.0', '>=')) {
                $event_model = array(
                    'load' => 'extension/event',
                    'use'  => 'model_extension_event'
                );

                $event = array(
                    'add'    => 'post.admin.product.add',
                    'edit'   => 'post.admin.product.edit',
                    'delete' => 'post.admin.product.delete'
                );
            }

            $this->load->model('module/openstock');
            $this->load->model('setting/setting');
            $this->load->model($event_model['load']);

            $this->model_module_openstock->install();

            $this->model_setting_setting->editSetting('openstock', array(
                'openstock_show_default_price'    => '0',
                'openstock_show_special_tab'      => '0',
                'openstock_default_stock'         => '10',
                'openstock_default_subtract'      => '1',
                'openstock_default_active'        => '1',
                'openstock_default_sku'           => 'blank',
                'openstock_default_sku_delimiter' => ':',
                'openstock_default_sku_case'      => 'default',
                'openstock_default_sku_space'     => '',
                'openstock_dependant_options'     => '1',
            ));

            $this->{$event_model['use']}->addEvent('openstock', $event['add'], 'module/openstock/postProduct');
            $this->{$event_model['use']}->addEvent('openstock', $event['edit'], 'module/openstock/postProduct');
            $this->{$event_model['use']}->addEvent('openstock', $event['delete'], 'module/openstock/deleteProduct');
        }
    }

    public function uninstall() {
        if ($this->user->hasPermission('modify', 'extension/module')) {
            if (version_compare(VERSION, '2.0.0.0', '==')) {
                $event_model = array(
                    'load' => 'tool/event',
                    'use'  => 'model_tool_event'
                );
            } elseif (version_compare(VERSION, '2.0.1.0', '>=')) {
                $event_model = array(
                    'load' => 'extension/event',
                    'use'  => 'model_extension_event'
                );
            }

            $this->load->model('module/openstock');
            $this->load->model($event_model['load']);

            $this->model_module_openstock->uninstall();

            $this->{$event_model['use']}->deleteEvent('openstock');
        }
    }

    public function repair() {
        $status = 'Failed';

        if ($this->user->hasPermission('modify', 'extension/module')) {
            $this->load->model('module/openstock');

            $this->model_module_openstock->repair();

            $status = 'OpenStock 2 was repaired successfully';
        }

        $this->response->setOutput(json_encode(array('msg' => $status)));
    }

    public function export() {
		header('Content-Type: text/html; charset=utf-8');

        $this->load->model('module/openstock');
        $this->load->model('module/openstock_export');
        $this->load->language('module/openstock');

        $this->model_module_openstock_export->init();

        $importable = ' (importable)';

        $this->model_module_openstock_export->setHeading('Variant ID', 'SKU' . $importable, 'Product name', 'Combination', 'Stock' . $importable, 'Weight' . $importable, 'Price' . $importable, 'Status' . $importable);

        $products = $this->model_module_openstock->getProductsWithVariants();

        if ($products) {
            foreach ($products as $product) {
                foreach ($product['variants'] as $option) {
                    $this->model_module_openstock_export->addLine(
                        $option['product_option_variant_id'],
                        $option['sku'],
                        html_entity_decode($product['name']),
                        html_entity_decode($option['combination']),
                        $option['stock'],
                        $option['weight'],
                        $option['price'],
                        $option['active']
                    );
                }
            }

            $this->model_module_openstock_export->output("D", "OpenStock_export.csv");

            $this->model_module_openstock_export->clear();

			die();
        }
    }

    public function import() {
        $this->load->language('module/openstock');

        $json = array();

        if ($this->validate() && !empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
            $file = fopen($this->request->files['file']['tmp_name'], 'r');
            $headings = fgetcsv($file);
            $headings = array_map('strtolower', $headings);
            $headings = str_replace(' ', '_', $headings);
            $headings = str_replace('_(importable)', '', $headings);

            while ($csv = fgetcsv($file, 1024)) {
                $csv = array_combine($headings, $csv);

                $this->db->query("
                    UPDATE `" . DB_PREFIX . "product_option_variant`
                    SET
                        `sku`    = '" . $this->db->escape($csv['sku']) . "',
                        `stock`  = '" . (int)$csv['stock'] . "',
                        `weight` = '" . $this->db->escape($csv['weight']) . "',
                        `price`  = '" . (float)$csv['price'] . "',
                        `active` = '" . (int)$csv['status'] . "'
                    WHERE
                        `product_option_variant_id` = '" . (int)$csv['variant_id'] . "'
                    LIMIT 1
                ");
            }

            $json['success'] = $this->language->get('notice_success');
        } else {
            $json['error'] = $this->language->get('error_permission');
        }

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
    }

    public function bulk() {
        $this->load->language('module/openstock');

        if ($this->validate()) {
            $start = microtime(true);
            $json['products'] = array();

            $this->load->model('module/openstock');
            $this->load->model('catalog/option');

            //Get products with options which has_options = 2
            $products = $this->db->query("
                SELECT `p`.`product_id`, `p`.`sku`, `p`.`model`
                FROM `" . DB_PREFIX . "product` p
                RIGHT JOIN `" . DB_PREFIX . "product_option` po ON (p.product_id = po.product_id)
                WHERE `p`.`has_option` = '2'
                GROUP BY `p`.`product_id`
            ");

            $created = 0;
            foreach ($products->rows as $product) {
                $all_variants = $this->model_module_openstock->calculateVariants($product['product_id']);

                if ($all_variants) {
                    if ($this->request->get['create']) {
                        $this->db->query("UPDATE " . DB_PREFIX . "product SET has_option = '1' WHERE product_id = '" . (int)$product['product_id'] . "'");
                    }

                    $increment = 1;
                    foreach ($all_variants as $new_variant) {
                        if ($this->request->get['create']) {
                            $sku = $this->model_module_openstock->generateSku($product['sku'], $product['model'], $new_variant, $increment);

                            $increment++;

                            $this->db->query("
                                INSERT INTO `" . DB_PREFIX . "product_option_variant`
                                SET
                                    `product_id`    = '" . (int)$product['product_id'] . "',
                                    `sku`           = '" . $this->db->escape($sku) . "',
                                    `stock`         = '" . (int)$this->config->get('openstock_default_stock') . "',
                                    `active`        = '" . (int)$this->config->get('openstock_default_active') . "',
                                    `subtract`      = '" . (int)$this->config->get('openstock_default_subtract') . "',
                                    `price`         = '0.00',
                                    `image`         = '',
                                    `weight`        = '0.00'
                            ");
                        }

                        $created++;

                        $variant_id = $this->db->getLastId();

                        $i = 1;
                        foreach ($new_variant as $new_variant_value) {
                            if ($this->request->get['create']) {
                                $this->db->query("
                                    INSERT INTO `" . DB_PREFIX . "product_option_variant_value`
                                    SET
                                        `product_option_variant_id`  = '" . (int)$variant_id . "',
                                        `product_option_value_id`    = '" . (int)$new_variant_value . "',
                                        `product_id`                 = '" . (int)$product['product_id'] . "',
                                        `sort_order`                 = '" . (int)$i++ . "'
                                ");
                            }
                        }
                    }
                }
            }

            $finish = microtime(true);

            $json['success'] = true;
            $json['created'] = $created;
            $json['time_taken'] = round($finish - $start, 3);
        } else {
            $json['success'] = false;
            $json['error'] = $this->language->get('error_permission');
        }

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'catalog/product')) {
            $this->error['warning'] = $this->language->get('error_permission_products');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}
?>