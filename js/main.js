document.addEventListener("DOMContentLoaded", () => {
  const localSiteUrl = "http://localhost/telcosur-spa-web/";
  const openedAsFile = window.location.protocol === "file:";

  const protectedForms = document.querySelectorAll(
    'form[action="consulta-plan.php"], form[action="postular.php"], form[action="contacto-enviar.php"], form[action="admin-login.php"]'
  );

  const appendCsrfToken = (token) => {
    protectedForms.forEach((form) => {
      if (form.querySelector('input[name="csrf_token"]')) {
        return;
      }

      const input = document.createElement("input");
      input.type = "hidden";
      input.name = "csrf_token";
      input.value = token;
      form.prepend(input);
    });
  };

  if (protectedForms.length > 0 && !openedAsFile) {
    fetch("csrf-token.php", {
      credentials: "same-origin",
      headers: {
        Accept: "application/json",
      },
    })
      .then((response) => (response.ok ? response.json() : null))
      .then((data) => {
        if (data?.token) {
          appendCsrfToken(data.token);
        }
      })
      .catch(() => {});
  }

  if (openedAsFile) {
    const warning = document.createElement("div");
    warning.style.cssText = [
      "position: fixed",
      "left: 16px",
      "right: 16px",
      "top: 16px",
      "z-index: 9999",
      "padding: 14px 18px",
      "border-radius: 12px",
      "background: #071a3d",
      "color: #ffffff",
      "font-weight: 800",
      "box-shadow: 0 14px 38px rgba(0, 34, 80, 0.24)",
      "text-align: center",
    ].join(";");
    warning.innerHTML = `Para guardar datos en MySQL abre el sitio desde <a href="${localSiteUrl}" style="color:#ffe600;">${localSiteUrl}</a>. Si lo abres como archivo, PHP no se ejecuta.`;
    document.body.appendChild(warning);

    const planForm = document.getElementById("consulta-plan-form");
    const applicationFormFileMode = document.getElementById("postulacion-form");

    if (planForm) {
      planForm.action = `${localSiteUrl}consulta-plan.php`;
    }

    if (applicationFormFileMode) {
      applicationFormFileMode.action = `${localSiteUrl}postular.php`;
    }
  }

  const siteHeader = document.querySelector(".header");
  const mobileMenuToggle = document.querySelector(".mobile-menu-toggle");
  const navbar = document.querySelector(".navbar");

  const homeHeader = document.querySelector(".sl-home .header--sl");
  if (homeHeader && document.body.classList.contains("sl-home")) {
    document.body.classList.add("header-has-fixed-nav");

    const updateHomeHeaderState = () => {
      const isScrolled = window.scrollY > 40;
      homeHeader.classList.toggle("header-is-scrolled", isScrolled);
      document.body.classList.toggle("header-is-scrolled-active", isScrolled);
    };

    updateHomeHeaderState();
    window.addEventListener("scroll", updateHomeHeaderState, { passive: true });
  } else if (siteHeader) {
    const updateHeaderState = () => {
      siteHeader.classList.toggle("header-is-scrolled", window.scrollY > 24);
    };
    updateHeaderState();
    window.addEventListener("scroll", updateHeaderState, { passive: true });
  }

  if (siteHeader && mobileMenuToggle && navbar) {
    const setMobileMenu = (isOpen) => {
      siteHeader.classList.toggle("menu-open", isOpen);
      document.body.classList.toggle("mobile-menu-open", isOpen);
      mobileMenuToggle.setAttribute("aria-expanded", String(isOpen));
      mobileMenuToggle.setAttribute("aria-label", isOpen ? "Cerrar menú" : "Abrir menú");
    };

    mobileMenuToggle.addEventListener("click", () => {
      setMobileMenu(!siteHeader.classList.contains("menu-open"));
    });

    navbar.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => setMobileMenu(false));
    });

    document.addEventListener("click", (event) => {
      if (!siteHeader.contains(event.target)) {
        setMobileMenu(false);
      }
    });

    document.addEventListener("keydown", (event) => {
      if (event.key === "Escape" && siteHeader.classList.contains("menu-open")) {
        setMobileMenu(false);
        mobileMenuToggle.focus();
      }
    });
  }
  const tabs = document.querySelectorAll(".tab[data-target]");
  const planCategories = document.querySelectorAll(".plan-category");

  if (tabs.length && planCategories.length) {
    const activateTab = (selectedTab) => {
      const targetId = selectedTab.dataset.target;
      const selectedCategory = document.getElementById(targetId);

      if (!targetId || !selectedCategory) {
        return null;
      }

      tabs.forEach((tab) => {
        const isActive = tab === selectedTab;
        tab.classList.toggle("active", isActive);
        tab.setAttribute("aria-selected", String(isActive));
      });

      planCategories.forEach((category) => {
        const isActive = category.id === targetId;
        category.classList.toggle("active", isActive);
        category.hidden = !isActive;
      });

      return selectedCategory;
    };

    const activateTabById = (targetId, shouldScroll = false) => {
      const selectedTab = Array.from(tabs).find((tab) => tab.dataset.target === targetId);
      const selectedCategory = selectedTab ? activateTab(selectedTab) : null;

      if (selectedCategory && shouldScroll) {
        const scrollTarget = document.querySelector(".plan-tabs") || selectedCategory;
        scrollTarget.scrollIntoView({ behavior: "smooth", block: "start" });
      }

      return selectedCategory;
    };

    const getPlanHashTarget = () => {
      const hashTarget = decodeURIComponent(window.location.hash.replace("#", ""));
      return Array.from(planCategories).some((category) => category.id === hashTarget) ? hashTarget : "";
    };

    tabs.forEach((tab) => {
      tab.addEventListener("click", () => activateTab(tab));
    });

    document.querySelectorAll('[data-plan-jump], a[href="#solo-internet"], a[href="#internet-tv"], a[href="#streaming"]').forEach((link) => {
      link.addEventListener("click", (event) => {
        const targetId = link.dataset.planJump || link.getAttribute("href")?.replace("#", "");

        if (!targetId) {
          return;
        }

        event.preventDefault();
        window.history.pushState(null, "", `#${targetId}`);
        activateTabById(targetId, true);
      });
    });

    const initialPlanTarget = getPlanHashTarget();

    if (initialPlanTarget) {
      setTimeout(() => activateTabById(initialPlanTarget, true), 80);
    }

    window.addEventListener("hashchange", () => {
      const nextPlanTarget = getPlanHashTarget();

      if (nextPlanTarget) {
        activateTabById(nextPlanTarget, true);
      }
    });
  }
  const applicationForm = document.getElementById("postulacion-form");
  const applicationSuccess = document.getElementById("postulacion-success");
  const roleSelectInput = document.getElementById("cargo-interes");
  const roleSelectButtons = document.querySelectorAll("[data-role-select]");
  const planInterestInput = document.getElementById("plan-interes");
  const planConsultationSection = document.getElementById("consulta-plan");

  document.querySelectorAll(".interactive-map").forEach((mapRoot) => {
    const mapStage = mapRoot.querySelector("[data-map-stage]");
    const mapCanvas = mapRoot.querySelector("[data-map-canvas]");
    const mapInfo = mapRoot.querySelector("[data-map-info]");
    const mapMarkers = mapRoot.querySelectorAll(".map-marker");
    const officeChips = mapRoot.querySelectorAll("[data-office-city]");
    const mapControls = mapRoot.querySelectorAll("[data-map-zoom]");
    const mapReset = mapRoot.querySelector("[data-map-reset]");

    if (!mapStage || !mapCanvas) {
      return;
    }

    const mapState = {
      scale: 1,
      x: 0,
      y: 0,
      dragging: false,
      startX: 0,
      startY: 0,
      originX: 0,
      originY: 0,
    };

    const clamp = (value, min, max) => Math.min(Math.max(value, min), max);

    const clampPan = () => {
      const maxPan = 120 * mapState.scale;
      mapState.x = clamp(mapState.x, -maxPan, maxPan);
      mapState.y = clamp(mapState.y, -maxPan, maxPan);
    };

    const applyMapTransform = (animate = false) => {
      mapCanvas.classList.toggle("is-animating", animate);
      mapCanvas.style.transform = `translate(${mapState.x}px, ${mapState.y}px) scale(${mapState.scale})`;
    };

    const setMapZoom = (nextScale, animate = false) => {
      mapState.scale = clamp(nextScale, 1, 2.6);

      if (mapState.scale === 1) {
        mapState.x = 0;
        mapState.y = 0;
      } else {
        clampPan();
      }

      applyMapTransform(animate);
    };

    const focusMarker = (marker, animate = true) => {
      const stageRect = mapStage.getBoundingClientRect();
      const markerRect = marker.getBoundingClientRect();
      const canvasRect = mapCanvas.getBoundingClientRect();

      const markerCenterX = markerRect.left + markerRect.width / 2 - canvasRect.left;
      const markerCenterY = markerRect.top + markerRect.height / 2 - canvasRect.top;
      const stageCenterX = stageRect.width / 2;
      const stageCenterY = stageRect.height / 2;

      const targetScale = clamp(Math.max(mapState.scale, 1.35), 1, 2.6);
      mapState.scale = targetScale;
      mapState.x += (stageCenterX - markerCenterX) * 0.85;
      mapState.y += (stageCenterY - markerCenterY) * 0.85;
      clampPan();
      applyMapTransform(animate);
    };

    const buildMapsUrl = (city, address) => {
      const query = encodeURIComponent(`${address}, ${city}, Chile`);
      return `https://www.google.com/maps/search/?api=1&query=${query}`;
    };

    const renderMapInfo = (marker) => {
      if (!mapInfo) {
        return;
      }

      const city = marker.dataset.city || "Oficina seleccionada";
      const address = marker.dataset.address || "";
      const detail = marker.dataset.detail || "Oficina TelcoSur para trabajadores y coordinación comercial.";
      const index = marker.dataset.index || "";
      const mapsUrl = address ? buildMapsUrl(city, address) : "contacto.php";

      mapInfo.classList.remove("is-updating");
      void mapInfo.offsetWidth;
      mapInfo.classList.add("is-updating");
      mapInfo.innerHTML = `
        <div class="map-info-selected">
          <span class="map-info-label">Oficina ${index ? `#${index}` : "seleccionada"}</span>
          <h3>${city}</h3>
          <p>${detail}</p>
          ${address ? `<p class="map-info-address"><strong>Dirección:</strong> ${address}</p>` : ""}
          <div class="map-info-actions">
            <a href="contacto.php" class="sl-btn-primary sl-btn-sm">Consultar oficina</a>
            ${address ? `<a href="${mapsUrl}" class="sl-btn-outline sl-btn-sm map-info-maps" target="_blank" rel="noopener">Ver en Google Maps</a>` : ""}
            ${address ? `<button type="button" class="map-info-copy sl-btn-ghost-sm">Copiar dirección</button>` : ""}
          </div>
        </div>
      `;

      const copyBtn = mapInfo.querySelector(".map-info-copy");
      if (copyBtn && address) {
        copyBtn.addEventListener("click", async () => {
          try {
            await navigator.clipboard.writeText(address);
            copyBtn.textContent = "Copiado";
            setTimeout(() => {
              copyBtn.textContent = "Copiar dirección";
            }, 1800);
          } catch {
            copyBtn.textContent = "No se pudo copiar";
          }
        });
      }
    };

    const selectMarker = (marker, { focus = true, scroll = false } = {}) => {
      mapMarkers.forEach((item) => item.classList.remove("active"));
      marker.classList.add("active");

      officeChips.forEach((chip) => {
        chip.classList.toggle("active", chip.dataset.officeCity === marker.dataset.city);
      });

      renderMapInfo(marker);

      if (focus) {
        requestAnimationFrame(() => focusMarker(marker, true));
      }

      if (scroll) {
        mapStage.scrollIntoView({ behavior: "smooth", block: "center" });
      }

      if (planInterestInput) {
        planInterestInput.value = `Oficina TelcoSur en ${marker.dataset.city || "ciudad seleccionada"}`;
      }
    };

    const resetMap = () => {
      mapState.scale = 1;
      mapState.x = 0;
      mapState.y = 0;
      applyMapTransform(true);
      mapMarkers.forEach((item) => item.classList.remove("active"));
      officeChips.forEach((chip) => chip.classList.remove("active"));

      if (mapInfo) {
        mapInfo.classList.remove("is-updating");
        mapInfo.innerHTML = mapInfo.dataset.initialHtml || "";
      }
    };

    if (mapInfo && !mapInfo.dataset.initialHtml) {
      mapInfo.dataset.initialHtml = mapInfo.innerHTML;
    }

    mapControls.forEach((control) => {
      control.addEventListener("click", () => {
        const direction = control.dataset.mapZoom;
        setMapZoom(mapState.scale + (direction === "in" ? 0.25 : -0.25), true);
      });
    });

    if (mapReset) {
      mapReset.addEventListener("click", resetMap);
    }

    mapStage.addEventListener(
      "wheel",
      (event) => {
        event.preventDefault();
        const delta = event.deltaY > 0 ? -0.12 : 0.12;
        setMapZoom(mapState.scale + delta, false);
      },
      { passive: false }
    );

    mapStage.addEventListener("pointerdown", (event) => {
      if (event.target.closest(".map-marker")) {
        return;
      }

      mapState.dragging = true;
      mapCanvas.classList.remove("is-animating");
      mapState.startX = event.clientX;
      mapState.startY = event.clientY;
      mapState.originX = mapState.x;
      mapState.originY = mapState.y;
      mapStage.setPointerCapture(event.pointerId);
    });

    mapStage.addEventListener("pointermove", (event) => {
      if (!mapState.dragging) {
        return;
      }

      mapState.x = mapState.originX + event.clientX - mapState.startX;
      mapState.y = mapState.originY + event.clientY - mapState.startY;
      clampPan();
      applyMapTransform(false);
    });

    const stopDragging = () => {
      mapState.dragging = false;
    };

    mapStage.addEventListener("pointerup", stopDragging);
    mapStage.addEventListener("pointercancel", stopDragging);
    mapStage.addEventListener("pointerleave", stopDragging);

    mapMarkers.forEach((marker) => {
      marker.addEventListener("click", (event) => {
        event.stopPropagation();
        selectMarker(marker, { focus: true, scroll: false });
      });
    });

    officeChips.forEach((chip) => {
      chip.addEventListener("click", () => {
        const marker = Array.from(mapMarkers).find((item) => item.dataset.city === chip.dataset.officeCity);
        if (marker) {
          selectMarker(marker, { focus: true, scroll: true });
        }
      });
    });
  });

  const whatsappConfig = {
    number: "56963719919",
    messages: {
      default: "Hola TelcoSur SPA, quisiera hacer una consulta.",
      plan: (planName) => `Hola TelcoSur SPA, quisiera consultar sobre el plan ${planName}.`,
      application: "Hola TelcoSur SPA, quiero postular para vender con ustedes.",
    },
  };

  const buildWhatsappUrl = (message) => {
    return `https://wa.me/${whatsappConfig.number}?text=${encodeURIComponent(message)}`;
  };

  const setupWhatsappLink = (link, message) => {
    if (!link) {
      return;
    }

    link.href = buildWhatsappUrl(message || whatsappConfig.messages.default);
    link.target = "_blank";
    link.rel = "noopener";
  };

  const whatsappLinks = document.querySelectorAll("[data-whatsapp-message]");

  whatsappLinks.forEach((link) => {
    setupWhatsappLink(link, link.dataset.whatsappMessage);
  });

  const planButtons = document.querySelectorAll(".plan-btn");

  planButtons.forEach((button) => {
    const planCard = button.closest(".plan-card");
    const planName = planCard?.querySelector("h3")?.textContent.trim();
    const planSpeed = planCard?.querySelector("strong")?.textContent.trim();
    const planType = planCard?.querySelector("span")?.textContent.trim();
    const planPrice = planCard?.querySelector("p b")?.textContent.trim();

    if (!planName) {
      return;
    }

    const planLabel = [
      planName,
      planSpeed && planType ? `${planSpeed} ${planType}` : "",
      planPrice ? `desde ${planPrice} /mes` : "",
    ].filter(Boolean).join(" - ");

    button.href = "#consulta-plan";
    button.addEventListener("click", () => {
      if (planInterestInput) {
        planInterestInput.value = planLabel;
      }

      if (planConsultationSection) {
        planConsultationSection.scrollIntoView({ behavior: "smooth", block: "start" });
      }
    });
  });

  roleSelectButtons.forEach((button) => {
    button.addEventListener("click", () => {
      if (roleSelectInput && button.dataset.roleSelect) {
        roleSelectInput.value = button.dataset.roleSelect;
      }
    });
  });

  const getFieldValue = (formData, fieldName) => {
    return String(formData.get(fieldName) || "").trim();
  };

  const buildWhatsappMessage = (formData) => {
    const messageLines = [
      whatsappConfig.messages.application,
      "",
      `Nombre: ${getFieldValue(formData, "nombre")}`,
      `RUT: ${getFieldValue(formData, "rut")}`,
      `Telefono: ${getFieldValue(formData, "telefono")}`,
      `Correo: ${getFieldValue(formData, "correo")}`,
      `Comuna o ciudad: ${getFieldValue(formData, "comuna")}`,
      `Cargo de interes: ${getFieldValue(formData, "cargo")}`,
      `Experiencia en ventas: ${getFieldValue(formData, "experiencia")}`,
      `Disponibilidad: ${getFieldValue(formData, "disponibilidad")}`,
      `Mensaje: ${getFieldValue(formData, "mensaje") || "Sin mensaje adicional"}`,
    ];

    return messageLines.join("\n");
  };

  if (applicationForm && applicationSuccess) {
    applicationForm.addEventListener("submit", (event) => {
      const submitter = event.submitter;
      const channel = submitter?.value || "correo";

      if (channel !== "whatsapp") {
        return;
      }

      event.preventDefault();

      if (!applicationForm.checkValidity()) {
        applicationForm.reportValidity();
        return;
      }

      const formData = new FormData(applicationForm);
      const message = buildWhatsappMessage(formData);
      window.open(buildWhatsappUrl(message), "_blank");

      applicationSuccess.hidden = false;
      applicationSuccess.scrollIntoView({ behavior: "smooth", block: "center" });
    });
  }

  const cookieBanner = document.getElementById("cookie-banner");
  const cookieAccept = document.getElementById("cookie-accept");
  const cookieKey = "telcosur-cookie-ok";

  if (cookieBanner && cookieAccept) {
    if (!localStorage.getItem(cookieKey)) {
      cookieBanner.hidden = false;
    }

    cookieAccept.addEventListener("click", () => {
      localStorage.setItem(cookieKey, "1");
      cookieBanner.hidden = true;
    });
  }

  document.querySelectorAll(".floating-whatsapp.contact-link").forEach((link) => {
    setupWhatsappLink(link, link.dataset.whatsappMessage || whatsappConfig.messages.default);
  });

  const photoLightbox = document.getElementById("photo-lightbox");
  const photoTriggers = document.querySelectorAll("[data-photo-lightbox]");
  if (photoLightbox && photoTriggers.length > 0) {
    const lightboxImg = photoLightbox.querySelector(".photo-lightbox__img");
    const lightboxCaption = photoLightbox.querySelector(".photo-lightbox__caption");
    const closeButtons = photoLightbox.querySelectorAll("[data-photo-lightbox-close]");
    const prevButton = photoLightbox.querySelector("[data-photo-lightbox-prev]");
    const nextButton = photoLightbox.querySelector("[data-photo-lightbox-next]");
    const photos = Array.from(photoTriggers).map((trigger) => ({
      src: trigger.dataset.photoSrc || "",
      alt: trigger.dataset.photoAlt || "",
    }));
    let activeIndex = 0;
    let lastFocused = null;

    const renderPhoto = (index) => {
      const photo = photos[index];
      if (!photo || !lightboxImg) {
        return;
      }

      activeIndex = index;
      lightboxImg.src = photo.src;
      lightboxImg.alt = photo.alt;
      if (lightboxCaption) {
        lightboxCaption.textContent = photo.alt;
      }
    };

    const openLightbox = (index) => {
      lastFocused = document.activeElement;
      renderPhoto(index);
      photoLightbox.hidden = false;
      document.body.style.overflow = "hidden";
      photoLightbox.querySelector(".photo-lightbox__close")?.focus();
    };

    const closeLightbox = () => {
      photoLightbox.hidden = true;
      document.body.style.overflow = "";
      if (lightboxImg) {
        lightboxImg.removeAttribute("src");
      }
      if (lastFocused instanceof HTMLElement) {
        lastFocused.focus();
      }
    };

    photoTriggers.forEach((trigger) => {
      trigger.addEventListener("click", () => {
        const index = Number.parseInt(trigger.dataset.photoIndex || "0", 10);
        openLightbox(Number.isNaN(index) ? 0 : index);
      });
    });

    closeButtons.forEach((button) => {
      button.addEventListener("click", closeLightbox);
    });

    prevButton?.addEventListener("click", () => {
      const nextIndex = (activeIndex - 1 + photos.length) % photos.length;
      renderPhoto(nextIndex);
    });

    nextButton?.addEventListener("click", () => {
      const nextIndex = (activeIndex + 1) % photos.length;
      renderPhoto(nextIndex);
    });

    photoLightbox.addEventListener("keydown", (event) => {
      if (photoLightbox.hidden) {
        return;
      }

      if (event.key === "Escape") {
        event.preventDefault();
        closeLightbox();
      }

      if (event.key === "ArrowLeft") {
        event.preventDefault();
        const nextIndex = (activeIndex - 1 + photos.length) % photos.length;
        renderPhoto(nextIndex);
      }

      if (event.key === "ArrowRight") {
        event.preventDefault();
        const nextIndex = (activeIndex + 1) % photos.length;
        renderPhoto(nextIndex);
      }
    });
  }
});

// Mejoras de interfaz: botón volver arriba y parallax del hero.
document.addEventListener("DOMContentLoaded", () => {
  const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  // Botón "volver arriba".
  const backToTop = document.querySelector(".back-to-top");
  if (backToTop) {
    const toggleBackToTop = () => {
      if (window.scrollY > 600) {
        backToTop.hidden = false;
        backToTop.classList.add("is-visible");
      } else {
        backToTop.classList.remove("is-visible");
      }
    };
    toggleBackToTop();
    window.addEventListener("scroll", toggleBackToTop, { passive: true });
    backToTop.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: reducedMotion ? "auto" : "smooth" });
    });
  }

  // Parallax sutil de la imagen del hero.
  const heroMedia = document.querySelector(".sl-hero-media");
  if (heroMedia && !reducedMotion) {
    let ticking = false;
    const applyParallax = () => {
      const offset = Math.min(window.scrollY, 600);
      heroMedia.style.transform = "translate3d(0," + offset * 0.18 + "px,0) scale(1.05)";
      ticking = false;
    };
    window.addEventListener(
      "scroll",
      () => {
        if (!ticking) {
          window.requestAnimationFrame(applyParallax);
          ticking = true;
        }
      },
      { passive: true }
    );
    applyParallax();
  }
});
