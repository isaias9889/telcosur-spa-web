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

  const tabs = document.querySelectorAll(".tab[data-target]");
  const planCategories = document.querySelectorAll(".plan-category");

  if (tabs.length && planCategories.length) {
    const activateTab = (selectedTab) => {
      const targetId = selectedTab.dataset.target;
      const selectedCategory = document.getElementById(targetId);

      if (!targetId || !selectedCategory) {
        return;
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
    };

    tabs.forEach((tab) => {
      tab.addEventListener("click", () => activateTab(tab));
    });
  }

  const applicationForm = document.getElementById("postulacion-form");
  const applicationSuccess = document.getElementById("postulacion-success");
  const planInterestInput = document.getElementById("plan-interes");
  const planConsultationSection = document.getElementById("consulta-plan");

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
