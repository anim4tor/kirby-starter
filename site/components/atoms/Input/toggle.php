<?php
	$name ??= null;
	$id ??= null;
	$label ??= null;
	$value ??= $label;
	$submit ??= false;
	$checked ??= false;
?>
<div class="field" data-checkbox>
	<label for="<?= $id ?>">
		<input type="checkbox" id="<?= $id ?>" name="<?= $name ?>" value="<?= $value ?>" <?= e($checked, 'checked') ?> <?= e($submit, 'submit='.$submit) ?>/>
		<div class="button bg__invert/10" checkbox><span><?= $label ?></span></div>
	</label>
</div>