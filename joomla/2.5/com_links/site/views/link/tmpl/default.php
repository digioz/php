<?php
/**
 * @version     1.0.3
 * @package     com_links
 * @copyright   Copyright (C) DigiOz Multimedia, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      DigiOz Multimedia <webmaster@digioz.com> - http://www.digioz.com
 */
// no direct access
defined('_JEXEC') or die;

// Add styles
JHtml::stylesheet(JURI::base() . 'components/com_links/css/links.css', array(), true);

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_links', JPATH_ADMINISTRATOR);
$canEdit = JFactory::getUser()->authorise('core.edit', 'com_links');
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_links')) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>

<p style="text-align: center;color: black;font-size: 18px;">
	<a href="<?php echo JRoute::_('index.php?option=com_links&view=links'); ?>">
		<?php echo JText::_("COM_LINKS_ADD_ITEM_LINK_INDEX_TEXT"); ?>
	</a> - 
	<a href="<?php echo JRoute::_('index.php?option=com_links&task=link.edit&id=0'); ?>">
		<?php echo JText::_("COM_LINKS_ADD_ITEM_LINK_ADD_TEXT"); ?>
	</a>
</p>

<?php if ($this->item) : ?>

<div class="items" style="background-color:#EFEFEF;width:100%;">
<div class="catnamelink"><?php echo JText::_('COM_LINKS_FORM_DESC_DETAILS_PUBLIC'); ?></div>
    <div class="item_fields">

        <table style="width:100%">

            <tr><td style="width: 150px;"><b><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_ID'); ?>:</b></td><td><?php echo $this->item->id; ?></td></tr>
			<tr><td><b><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_NAME'); ?>:</b></td><td>
			<?php echo $this->item->name; ?></td></tr>
			<tr><td><b><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_CATEGORY'); ?>:</b></td><td>
			<?php echo $this->item->category; ?></td></tr>
			<tr><td><b><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_URL'); ?>:</b></td><td>
			<a href="<?php echo $this->item->url; ?>" target="_blank"><?php echo $this->item->url; ?></a></td></tr>
			<tr><td style="vertical-align:top;"><b><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_DESCRIPTION'); ?>:</b></td><td>
			<?php echo $this->item->description; ?></td></tr>
			<tr><td><b><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_TIMESTAMP'); ?>:</b></td><td>
			<?php echo $this->item->timestamp; ?></td></tr>
			<tr><td><b><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_ORDERING'); ?>:</b></td><td>
			<?php echo $this->item->ordering; ?></td></tr>
			<tr><td><b><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_STATE'); ?>:</b></td><td>
			<?php echo $this->item->state; ?></td></tr>
			<tr><td><b><?php echo JText::_('COM_LINKS_FORM_LBL_LINK_CREATED_BY'); ?>:</b></td><td>
			<?php echo $this->item->created_by; ?></td></tr>


        </table>

    </div>
    <?php if($canEdit && $this->item->checked_out == 0): ?>
		<a href="<?php echo JRoute::_('index.php?option=com_links&task=link.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_LINKS_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_links')):
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
</div>
<?php
else:
    echo JText::_('COM_LINKS_ITEM_NOT_LOADED');
endif;
?>
