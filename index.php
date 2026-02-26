<?php if (!defined('ABSPATH')) { exit; } ?>
<?php get_header(); ?>
<main class="relative z-10 pt-24 pb-24 px-6 lg:px-24">
  <div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-foreground"><?php echo esc_html(get_bloginfo('name')); ?></h1>
    <p class="mt-4 text-muted-foreground">Theme is installed. Set a static front page to use the full layout.</p>
  </div>
</main>
<?php get_footer(); ?>