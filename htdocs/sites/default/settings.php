<?php

// @codingStandardsIgnoreFile

$databases = [];

$settings["config_sync_directory"] = '../sync';

$settings['update_free_access'] = FALSE;

$settings['container_yamls'][] = $app_root . '/' . $site_path . '/services.yml';

$settings['file_scan_ignore_directories'] = [
  'node_modules',
  'bower_components',
];

$settings['entity_update_batch_size'] = 50;

$settings['entity_update_backup'] = TRUE;

if (file_exists($app_root . '/../settings/default/settings.lando.php')) {
  include $app_root . '/../settings/default/settings.lando.php';
}
