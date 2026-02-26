<!-- SCALE -->
    <section id="scale" class="min-h-screen py-32 px-6 lg:px-24">
      <div class="max-w-5xl mx-auto">
        <span class="block font-mono text-xs uppercase tracking-[0.3em] text-primary mb-4">// Scale</span>
        <h2 class="text-3xl md:text-5xl font-bold text-foreground mb-12">Numbers that<br><span style="color: rgb(148, 163, 184);">matter.</span></h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <template x-for="(m, i) in metrics" :key="i">
            <div class="p-6 rounded-lg border border-border/60 bg-card/40 text-center">
              <div class="text-4xl md:text-5xl font-bold text-primary mb-2" x-text="m.value"></div>
              <div class="font-mono text-xs uppercase tracking-widest text-muted-foreground" x-text="m.label"></div>
            </div>
          </template>
        </div>
      </div>
    </section>