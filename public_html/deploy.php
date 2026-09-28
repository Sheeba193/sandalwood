<?php

set_time_limit(0);

chdir(__DIR__);

function run($command)
{
    echo "Running: $command\n";
    passthru($command . " 2>&1");
    echo "\n-------------------------\n";
}

run('composer install --no-dev --optimize-autoloader');
run('php artisan key:generate --force');
run('php artisan migrate:fresh --seed --force');
run('php artisan storage:link');
run('php artisan optimize');

// Delete this script after running once
//unlink(__FILE__);
