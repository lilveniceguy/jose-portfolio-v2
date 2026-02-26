<!-- TOP MARQUEE - SKILLS -->
<div class="fixed top-0 left-0 right-0 z-40 border-b border-border/60 bg-background/90 backdrop-blur-xl">
  <div class="flex items-center">
    <div class="hidden lg:flex shrink-0 items-center gap-2 border-r border-border/60 px-4 py-3">
      <i data-lucide="zap" class="w-4 h-4 text-primary"></i>
      <span class="font-mono text-xs uppercase tracking-widest text-foreground/80">Skills </span>
    </div>
    <div class="flex-1 overflow-hidden py-1 relative" @mouseenter="sp=true" @mouseleave="sp=false">
      <div class="pointer-events-none absolute left-0 top-0 z-10 h-full w-16 bg-gradient-to-r from-background to-transparent"></div>
      <div class="pointer-events-none absolute right-0 top-0 z-10 h-full w-16 bg-gradient-to-l from-background to-transparent"></div>

      <div class="flex gap-3 py-2 w-max" :class="sp ? 'paused' : ''" style="animation: marquee-left 140s linear infinite;">
        <template x-for="(s, i) in dupSkills" :key="s.slug+i">
          <button @click="openTag('skill', s.slug)"
            class="flex shrink-0 items-center gap-2.5 rounded-md border px-4 py-2 font-mono text-sm transition-all"
            :class="selSkill?.slug===s.slug ? 'border-primary bg-primary/15 text-primary' : 'border-border/70 bg-card/60 text-foreground/80 hover:border-primary/50 hover:text-foreground'">
            <span class="font-medium" x-text="s.label"></span>
            <span class="flex h-5 min-w-5 items-center justify-center rounded-full px-1.5 text-[10px]"
              :class="selSkill?.slug===s.slug ? 'bg-primary text-white' : 'bg-secondary text-foreground/70'"
              x-text="s.count || 0"></span>
          </button>
        </template>
      </div>
    </div>
  </div>
</div>