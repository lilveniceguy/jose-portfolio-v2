<?php if (!defined('ABSPATH')) { exit; } ?>

<!-- SKILL PANEL -->
<div x-cloak x-show="skillOpen" x-transition.opacity @click="skillOpen=false" class="fixed inset-0 z-[60] bg-background/60 backdrop-blur-sm"></div>
<div x-cloak x-show="skillOpen"
  x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
  x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
  class="fixed top-0 right-0 bottom-0 z-[60] w-full max-w-lg border-l border-border bg-background/95 backdrop-blur-xl overflow-y-auto"
  x-effect="skillOpen && $nextTick(() => { window.lucide && window.lucide.createIcons && window.lucide.createIcons(); })">
  <template x-if="selSkill">
    <div>
      <div class="flex items-start justify-between border-b border-border p-5">
        <div class="flex-1 pr-4">
          <span class="mb-1 inline-block rounded border border-primary/30 bg-primary/10 px-2 py-0.5 font-mono text-[10px] uppercase tracking-widest text-primary" x-text="selSkill.category"></span>
          <h3 class="mt-1.5 text-xl font-bold text-foreground" x-text="selSkill.label"></h3>
        </div>
        <button @click="skillOpen=false" class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md border border-border text-muted-foreground hover:bg-secondary hover:text-foreground">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
      </div>

      <div class="border-b border-border p-5" x-show="selSkill.intro">
        <p class="text-sm leading-relaxed text-muted-foreground" x-text="selSkill.intro"></p>
      </div>

      <div class="p-5">
        <div class="mb-3 flex items-center justify-between">
          <span class="font-mono text-xs uppercase tracking-[0.3em] text-primary">// Related experience</span>
          <span class="font-mono text-xs text-muted-foreground" x-text="skillPosts(selSkill.slug).length + ' entries'"></span>
        </div>

        <div class="space-y-4">
          <template x-for="post in skillPosts(selSkill.slug)" :key="post.id">
            <div class="rounded-lg border border-border bg-card/40 p-4">
              <div class="mb-2 flex items-center justify-between gap-2">
                <span class="font-mono text-[10px] uppercase tracking-widest text-primary" x-text="post.category==='work-experience' ? 'Experience' : post.category==='education' ? 'Education' : 'Certificate'"></span>
                <span class="font-mono text-[10px] text-muted-foreground shrink-0 flex items-center gap-1" x-show="post.meta && post.meta.date_label">
                  <i data-lucide="calendar" class="w-3 h-3"></i>
                  <span x-text="post.meta.date_label"></span>
                </span>
              </div>
              <h4 class="text-sm font-semibold text-foreground" x-text="post.meta.jp_position_title || post.meta._position_title || post.meta._degree_title || post.title"></h4>
              <p class="text-xs text-muted-foreground flex flex-wrap items-center gap-1 mt-0.5">
                <span x-text="post.category==='work-experience' ? post.title : (post.meta._company_name || post.meta._institution_name || post.meta._issuing_org || post.title)"></span>
                <template x-if="post.meta && post.meta.location_label">
                  <span class="flex items-center gap-1 text-muted-foreground">
                    <i data-lucide="map-pin" class="w-3 h-3 shrink-0"></i>
                    <span x-text="post.meta.location_label"></span>
                  </span>
                </template>
              </p>
              <template x-if="post.bullets && post.bullets.length">
                <ul class="mt-3 space-y-1 text-xs text-muted-foreground">
                  <template x-for="(bullet, bi) in post.bullets" :key="bi">
                    <li class="flex gap-2">
                      <span class="text-primary shrink-0">&gt;</span>
                      <span x-text="bullet"></span>
                    </li>
                  </template>
                </ul>
              </template>
              <template x-if="post.tag_names && post.tag_names.length">
                <p class="mt-3 font-mono text-[10px] text-muted-foreground" x-text="(post.tag_names || []).join(', ')"></p>
              </template>
            </div>
          </template>
        </div>
      </div>

      <div class="border-t border-border px-5 py-3">
        <div class="flex items-center justify-between font-mono text-[10px] text-muted-foreground">
          <span>Queried via WP REST</span>
          <span class="flex items-center gap-1.5"><span class="h-1.5 w-1.5 rounded-full bg-primary animate-pulse-dot"></span>Live data</span>
        </div>
      </div>
    </div>
  </template>
</div>

<!-- SYSTEM PANEL -->
<div x-cloak x-show="sysOpen" x-transition.opacity @click="sysOpen=false" class="fixed inset-0 z-[60] bg-background/60 backdrop-blur-sm"></div>
<div x-cloak x-show="sysOpen"
  x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
  x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
  class="fixed top-0 right-0 bottom-0 z-[60] w-full max-w-lg border-l border-border bg-background/95 backdrop-blur-xl overflow-y-auto">
  <template x-if="selSystem">
    <div>
      <div class="flex items-start justify-between border-b border-border p-5">
        <div class="flex-1 pr-4">
          <span class="mb-1 inline-block rounded border border-primary/30 bg-primary/10 px-2 py-0.5 font-mono text-[10px] uppercase tracking-widest text-primary">system</span>
          <h3 class="mt-1.5 text-xl font-bold text-foreground" x-text="selSystem.label"></h3>
        </div>
        <button @click="sysOpen=false" class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md border border-border text-muted-foreground hover:bg-secondary hover:text-foreground">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
      </div>

      <div class="border-b border-border p-5">
        <p class="text-sm leading-relaxed text-muted-foreground" x-text="selSystem.intro"></p>
      </div>

      <div class="p-5">
        <span class="font-mono text-xs uppercase tracking-[0.3em] text-primary mb-4 block">// Case studies</span>

        <template x-if="caseStudies[selSystem.slug]">
          <div class="space-y-4">
            <template x-for="study in caseStudies[selSystem.slug]" :key="study.title">
              <div class="rounded-lg border border-border bg-card/40 p-4">
                <div class="mb-2 flex flex-wrap gap-1.5">
                  <template x-for="tech in study.stack" :key="tech">
                    <span class="rounded border border-border px-1.5 py-0.5 font-mono text-[10px] text-muted-foreground" x-text="tech"></span>
                  </template>
                </div>
                <h4 class="text-sm font-semibold text-foreground" x-text="study.title"></h4>
                <p class="font-mono text-[11px] text-muted-foreground mb-3" x-text="study.subtitle"></p>
                <div class="space-y-2 text-xs text-muted-foreground">
                  <p><strong class="text-primary">Challenge:</strong> <span x-text="study.challenge"></span></p>
                  <p><strong class="text-primary">Solution:</strong> <span x-text="study.solution"></span></p>
                </div>
                <div class="mt-3 grid grid-cols-3 gap-2">
                  <template x-for="r in study.results" :key="r.metric">
                    <div class="text-center p-2 rounded bg-secondary/50">
                      <div class="font-mono text-[10px] text-muted-foreground" x-text="r.metric"></div>
                      <div class="text-xs"><span class="text-muted-foreground line-through" x-text="r.before"></span> <span class="text-primary font-semibold" x-text="r.after"></span></div>
                    </div>
                  </template>
                </div>
              </div>
            </template>
          </div>
        </template>

        <template x-if="!caseStudies[selSystem.slug]">
          <div class="rounded-lg border border-dashed border-border p-8 text-center">
            <p class="font-mono text-xs text-muted-foreground">Case study documentation in progress.</p>
          </div>
        </template>
      </div>

      <div class="border-t border-border px-5 py-3">
        <div class="flex items-center justify-between font-mono text-[10px] text-muted-foreground">
          <span x-text="'system/' + selSystem.slug"></span>
          <span class="flex items-center gap-1.5"><span class="h-1.5 w-1.5 rounded-full bg-primary animate-pulse-dot"></span>Architecture reference</span>
        </div>
      </div>
    </div>
  </template>
</div>

<?php wp_footer(); ?>
</body>
</html>