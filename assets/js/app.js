document.addEventListener('alpine:init', () => {
  Alpine.data('grid', () => ({
    mx: 0, my: 0, sy: 0, tx: 0, ty: 0,
    init() {
      window.addEventListener('mousemove', (e) => {
        const cx = window.innerWidth / 2;
        const cy = window.innerHeight / 2;
        this.tx = -((e.clientX - cx) / cx) * 30;
        this.ty = -((e.clientY - cy) / cy) * 30;
      }, { passive: true });

      window.addEventListener('scroll', () => {
        this.sy = window.scrollY * 0.15;
      }, { passive: true });

      const anim = () => {
        this.mx += (this.tx - this.mx) * 0.08;
        this.my += (this.ty - this.my) * 0.08;
        requestAnimationFrame(anim);
      };

      anim();
    }
  }));

  Alpine.data('portfolio', () => ({
    mounted: false,
    navExp: false,
    mobNav: false,
    activeSec: 'hero',
    sp: false,
    syp: false,

    skillOpen: false,
    sysOpen: false,
    selSkill: null,
    selSystem: null,

    credCat: 'all',
    typed: '',
    typingIdx: 0,
    typingChar: 0,
    typingDel: false,

    titles: ['Systems Architect', 'Scale Engineer', 'Infrastructure Designer', 'Performance Obsessive'],

    sections: [
      { id: 'hero', label: 'Init', icon: 'terminal' },
      { id: 'philosophy', label: 'Philosophy', icon: 'layers' },
      { id: 'experience', label: 'Experience', icon: 'briefcase' },
      { id: 'credentials', label: 'Certs', icon: 'graduation-cap' },
      { id: 'scale', label: 'Scale', icon: 'activity' },
      { id: 'creative', label: 'Creative', icon: 'camera' },
      { id: 'labs', label: 'Labs', icon: 'flask-conical' },
      { id: 'signal', label: 'Signal', icon: 'message-square' },
    ],

    // Keep your data as-is for now, later we can swap to WP REST.
    skills: [/* ... paste from your HTML ... */],
    systems: [/* ... */],
    caseStudies: {/* ... */},
    posts: [/* ... */],
    principles: [/* ... */],
    metrics: [/* ... */],
    creative: [/* ... */],
    labs: [/* ... */],
    credCats: [
      { slug: 'all', label: 'All' },
      { slug: 'education', label: 'Education' },
      { slug: 'certificates', label: 'Certificates' },
    ],

    get dupSkills() { return [...this.skills, ...this.skills]; },
    get dupSystems() { return [...this.systems, ...this.systems]; },
    get workPosts() { return this.posts.filter(p => p.category === 'work-experience'); },

    get filteredCreds() {
      const creds = this.posts.filter(p => p.category === 'education' || p.category === 'certificates');
      return this.credCat === 'all' ? creds : creds.filter(p => p.category === this.credCat);
    },

    init() {
      this.mounted = true;
      this.startTyping();
      this.setupObserver();
      this.$nextTick(() => {
        if (window.lucide && window.lucide.createIcons) {
          window.lucide.createIcons();
        }
      });
    },

    startTyping() {
      const tick = () => {
        const cur = this.titles[this.typingIdx];

        if (!this.typingDel) {
          this.typed = cur.slice(0, this.typingChar + 1);
          this.typingChar++;
          if (this.typingChar === cur.length) {
            setTimeout(() => { this.typingDel = true; tick(); }, 2000);
            return;
          }
        } else {
          this.typed = cur.slice(0, this.typingChar - 1);
          this.typingChar--;
          if (this.typingChar === 0) {
            this.typingDel = false;
            this.typingIdx = (this.typingIdx + 1) % this.titles.length;
          }
        }

        setTimeout(tick, this.typingDel ? 40 : 80);
      };

      tick();
    },

    setupObserver() {
      const obs = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
          if (e.isIntersecting) this.activeSec = e.target.id;
        });
      }, { threshold: 0.3, rootMargin: '-10% 0px -10% 0px' });

      this.sections.forEach((s) => {
        const el = document.getElementById(s.id);
        if (el) obs.observe(el);
      });
    },

    countSkill(slug) { return this.posts.filter(p => p.tags.includes(slug)).length; },
    skillPosts(slug) { return this.posts.filter(p => p.tags.includes(slug)); },

    openSkill(s) {
      this.selSkill = s;
      this.skillOpen = true;
      this.$nextTick(() => window.lucide && window.lucide.createIcons && window.lucide.createIcons());
    },

    openSystem(s) {
      this.selSystem = s;
      this.sysOpen = true;
      this.$nextTick(() => window.lucide && window.lucide.createIcons && window.lucide.createIcons());
    },
  }));
});

document.addEventListener('DOMContentLoaded', () => {
  if (window.lucide && window.lucide.createIcons) {
    window.lucide.createIcons();
  }
});