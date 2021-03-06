<?php
/* <one line to give the program's name and a brief idea of what it does.>
 * Copyright (C) 2015 ATM Consulting <support@atm-consulting.fr>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * \file    class/actions_kiwi.class.php
 * \ingroup kiwi
 * \brief   This file is an example hook overload class file
 *          Put some comments here
 */

/**
 * Class ActionsKiwi
 */
class ActionsKiwi
{
	/**
	 * @var array Hook results. Propagated to $hookmanager->resArray for later reuse
	 */
	public $results = array();

	/**
	 * @var string String displayed by executeHook() immediately after return
	 */
	public $resprints;

	/**
	 * @var array Errors
	 */
	public $errors = array();

	/**
	 * Constructor
	 */
	public function __construct()
	{
	}

	/**
	 * Overloading the doActions function : replacing the parent's function with the one below
	 *
	 * @param   array()         $parameters     Hook metadatas (context, etc...)
	 * @param   CommonObject    &$object        The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param   string          &$action        Current action (if set). Generally create or edit or null
	 * @param   HookManager     $hookmanager    Hook manager propagated to allow calling another hook
	 * @return  int                             < 0 on error, 0 on success, 1 to replace standard code
	 */
	function formObjectOptions($parameters, &$object, &$action, $hookmanager)
	{
		if (in_array('thirdpartycard', explode(':', $parameters['context'])))
		{
			
			global $db,$langs,$conf,$user;
		  
		  ?>
		  <tr>
		  	<td><?php echo $langs->trans('NumberOfKiwi') ?></td>
		  	<td><?php 
		  	
		  	define('INC_FROM_DOLIBARR', true);
		  	dol_include_once('/kiwi/config.php');
			dol_include_once('/kiwi/class/kiwi.class.php');
			
			$PDOdb=new TPDOdb;
			$nb = TKiwi::getNumber($PDOdb, $object->id);
			
			echo $nb.img_picto('Picto au pif', 'info_black.png');
			
		  	?></td>
		  </tr>
		  <?php
		  	
		  
		}

		if (! $error)
		{
			
			return 0; // or return 1 to replace standard code
		}
		else
		{
			$this->errors[] = 'Error message';
			return -1;
		}
	}
}