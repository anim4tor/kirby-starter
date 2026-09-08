<?php
$headline = $headline ?? ($page->headline()->value() ?: $page->title()->value());
$intro    = $intro    ?? ($page->intro()->value() ?: '');
$button   = $button   ?? false;
?>
<section class="hero-section">
  <div class="hero-content">
    <?php snippet('atoms/Heading', ['level' => 'h1', 'text' => $headline]) ?>
    <?php if (!empty($intro)): ?>
      <p class="hero-intro"><?= html($intro) ?></p>
    <?php endif ?>
    <?php if ($button): ?>
      <div class="hero-actions">
        <?php snippet('atoms/Button', $button) ?>
      </div>
    <?php endif ?>
  </div>
</section>
