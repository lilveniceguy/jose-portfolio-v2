<!-- EXPERIENCE -->
    <section id="experience" class="min-h-screen py-32 px-6 lg:px-24">
      <div class="max-w-4xl mx-auto">
        <span class="block font-mono text-xs uppercase tracking-[0.3em] text-primary mb-4">// Work timeline</span>
        <h2 class="text-3xl md:text-5xl font-bold text-foreground mb-12">Where I've built.<br><span style="color: rgb(148, 163, 184);">What I've shipped.</span></h2>
        <div class="space-y-6">
          <template x-for="post in workPosts" :key="post.id">
            <div class="relative pl-8 border-l-2 border-border/40 pb-8">
              <div class="absolute left-0 top-0 -translate-x-1/2 w-3 h-3 rounded-full bg-primary"></div>
              <div class="p-6 rounded-lg border border-border/60 bg-card/40 hover:border-primary/30 transition-all">
                <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                  <div>
                    <h3 class="text-xl font-semibold text-foreground" x-text="post.meta._position_title"></h3>
                    <p class="font-mono text-sm text-primary" x-text="post.meta._company_name"></p>
                  </div>
                  <span class="font-mono text-xs text-muted-foreground px-3 py-1 rounded-full bg-secondary" x-text="post.meta._is_current ? post.meta._date_start + ' - Present' : post.meta._date_start + ' - ' + post.meta._date_end"></span>
                </div>
                <p class="text-muted-foreground leading-relaxed mb-4" x-text="post.excerpt"></p>
                <div class="flex flex-wrap gap-2">
                  <template x-for="tag in post.tags.slice(0, 5)" :key="tag">
                    <span class="px-2 py-1 rounded text-xs font-mono bg-secondary text-muted-foreground" x-text="tag"></span>
                  </template>
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>
    </section>