<!-- HERO -->
    <section id="hero" class="relative flex min-h-screen items-center justify-center px-6 lg:px-24">
      <div class="max-w-4xl" :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" style="transition: all 1s;">
        <div class="mb-8 flex items-center gap-2 font-mono text-sm text-muted-foreground">
          <i data-lucide="terminal" class="w-4 h-4 text-primary"></i>
          <span class="text-primary">~/</span><span>portfolio</span><span class="text-primary">$</span><span class="text-foreground">whoami</span>
        </div>
        <h1 class="mb-4 text-5xl font-bold tracking-tight text-foreground md:text-7xl lg:text-8xl">
          <?php echo bloginfo('name'); ?><br>
          <span style="color: rgb(148, 163, 184);">I design systems</span><br>
          <span class="text-primary">that scale.</span>
        </h1>
        <div class="mb-8 font-mono text-lg text-muted-foreground md:text-xl">
          <span class="text-muted-foreground/60">&gt; </span>
          <span class="text-primary" x-text="typed"></span><span class="animate-blink">_</span>
        </div>
        <p class="max-w-2xl text-base leading-relaxed text-muted-foreground md:text-lg">
          Senior full-stack engineer building resilient architecture across WordPress multisite networks, Laravel systems, and AWS infrastructure. Not just writing code — engineering systems that hold under pressure.
        </p>
        <div class="mt-12 flex flex-wrap items-center gap-6 font-mono text-xs text-muted-foreground">
          <div class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-primary animate-pulse-dot"></span><span>Available for contract work</span></div>
          <div class="hidden md:block h-4 w-px bg-border"></div>
          <span class="hidden md:inline">Based in your timezone</span>
          <div class="hidden md:block h-4 w-px bg-border"></div>
          <span class="hidden md:inline">15+ years shipping</span>
        </div>
      </div>
      <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-muted-foreground">
        <span class="font-mono text-[10px] uppercase tracking-[0.3em]">Scroll</span>
        <div class="h-8 w-px bg-border relative overflow-hidden"><div class="absolute top-0 h-3 w-full bg-primary/50 animate-bounce-scroll"></div></div>
      </div>
    </section>