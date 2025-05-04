<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/rsync.php';
// Project name
set('application', 'my_project');

// Project repository
set('repository', getenv('GIT_REPO'));

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

//https://github.com/deployphp/deployer/issues/2908
set('git_ssh_command', 'ssh');
set('composer_options', get('composer_options') . ' --ignore-platform-req=ext-sodium');

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', ['public/sitemaps']);

// Writable dirs by web server
add('writable_dirs', []);

set('allow_anonymous_stats', false);

//TODO: check here https://github.com/deployphp/deployer/issues/2998
set('sub_directory', '');

set('rsync_src', __DIR__);
// Hosts

host(getenv('SSH_IP'))
    ->set('deploy_path', getenv('DEPLOY_PATH'))
    ->set('remote_user', getenv('REMOTE_USER'));

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

after('deploy:update_code', 'rsync');
// Refresh database before symlink new release.
if (getenv('CI_COMMIT_BRANCH') != 'main') {
//    before('deploy:symlink', 'artisan:migrate:fresh');
//    after('artisan:migrate:fresh', 'artisan:db:seed');
//    after('artisan:db:seed', 'artisan:optimize:clear');
}
