<!-- CREDENTIALS -->
<section id="credentials" class="min-h-screen py-32 px-6 lg:px-24">
  <div class="max-w-4xl mx-auto">
    <span class="block font-mono text-xs uppercase tracking-[0.3em] text-primary mb-4">// Credentials</span>
    <h2 class="text-3xl md:text-5xl font-bold text-foreground mb-12">
      Education &<br><span style="color: rgb(148, 163, 184);">certifications.</span>
    </h2>

    <?php
    $has_block_recursive = function (array $blocks, string $block_name) use (&$has_block_recursive): bool {
      foreach ($blocks as $block) {
        if (!is_array($block)) continue;
        if (!empty($block['blockName']) && $block['blockName'] === $block_name) return true;
        if (!empty($block['innerBlocks']) && is_array($block['innerBlocks'])) {
          if ($has_block_recursive($block['innerBlocks'], $block_name)) return true;
        }
      }
      return false;
    };

    $fmt_ym = function ($ymd): string {
      $ymd = is_string($ymd) ? trim($ymd) : '';
      if ($ymd === '') return '';
      $t = strtotime($ymd);
      return $t ? date('Y-m', $t) : '';
    };

    $cat_id = get_cat_ID('Education and Certificates');
    $cred_query = new WP_Query([
      'post_type' => 'post',
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'cat' => $cat_id ?: 0,
      'meta_key' => 'jp_ach_date_start',
      'orderby' => 'meta_value',
      'meta_type' => 'DATE',
      'order' => 'DESC',
      'ignore_sticky_posts' => true,
    ]);

    $education = [];
    $certificates = [];

    while ($cred_query->have_posts()) {
      $cred_query->the_post();
      $post_id = get_the_ID();

      $raw = get_post_field('post_content', $post_id);
      $blocks = function_exists('parse_blocks') ? parse_blocks($raw) : [];
      $has_ach = !empty($blocks) ? $has_block_recursive($blocks, 'jose-portfolio/achievement-detail') : false;

      if (!$has_ach) continue;

      $type = get_post_meta($post_id, 'jp_ach_type', true) ?: 'education';
      $issuer = get_post_meta($post_id, 'jp_ach_issuer', true);
      $location = get_post_meta($post_id, 'jp_ach_location', true);
      $start = get_post_meta($post_id, 'jp_ach_date_start', true);
      $end = get_post_meta($post_id, 'jp_ach_date_end', true);
      $verify = get_post_meta($post_id, 'jp_ach_verify_url', true);

      $date_label = trim($fmt_ym($start) . (($start && $end) ? ' - ' : '') . $fmt_ym($end));

      $item = [
        'id' => $post_id,
        'title' => get_the_title($post_id),
        'excerpt' => wp_strip_all_tags(get_the_excerpt($post_id)),
        'issuer' => $issuer,
        'location' => $location,
        'date_label' => $date_label,
        'verify' => $verify,
        'type' => $type,
      ];

      if ($type === 'certificate') $certificates[] = $item;
      else $education[] = $item;
    }
    wp_reset_postdata();
    ?>

    <?php if (empty($education) && empty($certificates)) : ?>
      <p class="text-muted-foreground">No education/certification entries found yet.</p>
    <?php else : ?>
      <?php
      $render_card = function (array $item) {
        $is_edu = ($item['type'] !== 'certificate');
        $wrap = $is_edu
          ? 'p-6 rounded-lg border border-primary/30 bg-primary/5 hover:border-primary/50 transition-all'
          : 'p-6 rounded-lg border border-border/60 bg-card/40 hover:border-primary/30 transition-all';
        ?>
        <div class="<?php echo esc_attr($wrap); ?>">
          <div class="flex items-start gap-4 mb-4">
            <div class="w-12 h-12 rounded-lg <?php echo $is_edu ? 'bg-primary/15' : 'bg-primary/10'; ?> flex items-center justify-center shrink-0">
              <i data-lucide="<?php echo esc_attr($is_edu ? 'graduation-cap' : 'award'); ?>" class="w-6 h-6 text-primary"></i>
            </div>
            <div class="flex-1 min-w-0">
              <h3 class="text-lg font-semibold text-foreground"><?php echo esc_html($item['title']); ?></h3>
              <?php if (!empty($item['issuer']) || !empty($item['location'])) : ?>
                <p class="font-mono text-sm text-primary">
                  <?php echo esc_html(trim(implode(' • ', array_filter([$item['issuer'], $item['location']])))); ?>
                </p>
              <?php endif; ?>
              <?php if (!empty($item['date_label'])) : ?>
                <p class="font-mono text-xs text-muted-foreground"><?php echo esc_html($item['date_label']); ?></p>
              <?php endif; ?>
            </div>
          </div>

          <?php if (!empty($item['excerpt'])) : ?>
            <p class="text-muted-foreground text-sm leading-relaxed"><?php echo esc_html($item['excerpt']); ?></p>
          <?php endif; ?>

          <?php if (!empty($item['verify'])) : ?>
            <div class="mt-4">
              <a class="inline-flex items-center gap-2 rounded-md font-mono text-xs px-3 py-2 border border-border/60 bg-card/40 hover:bg-card/60 text-foreground"
                 href="<?php echo esc_url($item['verify']); ?>" target="_blank" rel="noopener noreferrer">
                Verify <span class="text-muted-foreground">↗</span>
              </a>
            </div>
          <?php endif; ?>
        </div>
      <?php }; ?>

      <?php if (!empty($education)) : ?>
        <div class="mb-10">
          <div class="flex items-center gap-3 mb-5">
            <span class="inline-flex items-center rounded-full bg-primary/10 border border-primary/20 px-3 py-1 font-mono text-xs text-primary">Education</span>
            <span class="font-mono text-xs text-muted-foreground"><?php echo esc_html(count($education)); ?> items</span>
          </div>
          <div class="grid md:grid-cols-2 gap-6">
            <?php foreach ($education as $item) { $render_card($item); } ?>
          </div>
        </div>
      <?php endif; ?>

      <?php if (!empty($certificates)) : ?>
        <div>
          <div class="flex items-center gap-3 mb-5">
            <span class="inline-flex items-center rounded-full bg-card/40 border border-border/60 px-3 py-1 font-mono text-xs text-muted-foreground">Certificates</span>
            <span class="font-mono text-xs text-muted-foreground"><?php echo esc_html(count($certificates)); ?> items</span>
          </div>
          <div class="grid md:grid-cols-2 gap-6">
            <?php foreach ($certificates as $item) { $render_card($item); } ?>
          </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>