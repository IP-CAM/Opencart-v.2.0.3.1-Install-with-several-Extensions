<?php
/**
 * Multiple Featured Module Pro
 * 
 * @author  Kyo (AKA Yasuhiro Sota)
 * @version 3.2.2
 * @license Commercial License
 * @package catalog
 * @subpackage  catalog.model.module
 */
class ModelModuleMultiFeatured extends Model {
	
/**
 * The ID to use for caching.
 *
 * @var Integer $cache_id
 */
  public $cache_id = 0;
  
/**
 * getProductIds method
 *
 * @param string $product_ids Comma separated product ids
 * @param mixed $options
 * @return array $multi_featured_data
 */
  public function getProductIds($product_ids = null, $options = null) {
    $options = array_merge(array(
        'limit' => 4,
        'disp_oos_prods' => false,
        'module_key' => null,
        'cache_expire' => 3600,
        'module_id' => null,
        'language_id' => null,
        'currency' => null
    ), (array)$options);    
    
    $multi_featured_data = null;

    if ($product_ids) {
      
      $cache = new Cache('file', $options['cache_expire']);

      $multi_featured_data = $cache->get($options['module_key'] . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$options['module_id'] . '.' . (int)$options['language_id'] . '.' . strtolower($options['currency']));

      if (!$multi_featured_data) {
        $sql = "SELECT p.product_id FROM " . DB_PREFIX . "product p"; 
        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)";
        $sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
        $sql .= " AND p.product_id IN (" . $product_ids . ")";
        
        if (!$options['disp_oos_prods']) {
          $sql .= " AND p.quantity > 0";
        }
        
        $sql .= " GROUP BY p.product_id";
        $sql .= " ORDER BY FIELD(p.product_id, $product_ids)";
        $sql .= " LIMIT " . (int)$options['limit'];

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
          $multi_featured_data[] = $result['product_id'];
        }

        $cache->set($options['module_key'] . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$options['module_id'] . '.' . (int)$options['language_id'] . '.' . strtolower($options['currency']), $multi_featured_data);
      }
      
    }

    return (array)$multi_featured_data;
  }

}
