    <!-- LABS -->
    <section id="labs" class="min-h-screen py-32 px-6 lg:px-24">
      <div class="max-w-5xl mx-auto">
        <span class="block font-mono text-xs uppercase tracking-[0.3em] text-primary mb-4">// Labs</span>
        <h2 class="text-3xl md:text-5xl font-bold text-foreground mb-12">Experiments &<br><span style="color: rgb(148, 163, 184);">open source.</span></h2>
        <div class="grid md:grid-cols-2 gap-6">
          <template x-for="(proj, i) in labs" :key="i">
            <div class="p-6 rounded-lg border border-border/60 bg-card/40 hover:border-primary/30 transition-all">
              <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-foreground" x-text="proj.name"></h3>
                <span class="font-mono text-[10px] uppercase tracking-widest px-2 py-1 rounded bg-primary/10 text-primary" x-text="proj.status"></span>
              </div>
              <p class="text-sm text-muted-foreground mb-4" x-text="proj.desc"></p>
              <div class="flex flex-wrap gap-2">
                <template x-for="t in proj.tech" :key="t">
                  <span class="px-2 py-1 rounded text-xs font-mono bg-secondary text-muted-foreground" x-text="t"></span>
                </template>
              </div>
            </div>
          </template>
        </div>
      </div>
    </section>