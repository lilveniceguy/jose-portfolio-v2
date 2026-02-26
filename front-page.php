<?php if (!defined('ABSPATH')) { exit; } ?>
<?php get_header(); ?>

<?php get_template_part('template-parts/sections/marquee-top'); ?>
<?php get_template_part('template-parts/sections/marquee-bottom'); ?>
<?php get_template_part('template-parts/sections/nav-desktop'); ?>
<?php get_template_part('template-parts/sections/nav-mobile'); ?>

<main class="relative z-10 pt-16 pb-16">
  <?php get_template_part('template-parts/sections/hero'); ?>
  <?php get_template_part('template-parts/sections/philosophy'); ?>
  <?php get_template_part('template-parts/sections/experience'); ?>
  <?php get_template_part('template-parts/sections/credentials'); ?>
  <?php get_template_part('template-parts/sections/scale'); ?>
  <?php get_template_part('template-parts/sections/creative'); ?>
  <?php get_template_part('template-parts/sections/labs'); ?>
  <?php get_template_part('template-parts/sections/signal'); ?>
</main>

<?php get_template_part('template-parts/panels/skill'); ?>
<?php get_template_part('template-parts/panels/system'); ?>

<?php get_footer(); ?>