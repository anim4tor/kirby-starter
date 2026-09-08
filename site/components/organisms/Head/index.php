<head>

	<?= $site->seoheadscripts() ?>

	<script>
      document.documentElement.className = 'js';
    </script>
	 
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<?php 
	$assetVersion = function($path) {
		$fullPath = kirby()->root('index') . '/' . ltrim($path, '/');
		return file_exists($fullPath) ? $path . '?v=' . filemtime($fullPath) : $path;
	};
	?>

	<?php snippet('meta') ?>
	<?= css($assetVersion('public/assets/css/theme.dist.css')) ?>
	<?= css($assetVersion('public/assets/css/theme-tokens.css')) ?>
	<?= css($assetVersion('public/assets/css/app.dist.css')) ?>
	<!-- <?= css('public/assets/css/cookieconsent.css') ?> -->
	
	<?= snippet('atoms/favicon') ?>

</head>

	

	
			

			

			
			