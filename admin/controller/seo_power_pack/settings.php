<?php
ini_set('memory_limit', '124M');
set_time_limit(0);
class ControllerSeoPowerPackSettings extends Controller {
	private $error = array();

	private function __databaseFix() {
		$query = $this->db->query("DESC " . DB_PREFIX . "url_alias language_id");
		if (!$query->num_rows) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "url_alias` ADD `language_id` int(11) NOT NULL DEFAULT '0'");
		}

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query='account/login' LIMIT 1");

		if (!$query->num_rows) {
			$this->load->model('seo_power_pack/seo_urls');

			$urls = array(
				'1' => array( /* english = 1 (language_id) */
					'account/login'        => 'login',
					'account/register'     => 'register',
					'account/account'      => 'my-account',
					'account/edit'         => 'account-information',
					'account/password'     => 'password',
					'account/forgotten'    => 'forgot-password',
					'account/address'      => 'address-book',
					'account/order'        => 'order-history',
					'account/wishlist'     => 'wish-list',
					'account/download'     => 'downloads',
					'account/return'       => 'returns',
					'account/return/add'   => 'product-returns',
					'account/voucher'      => 'gift-vouchers',
					'account/newsletter'   => 'newsletter',
					'account/reward'       => 'reward-points',
					'account/transaction'  => 'transactions',
					'account/recurring'    => 'recurring-payments',
					'affiliate/account'    => 'affiliates',
					'checkout/cart'        => 'cart',
					'checkout/checkout'    => 'checkout',
					'product/special'      => 'special-offers',
					'product/search'       => 'search',
					'product/manufacturer' => 'brands',
					'information/contact'  => 'contact-us',
					'information/sitemap'  => 'sitemap',
				),
				'2' => array( /* swedish = 2 (language_id) */
					'account/login'        => 'login',
					'account/register'     => 'register',
					'account/account'      => 'my-account',
					'account/edit'         => 'account-information',
					'account/password'     => 'password',
					'account/forgotten'    => 'forgot-password',
					'account/address'      => 'address-book',
					'account/order'        => 'order-history',
					'account/wishlist'     => 'wish-list',
					'account/download'     => 'downloads',
					'account/return'       => 'returns',
					'account/return/add'   => 'product-returns',
					'account/voucher'      => 'gift-vouchers',
					'account/newsletter'   => 'newsletter',
					'account/reward'       => 'reward-points',
					'account/transaction'  => 'transactions',
					'account/recurring'    => 'recurring-payments',
					'affiliate/account'    => 'affiliates',
					'checkout/cart'        => 'cart',
					'checkout/checkout'    => 'checkout',
					'product/special'      => 'special-offers',
					'product/search'       => 'search',
					'product/manufacturer' => 'brands',
					'information/contact'  => 'contact-us',
					'information/sitemap'  => 'sitemap',
				),
			);

			foreach ($urls as $language_id => $lang_urls) {
				foreach ($lang_urls as $route => $keyword) {
					$this->model_seo_power_pack_seo_urls->addNewUrlAlias(
						$route,
						$this->url_slug($keyword),
						$language_id
					);
				}
			}

		}
	}

	public function index() {
		$this->load->language('seo_power_pack/settings');
		$this->load->model('setting/setting');
		$this->load->model('seo_power_pack/settings');

		$this->__databaseFix();

		$this->document->addScript('view/javascript/seo_power_pack/notify.min.js');

		/* Load Language Vars */

		$language_keys = array(
			'tab_text_main',
			'tab_text_products',
			'tab_text_categories',
			'tab_text_manufacturer',
			'tab_text_information_pages',
			'tab_text_duplicate_url',
			'tab_text_custom_urls',
			'tab_text_help',
			'tab_text_news_and_updates',
			'txt_auto_translate_seo_url_on',
			'txt_auto_translate_seo_url_on_tip',
			'txt_auto_translate_seo_url_off',
			'txt_auto_translate_seo_url_off_tip',
			'txt_product_seo_settings',
			'txt_category_seo_settings',
			'txt_manufacturers_seo_settings',
			'txt_information_seo_settings',
			'txt_generate',
			'txt_clear',
			'txt_example',
			'txt_auto_on',
			'txt_auto_off',
			'txt_meta_title',
			'txt_meta_keyword',
			'txt_meta_description',
			'txt_product_image_name_seo_optimiser',
			'txt_product_tags',
			'txt_seo_keyword',
			'txt_related_products_auto_generate',
			'txt_no_language',
			'txt_edit_custom_url',
			'txt_add_new_seo_url',
			'txt_route',
			'txt_seo_keyword_need_2b_unique',
			'txt_list',
			'txt_save',
			'txt_cancel',
			'txt_save_changes',
			'txt_close',
			'txt_loading',
			'txt_store',
			'txt_social',
			'txt_advanced',
			'txt_webmaster_tool',
			'txt_google_analytics',
			'txt_store_note',
			'txt_processing',
			'txt_social_settings',
			'txt_enable_facebook_open_graph',
			'txt_enable_twitter_card',
			'txt_twitter_content_creator',
			'txt_twitter_card_footer',
			'txt_enable_google_plus_meta_data',
			'txt_twitter_content_creator_ph',
			'txt_twitter_card_footer_ph',
			'txt_facebook',
			'txt_twitter',
			'txt_gplus',
			'txt_store_seo_settings',
			'txt_sitemaps',
			'txt_webmaster_tool_settings',
			'txt_google_site_verification_code',
			'txt_google_analytics_code',
			'txt_enable_google_analytics',
			'txt_sitemaps_note',
			'txt_generate_sitemaps',
			'ptxt_id',
			'ptxt_name',
			'ptxt_title',
			'ptxt_model',
			'ptxt_price',
			'ptxt_sku',
			'ptxt_upc',
			'ptxt_ean',
			'ptxt_jan',
			'ptxt_isbn',
			'ptxt_mpn',
			'ptxt_location',
			'ptxt_manufacturer',
			'ptxt_category',
			'btn_rename',
			'ptxt_desc',
			'ptxt_subcats',
			'note_product_meta_title',
			'note_product_meta_keyword',
			'note_product_meta_description',
			'note_product_image_name_seofrdly',
			'note_product_tag',
			'note_product_seo_keyword',
			'note_product_related_products',
			'note_category_seo_keyword',
			'note_category_meta_tag_title',
			'note_category_meta_tag_description',
			'note_category_meta_tag_keyword',
			'note_manufacturer_seo_keyword',
			'note_information_seo_keyword',
			'note_information_meta_title',
			'note_information_meta_tag_description',
			'tip_auto_on',
			'tip_auto_off',
			'tip_product_meta_title_generate',
			'tip_product_meta_title_clear',
			'tip_product_meta_keyword_generate',
			'tip_product_meta_keyword_clear',
			'tip_product_meta_desc_generate',
			'tip_product_meta_desc_clear',
			'tip_product_img_name_generate',
			'tip_product_img_name_clear',
			'tip_product_tag_generate',
			'tip_product_tag_clear',
			'tip_product_seo_keyword_generate',
			'tip_product_seo_keyword_clear',
			'tip_product_related_products_generate',
			'tip_product_related_products_clear',
			'tip_category_seo_keyword_generate',
			'tip_category_seo_keyword_clear',
			'tip_category_meta_title_generate',
			'tip_category_meta_title_clear',
			'tip_category_meta_desc_generate',
			'tip_category_meta_desc_clear',
			'tip_category_meta_keyword_generate',
			'tip_category_meta_keyword_clear',
			'tip_manufacturers_seo_keyword_generate',
			'tip_manufacturers_seo_keyword_clear',
			'tip_information_seo_keyword_generate',
			'tip_information_seo_keyword_clear',
			'tip_information_meta_title_generate',
			'tip_information_meta_title_clear',
			'tip_information_meta_desc_generate',
			'tip_information_meta_desc_clear',
			'tip_tag_meta_desc',
			'help_sort_order',
			'js_warning_tag_already_added',
			'js_warning_please_enter_pattern',
			'js_route_cannot_be_empty',
			'js_seo_keyword_cannot_be_empty',
			'js_successfully_added',
			'js_successfully_updated',
			'js_deleted_successfully',
			'js_enter_keyword_in',
			'js_seo_keyword',
			'js_url_params',
			'js_keyword_or_seo_keyword',
			'js_filter',
			'js_clear_or_refresh',
			'js_edit',
			'js_delete',
			'js_are_you_sure_you_want_to_delete',
			'js_name',
			'js_title',
			'js_meta_title',
			'js_meta_keyword',
			'js_meta_desc',
			'js_seo_keyword',
			'js_tags',
			'js_image_name',
			'js_no_products',
			'js_no_categories',
			'js_no_manufacturers',
			'js_no_informations',
			'js_no_duplicate_urls',
			'js_no_custom_urls',
			'js_warning_please_enter_a_page_number',
			'js_saved_successfully',
			'js_save_failed',
			'phr_product_meta_title',
			'phr_product_meta_keyword',
			'phr_product_meta_description',
			'phr_product_image_name_seofrdly',
			'phr_product_tag',
			'phr_product_seo_keyword',
			'phr_product_related_products',
			'phr_category_seo_keyword',
			'phr_category_meta_tag_title',
			'phr_category_meta_tag_description',
			'phr_category_meta_tag_keyword',
			'phr_manufacturer_seo_keyword',
			'phr_information_seo_keyword',
			'phr_information_meta_title',
			'phr_information_meta_tag_description',
		);

		foreach ($language_keys as $lf_key) {
			$data[$lf_key] = $this->language->get($lf_key);
		}

		/* Load Language Vars */

		$data['heading_title'] = $this->language->get('heading_title');

		$this->document->setTitle($data['heading_title']);

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('seo_power_pack/settings', 'token=' . $this->session->data['token'], 'SSL'),
		);

		$data['action']        = '#';
		$data['do_action_url'] = $this->url->link('seo_power_pack/settings/do_action', 'token=' . $this->session->data['token'], 'SSL');

		$data['token']                                = $this->session->data['token'];
		$data['seo_pp_product_meta_title']            = $this->config->get('seo_pp_product_meta_title');
		$data['seo_pp_product_meta_keyword']          = $this->config->get('seo_pp_product_meta_keyword');
		$data['seo_pp_product_meta_description']      = $this->config->get('seo_pp_product_meta_description');
		$data['seo_pp_product_tags']                  = $this->config->get('seo_pp_product_tags');
		$data['seo_pp_product_image_name_pattern']    = $this->config->get('seo_pp_product_image_name_pattern');
		$data['seo_pp_product_seo_url']               = $this->config->get('seo_pp_product_seo_url');
		$data['seo_pp_category_seo_url']              = $this->config->get('seo_pp_category_seo_url');
		$data['seo_pp_category_meta_tag_title']       = $this->config->get('seo_pp_category_meta_tag_title');
		$data['seo_pp_category_meta_tag_description'] = $this->config->get('seo_pp_category_meta_tag_description');
		$data['seo_pp_category_meta_tag_keywords']    = $this->config->get('seo_pp_category_meta_tag_keywords');
		$data['seo_pp_manufacturers_seo_url']         = $this->config->get('seo_pp_manufacturers_seo_url');
		$data['seo_pp_information_seo_url']           = $this->config->get('seo_pp_information_seo_url');
		$data['seo_pp_information_meta_title']        = $this->config->get('seo_pp_information_meta_title');
		$data['seo_pp_information_meta_desc']         = $this->config->get('seo_pp_information_meta_desc');
		$data['seo_pp_product_relpro']                = $this->config->get('seo_pp_product_relpro');

		$data['seo_pp_auto_information_meta_title']        = $this->config->get('seo_pp_auto_information_meta_title');
		$data['seo_pp_auto_information_meta_desc']         = $this->config->get('seo_pp_auto_information_meta_desc');
		$data['seo_pp_auto_information_seo_url']           = $this->config->get('seo_pp_auto_information_seo_url');
		$data['seo_pp_auto_manufacturers_seo_url']         = $this->config->get('seo_pp_auto_manufacturers_seo_url');
		$data['seo_pp_auto_category_meta_tag_keywords']    = $this->config->get('seo_pp_auto_category_meta_tag_keywords');
		$data['seo_pp_auto_category_meta_tag_description'] = $this->config->get('seo_pp_auto_category_meta_tag_description');
		$data['seo_pp_auto_category_meta_tag_title']       = $this->config->get('seo_pp_auto_category_meta_tag_title');
		$data['seo_pp_auto_category_seo_url']              = $this->config->get('seo_pp_auto_category_seo_url');
		$data['seo_pp_auto_product_relpro']                = $this->config->get('seo_pp_auto_product_relpro');
		$data['seo_pp_auto_product_seo_url']               = $this->config->get('seo_pp_auto_product_seo_url');
		$data['seo_pp_auto_product_tags']                  = $this->config->get('seo_pp_auto_product_tags');
		$data['seo_pp_auto_product_image_name_pattern']    = $this->config->get('seo_pp_auto_product_image_name_pattern');
		$data['seo_pp_auto_product_meta_description']      = $this->config->get('seo_pp_auto_product_meta_description');
		$data['seo_pp_auto_product_meta_keyword']          = $this->config->get('seo_pp_auto_product_meta_keyword');
		$data['seo_pp_auto_product_meta_title']            = $this->config->get('seo_pp_auto_product_meta_title');
		$data['seo_pp_auto_translate_seo_url']             = $this->config->get('seo_pp_auto_translate_seo_url');
		$data['seo_pp_store_settings']                     = $this->config->get('seo_pp_store_settings');
		$data['seo_pp_social_settings']                    = $this->config->get('seo_pp_social_settings');
		$data['seo_pp_google_analytics']                   = $this->config->get('seo_pp_google_analytics');
		$data['seo_pp_webmaster_tools']                    = $this->config->get('seo_pp_webmaster_tools');

		$data['languages'] = $this->model_seo_power_pack_settings->getActiveLanguages();

		$data['header']      = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer']      = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('seo_power_pack/settings.tpl', $data));
	}

	public function do_action() {

		if (!$this->__hasPermission()) {
			exit;
		}

		$this->load->model('seo_power_pack/settings');
		$this->load->model('setting/setting');

		if (isset($this->request->post['action']) && isset($this->request->post['pattern']) && strlen(trim($this->request->post['pattern'])) > 0) {

			$pattern = trim($this->request->post['pattern']);
			$this->model_setting_setting->editSetting('seo_pp_' . $this->request->post['data'], array('seo_pp_' . $this->request->post['data'] => $pattern));

			if ($this->request->post['action'] == 'generate') {
				switch ($this->request->post['data']) {
					case 'product_meta_title':$this->__process_product_meta_title($pattern);
						break;
					case 'product_meta_keyword':$this->__process_product_meta_keyword($pattern);
						break;
					case 'product_meta_description':$this->__process_product_meta_description($pattern);
						break;
					case 'product_tags':$this->__process_product_tags($pattern);
						break;
					case 'product_image_name_pattern':$this->__process_product_image_name($pattern);
						break;
					case 'product_seo_url':$this->__process_product_seo_url($pattern);
						break;
					case 'category_seo_url':$this->__process_category_seo_url($pattern);
						break;
					case 'category_meta_tag_title':$this->__process_category_meta_title($pattern);
						break;
					case 'category_meta_tag_description':$this->__process_category_meta_description($pattern);
						break;
					case 'category_meta_tag_keywords':$this->__process_category_meta_keyword($pattern);
						break;
					case 'manufacturers_seo_url':$this->__process_manufacturer_seo_url($pattern);
						break;
					case 'information_seo_url':$this->__process_information_seo_url($pattern);
						break;
					case 'information_meta_title':$this->__process_information_meta_title($pattern);
						break;
					case 'information_meta_desc':$this->__process_information_meta_desc($pattern);
						break;

					case 'product_relpro':$this->__process_product_related_products($pattern);
						break;

				}
			} else if ($this->request->post['action'] == 'clear') {
				switch ($this->request->post['data']) {
					case 'product_meta_title':$this->__process_product_meta_title($pattern, true);
						break;
					case 'product_meta_keyword':$this->__process_product_meta_keyword($pattern, true);
						break;
					case 'product_meta_description':$this->__process_product_meta_description($pattern, true);
						break;
					case 'product_tags':$this->__process_product_tags($pattern, true);
						break;
					case 'product_image_name_pattern':$this->__process_product_image_name($pattern, true);
						break;
					case 'product_seo_url':$this->__process_product_seo_url($pattern, true);
						break;
					case 'category_seo_url':$this->__process_category_seo_url($pattern, true);
						break;
					case 'category_meta_tag_title':$this->__process_category_meta_title($pattern, true);
						break;
					case 'category_meta_tag_description':$this->__process_category_meta_description($pattern, true);
						break;
					case 'category_meta_tag_keywords':$this->__process_category_meta_keyword($pattern, true);
						break;
					case 'manufacturers_seo_url':$this->__process_manufacturer_seo_url($pattern, true);
						break;
					case 'information_seo_url':$this->__process_information_seo_url($pattern, true);
						break;
					case 'information_meta_title':$this->__process_information_meta_title($pattern, true);
						break;
					case 'information_meta_desc':$this->__process_information_meta_desc($pattern, true);
						break;

					case 'product_relpro':$this->__process_product_related_products($pattern, true);
						break;
				}
			}

			$data['completed'] = 1;
		} else {
			$data['completed'] = 0;
		}
		$data['data']   = $this->request->post['data'];
		$data['action'] = $this->request->post['action'];

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}

	private function __process_product_related_products($count, $delete = false) {

		if ($delete) {
			$this->model_seo_power_pack_settings->removeProductRelatedProducts();
		} else {
			$this->model_seo_power_pack_settings->createProductRelatedProducts($count);
		}
	}

	private function __process_information_meta_title($pattern = null, $delete = false) {
		if ($delete) {
			$this->model_seo_power_pack_settings->removeInformationMetaTitle();
		} else {
			$informations = $this->model_seo_power_pack_settings->getAllInformation();

			foreach ($informations as $key => $page) {
				$page_meta_title = str_replace(array(
					'[ title ]',
				), array(
					strlen(trim($page['title'])) == 0 ? '' : trim($page['title']),
				),
					$pattern);

				$this->model_seo_power_pack_settings->updateInformationMetaTitle($page['information_id'], $page_meta_title, $page['language_id']);
			}
		}
	}

	private function __process_information_meta_desc($pattern = null, $delete = false) {
		if ($delete) {
			$this->model_seo_power_pack_settings->removeInformationMetaDescription();
		} else {
			$informations = $this->model_seo_power_pack_settings->getAllInformation();

			foreach ($informations as $key => $page) {

				$description     = $this->model_seo_power_pack_settings->clean_string($page['description']);
				$page_meta_title = str_replace(array(
					'[ title ]',
					'[ description ]',
				), array(
					strlen(trim($page['title'])) == 0 ? '' : trim($page['title']) . ' ',
					strlen($description) == 0 ? '' : ((strlen($description) > 150) ? substr($description, 0, 150) . '...' : $description),
				),
					$pattern);

				$this->model_seo_power_pack_settings->updateInformationMetaDescription($page['information_id'], $page_meta_title, $page['language_id']);
			}
		}
	}

	private function __process_information_seo_url($pattern = null, $delete = false) {
		if ($delete) {
			$this->model_seo_power_pack_settings->removeInformationSEOUrl();
		} else {
			$informations = $this->model_seo_power_pack_settings->getAllInformation();

			foreach ($informations as $key => $page) {
				$page_seo_keyword = str_replace(array(
					'[ id ]',
					'[ title ]',
				), array(
					$page['information_id'],
					strlen(trim($page['title'])) == 0 ? '' : trim($page['title']),
				),
					$pattern);

				$this->model_seo_power_pack_settings->addInformationSEOUrl($page['information_id'], $this->url_slug($page_seo_keyword), $page['language_id']);
			}
		}
	}

	private function __process_manufacturer_seo_url($pattern = null, $delete = false) {
		if ($delete) {
			$this->model_seo_power_pack_settings->removeManufacturerSEOUrl();
		} else {
			$manufacturers = $this->model_seo_power_pack_settings->getAllManufacturers();

			foreach ($manufacturers as $key => $manufacturer) {
				$manufacturer_seo_keyword = str_replace(array(
					'[ id ]',
					'[ name ]',
				), array(
					$manufacturer['manufacturer_id'],
					strlen(trim($manufacturer['name'])) == 0 ? '' : trim($manufacturer['name']),
				),
					$pattern);

				$this->model_seo_power_pack_settings->addManufacturerSEOUrl($manufacturer['manufacturer_id'], $this->url_slug($manufacturer_seo_keyword));
			}
		}
	}

	private function __process_category_meta_description($pattern = null, $delete = false) {
		if ($delete) {
			$this->model_seo_power_pack_settings->removeCategoryMetaDescription();
		} else {
			$categories = $this->model_seo_power_pack_settings->getAllCategoryIds();

			foreach ($categories as $key => $value) {
				$category = $this->model_seo_power_pack_settings->getCategoryDescriptions($value['category_id'], true);

				$category_meta_descs = array();
				foreach ($category as $language_id => $details) {

					$description = $this->model_seo_power_pack_settings->clean_string($details['description']);

					$cat_metadesc = str_replace(array(
						'[ name ]',
						'[ description ]',
						'[ sub_categories ]',
					), array(
						strlen($details['name']) == 0 ? '' : $details['name'] . ' ',
						strlen($description) == 0 ? '' : ((strlen($description) > 150) ? substr($description, 0, 150) . '...' : $description) . ' ',
						strlen($details['sub_cats']) == 0 ? '' : $details['sub_cats'] . ' ',
					),
						$pattern);

					$category_meta_descs[$language_id] = trim($cat_metadesc);
				}

				$this->model_seo_power_pack_settings->updateCategoryMetaDescription($value['category_id'], $category_meta_descs);
			}
		}
	}

	private function __process_category_meta_keyword($pattern = null, $delete = false) {
		if ($delete) {
			$this->model_seo_power_pack_settings->removeCategoryMetaKeyword();
		} else {
			$categories = $this->model_seo_power_pack_settings->getAllCategoryIds();

			foreach ($categories as $key => $value) {
				$category = $this->model_seo_power_pack_settings->getCategoryDescriptions($value['category_id'], true);

				$category_meta_keywords = array();
				foreach ($category as $language_id => $details) {
					$cat_meta_kw = str_replace(array(
						'[ name ]',
						'[ sub_categories ]',
					), array(
						strlen($details['name']) == 0 ? '' : $details['name'] . ',',
						strlen($details['sub_cats']) == 0 ? '' : $details['sub_cats'] . ',',
					),
						$pattern);

					$category_meta_keywords[$language_id] = rtrim($cat_meta_kw, ',');
				}

				$this->model_seo_power_pack_settings->updateCategoryMetaKeyword($value['category_id'], $category_meta_keywords);
			}
		}
	}

	private function __process_category_meta_title($pattern = null, $delete = false) {
		if ($delete) {
			$this->model_seo_power_pack_settings->removeCategoryMetaTitle();
		} else {
			$categories = $this->model_seo_power_pack_settings->getAllCategoryIds();

			foreach ($categories as $key => $value) {
				$category = $this->model_seo_power_pack_settings->getCategoryDescriptions($value['category_id']);

				$category_meta_titles = array();
				foreach ($category as $language_id => $details) {
					$cat_meta_title = str_replace(array(
						'[ name ]',
					), array(
						strlen($details['name']) == 0 ? '' : $details['name'],
					),
						$pattern);

					$category_meta_titles[$language_id] = $cat_meta_title;
				}

				$this->model_seo_power_pack_settings->updateCategoryMetaTitle($value['category_id'], $category_meta_titles);
			}
		}
	}

	private function __process_category_seo_url($pattern = null, $delete = false) {

		if ($delete) {
			$this->model_seo_power_pack_settings->removeCategorySEOUrl();
		} else {
			$categories = $this->model_seo_power_pack_settings->getAllCategoryIds();

			foreach ($categories as $key => $value) {
				$category = $this->model_seo_power_pack_settings->getCategoryDescriptions($value['category_id']);

				$category_seo_keywords = array();
				foreach ($category as $language_id => $details) {
					$cat_seo_keyword = str_replace(array(
						'[ id ]',
						'[ name ]',
					), array(
						$value['category_id'],
						strlen($details['name']) == 0 ? '' : $details['name'],
					),
						$pattern);

					$category_seo_keywords[$language_id] = $this->url_slug($cat_seo_keyword);
				}

				$this->model_seo_power_pack_settings->addCategorySEOUrl($value['category_id'], $category_seo_keywords);
			}
		}
	}

	private function __process_product_image_name($pattern = null, $delete = false) {
		$language_id = $this->model_seo_power_pack_settings->getLanguageIdByCode($this->config->get('config_language'));
		if ($delete) {
			$this->model_seo_power_pack_settings->removeProductImagePattern();
		} else {
			$products = $this->model_seo_power_pack_settings->getAllProductIds();

			foreach ($products as $key => $value) {
				$product = $this->__getProductDetails($value['product_id'], $language_id);

				$product_image_new_name = '';

				foreach ($product['desc'] as $language_id => $details) {
					$cat_names = '';
					if (isset($product['product_categories'][$language_id]) && is_array($product['product_categories'][$language_id])) {
						$cat_names = implode('-', $product['product_categories'][$language_id]);
					}

					$new_image_name = str_replace(array(
						'[ name ]',
						'[ model ]',
						'[ price ]',
						'[ sku ]',
						'[ upc ]',
						'[ ean ]',
						'[ jan ]',
						'[ isbn ]',
						'[ mpn ]',
						'[ location ]',
						'[ manufacturer ]',
						'[ category ]',
					), array(
						strlen($details['name']) == 0 ? '' : $details['name'] . '-',
						strlen($product['model']) == 0 ? '' : $product['model'] . '-',
						strlen($product['price']) == 0 ? '' : $product['price'] . '-',
						strlen($product['sku']) == 0 ? '' : $product['sku'] . '-',
						strlen($product['upc']) == 0 ? '' : $product['upc'] . '-',
						strlen($product['ean']) == 0 ? '' : $product['ean'] . '-',
						strlen($product['jan']) == 0 ? '' : $product['jan'] . '-',
						strlen($product['isbn']) == 0 ? '' : $product['isbn'] . '-',
						strlen($product['mpn']) == 0 ? '' : $product['mpn'] . '-',
						strlen($product['location']) == 0 ? '' : $product['location'] . '-',
						strlen($product['manufacturer']) == 0 ? '' : $product['manufacturer'] . '-',
						strlen($cat_names) == 0 ? '' : $cat_names . '-',
					),
						$pattern);

					$product_image_new_name = $this->url_slug(rtrim($new_image_name, '-'));
				}

				$this->model_seo_power_pack_settings->renameProductImageName($product['product_id'], $product['image'], $product_image_new_name);
			}
		}
	}

	private function __process_product_seo_url($pattern = null, $delete = false) {

		if ($delete) {
			$this->model_seo_power_pack_settings->removeProductSEOUrl();
		} else {
			$products = $this->model_seo_power_pack_settings->getAllProductIds();

			foreach ($products as $key => $value) {
				$product = $this->__getProductDetails($value['product_id']);

				$product_seo_keywords = array();
				foreach ($product['desc'] as $language_id => $details) {
					$cat_names = '';
					if (isset($product['product_categories'][$language_id]) && is_array($product['product_categories'][$language_id])) {
						$cat_names = implode('-', $product['product_categories'][$language_id]);
					}

					$seo_keyword = str_replace(array(
						'[ id ]',
						'[ name ]',
						'[ model ]',
						'[ price ]',
						'[ sku ]',
						'[ upc ]',
						'[ ean ]',
						'[ jan ]',
						'[ isbn ]',
						'[ mpn ]',
						'[ location ]',
						'[ manufacturer ]',
						'[ category ]',
					), array(
						$value['product_id'],
						strlen($details['name']) == 0 ? '' : $details['name'] . '-',
						strlen($product['model']) == 0 ? '' : $product['model'] . '-',
						strlen($product['price']) == 0 ? '' : $product['price'] . '-',
						strlen($product['sku']) == 0 ? '' : $product['sku'] . '-',
						strlen($product['upc']) == 0 ? '' : $product['upc'] . '-',
						strlen($product['ean']) == 0 ? '' : $product['ean'] . '-',
						strlen($product['jan']) == 0 ? '' : $product['jan'] . '-',
						strlen($product['isbn']) == 0 ? '' : $product['isbn'] . '-',
						strlen($product['mpn']) == 0 ? '' : $product['mpn'] . '-',
						strlen($product['location']) == 0 ? '' : $product['location'] . '-',
						strlen($product['manufacturer']) == 0 ? '' : $product['manufacturer'] . '-',
						strlen($cat_names) == 0 ? '' : $cat_names . '-',
					),
						$pattern);

					$product_seo_keywords[$language_id] = $this->url_slug(rtrim($seo_keyword, '-'));
				}

				$this->model_seo_power_pack_settings->addProductSEOUrl($value['product_id'], $product_seo_keywords);
			}
		}
	}

	private function __process_product_tags($pattern = null, $delete = false) {

		if ($delete) {
			$this->model_seo_power_pack_settings->removeProductTags();
		} else {
			$products = $this->model_seo_power_pack_settings->getAllProductIds();

			foreach ($products as $key => $value) {
				$product = $this->__getProductDetails($value['product_id']);

				$product_tags = array();
				foreach ($product['desc'] as $language_id => $details) {
					$cat_names = '';
					if (isset($product['product_categories'][$language_id]) && is_array($product['product_categories'][$language_id])) {
						$cat_names = implode(',', $product['product_categories'][$language_id]);
					}

					$protags = str_replace(array(
						'[ name ]',
						'[ model ]',
						'[ price ]',
						'[ sku ]',
						'[ upc ]',
						'[ ean ]',
						'[ jan ]',
						'[ isbn ]',
						'[ mpn ]',
						'[ location ]',
						'[ manufacturer ]',
						'[ category ]',
					), array(
						strlen($details['name']) == 0 ? '' : $details['name'] . ',',
						strlen($product['model']) == 0 ? '' : $product['model'] . ',',
						strlen($product['price']) == 0 ? '' : $product['price'] . ',',
						strlen($product['sku']) == 0 ? '' : $product['sku'] . ',',
						strlen($product['upc']) == 0 ? '' : $product['upc'] . ',',
						strlen($product['ean']) == 0 ? '' : $product['ean'] . ',',
						strlen($product['jan']) == 0 ? '' : $product['jan'] . ',',
						strlen($product['isbn']) == 0 ? '' : $product['isbn'] . ',',
						strlen($product['mpn']) == 0 ? '' : $product['mpn'] . ',',
						strlen($product['location']) == 0 ? '' : $product['location'] . ',',
						strlen($product['manufacturer']) == 0 ? '' : $product['manufacturer'] . ',',
						strlen($cat_names) == 0 ? '' : $cat_names . ',',
					),
						$pattern);

					$product_tags[$language_id] = rtrim($protags, ',');
				}

				$this->model_seo_power_pack_settings->updateProductTags($value['product_id'], $product_tags);
			}
		}
	}

	private function __process_product_meta_description($pattern = null, $delete = false) {

		if ($delete) {
			$this->model_seo_power_pack_settings->removeProductMetaDescription();
		} else {
			$products = $this->model_seo_power_pack_settings->getAllProductIds();

			foreach ($products as $key => $value) {
				$product = $this->__getProductDetails($value['product_id']);

				$meta_descs = array();
				foreach ($product['desc'] as $language_id => $details) {
					$cat_names = '';
					if (isset($product['product_categories'][$language_id]) && is_array($product['product_categories'][$language_id])) {
						$cat_names = implode(',', $product['product_categories'][$language_id]);
					}

					$metadesc = str_replace(array(
						'[ name ]',
						'[ model ]',
						'[ price ]',
						'[ sku ]',
						'[ upc ]',
						'[ ean ]',
						'[ jan ]',
						'[ isbn ]',
						'[ mpn ]',
						'[ location ]',
						'[ manufacturer ]',
						'[ category ]',
					), array(
						strlen($details['name']) == 0 ? '' : $details['name'] . ' ',
						strlen($product['model']) == 0 ? '' : $product['model'] . ' ',
						strlen($product['price']) == 0 ? '' : $product['price'] . ' ',
						strlen($product['sku']) == 0 ? '' : $product['sku'] . ' ',
						strlen($product['upc']) == 0 ? '' : $product['upc'] . ' ',
						strlen($product['ean']) == 0 ? '' : $product['ean'] . ' ',
						strlen($product['jan']) == 0 ? '' : $product['jan'] . ' ',
						strlen($product['isbn']) == 0 ? '' : $product['isbn'] . ' ',
						strlen($product['mpn']) == 0 ? '' : $product['mpn'] . ' ',
						strlen($product['location']) == 0 ? '' : $product['location'] . ' ',
						strlen($product['manufacturer']) == 0 ? '' : $product['manufacturer'] . ' ',
						strlen($cat_names) == 0 ? '' : $cat_names . ' ',
					),
						$pattern);

					$meta_descs[$language_id] = trim($metadesc);
				}

				$this->model_seo_power_pack_settings->updateProductMetaDescription($value['product_id'], $meta_descs);
			}
		}
	}

	private function __process_product_meta_keyword($pattern = null, $delete = false) {

		if ($delete) {
			$this->model_seo_power_pack_settings->removeProductMetaKeyword();
		} else {
			$products = $this->model_seo_power_pack_settings->getAllProductIds();

			foreach ($products as $key => $value) {
				$product = $this->__getProductDetails($value['product_id']);

				$meta_keywords = array();
				foreach ($product['desc'] as $language_id => $details) {
					$cat_names = '';
					if (isset($product['product_categories'][$language_id]) && is_array($product['product_categories'][$language_id])) {
						$cat_names = implode(',', $product['product_categories'][$language_id]);
					}

					$meta_key = str_replace(array(
						'[ name ]',
						'[ model ]',
						'[ price ]',
						'[ sku ]',
						'[ upc ]',
						'[ ean ]',
						'[ jan ]',
						'[ isbn ]',
						'[ mpn ]',
						'[ location ]',
						'[ manufacturer ]',
						'[ category ]',
					), array(
						strlen($details['name']) == 0 ? '' : $details['name'] . ',',
						strlen($product['model']) == 0 ? '' : $product['model'] . ',',
						strlen($product['price']) == 0 ? '' : $product['price'] . ',',
						strlen($product['sku']) == 0 ? '' : $product['sku'] . ',',
						strlen($product['upc']) == 0 ? '' : $product['upc'] . ',',
						strlen($product['ean']) == 0 ? '' : $product['ean'] . ',',
						strlen($product['jan']) == 0 ? '' : $product['jan'] . ',',
						strlen($product['isbn']) == 0 ? '' : $product['isbn'] . ',',
						strlen($product['mpn']) == 0 ? '' : $product['mpn'] . ',',
						strlen($product['location']) == 0 ? '' : $product['location'] . ',',
						strlen($product['manufacturer']) == 0 ? '' : $product['manufacturer'] . ',',
						strlen($cat_names) == 0 ? '' : $cat_names . ',',
					),
						$pattern);

					$meta_keywords[$language_id] = rtrim($meta_key, ',');
				}

				$this->model_seo_power_pack_settings->updateProductMetaKeyword($value['product_id'], $meta_keywords);
			}
		}
	}

	private function __process_product_meta_title($pattern = null, $delete = false) {

		if ($delete) {
			$this->model_seo_power_pack_settings->removeProductMetaTitle();
		} else {
			$products = $this->model_seo_power_pack_settings->getAllProductIds();

			foreach ($products as $key => $value) {
				$product = $this->__getProductDetails($value['product_id']);

				$meta_titles = array();
				foreach ($product['desc'] as $language_id => $details) {
					$cat_names = '';
					if (isset($product['product_categories'][$language_id]) && is_array($product['product_categories'][$language_id])) {
						$cat_names = implode(',', $product['product_categories'][$language_id]);
					}

					$meta_title = str_replace(array(
						'[ name ]',
						'[ model ]',
						'[ price ]',
						'[ sku ]',
						'[ upc ]',
						'[ ean ]',
						'[ jan ]',
						'[ isbn ]',
						'[ mpn ]',
						'[ location ]',
						'[ manufacturer ]',
						'[ category ]',
					), array(
						strlen($details['name']) == 0 ? '' : $details['name'] . ' ',
						strlen($product['model']) == 0 ? '' : $product['model'] . ' ',
						strlen($product['price']) == 0 ? '' : $product['price'] . ' ',
						strlen($product['sku']) == 0 ? '' : $product['sku'] . ' ',
						strlen($product['upc']) == 0 ? '' : $product['upc'] . ' ',
						strlen($product['ean']) == 0 ? '' : $product['ean'] . ' ',
						strlen($product['jan']) == 0 ? '' : $product['jan'] . ' ',
						strlen($product['isbn']) == 0 ? '' : $product['isbn'] . ' ',
						strlen($product['mpn']) == 0 ? '' : $product['mpn'] . ' ',
						strlen($product['location']) == 0 ? '' : $product['location'] . ' ',
						strlen($product['manufacturer']) == 0 ? '' : $product['manufacturer'] . ' ',
						strlen($cat_names) == 0 ? '' : $cat_names . ' ',
					),
						$pattern);

					$meta_titles[$language_id] = trim($meta_title);
				}

				$this->model_seo_power_pack_settings->updateProductMetaTitle($value['product_id'], $meta_titles);
			}
		}
	}

	/**
	 * Create a web friendly URL slug from a string.
	 *
	 * Although supported, transliteration is discouraged because
	 *     1) most web browsers support UTF-8 characters in URLs
	 *     2) transliteration causes a loss of information
	 *
	 * @author Sean Murphy <sean@iamseanmurphy.com>
	 * @copyright Copyright 2012 Sean Murphy. All rights reserved.
	 * @license http://creativecommons.org/publicdomain/zero/1.0/
	 *
	 * @param string $str
	 * @param array $options
	 * @return string
	 */
	function url_slug($str, $options = array()) {

		// Make sure string is in UTF-8 and strip invalid UTF-8 characters
		$str = mb_convert_encoding((string) $str, 'UTF-8', mb_list_encodings());

		$defaults = array(
			'delimiter'     => '-',
			'limit'         => null,
			'lowercase'     => true,
			'replacements'  => array(),
			'transliterate' => (intval($this->config->get('seo_pp_auto_translate_seo_url')) == 1 ? true : false),
		);

		// Merge options
		$options = array_merge($defaults, $options);

		$char_map = array(
			// Latin
			'À' => 'A', 'Á'  => 'A', 'Â'  => 'A', 'Ã'  => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',

			'È' => 'E', 'É'  => 'E', 'Ê'  => 'E', 'Ë'  => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï'  => 'I',

			'Ð' => 'D', 'Ñ'  => 'N', 'Ò'  => 'O', 'Ó'  => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő'  => 'O',

			'Ø' => 'O', 'Ù'  => 'U', 'Ú'  => 'U', 'Û'  => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ'  => 'TH',

			'ß' => 'ss',

			'à' => 'a', 'á'  => 'a', 'â'  => 'a', 'ã'  => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',

			'è' => 'e', 'é'  => 'e', 'ê'  => 'e', 'ë'  => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï'  => 'i',

			'ð' => 'd', 'ñ'  => 'n', 'ò'  => 'o', 'ó'  => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő'  => 'o',

			'ø' => 'o', 'ù'  => 'u', 'ú'  => 'u', 'û'  => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ'  => 'th',

			'ÿ' => 'y',

			// Latin symbols
			'©' => '(c)',

			// Greek
			'Α' => 'A', 'Β'  => 'B', 'Γ'  => 'G', 'Δ'  => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ'  => '8',
			'Ι' => 'I', 'Κ'  => 'K', 'Λ'  => 'L', 'Μ'  => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π'  => 'P',
			'Ρ' => 'R', 'Σ'  => 'S', 'Τ'  => 'T', 'Υ'  => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
			'Ά' => 'A', 'Έ'  => 'E', 'Ί'  => 'I', 'Ό'  => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ'  => 'I',
			'Ϋ' => 'Y',
			'α' => 'a', 'β'  => 'b', 'γ'  => 'g', 'δ'  => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ'  => '8',
			'ι' => 'i', 'κ'  => 'k', 'λ'  => 'l', 'μ'  => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π'  => 'p',
			'ρ' => 'r', 'σ'  => 's', 'τ'  => 't', 'υ'  => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
			'ά' => 'a', 'έ'  => 'e', 'ί'  => 'i', 'ό'  => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς'  => 's',
			'ϊ' => 'i', 'ΰ'  => 'y', 'ϋ'  => 'y', 'ΐ'  => 'i',

			// Turkish
			'Ş' => 'S', 'İ'  => 'I', 'Ç'  => 'C', 'Ü'  => 'U', 'Ö' => 'O', 'Ğ' => 'G',
			'ş' => 's', 'ı'  => 'i', 'ç'  => 'c', 'ü'  => 'u', 'ö' => 'o', 'ğ' => 'g',

			// Russian
			'А' => 'A', 'Б'  => 'B', 'В'  => 'V', 'Г'  => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
			'З' => 'Z', 'И'  => 'I', 'Й'  => 'J', 'К'  => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О'  => 'O',
			'П' => 'P', 'Р'  => 'R', 'С'  => 'S', 'Т'  => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц'  => 'C',
			'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы'  => 'Y', 'Ь' => '', 'Э'  => 'E', 'Ю'  => 'Yu',
			'Я' => 'Ya',
			'а' => 'a', 'б'  => 'b', 'в'  => 'v', 'г'  => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
			'з' => 'z', 'и'  => 'i', 'й'  => 'j', 'к'  => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о'  => 'o',
			'п' => 'p', 'р'  => 'r', 'с'  => 's', 'т'  => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц'  => 'c',
			'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы'  => 'y', 'ь' => '', 'э'  => 'e', 'ю'  => 'yu',
			'я' => 'ya',

			// Ukrainian
			'Є' => 'Ye', 'І' => 'I', 'Ї'  => 'Yi', 'Ґ' => 'G',
			'є' => 'ye', 'і' => 'i', 'ї'  => 'yi', 'ґ' => 'g',

			// Czech
			'Č' => 'C', 'Ď'  => 'D', 'Ě'  => 'E', 'Ň'  => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů'  => 'U',

			'Ž' => 'Z',

			'č' => 'c', 'ď'  => 'd', 'ě'  => 'e', 'ň'  => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů'  => 'u',
			'ž' => 'z',

			// Polish
			'Ą' => 'A', 'Ć'  => 'C', 'Ę'  => 'e', 'Ł'  => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź'  => 'Z',

			'Ż' => 'Z',

			'ą' => 'a', 'ć'  => 'c', 'ę'  => 'e', 'ł'  => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź'  => 'z',
			'ż' => 'z',

			// Latvian
			'Ā' => 'A', 'Č'  => 'C', 'Ē'  => 'E', 'Ģ'  => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ'  => 'N',

			'Š' => 'S', 'Ū'  => 'u', 'Ž'  => 'Z',
			'ā' => 'a', 'č'  => 'c', 'ē'  => 'e', 'ģ'  => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ'  => 'n',
			'š' => 's', 'ū'  => 'u', 'ž'  => 'z',
		);

		// Make custom replacements
		$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

		// Transliterate characters to ASCII
		if ($options['transliterate']) {
			$str = str_replace(array_keys($char_map), $char_map, $str);
		}

		// Replace non-alphanumeric characters with our delimiter
		$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

		// Remove duplicate delimiters
		$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

		// Truncate slug to max. characters
		$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

		// Remove delimiter from ends
		$str = trim($str, $options['delimiter']);

		return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
	}

	private function __getProductDetails($product_id = null, $language_id = 0) {

		if ($language_id == 0) {
			$product = $this->model_seo_power_pack_settings->getProduct($product_id);

			foreach ($product as $key => $val) {
				$product[$key] = trim($val);
			}

			$product['desc'] = $this->model_seo_power_pack_settings->getProductDescriptions($product_id);
			if (isset($product['manufacturer_id']) && intval($product['manufacturer_id']) > 0) {
				$manufacturer            = $this->model_seo_power_pack_settings->getManufacturer($product['manufacturer_id']);
				$product['manufacturer'] = $manufacturer['name'];
			} else {
				$product['manufacturer'] = '';

			}

			$categories = $this->model_seo_power_pack_settings->getProductCategories($product_id);

			$product['product_categories'] = array();

			$languages = $this->model_seo_power_pack_settings->getActiveLanguages();

			foreach ($categories as $category_id) {
				foreach ($languages as $lang) {
					$category_info = $this->model_seo_power_pack_settings->getCategory($category_id, $lang['language_id']);
					if ($category_info) {
						$product['product_categories'][$lang['language_id']][] = ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name'];
					}
				}
			}

		} else {
			$product = $this->model_seo_power_pack_settings->getProduct($product_id);

			foreach ($product as $key => $val) {
				$product[$key] = trim($val);
			}

			$product['desc'] = $this->model_seo_power_pack_settings->getProductDescriptions($product_id, $language_id);
			if (isset($product['manufacturer_id']) && intval($product['manufacturer_id']) > 0) {
				$manufacturer            = $this->model_seo_power_pack_settings->getManufacturer($product['manufacturer_id']);
				$product['manufacturer'] = $manufacturer['name'];
			} else {
				$product['manufacturer'] = '';

			}

			$categories = $this->model_seo_power_pack_settings->getProductCategories($product_id);

			$product['product_categories'] = array();

			$languages = $this->model_seo_power_pack_settings->getActiveLanguages();

			foreach ($categories as $category_id) {
				$category_info = $this->model_seo_power_pack_settings->getCategory($category_id, $language_id);
				if ($category_info) {
					$product['product_categories'][$language_id][] = ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name'];
				}
			}
		}

		return $product;
	}

	private function __hasPermission() {
		if (!$this->user->hasPermission('modify', 'seo_power_pack/settings')) {
			return false;
		}
		return true;
	}

	public function auto_settings() {
		if (!$this->__hasPermission()) {
			exit;
		}

		$this->load->model('setting/setting');

		if (isset($this->request->get['auto_field']) && isset($this->request->get['auto_field_value']) && strlen(trim($this->request->get['auto_field'])) > 1) {

			$this->model_setting_setting->editSetting(
				'seo_pp_' . $this->request->get['auto_field'],
				array('seo_pp_' . $this->request->get['auto_field'] => intval($this->request->get['auto_field_value']))
			);

		}
	}

}