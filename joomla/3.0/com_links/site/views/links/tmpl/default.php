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
?>

<script type="text/javascript">
    function deleteItem(item_id){
        if(confirm("<?php echo JText::_('COM_LINKS_DELETE_MESSAGE'); ?>")){
            document.getElementById('form-link-delete-' + item_id).submit();
        }
    }
    function broken(item_id){
        if(confirm("<?php echo "Are you sure you want to Report this link?"; ?>")){
            document.getElementById('form-send-mail-' + item_id).submit();
        }
    }
    
        
</script>


<?php
// Add styles
JHtml::stylesheet(JURI::base() . 'components/com_links/css/links.css', array(), true);
?>
<p style="text-align: center;
color: black;
font-size: 18px;"><?php echo JText::_("COM_LINKS_ADD_ITEM_LINK_INDEX_TEXT"); ?> - &nbsp;<a href="<?php echo JRoute::_('index.php?option=com_links&task=link.edit&id=0'); ?>"><?php echo JText::_("COM_LINKS_ADD_ITEM_LINK_ADD_TEXT"); ?></a></p>
<div class="items">  
<?php $show = false; ?>
	<?php $cat = $this->items['category']?>
	<?php foreach ($this->items as $item) : ?>
		<?php 
		if ($cat != $item->category){
		?>
		<div class="catnamelink">
			
		<?php
		 echo $item->categories_name_1152660;
		 $cat = $item->category;
		?>
		</div>
		<?php
		}
		?>
		
		<div class="linkname">		
			<span class="linkspan"><a href="<?php echo $item->url; ?>" target="_blank"><?php echo $item->name; ?></a></span>
			<a href="<?php echo JRoute::_('index.php?option=com_links&view=link&id=' . (int)$item->id); ?>" class="descli"><img src="<?php echo JURI::base() . 'components/com_links/images/description.jpg' ?>" alt="broken" /></a>
			<a href="javascript:broken(<?php echo $item->id; ?>);" id="broken" class="brcli"><img src="<?php echo JURI::base() . 'components/com_links/images/broken.jpg' ?>" alt="broken" /></a>
		</div>
				
		<form id="form-send-mail-<?php echo $item->id; ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_links&task=link.sendmail'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
			<input type="hidden" name="jform[id]" value="<?php echo $item->id; ?>" />
			<input type="hidden" name="jform[name]" value="<?php echo $item->name; ?>" />
			<input type="hidden" name="option" value="com_links" />
			<input type="hidden" name="task" value="link.sendmail" />
			<?php echo JHtml::_('form.token'); ?>
		</form>

	<?php endforeach; ?>
  
</div>
<?php if ($show): ?>
    <div class="paginations">
        <p class="counter">
            <?php echo $this->pagination->getPagesCounter(); ?>
        </p>
        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
<?php endif; ?>


									
	
	
