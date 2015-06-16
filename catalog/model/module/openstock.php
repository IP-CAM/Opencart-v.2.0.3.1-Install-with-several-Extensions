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

    public function getVariant($variant_id, $product_id) {
        $variant = $this->db->query("
            SELECT DISTINCT *
            FROM `" . DB_PREFIX . "product_option_variant`
            WHERE `product_option_variant_id` = '" . (int)$variant_id . "'
            AND `product_id` = '" . (int)$product_id . "'
            LIMIT 1");

        if ($variant->num_rows) {
            $variant = $variant->row;
            $this->load->model('catalog/product');

            $product = $this->model_catalog_product->getProduct($product_id);

            if ($variant['price'] == 0) {
                $variant['price'] = $product['price'];
            }

            return $variant;
        } else {
            return false;
        }
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

    public function getVariantByOptionValues($option_value_ids, $product_id) {
        $matches = array();

        foreach ($option_value_ids as $option_value_id) {
            $variant_values = $this->db->query("
                SELECT *
                FROM `" . DB_PREFIX . "product_option_variant_value`
                WHERE `product_option_value_id` = '" . (int)$option_value_id . "'
                AND `product_id` = '" . (int)$product_id . "'");

            foreach ($variant_values->rows as $variant_value) {
                $matches[$variant_value['product_option_variant_id']][] = array();
            }
        }

        foreach ($matches as $key => $match) {
            if (count($option_value_ids) == count($match)) {
                $variant_id = $key;
            }
        }

        if (isset($variant_id)) {
            return $this->getVariant($variant_id, $product_id);
        } else {
            return false;
        }
    }

    public function getVariantDiscount($product_id, $variant_id, $quantity) {
        $discount = $this->db->query("
            SELECT
                `" . DB_PREFIX . "product_option_variant_discount`.`price` AS `price`
            FROM
                `" . DB_PREFIX . "product_option_variant_discount`,
                `" . DB_PREFIX . "product_option_variant`
            WHERE
                `" . DB_PREFIX . "product_option_variant`.`product_option_variant_id` = '" . (int)$variant_id . "'
            AND
                `" . DB_PREFIX . "product_option_variant`.`product_id` = '".(int)$product_id."'
            AND
                `" . DB_PREFIX . "product_option_variant`.`product_option_variant_id` = `" . DB_PREFIX . "product_option_variant_discount`.`product_option_variant_id`
            AND
                `" . DB_PREFIX . "product_option_variant_discount`.`quantity` <= '" . (int)$quantity . "'
            AND
                `" . DB_PREFIX . "product_option_variant_discount`.`customer_group_id` = '" . (int)$this->config->get('config_customer_group_id') . "'
            AND
                ((`" . DB_PREFIX . "product_option_variant_discount`.`date_start` = '0000-00-00' OR `" . DB_PREFIX . "product_option_variant_discount`.`date_start` < NOW()) AND (`" . DB_PREFIX . "product_option_variant_discount`.`date_end` = '0000-00-00' OR `" . DB_PREFIX . "product_option_variant_discount`.`date_end` > NOW()))
            ORDER BY
                `" . DB_PREFIX . "product_option_variant_discount`.`quantity` DESC, `" . DB_PREFIX . "product_option_variant_discount`.`price` ASC
            LIMIT 1
        ");

        return $discount->row;
    }

    public function getVariantDiscounts($product_id, $variant_id) {
        $query = $this->db->query("
            SELECT * FROM " . DB_PREFIX . "product_option_variant_discount
            WHERE product_id = '" . (int)$product_id . "'
                AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'
                AND quantity > 1 AND product_option_variant_id = '" . (int)$variant_id . "'
                AND ((`date_start` = '0000-00-00' OR `date_start` < NOW()) AND (`date_end` = '0000-00-00' OR `date_end` > NOW()))
            ORDER BY quantity ASC, price ASC");

        return $query->rows;
    }

    public function getVariantSpecial($product_id, $variant_id) {
        $query = $this->db->query("
            SELECT `price`
            FROM `" . DB_PREFIX . "product_option_variant_special`
            WHERE `product_option_variant_id` = '" . (int)$variant_id . "'
                AND `product_id` = '" . (int)$product_id . "'
                AND `customer_group_id` = '" . (int)$this->config->get('config_customer_group_id') . "'
                AND ((`date_start` = '0000-00-00' OR `date_start` < NOW()) AND (`date_end` = '0000-00-00' OR `date_end` > NOW()))
            ORDER BY `price` ASC
            LIMIT 1");

        return $query->row;
    }
}
?>