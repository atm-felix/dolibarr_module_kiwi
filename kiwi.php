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
	echo $form->select_produits_list($selected,$htmlname,$filtertype,$limit,$price_level,'',$status,$finished,0,$socid);
	
	// affichage de la liste des kiwi associés
	
	$PDOdb = new TPDOdb;
	
	$kiwi = new TKiwi;
	$kiwi->fk_soc = $object->id;
	$kiwi->fk_product = 1;
	$kiwi->save($PDOdb);
	
	// pied de page 
	dol_fiche_end();
	llxFooter();
	
}