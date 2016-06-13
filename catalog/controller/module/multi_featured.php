<?php

/**
 * Multiple Featured Module Pro
 * 
 * @author  Kyo (AKA Yasuhiro Sota)
 * @version 3.2.2
 * @license Commercial License
 * @package catalog
 * @subpackage  catalog.controller.module
 */
if (!defined('IS_MIJOSHOP')) {
  define('IS_MIJOSHOP', defined('_JEXEC') && defined('JPATH_MIJOSHOP_ADMIN'));
}

if (IS_MIJOSHOP) {
  // No Permission
  defined('_JEXEC') or die('Restricted access');
}

class ControllerModuleMultiFeatured extends Controller {

/**
 * Name of module key
 *
 * @var string
 */  
  protected $module_key = 'multi_featured';

/**
 * The default display limit of products.
 *
 * @var string
 */  
  protected $default_product_limit = 4;
  
/**
 * index method
 *
 * @param array $setting
 * @return void
 */
  public function index($setting) {
    
    if (!$this->config->get($this->module_key . '_status')) {
      return false;
    }
    
    if (!$setting) {
      return false;
    }
    
    if (!$setting['status']) {
      return false;
    }
    
    // Configuration
    if (!$this->config->get($this->module_key . '_config')) {
      return false;
    }
    
    $config = $this->config->get($this->module_key . '_config');
        
    
    static $module = 0;
    
    if (version_compare(VERSION, '2.0.1.0', '<')) { // for OpenCart 2.0.0.0 or earlier.
      
      if (!$setting['featured_id']) {
        return false;
      }

      $featured = $this->config->get($this->module_key . '_' . $setting['featured_id']);
      
    } else { // for OpenCart 2.0.1.0 or later.
      $featured = $setting;
      $setting['featured_id'] = $setting['module_id'];
    }
    
    
    // Stores
    $stores = array();
    
    if (isset($featured['stores'])) {
      $stores = (array)$featured['stores'];
    }

    if (!$stores || !in_array($this->config->get('config_store_id'), $stores)) {
      return false;
    }

    // Access levels
    $customer_group_display = array();
    
    if (isset($featured['access_levels'])) {
      $customer_group_display = (array)$featured['access_levels'];
    }    

    if (!$this->customer->isLogged() && !in_array(0, $customer_group_display)) {
      return false;
    }

    if ($this->customer->isLogged()) {

      $this->load->model('account/customer_group');
      $customer_group_info = $this->model_account_customer_group->getCustomerGroup($this->config->get('config_customer_group_id'));

      if (!in_array($customer_group_info['customer_group_id'], $customer_group_display)) {
        return false;
      }
    }
    
    // Stylesheet
    if ($featured['use_default_stylesheet']) {
      if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/multi_featured.css')) {
        $this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/multi_featured.css');
      } else {
        $this->document->addStyle('catalog/view/theme/default/stylesheet/multi_featured.css');
      }
    }

    // User-defined CSS files
    if ($featured['stylesheet']) {
      $stylesheet_paths = explode("\r\n", (string) $featured['stylesheet']);

      foreach ($stylesheet_paths as $css_file_path) {
        $css_file_path = trim($css_file_path);
        
        if (!$css_file_path) {
          continue;
        }
        
        // Replace [THEME] with the current template name.
        $path = preg_replace("/\[THEME\]/", $this->config->get('config_template'), $css_file_path);

        if (file_exists($path)) {
          $this->document->addStyle($path);
        } else {
          // Replace [THEME] with the default template name.
          $this->document->addStyle(preg_replace("/\[THEME\]/", 'default', $css_file_path));
        }
      }
    }
    unset($path);
    
    
    // User-defined JS files
    if ($featured['javascript']) {
      $javascript_paths = explode("\r\n", (string) $featured['javascript']);

      foreach ($javascript_paths as $js_file_path) {
        $js_file_path = trim($js_file_path);
        
        if (!$js_file_path) {
          continue;
        }
        
        // Replace [THEME] with the current template name.
        $path = preg_replace("/\[THEME\]/", $this->config->get('config_template'), $js_file_path);

        if (file_exists($path)) {
          $this->document->addScript($path);
        } else {
          // Replace [THEME] with the default template name.
          $this->document->addScript(preg_replace("/\[THEME\]/", 'default', $js_file_path));
        }        
        
      }
    }

    $data = array();
    
    $this->language->load('module/multi_featured');

    // Title
    if (isset($featured['title'][(int)$this->config->get('config_language_id')]) && $featured['title'][(int)$this->config->get('config_language_id')]) {
      $data['heading_title'] = $featured['title'][(int)$this->config->get('config_language_id')];
    } else {
      $data['heading_title'] = $this->language->get('heading_title');
    }

    // Title link
    if ($featured['title_link']) {
      $data['heading_title_link'] = $featured['title_link'];
    } else {
      $data['heading_title_link'] = "";
    }

    // Parameters
    $params = array();

    if ($featured['params']) {
      $array_params = explode("\r\n", (string) $featured['params']);

      foreach ($array_params as $param) {
        if (strpos($param, ':') !== false) {
          // Split a string at the first occurrence of “:” (colon sign) into two $vars
          list($key, $value) = explode(':', $param, 2);

          if (trim($key)) {
            $params[trim($key)] = html_entity_decode(trim($value));
          }
        }
      }
    }

    $data['params'] = $params;


    // Text
		$data['text_tax'] = $this->language->get('text_tax');    
    $data['text_view_more'] = $this->language->get('text_view_more');
    
    // Button
    $data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');    
    $data['button_view_more'] = $this->language->get('button_view_more');


    // Products
    $data['products'] = array();

    $product_ids = null;

    if ($featured['product']) {
      $product_ids = $featured['product'];
    }

    if (empty($setting['limit'])) {
      $setting['limit'] = $this->default_product_limit;
    }

    // Display out-of-stock products 
    $disp_oos_prods = false;

    if ($featured['disp_oos_prods']) {
      $disp_oos_prods = $featured['disp_oos_prods'];
    }

    $this->load->model('module/multi_featured');

    // Random Product Display
    $random_products = false;

    if ($featured['random_products'] != '') {
      $random_products = $featured['random_products'];
    }

    // Set the ID for caching.
    $this->model_module_multi_featured->cache_id = $setting['featured_id'];

    $options = array(
        'limit' => (int)$setting['limit'],
        'disp_oos_prods' => (bool)$disp_oos_prods,
        'module_key' => $this->module_key,
        'cache_expire' => (isset($config['cache_expire']) && is_numeric($config['cache_expire'])) ? $config['cache_expire'] : 3600,
        'module_id' => (int)$setting['module_id'],
        'language_id' => (int)$this->config->get('config_language_id'),
        'currency' => $this->session->data['currency']
    );
    
    switch ($random_products) {
      case 0: // Display products in a specific order as specified in the product list.
        $products = $this->model_module_multi_featured->getProductIds($product_ids, $options);
        break;
      case 1: // Display products randomly by shuffling the partial list of products controlled by limit.
        $products = $this->model_module_multi_featured->getProductIds($product_ids, $options);
        shuffle($products);
        break;
      case 2: // Display products randomly by shuffling the whole product list.
        $product_ids = $this->_shuffleCommaSeparatedValues($product_ids);
        $products = $this->model_module_multi_featured->getProductIds($product_ids, $options);
        shuffle($products);
    }

    unset($product_ids, $options);


    $this->load->model('catalog/product');
    $this->load->model('tool/image');

    foreach ($products as $product_id) {
      $product_info = $this->model_catalog_product->getProduct($product_id);

      if ($product_info) {
        if ($product_info['image']) {
          $image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
        } else {
          if (version_compare(VERSION, '2.2.0.0', '<')) { // for OpenCart 2.1.0.2 or earlier.
            $image = false;
          } else {
            $image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
          }
        }

        if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
          if (version_compare(VERSION, '2.2.0.0', '<')) { // for OpenCart 2.1.0.2 or earlier.
            $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
          } else {
            $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
          }
        } else {
          $price = false;
        }

        if ((float) $product_info['special']) {
          if (version_compare(VERSION, '2.2.0.0', '<')) { // for OpenCart 2.1.0.2 or earlier.
            $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
          } else {
            $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
          }
        } else {
          $special = false;
        }

				if ($this->config->get('config_tax')) {
          if (version_compare(VERSION, '2.2.0.0', '<')) { // for OpenCart 2.1.0.2 or earlier.
            $tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
          } else {
            $tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
          }
				} else {
					$tax = false;
				}
        
        if ($this->config->get('config_review_status')) {
          $rating = $product_info['rating'];
        } else {
          $rating = false;
        }
        
        if (version_compare(VERSION, '2.2.0.0', '<')) { // for OpenCart 2.1.0.2 or earlier.
          $description = utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..';
				} else {
          $description = utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..';
				}        

        $data['products'][] = array(
            'product_id' => $product_info['product_id'],
            'thumb' => $image,
            'name' => $product_info['name'],
            'description' => $description,
            'price' => $price,
            'special' => $special,
            'tax' => $tax,
            'rating' => $rating,
            'reviews' => sprintf($this->language->get('text_reviews'), (int) $product_info['reviews']),
            'href' => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
        );
      }
    }

    // Module
    $data['module'] = $module++;


    // Template
    if (!$data['products']) {
      return false;
    }
    
    
    $template = null;
    
    if (version_compare(VERSION, '2.2.0.0', '<')) { // for OpenCart 2.1.0.2 or earlier.
      if (!$featured['use_default_template'] && $featured['template']) {
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/multi_featured_' . $featured['template'] . '.tpl')) {
          $template = $this->config->get('config_template') . '/template/module/multi_featured_' . $featured['template'] . '.tpl';
        } else {
          $template = 'default/template/module/multi_featured_' . $featured['template'] . '.tpl';
        }
      } else {
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/multi_featured.tpl')) {
          $template = $this->config->get('config_template') . '/template/module/multi_featured.tpl';
        } else {
          $template = 'default/template/module/multi_featured.tpl';
        }
      }
    } else {
      if (!$featured['use_default_template'] && $featured['template']) {
        $template = 'module/multi_featured_' . $featured['template'];
      } else {
        $template = 'module/multi_featured';
      }
    }

    return $this->load->view($template, $data);
  }

/**
 * Shuffle comma separated values.
 *
 * @param string $string Comma separated string
 * @return Formatted comma separated string
 */
  protected function _shuffleCommaSeparatedValues($string) {
    if (!$string) {
      return false;
    }
    $array = explode(",", $string);
    shuffle($array);
    return implode(",", $array);
  }

}
