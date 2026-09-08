<?php if ($image = $block->image()->toFile()): ?>
  <figure class="block-image">
    <img src="<?= $image->url() ?>" alt="<?= $block->alt()->or($image->alt())->html() ?>">
    <?php if ($block->caption()->isNotEmpty()): ?>
      <figcaption><?= $block->caption()->html() ?></figcaption>
    <?php endif ?>
  </figure>
<?php endif ?>
