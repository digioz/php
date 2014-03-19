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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_addressbook/assets/css/addressbook.css');
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
            

            Joomla.submitbutton = function(task)
            {
                if (task == 'address.cancel') {
                    Joomla.submitform(task, document.getElementById('address-form'));
                }
                else{
                    
                    if (task != 'address.cancel' && document.formvalidator.isValid(document.id('address-form'))) {
                        
                        Joomla.submitform(task, document.getElementById('address-form'));
                    }
                    else {
                        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
                    }
                }
            }
        });
    });
</script>

<form action="<?php echo JRoute::_('index.php?option=com_addressbook&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="address-form" class="form-validate">
    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_ADDRESSBOOK_LEGEND_ADDRESS'); ?></legend>
            <ul class="adminformlist">

                				<li><?php echo $this->form->getLabel('id'); ?>
				<?php echo $this->form->getInput('id'); ?></li>
				<li><?php echo $this->form->getLabel('firstname'); ?>
				<?php echo $this->form->getInput('firstname'); ?></li>
				<li><?php echo $this->form->getLabel('middlename'); ?>
				<?php echo $this->form->getInput('middlename'); ?></li>
				<li><?php echo $this->form->getLabel('lastname'); ?>
				<?php echo $this->form->getInput('lastname'); ?></li>
				<li><?php echo $this->form->getLabel('company'); ?>
				<?php echo $this->form->getInput('company'); ?></li>
				<li><?php echo $this->form->getLabel('address'); ?>
				<?php echo $this->form->getInput('address'); ?></li>
				<li><?php echo $this->form->getLabel('address2'); ?>
				<?php echo $this->form->getInput('address2'); ?></li>
				<li><?php echo $this->form->getLabel('city'); ?>
				<?php echo $this->form->getInput('city'); ?></li>
				<li><?php echo $this->form->getLabel('statename'); ?>
				<?php echo $this->form->getInput('statename'); ?></li>
				<li><?php echo $this->form->getLabel('country'); ?>
				<?php echo $this->form->getInput('country'); ?></li>
				<li><?php echo $this->form->getLabel('email'); ?>
				<?php echo $this->form->getInput('email'); ?></li>
				<li><?php echo $this->form->getLabel('website'); ?>
				<?php echo $this->form->getInput('website'); ?></li>
				<li><?php echo $this->form->getLabel('twitter'); ?>
				<?php echo $this->form->getInput('twitter'); ?></li>
				<li><?php echo $this->form->getLabel('facebook'); ?>
				<?php echo $this->form->getInput('facebook'); ?></li>
				<li><?php echo $this->form->getLabel('linkedin'); ?>
				<?php echo $this->form->getInput('linkedin'); ?></li>
				<li><?php echo $this->form->getLabel('birthdate'); ?>
				<?php echo $this->form->getInput('birthdate'); ?></li>
				<li><?php echo $this->form->getLabel('workphone'); ?>
				<?php echo $this->form->getInput('workphone'); ?></li>
				<li><?php echo $this->form->getLabel('homephone'); ?>
				<?php echo $this->form->getInput('homephone'); ?></li>
				<li><?php echo $this->form->getLabel('mobilephone'); ?>
				<?php echo $this->form->getInput('mobilephone'); ?></li>
				<li><?php echo $this->form->getLabel('fax'); ?>
				<?php echo $this->form->getInput('fax'); ?></li>
				<li><?php echo $this->form->getLabel('state'); ?>
				<?php echo $this->form->getInput('state'); ?></li>
				<li><?php echo $this->form->getLabel('created_by'); ?>
				<?php echo $this->form->getInput('created_by'); ?></li>
				<li><?php echo $this->form->getLabel('notes'); ?>
				<?php echo $this->form->getInput('notes'); ?></li>


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