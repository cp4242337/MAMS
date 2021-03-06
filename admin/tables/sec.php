<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
/**
 * @version		$Id: sec.php 2012-03.05 $
 * @package		MAMS.Admin
 * @subpackage	sec
 * @copyright	Copyright (C) 2012 Corona Productions.
 * @license		GNU General Public License version 2
 */

// import Joomla table library
jimport('joomla.database.table');

/**
 * MAMS Section Table
 *
 * @static
 * @package		MAMS.Admin
 * @subpackage	sec
 * @since		1.0
 */
class MAMSTableSec extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function __construct(&$db) 
	{
		parent::__construct('#__mams_secs', 'sec_id', $db);
	}
	
	public function store($updateNulls = false)
	{
		$date	= JFactory::getDate();
		$user	= JFactory::getUser();
		if ($this->sec_id) {
			// Existing item
			$this->sec_modified		= $date->toMySQL();
		} else {
			// New section. A section created on field can be set by the user,
			// so we don't touch either of these if they are set.
			if (!intval($this->sec_cadded)) {
				$this->sec_added = $date->toMySQL();
				$this->sec_modified		= $date->toMySQL();
			}
		}

		// Verify that the alias is unique
		$table = JTable::getInstance('Sec', 'MAMSTable');
		if ($table->load(array('sec_alias'=>$this->sec_alias)) && ($table->sec_id != $this->sec_id || $this->sec_id==0)) {
			$this->setError(JText::_('COM_MAMS_ERROR_UNIQUE_ALIAS'));
			return false;
		}
		// Attempt to store the user data.
		return parent::store($updateNulls);
	}
	
	public function check()
	{
		// check for valid name
		if (trim($this->sec_name) == '') {
			$this->setError(JText::_('COM_MAMS_ERR_TABLES_TITLE'));
			return false;
		}

		// check for existing name
		$query = 'SELECT sec_id FROM #__mams_secs WHERE sec_name = '.$this->_db->Quote($this->sec_name);
		$this->_db->setQuery($query);

		$xid = intval($this->_db->loadResult());
		if ($xid && $xid != intval($this->sec_id)) {
			$this->setError(JText::_('COM_MAMS_ERR_TABLES_NAME'));
			return false;
		}

		if (empty($this->sec_alias)) {
			$this->sec_alias = $this->sec_name;
		}
		$this->sec_alias = JApplication::stringURLSafe($this->sec_alias);
		if (trim(str_replace('-','',$this->sec_alias)) == '') {
			$this->sec_alias = JFactory::getDate()->format("Y-m-d-H-i-s");
		}

		return true;
	}
	
}