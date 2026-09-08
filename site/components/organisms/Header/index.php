<header class="site-header">
  <div class="container header-inner">
    <a href="<?= site()->url() ?>" class="site-logo">
      <span><?= site()->title()->html() ?></span>
      <?php snippet('atoms/Badge', ['label' => 'Starter', 'style' => 'primary']) ?>
    </a>
    <?php snippet('molecules/Nav') ?>
  </div>
</header>
