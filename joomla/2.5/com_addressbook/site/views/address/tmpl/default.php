<?php
/**
 * @version     1.0.2
 * @package     com_addressbook
 * @copyright   Copyright (C) DigiOz Multimedia. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Pete Soheil <webmaster@digioz.com> - http://www.digioz.com
 */
// no direct access
defined('_JEXEC') or die;

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_addressbook', JPATH_ADMINISTRATOR);

?>
<?php if ($this->item) : ?>

    <div class="item_fields">

        <table width="80%">

            <tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_ID'); ?>:
			</td><td><?php echo $this->item->id; ?></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_FIRSTNAME'); ?>:
			</td><td><?php echo $this->item->firstname; ?></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_MIDDLENAME'); ?>:
			</td><td><?php echo $this->item->middlename; ?></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_LASTNAME'); ?>:
			</td><td><?php echo $this->item->lastname; ?></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_COMPANY'); ?>:
			</td><td><?php echo $this->item->company; ?></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_ADDRESS'); ?>:
			</td><td><?php echo $this->item->address; ?></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_ADDRESS2'); ?>:
			</td><td><?php echo $this->item->address2; ?></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_CITY'); ?>:
			</td><td><?php echo $this->item->city; ?></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_STATENAME'); ?>:
			</td><td><?php echo $this->item->statename; ?></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_COUNTRY'); ?>:
			</td><td><?php echo $this->item->country; ?></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_EMAIL'); ?>:
			</td><td><a href="mailto:<?php echo $this->item->email; ?>"><?php echo $this->item->email; ?></a></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_WEBSITE'); ?>:
			</td><td><a href="<?php echo $this->item->website; ?>"><?php echo $this->item->website; ?></a></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_TWITTER'); ?>:
			</td><td><?php echo $this->item->twitter; ?></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_FACEBOOK'); ?>:
			</td><td><?php echo $this->item->facebook; ?></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_LINKEDIN'); ?>:
			</td><td><?php echo $this->item->linkedin; ?></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_BIRTHDATE'); ?>:
			</td><td><?php echo $this->item->birthdate; ?></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_WORKPHONE'); ?>:
			</td><td><?php echo $this->item->workphone; ?></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_HOMEPHONE'); ?>:
			</td><td><?php echo $this->item->homephone; ?></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_MOBILEPHONE'); ?>:
			</td><td><?php echo $this->item->mobilephone; ?></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_FAX'); ?>:
			</td><td><?php echo $this->item->fax; ?></td></tr>
			
			<tr><td style="font-weight:bold;"><?php echo JText::_('COM_ADDRESSBOOK_FORM_LBL_ADDRESS_NOTES'); ?>:
			</td><td><?php echo $this->item->notes; ?></td></tr>

        </table>

    </div>
    
<?php
else:
    echo JText::_('COM_ADDRESSBOOK_ITEM_NOT_LOADED');
endif;
?>
