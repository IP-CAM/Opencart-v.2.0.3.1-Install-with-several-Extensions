<?php
class ModelModuleOpenstock extends Model {
    public function calculateVariants($product_id) {
        $product_options_values = $this->db->query("SELECT `" . DB_PREFIX . "product_option_value`.`product_option_value_id`, `" . DB_PREFIX . "product_option_value`.`option_id`
            FROM
                `" . DB_PREFIX . "product_option_value`,
                `" . DB_PREFIX . "option_value_description`,
                `" . DB_PREFIX . "option_value`,
                `" . DB_PREFIX . "option`
            WHERE
                `" . DB_PREFIX . "product_option_value`.`product_id` = '" . (int)$product_id . "'
            AND
                ((`" . DB_PREFIX . "option`.`type` = 'radio') OR (`" . DB_PREFIX . "option`.`type` = 'select') OR (`" . DB_PREFIX . "option`.`type` = 'image'))
            AND
                `" . DB_PREFIX . "option_value_description`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'
            AND
                `" . DB_PREFIX . "product_option_value`.`option_value_id` = `" . DB_PREFIX . "option_value_description`.`option_value_id`
            AND
                `" . DB_PREFIX . "option_value`.`option_value_id` = `" . DB_PREFIX . "product_option_value`.`option_value_id`
            AND
                `" . DB_PREFIX . "option`.`option_id` = `" . DB_PREFIX . "option_value`.`option_id`
            ORDER BY `" . DB_PREFIX . "option`.`option_id`, `" . DB_PREFIX . "option_value`.`option_value_id` ASC");

        $unique_groups = array();

        foreach ($product_options_values->rows as $product_options_value) {
            $unique_groups[$product_options_value['option_id']][] = $product_options_value['product_option_value_id'];
        }

        $variants = array();
        $i = 0;
        foreach ($unique_groups as $unique_group) {
            $variants[$i++] = $unique_group;
        }

        $final = array();
        if (!empty($variants)){
            foreach ($variants[0] as $v1) {
                if (!empty($variants[1])) {
                    foreach($variants[1] as $v2) {
                        if (!empty($variants[2])) {
                            foreach($variants[2] as $v3) {
                                if (!empty($variants[3])) {
                                    foreach($variants[3] as $v4) {
                                        if (!empty($variants[4])){
                                            foreach($variants[4] as $v5) {
                                                $final[$v1 . ':' . $v2 . ':' . $v3 . ':' . $v4 . ':' . $v5] = array(
                                                    $v1,
                                                    $v2,
                                                    $v3,
                                                    $v4,
                                                    $v5
                                                );
                                            }
                                        } else {
                                            $final[$v1 . ':' . $v2 . ':' . $v3 . ':' . $v4] =  array(
                                                $v1,
                                                $v2,
                                                $v3,
                                                $v4
                                            );
                                        }
                                    }
                                } else {
                                    $final[$v1 . ':' . $v2 . ':' . $v3] = array(
                                        $v1,
                                        $v2,
                                        $v3
                                    );
                                }
                            }
                        } else {
                            $final[$v1 . ':' . $v2] = array(
                                $v1,
                                $v2
                            );
                        }
                    }
                } else {
                    $final[$v1] = array(
                        $v1
                    );
                }
            }
        }

        return $final;
    }

    public function install() {
        $this->repair();

        $products = $this->db->query("
            SELECT `p`.`product_id`
            FROM `" . DB_PREFIX . "product` p
            RIGHT JOIN `" . DB_PREFIX . "product_option` po ON (p.product_id = po.product_id)
            GROUP BY `p`.`product_id`
        ");

        if ($products->num_rows) {
            foreach ($products->rows as $product) {
                $this->db->query("
                    UPDATE `" . DB_PREFIX . "product`
                    SET
                         `has_option`  = '2'
                    WHERE
                         `product_id` = '" . (int)$product['product_id'] . "'
                ");
            }
        }

        $this->log->write('OPENSTOCK --> Completed install');
    }

    public function uninstall() {
        $this->log->write('OPENSTOCK --> Starting uninstall');

        $sql = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product` LIKE 'has_option'");
        if ($sql->num_rows == 1) {
			$query = $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` DROP `has_option`");
			$this->log->write('OPENSTOCK --> Altered ' . DB_PREFIX . 'product table - dropped has option column');
        }

        $sql = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "product_option_variant'");
        if ($sql->num_rows > 0) {
			$query = $this->db->query("DROP TABLE `" . DB_PREFIX . "product_option_variant`");
			$this->log->write('OPENSTOCK --> Dropped ' . DB_PREFIX . 'product_option_variant table');
        }

        $sql = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "product_option_variant_value'");
        if ($sql->num_rows > 0) {
			$query = $this->db->query("DROP TABLE `" . DB_PREFIX . "product_option_variant_value`");
			$this->log->write('OPENSTOCK --> Dropped ' . DB_PREFIX . 'product_option_variant_value table');
        }

        $sql = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "product_option_variant_special'");
        if ($sql->num_rows > 0) {
			$query = $this->db->query("DROP TABLE `" . DB_PREFIX . "product_option_variant_special`");
			$this->log->write('OPENSTOCK --> Dropped ' . DB_PREFIX . 'product_option_variant_special table');
        }

        $sql = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "product_option_variant_discount'");
        if ($sql->num_rows > 0) {
			$query = $this->db->query("DROP TABLE `" . DB_PREFIX . "product_option_variant_discount`");
			$this->log->write('OPENSTOCK --> Dropped ' . DB_PREFIX . 'product_option_variant_discount table');
        }

        $this->log->write('OPENSTOCK --> Completed uninstall');
    }

    public function repair() {
        $this->log->write('OPENSTOCK --> Starting install / repair');

        //check product table for has_option
        $sql = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product` LIKE 'has_option'");
        if ($sql->num_rows == 0) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` ADD `has_option` TINYINT(1) NOT NULL");
            $this->log->write('OPENSTOCK --> Altered ' . DB_PREFIX . 'product table, added has_option column');
        }

        //check for product_option_variant table
        $sql = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "product_option_variant'");
        if ($sql->num_rows == 0) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_option_variant` (
                  `product_option_variant_id` int(11) NOT NULL AUTO_INCREMENT,
                  `product_id` int(11) NOT NULL,
                  `sku` char(50) NOT NULL,
                  `stock` int(11) NOT NULL,
                  `active` tinyint(4) NOT NULL DEFAULT '1',
                  `subtract` tinyint(1) NOT NULL DEFAULT '0',
                  `price` decimal(10,4) NOT NULL DEFAULT '0.0000',
                  `image` text NOT NULL,
                  `weight`  decimal(15,8) NOT NULL,
                  PRIMARY KEY (`product_option_variant_id`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
            ");

            $this->log->write('OPENSTOCK --> Created ' . DB_PREFIX . 'product_option_variant table');
        }

        //check for product_option_variant table
        $sql = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "product_option_variant_value'");
        if ($sql->num_rows == 0) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_option_variant_value` (
                  `product_option_variant_value_id` int(11) NOT NULL AUTO_INCREMENT,
                  `product_option_variant_id` int(11) NOT NULL,
                  `product_option_value_id` int(11) NOT NULL,
                  `product_id` int(11) NOT NULL,
                  `sort_order` int(3) NOT NULL,
                  PRIMARY KEY (`product_option_variant_value_id`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
            ");

            $this->log->write('OPENSTOCK --> Created ' . DB_PREFIX . 'product_option_variant_value table');
        }

        //install product_option_variant_special table
        $sql = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "product_option_variant_special'");
        if ($sql->num_rows == 0) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_option_variant_special` (
                  `product_option_variant_special_id` int(11) NOT NULL AUTO_INCREMENT,
                  `product_option_variant_id` int(11) NOT NULL,
                  `product_id` int(11) NOT NULL,
                  `customer_group_id` int(11) NOT NULL,
                  `price` decimal(10,4) NOT NULL DEFAULT '0.0000',
                  `date_start` date NOT NULL DEFAULT '0000-00-00',
                  `date_end` date NOT NULL DEFAULT '0000-00-00',
                  PRIMARY KEY (`product_option_variant_special_id`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
            ");

            $this->log->write('OPENSTOCK --> Created ' . DB_PREFIX . 'product_option_variant_special table');
        }

        //install product_option_variant_discount table
        $sql = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "product_option_variant_discount'");
        if ($sql->num_rows == 0) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_option_variant_discount` (
                  `product_option_variant_discount_id` int(11) NOT NULL AUTO_INCREMENT,
                  `product_option_variant_id` int(11) NOT NULL,
                  `product_id` int(11) NOT NULL,
                  `customer_group_id` int(11) NOT NULL,
                  `quantity` int(11) NOT NULL,
                  `price` decimal(10,4) NOT NULL DEFAULT '0.0000',
                  `date_start` date NOT NULL DEFAULT '0000-00-00',
                  `date_end` date NOT NULL DEFAULT '0000-00-00',
                  PRIMARY KEY (`product_option_variant_discount_id`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
            ");

            $this->log->write('OPENSTOCK --> Created ' . DB_PREFIX . 'product_option_variant_discount table');
        }

        $this->log->write('OPENSTOCK --> End install / repair');
    }

    public function getProductsWithVariants(){
        $this->load->model('catalog/product');

        $query = $this->db->query("
            SELECT `p`.`product_id`, `pd`.`name`
            FROM `" . DB_PREFIX . "product` `p`
            LEFT JOIN `" . DB_PREFIX . "product_description` `pd` ON (p.product_id = pd.product_id)
            WHERE `p`.`has_option` = '1'
                AND `pd`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'
            ");

        if ($query->num_rows) {
            $products = array();

            foreach ($query->rows as $row) {
                $p['name']      = $row['name'];
                $p['variants']  = $this->getVariants($row['product_id']);

                $products[] = $p;
            }

            return $products;
        } else {
            return false;
        }
    }

    public function getVariant($product_option_variant_id) {
        $query = $this->db->query("
SELECT
  `povv`.`product_option_variant_value_id`,
  `povv`.`product_option_variant_id`,
  `povv`.`product_option_value_id`,
  `povv`.`product_id`,
  `povv`.`sort_order`,
  `od`.`name` AS `option_name`,
  `ovd`.`name` AS `option_value_name`
FROM `" . DB_PREFIX . "product_option_variant_value` `povv`
LEFT JOIN `" . DB_PREFIX . "product_option_value` `pov` ON `pov`.`product_option_value_id` = `povv`.`product_option_value_id`
LEFT JOIN `" . DB_PREFIX . "option_value` `ov` ON `ov`.`option_value_id` = `pov`.`option_value_id`
LEFT JOIN `" . DB_PREFIX . "option_value_description` `ovd` ON `ovd`.`option_value_id` = `ov`.`option_value_id`
LEFT JOIN `" . DB_PREFIX . "option` `o` ON `o`.`option_id` = `ov`.`option_id`
LEFT JOIN `" . DB_PREFIX . "option_description` `od` ON `od`.`option_id` = `o`.`option_id`
WHERE `povv`.`product_option_variant_id` = '" . (int)$product_option_variant_id . "'
AND `od`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'
AND `ovd`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'
ORDER BY `povv`.`sort_order` ASC
");

        $variant = array();

        foreach ($query->rows as $row) {
            $variant[] = $row;
        }

        return $variant;
    }

    public function getVariants($product_id) {
        $sql = "
                SELECT `" . DB_PREFIX . "product_option_value`.`product_option_value_id`, `" . DB_PREFIX . "option_value_description`.`name`
                FROM
                    `" . DB_PREFIX . "product_option_value`,
                    `" . DB_PREFIX . "option_value_description`,
                    `" . DB_PREFIX . "option_value`,
                    `" . DB_PREFIX . "option`
                WHERE
                    `" . DB_PREFIX . "product_option_value`.`product_id` = '" . (int)$product_id . "'
                AND
                    `" . DB_PREFIX . "product_option_value`.`option_value_id` = `" . DB_PREFIX . "option_value_description`.`option_value_id`
                AND
					`" . DB_PREFIX . "option_value_description`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'
                AND
                    `" . DB_PREFIX . "option_value`.`option_value_id` = `" . DB_PREFIX . "product_option_value`.`option_value_id`
                AND
                    `" . DB_PREFIX . "option`.`option_id` = `" . DB_PREFIX . "option_value`.`option_id`
                ORDER BY `" . DB_PREFIX . "option`.`sort_order`, `" . DB_PREFIX . "option_value`.`sort_order` ASC";
        $options_qry = $this->db->query($sql);

        $option_values = array();
        foreach ($options_qry->rows as $row) {
            $option_values[$row['product_option_value_id']] = $row['name'];
        }

        $variants = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option_variant` WHERE `product_id` = '" . (int)$product_id . "' ORDER BY `product_option_variant_id` ASC");

        $variants_array = array();
        foreach ($variants->rows as $variant) {
            $variant_values = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option_variant_value` WHERE `product_id` = '" . (int)$product_id . "' AND `product_option_variant_id` = '" . (int)$variant['product_option_variant_id'] . "' ORDER BY `sort_order` ASC");
            $variant_combination = '';

            $variant_values_array = array();
            foreach ($variant_values->rows as $variant_value) {
                $variant_combination .= $option_values[$variant_value['product_option_value_id']] . ' > ';

                $variant_values_array[$variant_value['sort_order']] = array(
                    'product_option_value_id'         => $variant_value['product_option_value_id'],
                    'product_option_variant_value_id' => $variant_value['product_option_variant_value_id']
                );
            }

            //variant specials
            $variant_specials = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option_variant_special` WHERE `product_id` = '" . (int)$product_id . "' AND `product_option_variant_id` = '" . (int)$variant['product_option_variant_id'] . "' ORDER BY `customer_group_id` ASC");

            $specials = array();
            foreach ($variant_specials->rows as $variant_special) {
				$specials[$variant_special['product_option_variant_special_id']] = array(
					'customer_group_id' => $variant_special['customer_group_id'],
					'price' 			=> $variant_special['price'],
					'date_start' 		=> $variant_special['date_start'],
					'date_end' 			=> $variant_special['date_end']
				);
            }

            //variant discounts
            $variant_discounts = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option_variant_discount` WHERE `product_id` = '" . (int)$product_id . "' AND `product_option_variant_id` = '" . (int)$variant['product_option_variant_id'] . "' ORDER BY `customer_group_id`, `quantity` ASC");

            $discounts = array();
            foreach ($variant_discounts->rows as $variant_discount) {
                $discounts[$variant_discount['product_option_variant_discount_id']] = array(
                    'price'             => $variant_discount['price'],
                    'quantity'          => $variant_discount['quantity'],
                    'customer_group_id' => $variant_discount['customer_group_id'],
                    'date_start'        => $variant_discount['date_start'],
                    'date_end'          => $variant_discount['date_end']
                );
            }

            $this->load->model('tool/image');

            if (!empty($variant) && $variant['image'] && file_exists(DIR_IMAGE . $variant['image'])) {
                $thumb = $this->model_tool_image->resize($variant['image'], 100, 100);
            } else {
                $thumb = '';
            }

            $variants_array[$variant['product_option_variant_id']] = array(
                'product_option_variant_id'  => $variant['product_option_variant_id'],
                'sku'                        => $variant['sku'],
                'product_id'                 => $variant['product_id'],
                'combination'                => rtrim($variant_combination, ' > '),
                'stock'                      => $variant['stock'],
                'active'                     => $variant['active'],
                'subtract'                   => $variant['subtract'],
                'price'                      => $variant['price'],
                'option_values'              => $option_values,
                'variant_values'             => $variant_values_array,
                'specials'                   => $specials,
                'discounts'                  => $discounts,
                'image'                      => $variant['image'],
                'thumb'                      => $thumb,
                'weight'                     => $variant['weight']
            );
        }

        return $variants_array;
    }

    public function getVariantValues($product_option_variant_id) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option_variant_value` WHERE `product_option_variant_id` = '" . (int)$product_option_variant_id . "' ORDER BY `sort_order` ASC");

        $variant_values = array();

        foreach ($query->rows as $row) {
            $variant_values[] = $row;
        }

        return $variant_values;
    }

    public function countVariation($product_id) {
        $sql = "
            SELECT *
            FROM `" . DB_PREFIX . "product_option_variant`
                WHERE `product_id` = '" . (int)$product_id . "'";
        $option_qry = $this->db->query($sql);

        return (int)$option_qry->num_rows;
    }

    public function countVariationStock($product_id) {
        $sql = "
            SELECT SUM(`stock`) as `s`
            FROM `" . DB_PREFIX . "product_option_variant`
                WHERE `product_id` = '" . (int)$product_id . "'";
        $option_qry = $this->db->query($sql);

        return (int)$option_qry->row['s'];
    }

    public function checkProblems() {
        $array = array();

        if (ini_get('max_input_vars') && ini_get('max_input_vars') < '1000') {
            $array['max_input_vars'] = array(
                'colour' => 'red',
                'text'   => sprintf($this->language->get('text_max_input_vars'), ini_get('max_input_vars'), 'http://help.welfordmedia.co.uk/kb/openstock/common-problems')
            );
        } elseif (ini_get('max_input_vars') && ini_get('max_input_vars') < '5000') {
            $array['max_input_vars'] = array(
                'colour' => 'orange',
                'text'   => sprintf($this->language->get('text_max_input_vars'), ini_get('max_input_vars'), 'http://help.welfordmedia.co.uk/kb/openstock/common-problems')
            );
        }

        if ($this->config->get('config_template') != 'default') {
            $array['custom_theme'] = array(
                'colour' => 'orange',
                'text'   => sprintf($this->language->get('text_custom_theme_orange'), 'http://help.welfordmedia.co.uk/kb/openstock/custom-theme-patching')
            );
        }

        if (!class_exists('VQMod')) {
            $array['vqmod'] = array(
                'colour' => 'red',
                'text'   => sprintf($this->language->get('text_vqmod_red'), 'https://github.com/vqmod/vqmod/wiki')
            );
        }

        return $array;
    }

    public function checkProductOptionValues($data) {
        $this->load->model('catalog/option');
        $this->load->model('catalog/product');

        $option_values = $this->model_catalog_option->getOptionValueDescriptions($this->request->get['option_id']);

        $ov_array = array();
        foreach ($option_values as $option_value) {
            $ov_array[$option_value['option_value_id']] = $option_value['option_value_id'];
        }

        if (isset($data['option_value'])) {
            foreach ($data['option_value'] as $form_option_value) {
                if (in_array($form_option_value['option_value_id'], $ov_array)) {
                    unset($ov_array[$form_option_value['option_value_id']]);
                }
            }
        }

        $offending = array();

        if ($ov_array) {
            foreach ($ov_array as $current_option_value_id) {
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE option_value_id = '" . (int)$current_option_value_id . "'");

                if ($query->num_rows) {
                    foreach ($query->rows as $row) {
                        $product = $this->model_catalog_product->getProduct($row['product_id']);

                        $option_value_description = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value_description WHERE option_value_id = '" . (int)$current_option_value_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

                        $offending[$row['option_value_id']]['option_name'] = $option_value_description->row['name'];

                        $offending[$row['option_value_id']]['products'][$product['product_id']] = array(
                            'name' => $product['name']
                        );
                    }
                }
            }
        }

        if ($offending) {
            return $offending;
        } else {
            return false;
        }
    }

    public function validateVariants($data, $product_id) {
        $this->load->language('module/openstock');

        $errors = array();

        if ($data['has_option'] == '1' && isset($data['variant']) && !empty($data['variant'])) {
            $skus = array();
            foreach ($data['variant'] as $variant) {
                if (!empty($variant['sku'])) {
                    $skus[] = $variant['sku'];
                }
            }

            if (count($skus) !== count(array_unique($skus))) {
                $errors['warning'] = $this->language->get('error_duplicate_sku_post');
            }

            if (!$errors) {
                foreach ($data['variant'] as $variant) {
                    if (!empty($variant['sku'])) {
                        $unique_sku_query = $this->db->query("
                            SELECT DISTINCT `pov`.`product_id`, (
                            SELECT GROUP_CONCAT(`povv`.`product_option_value_id` ORDER BY `povv`.`sort_order` ASC SEPARATOR ':')
                            FROM `" . DB_PREFIX . "product_option_variant_value` `povv`
                            WHERE `povv`.`product_option_variant_id` = `pov`.`product_option_variant_id`
                            ) AS variant_string
                            FROM `" . DB_PREFIX . "product_option_variant` `pov`
                            WHERE `pov`.`sku` = '" . $this->db->escape($variant['sku']) . "'
                            GROUP BY `pov`.`product_id`
                        ");

                        if ($unique_sku_query->num_rows && $unique_sku_query->row['variant_string'] != $variant['variant_string'] && $unique_sku_query->row['product_id'] != $product_id) {
                            $errors['variant'][$variant['variant_string']] = sprintf($this->language->get('error_duplicate_sku_db'), $unique_sku_query->row['product_id']);
                        }
                    }
                }
            }
        }

        return $errors;
    }

    public function generateSku($product_sku, $product_model, $variant_values, $increment) {
        $sku = '';

        if ($this->config->get('openstock_default_sku') != 'blank') {
            if ($this->config->get('openstock_default_sku_delimiter')) {
                $delimiter = $this->config->get('openstock_default_sku_delimiter');
            } else {
                $delimiter = ':';
            }

            switch ($this->config->get('openstock_default_sku')) {
                case 'sku_increment':
                    if ($product_sku) {
                        $sku = $product_sku . $delimiter . $increment;
                    }
                    break;
                case 'model_increment':
                    if ($product_model) {
                        $sku = $product_model . $delimiter . $increment;
                    }
                    break;
                case 'sku_combination':
                    if ($product_sku) {
                        $option_string = '';
                        foreach ($variant_values as $option_value) {
                            $name = $this->db->query("
                                SELECT DISTINCT `ovd`.`name`
                                FROM `oc_product_option_value` `pov`
                                LEFT JOIN `oc_option_value_description` `ovd` ON (`pov`.`option_value_id` = `ovd`.`option_value_id`)
                                WHERE `pov`.`product_option_value_id` = '" . (int)$option_value . "'
                                AND `ovd`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'
                            ");

                            if ($name->num_rows) {
                                $option_string .= $name->row['name'] . $delimiter;
                            }
                        }

                        $sku = $product_model . $delimiter . rtrim($option_string, $delimiter);
                    }
                    break;
                case 'model_combination':
                    if ($product_model) {
                        $option_string = '';
                        foreach ($variant_values as $option_value) {
                            $name = $this->db->query("
                                SELECT DISTINCT `ovd`.`name`
                                FROM `oc_product_option_value` `pov`
                                LEFT JOIN `oc_option_value_description` `ovd` ON (`pov`.`option_value_id` = `ovd`.`option_value_id`)
                                WHERE `pov`.`product_option_value_id` = '" . (int)$option_value . "'
                                AND `ovd`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'
                            ");

                            if ($name->num_rows) {
                                $option_string .= $name->row['name'] . $delimiter;
                            }
                        }

                        $sku = $product_model . $delimiter . rtrim($option_string, $delimiter);
                    }
                    break;
            }

            if ($this->config->get('openstock_default_sku_space')) {
                $sku = str_replace(' ', $this->config->get('openstock_default_sku_space'), $sku);
            }

            switch ($this->config->get('openstock_default_sku_case')) {
                case 'uppercase':
                    $sku = strtoupper($sku);
                    break;
                case 'lowercase':
                    $sku = strtolower($sku);
                    break;
            }

            $unique_sku_query = $this->db->query("
                SELECT DISTINCT `pov`.`product_id`
                FROM `" . DB_PREFIX . "product_option_variant` `pov`
                WHERE `pov`.`sku` = '" . $this->db->escape($sku) . "'
            ");

            if ($unique_sku_query->num_rows) {
                $sku = '';
            }
        }

        return $sku;
    }

    public function skuExample() {
        $this->load->language('module/openstock');

        $this->load->model('catalog/option');

        //Get products with options which has_options = 2
        $products = $this->db->query("
            SELECT `p`.`product_id`, `p`.`sku`, `p`.`model`
            FROM `" . DB_PREFIX . "product` p
            RIGHT JOIN `" . DB_PREFIX . "product_option` po ON (p.product_id = po.product_id)
            GROUP BY `p`.`product_id`
        ");

        if ($products->num_rows) {
            foreach ($products->rows as $product) {
                $all_variants = $this->calculateVariants($product['product_id']);

                if ($all_variants) {
                    foreach ($all_variants as $new_variant) {
                        $sku = $this->generateSku($product['sku'], $product['model'], $new_variant, 1);

                        if ($sku) {
                            return $sku;
                        }
                    }
                }
            }
        }

        return '';
    }
}
?>