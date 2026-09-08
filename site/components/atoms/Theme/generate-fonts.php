<?php
function generateThemeFonts() {
    $currentDir = __DIR__;
    $fontsDir = realpath($currentDir . '/../../../assets/fonts') ?: realpath($currentDir . '/../../../../public/assets/fonts');
    $outputFile = $currentDir . '/_fonts.scss';

    $googleFonts = [
        'Inter' => 'https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap',
        'Roboto' => 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap'
    ]; 

    $formatMap = ['woff2' => 'woff2', 'woff' => 'woff', 'ttf' => 'truetype', 'otf' => 'opentype'];
    $scssOutput = "/* AUTOMATICALLY GENERATED - DO NOT EDIT */\n\n";

    foreach ($googleFonts as $name => $url) {
        $scssOutput .= "@import url('" . $url . "');\n";
    }
    $scssOutput .= "\n";

    $discoveredFamilies = array_keys($googleFonts);

    if ($fontsDir && is_dir($fontsDir)) {
        $files = array_diff(scandir($fontsDir), array('.', '..'));
        $scssOutputVariants = [];

        foreach ($files as $file) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (array_key_exists($ext, $formatMap)) {
                $baseName = pathinfo($file, PATHINFO_FILENAME);
                $scssOutputVariants[$baseName][] = "url('../fonts/" . $file . "') format('" . $formatMap[$ext] . "')";
            }
        }

        foreach ($scssOutputVariants as $baseName => $srcLines) {
            $familyName = explode('-', $baseName)[0];
            $familyName = explode('_', $familyName)[0];
            if ($familyName && !in_array($familyName, $discoveredFamilies)) {
                $discoveredFamilies[] = $familyName;
            }
            $lowerBase = strtolower($baseName);
            
            $isVariable = (strpos($lowerBase, 'variable') !== false);
            $weight = $isVariable ? '100 900' : 'normal';

            if (!$isVariable) {
                if (strpos($lowerBase, 'light') !== false || strpos($lowerBase, '300') !== false) $weight = '300';
                elseif (strpos($lowerBase, 'medium') !== false || strpos($lowerBase, '500') !== false) $weight = '500';
                elseif (strpos($lowerBase, 'bold') !== false || strpos($lowerBase, '700') !== false) $weight = '700';
                elseif (strpos($lowerBase, 'thin') !== false || strpos($lowerBase, '100') !== false) $weight = '100';
            }

            $scssOutput .= "@font-face {\n";
            $scssOutput .= "    font-family: '" . $familyName . "';\n";
            $scssOutput .= "    src: " . implode(",\n         ", $srcLines) . ";\n";
            $scssOutput .= "    font-weight: " . $weight . ";\n";
            $scssOutput .= "    font-style: normal;\n";
            $scssOutput .= "    font-display: swap;\n";
            $scssOutput .= "}\n\n";
        }

        file_put_contents($outputFile, $scssOutput);
    }
    sort($discoveredFamilies);
    return $discoveredFamilies;
}

if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'] ?? '')) {
    $fonts = generateThemeFonts();
    header('Content-Type: application/json');
    echo json_encode(["status" => "success", "message" => "Updated _fonts.scss", "fonts" => $fonts]);
    exit;
}