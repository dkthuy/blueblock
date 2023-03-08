<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:dkthuy/blueblock.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('157.230.36.85')
    ->set('remote_user', 'root')
    ->set('identity_file', '~/.ssh/id_rsa')
    ->set('deploy_path', '/var/www/blueblock');

// Hooks

after('deploy:failed', 'deploy:unlock');
