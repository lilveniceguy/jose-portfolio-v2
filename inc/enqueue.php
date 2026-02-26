<?php
if (!defined('ABSPATH')) { exit; }

add_action('wp_enqueue_scripts', function () {
  $dir = get_template_directory();
  $uri = get_template_directory_uri();

  $css = $dir . '/dist/tailwind.css';
  $app = $dir . '/dist/app.js';
  $alpine = $dir . '/dist/alpine.min.js';
  $lucide = $dir . '/dist/lucide.min.js';

  if (file_exists($css)) {
    wp_enqueue_style(
      'jose-portfoliov2-tailwind',
      $uri . '/dist/tailwind.css',
      [],
      filemtime($css)
    );
  }

  // App first (HEAD) so Alpine components are registered before Alpine boots
  if (file_exists($app)) {
    wp_enqueue_script(
      'jose-portfoliov2-app',
      $uri . '/dist/app.js',
      [],
      filemtime($app),
      false
    );
  }

  // Alpine in footer
  if (file_exists($alpine)) {
    wp_enqueue_script(
      'jose-portfoliov2-alpine',
      $uri . '/dist/alpine.min.js',
      [],
      filemtime($alpine),
      true
    );
  }

  // Lucide in footer (after Alpine is fine)
  if (file_exists($lucide)) {
    wp_enqueue_script(
      'jose-portfoliov2-lucide',
      $uri . '/dist/lucide.min.js',
      [],
      filemtime($lucide),
      true
    );
  }
});