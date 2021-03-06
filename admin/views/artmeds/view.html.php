<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
/**
 * @version		$Id: view.html.php 2012-03-12 $
 * @package		MAMS.Admin
 * @subpackage	artmeds
 * @copyright	Copyright (C) 2012 DtD Productions.
 * @license		GNU General Public License version 2
 */

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * MAMS Article Medias View
 *
 * @static
 * @package		MAMS.Admin
 * @subpackage	artmeds
 * @since		1.0
 */
class MAMSViewArtMeds extends JView
{
	function display($tpl = null) 
	{
		// Get data from the model
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
		$this->state		= $this->get('State');
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;
		// Set the toolbar
		$this->addToolBar();

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		$state	= $this->get('State');
		JToolBarHelper::title(JText::_('COM_MAMS_MANAGER_ARTCATS'), 'mams');
		JToolBarHelper::addNew('artmed.add', 'COM_MAMS_TOOLBAR_ADD');
		JToolBarHelper::editList('artmed.edit', 'JTOOLBAR_EDIT');
		JToolBarHelper::divider();
		JToolBarHelper::custom('artmeds.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
		JToolBarHelper::custom('artmeds.unpublish', 'unpublish.png', 'unpublish_f2.png','JTOOLBAR_UNPUBLISH', true);
		JToolBarHelper::divider();
		if ($state->get('filter.published') == -2) {
			JToolBarHelper::deleteList('', 'artmeds.delete', 'JTOOLBAR_EMPTY_TRASH');
			JToolBarHelper::divider();
		} else  {
			JToolBarHelper::trash('artmeds.trash');
		}
		JToolBarHelper::back('COM_MAMS_TOOLBAR_ARTICLES','index.php?option=com_mams&view=articles');
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_MAMS_MANAGER_ARTMEDS'));
	}
}
