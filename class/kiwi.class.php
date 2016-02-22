<?php

class TKiwi extends TObjetStd {
	
	function __construct() {
		
		$this->set_table(MAIN_DB_PREFIX.'kiwi');
	  
		$this->add_champs('fk_soc,fk_product',array('type'=>'integer', 'index'=>true));
		$this->add_champs('note','type=text;');
		
		$this->_init_vars();
		
		$this->start();
		
		
	}
}
