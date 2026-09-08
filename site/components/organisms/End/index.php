<!-- Vendor js -->

<!-- The cookie elements --> 
<!-- <script type="module" src="/assets/js/cookieconsent-config.js"></script> -->

<!-- Global js -->
<?php 
$assetVersion = function($path) {
	$fullPath = kirby()->root('index') . '/' . ltrim($path, '/');
	return file_exists($fullPath) ? $path . '?v=' . filemtime($fullPath) : $path;
};
?>
<?= js($assetVersion('public/assets/js/app.dist.js')); ?>

<!-- Local js -->
<?php 
$templateJs = 'site/components/templates/' . ucwords($page->intendedTemplate()) . '/index.js';
if (file_exists(kirby()->root('index') . '/' . $templateJs)) : ?>
	<?= js($assetVersion($templateJs)) ?>
<?php endif ?>

<?php if (kirby()->option('debug')): ?>
	<script async src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
	<?= js('public/assets/js/idiomorph.min.js') ?>
	<script>
	(function() {
		function initMorphWatcher() {
			if (!window.___browserSync___ || !window.___browserSync___.socket) {
				setTimeout(initMorphWatcher, 150);
				return;
			}
			window.___browserSync___.socket.on('php:morph', async () => {
				try {
					const scrollY = window.SCROLL?.engine?.scroll ?? window.scrollY;
					const res = await fetch(window.location.href, {
						headers: { 'X-Requested-With': 'XMLHttpRequest' },
						cache: 'no-store'
					});
					const html = await res.text();
					const parser = new DOMParser();
					const newDoc = parser.parseFromString(html, 'text/html');

					if (window.Idiomorph && newDoc.body) {
						Idiomorph.morph(document.body, newDoc.body, {
							morphStyle: 'innerHTML',
							ignoreActiveValue: true,
							callbacks: {
								beforeNodeRemoved: function(node) {
									if (node.tagName === 'SCRIPT' || node.matches?.('[data-loader]')) return false;
								}
							}
						});

						if (typeof init === 'function') {
							await init();
						}

						if (window.SCROLL && typeof window.SCROLL.scrollTo === 'function') {
							window.SCROLL.scrollTo(scrollY, { immediate: true });
						} else {
							window.scrollTo({ top: scrollY, behavior: 'instant' });
						}
					} else {
						window.location.reload();
					}
				} catch (e) {
					console.warn('[Live Morph Error] Falling back to reload', e);
					window.location.reload();
				}
			});
		}
		initMorphWatcher();
	})();
	</script>
<?php endif ?>