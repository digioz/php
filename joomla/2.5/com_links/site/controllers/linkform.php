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

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Link controller class.
 */
class LinksControllerLinkForm extends LinksController
{

	/**
	 * Method to check out an item for editing and redirect to the edit form.
	 *
	 * @since	1.6
	 */
	public function edit()
	{
		$app			= JFactory::getApplication();

		// Get the previous edit id (if any) and the current edit id.
		$previousId = (int) $app->getUserState('com_links.edit.link.id');
		$editId	= JFactory::getApplication()->input->getInt('id', null, 'array');

		// Set the user id for the user to edit in the session.
		$app->setUserState('com_links.edit.link.id', $editId);

		// Get the model.
		$model = $this->getModel('LinkForm', 'LinksModel');

		// Check out the item
		if ($editId) {
            $model->checkout($editId);
		}

		// Check in the previous user.
		if ($previousId) {
            $model->checkin($previousId);
		}

		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option=com_links&view=link&layout=edit', false));
	}

	/**
	 * Method to save a user's profile data.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public function save()
	{
		
		if(JFactory::getUser()->guest){
		//Captcha
		$post = JRequest::get('post');      
		
		JPluginHelper::importPlugin('captcha');
		$dispatcher = JDispatcher::getInstance();
		$res = $dispatcher->trigger('onCheckAnswer',$post['recaptcha_response_field']);
		if(!$res[0]){

			$this->setRedirect(JRoute::_('index.php?option=com_links&view=linkform&layout=edit&mesag=ic', false));
			return false;	
		}
		}
		
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app	= JFactory::getApplication();
		$model = $this->getModel('LinkForm', 'LinksModel');

		// Get the user data.
		$data = JFactory::getApplication()->input->get('jform', array(), 'array');

		// Validate the posted data.
		$form = $model->getForm();
		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}

		// Validate the posted data.
		$data = $model->validate($form, $data);

		// Check for errors.
		if ($data === false) {
			// Get the validation messages.
			$errors	= $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if ($errors[$i] instanceof Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			// Save the data in the session.
			$app->setUserState('com_links.edit.link.data', JRequest::getVar('jform'),array());

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_links.edit.link.id');
			$this->setRedirect(JRoute::_('index.php?option=com_links&view=linkform&layout=edit&id='.$id, false));
			return false;
		}

		// Attempt to save the data.
		$return	= $model->save($data);
		// Check for errors.
		if ($return === false) {
			// Save the data in the session.
			$app->setUserState('com_links.edit.link.data', $data);

			// Redirect back to the edit screen.
			$id = (int)$app->getUserState('com_links.edit.link.id');
			$this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_links&view=linkform&layout=edit&id='.$id, false));
			return false;
		}
		
		//For sending email
		if ($return == 0) {
            $model->sendmail();  
        }
            
        // Check in the profile.
        if ($return) {
            $model->sendmail();
        	$model->checkin($return);  
        }
        
        // Clear the profile id from the session.
        $app->setUserState('com_links.edit.link.id', null);

        // Redirect to the list screen.
        $this->setMessage(JText::_('COM_LINKS_ITEM_SAVED_SUCCESSFULLY'));
        $menu = & JSite::getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));

		// Flush the data from the session.
		$app->setUserState('com_links.edit.link.data', null);
	}
    
    
    function cancel() {
		$menu = & JSite::getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));
    }
    
	public function remove()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app	= JFactory::getApplication();
		$model = $this->getModel('LinkForm', 'LinksModel');

		// Get the user data.
		$data = JFactory::getApplication()->input->get('jform', array(), 'array');

		// Validate the posted data.
		$form = $model->getForm();
		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}

		// Validate the posted data.
		$data = $model->validate($form, $data);

		// Check for errors.
		if ($data === false) {
			// Get the validation messages.
			$errors	= $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if ($errors[$i] instanceof Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			// Save the data in the session.
			$app->setUserState('com_links.edit.link.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_links.edit.link.id');
			$this->setRedirect(JRoute::_('index.php?option=com_links&view=link&layout=edit&id='.$id, false));
			return false;
		}

		// Attempt to save the data.
		$return	= $model->delete($data);

		// Check for errors.
		if ($return === false) {
			// Save the data in the session.
			$app->setUserState('com_links.edit.link.data', $data);

			// Redirect back to the edit screen.
			$id = (int)$app->getUserState('com_links.edit.link.id');
			$this->setMessage(JText::sprintf('Delete failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_links&view=link&layout=edit&id='.$id, false));
			return false;
		}
		
            
        // Check in the profile.
        if ($return) {
            $model->checkin($return);
        }
        
        // Clear the profile id from the session.
        $app->setUserState('com_links.edit.link.id', null);

        // Redirect to the list screen.
        $this->setMessage(JText::_('COM_LINKS_ITEM_DELETED_SUCCESSFULLY'));
        $menu = & JSite::getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));

		// Flush the data from the session.
		$app->setUserState('com_links.edit.link.data', null);
	}
    
    
}