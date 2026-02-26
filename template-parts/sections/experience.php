<!-- EXPERIENCE -->
<section id="experience" class="min-h-screen py-32 px-6 lg:px-24">
  <div class="max-w-4xl mx-auto">
    <span class="block font-mono text-xs uppercase tracking-[0.3em] text-primary mb-4">// Work timeline</span>
    <h2 class="text-3xl md:text-5xl font-bold text-foreground mb-12">
      Where I've built.<br>
      <span style="color: rgb(148, 163, 184);">What I've shipped.</span>
    </h2>

    <?php
    // Query posts in "Work Experience" category to build the timeline.
    $experience_query = new WP_Query([
      'post_type'      => 'post',
      'posts_per_page' => -1,
      'category_name'  => 'work-experience', // slug for "Work Experience"
      // Order by job start date (newest first)
      'meta_key'       => 'jp_date_start',
      'orderby'        => 'meta_value',
      'meta_type'      => 'DATE',
      'order'          => 'DESC',
    ]);
    ?>

    <?php if ($experience_query->have_posts()) : ?>
      <div class="space-y-6">
        <?php while ($experience_query->have_posts()) : $experience_query->the_post(); ?>
          <?php
          $post_id   = get_the_ID();
          $company   = get_the_title($post_id);
          $position  = get_post_meta($post_id, 'jp_position_title', true);
          $start     = get_post_meta($post_id, 'jp_date_start', true);
          $is_current = (bool) get_post_meta($post_id, 'jp_is_current', true);
          $end       = get_post_meta($post_id, 'jp_date_end', true);
          $tags      = get_the_tags($post_id) ?: [];
          $excerpt   = get_the_excerpt() ?: '';

          $fmt_date = function ($ymd) {
            if (!$ymd) return '';
            $t = strtotime($ymd);
            if (!$t) return '';
            return date('Y-m', $t);
          };

          $date_label = '';
          if ($start) {
            $date_label = $fmt_date($start) . ' - ' . ($is_current ? 'Present' : $fmt_date($end));
          }

          // Limit tags to first 5, like the original template.
          if (!empty($tags)) {
            $tags = array_slice($tags, 0, 5);
          }
          ?>

          <div class="relative pl-8 border-l-2 border-border/40 pb-8 last:pb-0">
            <div class="absolute left-0 top-0 -translate-x-1/2 w-3 h-3 rounded-full bg-primary"></div>

            <div class="p-6 rounded-lg border border-border/60 bg-card/40 hover:border-primary/30 transition-all">
              <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                <div>
                  <h3 class="text-xl font-semibold text-foreground">
                    <?php echo esc_html($position ?: $company); ?>
                  </h3>
                  <p class="font-mono text-sm text-primary">
                    <?php echo esc_html($company); ?>
                  </p>
                </div>

                <?php if ($date_label) : ?>
                  <span class="font-mono text-xs text-muted-foreground px-3 py-1 rounded-full bg-secondary">
                    <?php echo esc_html($date_label); ?>
                  </span>
                <?php endif; ?>
              </div>

              <?php if ($excerpt) : ?>
                <p class="text-muted-foreground leading-relaxed mb-4">
                  <?php echo esc_html($excerpt); ?>
                </p>
              <?php endif; ?>

              <?php if (!empty($tags)) : ?>
                <div class="flex flex-wrap gap-2">
                  <?php foreach ($tags as $tag) : ?>
                    <span class="px-2 py-1 rounded text-xs font-mono bg-secondary text-muted-foreground">
                      <?php echo esc_html($tag->name); ?>
                    </span>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
      <?php wp_reset_postdata(); ?>
    <?php else : ?>
      <p class="text-muted-foreground">No work experience entries found yet.</p>
    <?php endif; ?>
  </div>
</section>