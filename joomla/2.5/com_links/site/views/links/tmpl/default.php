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
?>
<script type="text/javascript">
    function deleteItem(item_id){
        if(confirm("<?php echo JText::_('COM_LINKS_DELETE_MESSAGE'); ?>")){
            document.getElementById('form-link-delete-' + item_id).submit();
        }
    }
</script>

<div class="items">
    <ul class="items_list">
<?php $show = false; ?>
        <?php foreach ($this->items as $item) : ?>

            
				<?php
					if($item->state == 1 || ($item->state == 0 && JFactory::getUser()->authorise('core.edit.own',' com_links.link.'.$item->id))):
						$show = true;
						?>
							<li>
								<a href="<?php echo JRoute::_('index.php?option=com_links&view=link&id=' . (int)$item->id); ?>"><?php echo $item->name; ?></a>
								<?php
									if(JFactory::getUser()->authorise('core.edit.state','com_links.link.'.$item->id)):
									?>
										<a href="javascript:document.getElementById('form-link-state-<?php echo $item->id; ?>').submit()"><?php if($item->state == 1): echo JText::_("COM_LINKS_UNPUBLISH_ITEM"); else: echo JText::_("COM_LINKS_PUBLISH_ITEM"); endif; ?></a>
										<form id="form-link-state-<?php echo $item->id ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_links&task=link.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
											<input type="hidden" name="jform[id]" value="<?php echo $item->id; ?>" />
											<input type="hidden" name="jform[state]" value="<?php echo (int)!((int)$item->state); ?>" />
											<input type="hidden" name="option" value="com_links" />
											<input type="hidden" name="task" value="link.publish" />
											<?php echo JHtml::_('form.token'); ?>
										</form>
									<?php
									endif;
									if(JFactory::getUser()->authorise('core.delete','com_links.link.'.$item->id)):
									?>
										<a href="javascript:deleteItem(<?php echo $item->id; ?>);"><?php echo JText::_("COM_LINKS_DELETE_ITEM"); ?></a>
										<form id="form-link-delete-<?php echo $item->id; ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_links&task=link.remove'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
											<input type="hidden" name="jform[id]" value="<?php echo $item->id; ?>" />
											<input type="hidden" name="option" value="com_links" />
											<input type="hidden" name="task" value="link.remove" />
											<?php echo JHtml::_('form.token'); ?>
										</form>
									<?php
									endif;
								?>
							</li>
						<?php endif; ?>

<?php endforeach; ?>
        <?php
        if (!$show):
            echo JText::_('COM_LINKS_NO_ITEMS');
        endif;
        ?>
    </ul>
</div>
<?php if ($show): ?>
    <div class="pagination">
        <p class="counter">
            <?php echo $this->pagination->getPagesCounter(); ?>
        </p>
        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
<?php endif; ?>


									<?php if(JFactory::getUser()->authorise('core.create','com_links')): ?><a href="<?php echo JRoute::_('index.php?option=com_links&task=link.edit&id=0'); ?>"><?php echo JText::_("COM_LINKS_ADD_ITEM"); ?></a>
	<?php endif; ?>