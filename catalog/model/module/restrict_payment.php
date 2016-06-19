<?php
//==============================================================================
// Restrict Payment Methods v220.2
// 
// Author: Clear Thinking, LLC
// E-mail: johnathan@getclearthinking.com
// Website: http://www.getclearthinking.com
// 
// All code within this file is copyright Clear Thinking, LLC.
// You may not copy or reuse code within this file without written permission.
//==============================================================================

class ModelModuleRestrictPayment extends Model {
	private $type = 'payment';
	private $name = 'restrict_payment';
	private $testing_mode;
	private $row;
	
	public function restrict($extensions) {
		$settings = $this->getSettings();
		$this->testing_mode = $settings['testing_mode'];
		
		$this->logMessage("\n" . '------------------------------ Starting Test ' . date('Y-m-d G:i:s') . ' ------------------------------');
		
		if (empty($settings['status'])) {
			$this->logMessage('Extension is disabled');
			return $extensions;
		}
		
		unset($this->session->data[$this->name]);
		
		// Set address info
		$addresses = array();
		$this->load->model('account/address');
		foreach (array('shipping', 'payment', 'geoiptools') as $address_type) {
			if ($address_type == 'geoiptools' && !empty($this->session->data['geoip_data']['location'])) {
				$address = $this->session->data['geoip_data']['location'];
			} elseif (($address_type == 'shipping' && empty($address)) || $address_type == 'payment') {
				$address = array();
				
				if ($this->customer->isLogged()) 										$address = $this->model_account_address->getAddress($this->customer->getAddressId());
				if (!empty($this->session->data['country_id']))							$address['country_id'] = $this->session->data['country_id'];
				if (!empty($this->session->data['zone_id']))							$address['zone_id'] = $this->session->data['zone_id'];
				if (!empty($this->session->data['postcode']))							$address['postcode'] = $this->session->data['postcode'];
				if (!empty($this->session->data['city']))								$address['city'] = $this->session->data['city'];
				
				if (!empty($this->session->data[$address_type . '_country_id']))		$address['country_id'] = $this->session->data[$address_type . '_country_id'];
				if (!empty($this->session->data[$address_type . '_zone_id']))			$address['zone_id'] = $this->session->data[$address_type . '_zone_id'];
				if (!empty($this->session->data[$address_type . '_postcode']))			$address['postcode'] = $this->session->data[$address_type . '_postcode'];
				if (!empty($this->session->data[$address_type . '_city']))				$address['city'] = $this->session->data[$address_type . '_city'];
				
				if (!empty($this->session->data['guest'][$address_type]))				$address = $this->session->data['guest'][$address_type];
				if (!empty($this->session->data[$address_type . '_address_id']))		$address = $this->model_account_address->getAddress($this->session->data[$address_type . '_address_id']);
				if (!empty($this->session->data[$address_type . '_address']))			$address = $this->session->data[$address_type.'_address'];
			}
			
			if (empty($address['address_1']))	$address['address_1'] = '';
			if (empty($address['address_2']))	$address['address_2'] = '';
			if (empty($address['city']))		$address['city'] = '';
			if (empty($address['postcode']))	$address['postcode'] = '';
			if (empty($address['country_id']))	$address['country_id'] = $this->config->get('config_country_id');
			if (empty($address['zone_id']))		$address['zone_id'] =  $this->config->get('config_zone_id');
			
			$country_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country WHERE country_id = " . (int)$address['country_id']);
			$address['country'] = (isset($country_query->row['name'])) ? $country_query->row['name'] : '';
			$address['iso_code_2'] = (isset($country_query->row['iso_code_2'])) ? $country_query->row['iso_code_2'] : '';
			
			$zone_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone WHERE zone_id = " . (int)$address['zone_id']);
			$address['zone'] = (isset($zone_query->row['name'])) ? $zone_query->row['name'] : '';
			$address['zone_code'] = (isset($zone_query->row['code'])) ? $zone_query->row['code'] : '';
			
			$addresses[$address_type] = $address;
			
			$addresses[$address_type]['geo_zones'] = array();
			$geo_zones_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE country_id = " . (int)$address['country_id'] . " AND (zone_id = 0 OR zone_id = " . (int)$address['zone_id'] . ")");
			if ($geo_zones_query->num_rows) {
				foreach ($geo_zones_query->rows as $geo_zone) {
					$addresses[$address_type]['geo_zones'][] = $geo_zone['geo_zone_id'];
				}
			} else {
				$addresses[$address_type]['geo_zones'] = array(0);
			}
		}
		
		// Set order totals if necessary
		if ($this->type != 'total') {
			$order_totals_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = 'total' ORDER BY `code` ASC");
			$order_totals = $order_totals_query->rows;
			
			$sort_order = array();
			foreach ($order_totals as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}
			array_multisort($sort_order, SORT_ASC, $order_totals);
			
			$total_data = array();
			$order_total = 0;
			$taxes = $this->cart->getTaxes();
			
			foreach ($order_totals as $ot) {
				if ($ot['code'] == 'shipping' && $this->type == 'shipping') break;
				if (!$this->config->get($ot['code'] . '_status')) continue;
				$this->load->model('total/' . $ot['code']);
				if (version_compare(VERSION, '2.2', '<')) {
					$this->{'model_total_' . $ot['code']}->getTotal($total_data, $order_total, $taxes);
				} else {
					$this->{'model_total_' . $ot['code']}->getTotal(array('totals' => &$total_data, 'total' => &$order_total, 'taxes' => &$taxes));
				}
			}
		}
		
		// Set shipping/payment info
		$shipping_method = (isset($this->session->data['shipping_method']['code'])) ? substr($this->session->data['shipping_method']['code'], 0, strpos($this->session->data['shipping_method']['code'], '.')) : '';
		$shipping_rate = (isset($this->session->data['shipping_method']['title'])) ? strtolower($this->session->data['shipping_method']['title']) : '';
		$shipping_cost = (isset($this->session->data['shipping_method']['cost'])) ? $this->session->data['shipping_method']['cost'] : '';		
		
		if (isset($this->session->data['payment_method']['code'])) {
			$payment_method = $this->session->data['payment_method']['code'];
		} elseif (isset($this->request->post['payment_code'])) {
			$payment_method = $this->request->post['payment_code'];
		} else {
			$payment_method = '';
		}
		
		// Set cart and order data
		$this->load->model('catalog/product');
		
		$cart_products = $this->cart->getProducts();
		if (version_compare(VERSION, '2.1', '>=')) {
			foreach ($cart_products as &$cart_product) {
				$cart_product['key'] = $cart_product['product_id'] . json_encode($cart_product['option']);
			}
		}
		
		$cumulative_total_value = $order_total;
		$currency = $this->session->data['currency'];
		$customer_id = (int)$this->customer->getId();
		$customer_group_id = (version_compare(VERSION, '2.0', '<')) ? (int)$this->customer->getCustomerGroupId() : (int)$this->customer->getGroupId();
		$default_currency = $this->config->get('config_currency');
		$distance = 0;
		$language = (isset($this->session->data['language'])) ? $this->session->data['language'] : $this->config->get('config_language');
		$store_id = (int)$this->config->get('config_store_id');
		
		// Loop through rows
		$disabled = array();
		$enabled = array();
		
		foreach ($settings['restriction'] as $row) {
			$this->row = $row;
			if (!isset($row['name'])) continue;
			
			// Compile rules and rule sets
			$rule_list = (!empty($row['rule'])) ? $row['rule'] : array();
			$rule_sets = array();
			
			foreach ($rule_list as $rule) {
				if (isset($rule['type']) && $rule['type'] == 'rule_set') {
					$rule_sets[] = $settings['rule_set'][$rule['value']]['rule'];
				}
			}
			
			foreach ($rule_sets as $rule_set) {
				$rule_list = array_merge($rule_list, $rule_set);
			}
			
			$rules = array();
			foreach ($rule_list as $rule) {
				if (empty($rule['type'])) continue;
				
				if (isset($rule['value'])) {
					if (in_array($rule['type'], array('attribute_group', 'category', 'manufacturer', 'product', 'customer', 'zone'))) {
						$value = substr($rule['value'], strrpos($rule['value'], '[') + 1, -1);
					} else {
						$value = $rule['value'];
					}
				} else {
					$value = 1;
				}
				
				if (!isset($rule['comparison'])) $rule['comparison'] = '';
				if (in_array($rule['type'], array('attribute', 'custom_field', 'option'))) {
					$comparison = substr($rule['comparison'], strrpos($rule['comparison'], '[') + 1, -1);
				} else {
					$comparison = $rule['comparison'];
				}
				$rules[$rule['type']][$comparison][] = $value;
			}
			$this->row['rules'] = $rules;
			
			// Add methods to disabled list
			$methods = explode(';', str_replace(' ', '', $row['methods']));
			$disabled = array_unique(array_merge($disabled, $methods));
			
			// Perform settings overrides
			if (!empty($defaults)) {
				foreach ($defaults as $key => $value) {
					$this->config->set($key, $value);
				}
			}
			
			$defaults = array();
			
			if (isset($rules['setting_override'])) {
				foreach ($rules['setting_override'] as $setting => $override) {
					$defaults[$setting] = $this->config->get($setting);
					$this->config->set($setting, $override[0]);
					
					if ($setting == 'config_address') {
						$distance = 0;
					}
				}
			}
			
			// Check date/time criteria
			if ($this->ruleViolation('day', strtolower(date('l'))) ||
				$this->ruleViolation('date', date('Y-m-d')) ||
				$this->ruleViolation('time', date('H:i'))
			) {
				continue;
			}
			
			// Check location criteria
			if (isset($rules['location_comparison'])) {
				$location_comparison = $rules['location_comparison'][''][0];
			} else {
				$location_comparison = ($this->type == 'shipping' || empty($addresses['payment']['postcode'])) ? 'shipping' : 'payment';
			}
			$address = $addresses[$location_comparison];
			$postcode = $address['postcode'];
			
			if (isset($rules['city'])) {
				$this->commaMerge($rules['city']);
				$this->row['rules']['city'] = $rules['city'];
			}
			
			if ($this->ruleViolation('city', strtolower($address['city'])) ||
				$this->ruleViolation('country', $address['country_id']) ||
				$this->ruleViolation('geo_zone', $address['geo_zones']) ||
				$this->ruleViolation('zone', $address['zone_id'])
			) {
				continue;
			}
			
			if (isset($rules['distance']) && !$distance) {
				$context = stream_context_create(array('http' => array('ignore_errors' => '1')));
				$store_address = html_entity_decode(preg_replace('/\s+/', '+', $this->config->get('config_address')), ENT_QUOTES, 'UTF-8');
				
				if (!empty($address['geocode'])) {
					$customer_address = $address['geocode'];
				} else {
					$customer_address = $address['address_1'] . ' ' . $address['address_2'] . ' ' . $address['city'] . ' ' . $address['zone'] . ' ' . $address['country'] . ' ' . $address['postcode'];
					$customer_address = html_entity_decode(preg_replace('/\s+/', '+', $customer_address), ENT_QUOTES, 'UTF-8');
				}
				
				if (isset($settings['distance_calculation']) && $settings['distance_calculation'] == 'driving') {
					$directions = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/directions/json?origin=' . $store_address . '&destination=' . $customer_address, false, $context));
					if (empty($directions->routes)) {
						sleep(1);
						$directions = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/directions/json?origin=' . $store_address . '&destination=' . $customer_address, false, $context));
						if (empty($directions->routes)) {
							$this->logMessage('The Google directions service returned the error "' . $directions->status . '" for origin "' . $store_address . '" and destination "' . $customer_address . '"');
							continue;
						}
					}
					$distance = $directions->routes[0]->legs[0]->distance->value / 1609.344;
				} else {
					if ($this->config->get('config_geocode')) {
						$xy = explode(',', $this->config->get('config_geocode'));
						$x1 = $xy[0];
						$y1 = $xy[1];
					} else {
						$geocode = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . $store_address, false, $context));
						if (empty($geocode->results)) {
							sleep(1);
							$geocode = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . $store_address, false, $context));
							if (empty($geocode->results)) {
								$this->logMessage('The Google geocoding service returned the error "' . $geocode->status . '" for address "' . $store_address . '"');
								continue;
							}
						}
						$x1 = $geocode->results[0]->geometry->location->lat;
						$y1 = $geocode->results[0]->geometry->location->lng;
					}
					
					if (!empty($address['geocode'])) {
						$xy = explode(',', $address['geocode']);
						$x2 = $xy[0];
						$y2 = $xy[1];
					} else {
						$geocode = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . $customer_address, false, $context));
						if (empty($geocode->results)) {
							sleep(1);
							$geocode = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . $customer_address, false, $context));
							if (empty($geocode->results)) {
								$this->logMessage('The Google geocoding service returned the error "' . $geocode->status . '" for address "' . $customer_address . '"');
								continue;
							}
						}
						$x2 = $geocode->results[0]->geometry->location->lat;
						$y2 = $geocode->results[0]->geometry->location->lng;
					}
					
					$distance = rad2deg(acos(sin(deg2rad($x1)) * sin(deg2rad($x2)) + cos(deg2rad($x1)) * cos(deg2rad($x2)) * cos(deg2rad($y1 - $y2)))) * 60 * 114 / 99;
				}
				
				if (isset($settings['distance_units']) && $settings['distance_units'] == 'km') {
					$distance *= 1.609344;
				}
				$this->logMessage('Calculated distance between ' . $store_address . ' and ' . $customer_address . ' = ' . round($distance, 3) . ' ' . $settings['distance_units']);
			}
			
			if (isset($rules['distance'])) {
				$this->commaMerge($rules['distance']);
				
				foreach ($rules['distance'] as $comparison => $distances) {
					$in_range = $this->inRange($distance, $distances, 'distance');
					
					if (($comparison == 'is' && !$in_range) || ($comparison == 'not' && $in_range)) {
						continue 2;
					}
				}
			}
			
			if (isset($rules['postcode'])) {
				$this->commaMerge($rules['postcode']);
				
				foreach ($rules['postcode'] as $comparison => $postcodes) {
					$in_range = $this->inRange($address['postcode'], $postcodes, 'postcode');
					
					if (($comparison == 'is' && !$in_range) || ($comparison == 'not' && $in_range)) {
						continue 2;
					}
				}
			}
			
			// Check order criteria
			if ($this->ruleViolation('currency', $currency) ||
				$this->ruleViolation('customer_group', $customer_group_id) ||
				$this->ruleViolation('language', $language) ||
				$this->ruleViolation('payment_extension', $payment_method) ||
				$this->ruleViolation('shipping_extension', $shipping_method) ||
				$this->ruleViolation('store', $store_id)
			) {
				continue;
			}
			
			if (isset($rules['past_orders'])) {
				$past_orders_query = $this->db->query("SELECT IFNULL(MIN(ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 86400)), 0) AS days, IFNULL(COUNT(*), 0) AS quantity, IFNULL(AVG(total), 0) AS average, IFNULL(SUM(total), 0) AS total FROM `" . DB_PREFIX . "order` WHERE customer_id = " . (int)$customer_id . " AND customer_id != 0 AND order_status_id > 0");
				foreach ($rules['past_orders'] as $comparison => $values) {
					if (!$this->inRange($past_orders_query->row[$comparison], $values, 'past order')) {
						continue 2;
					}
				}
			}
			
			if (isset($rules['shipping_rate'])) {
				$this->commaMerge($rules['shipping_rate']);
				$skip_charge = true;
				$skip_message = '';
				
				foreach ($rules['shipping_rate'] as $comparison => $values) {
					foreach ($values as $value) {
						if (($comparison == 'is' && strpos($shipping_rate, $value) !== false) || ($comparison == 'not' && strpos($shipping_rate, $value) === false)) {
							$skip_charge = false;
						} else {
							$skip_message = '"' . $row['name'] . '" disabled for violating rule "shipping_rate ' . $comparison . ' ' . $value . '"';
						}
					}
				}
				
				if ($skip_charge) {
					$this->logMessage($skip_message);
					continue;
				}
			}
			
			// Generate comparison values
			$cart_criteria = array(
				'length',
				'width',
				'height',
				'quantity',
				'stock',
				'total',
				'volume',
				'weight',
			);
			
			foreach ($cart_criteria as $spec) {
				${$spec.'s'} = array();
				if (isset($rules[$spec])) {
					$this->commaMerge($rules[$spec]);
				}
			}
			
			$categorys = array();
			$manufacturers = array();
			$products = array();
			
			$product_keys = array();
			$total_value = $cumulative_total_value;
			
			foreach ($cart_products as $product) {
				if ($this->type == 'shipping' && !$product['shipping']) {
					$total_value -= $product['total'];
					$this->logMessage($product['name'] . ' (product_id: ' . $product['product_id'] . ') does not require shipping and was ignored');
					continue;
				}
				
				$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id = " . (int)$product['product_id']);
				
				// dimensions
				$length_class_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "length_class WHERE length_class_id = " . (int)$product['length_class_id']);
				if ($length_class_query->num_rows) {
					$lengths[$product['key']] = $this->length->convert($product['length'], $product['length_class_id'], $this->config->get('config_length_class_id'));
					$widths[$product['key']] = $this->length->convert($product['width'], $product['length_class_id'], $this->config->get('config_length_class_id'));
					$heights[$product['key']] = $this->length->convert($product['height'], $product['length_class_id'], $this->config->get('config_length_class_id'));
				} else {
					$message = $product['name'] . ' (product_id: ' . $product['product_id'] . ') does not have a valid length class, which causes a "Division by zero" error, and means it cannot be used for dimension/volume calculations. You can fix this by re-saving the product data.';
					$this->log->write($message);
					$this->logMessage($message);
					
					$lengths[$product['key']] = 0;
					$widths[$product['key']] = 0;
					$heights[$product['key']] = 0;
				}
				
				// stock
				$stocks[$product['key']] = $product_query->row['quantity'] - $product['quantity'];
				
				// quantity
				$quantitys[$product['key']] = $product['quantity'];
				
				// total
				if (isset($rules['total_value']) && $rules['total_value'][''][0] != 'cheapest') {
					$product_info = $this->model_catalog_product->getProduct($product['product_id']);
					$product_price = ($product_info['special']) ? $product_info['special'] : $product_info['price'];
					
					if ($rules['total_value'][''][0] == 'prediscounted') {
						$totals[$product['key']] = $product['total'] + ($product['quantity'] * ($product_query->row['price'] - $product_price));
					} elseif ($rules['total_value'][''][0] == 'nondiscounted') {
						$totals[$product['key']] = ($product_info['special']) ? 0 : $product['total'];
					} elseif ($rules['total_value'][''][0] == 'taxed') {
						$totals[$product['key']] = $this->tax->calculate($product['total'], $product['tax_class_id']);
					}
				} else {
					$totals[$product['key']] = $product['total'];
				}
				
				// volume
				$volumes[$product['key']] = $lengths[$product['key']] * $widths[$product['key']] * $heights[$product['key']] * $product['quantity'];
				
				// weight
				$weight_class_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "weight_class WHERE weight_class_id = " . (int)$product['weight_class_id']);
				if ($weight_class_query->num_rows) {
					$weights[$product['key']] = $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('config_weight_class_id'));
				} else {
					$message = $product['name'] . ' (product_id: ' . $product['product_id'] . ') does not have a valid weight class, which causes a "Division by zero" error, and means it cannot be used for weight calculations. You can fix this by re-saving the product data.';
					$this->log->write($message);
					$this->logMessage($message);
					
					$weights[$product['key']] = 0;
				}
				
				// categories
				$category_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = " . (int)$product['product_id']);
				if ($category_query->num_rows) {
					foreach ($category_query->rows as $category) {
						$categorys[$product['key']][] = $category['category_id'];
					}
				} else {
					$categorys[$product['key']][] = 0;
				}
				
				// manufacturer
				$manufacturers[$product['key']][] = $product_query->row['manufacturer_id'];
				
				// products
				$products[$product['key']][] = $product['product_id'];
				
				// Check item criteria (entire cart comparisons)
				foreach ($cart_criteria as $spec) {
					if (isset($rules['adjust']['item_' . $spec])) {
						foreach ($rules['adjust']['item_' . $spec] as $adjustment) {
							${$spec.'s'}[$product['key']] += (strpos($adjustment, '%')) ? ${$spec.'s'}[$product['key']] * (float)$adjustment / 100 : (float)$adjustment;
						}
					}
					
					if (isset($rules[$spec]['entire_any'])) {
						if (!$this->inRange(${$spec.'s'}[$product['key']], $rules[$spec]['entire_any'], $spec . ' of any item in entire cart', true)) {
							continue 2;
						}
					}
					
					if (isset($rules[$spec]['entire_every'])) {
						if (!$this->inRange(${$spec.'s'}[$product['key']], $rules[$spec]['entire_every'], $spec . ' of every item in entire cart', true)) {
							continue 3;
						}
					}
				}
				
				// Check product criteria
				if (isset($rules['category']) && $this->ruleViolation('category', $categorys[$product['key']])) {
					continue;
				}
				
				if (isset($rules['manufacturer']) && $this->ruleViolation('manufacturer', $product_query->row['manufacturer_id'])) {
					continue;
				}
				
				if (isset($rules['product']) && $this->ruleViolation('product', $product['product_id'])) {
					continue;
				}
				
				// Check item criteria (eligible item comparisons)
				foreach ($cart_criteria as $spec) {
					if (isset($rules[$spec]['any'])) {
						if (!$this->inRange(${$spec.'s'}[$product['key']], $rules[$spec]['any'], $spec . ' of any item', true)) {
							continue 2;
						}
					}
					
					if (isset($rules[$spec]['every'])) {
						if (!$this->inRange(${$spec.'s'}[$product['key']], $rules[$spec]['every'], $spec . ' of every item', true)) {
							continue 3;
						}
					}
				}
				
				// product passed all rules and is eligible for charge
				$product_keys[] = $product['key'];
			}
			
			// Check product group rules
			$row_disabled_text = '"' . $row['name'] . '" disabled [' . strtoupper($row['methods']) . ']';
			
			if (isset($rules['product_group'])) {
				$list_types = array(
					'category',
					'manufacturer',
					'product',
				);
				
				foreach ($list_types as $list_type) {
					${$list_type . 's_array'} = array();
					foreach (${$list_type . 's'} as $list) {
						${$list_type . 's_array'} = array_merge(${$list_type . 's_array'}, $list);
					}
				}
				
				$eligible_products = array();
				$ineligible_products = array();
				
				foreach ($rules['product_group'] as $comparison => $product_group_ids) {
					$rule_satisfied = false;
					
					foreach ($product_group_ids as $product_group_id) {
						if (empty($settings['product_group'][$product_group_id]['member'])) continue;
						
						$product_group_rule_text = 'cart has items from ' . ($comparison == 'none' ? 'none of the' : $comparison) . ' members of ' . $settings['product_group'][$product_group_id]['name'];
						unset($members_array);
						
						foreach ($settings['product_group'][$product_group_id]['member'] as $member) {
							$bracket = strrpos($member, '[');
							$colon = strrpos($member, ':');
							$member_type = substr($member, $bracket + 1, $colon - $bracket - 1);
							$members_array[$member_type][] = substr($member, $colon + 1, -1);
						}
						
						foreach ($members_array as $type => $members) {
							// Check "all" and "onlyall" comparisons
							if (($comparison == 'all' || $comparison == 'onlyall') && array_diff($members, ${$type.'s_array'})) {
								$this->logMessage($row_disabled_text . ' for violating product group rule "' . $product_group_rule_text . '", due to missing ' . $type . '_id(s) "' . implode(', ', array_diff($members, ${$type.'s_array'})) . '"');
								continue 4;
							}
							
							// Check product eligibility
							foreach ($cart_products as $product) {
								if ($this->type == 'shipping' && !$product['shipping']) {
									continue;
								}
								if ((($comparison == 'onlyany' || $comparison == 'onlyall') && array_diff(${$type.'s'}[$product['key']], $members)) ||
									($comparison == 'none' && array_intersect(${$type.'s'}[$product['key']], $members))
								) {
									$this->logMessage($row_disabled_text . ' for violating product group rule "' . $product_group_rule_text . '"');
									continue 5;
								} elseif (($comparison != 'not' && $comparison != 'none' && !array_intersect(${$type.'s'}[$product['key']], $members)) ||
									(($comparison == 'not' || $comparison == 'none') && !array_diff(${$type.'s'}[$product['key']], $members))
								) {
									$ineligible_products[] = $product['key'];
								} else {
									$rule_satisfied = true;
									$eligible_products[] = $product['key'];
								}
							}
						}
					}
					
					// Check that rule has at least one matching product
					if (!$rule_satisfied) {
						$this->logMessage($row_disabled_text . ' for having no eligible products');
						continue 2;
					}
				}
				
				// Remove ineligible products
				foreach ($ineligible_products as $ineligible_key) {
					if (in_array($ineligible_key, $eligible_products)) continue;
					foreach ($product_keys as $index => $product_key) {
						if ($product_key == $ineligible_key) unset($product_keys[$index]);
					}
				}
			}
			
			// Check for empty product list
			if (empty($product_keys) && empty($this->session->data['vouchers'])) {
				$this->logMessage($row_disabled_text . ' for having no eligible products');
				continue;
			}
			
			// Check cart criteria and generate total comparison values
			$single_foreign_currency = (isset($rules['currency']['is']) && count($rules['currency']['is']) == 1 && $default_currency != $currency) ? $rules['currency']['is'][0] : '';
			
			foreach ($cart_criteria as $spec) {
				// note: cart_comparison to be added here if requested
				if ($spec == 'total' && isset($rules['total_value']) && $rules['total_value'][''][0] == 'shipping_cost') {
					$total = $shipping_cost;
					$cart_total = $shipping_cost;
				} elseif ($spec == 'total' && isset($rules['total_value']) && $rules['total_value'][''][0] == 'total') {
					$total = $total_value;
					$cart_total = $total_value;
				} else {
					${$spec} = 0;
					foreach ($product_keys as $product_key) {
						${$spec} += ${$spec.'s'}[$product_key];
					}
					${'cart_'.$spec} = array_sum(${$spec.'s'});
				}
				
				if ($spec == 'total' && $single_foreign_currency) {
					$total = $this->currency->convert($total, $default_currency, $single_foreign_currency);
				}
				
				if (isset($rules['adjust']['cart_' . $spec])) {
					foreach ($rules['adjust']['cart_' . $spec] as $adjustment) {
						${$spec} += (strpos($adjustment, '%')) ? ${$spec} * (float)$adjustment / 100 : (float)$adjustment;
						${'cart_'.$spec} += (strpos($adjustment, '%')) ? ${'cart_'.$spec} * (float)$adjustment / 100 : (float)$adjustment;
					}
				}
				
				if (isset($rules[$spec]['cart'])) {
					if (!$this->inRange(${$spec}, $rules[$spec]['cart'], $spec . ' of cart')) {
						continue 2;
					}
				}
				
				if (isset($rules[$spec]['entire_cart'])) {
					if (!$this->inRange(${'cart_'.$spec}, $rules[$spec]['entire_cart'], $spec . ' of entire cart')) {
						continue 2;
					}
				}
			}
			
			// Restore setting defaults
			foreach ($defaults as $key => $value) {
				$this->config->set($key, $value);
			}
			
			// All rules have been met, so enable extensions
			$enabled = array_unique(array_merge($enabled, $methods));
			
		} // end row loop
		
		// Remove disabled methods
		foreach ($extensions as $index => $extension) {
			if (!in_array($extension['code'], $enabled) && in_array($extension['code'], $disabled)) {
				unset($extensions[$index]);
			}
		}
		
		return $extensions;
	}
	
	//------------------------------------------------------------------------------
	// Private functions
	//------------------------------------------------------------------------------
	private function getSettings() {
		$settings = array();
		$settings_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `" . (version_compare(VERSION, '2.0.1', '<') ? 'group' : 'code') . "` = '" . $this->db->escape($this->name) . "' ORDER BY `key` ASC");
		
		foreach ($settings_query->rows as $setting) {
			$value = $setting['value'];
			if ($setting['serialized']) {
				$value = (version_compare(VERSION, '2.1', '<')) ? unserialize($setting['value']) : json_decode($setting['value'], true);
			}
			$split_key = preg_split('/_(\d+)_?/', str_replace($this->name . '_', '', $setting['key']), -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
			
				if (count($split_key) == 1)	$settings[$split_key[0]] = $value;
			elseif (count($split_key) == 2)	$settings[$split_key[0]][$split_key[1]] = $value;
			elseif (count($split_key) == 3)	$settings[$split_key[0]][$split_key[1]][$split_key[2]] = $value;
			elseif (count($split_key) == 4)	$settings[$split_key[0]][$split_key[1]][$split_key[2]][$split_key[3]] = $value;
			else 							$settings[$split_key[0]][$split_key[1]][$split_key[2]][$split_key[3]][$split_key[4]] = $value;
		}
		
		return $settings;
	}
	
	private function logMessage($message) {
		if ($this->testing_mode) {
			file_put_contents(DIR_LOGS . $this->name . '.messages', print_r($message, true) . "\n", FILE_APPEND|LOCK_EX);
		}
	}
	
	private function commaMerge(&$rule) {
		$merged_rule = array();
		foreach ($rule as $comparison => $values) {
			$merged_rule[$comparison] = array();
			foreach ($values as $value) {
				$merged_rule[$comparison] = array_merge($merged_rule[$comparison], array_map('trim', explode(',', strtolower($value))));
			}
		}
		$rule = $merged_rule;
	}
	
	private function ruleViolation($rule, $value) {
		$violation = false;
		$rules = $this->row['rules'];
		$function = (is_array($value)) ? 'array_intersect' : 'in_array';
		
		if (isset($rules[$rule]['after']) && strtotime($value) < min(array_map('strtotime', $rules[$rule]['after']))) {
			$violation = true;
			$comparison = 'after';
		}
		if (isset($rules[$rule]['before']) && strtotime($value) > max(array_map('strtotime', $rules[$rule]['before']))) {
			$violation = true;
			$comparison = 'before';
		}
		if (isset($rules[$rule]['is']) && !$function($value, $rules[$rule]['is'])) {
			$violation = true;
			$comparison = 'is';
		}
		if (isset($rules[$rule]['not']) && $function($value, $rules[$rule]['not'])) {
			$violation = true;
			$comparison = 'not';
		}
		
		if ($violation) {
			$this->log->write(strtoupper($this->name) . ': "' . $this->row['name'] . '" disabled [' . strtoupper($this->row['methods']) . '] for violating rule "' . $rule . ' ' . $comparison . ' ' . implode(', ', $rules[$rule][$comparison]) . '" with value "' . (is_array($value) ? implode(',', $value) : $value) . '"');
		}
		
		return $violation;
	}
	
	private function inRange($value, $range_list, $charge_type = '', $skip_testing = false) {
		$in_range = false;
		
		foreach ($range_list as $range) {
			if ($range == '') continue;
			
			$range = (strpos($range, '::')) ? explode('::', $range) : explode('-', $range);
			
			if (strpos($charge_type, 'distance') === 0) {
				if (empty($range[1])) {
					array_unshift($range, 0);
				}
				if ($value >= (float)$range[0] && $value <= (float)$range[1]) {
					$in_range = true;
				}
			} elseif (strpos($charge_type, 'postcode') === 0) {
				$postcode = preg_replace('/[^A-Z0-9]/', '', strtoupper($value));
				$from = preg_replace('/[^A-Z0-9]/', '', strtoupper($range[0]));
				$to = (isset($range[1])) ? preg_replace('/[^A-Z0-9]/', '', strtoupper($range[1])) : $from;
				
				if (strlen($from) < 3 && !preg_match('/[0-9]/', $from)) $from .= '1';
				if (strlen($to) < 3 && !preg_match('/[0-9]/', $to)) $to .= '99';
				
				if (strlen($from) < strlen($postcode)) $from = str_pad($from, strlen($from) + 3, ' ');
				if (strlen($to) < strlen($postcode)) $to = str_pad($to, strlen($to) + 3, preg_match('/[A-Z]/', $postcode) ? 'Z' : '9');
				
				$postcode = substr_replace(substr_replace($postcode, ' ', -3, 0), ' ', -2, 0);
				$from = substr_replace(substr_replace($from, ' ', -3, 0), ' ', -2, 0);
				$to = substr_replace(substr_replace($to, ' ', -3, 0), ' ', -2, 0);
				
				if (strnatcasecmp($postcode, $from) >= 0 && strnatcasecmp($postcode, $to) <= 0) {
					$in_range = true;
				}
			} else {
				if ($charge_type != 'attribute' && $charge_type != 'option' && $charge_type != 'other product data' && !isset($range[1])) {
					$range[1] = 999999999;
				}
				
				if ((count($range) > 1 && $value >= $range[0] && $value <= $range[1]) || (count($range) == 1 && $value == $range[0])) {
					$in_range = true;
				}
			}
		}
		
		if (!$skip_testing) {
			if (strpos($charge_type, ' not') ? $in_range : !$in_range) {
				$this->logMessage('"' . $this->row['name'] . '" disabled [' . strtoupper($this->row['methods']) . '] for violating rule "' . $charge_type . (strpos($charge_type, ' not') ? ' is not ' : ' is ') . implode(', ', $range_list) . '" with value "' . $value . '"');
			}
		}
		
		return $in_range;
	}
}
?>