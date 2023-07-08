<?php

/** create a file the deploy */

namespace Deployer;

require 'recipe/common.php';

const APP = 'CRUD-CLIENTES';
const REPOSITORY = 'git@github.com:HandersonSilva/crud-clientes.git';
const AMBIENTE = 'production';
const IMAGE_NAME = 'crud-clientes';

inventory('deployment/hosts.yml');

set('application', APP);

set('repository', REPOSITORY);
set('default_timeout', 1200);

//get version for git
task('get-version', function () {
    $version = run('cd {{release_path}} && git describe --tag');
    $version = explode('-', $version);
    $version = $version[0];
    run('echo ' . $version);
    return $version;
})->desc('Get version');

task('docker-build', function () {
    $version = run('cd {{release_path}} && git describe --tag');
    $version = explode('-', $version);
    $version = $version[0];
    run('cd {{release_path}} && docker build -t handersonsilva/' . IMAGE_NAME . ':' . $version . ' -f ' . AMBIENTE . '.dockerfile .');
})->desc('Build image');

task('docker-push', function () {
    $version = run('cd {{release_path}} && git describe --tag');
    $version = explode('-', $version);
    $version = $version[0];
    run('docker push handersonsilva/' . IMAGE_NAME . ':' . $version);
})->desc('Push image');

//UPDATE VARIABLES KUBERNET
//task('update-variables', function () use ($version) {
//    run("echo -e 'deployment:\n  hostname:''\n  stage:' main'  \n  deploy_path:' ${{ secrets.DEPLOYER_PATH }}'\n  user:' ${{ secrets.TARGET_USER }} >> values.yaml");
//})->desc('Update variables');

// Install yq
//task('install-yq', function () {
//    run('sudo wget https://github.com/mikefarah/yq/releases/download/v4.12.0/yq_darwin_arm64 -O /usr/bin/yq && chmod +x /usr/bin/yq');
//    run('yq --version');
//})->desc('Install yq');


task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'get-version',
    'docker-build',
    'docker-push',
//    'install-yq',
    'deploy:shared',
    'deploy:writable',
    'deploy:symlink',
    'cleanup'
])->desc('Deploy project');

after('deploy:failed', 'deploy:unlock');