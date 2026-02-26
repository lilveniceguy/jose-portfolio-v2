<!-- CREDENTIALS -->
    <section id="credentials" class="min-h-screen py-32 px-6 lg:px-24">
      <div class="max-w-4xl mx-auto">
        <span class="block font-mono text-xs uppercase tracking-[0.3em] text-primary mb-4">// Credentials</span>
        <h2 class="text-3xl md:text-5xl font-bold text-foreground mb-12">Education &<br><span style="color: rgb(148, 163, 184);">certifications.</span></h2>
        <div class="flex flex-wrap gap-2 mb-10">
          <template x-for="cat in credCats" :key="cat.slug">
            <button @click="credCat = cat.slug" class="px-4 py-2 rounded-md font-mono text-sm transition-all"
                    :class="credCat === cat.slug ? 'bg-primary text-white' : 'bg-card/40 border border-border/60 text-muted-foreground hover:text-foreground'" x-text="cat.label"></button>
          </template>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
          <template x-for="post in filteredCreds" :key="post.id">
            <div class="p-6 rounded-lg border border-border/60 bg-card/40 hover:border-primary/30 transition-all">
              <div class="flex items-start gap-4 mb-4">
                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                  <i :data-lucide="post.category === 'education' ? 'graduation-cap' : 'award'" class="w-6 h-6 text-primary"></i>
                </div>
                <div class="flex-1 min-w-0">
                  <h3 class="text-lg font-semibold text-foreground" x-text="post.meta._degree_title || post.title"></h3>
                  <p class="font-mono text-sm text-primary" x-text="post.meta._institution_name || post.meta._issuing_org"></p>
                  <p class="font-mono text-xs text-muted-foreground" x-text="post.meta._date_start"></p>
                </div>
              </div>
              <p class="text-muted-foreground text-sm leading-relaxed" x-text="post.excerpt"></p>
            </div>
          </template>
        </div>
      </div>
    </section>