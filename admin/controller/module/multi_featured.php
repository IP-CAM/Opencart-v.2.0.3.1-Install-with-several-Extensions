<?php
/**
 * Multiple Featured Module Pro
 * 
 * @author  Kyo (AKA Yasuhiro Sota)
 * @version 3.2.2
 * @license Commercial License
 * @package admin
 * @subpackage  admin.controller
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
 * List of validation errors.
 *
 * @var array
 */
  private $error = array();

/**
 * Name of module key
 *
 * @var string
 */  
  protected $module_key = 'multi_featured';

/**
 * Constructor.
 *
 * @param object $registry
 * @return void
 */
	public function __construct($registry) {
    parent::__construct($registry); 
	}

/**
 * index method
 *
 * @param void
 * @return void
 */    
  public function index() {
    $this->language->load('module/multi_featured');   

    $this->document->setTitle($this->language->get('heading_title'));
    
    if (IS_MIJOSHOP) {
      $this->document->addStyle('../opencart/admin/view/stylesheet/multi_featured.css');
      $this->document->addStyle('../opencart/admin/view/stylesheet/multi_featured_mijoshop.css');
    } else {
      $this->document->addStyle('view/stylesheet/multi_featured.css');
    }

    $this->document->addScript('view/javascript/multi_featured/jquery-ui/1.11.1/ui/core.js');
    $this->document->addScript('view/javascript/multi_featured/jquery-ui/1.11.1/ui/widget.js');
    $this->document->addScript('view/javascript/multi_featured/jquery-ui/1.11.1/ui/mouse.js');
    $this->document->addScript('view/javascript/multi_featured/jquery-ui/1.11.1/ui/position.js');
    $this->document->addScript('view/javascript/multi_featured/jquery-ui/1.11.1/ui/menu.js');
    $this->document->addScript('view/javascript/multi_featured/jquery-ui/1.11.1/ui/autocomplete.js');
    $this->document->addScript('view/javascript/multi_featured/jquery-ui/1.11.1/ui/sortable.js');
    $this->document->addScript('view/javascript/multi_featured/jquery-ui/1.11.1/ui/draggable.js');
    $this->document->addScript('view/javascript/multi_featured/jquery-ui/1.11.1/ui/resizable.js');
    
    $this->document->addStyle('view/javascript/multi_featured/jquery-ui/1.11.1/themes/base/core.css');
    $this->document->addStyle('view/javascript/multi_featured/jquery-ui/1.11.1/themes/base/autocomplete.css');
    $this->document->addStyle('view/javascript/multi_featured/jquery-ui/1.11.1/themes/base/sortable.css');
    $this->document->addStyle('view/javascript/multi_featured/jquery-ui/1.11.1/themes/base/draggable.css');
    $this->document->addStyle('view/javascript/multi_featured/jquery-ui/1.11.1/themes/base/resizable.css');
    $this->document->addStyle('view/javascript/multi_featured/jquery-ui/1.11.1/themes/base/menu.css');
    $this->document->addStyle('view/javascript/multi_featured/jquery-ui/1.11.1/themes/base/theme.css');

    $this->document->addScript('view/javascript/multi_featured/jquery.ba-resize.min.js');
    $this->document->addScript('view/javascript/multi_featured/jquery.kh-cookie.min.js');
    
    $this->document->addScript('view/javascript/multi_featured/multi_featured.min.js');
    
    
    $this->load->model('setting/setting');

    if ($this->request->server['REQUEST_METHOD'] == 'POST') {

      if ($this->validate()) {

        for ($i = 1; $i <= $this->request->post['multi_featured_count']; $i++) {
          // Remove data related to the autocomplete field to prevent it from being saved.
          if (isset($this->request->post["product_{$i}"])) {
            unset($this->request->post["product_{$i}"]);
          }
        }

        unset($this->request->post['multi_featured_count']);

        foreach($this->request->post as $key => $value) {
          // Remove data related to the filter fields to prevent it from being saved.
          if (substr($key, 0, 7) === 'filter_') {
            unset($this->request->post[$key]);

          } else {
            // Remove empty data to prevent it from being saved.
            if (!$value) {
              unset($this->request->post[$key]);
            }
          }
        }
        
        // The following line decides if it is a "save" or "save and continue"
        $url = '';
        
        if ($this->request->post['redirect_after_save'] == 'save') {
          // Submit form and stay on same page
          $url = $this->url->link('module/' . $this->module_key, 'token=' . $this->session->data['token'], 'SSL');

        } elseif ($this->request->post['redirect_after_save'] == 'save-and-close') {
          $url = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        }
        unset($this->request->post['redirect_after_save']);
        
        
        $this->load->model('module/multi_featured');
        
        // Set the version of this extension.
        $this->request->post[$this->module_key . '_version'] = $this->model_module_multi_featured->version();


        $postData = array();
        
        // For duplicated module.
        if ($this->module_key != 'multi_featured') {
          
          foreach($this->request->post as $key => $value) {
            if (strrpos($key, '_') !== false) {
              $pos = strrpos($key, '_');
              $postData[$this->module_key . '_' .  substr($key, $pos + 1)] = $value;
            }
          }
          unset($key, $value);

        } else {
          $postData = $this->request->post;
        }        
        
        // Save the data.
        if (version_compare(VERSION, '2.0.1.0', '<')) { // for OpenCart 2.0.0.0 or earlier.
          // Modules
          $postData[$this->module_key . '_module'] = array();
          
          foreach ($postData as $key => $value) {
            if (strpos($key, 'multi_featured_') === 0 && is_array($value)) {
              $featured_id = null;
              
              if (strrpos($key, '_') !== false) {
                $pos = strrpos($key, '_');
                $featured_id = substr($key, $pos + 1);
                
                if (is_numeric($featured_id)) {
                  $postData['multi_featured_module'][$featured_id]['featured_id'] = $featured_id;
                  $postData['multi_featured_module'][$featured_id]['limit'] = $value['limit'];
                  $postData['multi_featured_module'][$featured_id]['width'] = $value['width'];
                  $postData['multi_featured_module'][$featured_id]['height'] = $value['height'];
                  $postData['multi_featured_module'][$featured_id]['status'] = $value['status'];
                }
              }
            }
          }
          
          $this->load->model('setting/setting');
          $this->model_setting_setting->editSetting($this->module_key, $postData);

        } else {
          $this->load->model('module/multi_featured');
          $this->model_module_multi_featured->editSetting($this->module_key, $postData);
        }
        
        
        $this->cache->delete($this->module_key);

        $this->session->data['success'] = $this->language->get('text_success');
        
        $this->response->redirect($url);
      }
    }
    
    $this->load->model('module/multi_featured');
    
    $data = array();
    
    // Module key
    $data['module_key'] = $this->module_key;
    
    // Version
    $data['version'] = $this->model_module_multi_featured->version();
    
    // Heading Title
    $data['heading_title'] = $this->language->get('heading_title');
    
    // Tab
    $data['tab_featured_product_lists'] = $this->language->get('tab_featured_product_lists');
    $data['tab_config'] = $this->language->get('tab_config');
    $data['tab_modules'] = $this->language->get('tab_modules');
    $data['tab_layouts'] = $this->language->get('tab_layouts');
    
    // Text
    $data['text_enabled'] = $this->language->get('text_enabled');
    $data['text_disabled'] = $this->language->get('text_disabled');
    $data['text_content_top'] = $this->language->get('text_content_top');
    $data['text_content_bottom'] = $this->language->get('text_content_bottom');
    $data['text_column_left'] = $this->language->get('text_column_left');
    $data['text_column_right'] = $this->language->get('text_column_right');
    $data['text_confirm_delete_product_list'] = $this->language->get('text_confirm_delete_product_list');
    $data['text_featured_content'] = $this->language->get('text_featured_content');
    $data['text_add_featured_content'] = $this->language->get('text_add_featured_content');
    $data['text_check_all'] = $this->language->get('text_check_all');
    $data['text_uncheck_all'] = $this->language->get('text_uncheck_all');
    $data['text_random_products_0'] = $this->language->get('text_random_products_0');
    $data['text_random_products_1'] = $this->language->get('text_random_products_1');
    $data['text_random_products_2'] = $this->language->get('text_random_products_2');
    $data['text_edit'] = $this->language->get('text_edit');
    $data['text_tab_filter_no_result'] = $this->language->get('text_tab_filter_no_result');
    $data['text_general'] = $this->language->get('text_general');
    
    // Entry
    $data['entry_name'] = $this->language->get('entry_name');
    $data['entry_title'] = $this->language->get('entry_title');
    $data['entry_title_link'] = $this->language->get('entry_title_link');
    $data['entry_product'] = $this->language->get('entry_product');
    $data['entry_incl_dab_prods'] = $this->language->get('entry_incl_dab_prods');
    $data['entry_product_list'] = $this->language->get('entry_product_list');
    $data['entry_random_products'] = $this->language->get('entry_random_products');
    $data['entry_disp_oos_prods'] = $this->language->get('entry_disp_oos_prods');
    $data['entry_stores'] = $this->language->get('entry_stores');
    $data['entry_access_levels'] = $this->language->get('entry_access_levels');
    $data['entry_template'] = $this->language->get('entry_template');
    $data['entry_use_default_template'] = $this->language->get('entry_use_default_template');
    $data['entry_stylesheet'] = $this->language->get('entry_stylesheet');
    $data['entry_use_default_stylesheet'] = $this->language->get('entry_use_default_stylesheet');
    $data['entry_javascript'] = $this->language->get('entry_javascript');
    $data['entry_params'] = $this->language->get('entry_params');
    $data['entry_multi_featured_id'] = $this->language->get('entry_multi_featured_id');
    $data['entry_limit'] = $this->language->get('entry_limit');
    $data['entry_image'] = $this->language->get('entry_image');
    $data['entry_layout'] = $this->language->get('entry_layout');
    $data['entry_position'] = $this->language->get('entry_position');
    $data['entry_status'] = $this->language->get('entry_status');
    $data['entry_sort_order'] = $this->language->get('entry_sort_order');
    $data['entry_filter_tabs'] = $this->language->get('entry_filter_tabs');
    $data['entry_width'] = $this->language->get('entry_width');
    $data['entry_height'] = $this->language->get('entry_height');
    $data['entry_cache_expire'] = $this->language->get('entry_cache_expire');
    
    // Help
    $data['help_name'] = $this->language->get('help_name');
    $data['help_title'] = $this->language->get('help_title');
    $data['help_title_link'] = $this->language->get('help_title_link');
    $data['help_product'] = $this->language->get('help_product');
    $data['help_product_list'] = $this->language->get('help_product_list');
    $data['help_stores'] = $this->language->get('help_stores');
    $data['help_access_levels'] = $this->language->get('help_access_levels');
    $data['help_template'] = $this->language->get('help_template');
    $data['help_stylesheet'] = $this->language->get('help_stylesheet');
    $data['help_javascript'] = $this->language->get('help_javascript');
    $data['help_params'] = $this->language->get('help_params');
    $data['help_cache_expire'] = $this->language->get('help_cache_expire');
    
    // Button
    $data['button_save'] = $this->language->get('button_save');
    $data['button_save_and_close'] = $this->language->get('button_save_and_close');
    $data['button_cancel'] = $this->language->get('button_cancel');
    $data['button_module_add'] = $this->language->get('button_module_add');
    $data['button_remove'] = $this->language->get('button_remove');
    $data['button_clear_filters'] = $this->language->get('button_clear_filters');

		// Success
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
    
    // Warning
    if (isset($this->error['warning'])) {
      $data['error_warning'] = $this->error['warning'];
    } else {
      $data['error_warning'] = '';
    }
    
    if (isset($this->error['warning_multiple'])) {
      $data['error_warning_multiple'] = $this->error['warning_multiple'];
    } else {
      $data['error_warning_multiple'] = array();
    }
    
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		
		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}
		
		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
    }

    if (isset($this->error['image'])) {
      $data['error_image'] = $this->error['image'];
    } else {
      $data['error_image'] = array();
    }

    if (isset($this->error['featured_id'])) {
      $data['error_featured_id'] = $this->error['featured_id'];
    } else {
      $data['error_featured_id'] = array();
    }

    if (isset($this->error['template'])) {
      $data['error_template'] = $this->error['template'];
    } else {
      $data['error_template'] = array();
    }

    // Breadcrumbs
    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_home'),
        'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
    );

    $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_module'),
        'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
    );

    $data['breadcrumbs'][] = array(
        'text' => $this->language->get('heading_title'),
        'href' => $this->url->link('module/' . $this->module_key, 'token=' . $this->session->data['token'], 'SSL')
    );

    $data['action'] = $this->url->link('module/' . $this->module_key, 'token=' . $this->session->data['token'], 'SSL');

    $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
    
    $data['link_to_layout'] = $this->url->link('design/layout', 'token=' . $this->session->data['token'], 'SSL');
    
    $data['token'] = $this->session->data['token'];
    
    
    if (isset($this->request->get['module_id']) && $this->request->get['module_id']) {
      $data['module_id'] = $this->request->get['module_id'];
    } else {
      $data['module_id'] = '';
    }
    
    
		// Configuration: Status
    if (isset($this->request->post['multi_featured_status'])) {
			$data['multi_featured_status'] = $this->request->post['multi_featured_status'];
		} else {
			$data['multi_featured_status'] = $this->config->get('multi_featured_status');
		}

    
    // Get the data.
		if (count($this->request->post)) {
			$multi_featured_data = $this->request->post;
      
		} else {
      
      if (version_compare(VERSION, '2.0.1.0', '<')) { // for OpenCart 2.0.0.0 or earlier.
        $this->load->model('setting/setting');
        $multi_featured_data = $this->model_setting_setting->getSetting($this->module_key, (int)$this->config->get('config_store_id'));

      } else {
        $this->load->model('module/multi_featured');
        $multi_featured_data = $this->model_module_multi_featured->getSetting($this->module_key, (int)$this->config->get('config_store_id'));
        
        $multi_featured_data['multi_featured_config'] = $this->config->get('multi_featured_config');
        $multi_featured_data['multi_featured_status'] = $this->config->get('multi_featured_status');        
      }      


      // For duplicated module.
      if ($this->module_key != 'multi_featured') {
        foreach($multi_featured_data as $key => $value) {
          if (strrpos($key, '_') !== false) {
            $pos = strrpos($key, '_');
            $multi_featured_data['multi_featured_' . substr($key, $pos + 1)] = $value;
            unset($multi_featured_data[$this->module_key . '_' .  substr($key, $pos + 1)]);
          }
        }
        unset($key, $value);
      }      
		}


    // Configuration
    $data['multi_featured_config'] = array(
        'cache_expire' => 3600
    );
    
    if (isset($this->request->post['multi_featured_config'])) {
      $data['multi_featured_config'] = array_merge($data['multi_featured_config'], $this->request->post['multi_featured_config']);
      
    } elseif ($this->config->get('multi_featured_config')) {
      $data['multi_featured_config'] = array_merge($data['multi_featured_config'], $this->config->get('multi_featured_config'));
    }

    if (isset($multi_featured_data['multi_featured_config'])) {
      unset($multi_featured_data['multi_featured_config']);
    }
    
    
    // Modules
    // Deprecated: BEGIN
    $data['multi_featured_modules'] = array();
    
    $modules = array();
    
    if (isset($this->request->post['multi_featured_module'])) {
      $modules = $this->request->post['multi_featured_module'];
    } elseif (isset($multi_featured_data['multi_featured_module']) && $multi_featured_data['multi_featured_module']) {
      $modules = $multi_featured_data['multi_featured_module'];
    }

		foreach ($modules as $key => $module) {
			$data['multi_featured_modules'][] = array(
				'key' => $key,
				'featured_id' => $module['featured_id'],
				'limit' => $module['limit'],
				'width' => $module['width'],
				'height' => $module['height'],
				'status' => $module['status']
			);
		}
    
    unset($multi_featured_data['multi_featured_module']);
    
    // Deprecated: END
    
    
    // Multiple Featured Module settings
    $data['multi_featured_settings'] = array();

    // Products
    $this->load->model('catalog/product');
    
    
    if (! $this->isOC2031orEarlier()) { // for OpenCart 2.1.0.0 or later.
      // Convert an object to an array
      $multi_featured_data = json_decode(json_encode($multi_featured_data), true);
    }  
    
		foreach ($multi_featured_data as $key => $value) {
      
      if (strpos($key, 'multi_featured_') === 0 && is_array($value)) {
        // Initialize "module_id" variable for OpenCart 2.0.0.0. 
        if (!isset($value['module_id'])) {
          $value['module_id'] = null;
        }

        $featured_id = null;

        if (strrpos($key, '_') !== false) {
          $pos = strrpos($key, '_');
          $featured_id = substr($key, $pos + 1);
        }

        if (!$featured_id) {
          continue;
        }        

        $data['multi_featured_settings'][$featured_id] = $value;

        $products = array();

        if ($value['product']) {
          $product_ids = explode(',', $value['product']);

          foreach ($product_ids as $product_id) {
            $product_info = $this->model_catalog_product->getProduct($product_id);

            if ($product_info) {
              $products[] = array(
                'product_id' => $product_info['product_id'],
                'name' => $product_info['name']
              );
            }
          }        
        }

        $data['multi_featured_settings'][$featured_id]['products'] = $products; 
      }        
		}
    
    $data['multi_featured_count'] = count($data['multi_featured_settings']);
    
      
    ksort($data['multi_featured_settings']);
    
    
    // Languages
    $this->load->model('localisation/language');
    
    $languages = $this->model_localisation_language->getLanguages();

    $data['languages'] = $languages;
    
    $data['primary_language'] = reset($languages);
    
    
    // Stores
		$this->load->model('setting/store');
		
		$data['stores'] = array();
		$data['stores'][] = array(
			'store_id' => 0,
			'name' => $this->config->get('config_name')
		);
		
		$stores = array_merge($data['stores'], $this->model_setting_store->getStores());    
		$data['stores'] = $stores;   
    

    // Customer groups
    if ($this->isOC2031orEarlier()) { // for OpenCart 2.0.3.1 or earlier.
      $this->load->model('sale/customer_group');
      $customer_groups = $this->model_sale_customer_group->getCustomerGroups();
    } else { // for OpenCart 2.1.0.0 or later.
      $this->load->model('customer/customer_group');
      $customer_groups = $this->model_customer_customer_group->getCustomerGroups();
    }

    foreach ($customer_groups as $key => $customer_group) {
      if ($customer_group['customer_group_id'] == $this->config->get('config_customer_group_id')) {
        $customer_groups[$key]['name'] = $customer_group['name'] . ' ' . $this->language->get('text_default');
        $customer_groups[$key]['customer_group_default'] = 1;
      } else {
        $customer_groups[$key]['customer_group_default'] = 0;
      }
    }

    $formatted_customer_groups = array_merge(array(array(
      'customer_group_id' => 0,
      'name' => $this->language->get('text_guest_users'),
      'customer_group_default' => 0
      )), $customer_groups
    );
    
    $data['customer_groups'] = $formatted_customer_groups;
    
    // Max input variables
    $data['max_input_vars'] = null;

    if (function_exists('ini_get')) {
      $data['max_input_vars'] = ini_get('max_input_vars');
    }     
    
    // Template
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/multi_featured.tpl', $data));    
  }

/**
 * validate method
 *
 * @param void
 * @return boolean True or false
 */  
  protected function validate() {
    if (!$this->user->hasPermission('modify', 'module/multi_featured')) {
      $this->error['warning'] = $this->language->get('error_permission');
    }

    $featuredCount = (int)$this->request->post['multi_featured_count'];
    
    if ($featuredCount > 0) {
      
      for ($i = 1; $i <= $featuredCount; $i++) {
        if ($this->request->post["multi_featured_{$i}"]['name']) {
          $tabName = $this->request->post["multi_featured_{$i}"]['name'];
        } else {
          $tabName = $this->language->get('text_featured_content') . ' ' . $i;
        }          
        
        // Module name
        if ((utf8_strlen($this->request->post["multi_featured_{$i}"]['name']) < 3) || (utf8_strlen($this->request->post["multi_featured_{$i}"]['name']) > 64)) {
          $this->error['warning_multiple'][$i] = sprintf($this->language->get('error_warning_multiple'), $this->language->get('tab_featured_product_lists'), $tabName);
          $this->error['name'][$i] = $this->language->get('error_name');          
        }

        // Width
        if (!$this->request->post["multi_featured_{$i}"]['width']) {
          $this->error['warning_multiple'][$i] = sprintf($this->language->get('error_warning_multiple'), $this->language->get('tab_featured_product_lists'), $tabName);
          $this->error['width'][$i] = $this->language->get('error_width');      
        }
        
        // Height
        if (!$this->request->post["multi_featured_{$i}"]['height']) {
          $this->error['warning_multiple'][$i] = sprintf($this->language->get('error_warning_multiple'), $this->language->get('tab_featured_product_lists'), $tabName);
          $this->error['height'][$i] = $this->language->get('error_height');      
        }
        
        // Template
        if (!$this->request->post["multi_featured_{$i}"]['use_default_template']) {
          $template = 'multi_featured_' . $this->request->post["multi_featured_{$i}"]['template'] . '.tpl';

          if (
            is_file(DIR_CATALOG . 'view/theme/' . $this->config->get('config_template') . '/template/module/' . $template) ||
            is_file(DIR_CATALOG . 'view/theme/' . 'default/template/module/' . $template)
          ) {
            continue;
          } else {
            $this->error['warning_multiple'][$i] = sprintf($this->language->get('error_warning_multiple'), $this->language->get('tab_featured_product_lists'), $tabName);
            $this->error['template'][$i] = $this->language->get('error_template');
          }
        }
        
      }
    }

    if (isset($this->request->post['multi_featured_module'])) {
      
      foreach ($this->request->post['multi_featured_module'] as $key => $value) {
        
        // Image width and height
        if (!$value['width'] || !$value['height']) {
          $this->error['image'][$key] = $this->language->get('error_image');
          $this->error['warning'] = $this->language->get('error_warning_modules');
        }
        
        if (!$value['featured_id']) {
          $this->error['featured_id'][$key] = $this->language->get('error_featured_id');
          $this->error['warning'] = $this->language->get('error_warning_modules');
        }
        
      }
    }

    if (!$this->error) {
      return true;
    } else {
      return false;
    }
  }

/**
 * autocomplete method
 *
 * @param void
 * @return void
 */  
  public function autocomplete() {
    $json = array();

    if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_category_id'])) {
      $this->load->model('catalog/product');
      $this->load->model('catalog/option');

      if (isset($this->request->get['filter_name'])) {
        $filter_name = $this->request->get['filter_name'];
      } else {
        $filter_name = '';
      }

      if (isset($this->request->get['filter_model'])) {
        $filter_model = $this->request->get['filter_model'];
      } else {
        $filter_model = '';
      }

      if (isset($this->request->get['limit'])) {
        $limit = $this->request->get['limit'];
      } else {
        $limit = 20;
      }

      $data = array(
        'filter_name' => $filter_name,
        'filter_model' => $filter_model,
        'start' => 0,
        'limit' => $limit,
        'filter_status' => 1
      );

      if (isset($this->request->get['incl_dab_prods']) && $this->request->get['incl_dab_prods']) {
        unset($data['filter_status']);
      }

      $results = $this->model_catalog_product->getProducts($data);
      
      $this->load->model('module/multi_featured');
      
      foreach ($results as $result) {
        $option_data = array();

        $product_options = $this->model_catalog_product->getProductOptions($result['product_id']);

        foreach ($product_options as $product_option) {
          $option_info = $this->model_catalog_option->getOption($product_option['option_id']);

          if ($option_info) {
            if ($option_info['type'] == 'select' || $option_info['type'] == 'radio' || $option_info['type'] == 'checkbox' || $option_info['type'] == 'image') {
              $option_value_data = array();

              foreach ($product_option['product_option_value'] as $product_option_value) {
                $option_value_info = $this->model_module_multi_featured->getOptionValue($product_option_value['option_value_id']);

                if ($option_value_info) {
                  $option_value_data[] = array(
                      'product_option_value_id' => $product_option_value['product_option_value_id'],
                      'option_value_id' => $product_option_value['option_value_id'],
                      'name' => $option_value_info['name'],
                      'price' => (float) $product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
                      'price_prefix' => $product_option_value['price_prefix']
                  );
                }
              }

              $option_data[] = array(
                  'product_option_id' => $product_option['product_option_id'],
                  'option_id' => $product_option['option_id'],
                  'name' => $option_info['name'],
                  'type' => $option_info['type'],
                  'option_value' => $option_value_data,
                  'required' => $product_option['required']
              );
            } else {
              $option_data[] = array(
                  'product_option_id' => $product_option['product_option_id'],
                  'option_id' => $product_option['option_id'],
                  'name' => $option_info['name'],
                  'type' => $option_info['type'],
                  'option_value' => isset($product_option['option_value']) ? $product_option['option_value'] : null,
                  'required' => $product_option['required']
              );
            }
          }
        }

        $json[] = array(
            'product_id' => $result['product_id'],
            'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
            'model' => $result['model'],
            'option' => $option_data,
            'price' => $result['price'],
            'status' => $result['status']
        );
      }
    }

    $this->response->setOutput(json_encode($json));
  }
  
/**
 * Checks if OpenCart 2.0.3.1 or earlier
 *
 * @param void
 * @return bool True or false
 */
  public function isOC2031orEarlier() {
    return version_compare(str_replace('_rc1', '.RC.1', VERSION), '2.1.0.0.RC.1', '<');
  }

/**
 * install method
 *
 * @param void
 * @return void
 */
  public function install() {
  }

/**
 * uninstall method
 *
 * @param void
 * @return void
 */
  public function uninstall() {
  }  

/**
 * upgrade method
 *
 * @param void
 * @return void
 */
  public function upgrade() {
  }

}
