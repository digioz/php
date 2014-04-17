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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_links/assets/css/links.css');
?>
<script type="text/javascript">
    function getScript(url,success) {
        var script = document.createElement('script');
        script.src = url;
        var head = document.getElementsByTagName('head')[0],
        done = false;
        // Attach handlers for all browsers
        script.onload = script.onreadystatechange = function() {
            if (!done && (!this.readyState
                || this.readyState == 'loaded'
                || this.readyState == 'complete')) {
                done = true;
                success();
                script.onload = script.onreadystatechange = null;
                head.removeChild(script);
            }
        };
        head.appendChild(script);
    }
    getScript('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js',function() {
        js = jQuery.noConflict();
        js(document).ready(function(){
            
					js('input:hidden.category').each(function(){
						var name = js(this).attr('name');
						if(name.indexOf('categoryhidden')){
							js('#jform_category option[value="'+jQuery(this).val()+'"]').attr('selected',true);
						}
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
        });
    });
</script>

<form action="<?php echo JRoute::_('index.php?option=com_links&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="link-form" class="form-validate">
    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_LINKS_LEGEND_LINK'); ?></legend>
            <ul class="adminformlist">

                				<li><?php echo $this->form->getLabel('id'); ?>
				<?php echo $this->form->getInput('id'); ?></li>
				<li><?php echo $this->form->getLabel('name'); ?>
				<?php echo $this->form->getInput('name'); ?></li>
				<li><?php echo $this->form->getLabel('category'); ?>
				<?php echo $this->form->getInput('category'); ?></li>
				<li><input type="hidden" name="jform[timestamp]" value="<?php echo date('Y-m-d H:i:s'); ?>" /></li>

			<?php
				foreach((array)$this->item->category as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="category" name="jform[categoryhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<li><?php echo $this->form->getLabel('url'); ?>
				<?php echo $this->form->getInput('url'); ?></li>
				<li><?php echo $this->form->getLabel('description'); ?>
				<?php echo $this->form->getInput('description'); ?></li>
				<li><input type="hidden" name="jform[timestamp]" value="<?php echo date('Y-m-d H:i:s'); ?>" /></li>
				<li><?php echo $this->form->getLabel('state'); ?>
				<?php echo $this->form->getInput('state'); ?></li>
				<li><?php echo $this->form->getLabel('created_by'); ?>
				<?php echo $this->form->getInput('created_by'); ?></li>


            </ul>
        </fieldset>
    </div>

    

    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
    <div class="clr"></div>

    <style type="text/css">
        /* Temporary fix for drifting editor fields */
        .adminformlist li {
            clear: both;
        }
    </style>
</form>