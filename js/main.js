document.addEventListener("DOMContentLoaded", () => {
  const localSiteUrl = "http://localhost/Telcosur/";
  const openedAsFile = window.location.protocol === "file:";

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

  if (siteHeader && mobileMenuToggle && navbar) {
    const setMobileMenu = (isOpen) => {
      siteHeader.classList.toggle("menu-open", isOpen);
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
  const mapStage = document.getElementById("coverage-map-stage");
  const mapCanvas = document.getElementById("coverage-map-canvas");
  const mapInfo = document.getElementById("coverage-map-info");
  const mapMarkers = document.querySelectorAll(".map-marker");
  const officeChips = document.querySelectorAll("[data-office-city]");
  const mapControls = document.querySelectorAll("[data-map-zoom]");
  const mapReset = document.querySelector("[data-map-reset]");

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

  if (mapStage && mapCanvas) {
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

    const applyMapTransform = () => {
      mapCanvas.style.transform = `translate(${mapState.x}px, ${mapState.y}px) scale(${mapState.scale})`;
    };

    const setMapZoom = (nextScale) => {
      mapState.scale = clamp(nextScale, 1, 2.2);

      if (mapState.scale === 1) {
        mapState.x = 0;
        mapState.y = 0;
      }

      applyMapTransform();
    };

    const resetMap = () => {
      mapState.scale = 1;
      mapState.x = 0;
      mapState.y = 0;
      applyMapTransform();
    };

    mapControls.forEach((control) => {
      control.addEventListener("click", () => {
        const direction = control.dataset.mapZoom;
        setMapZoom(mapState.scale + (direction === "in" ? 0.2 : -0.2));
      });
    });

    if (mapReset) {
      mapReset.addEventListener("click", resetMap);
    }

    mapStage.addEventListener("pointerdown", (event) => {
      if (event.target.closest(".map-marker")) {
        return;
      }

      mapState.dragging = true;
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
      applyMapTransform();
    });

    const stopDragging = () => {
      mapState.dragging = false;
    };

    mapStage.addEventListener("pointerup", stopDragging);
    mapStage.addEventListener("pointercancel", stopDragging);
    mapStage.addEventListener("pointerleave", stopDragging);

    mapMarkers.forEach((marker) => {
      marker.addEventListener("click", () => {
        mapMarkers.forEach((item) => item.classList.remove("active"));
        marker.classList.add("active");

        officeChips.forEach((chip) => {
          chip.classList.toggle("active", chip.dataset.officeCity === marker.dataset.city);
        });

        if (mapInfo) {
          const city = marker.dataset.city || "Oficina seleccionada";
          const address = marker.dataset.address || "";
          const detail = marker.dataset.detail || "Oficina TelcoSur para trabajadores y coordinación comercial.";
          const addressMarkup = address ? `<p><strong>Dirección:</strong> ${address}</p>` : "";
          mapInfo.innerHTML = `
            <span>Oficina seleccionada</span>
            <h3>${city}</h3>
            <p>${detail}</p>
            ${addressMarkup}
            <a href="contacto.php" class="btn-primary">Consultar oficina</a>
          `;
        }

        if (planInterestInput) {
          planInterestInput.value = `Oficina TelcoSur en ${marker.dataset.city || "ciudad seleccionada"}`;
        }
      });
    });

    officeChips.forEach((chip) => {
      chip.addEventListener("click", () => {
        const marker = Array.from(mapMarkers).find((item) => item.dataset.city === chip.dataset.officeCity);

        if (marker) {
          marker.click();
          marker.scrollIntoView({ behavior: "smooth", block: "center", inline: "center" });
        }
      });
    });
  }

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
});
