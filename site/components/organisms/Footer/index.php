<footer class="site-footer">
  <div class="container footer-inner">
    <div class="footer-brand">
      <strong><?= site()->title()->html() ?></strong>
      <p><?= site()->site_description()->or('ModernĂ­ web na Kirby CMS')->html() ?></p>
    </div>
    <div class="footer-links">
      <?php snippet('molecules/Nav') ?>
    </div>
    <div class="footer-bottom">
      <p>&copy; <?= date('Y') ?> <?= site()->title()->html() ?>. VĹˇechna prĂˇva vyhrazena.</p>
    </div>
  </div>
</footer>
