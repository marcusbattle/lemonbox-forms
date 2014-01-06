<?php 
	
	if ( isset($_GET['form_id']) ) {
		$form = lbox_get_form( $_GET['form_id'] );
		$form_id = $form->id;
	} else {
		$form_id = 0;
	}
?>

<div id="lemonbox-wrapper">
	<h2><?php echo ucwords($_GET['action']); ?> Form</h2>
	<h3 class="form-title">Form Title</h3>
	<form>
		<input type="hidden" name="mode" value="preview" />
		<?php if ( isset($_GET['form_id']) ): ?>
			<?php echo stripslashes($form->fields) ?>
		<?php else: ?>
			<ul class="lemonbox-fields edit">
				<li class="submit">
					<button type="submit">Submit</button>
					<input type="hidden" name="form_title" value="" />
				</li>
			</ul>
		<?php endif; ?>
	</form>

	<div id="form-inspector">

		<button class="form-action save-form" data-form-id="<?php echo $form_id ?>">Save Form</button>
		<ul id="form-menu">
			<li><a href="#add-fields">Add Fields</a></li>
			<li><a href="#field-settings">Field Settings</a></li>
			<li><a href="#form-settings">Form Settings</a></li>
		</ul>
		<div id="add-fields">
			<h3>Add Fields</h3>
			<h4>User</h4>
			<button>Name
				<li class="input name">
					<label>Name</label>
					<input type="text" name="fields[name]" />
				</li>
			</button>
			<button>Email
				<li class="input email">
					<label>Email</label>
					<input type="text" name="fields[email]" />
				</li>
			</button>
			<h4>General</h4>
			<button>Title
				<li class="title">
					<label>Title</label>
				</li>
			</button>
			<button>Text Field
				<li class="input">
					<label>Label</label>
					<input type="text" name="fields[new_field]" />
				</li>
			</button>
			<button>Text Area
				<li class="input">
					<label>Label</label>
					<textarea name="fields[new_field]"></textarea>
				</li>
			</button>
			<button>Date
				<li class="input date">
					<label>Date</label>
					<input type="text" name="fields[date]" />
				</li>
			</button>
			<button>
				State
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
			</button>
			<?php if ( is_plugin_active( 'lemonbox-shop/lemonbox-shop.php' ) ): ?>
			<button>Product
				<li class="product">
					<h2 class="product-title">Audition Ticket</h2>
					<input type="hidden" name="product_id" value="0" />
					<input type="hidden" name="price" value="10" />
					<div class="quantity">
						<label>Quantity</label>
						<select name="quantity">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
					</div>
					<div class="cost">
						<label>Cost</label> 
						<span class="callout">$10</span>
					</div>
					<div class="credit-card">
						<label>Credit Card</label>
						<input type="text" name="card_number" placeholder="•••• •••• •••• ••••" />
						<div class="flex">
							<input type="text" name="exp_month" maxlength="2" placeholder="Month (MM)" />
							<input type="text" name="exp_year" maxlength="4" placeholder="Year (YYYY)" />
							<input type="text" name="cvc" maxlength="3" placeholder="CVC" />
						</div>
					</div>
					<p>Here is all of the great security information!</p>
				</li>
			</button>
			<?php endif; ?>
		</div>
		<div id="field-settings">
			<h3>Field Settings</h3>
			<?php if ( is_plugin_active( 'lemonbox-shop/lemonbox-shop.php' ) ): ?>
			<ul class="product-settings">
				<li>
					<h4>Product</h4>
					<select class="product">
						<option value="0">Select Product</option>
						<?php foreach( lbox_get_products() as $product ): print_r( $product ); ?>
						<option value="<?php echo $product->ID ?>" data-price="<?php echo $product->price ?>"><?php echo $product->post_title ?></option>
						<?php endforeach; ?>
					</select>
				</li>
				<li>
					<h4>Max Quantity</h4>
					<input type="text" class="max-quantity" />
				</li>
			</ul>
			<?php endif; ?>
			<ul class="general-settings">
				<li>
					<h4>Field Label</h4>
					<input type="text" class="label" />
				</li>
				<li>
					<h4>Placeholder Text</h4>
					<input type="text" class="placeholder" />
				</li>
				<li>
					<h4>Field Name</h4>
					<input type="text" class="field-name" />
				</li>
				<li>
					<a class="field-action delete">Delete Field</a>
				</li>
			</ul>
		</div>
		<div id="form-settings">
			<h3>Form Settings</h3>
			<ul>
				<li>
					<h4>Form Name</h4>
					<input type="text" class="form-title" />
				</li>
			</ul>
		</div>
	</div>
</div>