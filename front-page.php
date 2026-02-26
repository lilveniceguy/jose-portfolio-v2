<?php if (!defined('ABSPATH')) { exit; } ?>
<?php get_header(); ?>

<!-- TOP MARQUEE - SKILLS -->
<div class="fixed top-0 left-0 right-0 z-40 border-b border-border/60 bg-background/90 backdrop-blur-xl">
  <div class="flex items-center">
    <div class="hidden lg:flex shrink-0 items-center gap-2 border-r border-border/60 px-4 py-3">
      <i data-lucide="zap" class="w-4 h-4 text-primary"></i>
      <span class="font-mono text-xs uppercase tracking-widest text-foreground/80">Skills</span>
    </div>
    <div class="flex-1 overflow-hidden py-1 relative" @mouseenter="sp=true" @mouseleave="sp=false">
      <div class="pointer-events-none absolute left-0 top-0 z-10 h-full w-16 bg-gradient-to-r from-background to-transparent"></div>
      <div class="pointer-events-none absolute right-0 top-0 z-10 h-full w-16 bg-gradient-to-l from-background to-transparent"></div>

      <div class="flex gap-3 py-2 w-max" :class="sp ? 'paused' : ''" style="animation: marquee-left 60s linear infinite;">
        <template x-for="(s, i) in dupSkills" :key="s.slug+i">
          <button @click="openSkill(s)"
            class="flex shrink-0 items-center gap-2.5 rounded-md border px-4 py-2 font-mono text-sm transition-all"
            :class="selSkill?.slug===s.slug ? 'border-primary bg-primary/15 text-primary' : 'border-border/70 bg-card/60 text-foreground/80 hover:border-primary/50 hover:text-foreground'">
            <span class="font-medium" x-text="s.label"></span>
            <span class="flex h-5 min-w-5 items-center justify-center rounded-full px-1.5 text-[10px]"
              :class="selSkill?.slug===s.slug ? 'bg-primary text-white' : 'bg-secondary text-foreground/70'"
              x-text="countSkill(s.slug)"></span>
          </button>
        </template>
      </div>
    </div>
  </div>
</div>

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

      <div class="flex gap-3 py-2 w-max" :class="syp ? 'paused' : ''" style="animation: marquee-right 50s linear infinite;">
        <template x-for="(sys, i) in dupSystems" :key="sys.slug+i">
          <button @click="openSystem(sys)"
            class="flex shrink-0 items-center gap-2.5 rounded-md border px-4 py-2 font-mono text-sm transition-all"
            :class="selSystem?.slug===sys.slug ? 'border-primary bg-primary/15 text-primary' : 'border-border/70 bg-card/60 text-foreground/80 hover:border-primary/50 hover:text-foreground'">
            <span class="font-medium" x-text="sys.label"></span>
          </button>
        </template>
      </div>
    </div>
  </div>
</div>

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

<!-- MAIN CONTENT -->
  <main class="relative z-10 pt-16 pb-16">
    <!-- HERO -->
    <section id="hero" class="relative flex min-h-screen items-center justify-center px-6 lg:px-24">
      <div class="max-w-4xl" :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" style="transition: all 1s;">
        <div class="mb-8 flex items-center gap-2 font-mono text-sm text-muted-foreground">
          <i data-lucide="terminal" class="w-4 h-4 text-primary"></i>
          <span class="text-primary">~/</span><span>portfolio</span><span class="text-primary">$</span><span class="text-foreground">whoami</span>
        </div>
        <h1 class="mb-4 text-5xl font-bold tracking-tight text-foreground md:text-7xl lg:text-8xl">
          I design systems<br>
          <span style="color: rgb(148, 163, 184);">that survive</span><br>
          <span class="text-primary">scale.</span>
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
          <span class="hidden md:inline">10+ years shipping</span>
        </div>
      </div>
      <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-muted-foreground">
        <span class="font-mono text-[10px] uppercase tracking-[0.3em]">Scroll</span>
        <div class="h-8 w-px bg-border relative overflow-hidden"><div class="absolute top-0 h-3 w-full bg-primary/50 animate-bounce-scroll"></div></div>
      </div>
    </section>

    <!-- PHILOSOPHY -->
    <section id="philosophy" class="min-h-screen py-32 px-6 lg:px-24">
      <div class="max-w-4xl mx-auto">
        <span class="block font-mono text-xs uppercase tracking-[0.3em] text-primary mb-4">// Philosophy</span>
        <h2 class="text-3xl md:text-5xl font-bold text-foreground mb-12">Code is liability.<br><span style="color: rgb(148, 163, 184);">Architecture is asset.</span></h2>
        <div class="grid md:grid-cols-2 gap-8">
          <template x-for="(p, i) in principles" :key="i">
            <div class="p-6 rounded-lg border border-border bg-card/40 hover:border-primary/30 transition-all">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center"><i :data-lucide="p.icon" class="w-5 h-5 text-primary"></i></div>
                <h3 class="font-semibold text-foreground" x-text="p.title"></h3>
              </div>
              <p class="text-sm leading-relaxed text-muted-foreground" x-text="p.desc"></p>
            </div>
          </template>
        </div>
      </div>
    </section>

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

    <!-- CREATIVE -->
    <section id="creative" class="min-h-screen py-32 px-6 lg:px-24">
      <div class="max-w-5xl mx-auto">
        <span class="block font-mono text-xs uppercase tracking-[0.3em] text-primary mb-4">// Creative</span>
        <h2 class="text-3xl md:text-5xl font-bold text-foreground mb-12">Beyond the<br><span style="color: rgb(148, 163, 184);">terminal.</span></h2>
        <div class="grid md:grid-cols-3 gap-6">
          <template x-for="(item, i) in creative" :key="i">
            <div class="group relative overflow-hidden rounded-lg border border-border/60 bg-card/40 aspect-[4/3] hover:border-primary/30 transition-all">
              <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-background/90"></div>
              <div class="absolute bottom-0 left-0 right-0 p-4">
                <h3 class="font-semibold text-foreground" x-text="item.title"></h3>
                <p class="font-mono text-xs text-muted-foreground" x-text="item.type"></p>
              </div>
            </div>
          </template>
        </div>
      </div>
    </section>

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

    <!-- SIGNAL -->
    <section id="signal" class="min-h-screen py-32 px-6 lg:px-24">
      <div class="max-w-4xl mx-auto text-center">
        <span class="block font-mono text-xs uppercase tracking-[0.3em] text-primary mb-4">// Signal</span>
        <h2 class="text-3xl md:text-5xl font-bold text-foreground mb-8">Let's build<br><span style="color: rgb(148, 163, 184);">something resilient.</span></h2>
        <p class="text-muted-foreground text-lg mb-12 max-w-2xl mx-auto">Available for architecture consulting, system design reviews, and complex full-stack builds. If your system needs to survive scale, let's talk.</p>
        <div class="flex flex-wrap justify-center gap-4">
          <a href="mailto:hello@example.com" class="inline-flex items-center gap-2 px-6 py-3 rounded-md bg-primary text-white font-medium hover:bg-primary/90 transition-colors">
            <i data-lucide="mail" class="w-4 h-4"></i><span>Get in touch</span>
          </a>
          <a href="#" class="inline-flex items-center gap-2 px-6 py-3 rounded-md border border-border bg-card/40 text-foreground font-medium hover:bg-card/80 transition-colors">
            <i data-lucide="github" class="w-4 h-4"></i><span>GitHub</span>
          </a>
          <a href="#" class="inline-flex items-center gap-2 px-6 py-3 rounded-md border border-border bg-card/40 text-foreground font-medium hover:bg-card/80 transition-colors">
            <i data-lucide="linkedin" class="w-4 h-4"></i><span>LinkedIn</span>
          </a>
        </div>
        <div class="mt-20 pt-8 border-t border-border">
          <p class="font-mono text-xs text-muted-foreground"><span class="text-primary">$</span> echo "Built with systems thinking"</p>
        </div>
      </div>
    </section>
</main>

<?php get_footer(); ?>