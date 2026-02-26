<!-- MOBILE NAV BUTTON -->
<button @click="mobNav=true" class="fixed left-4 top-1/2 -translate-y-1/2 z-50 lg:hidden flex items-center justify-center w-10 h-10 rounded-md border border-border bg-card/80 backdrop-blur-xl text-muted-foreground">
  <i data-lucide="menu" class="w-5 h-5"></i>
</button>

<!-- MOBILE NAV OVERLAY -->
<div x-cloak x-show="mobNav" x-transition.opacity @click="mobNav=false" class="fixed inset-0 z-50 bg-background/95 backdrop-blur-xl lg:hidden">
  <div class="flex flex-col items-center justify-center h-full gap-6 p-8">
    <button @click="mobNav=false" class="absolute top-6 right-6 text-muted-foreground hover:text-foreground">
      <i data-lucide="x" class="w-6 h-6"></i>
    </button>
    <template x-for="sec in sections" :key="sec.id">
      <a :href="'#'+sec.id" @click="mobNav=false"
        class="font-mono text-lg uppercase tracking-widest transition-colors"
        :class="activeSec===sec.id ? 'text-primary' : 'text-muted-foreground hover:text-foreground'"
        x-text="sec.label"></a>
    </template>
  </div>
</div>