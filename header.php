<?php if (!defined('ABSPATH')) { exit; } ?>
<!doctype html>
<html <?php language_attributes(); ?> class="dark">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#0F172A">
  <?php $description = "Senior full-stack engineer. Not just writing code — engineering systems that hold under pressure"; ?>
  <title><?php echo bloginfo('name'); ?>  | <?php echo $description; ?></title>
  <meta name="description" content="<?php echo $description; ?>">
  <?php
  $meta_keywords = '';
  if (is_singular() && ($tags = get_the_tags())) {
    $meta_keywords = implode(', ', wp_list_pluck($tags, 'name'));
  } else {
    $meta_keywords = 'full-stack engineer, web development, portfolio, PHP, JavaScript';
  }
  ?>
  <meta name="keywords" content="<?php echo esc_attr($meta_keywords); ?>">

  <?php wp_head(); ?>
</head>

<body <?php body_class('font-sans antialiased min-h-screen'); ?> x-data="portfolio()" x-init="init()">
<?php wp_body_open(); ?>

<!-- GRID BACKGROUND -->
<div class="fixed inset-0 pointer-events-none overflow-hidden z-0" x-data="grid()">
  <div
    class="absolute -inset-[10%] w-[120%] h-[120%] animate-grid-fade"
    :style="`background-image: linear-gradient(#334155 1px, transparent 1px), linear-gradient(90deg, #334155 1px, transparent 1px); background-size: 60px 60px; transform: translate(${mx}px, ${my - sy}px);`"
  ></div>
  <div
    class="absolute top-1/4 left-1/2 w-[800px] h-[800px] rounded-full opacity-[0.12]"
    :style="`background: radial-gradient(circle, #3B82F6 0%, transparent 70%); transform: translate(calc(-50% + ${mx*0.5}px), calc(-50% + ${my*0.5 - sy*0.3}px));`"
  ></div>
</div>