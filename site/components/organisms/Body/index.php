<body page="<?= $page ?>" theme="invert" >
    
    <?= $site->seobodyscripts() ?>

    <!-- The loader -->
    <?php snippet('organisms/Loader') ?>

    <!-- The aside --> 
    <?php snippet('organisms/Aside'); ?>

    <!-- The contact widget --> 
    <?= snippet('organisms/Contact') ?>
    
    <!-- The theme widget --> 
    <?php snippet('atoms/Theme'); ?>
    
    <!-- Scroll container -->
    <main id="top" data-scroll-content>

      <!-- The header --> 
      <?php snippet('organisms/Header'); ?>

      <?php if ($main = $slots->main()): ?>
        <!-- The main --> 
        <?= $main ?>
      <?php endif ?>
      
      <!-- The footer --> 
      <?php snippet('organisms/Footer'); ?>

    </main>

    
</body>

