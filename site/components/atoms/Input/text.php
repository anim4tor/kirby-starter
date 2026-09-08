<?php
	$name ??= null;
	$id ??= null;
	$placeholder ??= null;
	$value ??= null;
	$bind ??= null;
	$update ??= null;
?>
<div class="field">
	<input type="text" id="<?= $id ?>" name="<?= $name ?>" placeholder="<?= $placeholder ?>" value="<?= $value ?>" <?= $bind ? "data-bind=". $bind : null ?> <?= $update ? "data-update=". $update : null ?>>
</div>