<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
/**
 * @version		$Id: artmedias.php 2012-03-12 $
 * @package		MAMS.Admin
 * @subpackage	artmedias
 * @copyright	Copyright (C) 2012 Corona Productions.
 * @license		GNU General Public License version 2
 */

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * MAMS Article Media Controller
 *
 * @static
 * @package		MAMS.Admin
 * @subpackage	artmedias
 * @since		1.0
 */
class MAMSControllerArtMedias extends JControllerAdmin
{

	protected $text_prefix = "COM_MAMS_ARTMEDIA";
	
	public function getModel($name = 'ArtMedia', $prefix = 'MAMSModel') 
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}