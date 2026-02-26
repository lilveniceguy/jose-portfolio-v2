<!-- SIDE NAVIGATION -->
<nav class="fixed left-0 top-0 z-50 hidden h-screen lg:flex flex-col items-start justify-center" @mouseenter="navExp=true" @mouseleave="navExp=false">
  <div class="flex flex-col gap-1 rounded-r-lg border border-l-0 border-border bg-card/80 backdrop-blur-xl p-2">
    <template x-for="sec in sections" :key="sec.id">
      <a :href="'#'+sec.id"
        class="group flex items-center gap-3 rounded-md px-3 py-2.5 text-sm transition-all duration-300"
        :class="activeSec===sec.id ? 'bg-primary/10 text-primary' : 'text-muted-foreground hover:text-foreground hover:bg-secondary'">
        <i :data-lucide="sec.icon" class="w-4 h-4 shrink-0"></i>
        <span class="overflow-hidden whitespace-nowrap font-mono text-xs tracking-wider uppercase transition-all duration-300"
          :class="navExp ? 'w-24 opacity-100' : 'w-0 opacity-0'" x-text="sec.label"></span>
        <template x-if="activeSec===sec.id && navExp">
          <i data-lucide="chevron-right" class="w-3 h-3 shrink-0 text-primary"></i>
        </template>
      </a>
    </template>
  </div>
</nav>