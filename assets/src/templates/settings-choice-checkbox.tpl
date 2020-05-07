{#choices}
<div class="radio choice">
	
	<label>
		<input type="checkbox" name="choice" class="option" {#checked}checked{/checked}>&nbsp;
	</label>

	<input type="text" class="bind-control form-control" data-bind=".{bindingClass}" style="display: inline-block; width: 65%;" value="{title}" />&nbsp;
	
	<button class="button btn-success success1 add-choice">++</button>&nbsp;
	<button class="button btn-danger danger remove-choice" data-delete=".{bindingClass}">--</button>

</div>
{/choices}