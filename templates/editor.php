<div id="lbox-form-field-menu">
   <h4>Form View</h4>
   <a class="thickbox" href="#TB_inline?width=500px&height=550&inlineId=lbox-form-field-picker">Add Field</a>
   <a id="clear-fields">Clear Form</a>
</div>

<div id="lbox-form-builder">
   <div id="lbox-fields">
      <?php echo get_post_meta( $post->ID, '_form_fields', true ); ?>
   </div>
   <div id="lbox-field-inspector">
      <ul>
         <li><a href="#field-settings">Field Settings</a></li>
      </ul>
      <div id="field-settings">
         <ul class="general-settings">
            <li>
               <label>Field Label</label>
               <input type="text" class="label" />
            </li>
            <li>
               <label>Field Name</label>
               <input type="text" class="field-name" />
               <small>The hidden field name sent when the form is submitted</small>
            </li>
            <li>
               <label>Placeholder Text</label>
               <input type="text" class="placeholder" />
            </li>
            <li>
               <label>Required?</label>
               <select class="required">
                  <option></option>
                  <option value="1">Yes</option>
                  <option value="0">No</option>
               </select>
            </li>
         </ul>
         <ul class="dropdown-settings" style="display: none;">
            <li>
               <label>Dropdown Options</label>
               <textarea placeholder="option:value" style="width: 100%;" rows="6" data-rel="dropdown"></textarea>
            </li>
            <li>
               <label>Dropdown Format</label>
               <select data-rel="format">
                  <option value="dropdown">Dropdown</option>
                  <option value="multiple">Multiple</option>
               </select>
            </li>
         </ul>
         <p><a class="field-action delete">Delete Field</a></p>
      </div>
      <?php do_action( 'lbox_form_settings' ); ?>
   </div>
</div>

<input id="lbox-form-html" name="_form_fields" type="hidden" value="" />

<?php include('fields.php'); ?>
 
   
   