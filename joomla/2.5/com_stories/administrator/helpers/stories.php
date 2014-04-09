<?php
/**
 * @version     1.0.2
 * @package     com_stories
 * @copyright   Copyright (C) DigiOz Multimedia, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      DigiOz Multimedia <webmaster@gmail.com> - http://www.digioz.com
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Stories helper.
 */
class StoriesHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($vName = '')
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_STORIES_TITLE_STORIES'),
			'index.php?option=com_stories&view=stories',
			$vName == 'stories'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_STORIES_TITLE_CATEGORIES'),
			'index.php?option=com_stories&view=categories',
			$vName == 'categories'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_STORIES_TITLE_SUBCATEGORIES'),
			'index.php?option=com_stories&view=subcategories',
			$vName == 'subcategories'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_STORIES_TITLE_RATINGS'),
			'index.php?option=com_stories&view=ratings',
			$vName == 'ratings'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_STORIES_TITLE_CHAPTERS'),
			'index.php?option=com_stories&view=chapters',
			$vName == 'chapters'
		);

	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_stories';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}
