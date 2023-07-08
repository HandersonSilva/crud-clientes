<?php

/** create a file the deploy */

namespace Deployer;

require 'recipe/common.php';

const APP = 'CRUD-CLIENTES';
const REPOSITORY = 'git@github.com:switchsoftware/salao-levie.git';
const NUMBER_RELEASE = 2;
const AMBIENTE = 'production';
const IMAGE_NAME = 'crud-clientes';
const VERSION = '1.0.0';

inventory('deployment/hosts.yml');

set('application', APP);

set('repository', REPOSITORY);
set('default_timeout', 1200);

task('docker-build', function () {
    run('cd {{release_path}} && docker build -t handersonsilva/' . IMAGE_NAME . ':' . VERSION . ' -f ' . AMBIENTE . '.dockerfile .');
})->desc('Build image');

task('docker-push', function () {
    run('docker push handersonsilva/' . IMAGE_NAME . ':' . VERSION);
})->desc('Push image');

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'docker-build',
    'docker-push',
    'deploy:shared',
    'deploy:writable',
    'deploy:symlink',
    'cleanup'
])->desc('Deploy project');

after('deploy:failed', 'deploy:unlock');