<?php 
$sectionsOrder = [];
$structure = $page->order()->toStructure();

if ($structure->isNotEmpty()) {
    // 1. If user sorted via Panel, pluck values normally
    foreach ($structure as $item) {
        if ($label = trim($item->label())) {
            $sectionsOrder[] = $label;
        }
    }
} else {
    // 2. FALLBACK: Read files directly from the local sections folder
    $templateName = ucfirst($page->intendedTemplate()->name());
    $localPath = kirby()->root('snippets') . '/templates/' . $templateName . '/sections';
    $localFiles = [];

    if (is_dir($localPath)) {
        $files = array_diff(scandir($localPath), ['.', '..', '.DS_Store', 'index.php']);
        
        foreach ($files as $file) {
            // EXCLUSION GUARD: Skip if it doesn't end in .php OR if it starts with an underscore
            if (!str_ends_with($file, '.php') || str_starts_with($file, '_')) {
                continue;
            }

            $name = substr($file, 0, -4);
            $parts = explode('_', $name, 2);
            $order = (isset($parts[1]) && is_numeric($parts[0])) ? (int)$parts[0] : 999;
            
            $localFiles[] = [
                'order' => $order,
                'value' => $name
            ];
        }
        // Sort files natively by their leading number (1_hero, 2_about...)
        usort($localFiles, fn($a, $b) => $a['order'] <=> $b['order']);
        $sectionsOrder = array_column($localFiles, 'value');
    }

    // 3. Append the global fallbacks to the trailing tail end
    $globalsPath = kirby()->root('snippets') . '/templates/globals';
    foreach (['Feed', 'Cta'] as $globalName) {
        if (is_dir($globalsPath)) {
            $subfolders = array_diff(scandir($globalsPath), ['.', '..', '.DS_Store']);
            foreach ($subfolders as $sub) {
                // Also ignore global directories starting with an underscore
                if (str_starts_with($sub, '_')) continue;

                $cleanSub = preg_replace('/^\d+_(.*)$/', '$1', $sub);
                if (strtolower($cleanSub) === strtolower($globalName) && file_exists($globalsPath . '/' . $sub . '/index.php')) {
                    $sectionsOrder[] = 'global/' . $sub . '/index';
                    break;
                }
            }
        }
    }
}
?>

<?php # 4. Render the output list ?>
<?php foreach ($sectionsOrder as $label) : ?>
    <?php 
    $isGlobal = str_starts_with($label, 'global/');
    $dir = $isGlobal ? 'templates/globals' : 'templates/' . ucfirst($page->intendedTemplate()->name()) . '/sections';
    $file = $isGlobal ? substr($label, 7) : $label;

    snippet($dir . '/' . $file);
    ?>
<?php endforeach ?>