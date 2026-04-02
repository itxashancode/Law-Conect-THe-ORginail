/**
 * BounceCards - Interactive overlapping card carousel with GSAP
 * Inspired by reactbits.dev BounceCards component
 */

class BounceCards {
  constructor(container, options = {}) {
    this.container = container;
    this.options = {
      images: options.images || [],
      containerWidth: options.containerWidth || 400,
      containerHeight: options.containerHeight || 400,
      animationDelay: options.animationDelay || 0.5,
      animationStagger: options.animationStagger || 0.06,
      easeType: options.easeType || 'elastic.out(1, 0.8)',
      transformStyles: options.transformStyles || [
        'rotate(10deg) translate(-170px)',
        'rotate(5deg) translate(-85px)',
        'rotate(-3deg)',
        'rotate(-10deg) translate(85px)',
        'rotate(2deg) translate(170px)'
      ],
      enableHover: options.enableHover !== undefined ? options.enableHover : true
    };

    this.cards = [];
    this.init();
  }

  init() {
    if (!this.container || !this.options.images.length) return;

    // Set container dimensions
    this.container.style.width = this.options.containerWidth + 'px';
    this.container.style.height = this.options.containerHeight + 'px';
    this.container.style.position = 'relative';
    this.container.style.margin = '0 auto';

    // Create cards
    this.options.images.forEach((src, idx) => {
      const card = document.createElement('div');
      card.className = `card card-${idx}`;
      card.style.position = 'absolute';
      card.style.top = '50%';
      card.style.left = '50%';
      card.style.width = '200px';
      card.style.height = '280px';
      card.style.marginTop = '-140px';
      card.style.marginLeft = '-100px';
      card.style.transform = this.options.transformStyles[idx] || 'none';
      card.style.transition = 'transform 0.4s cubic-bezier(0.87, 0, 0.13, 1)';
      card.style.zIndex = idx + 1;
      card.style.overflow = 'hidden';
      card.style.borderRadius = '0.75rem';
      card.style.boxShadow = '0 10px 30px -5px rgba(212, 175, 55, 0.15), 0 0 0 1px rgba(212, 175, 55, 0.05)';
      card.style.cursor = this.options.enableHover ? 'pointer' : 'default';
      card.style.background = '#fff';

      const img = document.createElement('img');
      img.src = src;
      img.className = 'image';
      img.style.width = '100%';
      img.style.height = '100%';
      img.style.objectFit = 'cover';
      img.style.pointerEvents = 'none';

      card.appendChild(img);
      this.container.appendChild(card);
      this.cards.push(card);

      if (this.options.enableHover) {
        card.addEventListener('mouseenter', () => this.onMouseEnter(idx));
        card.addEventListener('mouseleave', () => this.onMouseLeave());
      }
    });

    // Entrance animation
    this.playEntranceAnimation();
  }

  playEntranceAnimation() {
    // Use GSAP if available
    if (typeof gsap !== 'undefined') {
      gsap.fromTo(this.cards,
        { scale: 0 },
        {
          scale: 1,
          stagger: this.options.animationStagger,
          ease: this.options.easeType,
          delay: this.options.animationDelay,
          duration: 1
        }
      );
    } else {
      // Fallback: simple CSS animation
      this.cards.forEach((card, idx) => {
        card.style.opacity = '0';
        card.style.transform = this.options.transformStyles[idx] + ' scale(0)';
        setTimeout(() => {
          card.style.transition = 'all 1s cubic-bezier(0.87, 0, 0.13, 1)';
          card.style.opacity = '1';
          card.style.transform = this.options.transformStyles[idx] + ' scale(1)';
        }, this.options.animationDelay * 1000 + idx * this.options.animationStagger * 1000);
      });
    }
  }

  onMouseEnter(hoveredIdx) {
    if (!this.options.enableHover) return;

    this.cards.forEach((card, idx) => {
      const baseTransform = this.options.transformStyles[idx] || 'none';

      if (idx === hoveredIdx) {
        // Remove rotation from hovered card
        const noRotation = this.removeRotation(baseTransform);
        if (typeof gsap !== 'undefined') {
          gsap.to(card, {
            transform: noRotation,
            duration: 0.4,
            ease: 'back.out(1.4)',
            overwrite: 'auto'
          });
        } else {
          card.style.transform = noRotation;
        }
      } else {
        // Push siblings away
        const offsetX = idx < hoveredIdx ? -160 : 160;
        const pushed = this.addTranslate(baseTransform, offsetX);
        if (typeof gsap !== 'undefined') {
          const distance = Math.abs(hoveredIdx - idx);
          gsap.to(card, {
            transform: pushed,
            duration: 0.4,
            ease: 'back.out(1.4)',
            delay: distance * 0.05,
            overwrite: 'auto'
          });
        } else {
          card.style.transform = pushed;
        }
      }
    });
  }

  onMouseLeave() {
    if (!this.options.enableHover) return;

    this.cards.forEach((card, idx) => {
      const baseTransform = this.options.transformStyles[idx] || 'none';
      if (typeof gsap !== 'undefined') {
        gsap.to(card, {
          transform: baseTransform,
          duration: 0.4,
          ease: 'back.out(1.4)',
          overwrite: 'auto'
        });
      } else {
        card.style.transform = baseTransform;
      }
    });
  }

  removeRotation(transformStr) {
    if (transformStr === 'none') return 'rotate(0deg)';
    return transformStr.replace(/rotate\([\s\S]*?\)/, 'rotate(0deg)');
  }

  addTranslate(transformStr, offsetX) {
    const translateRegex = /translate\(([-0-9.]+)px\)/;
    const match = transformStr.match(translateRegex);
    if (match) {
      const currentX = parseFloat(match[1]);
      const newX = currentX + offsetX;
      return transformStr.replace(translateRegex, `translate(${newX}px)`);
    } else {
      if (transformStr === 'none') {
        return `translate(${offsetX}px)`;
      }
      return `${transformStr} translate(${offsetX}px)`;
    }
  }

  destroy() {
    this.container.innerHTML = '';
    this.cards = [];
  }
}

window.BounceCards = BounceCards;
