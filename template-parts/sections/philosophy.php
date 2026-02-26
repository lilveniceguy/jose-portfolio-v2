<!-- PHILOSOPHY -->
<?php
$cards = jose_get_philosophy_cards_from_page('philosophy'); // slug
// dd($cards); // check output, should be an array of card data
?>

<!-- PHILOSOPHY -->
<section id="philosophy" class="min-h-screen py-32 px-6 lg:px-24">
  <div class="max-w-4xl mx-auto">
    <span class="block font-mono text-xs uppercase tracking-[0.3em] text-primary mb-4">// Philosophy</span>

    <h2 class="text-3xl md:text-5xl font-bold text-foreground mb-12">
      Code is liability.<br>
      <span style="color: rgb(148, 163, 184);">Architecture is asset.</span>
    </h2>

    <div class="grid md:grid-cols-2 gap-8">
      <?php foreach ($cards as $p) : ?>
        <div class="p-6 rounded-lg border border-border bg-card/40 hover:border-primary/30 transition-all">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
              <i data-lucide="<?php echo esc_attr($p['icon']); ?>" class="w-5 h-5 text-primary"></i>
            </div>
            <h3 class="font-semibold text-foreground"><?php echo esc_html($p['title']); ?></h3>
          </div>
          <p class="text-sm leading-relaxed text-muted-foreground"><?php echo esc_html($p['desc']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>