<?php

/** create a file the deploy */

namespace Deployer;

require 'recipe/common.php';

const APP = 'CRUD-CLIENTES';
const REPOSITORY = 'git@github.com:HandersonSilva/crud-clientes.git';
const AMBIENTE = 'production';
const IMAGE_NAME = 'crud-clientes';
$version = '1.0.7';

inventory('deployment/hosts.yml');

set('application', APP);

set('repository', REPOSITORY);
set('default_timeout', 1200);

//get version for git
task('get-version', function () {
    $version = run('git describe --tags --abbrev=0');
    $version = str_replace('v', '', $version);
    $version = explode('.', $version);
    $version[2] = $version[2] + 1;
    $version = implode('.', $version);
    run('echo ' . $version);
    return $version;
})->desc('Get version');

task('docker-build', function () use ($version) {
    run('cd {{release_path}} && docker build -t handersonsilva/' . IMAGE_NAME . ':' . $version . ' -f ' . AMBIENTE . '.dockerfile .');
})->desc('Build image');

task('docker-push', function () use ($version){
    run('docker push handersonsilva/' . IMAGE_NAME . ':' . $version);
})->desc('Push image');

//install yq
task('install-yq', function () {
    run('sudo wget https://github.com/mikefarah/yq/releases/download/v4.12.0/yq_linux_amd64 -O /usr/bin/yq && chmod +x /usr/bin/yq');
    run('yq --version');
})->desc('Install yq');

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'install-yq',
    'docker-build',
    'docker-push',
    'deploy:shared',
    'deploy:writable',
    'deploy:symlink',
    'cleanup'
])->desc('Deploy project');

after('deploy:failed', 'deploy:unlock');