<?php
// No direct access to this file
defined('_JEXEC') or die;
/**
 * @version		$Id: mams.php 2012-03-05 $
 * @package		MAMS.Admin
 * @subpackage	Helper
 * @copyright	Copyright (C) 2012 Corona Productions.
 * @license		GNU General Public License version 2
 */


abstract class MAMSHelper
{
	public static function addSubmenu($submenu) 
	{
		JSubMenuHelper::addEntry(JText::_('COM_MAMS_SUBMENU_MAMS'), 'index.php?option=com_mams', $submenu == 'mams');
		JSubMenuHelper::addEntry(JText::_('COM_MAMS_SUBMENU_ARTICLES'),'index.php?option=com_mams&view=articles',$submenu == 'artciles');
		JSubMenuHelper::addEntry(JText::_('COM_MAMS_SUBMENU_SECS'),'index.php?option=com_mams&view=secs',$submenu == 'secs');
		JSubMenuHelper::addEntry(JText::_('COM_MAMS_SUBMENU_CATS'),'index.php?option=com_mams&view=cats',$submenu == 'cats');
		JSubMenuHelper::addEntry(JText::_('COM_MAMS_SUBMENU_AUTHS'),'index.php?option=com_mams&view=auths',$submenu == 'auths');
		JSubMenuHelper::addEntry(JText::_('COM_MAMS_SUBMENU_DLOADS'),'index.php?option=com_mams&view=dloads',$submenu == 'dloads');
		JSubMenuHelper::addEntry(JText::_('COM_MAMS_SUBMENU_MEDIAS'),'index.php?option=com_mams&view=medias',$submenu == 'medias');
		JSubMenuHelper::addEntry(JText::_('COM_MAMS_SUBMENU_STATS'),'index.php?option=com_mams&view=stats',$submenu == 'stats');
	}
	
	static function getSections()
	{
		$db = JFactory::getDbo();
		$db->setQuery(
			'SELECT sec_id AS value, sec_name AS text' .
			' FROM #__mams_secs' .
			' ORDER BY sec_name'
		);
		$options = $db->loadObjectList();
		
		// Check for a database error.
		if ($db->getErrorNum())
		{
		JError::raiseNotice(500, $db->getErrorMsg());
		return null;
		}
		
		return $options;
	}

	
	
}