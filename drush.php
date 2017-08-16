#!/usr/bin/env php
<?php

/**
 * @file
 * drush is a PHP script implementing a command line shell for Drupal.
 *
 * @requires PHP CLI 5.4.5, or newer.
 */

/**
 * Helper to try some cache locations.
 *
 * @return string
 * @throws Exception
 */
function drush_get_cache_directory() {
  $tmp_dirs = array(
    '/dev/shm',
    '/tmp'
  );
  foreach ($tmp_dirs as $key => $dir) {
    if (file_exists($dir)) {
      return $dir . '/drush_files';
      break;
    }
  }

  throw new \Exception("Cache cannot write on /tmp");
}

/**
 * Write values to cache.
 *
 * @param $cid
 * @param $default
 */
function drush_write_cache($cid, $value) {

  $cache_directory = drush_get_cache_directory();

  if (!file_exists($cache_directory)) {
    mkdir($cache_directory);
  }

  $cache_file = $cache_directory . '/' . $cid;

  file_put_contents($cache_file, serialize($value));

  dlm('Wrote on cache ' . $cache_file);
}

/**
 * Loads values from cache.
 *
 * @param $cid
 */
function drush_get_from_cache($cid) {
  static $static_cache;
  if (isset($static_cache[__FUNCTION__ . $cid])) {
    return $static_cache[__FUNCTION__ . $cid];
  }

  $value = NULL;

  $cache_file = drush_get_cache_directory() . '/' . $cid;

  if (file_exists($cache_file)) {
    $content = file_get_contents($cache_file);
    $unserialized = unserialize($content);
    if (is_array($unserialized)) {
      $value = $unserialized;
    }
  }

  if (!is_null($value)) {
    dlm('Read from cache ' . $cache_file);
  }
  else {
    dlm('Cache empty ' . $cache_file);
  }

  $static_cache[__FUNCTION__ . $cid] = $value;
  return $value;
}

require __DIR__ . '/includes/preflight.inc';
require '/vagrant/repos/3d_debugger/vendor/marcelovani/xhprof/includes/xhprof_start.php';
drush_main();
require '/vagrant/repos/3d_debugger/vendor/marcelovani/xhprof/includes/xhprof_end.php';
exit;

