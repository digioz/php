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
?>
<script type="text/javascript">
    function deleteItem(item_id){
        if(confirm("<?php echo JText::_('COM_ADDRESSBOOK_DELETE_MESSAGE'); ?>")){
            document.getElementById('form-address-delete-' + item_id).submit();
        }
    }
</script>

<table width="90%">
    <tr><td><b>First Name</b></td><td><b>Last Name</b></td><td><b>Company</b></td><td><b>Email</b></td></tr>
<?php $show = false; ?>
        <?php foreach ($this->items as $item) : ?>

            
				<?php
					if($item->state == 1 || ($item->state == 0 && JFactory::getUser()->authorise('core.edit.own',' com_addressbook'))):
						$show = true;
						?>
							<tr>
							<td>
								<a href="<?php echo JRoute::_('index.php?option=com_addressbook&view=address&id=' . (int)$item->id); ?>"><?php echo $item->firstname; ?></a>
							</td>
							<td>
								<a href="<?php echo JRoute::_('index.php?option=com_addressbook&view=address&id=' . (int)$item->id); ?>"><?php echo $item->lastname; ?></a>
							</td>
							<td>
								<a href="<?php echo JRoute::_('index.php?option=com_addressbook&view=address&id=' . (int)$item->id); ?>"><?php echo $item->company; ?></a>
							</td>
							<td>
								<a href="<?php echo 'mailto:'. $item->email; ?>"><?php echo $item->email; ?></a>
							</td>
							</tr>
						<?php endif; ?>

<?php endforeach; ?>
        <?php
        if (!$show):
            echo JText::_('COM_ADDRESSBOOK_NO_ITEMS');
        endif;
        ?>
    
</table>
<?php if ($show): ?>
    <div class="pagination">
        <p class="counter">
            <?php echo $this->pagination->getPagesCounter(); ?>
        </p>
        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
<?php endif; ?>

