<div class="row">
	<div class="large-12 columns">
		<fieldset>
		<legend>{{ $field['name'] }}</legend>
			@foreach($field['listFields'] as $listField)
				<div class="row">
					<div class="large-12 columns">
						<input name="{{ $field['name'] }}[]" type="text" placeholder="{{ $listField }}" value="{{ $listField }}">
					</div>
				</div>
			@endforeach
		</fieldset>
	</div>
</div>