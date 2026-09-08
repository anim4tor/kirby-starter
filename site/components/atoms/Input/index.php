<?php
$name        = $name        ?? '';
$type        = $type        ?? 'text';
$label       = $label       ?? false;
$placeholder = $placeholder ?? '';
$required    = (!empty($required) && $required) ? 'required' : '';
$value       = $value       ?? '';
?>
<div class="form-group">
  <?php if ($label): ?>
    <label for="<?= $name ?>" class="form-label"><?= html($label) ?></label>
  <?php endif ?>
  <?php if ($type === 'textarea'): ?>
    <textarea id="<?= $name ?>" name="<?= $name ?>" placeholder="<?= html($placeholder) ?>" <?= $required ?> class="form-control"><?= html($value) ?></textarea>
  <?php else: ?>
    <input type="<?= $type ?>" id="<?= $name ?>" name="<?= $name ?>" value="<?= html($value) ?>" placeholder="<?= html($placeholder) ?>" <?= $required ?> class="form-control">
  <?php endif ?>
</div>
