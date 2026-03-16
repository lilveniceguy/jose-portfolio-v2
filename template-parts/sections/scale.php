<!-- SCALE -->
<?php
// Build "numbers that matter" from Work Experience posts.

// Query all work-experience posts.
$scale_experience_query = new WP_Query([
  'post_type'      => 'post',
  'posts_per_page' => -1,
  'category_name'  => 'work-experience',
  'meta_key'       => 'jp_date_start',
  'orderby'        => 'meta_value',
  'meta_type'      => 'DATE',
  'order'          => 'DESC',
]);

$tag_years      = [];
$total_projects = 0;
$now            = new DateTimeImmutable('now');

if ($scale_experience_query->have_posts()) {
  while ($scale_experience_query->have_posts()) {
    $scale_experience_query->the_post();

    $post_id    = get_the_ID();
    $start_raw  = get_post_meta($post_id, 'jp_date_start', true);
    $end_raw    = get_post_meta($post_id, 'jp_date_end', true);
    $is_current = (bool) get_post_meta($post_id, 'jp_is_current', true);

    try {
      $start_dt = $start_raw ? new DateTimeImmutable($start_raw) : null;
    } catch (Exception $e) {
      $start_dt = null;
    }

    try {
      $end_dt = $is_current ? $now : ($end_raw ? new DateTimeImmutable($end_raw) : null);
    } catch (Exception $e) {
      $end_dt = null;
    }

    if ($start_dt && $end_dt && $end_dt >= $start_dt) {
      $diff = $start_dt->diff($end_dt);
      // Approximate years with fraction.
      $years = (float) $diff->y + ($diff->m / 12) + ($diff->d / 365.25);

      $tags = get_the_tags($post_id);
      if (!empty($tags) && !is_wp_error($tags)) {
        foreach ($tags as $tag) {
          $slug = $tag->slug;
          if (!isset($tag_years[$slug])) {
            $tag_years[$slug] = [
              'slug'  => $slug,
              'name'  => $tag->name,
              'years' => 0.0,
            ];
          }
          $tag_years[$slug]['years'] += max(0.0, $years);
        }
      }
    }

    // Optional: sum a per-job project count if present.
    $job_projects = get_post_meta($post_id, 'jp_project_count', true);
    if ($job_projects !== '' && $job_projects !== null) {
      $n = (int) $job_projects;
      if ($n > 0) {
        $total_projects += $n;
      }
    }
  }
  wp_reset_postdata();
}

// Sort tags by total years (desc) and take top 5.
$top_tags = array_values($tag_years);
usort($top_tags, function ($a, $b) {
  if ($a['years'] === $b['years']) {
    return 0;
  }
  return ($a['years'] < $b['years']) ? 1 : -1;
});
$top_tags = array_slice($top_tags, 0, 5);

// Build metrics array for rendering.
$metrics = [];

// First card: projects shipped.
if ($total_projects > 0) {
  $projects_number = $total_projects;
  $projects_suffix = ($total_projects >= 100) ? '+' : '';
} else {
  // Fallback if no explicit jp_project_count values exist.
  $projects_number = 100;
  $projects_suffix = '+';
}

$metrics[] = [
  'number'   => $projects_number,
  'suffix'   => $projects_suffix,
  'unit'     => '', // no extra text unit
  'label'    => 'Projects shipped',
  'decimals' => 0,
];

// Top tech/framework years.
foreach ($top_tags as $tag_info) {
  $years = max(0.0, (float) $tag_info['years']);
  // Round to 1 decimal, but avoid showing "0.0y".
  $rounded = round($years, 1);
  if ($rounded < 0.1 && $years > 0) {
    $rounded = 0.1;
  }

  $metrics[] = [
    'number'   => $rounded,
    'suffix'   => '', // numeric value only, text unit handled separately
    'unit'     => 'years',
    'label'    => esc_html($tag_info['name']),
    'decimals' => 1,
  ];
}
?>

<section id="scale" class="min-h-screen py-32 px-6 lg:px-24">
  <div class="max-w-5xl mx-auto">
    <span class="block font-mono text-xs uppercase tracking-[0.3em] text-primary mb-4">// Scale</span>
    <h2 class="text-3xl md:text-5xl font-bold text-foreground mb-4">
      Numbers that<br>
      <span style="color: rgb(148, 163, 184);">matter.</span>
    </h2>
    <p class="text-muted-foreground max-w-2xl mb-12 text-sm md:text-base">
      I’ve shipped more than 100 projects across products, platforms, and industries.
      These numbers are summed directly from my work experience and the technologies
      I’ve used to build them.
    </p>

    <?php if (!empty($metrics)) : ?>
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php foreach ($metrics as $index => $metric) : ?>
          <?php
          $is_primary = ($index === 0);
          $card_classes = 'group relative overflow-hidden p-6 rounded-lg border bg-card/40 text-center cursor-default transition-all duration-300 ease-out';
          $card_classes .= $is_primary
            ? ' border-primary/70 bg-primary/5 hover:bg-primary/10 hover:border-primary'
            : ' border-border/60 hover:border-primary/60 hover:bg-card/70';
          ?>
          <div
            class="<?php echo esc_attr($card_classes); ?> hover:-translate-y-1 hover:shadow-[0_18px_45px_rgba(15,23,42,0.55)]"
          >
            <div
              class="pointer-events-none absolute inset-0 opacity-0 group-hover:opacity-100
                     bg-radial-gradient from-primary/15 via-transparent to-transparent
                     transition-opacity duration-300"
              aria-hidden="true"
            ></div>

            <div class="relative z-10">
              <div class="flex items-baseline justify-center mb-2 gap-1">
                <span
                  class="jp-scale-number text-4xl md:text-5xl font-bold
                         transition-transform duration-300 ease-out group-hover:scale-110 group-hover:-translate-y-0.5 <?php echo $is_primary ? 'text-primary' : 'text-primary'; ?>"
                  data-countup="true"
                  data-target="<?php echo esc_attr($metric['number']); ?>"
                  data-suffix="<?php echo esc_attr($metric['suffix'] ?? ''); ?>"
                  data-decimals="<?php echo isset($metric['decimals']) ? (int) $metric['decimals'] : 0; ?>"
                >
                  0<?php echo esc_html($metric['suffix'] ?? ''); ?>
                </span>
                <?php if (!empty($metric['unit'])) : ?>
                  <span class="text-xs text-white/80 uppercase tracking-wide">
                    <?php echo esc_html($metric['unit']); ?>
                  </span>
                <?php endif; ?>
              </div>
              <div
                class="font-mono text-xs uppercase tracking-widest transition-colors duration-300 <?php echo $is_primary ? 'text-primary/90 group-hover:text-primary' : 'text-muted-foreground group-hover:text-primary/90'; ?>"
              >
                <?php echo $metric['label']; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <p class="text-muted-foreground">Scale metrics will appear here once work experience is added.</p>
    <?php endif; ?>
  </div>
</section>

<script>
  (function () {
    function animateCount(el) {
      const target = parseFloat(el.getAttribute('data-target') || '0');
      const suffix = el.getAttribute('data-suffix') || '';
      const decimals = parseInt(el.getAttribute('data-decimals') || '0', 10);
      const duration = 1400;
      const start = performance.now();
      const startVal = 0;

      function frame(now) {
        const progress = Math.min(1, (now - start) / duration);
        const eased = 1 - Math.pow(1 - progress, 3); // easeOutCubic
        const current = startVal + (target - startVal) * eased;
        el.textContent = current.toFixed(decimals) + suffix;
        if (progress < 1) {
          requestAnimationFrame(frame);
        }
      }

      requestAnimationFrame(frame);
    }

    document.addEventListener('DOMContentLoaded', function () {
      const section = document.getElementById('scale');
      if (!section) return;

      const numbers = Array.prototype.slice.call(
        section.querySelectorAll('[data-countup="true"]')
      );
      if (!numbers.length) return;

      let hasAnimated = false;

      const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (!hasAnimated && entry.isIntersecting) {
            hasAnimated = true;
            numbers.forEach(function (el) { animateCount(el); });
            observer.disconnect();
          }
        });
      }, { threshold: 0.35 });

      observer.observe(section);
    });
  })();
</script>