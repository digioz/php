<?php
/**
 * @version     1.0.3
 * @package     com_links
 * @copyright   Copyright (C) DigiOz Multimedia, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      DigiOz Multimedia <webmaster@digioz.com> - http://www.digioz.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Link controller class.
 */
class LinksControllerLink extends JControllerForm
{

    function __construct() {
        $this->view_list = 'links';
        parent::__construct();
    }

}