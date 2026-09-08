<ul class="block-list">
  <?php foreach ($block->items()->toStructure() as $item): ?>
    <li><?= $item->text()->html() ?></li>
  <?php endforeach ?>
</ul>
