<?php

// All Deployer recipes are based on `recipe/common.php`.
require 'recipe/laravel.php';

server('intangibleproduction', 'www.propar.com.py', 22)
    ->user('intangibleproparluis')
    ->forwardAgent()
    ->stage(['production','all'])
    ->env('jail_path','/var/www/propar.com.py')
    ->env('deploy_path', '/var/www/propar.com.py/web');

server('intangiblealpha', 'alpha.propar.intangible.com.py', 22)
    ->user('intangiblealphaproparluis')
    ->forwardAgent()
    ->stage(['alpha','all'])
    ->env('jail_path','/var/www/alpha.propar.intangible.com.py')
    ->env('deploy_path', '/var/www/alpha.propar.intangible.com.py/web');

server('intangiblebeta', 'beta.propar.intangible.com.py', 22)
    ->user('intangiblebetaproparluis')
    ->forwardAgent()
    ->stage(['beta','all'])
    ->env('jail_path','/var/www/beta.propar.intangible.com.py')
    ->env('deploy_path', '/var/www/beta.propar.intangible.com.py/web');

set('keep_releases', 2);
set('repository', 'git@gitlab.intangible.com.py:EmilioBravo/propar-com-py.git');
set('shared_files', []);
set('shared_dirs', ['app/storage/views','app/storage/sessions','app/storage/logs','app/storage/cache', 'public/uploads']);
set('writable_dirs', ['app/storage','app/storage/views','app/storage/sessions','app/storage/logs','app/storage/cache','app/storage/meta/','public/uploads']);
set('writable_use_sudo', false);


task('deploy:upload-env-files',function(){
    $stage = env('stages');
    if($stage[0] == 'production'){
        $envfile = '.env.php';
    }else{
        $envfile = '.env.' . $stage[0] . '.php';
    }
    upload($envfile, '/web/release/' . $envfile);
})->desc('Uploading env files');

/**
 * Main task
 */
task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:upload-env-files',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'deploy:symlink',
    'cleanup',
])->desc('Deploy your project');
