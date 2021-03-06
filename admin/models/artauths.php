<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * @version		$Id: artauths.php 2012-03-12 $
 * @package		MAMS.Admin
 * @subpackage	artauths
 * @copyright	Copyright (C) 2012 Corona Productions.
 * @license		GNU General Public License version 2
 */

jimport('joomla.application.component.modellist');

/**
 * MAMS Article Authors Model
 *
 * @static
 * @package		MAMS.Admin
 * @subpackage	artauths
 * @since		1.0
 */
class MAMSModelArtAuths extends JModelList
{
	
	public function __construct($config = array())
	{
		
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'ordering', 'a.ordering',
			);
		}
		parent::__construct($config);
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		$published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '', 'string');
		$this->setState('filter.published', $published);

		$artId = $this->getUserStateFromRequest($this->context.'.filter.article', 'filter_article','');
		$this->setState('filter.article', $artId);
		
		// Load the parameters.
		$params = JComponentHelper::getParams('com_mams');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.ordering', 'asc');
	}
	
	protected function getListQuery() 
	{
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		// Select some fields
		$query->select('a.*');

		// From the table
		$query->from('#__mams_artauth as a');
		
		// Filter by article.
		$artId = $this->getState('filter.article');
		if (is_numeric($artId)) {
			$query->where('a.aa_art = '.(int) $artId);
		}

		// Join over the authors.
		$query->select('auth.auth_name');
		$query->join('LEFT', '#__mams_authors AS auth ON auth.auth_id = a.aa_auth');
		
		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published)) {
			$query->where('a.published = '.(int) $published);
		} else if ($published === '') {
			$query->where('(a.published IN (0, 1))');
		}
		
		$orderCol	= $this->state->get('list.ordering');
		$orderDirn	= $this->state->get('list.direction');
		
		$query->order($db->getEscaped($orderCol.' '.$orderDirn));
				
		return $query;
	}
}
