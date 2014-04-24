<div id="lbox-form-field-picker" style="display: none;">
   <h3>Fields</h3>  
	<div id="add-fields">
		<button>Name
			<div class="form-group input name">
				<label>Name</label>
				<div class="row">
					<div class="col-md-6">
					    <input type="text" class="form-control" name="fields[first_name]" placeholder="First Name" class="required" />
					</div>
					<div class="col-md-6">
						<input type="text" class="form-control" name="fields[last_name]" placeholder="Last Name" class="required" />
					</div>
				</div>
			</div>
		</button>
		<button>Email
			<div class="form-group input email">
				<label>Email</label>
				<input type="email" name="fields[email]" class="form-control" />
			</div>
		</button>
		<button>Text Field
			<div class="form-group input">
				<label>Label</label>
				<input type="text" name="fields[new_field]" class="form-control" />
			</div>
		</button>
		<button>Money
			<div class="form-group input money" data-field-type="money">
				<label>Amount</label>
				<div class="input-group">
					<span class="input-group-addon">$</span>
					<input type="text" class="form-control" name="fields[amount]" />
				</div>
			</div>
		</button>
		<button>Title
			<div class="title">
				<label>Title</label>
			</div>
		</button>
		<button>Text Area
			<div class="input">
				<label>Label</label>
				<textarea name="fields[new_field]"></textarea>
			</div>
		</button>
		<button>Dropdown
			<div class="select dropdown">
				<label>Dropdown</label>
				<select name="fields[dropdown]">
					<option value=""></option>
				</select>
			</div>
		</button>
		<button>Date
			<div class="input date">
				<label>Date</label>
				<input type="text" name="fields[date]" />
			</div>
		</button>
		<button>Paragraph
			<div class="text">
				<p>A short message to share with the viewer</p>
			</div>
		</button>
		<button>
			State
			<div class="dropdown state">
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
			</div>
		</button>
	</div>
	<a onclick="javascript:tb_remove()">Close</a>
</div>