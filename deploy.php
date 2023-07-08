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

//UPDATE VARIABLES KUBERNET
//task('update-variables', function () use ($version) {
//    run("echo -e 'deployment:\n  hostname:''\n  stage:' main'  \n  deploy_path:' ${{ secrets.DEPLOYER_PATH }}'\n  user:' ${{ secrets.TARGET_USER }} >> values.yaml");
//})->desc('Update variables');


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