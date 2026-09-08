<?php
    // Parameter Sanitizations & Fallbacks
    $img             = (!isset($img) || $img === '') ? null : $img;
    $url             = (!isset($url) || trim($url) === '') ? null : $url;
    $css             = (!isset($css) || trim($css) === '') ? '' : $css;
    $node            = (!isset($node) || trim($node) === '') ? '' : $node;
    $nodeTag         = (!isset($nodeTag) || trim($nodeTag) === '') ? 'figure' : $nodeTag;
    $nodeHref        = (!isset($nodeHref) || trim($nodeHref) === '') ? false : $nodeHref;

    // Performance & Loading Attributes
    $priority        = (isset($priority) && ($priority === true || $priority === 'true')) ? true : false;
    $loading         = isset($loading) ? $loading : ($priority ? 'eager' : 'lazy');
    $fetchpriority   = isset($fetchpriority) ? $fetchpriority : ($priority ? 'high' : null);
    $decoding        = isset($decoding) ? $decoding : 'async';

    // Animation Properties Sanitizations (Parallax strictly false by default)
    $parallax        = (!isset($parallax) || $parallax === false || $parallax === 'false' || trim((string)$parallax) === '') ? false : $parallax;
    $reveal          = (isset($reveal) && ($reveal === 'true' || $reveal === true)) ? true : false;
    $revealDirection = (!isset($revealDirection) || $revealDirection === false || trim($revealDirection) === '') ? false : $revealDirection;

    // Extract Alternative Text & Dimensions
    $altText    = 'Image';
    $widthAttr  = '';
    $heightAttr = '';

    if ($img && is_object($img)) {
        $altText = $img->alt()->isNotEmpty() ? $img->alt()->esc() : $img->filename();
        try {
            $dimensions = $img->dimensions();
            if ($dimensions && $dimensions->width() > 0 && $dimensions->height() > 0) {
                $widthAttr  = ' width="' . $dimensions->width() . '"';
                $heightAttr = ' height="' . $dimensions->height() . '"';
            }
        } catch (\Throwable $e) {}
    }
?>

<?php if ($nodeHref): ?>
    <a href="<?= $nodeHref ?>" class="figure__link" style="display: block; text-decoration: none; color: inherit;">
<?php endif ?>

	<figure 
		<?= ($reveal || $parallax !== false || str_contains((string)$node, 'data-reveal-image')) ? 'data-scroll' : '' ?>
		<?= $revealDirection !== false ? 'data-reveal-image="' . esc($revealDirection) . '"' : '' ?>
		<?= $parallax !== false ? 'data-scroll-progress data-parallax style="--speed: ' . esc($parallax) . '"' : '' ?>
		class="img__radius <?= esc($css) ?>"
		<?= esc($node) ?>
	>
		<?php if ($img && is_object($img)) : ?>
			<img class="<?= $priority ? 'is-loaded' : '' ?>" loading="<?= esc($loading) ?>" <?= $fetchpriority ? 'fetchpriority="' . esc($fetchpriority) . '" ' : '' ?>decoding="<?= esc($decoding) ?>" onload="this.classList.add('is-loaded')" src="<?= $img->url() ?>" alt="<?= $altText ?>"<?= $widthAttr ?><?= $heightAttr ?>>
		<?php elseif ($url): ?>
			<img class="<?= $priority ? 'is-loaded' : '' ?>" loading="<?= esc($loading) ?>" <?= $fetchpriority ? 'fetchpriority="' . esc($fetchpriority) . '" ' : '' ?>decoding="<?= esc($decoding) ?>" onload="this.classList.add('is-loaded')" src="<?= asset('public/assets/images/' . $url)->url() ?>" alt="<?= $altText ?>">
		<?php endif ?>
	</figure>

<?php if ($nodeHref): ?>
    </a>
<?php endif ?>