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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_links/assets/css/links.css');
?>
<script type="text/javascript">
        js = jQuery.noConflict();
        js(document).ready(function(){
		
		});

		Joomla.submitbutton = function(task)
		{
			if (task == 'link.cancel') {
				Joomla.submitform(task, document.getElementById('link-form'));
			}
			else{
				
				if (task != 'link.cancel' && document.formvalidator.isValid(document.id('link-form'))) {
					
					Joomla.submitform(task, document.getElementById('link-form'));
				}
				else {
					alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
				}
			}
		}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_links&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="link-form" class="form-validate">

<div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_LINKS_LEGEND_LINK', true)); ?>

    <div class="row-fluid">
        <fieldset class="adminform">

				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
				</div>
				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('name'); ?></div>
				</div>
				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('category'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('category'); ?></div>
				</div>
				
				<input type="hidden" name="jform[timestamp]" value="<?php echo date('Y-m-d H:i:s'); ?>" />

			<?php
				foreach((array)$this->item->category as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="category" name="jform[categoryhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				
			
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('url'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('url'); ?></div>
				</div>
				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('description'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('description'); ?></div>
				</div>
				
				<input type="hidden" name="jform[timestamp]" value="<?php echo date('Y-m-d H:i:s'); ?>" />
				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
				</div>

				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
				</div>

        </fieldset>
    </div>
	
    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>