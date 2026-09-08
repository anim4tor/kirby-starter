<?php
	$name ??= null;
	$id ??= null;
	$label ??= null;
	$value ??= $label;
	$checked ??= false;
?>
<div class="absolute -bottom__02 superset -wrap-b__1 wrap-l__1 inner-l__07 inner-y__03 z__1" data-checkbox>
	<label for="<?= $id ?>">
		<input type="checkbox" id="<?= $id ?>" name="<?= $name ?>" submit="update_workout" value="<?= $value ?>" <?= e($checked, 'checked') ?>/>
		<div superset class="op__2">
			<icon><?= svg('public/assets/images/ui/ui_superset.svg') ?></icon>
		</div>
	</label>
</div>
