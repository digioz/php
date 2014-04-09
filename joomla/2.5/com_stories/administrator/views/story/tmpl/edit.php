<?php
/**
 * @version     1.0.2
 * @package     com_stories
 * @copyright   Copyright (C) DigiOz Multimedia, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      DigiOz Multimedia <webmaster@gmail.com> - http://www.digioz.com
 */
// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_stories/assets/css/stories.css');
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
            
					js('input:hidden.categories').each(function(){
						var name = js(this).attr('name');
						if(name.indexOf('categorieshidden')){
							js('#jform_categories option[value="'+jQuery(this).val()+'"]').attr('selected',true);
						}
					});
					js('input:hidden.subcategories').each(function(){
						var name = js(this).attr('name');
						if(name.indexOf('subcategorieshidden')){
							js('#jform_subcategories option[value="'+jQuery(this).val()+'"]').attr('selected',true);
						}
					});
					js('input:hidden.rating').each(function(){
						var name = js(this).attr('name');
						if(name.indexOf('ratinghidden')){
							js('#jform_rating option[value="'+jQuery(this).val()+'"]').attr('selected',true);
						}
					});

            Joomla.submitbutton = function(task)
            {
                if (task == 'story.cancel') {
                    Joomla.submitform(task, document.getElementById('story-form'));
                }
                else{
                    
                    if (task != 'story.cancel' && document.formvalidator.isValid(document.id('story-form'))) {
                        js = jQuery.noConflict();
if(js('#jform_categories option:selected').length == 0){
	js("#jform_categories option[value=0]").attr('selected','selected');
}js = jQuery.noConflict();
if(js('#jform_subcategories option:selected').length == 0){
	js("#jform_subcategories option[value=0]").attr('selected','selected');
}
                        Joomla.submitform(task, document.getElementById('story-form'));
                    }
                    else {
                        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
                    }
                }
            }
        });
    });
</script>

<form action="<?php echo JRoute::_('index.php?option=com_stories&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="story-form" class="form-validate">
    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_STORIES_LEGEND_STORY'); ?></legend>
            <ul class="adminformlist">

                				<li><?php echo $this->form->getLabel('id'); ?>
				<?php echo $this->form->getInput('id'); ?></li>
				<li><?php echo $this->form->getLabel('title'); ?>
				<?php echo $this->form->getInput('title'); ?></li>
				<li><?php echo $this->form->getLabel('author'); ?>
				<?php echo $this->form->getInput('author'); ?></li>
				<li><?php echo $this->form->getLabel('coauthors'); ?>
				<?php echo $this->form->getInput('coauthors'); ?></li>
				<li><?php echo $this->form->getLabel('summary'); ?>
				<?php echo $this->form->getInput('summary'); ?></li>
				<li><?php echo $this->form->getLabel('state'); ?>
				<?php echo $this->form->getInput('state'); ?></li>
				<li><?php echo $this->form->getLabel('created_by'); ?>
				<?php echo $this->form->getInput('created_by'); ?></li>
				<li><?php echo $this->form->getLabel('notes'); ?>
				<?php echo $this->form->getInput('notes'); ?></li>
				<li><?php echo $this->form->getLabel('categories'); ?>
				<?php echo $this->form->getInput('categories'); ?></li>

			<?php
				foreach((array)$this->item->categories as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="categories" name="jform[categorieshidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<li><?php echo $this->form->getLabel('subcategories'); ?>
				<?php echo $this->form->getInput('subcategories'); ?></li>

			<?php
				foreach((array)$this->item->subcategories as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="subcategories" name="jform[subcategorieshidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<li><?php echo $this->form->getLabel('warnings'); ?>
				<?php echo $this->form->getInput('warnings'); ?></li>
				<li><?php echo $this->form->getLabel('rating'); ?>
				<?php echo $this->form->getInput('rating'); ?></li>

			<?php
				foreach((array)$this->item->rating as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="rating" name="jform[ratinghidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<li><?php echo $this->form->getLabel('chaptertitle'); ?>
				<?php echo $this->form->getInput('chaptertitle'); ?></li>
				<li><?php echo $this->form->getLabel('chapternotes'); ?>
				<?php echo $this->form->getInput('chapternotes'); ?></li>
				<li><?php echo $this->form->getLabel('storytext'); ?>
				<?php echo $this->form->getInput('storytext'); ?></li>
				<li><?php echo $this->form->getLabel('endnotes'); ?>
				<?php echo $this->form->getInput('endnotes'); ?></li>


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