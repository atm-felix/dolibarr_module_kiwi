<?php

	require 'config.php';
	
	dol_include_once('/societe/class/societe.class.php');
	dol_include_once('/kiwi/class/kiwi.class.php');
	dol_include_once('/core/lib/company.lib.php');
	
	
	$fk_soc = GETPOST('id');
	
	$object=new Societe($db);
	$object->fetch($fk_soc);
	
	$action = GETPOST('action');
	

	switch ($action) {
		case 'add':
			
			break;
		
		case 'del':
			
			break;
		
		default:
		
			_card($object);
			
			break;
	}


function _card(&$object) {
	global $conf,$db,$user,$langs,$form;	

	// défintion entête
	$head = societe_prepare_head($object);
	llxHeader();
	dol_fiche_head($head, 'kiwi', $langs->trans("ThirdParty"),0,'company');
	
	
	// sélection d'un produit dans une catégorie défini dans l'admin
	// on utilise un sélecteur custom car pas de filtre natif sur catégorie pour ce combo dans dolibarr
	
	$PDOdb = new TPDOdb;
	
	$TProduct = TKiwi::getProduct($PDOdb);
	
	$formCore=new TFormCore;
	
	echo $formCore->combo($langs->trans('KiwiToAdd'), 'fk_kiwi', $TProduct, 0);
	
	// affichage de la liste des kiwi associés
	
	$l=new TListviewTBS('lKiwi');
	$sql = "SELECT fk_product,date_cre FROM ".MAIN_DB_PREFIX."kiwi WHERE fk_soc = ".$object->id;
	
	
	
	echo $l->render($PDOdb, $sql,array(
	
		'title'=>array(
			'fk_product'=>$langs->trans('Product')
			,'date_cre'=>$langs->trans('Date')
		)
		,'type'=>array(
			'date_cre'=>'date'
		)
		,'eval'=>array(
			
			'fk_product'=>'getProductLink(@val@)'
		
		)
	));
	
	
	/*$kiwi = new TKiwi;
	$kiwi->fk_soc = $object->id;
	$kiwi->fk_product = 1;
	$kiwi->save($PDOdb);
	*/
	// pied de page 
	dol_fiche_end();
	llxFooter();
	
}

function getProductLink($fk_product) {
	global $conf,$user,$db,$langs;
	dol_include_once('/product/class/product.class.php');
				
	$product_static = new Product($db);
	$product_static->fetch($fk_product);
	
	
	return $product_static->getNomUrl(1).' '.$product_static->label;
}
