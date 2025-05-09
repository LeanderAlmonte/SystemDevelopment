<?php
function lang($key) {
    $lang = $_SESSION['lang'] ?? 'en';
    $langFile = __DIR__ . '/' . $lang . '.php';
    if (!file_exists($langFile)) {
        $langFile = __DIR__ . '/en.php';
    }
    $translations = require $langFile;
    return $translations[$key] ?? $key;
} 