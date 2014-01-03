<h2>Forms</h2>
<div id="lemombox-forms">
	<ul>
		<?php foreach( get_lbox_forms() as $form ): ?>
		<li>
			<h3><?php echo $form->form_title ?></h3>
		</li>
		<?php endforeach ?>
	</ul>
</div>

<div id="lemonbox-wrapper">
	<!-- <a class="form-action preview">Preview</a>
	<a class="form-action edit">Edit</a>
	<a class="form-action save">Save</a> -->
	<form>
		<ul class="lemonbox-fields edit">
			<li class="title">
				<h2>Scholarship Application</h2>
			</li>
			<li class="input">
				<label>Full Name</label>
				<input type="text" name="fields[full_name]" />
			</li>
			<li class="input birthdate">
				<label>Birthdate</label>
				<input type="text" name="fields[birthdate]" />
			</li>
			<li class="input">
				<label>College/University you currently attend</label>
				<input type="text" name="fields[college]" />
			</li>
			<li class="input email">
				<label>E-mail</label>
				<input type="text" name="fields[email]" />
			</li>
			<li class="input city">
				<label>City</label>
				<input type="text" name="fields[city]" />
			</li>
			<li class="dropdown state">
				<label>State</label>
				<select name="fields[state]"> 
					<option value="" selected="selected">Select a State</option> 
					<option value="AL">Alabama</option> 
					<option value="AK">Alaska</option> 
					<option value="AZ">Arizona</option> 
					<option value="AR">Arkansas</option> 
					<option value="CA">California</option> 
					<option value="CO">Colorado</option> 
					<option value="CT">Connecticut</option> 
					<option value="DE">Delaware</option> 
					<option value="DC">District Of Columbia</option> 
					<option value="FL">Florida</option> 
					<option value="GA">Georgia</option> 
					<option value="HI">Hawaii</option> 
					<option value="ID">Idaho</option> 
					<option value="IL">Illinois</option> 
					<option value="IN">Indiana</option> 
					<option value="IA">Iowa</option> 
					<option value="KS">Kansas</option> 
					<option value="KY">Kentucky</option> 
					<option value="LA">Louisiana</option> 
					<option value="ME">Maine</option> 
					<option value="MD">Maryland</option> 
					<option value="MA">Massachusetts</option> 
					<option value="MI">Michigan</option> 
					<option value="MN">Minnesota</option> 
					<option value="MS">Mississippi</option> 
					<option value="MO">Missouri</option> 
					<option value="MT">Montana</option> 
					<option value="NE">Nebraska</option> 
					<option value="NV">Nevada</option> 
					<option value="NH">New Hampshire</option> 
					<option value="NJ">New Jersey</option> 
					<option value="NM">New Mexico</option> 
					<option value="NY">New York</option> 
					<option value="NC">North Carolina</option> 
					<option value="ND">North Dakota</option> 
					<option value="OH">Ohio</option> 
					<option value="OK">Oklahoma</option> 
					<option value="OR">Oregon</option> 
					<option value="PA">Pennsylvania</option> 
					<option value="RI">Rhode Island</option> 
					<option value="SC">South Carolina</option> 
					<option value="SD">South Dakota</option> 
					<option value="TN">Tennessee</option> 
					<option value="TX">Texas</option> 
					<option value="UT">Utah</option> 
					<option value="VT">Vermont</option> 
					<option value="VA">Virginia</option> 
					<option value="WA">Washington</option> 
					<option value="WV">West Virginia</option> 
					<option value="WI">Wisconsin</option> 
					<option value="WY">Wyoming</option>
				</select>
			</li>
			<li class="input zip">
				<label>Zip</label>
				<input type="text" name="fields[zip]" />
			</li>
			<li class="textarea">
				<label>Why did you choose your major and what do you plan to do with your degree?</label>
				<textarea name="fields[education_bio]"></textarea>
			</li>
			<li>
				<button type="submit">Submit</button>
			</li>
		</ul>
	</form>

	<div id="field-inspector">
		<ul>
			<li>Type: <span class="type"></span></li>
			<li>Placeholder Text: <span class="placeholder" contenteditable="true"></span></li>
			<li>
				<a class="field-action delete">Delete Field</a>
			</li>
		</ul>
	</div>
</div>