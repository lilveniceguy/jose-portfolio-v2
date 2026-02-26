<?php
if (!defined('ABSPATH')) { exit; }
require_once get_template_directory() . '/inc/config.php';
require_once get_template_directory() . '/inc/enqueue.php';

//philosophy cards are a bit nested so we need to parse the blocks to get them out
function jose_collect_blocks_recursive($blocks, $block_name) {
  $found = [];

  foreach ($blocks as $block) {
    if (!is_array($block)) continue;

    if (!empty($block['blockName']) && $block['blockName'] === $block_name) {
      $found[] = $block;
    }

    if (!empty($block['innerBlocks']) && is_array($block['innerBlocks'])) {
      $inner_found = jose_collect_blocks_recursive($block['innerBlocks'], $block_name);
      if (!empty($inner_found)) {
        $found = array_merge($found, $inner_found);
      }
    }
  }

  return $found;
}

function jose_get_philosophy_cards_from_page($page_slug = 'philosophy') {
  // Try to load the dedicated "philosophy" page by slug.
  // If it doesn't exist, fall back to the current post so the
  // cards can be stored directly on the front page (or any page
  // that includes the philosophy section template).
  $page = get_page_by_path($page_slug);
  if (!$page) {
    $page = get_post();
    if (!$page) return [];
  }

  $blocks = parse_blocks($page->post_content);

  // Find the first philosophy block (search recursively, it may be nested)
  $philosophy_blocks = jose_collect_blocks_recursive($blocks, 'jose-portfolio/philosophy');
  if (empty($philosophy_blocks)) return [];
  $philosophy_block = $philosophy_blocks[0];

  // Collect all principle-card blocks inside it
  $cards = [];
  if (!empty($philosophy_block['innerBlocks'])) {
    $cards = jose_collect_blocks_recursive($philosophy_block['innerBlocks'], 'jose-portfolio/principle-card');
  }

  // Convert blocks -> simple array for template usage
  $out = [];
  foreach ($cards as $card) {
    $attrs = isset($card['attrs']) && is_array($card['attrs']) ? $card['attrs'] : [];

    $out[] = [
      'icon'  => isset($attrs['icon']) ? (string) $attrs['icon'] : 'shield',
      'title' => isset($attrs['title']) ? (string) $attrs['title'] : '',
      'desc'  => isset($attrs['desc']) ? (string) $attrs['desc'] : '',
    ];
  }

  return $out;
}

function dd($data) {
  echo '<pre>';
  var_dump($data);
  echo '</pre>';
  die();
}