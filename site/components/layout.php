<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page->title()->html() ?> | <?= $site->title()->html() ?></title>
  <?= css('public/assets/css/main.css') ?>
</head>
<body>
  <?php snippet('header') ?>

  <main class="site-main">
    <div class="container">
      <?= $slots->default() ?>
    </div>
  </main>

  <?php snippet('footer') ?>

  <?php snippet('organisms/BranchSwitcher') ?>

  <?= js('public/assets/js/main.js') ?>
</body>
</html>
