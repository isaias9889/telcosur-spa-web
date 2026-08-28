/**
 * TelcoSur — Animaciones corporativas
 * Ajustes: modifica --anim-* en css/animations.css
 */
(() => {
  const root = document.documentElement;
  const prefersReduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  root.classList.add("js-anim");

  const revealAll = () => {
    document.querySelectorAll(".reveal-on-scroll, .anim-hero__item, .anim-section, .corp-highlight-strip, .corp-trust-stats").forEach((element) => {
      element.classList.add("is-visible");
      element.querySelectorAll("article").forEach((child) => child.classList.add("is-visible"));
    });
    document.querySelectorAll(".anim-hero").forEach((hero) => hero.classList.add("is-ready"));
  };

  if (prefersReduced) {
    root.classList.add("anim-reduced");
    revealAll();
    return;
  }

  const assignStagger = (container) => {
    Array.from(container.children).forEach((child, index) => {
      if (!child.style.getPropertyValue("--anim-i")) {
        child.style.setProperty("--anim-i", String(index));
      }
    });
  };

  document.querySelectorAll(".anim-stagger").forEach(assignStagger);

  document.querySelectorAll(".corp-highlight-strip, .corp-trust-stats").forEach((strip) => {
    Array.from(strip.children).forEach((child, index) => {
      child.style.setProperty("--anim-i", String(index));
    });
  });

  const hero = document.querySelector(".anim-hero");
  if (hero) {
    requestAnimationFrame(() => {
      requestAnimationFrame(() => hero.classList.add("is-ready"));
    });
  }

  document.querySelectorAll(".corp-equipo-tema-hero.anim-hero").forEach((temaHero) => {
    requestAnimationFrame(() => {
      requestAnimationFrame(() => temaHero.classList.add("is-ready"));
    });
  });

  document.querySelectorAll(".corp-page-hero").forEach((pageHero) => {
    pageHero.classList.add("anim-hero", "is-ready");
    pageHero.querySelectorAll(".corp-page-hero-eyebrow, h1, .corp-page-hero-lead, .corp-page-hero-stats, .corp-page-hero-actions").forEach((item, index) => {
      item.classList.add("anim-hero__item");
      item.style.setProperty("--anim-i", String(index));
    });
  });

  const animateCounter = (element) => {
    const rawTarget = element.dataset.countTo;
    if (!rawTarget) {
      return;
    }

    const target = Number(rawTarget);
    if (Number.isNaN(target)) {
      return;
    }

    const suffix = element.dataset.countSuffix || "";
    const prefix = element.dataset.countPrefix || "";
    const duration = Number(element.dataset.countDuration || 1400);
    const start = performance.now();

    const tick = (now) => {
      const progress = Math.min((now - start) / duration, 1);
      const eased = 1 - (1 - progress) ** 3;
      const value = Math.round(target * eased);
      element.textContent = `${prefix}${value}${suffix}`;

      if (progress < 1) {
        requestAnimationFrame(tick);
      } else {
        element.textContent = `${prefix}${target}${suffix}`;
      }
    };

    element.textContent = `${prefix}0${suffix}`;
    requestAnimationFrame(tick);
  };

  const revealElement = (element) => {
    element.classList.add("is-visible");
    element.querySelectorAll("article").forEach((child) => child.classList.add("is-visible"));
    element.querySelectorAll(".reveal-on-scroll").forEach((child) => {
      if (child !== element) {
        child.classList.add("is-visible");
      }
    });

    element.querySelectorAll("[data-count-to]").forEach((counter) => {
      if (!counter.dataset.counted) {
        counter.dataset.counted = "true";
        animateCounter(counter);
      }
    });
  };

  const isInViewport = (element) => {
    const rect = element.getBoundingClientRect();
    return rect.top < window.innerHeight * 0.92 && rect.bottom > 0;
  };

  const revealTargets = document.querySelectorAll(
    ".reveal-on-scroll, .anim-section, .corp-highlight-strip, .corp-trust-stats, .interactive-map.reveal-on-scroll"
  );

  if (!("IntersectionObserver" in window)) {
    revealTargets.forEach(revealElement);
    return;
  }

  const revealObserver = new IntersectionObserver(
    (entries, observer) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) {
          return;
        }

        revealElement(entry.target);
        observer.unobserve(entry.target);
      });
    },
    { threshold: 0.08, rootMargin: "0px 0px -6% 0px" }
  );

  revealTargets.forEach((element) => {
    if (isInViewport(element)) {
      revealElement(element);
      return;
    }

    revealObserver.observe(element);
  });

  window.TelcoSurAnimations = {
    revealAll,
    assignStagger,
    animateCounter,
  };
})();
