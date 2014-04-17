<?php
/**
 * @version     1.0.3
 * @package     com_links
 * @copyright   Copyright (C) DigiOz Multimedia, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      DigiOz Multimedia <webmaster@digioz.com> - http://www.digioz.com
 */

// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Links list controller class.
 */
class LinksControllerLinks extends LinksController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'Links', $prefix = 'LinksModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}