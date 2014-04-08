<?php
/**
 * @version     1.0.0
 * @package     com_links
 * @copyright   Copyright (C) DigiOz Multimedia, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      DigiOz Multimedia <webmaster@digioz.com> - http://www.digioz.com
 */
// no direct access
defined('_JEXEC') or die;

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_links', JPATH_ADMINISTRATOR);
$canEdit = JFactory::getUser()->authorise('core.edit', 'com_links.' . $this->item->id);
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_links' . $this->item->id)) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

    <div class="item_fields">

        <ul class="fields_list">

            			<li><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_ID'); ?>:
			<?php echo $this->item->id; ?></li>
			<li><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_NAME'); ?>:
			<?php echo $this->item->name; ?></li>
			<li><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_CATEGORY'); ?>:
			<?php echo $this->item->category; ?></li>
			<li><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_URL'); ?>:
			<?php echo $this->item->url; ?></li>
			<li><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_DESCRIPTION'); ?>:
			<?php echo $this->item->description; ?></li>
			<li><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_TIMESTAMP'); ?>:
			<?php echo $this->item->timestamp; ?></li>
			<li><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_ORDERING'); ?>:
			<?php echo $this->item->ordering; ?></li>
			<li><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_STATE'); ?>:
			<?php echo $this->item->state; ?></li>
			<li><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_CHECKED_OUT'); ?>:
			<?php echo $this->item->checked_out; ?></li>
			<li><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_CHECKED_OUT_TIME'); ?>:
			<?php echo $this->item->checked_out_time; ?></li>
			<li><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_CREATED_BY'); ?>:
			<?php echo $this->item->created_by; ?></li>


        </ul>

    </div>
    <?php if($canEdit && $this->item->checked_out == 0): ?>
		<a href="<?php echo JRoute::_('index.php?option=com_links&task=link.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_LINKS_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_links.link.'.$this->item->id)):
								?>
									<a href="javascript:document.getElementById('form-link-delete-<?php echo $this->item->id ?>').submit()"><?php echo JText::_("COM_LINKS_DELETE_ITEM"); ?></a>
									<form id="form-link-delete-<?php echo $this->item->id; ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_links&task=link.remove'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
										<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
										<input type="hidden" name="option" value="com_links" />
										<input type="hidden" name="task" value="link.remove" />
										<?php echo JHtml::_('form.token'); ?>
									</form>
								<?php
								endif;
							?>
<?php
else:
    echo JText::_('COM_LINKS_ITEM_NOT_LOADED');
endif;
?>
