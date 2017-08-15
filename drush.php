#!/usr/bin/env php
<?php

/**
 * @file
 * drush is a PHP script implementing a command line shell for Drupal.
 *
 * @requires PHP CLI 5.4.5, or newer.
 */

require __DIR__ . '/includes/preflight.inc';
require '/vagrant/repos/3d_debugger/vendor/marcelovani/xhprof/includes/xhprof_start.php';
drush_main();
require '/vagrant/repos/3d_debugger/vendor/marcelovani/xhprof/includes/xhprof_end.php';
exit;
