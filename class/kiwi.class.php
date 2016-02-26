<?php

class TKiwi extends TObjetStd {
	
	function __construct() {
		
		$this->set_table(MAIN_DB_PREFIX.'kiwi');
	  
		$this->add_champs('fk_soc,fk_product',array('type'=>'integer', 'index'=>true));
		$this->add_champs('note','type=text;');
		
		$this->_init_vars();
		
		$this->start();
		
		
	}
	
	function load(&$PDOdb, $id) {
		
		$res = parent::load($PDOdb, $id);
		
		if($this->fk_product>0) {
			global $conf,$user,$db,$langs;
			
			dol_include_once('/product/class/product.class.php');			
			
			$this->product = new Product($db);
			$this->product->fetch($this->fk_product);
			
		}
		
		return $res;
		
	}
	
	static function getProduct(&$PDOdb) {
		global $conf;
		
		$PDOdb->Execute("SELECT c.fk_product,p.label FROM ".MAIN_DB_PREFIX."categorie_product c
				LEFT JOIN ".MAIN_DB_PREFIX."product p ON (c.fk_product=p.rowid)
		WHERE c.fk_categorie=".(int)$conf->global->KIWI_PRODUCT_CATEG);
		
		$Tab=array();
		
		while($obj = $PDOdb->Get_line()) {
			
			$Tab[ $obj->fk_product ] = $obj->label;
			
		}
		
		return $Tab;
		
	}
	
	static function getNumber(&$PDOdb, $fk_soc) {
		
		$Tab = self::getAll($PDOdb, $fk_soc);
		
		return count($Tab);
		
	}
	
	static function getAll(&$PDOdb, $fk_soc) {
		
		$TRes  = $PDOdb->ExecuteAsArray("SELECT rowid FROM ".MAIN_DB_PREFIX."kiwi WHERE fk_soc = ".$fk_soc);
		$Tab=array();
		foreach($TRes as &$row) {
			
			$k=new TKiwi;
			if($k->load($PDOdb, $row->rowid)) {
				$Tab[] = $k;	
			}
			
		}
		
		return $Tab;
		
	}
	
}
