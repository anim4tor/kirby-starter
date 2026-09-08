<body page="<?= $page->id() ?>" theme="invert" >
    
    <?= site()->seobodyscripts() ?>

    <!-- The loader -->
    <?php snippet('organisms/Loader') ?>

    <!-- The aside --> 
    <?php snippet('organisms/Aside'); ?>
    
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
