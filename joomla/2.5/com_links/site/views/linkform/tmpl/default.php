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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JPluginHelper::importPlugin('captcha');

$dispatcher = JDispatcher::getInstance();

$dispatcher->trigger('onInit','dynamic_recaptcha_1');

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_links', JPATH_ADMINISTRATOR);
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
            js('#form-link').submit(function(event){
                 
            }); 
        
            
        });
    });

   
    	   
    	
</script>

<script>
// just for the demos, avoids form submit


getScript('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js',function() {
    jQuery.noConflict();
    var isValid = function isValid(form, field){
        return $(form-link).valid({
          rules: {
        	jform_url: {
              required: true,
              url: true
            }
          }
        });    
    };
});
</script>

<p style="text-align: center;color: black;font-size: 18px;">
	<a href="<?php echo JRoute::_('index.php?option=com_links&view=links'); ?>">
		<?php echo JText::_("COM_LINKS_ADD_ITEM_LINK_INDEX_TEXT"); ?>
	</a> - 
	<?php echo JText::_("COM_LINKS_ADD_ITEM_LINK_ADD_TEXT"); ?>
</p>

<div class="items" style="background-color:#EFEFEF;width:100%;">
<div class="catnamelink" style="width:100%;"><?php echo JText::_('COM_LINKS_ADD_ITEM_LINK_ADD_TEXT'); ?></div>
	<div>
		<?php if (!empty($this->item->id)): ?>
			<h1>Edit <?php echo $this->item->id; ?></h1>
		<?php else: ?>
			<h2 style="padding-left:30px;">Add Link</h2>
		<?php endif; ?>
		<?php if($_GET['mesag'])
		{
		echo "<h2 style='color:red;'>Invalid Captcha</h2>";
		}
		
		?>
		<form id="form-link" action="<?php echo JRoute::_('index.php?option=com_links&task=link.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
			<ul>
								<li><?php echo $this->form->getLabel('id'); ?>
					<?php echo $this->form->getInput('id'); ?></li>
					<li><?php echo $this->form->getLabel('name'); ?>
					<?php echo $this->form->getInput('name'); ?></li>
					<li><?php echo $this->form->getLabel('category'); ?>
					<?php echo $this->form->getInput('category'); ?></li>

				<?php
					foreach((array)$this->item->category as $value): 
						if(!is_array($value)):
							echo '<input type="hidden" class="category" name="jform[categoryhidden]['.$value.']" value="'.$value.'" />';
						endif;
					endforeach;
				?>
				<script type="text/javascript">
					window.onload = function(){
						jQuery.noConflict();
						jQuery('input:hidden.category').each(function(){
							var name = jQuery(this).attr('name');
							if(name.indexOf('categoryhidden')){
								jQuery('#jform_category option[value="'+jQuery(this).val()+'"]').attr('selected',true);
							}
						});
					}
				</script>				<li><?php echo $this->form->getLabel('url'); ?>
					<?php echo $this->form->getInput('url'); ?></li>
					<li><?php echo $this->form->getLabel('description'); ?>
					
					
					<?php echo $this->form->getInput('description'); ?></li>
					<input type="hidden" name="jform[timestamp]" value="<?php echo $this->item->timestamp; ?>" />
					<?php $canState = false; ?>
						<?php $canState = $canState = JFactory::getUser()->authorise('core.edit.state','com_links'); ?>				<?php if(!$canState): ?>
						
						<input type="hidden" name="jform[state]" value="<?php echo $state_value; ?>" />				<?php else: ?>					<li><?php //echo $this->form->getLabel('state'); ?>
						<?php //echo $this->form->getInput('state'); ?></li>
						<li>
						
						</li>
						
					<?php endif; ?>				<li><?php $this->form->getLabel('created_by'); ?>
					<?php $this->form->getInput('created_by'); ?></li>
				<li>
				
				
				</li>
			
			
			</ul>
			<?php if(JFactory::getUser()->guest){ ?>
			<div id="dynamic_recaptcha_1" style="padding-left:30px;"></div>
			<?php }?>
			<br />
			<div style="padding-left:30px;">
				<button type="submit" class="validate"><span><?php echo JText::_('JSUBMIT'); ?></span></button>
				<?php echo JText::_('or'); ?>
				<a href="<?php echo JRoute::_('index.php?option=com_links&task=linkform.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>

				<input type="hidden" name="option" value="com_links" />
				<input type="hidden" name="task" value="linkform.save" />
				<?php echo JHtml::_('form.token'); ?>
			</div>
		</form>
		
		
	</div>
</div>
