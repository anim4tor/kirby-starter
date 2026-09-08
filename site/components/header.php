<header class="site-header">
  <div class="container header-inner">
    <a href="<?= $site->url() ?>" class="site-logo">
      <?= $site->title()->html() ?>
      <span class="badge">Starter</span>
    </a>
    <nav class="site-nav">
      <?php foreach ($site->children()->listed() as $item): ?>
        <a href="<?= $item->url() ?>" class="<?= $item->isOpen() ? 'is-active' : '' ?>">
          <?= $item->title()->html() ?>
        </a>
      <?php endforeach ?>
    </nav>
  </div>
</header>
