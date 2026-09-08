<?php
    // Parameter Sanitizations & Fallbacks
    $text            = (!isset($text) || trim($text) === '') ? false : $text;
    $css             = (!isset($css) || trim($css) === '') ? '' : $css;
    $node             = (!isset($node) || trim($node) === '') ? '' : $node;

    // Animation Properties Sanitizations
    $reveal       = (isset($reveal) && ($reveal === 'true' || $reveal === true)) ? true : false;
    $revealDirection = (!isset($revealDirection) || $revealDirection === false || trim($revealDirection) === '') ? false : $revealDirection;
?>

<?php if ($text) : ?>
	<p 
		<?= $reveal ? 'data-scroll data-reveal-text="lines"' : '' ?>
		class="<?= esc($css) ?>" 
		<?= $node ?>
	>
		<?= $text ?>
	</p>
<?php endif ?>