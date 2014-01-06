<h2>Forms</h2>
<a class="form-action new-form" href="admin.php?page=lemonbox-forms&action=new">New Form</a>
<div id="lemombox-forms">
	<ul>
		<?php foreach( lbox_get_forms() as $form ): ?>
		<ul class="table">
			<ul>
				<li>Form</li>
				<li>Entries</li>
				<li>Author</li>
				<li>Date</li>
			</ul>
			<ul>
				<li><a href="admin.php?page=lemonbox-forms&action=edit&form_id=<?php echo $form->id ?>"><?php echo $form->form_title ?></a></li>
				<li><?php echo $form->entries ?></li>
				<li><?php echo $form->author ?></li>
				<li><?php echo $form->created_at ?></li>
			</ul>
		</div>
		<?php endforeach ?>
	</ul>
</div>