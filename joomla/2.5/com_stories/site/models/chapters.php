<?php

/**
 * @version     1.0.2
 * @package     com_stories
 * @copyright   Copyright (C) DigiOz Multimedia, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      DigiOz Multimedia <webmaster@gmail.com> - http://www.digioz.com
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Stories records.
 */
class StoriesModelChapters extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since	1.6
     */
    protected function populateState($ordering = null, $direction = null) {

        // Initialise variables.
        $app = JFactory::getApplication();

        // List state information
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
        $this->setState('list.limit', $limit);

        $limitstart = JFactory::getApplication()->input->getInt('limitstart', 0);
        $this->setState('list.start', $limitstart);

        
		if(empty($ordering)) {
			$ordering = 'a.ordering';
		}

        // List state information.
        parent::populateState($ordering, $direction);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'a.*'
                )
        );

        $query->from('`#__stories_chapter` AS a');

        
    // Join over the users for the checked out user.
    $query->select('uc.name AS editor');
    $query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
    
		// Join over the foreign key 'story'
		$query->select('#__stories_story_1185742.title AS stories_title_1185742');
		$query->join('LEFT', '#__stories_story AS #__stories_story_1185742 ON #__stories_story_1185742.id = a.story');
		// Join over the created by field 'created_by'
		$query->select('created_by.name AS created_by');
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
		// Join over the foreign key 'categories'
		$query->select('#__stories_category_1185734.name AS categories_name_1185734');
		$query->join('LEFT', '#__stories_category AS #__stories_category_1185734 ON #__stories_category_1185734.id = a.categories');
		// Join over the foreign key 'subcategories'
		$query->select('#__stories_subcategory_1185735.name AS subcategories_name_1185735');
		$query->join('LEFT', '#__stories_subcategory AS #__stories_subcategory_1185735 ON #__stories_subcategory_1185735.id = a.subcategories');
		// Join over the foreign key 'rating'
		$query->select('#__stories_rating_1185737.name AS ratings_name_1185737');
		$query->join('LEFT', '#__stories_rating AS #__stories_rating_1185737 ON #__stories_rating_1185737.id = a.rating');
        

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.title LIKE '.$search.'  OR  a.author LIKE '.$search.'  OR  a.coauthors LIKE '.$search.' )');
            }
        }

        

		//Filtering categories
		$filter_categories = $this->state->get("filter.categories");
		if ($filter_categories) {
			$query->where("a.categories = '".$filter_categories."'");
		}

		//Filtering subcategories
		$filter_subcategories = $this->state->get("filter.subcategories");
		if ($filter_subcategories) {
			$query->where("a.subcategories = '".$filter_subcategories."'");
		}

        return $query;
    }

    public function getItems() {
        return parent::getItems();
    }

}
