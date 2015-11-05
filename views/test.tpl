<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<div class="container">
	<div class="row">
		{if $isSubmitted}
			<h2>Form is submitted.</h2>
		{else}
			<h2 class="text-warning">Form not submitted.</h2>
		{/if}
		{if $isValid}
			<h2 class="text-success">Form is valid.</h2>
		{/if}

		{* novalidate turns off html5 validation, so symfony forms solely has to handle it *}
		{form_start form=$form attr=['novalidate' => 'novalidate']}
		{form_row form=$form.email help="abcd here is some help text."}

		Custom row...
		<div class="form-group">
			{form_label form=$form.my_long_temp_field}
			<div class="col-sm-10">
				{form_widget form=$form.my_long_temp_field}
			</div>
		</div>
		Custom row...
		<div class="form-group">
			{form_label form=$form.my_long_temp_field label="hi"}
			<div class="col-sm-10">
				{form_widget form=$form.my_long_temp_field}
			</div>
		</div>

		{form_widget form=$form}
		{form_end form=$form}
	</div>
</div>

