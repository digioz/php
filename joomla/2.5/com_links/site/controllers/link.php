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

require_once JPATH_COMPONENT . '/controller.php';

/**
 * Link controller class.
 */
class LinksControllerLink extends LinksController {

    /**
     * Method to check out an item for editing and redirect to the edit form.
     *
     * @since	1.6
     */
    public function edit() {
        $app = JFactory::getApplication();

        // Get the previous edit id (if any) and the current edit id.
        $previousId = (int) $app->getUserState('com_links.edit.link.id');
        $editId = JFactory::getApplication()->input->getInt('id', null, 'array');

        // Set the user id for the user to edit in the session.
        $app->setUserState('com_links.edit.link.id', $editId);

        // Get the model.
        $model = $this->getModel('Link', 'LinksModel');

        // Check out the item
        if ($editId) {
            $model->checkout($editId);
        }

        // Check in the previous user.
        if ($previousId && $previousId !== $editId) {
            $model->checkin($previousId);
        }

        // Redirect to the edit screen.
        $this->setRedirect(JRoute::_('index.php?option=com_links&view=linkform&layout=edit', false));
    }

    /**
     * Method to save a user's profile data.
     *
     * @return	void
     * @since	1.6
     */
    public function publish() {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Initialise variables.
        $app = JFactory::getApplication();
        $model = $this->getModel('Link', 'LinksModel');

        // Get the user data.
        $data = JFactory::getApplication()->input->get('jform', array(), 'array');

        // Attempt to save the data.
        $return = $model->publish($data['id'], $data['state']);

        // Check for errors.
        if ($return === false) {
            $this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
        } else {
            // Check in the profile.
            if ($return) {
                $model->checkin($return);
            }

            // Clear the profile id from the session.
            $app->setUserState('com_entrusters.edit.bid.id', null);

            // Redirect to the list screen.
            $this->setMessage(JText::_('COM_ENTRUSTERS_ITEM_SAVED_SUCCESSFULLY'));
        }

        // Clear the profile id from the session.
        $app->setUserState('com_links.edit.link.id', null);

        // Flush the data from the session.
        $app->setUserState('com_links.edit.link.data', null);

        // Redirect to the list screen.
        $this->setMessage(JText::_('COM_LINKS_ITEM_SAVED_SUCCESSFULLY'));
        $menu = & JSite::getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));
    }

    public function remove() {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Initialise variables.
        $app = JFactory::getApplication();
        $model = $this->getModel('Link', 'LinksModel');

        // Get the user data.
        $data = JFactory::getApplication()->input->get('jform', array(), 'array');

        // Attempt to save the data.
        $return = $model->delete($data['id']);

        // Check for errors.
        if ($return === false) {
            $this->setMessage(JText::sprintf('Delete failed', $model->getError()), 'warning');   
        } else {
            // Check in the profile.
            if ($return) {
                $model->checkin($return);
            }

            // Clear the profile id from the session.
            $app->setUserState('com_links.edit.link.id', null);

            // Flush the data from the session.
            $app->setUserState('com_links.edit.link.data', null);
            
            $this->setMessage(JText::_('COM_LINKS_ITEM_DELETED_SUCCESSFULLY'));
        }
          
        // Redirect to the list screen.
        $menu = & JSite::getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));
    }
    
	//Method for Sending Email
	public function sendmail(){
		
	$data = JFactory::getApplication()->input->get('jform', array(), 'array');	
		
	$linkId = $data['id'];
	$linkName = $data['name'];
	
	$db =& JFactory::getDBO();
	$query = "SELECT * FROM #__users 
			  LEFT JOIN #__user_usergroup_map 
			  ON #__users.id=#__user_usergroup_map.user_id
			  LEFT JOIN #__usergroups ON #__user_usergroup_map.group_id = #__usergroups.id
			  WHERE #__usergroups.title = 'Administrator' OR #__usergroups.title = 'Super Users'
	" ;
	
	$db->setQuery($query);
	
	$rows = $db->loadObjectList();
	foreach ($rows as $row) {
  	$to[] = $row->email;	
	}
	//For sending Email
	$mailer = JFactory::getMailer();
	$config = JFactory::getConfig();
	$sender = array( 
    $config->getValue( 'config.mailfrom' ),
    $config->getValue( 'config.fromname' ) );
 
	$mailer->setSender($sender);
	$mailer->addRecipient($to);
	

	$mailer->setSubject('Link Broken Notification');
	$mailer->setBody($body);
	
	$body   = '<h2>New Link</h2>'
    . '<div>The following link has been reported broken.</div>'
    .'Link ID :'.$linkId.'<br>'.'Link Name :'.$linkName.'<br>'
    ;
	$mailer->isHTML(true);
	$mailer->Encoding = 'base64';
	$mailer->setBody($body);
	
	$send = $mailer->Send();
	if ( $send !== true ) {
	    echo 'Error sending email: ' . $send->__toString();
	} else {
	    echo 'An Email has been sent to Admin';
	    // Redirect to the list screen.
	    $this->setMessage(JText::_('COM_LINKS_ITEM_SEND_SUCCESSFULLY'));
        $menu = & JSite::getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));
	}
	}

}
