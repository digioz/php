<?php
/**
 * @version     1.0.3
 * @package     com_addressbook
 * @copyright   Copyright (C) DigiOz Multimedia. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Pete Soheil <webmaster@digioz.com> - http://www.digioz.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Address controller class.
 */
class AddressbookControllerAddress extends JControllerForm
{

    function __construct() {
        $this->view_list = 'addresses';
        parent::__construct();
    }

}