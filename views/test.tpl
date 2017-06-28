<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="./form.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script type="text/javascript">
$(function() {
	$('[data-toggle="tooltip"]').tooltip()
});
</script>

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
		{form_row form=$form.firstName help="abcd here is some help text." input_icon=['fa fa-user', 'tooltip' => 'Enter your name', 'position' => 'left']}
		{form_row form=$form.email help="abcd here is some help text." input_icon=['fa fa-envelope']}

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

	<div class="row">
		<h2>Form 2</h2>
		{form_start form=$form2}
		{form_row form=$form2.firstName form_label_class="col-sm-6" form_group_class="col-sm-6"}
		{form_row form=$form2.lastName}
		{form_rest form=$form2 form_label_class="col-sm-4" form_group_class="col-sm-8"}

		{form_end form=$form2}
	</div>

	<div class="row">
		<h2>Form 3</h2>
		{form_start form=$form3}
		{form_widget form=$form3 form_label_class="col-sm-7" form_group_class="col-sm-5"}

		{form_end form=$form3}
	</div>
</div>

