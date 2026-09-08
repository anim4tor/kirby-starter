<?php
    // Parameter Sanitizations & Fallbacks
    $text            = (!isset($text) || trim($text) === '') ? false : $text;
    $level           = (!isset($level) || trim($level) === '') ? 'h2' : $level;
    $css             = (!isset($css) || trim($css) === '') ? '' : $css;
    $node             = (!isset($node) || trim($node) === '') ? '' : $node;

    // Animation Properties Sanitizations
    $reveal       = (isset($reveal) && ($reveal === 'true' || $reveal === true)) ? true : false;
    $revealDirection = (!isset($revealDirection) || $revealDirection === false || trim($revealDirection) === '') ? false : $revealDirection;

    // Ensure only valid semantic tag elements leak into execution
    $allowedLevels   = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
    $tag             = in_array($level, $allowedLevels) ? $level : 'h2';
?>

<?php if ($text) : ?>
	<<?= $tag ?> 
		<?= $reveal ? 'data-scroll data-reveal-text' : '' ?>
		class="<?= esc($css) ?>"
        <?= $node ?>

	>
		<?= $text ?>
	</<?= $tag ?>>
<?php endif ?>