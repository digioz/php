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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_stories', JPATH_ADMINISTRATOR);
?>

<!-- Styling for making front end forms look OK -->
<!-- This should probably be moved to the template CSS file -->
<style>
    .front-end-edit ul {
        padding: 0 !important;
    }
    .front-end-edit li {
        list-style: none;
        margin-bottom: 6px !important;
    }
    .front-end-edit label {
        margin-right: 10px;
        display: block;
        float: left;
        text-align: center;
        width: 200px !important;
    }
    .front-end-edit .radio label {
        float: none;
    }
    .front-end-edit .readonly {
        border: none !important;
        color: #666;
    }    
    .front-end-edit #editor-xtd-buttons {
        height: 50px;
        width: 600px;
        float: left;
    }
    .front-end-edit .toggle-editor {
        height: 50px;
        width: 120px;
        float: right;
    }

    #jform_rules-lbl{
        display:none;
    }

    #access-rules a:hover{
        background:#f5f5f5 url('../images/slider_minus.png') right  top no-repeat;
        color: #444;
    }

    fieldset.radio label{
        width: 50px !important;
    }
</style>
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
            js('#form-story').submit(function(event){
                 
            }); 
        
            js = jQuery.noConflict();
js(document).ready(function(){
	js('#jform_categories').change(function(){
		if(js('#jform_categories option:selected').length == 0){
		js("#jform_categories option[value=0]").attr('selected','selected');
		}
	});
});js = jQuery.noConflict();
js(document).ready(function(){
	js('#jform_subcategories').change(function(){
		if(js('#jform_subcategories option:selected').length == 0){
		js("#jform_subcategories option[value=0]").attr('selected','selected');
		}
	});
});
        });
    });
    
</script>

<div class="story-edit front-end-edit">
    <?php if (!empty($this->item->id)): ?>
        <h1>Edit <?php echo $this->item->id; ?></h1>
    <?php else: ?>
        <h1>Add</h1>
    <?php endif; ?>

    <form id="form-story" action="<?php echo JRoute::_('index.php?option=com_stories&task=story.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
        <ul>
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
				<?php $canState = false; ?>
					<?php $canState = $canState = JFactory::getUser()->authorise('core.edit.state','com_stories'); ?>				<?php if(!$canState): ?>
					<li><?php echo $this->form->getLabel('state'); ?>
					<?php
						$state_string = 'Unpublish';
						$state_value = 0;
						if($this->item->state == 1):
							$state_string = 'Publish';
							$state_value = 1;
						endif;
						echo $state_string; ?></li>
					<input type="hidden" name="jform[state]" value="<?php echo $state_value; ?>" />				<?php else: ?>					<li><?php echo $this->form->getLabel('state'); ?>
					<?php echo $this->form->getInput('state'); ?></li>
				<?php endif; ?>				<li><?php echo $this->form->getLabel('created_by'); ?>
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
			?>
			<script type="text/javascript">
				window.onload = function(){
					jQuery.noConflict();
					jQuery('input:hidden.categories').each(function(){
						var name = jQuery(this).attr('name');
						if(name.indexOf('categorieshidden')){
							jQuery('#jform_categories option[value="'+jQuery(this).val()+'"]').attr('selected',true);
						}
					});
				}
			</script>				<li><?php echo $this->form->getLabel('subcategories'); ?>
				<?php echo $this->form->getInput('subcategories'); ?></li>

			<?php
				foreach((array)$this->item->subcategories as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="subcategories" name="jform[subcategorieshidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>
			<script type="text/javascript">
				window.onload = function(){
					jQuery.noConflict();
					jQuery('input:hidden.subcategories').each(function(){
						var name = jQuery(this).attr('name');
						if(name.indexOf('subcategorieshidden')){
							jQuery('#jform_subcategories option[value="'+jQuery(this).val()+'"]').attr('selected',true);
						}
					});
				}
			</script>				<li><?php echo $this->form->getLabel('warnings'); ?>
				<?php echo $this->form->getInput('warnings'); ?></li>
				<li><?php echo $this->form->getLabel('rating'); ?>
				<?php echo $this->form->getInput('rating'); ?></li>

			<?php
				foreach((array)$this->item->rating as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="rating" name="jform[ratinghidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>
			<script type="text/javascript">
				window.onload = function(){
					jQuery.noConflict();
					jQuery('input:hidden.rating').each(function(){
						var name = jQuery(this).attr('name');
						if(name.indexOf('ratinghidden')){
							jQuery('#jform_rating option[value="'+jQuery(this).val()+'"]').attr('selected',true);
						}
					});
				}
			</script>				<li><?php echo $this->form->getLabel('chaptertitle'); ?>
				<?php echo $this->form->getInput('chaptertitle'); ?></li>
				<li><?php echo $this->form->getLabel('chapternotes'); ?>
				<?php echo $this->form->getInput('chapternotes'); ?></li>
				<li><?php echo $this->form->getLabel('storytext'); ?>
				<?php echo $this->form->getInput('storytext'); ?></li>
				<li><?php echo $this->form->getLabel('endnotes'); ?>
				<?php echo $this->form->getInput('endnotes'); ?></li>

        </ul>

        <div>
            <button type="submit" class="validate"><span><?php echo JText::_('JSUBMIT'); ?></span></button>
            <?php echo JText::_('or'); ?>
            <a href="<?php echo JRoute::_('index.php?option=com_stories&task=storyform.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>

            <input type="hidden" name="option" value="com_stories" />
            <input type="hidden" name="task" value="storyform.save" />
            <?php echo JHtml::_('form.token'); ?>
        </div>
    </form>
</div>
