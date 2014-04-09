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
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                                'id', 'a.id',
                'title', 'a.title',
                'story', 'a.story',
                'author', 'a.author',
                'coauthors', 'a.coauthors',
                'summary', 'a.summary',
                'ordering', 'a.ordering',
                'state', 'a.state',
                'created_by', 'a.created_by',
                'notes', 'a.notes',
                'categories', 'a.categories',
                'subcategories', 'a.subcategories',
                'warnings', 'a.warnings',
                'rating', 'a.rating',
                'chaptertitle', 'a.chaptertitle',
                'chapternotes', 'a.chapternotes',
                'storytext', 'a.storytext',
                'endnotes', 'a.endnotes',

            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        
		//Filtering categories
		$this->setState('filter.categories', $app->getUserStateFromRequest($this->context.'.filter.categories', 'filter_categories', '', 'string'));

		//Filtering subcategories
		$this->setState('filter.subcategories', $app->getUserStateFromRequest($this->context.'.filter.subcategories', 'filter_subcategories', '', 'string'));


        // Load the parameters.
        $params = JComponentHelper::getParams('com_stories');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.title', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id.= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
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

        
		// Join over the users for the checked out user
		$query->select("uc.name AS editor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");
		// Join over the foreign key 'story'
		$query->select('#__stories_story_1185742.title AS stories_title_1185742');
		$query->join('LEFT', '#__stories_story AS #__stories_story_1185742 ON #__stories_story_1185742.id = a.story');
		// Join over the user field 'created_by'
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

        

		// Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.state = ' . (int) $published);
		} else if ($published === '') {
			$query->where('(a.state IN (0, 1))');
		}

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.title LIKE '.$search.'  OR  a.author LIKE '.$search.'  OR  a.coauthors LIKE '.$search.'  OR  a.categories LIKE '.$search.'  OR  a.subcategories LIKE '.$search.' )');
            }
        }

        

		//Filtering categories
		$filter_categories = $this->state->get("filter.categories");
		if ($filter_categories) {
			$query->where("FIND_IN_SET(" . $filter_categories. ",a.categories)");
		}

		//Filtering subcategories
		$filter_subcategories = $this->state->get("filter.subcategories");
		if ($filter_subcategories) {
			$query->where("FIND_IN_SET(" . $filter_subcategories. ",a.subcategories)");
		}


        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

    public function getItems() {
        $items = parent::getItems();
        
		foreach ($items as $oneItem) {

			if (isset($oneItem->story)) {
				$values = explode(',', $oneItem->story);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('title')
							->from('`#__stories_story`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$oneItem->story = !empty($textValue) ? implode(', ', $textValue) : $oneItem->story;

			}

			if (isset($oneItem->categories)) {
				$values = explode(',', $oneItem->categories);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('name')
							->from('`#__stories_category`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$oneItem->categories = !empty($textValue) ? implode(', ', $textValue) : $oneItem->categories;

			}

			if (isset($oneItem->subcategories)) {
				$values = explode(',', $oneItem->subcategories);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('name')
							->from('`#__stories_subcategory`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$oneItem->subcategories = !empty($textValue) ? implode(', ', $textValue) : $oneItem->subcategories;

			}

			if (isset($oneItem->rating)) {
				$values = explode(',', $oneItem->rating);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('name')
							->from('`#__stories_rating`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->name;
					}
				}

			$oneItem->rating = !empty($textValue) ? implode(', ', $textValue) : $oneItem->rating;

			}
		}
        return $items;
    }

}
