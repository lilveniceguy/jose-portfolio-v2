    <!-- CREATIVE -->
    <section id="creative" class="min-h-screen py-32 px-6 lg:px-24">
      <div class="max-w-5xl mx-auto">
        <span class="block font-mono text-xs uppercase tracking-[0.3em] text-primary mb-4">// Creative</span>
        <h2 class="text-3xl md:text-5xl font-bold text-foreground mb-12">Beyond the<br><span style="color: rgb(148, 163, 184);">terminal.</span></h2>
        <div class="grid md:grid-cols-3 gap-6">
          <template x-for="(item, i) in creative" :key="i">
            <div class="group relative overflow-hidden rounded-lg border border-border/60 bg-card/40 aspect-[4/3] hover:border-primary/30 transition-all">
              <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-background/90"></div>
              <div class="absolute bottom-0 left-0 right-0 p-4">
                <h3 class="font-semibold text-foreground" x-text="item.title"></h3>
                <p class="font-mono text-xs text-muted-foreground" x-text="item.type"></p>
              </div>
            </div>
          </template>
        </div>
      </div>
    </section>