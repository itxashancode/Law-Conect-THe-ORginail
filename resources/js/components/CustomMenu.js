// CustomMenu - Vanilla JS implementation of staggered fullscreen menu
// Uses GSAP for animations, matches the StaggeredMenu design

class CustomMenu {
  constructor(options = {}) {
    this.position = options.position || 'right';
    this.colors = options.colors || ['#0D0D0D', '#1A1A1A', '#B8860B'];
    this.items = options.items || [];
    this.socialItems = options.socialItems || [];
    this.displaySocials = options.displaySocials !== false;
    this.menuButtonColor = options.menuButtonColor || '#fff';
    this.openMenuButtonColor = options.openMenuButtonColor || '#fff';
    this.accentColor = options.accentColor || '#D4AF37';
    this.changeMenuColorOnOpen = options.changeMenuColorOnOpen !== false;
    this.onClose = options.onClose || (() => {});

    this.open = false;
    this.busy = false;

    this.init();
  }

  init() {
    this.createElements();
    this.setupStyles();
    this.bindEvents();
  }

  createElements() {
    // Create wrapper
    this.wrapper = document.createElement('div');
    this.wrapper.className = 'custom-menu-wrapper';
    this.wrapper.setAttribute('data-position', this.position);
    this.wrapper.style.setProperty('--sm-accent', this.accentColor);
    
    // Backdrop blur for premium feel
    this.wrapper.style.backdropFilter = 'blur(0px)';
    this.wrapper.style.transition = 'backdrop-filter 0.5s ease';

    // Prelayers
    this.prelayersContainer = document.createElement('div');
    this.prelayersContainer.className = 'sm-prelayers';
    this.prelayersContainer.setAttribute('aria-hidden', 'true');
    const colorArray = this.colors.slice(0, 4);
    colorArray.forEach((color, i) => {
      const layer = document.createElement('div');
      layer.className = 'sm-prelayer';
      layer.style.background = color;
      layer.style.opacity = '1'; // Ensure layers are visible
      this.prelayersContainer.appendChild(layer);
    });

    // Header
    this.header = document.createElement('header');
    this.header.className = 'staggered-menu-header';
    this.header.setAttribute('aria-label', 'Main navigation header');

    this.logoDiv = document.createElement('div');
    this.logoDiv.className = 'sm-logo';
    this.logoDiv.setAttribute('aria-label', 'Logo');
    
    // Match the navbar brand styling
    this.logoDiv.innerHTML = `
      <a href="/" class="font-serif text-2xl text-white font-normal tracking-tightest no-underline flex items-baseline gap-1">
        Legal<span class="text-gold-500 italic">Counsel</span>
        <span class="w-1 h-1 bg-gold-500 rounded-full ml-1 animate-pulse"></span>
      </a>
    `;

    this.toggleBtn = document.createElement('button');
    this.toggleBtn.className = 'sm-toggle';
    this.toggleBtn.setAttribute('aria-label', this.open ? 'Close menu' : 'Open menu');
    this.toggleBtn.setAttribute('aria-expanded', this.open);
    this.toggleBtn.setAttribute('aria-controls', 'staggered-menu-panel');
    this.toggleBtn.type = 'button';

    this.textWrap = document.createElement('span');
    this.textWrap.className = 'sm-toggle-textWrap';
    this.textWrap.setAttribute('aria-hidden', 'true');
    this.textInner = document.createElement('span');
    this.textInner.className = 'sm-toggle-textInner';
    this.textLine1 = document.createElement('span');
    this.textLine1.className = 'sm-toggle-line';
    this.textLine1.textContent = 'Menu';
    this.textLine2 = document.createElement('span');
    this.textLine2.className = 'sm-toggle-line';
    this.textLine2.textContent = 'Close';
    this.textInner.appendChild(this.textLine1);
    this.textInner.appendChild(this.textLine2);
    this.textWrap.appendChild(this.textInner);

    this.icon = document.createElement('span');
    this.icon.className = 'sm-icon';
    this.icon.setAttribute('aria-hidden', 'true');
    this.plusH = document.createElement('span');
    this.plusH.className = 'sm-icon-line';
    this.plusV = document.createElement('span');
    this.plusV.className = 'sm-icon-line sm-icon-line-v';
    this.icon.appendChild(this.plusH);
    this.icon.appendChild(this.plusV);

    this.toggleBtn.appendChild(this.textWrap);
    this.toggleBtn.appendChild(this.icon);

    this.header.appendChild(this.logoDiv);
    this.header.appendChild(this.toggleBtn);

    // Panel
    this.panel = document.createElement('aside');
    this.panel.id = 'staggered-menu-panel';
    this.panel.className = 'staggered-menu-panel';
    this.panel.setAttribute('aria-hidden', !this.open);
    
    // Add a solid background to the panel to prevent overlap issues
    this.panel.style.background = '#0D0D0D'; 

    this.panelInner = document.createElement('div');
    this.panelInner.className = 'sm-panel-inner';

    this.menuList = document.createElement('ul');
    this.menuList.className = 'sm-panel-list';
    this.menuList.setAttribute('role', 'list');

    this.items.forEach((item, idx) => {
      const li = document.createElement('li');
      li.className = 'sm-panel-itemWrap';
      const a = document.createElement('a');
      a.className = 'sm-panel-item';
      a.href = item.link;
      if (item.ariaLabel) a.setAttribute('aria-label', item.ariaLabel);
      a.setAttribute('data-index', (idx + 1).toString().padStart(2, '0'));
      const labelSpan = document.createElement('span');
      labelSpan.className = 'sm-panel-itemLabel';
      labelSpan.textContent = item.label;
      a.appendChild(labelSpan);
      li.appendChild(a);
      this.menuList.appendChild(li);
    });

    this.panelInner.appendChild(this.menuList);

    if (this.displaySocials && this.socialItems.length) {
      const socialsDiv = document.createElement('div');
      socialsDiv.className = 'sm-socials';
      socialsDiv.setAttribute('aria-label', 'Social links');
      const socialTitle = document.createElement('h3');
      socialTitle.className = 'sm-socials-title';
      socialTitle.textContent = 'Socials.';
      const socialList = document.createElement('ul');
      socialList.className = 'sm-socials-list';
      socialList.setAttribute('role', 'list');
      this.socialItems.forEach(social => {
        const li = document.createElement('li');
        li.className = 'sm-socials-item';
        const a = document.createElement('a');
        a.href = social.link;
        a.target = '_blank';
        a.rel = 'noopener noreferrer';
        a.className = 'sm-socials-link';
        a.textContent = social.label;
        li.appendChild(a);
        socialList.appendChild(li);
      });
      socialsDiv.appendChild(socialTitle);
      socialsDiv.appendChild(socialList);
      this.panelInner.appendChild(socialsDiv);
    }

    this.panel.appendChild(this.panelInner);
    this.wrapper.appendChild(this.prelayersContainer);
    this.wrapper.appendChild(this.header);
    this.wrapper.appendChild(this.panel);

    // Insert into DOM
    document.body.appendChild(this.wrapper);

    // Cache elements for GSAP
    this.prelayerEls = Array.from(this.prelayersContainer.querySelectorAll('.sm-prelayer'));
    this.itemEls = Array.from(this.panel.querySelectorAll('.sm-panel-itemLabel'));
    this.itemWraps = Array.from(this.panel.querySelectorAll('.sm-panel-item'));
    this.socialTitleEl = this.panel.querySelector('.sm-socials-title');
    this.socialLinkEls = Array.from(this.panel.querySelectorAll('.sm-socials-link'));
  }

  setupStyles() {
    gsap.set([this.panel, ...this.prelayerEls], { xPercent: this.position === 'left' ? -100 : 100 });
    gsap.set(this.logoDiv, { opacity: 0, y: -10 }); // Hide logo initially
    this.logoDiv.style.pointerEvents = 'none'; // Disable pointer events initially
    gsap.set(this.plusH, { transformOrigin: '50% 50%', rotate: 0 });
    gsap.set(this.plusV, { transformOrigin: '50% 50%', rotate: 90 });
    gsap.set(this.icon, { rotate: 0, transformOrigin: '50% 50%' });
    gsap.set(this.textInner, { yPercent: 0 });
    gsap.set(this.toggleBtn, { color: this.menuButtonColor });
    if (this.itemWraps.length) {
      gsap.set(this.itemWraps, { '--sm-num-opacity': 0 });
    }
    if (this.socialTitleEl) {
      gsap.set(this.socialTitleEl, { opacity: 0 });
    }
    if (this.socialLinkEls.length) {
      gsap.set(this.socialLinkEls, { y: 25, opacity: 0 });
    }
  }

  bindEvents() {
    this.toggleBtn.addEventListener('click', () => this.toggle());
    document.addEventListener('mousedown', (e) => {
      if (this.open &&
          this.panel &&
          !this.panel.contains(e.target) &&
          this.toggleBtn &&
          !this.toggleBtn.contains(e.target)) {
        this.close();
      }
    });
  }

  toggle() {
    if (this.open) {
      this.close();
    } else {
      this.openMenu();
    }
  }

  openMenu() {
    if (this.busy) return;
    this.busy = true;
    this.openRef = true;
    this.open = true;
    this.wrapper.setAttribute('data-open', '');
    this.toggleBtn.setAttribute('aria-expanded', 'true');
    this.toggleBtn.setAttribute('aria-label', 'Close menu');
    
    // Backdrop blur
    this.wrapper.style.backdropFilter = 'blur(12px)';

    // Animate logo in
    gsap.to(this.logoDiv, { 
      opacity: 1, 
      y: 0, 
      duration: 0.6, 
      ease: 'power4.out', 
      delay: 0.2,
      onStart: () => { this.logoDiv.style.pointerEvents = 'auto'; }
    });

    // Animate icon
    gsap.to(this.icon, { rotate: 225, duration: 0.8, ease: 'power4.out', overwrite: 'auto' });

    // Animate text cycle
    this.cycleText(this.textInner, ['Menu', 'Close']);

    // Animate color
    if (this.changeMenuColorOnOpen) {
      gsap.to(this.toggleBtn, { color: this.openMenuButtonColor, delay: 0.18, duration: 0.3, ease: 'power2.out' });
    }

    // Build and play timeline
    const tl = gsap.timeline({ paused: true });

    const offscreen = this.position === 'left' ? -100 : 100;
    const layerStates = this.prelayerEls.map(el => ({ el, start: Number(gsap.getProperty(el, 'xPercent')) }));
    const panelStart = Number(gsap.getProperty(this.panel, 'xPercent'));

    if (this.itemEls.length) {
      gsap.set(this.itemEls, { yPercent: 140, rotate: 5 });
    }
    if (this.itemWraps.length) {
      gsap.set(this.itemWraps, { '--sm-num-opacity': 0 });
    }

    layerStates.forEach((ls, i) => {
      tl.fromTo(ls.el, { xPercent: ls.start }, { xPercent: 0, duration: 0.5, ease: 'power4.out' }, i * 0.07);
    });
    const lastTime = layerStates.length ? (layerStates.length - 1) * 0.07 : 0;
    const panelInsertTime = lastTime + 0.08;
    const panelDuration = 0.65;
    tl.fromTo(this.panel, { xPercent: panelStart }, { xPercent: 0, duration: panelDuration, ease: 'power4.out' }, panelInsertTime);

    if (this.itemEls.length) {
      const itemsStart = panelInsertTime + panelDuration * 0.15;
      tl.to(this.itemEls, { yPercent: 0, rotate: 0, duration: 1, ease: 'expo.out', stagger: 0.1 }, itemsStart);
      if (this.itemWraps.length) {
        tl.to(this.itemWraps, { duration: 0.6, ease: 'power2.out', '--sm-num-opacity': 1, stagger: 0.08 }, itemsStart + 0.1);
      }
    }

    if (this.socialTitleEl || this.socialLinkEls.length) {
      const socialsStart = panelInsertTime + panelDuration * 0.4;
      if (this.socialTitleEl) {
        tl.to(this.socialTitleEl, { opacity: 1, duration: 0.5, ease: 'power2.out' }, socialsStart);
      }
      if (this.socialLinkEls.length) {
        tl.to(this.socialLinkEls, { y: 0, opacity: 1, duration: 0.55, ease: 'power3.out', stagger: 0.08 }, socialsStart + 0.04);
      }
    }

    tl.eventCallback('onComplete', () => { this.busy = false; });
    tl.play();
  }

  close() {
    if (this.busy) return;
    this.busy = true;
    this.openRef = false;
    this.open = false;
    this.wrapper.removeAttribute('data-open');
    this.toggleBtn.setAttribute('aria-expanded', 'false');
    this.toggleBtn.setAttribute('aria-label', 'Open menu');
    
    // Remove backdrop blur
    this.wrapper.style.backdropFilter = 'blur(0px)';

    // Animate logo out
    gsap.to(this.logoDiv, { 
      opacity: 0, 
      y: -10, 
      duration: 0.3, 
      ease: 'power3.in',
      onComplete: () => { this.logoDiv.style.pointerEvents = 'none'; }
    });

    // Animate icon back
    gsap.to(this.icon, { rotate: 0, duration: 0.35, ease: 'power3.inOut', overwrite: 'auto' });

    // Animate text cycle back
    this.cycleText(this.textInner, ['Close', 'Menu']);

    // Disable color change if configured
    if (!this.changeMenuColorOnOpen) {
      gsap.set(this.toggleBtn, { color: this.menuButtonColor });
    } else {
      // Revert color
      gsap.to(this.toggleBtn, { color: this.menuButtonColor, duration: 0.3, ease: 'power2.in' });
    }

    // Close panel
    const all = [...this.prelayerEls, this.panel];
    const offscreen = this.position === 'left' ? -100 : 100;
    gsap.to(all, {
      xPercent: offscreen,
      duration: 0.32,
      ease: 'power3.in',
      overwrite: 'auto',
      onComplete: () => {
        if (this.itemEls.length) {
          gsap.set(this.itemEls, { yPercent: 140, rotate: 5 });
        }
        if (this.itemWraps.length) {
          gsap.set(this.itemWraps, { '--sm-num-opacity': 0 });
        }
        if (this.socialTitleEl) gsap.set(this.socialTitleEl, { opacity: 0 });
        if (this.socialLinkEls.length) gsap.set(this.socialLinkEls, { y: 25, opacity: 0 });
        this.busy = false;
        this.onClose();
      }
    });
  }

  cycleText(element, labels) {
    const cycles = 4;
    const seq = [labels[0]];
    let last = labels[0];
    for (let i = 0; i < cycles; i++) {
      last = last === 'Menu' ? 'Close' : 'Menu';
      seq.push(last);
    }
    if (last !== labels[1]) seq.push(labels[1]);
    
    // Clear and rebuild the element with the sequence
    element.innerHTML = '';
    seq.forEach(label => {
      const span = document.createElement('span');
      span.className = 'sm-toggle-line';
      span.style.display = 'block';
      span.textContent = label;
      element.appendChild(span);
    });

    gsap.set(element, { yPercent: 0 });
    const lineCount = seq.length;
    const finalShift = ((lineCount - 1) / lineCount) * 100;
    
    if (this.textCycleTween) this.textCycleTween.kill();
    this.textCycleTween = gsap.to(element, {
      yPercent: -finalShift,
      duration: 0.8,
      ease: 'expo.inOut'
    });
  }
}

// Auto-initialize if data attributes present
document.addEventListener('DOMContentLoaded', () => {
  const menuEl = document.getElementById('custom-menu');
  if (menuEl) {
    const items = JSON.parse(menuEl.dataset.items || '[]');
    const socialItems = JSON.parse(menuEl.dataset.social || '[]');
    const colors = JSON.parse(menuEl.dataset.colors || '["#0D0D0D", "#1A1A1A", "#B8860B"]');
    window.customMenu = new CustomMenu({
      items,
      socialItems,
      colors,
      menuButtonColor: menuEl.dataset.menuColor || '#fff',
      openMenuButtonColor: menuEl.dataset.openColor || '#fff',
      accentColor: menuEl.dataset.accent || '#D4AF37',
      onClose: () => {
        // optional callback
      }
    });
  }
});

export { CustomMenu };
