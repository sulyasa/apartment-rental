<?php
/**
 * Deployment Script for 000webhost
 * 
 * Instructions:
 * 1. Create account on 000webhost.com
 * 2. Create new website with MySQL database
 * 3. Upload all files to public_html folder
 * 4. Import database from database.sql
 * 5. Update .env file with database credentials
 */

// Database configuration - UPDATE THESE VALUES
$db_host = 'localhost'; // Usually localhost
$db_name = 'your_database_name';
$db_user = 'your_database_user';
$db_pass = 'your_database_password';

echo "=== Apartment Rental Deployment ===\n\n";

// Check PHP version
echo "PHP Version: " . phpversion() . "\n";

// Check required extensions
$required = ['pdo', 'pdo_mysql', 'mbstring', 'curl', 'json', 'xml'];
foreach ($required as $ext) {
    $status = extension_loaded($ext) ? '✓' : '✗';
    echo "$status $ext\n";
}

echo "\n=== Deployment Complete ===\n";
echo "Next steps:\n";
echo "1. Configure database in .env\n";
echo "2. Run: php artisan migrate\n";
echo "3. Run: php artisan db:seed\n";
echo "4. Visit your website\n";