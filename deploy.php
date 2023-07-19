<?php

/** create a file the deploy */

namespace Deployer;

require 'recipe/common.php';

const APP = 'CRUD-CLIENTES';
const NUMBER_RELEASE = 1;
const REPOSITORY = 'git@github.com:HandersonSilva/crud-clientes.git';
const AMBIENTE = 'production';
const IMAGE_NAME = 'crud-clientes';

inventory('deployment/hosts.yml');

set('application', APP);
set('repository', REPOSITORY);
set('keep_releases', NUMBER_RELEASE);
set('default_timeout', 1200);

//get version for git
task('get-version', function () {
    $version = run('cd {{release_path}} && git rev-parse --short HEAD');
    run('echo ' . $version);
    return $version;
})->desc('Get version');

task('docker-build', function () {
    $version = run('cd {{release_path}} && git rev-parse --short HEAD');
    run('cd {{release_path}} && docker build -t handersonsilva/' . IMAGE_NAME . ':' . $version . ' -f ' . AMBIENTE . '.dockerfile .');
})->desc('Build image');

task('docker-push', function () {
    $version = run('cd {{release_path}} && git rev-parse --short HEAD');
    run('docker push handersonsilva/' . IMAGE_NAME . ':' . $version);
})->desc('Push image');

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'get-version',
    'docker-build',
    'docker-push',
    'deploy:shared',
    'deploy:writable',
    'deploy:symlink',
    'cleanup'
])->desc('Deploy project');

after('deploy:failed', 'deploy:unlock');