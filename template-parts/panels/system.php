<!-- BOTTOM MARQUEE - SYSTEMS -->
<div class="fixed bottom-0 left-0 right-0 z-40 border-t border-border/60 bg-background/90 backdrop-blur-xl">
  <div class="flex items-center">
    <div class="hidden lg:flex shrink-0 items-center gap-2 border-r border-border/60 px-4 py-3">
      <i data-lucide="layers" class="w-4 h-4 text-primary"></i>
      <span class="font-mono text-xs uppercase tracking-widest text-foreground/80">Systems</span>
    </div>
    <div class="flex-1 overflow-hidden py-1 relative" @mouseenter="syp=true" @mouseleave="syp=false">
      <div class="pointer-events-none absolute left-0 top-0 z-10 h-full w-16 bg-gradient-to-r from-background to-transparent"></div>
      <div class="pointer-events-none absolute right-0 top-0 z-10 h-full w-16 bg-gradient-to-l from-background to-transparent"></div>

      <div class="flex gap-3 py-2 w-max" :class="syp ? 'paused' : ''" style="animation: marquee-right 70s linear infinite;">
        <template x-for="(sys, i) in dupSystems" :key="sys.slug+i">
          <button @click="openTag('system', sys.slug)"
            class="flex shrink-0 items-center gap-2.5 rounded-md border px-4 py-2 font-mono text-sm transition-all"
            :class="selSystem?.slug===sys.slug ? 'border-primary bg-primary/15 text-primary' : 'border-border/70 bg-card/60 text-foreground/80 hover:border-primary/50 hover:text-foreground'">
            <span class="font-medium" x-text="sys.label"></span>
            <span class="flex h-5 min-w-5 items-center justify-center rounded-full px-1.5 text-[10px]"
            :class="selSystem?.slug===sys.slug ? 'bg-primary text-white' : 'bg-secondary text-foreground/70'"
            x-text="sys.count || 0"></span>
          </button>
        </template>
      </div>
    </div>
  </div>
</div>