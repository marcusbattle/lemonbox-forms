<div id="lbox-form-field-menu">
   <a class="thickbox" href="#TB_inline?width=500px&height=550&inlineId=lbox-form-field-picker">Add Field</a>
   <a id="clear-fields">Clear Form</a>
</div>

<div id="lbox-form-field-picker" style="display: none;">
   <h3>Fields</h3>   
   <?php include('fields.php'); ?>
   <a onclick="javascript:tb_remove()">Close</a>
</div>

<div id="lbox-fields">
   <?php echo $post->post_content ?>
</div>
<div id="lbox-field-inspector"></div>

<input id="lbox-form-html" name="_form_fields" type="hidden" />