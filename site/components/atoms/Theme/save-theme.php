<?php

// Securely grab the post value using Kirby's helper wrapper
$cssContent = get('css_tokens');

if (!empty($cssContent)) {
    // Locate your static theme asset destination file
    // Using $kirby->root('index') keeps paths aligned with public resources
    $targetFile = $kirby->root('index') . '/public/assets/css/theme-tokens.css';
    
    $targetDirectory = dirname($targetFile);
    if (!file_exists($targetDirectory)) {
        // Build the target directory framework safely if it does not exist
        mkdir($targetDirectory, 0755, true);
    }
    
    // Write your generated CSS payload to disk
    file_put_contents($targetFile, $cssContent);
}