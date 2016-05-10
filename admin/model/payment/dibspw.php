<?php
class ModelPaymentDibspw extends Model {
    public function install() {
           $this->db->query("ALTER TABLE `" . DB_PREFIX . "customer`
                ADD COLUMN `ssn` VARCHAR(25) DEFAULT NULL;");
    }
    
    
    public function uninstall() {
           $this->db->query("ALTER TABLE `" . DB_PREFIX . "customer`
                DROP COLUMN `ssn`;");   
    }
    
    
 }