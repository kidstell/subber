<?php

chdir(__DIR__);

echo "\ninstalling... ";
// make sure composer is globally installed
$output = [];
$returnCode = 0;
exec('composer install', $output, $returnCode);
if ($returnCode !== 0) {
    echo "\nError: Composer install failed";
    printf("\n".implode("",$output));
    exit;
}
echo "Packages installed successfully";



echo "\ninstalling... ";
copy('.env.example', '.env');
$file = fopen('.env', 'r');
if( $file===false ) {
    echo "\nError: Failed to create .env file. You can manually create a copy of .env.example and rename it to .env, then rerun `php install.php`";
    exit;
}
echo ".env created successfully";



echo "\ninstalling... ";
$output = [];
$returnCode = 0;
exec('php artisan key:generate', $output, $returnCode);
if ($returnCode !== 0) {
    echo "\nError: Failed to generate APP_KEY for .env";
    printf("\n".implode("",$output));
    exit;
}
echo "APP_KEY generated successfully";



echo "\ninstalling... ";
$dbPath = __DIR__.DIRECTORY_SEPARATOR."database/database.sqlite";
$file = fopen($dbPath,'w');
if ($file === false) {
    echo "\nError: Failed to create SQLite database. You can create this file manually at {$dbPath}";
    exit;
}
echo "SQLite DB created successfully";



echo "\ninstalling... ";
$config = ['DB_CONNECTION' => 'sqlite', 'DB_DATABASE' => $dbPath, 'MAIL_HOST' => 'localhost', 'MAIL_PORT' => 1025];
$lines = file('.env');
$updates = 0;
foreach ($lines as $idx => $line) {
    foreach ($config as $key => $val) {
        if (strpos($line, "{$key}=") !== false) {
            $lines[$idx] = "{$key}={$val}".PHP_EOL;
            // unset($config[$key]);
            $updates++;
        }
        if (count($config) == $updates) break;
    }
}
$file = file_put_contents('.env', implode('',$lines));
if ($file === false) {
    echo "\nError: Failed to configure Database and Email server parameters in .env\nYou can do this manually in the .env file.\n".json_encode($config);
    exit;
}
echo "Database and Email server parameters configured successfully";



echo "\ninstalling... ";
$output = [];
$returnCode = 0;
exec('php artisan migrate --force', $output, $returnCode);
if ($returnCode !== 0) {
    echo "Error: database migration failed";
    printf("\n".implode("\n",$output));
    exit;
}
echo "Database migrated successfully";



echo "\ninstalling... ";
$output = [];
$returnCode = 0;
exec('php artisan db:seed', $output, $returnCode);
if ($returnCode !== 0) {
    echo "Error: Failed to seed the Database";
    printf("\n".implode("\n",$output));
    exit;
}
echo "Database seeded successfully";

echo "\ninstalling... Done.";

echo "\n\nEsure your email server is running. configure the email host/ip and port in the env file.\n\nNow run `php artisan queue:work` - this would manage background jobs.";
echo "\n\nWhen you want to push the feeds, simply run `php artisan feeder` - this would collate all pending feeds and send as email to the subscribers";


unlink(__FILE__);



