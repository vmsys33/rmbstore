<?php
// Simple test file to check if PHP is working
echo "PHP is working!<br>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Current Directory: " . __DIR__ . "<br>";

// Check if CodeIgniter files exist
$files_to_check = [
    'app/Config/App.php',
    'app/Config/Database.php',
    'index.php',
    '.env'
];

echo "<h3>File Check:</h3>";
foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        echo "✅ $file exists<br>";
    } else {
        echo "❌ $file missing<br>";
    }
}

// Check PHP extensions
echo "<h3>PHP Extensions:</h3>";
$required_extensions = ['mysqli', 'json', 'mbstring'];
foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ $ext loaded<br>";
    } else {
        echo "❌ $ext not loaded<br>";
    }
}

// Check directory permissions
echo "<h3>Directory Permissions:</h3>";
$dirs_to_check = ['app', 'public', 'writable'];
foreach ($dirs_to_check as $dir) {
    if (is_dir($dir)) {
        echo "✅ $dir directory exists<br>";
        if (is_readable($dir)) {
            echo "✅ $dir is readable<br>";
        } else {
            echo "❌ $dir is not readable<br>";
        }
    } else {
        echo "❌ $dir directory missing<br>";
    }
}
?>








