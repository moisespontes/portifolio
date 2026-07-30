/* ==========================================================================
   DEVPONTES — SCRIPT PRINCIPAL
   JavaScript Vanilla, organizado em funções independentes.
   Índice:
   1. initNavbarScroll   -> efeito de vidro na navbar ao rolar
   2. initMobileMenu     -> abre/fecha o menu mobile
   3. initSmoothScroll   -> rolagem suave entre âncoras
   4. initScrollSpy      -> marca o link ativo do menu conforme a seção visível
   5. initScrollReveal   -> anima elementos ao entrarem na tela
   6. initSkillBars      -> anima as barras de habilidades quando visíveis
   7. initCounters       -> conta os números do card do herói
   8. initBackToTop      -> mostra/esconde botão de voltar ao topo
   9. initContactForm    -> validação simples do formulário de contato
   10. initFooterYear    -> atualiza o ano automaticamente
   ========================================================================== */

document.addEventListener('DOMContentLoaded', () => {
  initNavbarScroll();
  initMobileMenu();
  initSmoothScroll();
  initScrollSpy();
  initScrollReveal();
  initSkillBars();
  initCounters();
  initBackToTop();
  initContactForm();
  initFooterYear();
});

/**
 * 1. Adiciona a classe "scrolled" na navbar após rolar a página,
 * ativando o efeito de glassmorphism e reduzindo o padding.
 */
function initNavbarScroll() {
  const navbar = document.getElementById('navbar');
  if (!navbar) return;

  const toggleScrolled = () => {
    navbar.classList.toggle('scrolled', window.scrollY > 20);
  };

  toggleScrolled();
  window.addEventListener('scroll', toggleScrolled, { passive: true });
}

/**
 * 2. Controla a abertura/fechamento do menu mobile em tela cheia,
 * incluindo o botão "hambúrguer" animado e o fechamento ao clicar num link.
 */
function initMobileMenu() {
  const toggleBtn = document.getElementById('menuToggle');
  const mobileMenu = document.getElementById('mobileMenu');
  if (!toggleBtn || !mobileMenu) return;

  const closeMenu = () => {
    toggleBtn.classList.remove('open');
    mobileMenu.classList.remove('open');
    toggleBtn.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  };

  const openMenu = () => {
    toggleBtn.classList.add('open');
    mobileMenu.classList.add('open');
    toggleBtn.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  };

  toggleBtn.addEventListener('click', () => {
    const isOpen = mobileMenu.classList.contains('open');
    isOpen ? closeMenu() : openMenu();
  });

  mobileMenu.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', closeMenu);
  });
}

/**
 * 3. Rolagem suave para todas as âncoras internas (links que começam com #),
 * considerando a altura da navbar fixa.
 */
function initSmoothScroll() {
  const links = document.querySelectorAll('a[href^="#"]');

  links.forEach((link) => {
    link.addEventListener('click', (event) => {
      const targetId = link.getAttribute('href');
      if (targetId.length <= 1) return;

      const targetEl = document.querySelector(targetId);
      if (!targetEl) return;

      event.preventDefault();
      targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });
}

/**
 * 4. Observa as seções da página e marca o link correspondente
 * no menu como "active" conforme o usuário rola a tela (scrollspy).
 */
function initScrollSpy() {
  const sections = document.querySelectorAll('main section[id]');
  const navLinks = document.querySelectorAll('.nav-links a');
  if (!sections.length || !navLinks.length) return;

  const setActiveLink = (id) => {
    navLinks.forEach((link) => {
      link.classList.toggle('active', link.getAttribute('href') === `#${id}`);
    });
  };

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          setActiveLink(entry.target.id);
        }
      });
    },
    { rootMargin: '-45% 0px -50% 0px', threshold: 0 }
  );

  sections.forEach((section) => observer.observe(section));
}

/**
 * 5. Revela elementos com a classe .reveal suavemente conforme
 * entram no viewport, usando IntersectionObserver (leve e performático).
 */
function initScrollReveal() {
  const revealEls = document.querySelectorAll('.reveal');
  if (!revealEls.length) return;

  const observer = new IntersectionObserver(
    (entries, obs) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          obs.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.15 }
  );

  revealEls.forEach((el) => observer.observe(el));
}

/**
 * 6. Anima o preenchimento das barras de habilidades (skills)
 * apenas quando a seção se torna visível na tela.
 */
function initSkillBars() {
  const bars = document.querySelectorAll('.skill-bar__fill');
  if (!bars.length) return;

  const observer = new IntersectionObserver(
    (entries, obs) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const fill = entry.target;
          const width = fill.getAttribute('data-width') || 0;
          fill.style.width = `${width}%`;
          obs.unobserve(fill);
        }
      });
    },
    { threshold: 0.4 }
  );

  bars.forEach((bar) => observer.observe(bar));
}

/**
 * 7. Faz a contagem numérica dos indicadores dentro do card
 * do herói (anos de experiência, projetos, uptime) quando visíveis.
 */
function initCounters() {
  const counters = document.querySelectorAll('[data-counter]');
  if (!counters.length) return;

  const animateCounter = (el) => {
    const target = parseInt(el.getAttribute('data-counter'), 10) || 0;
    const duration = 1400;
    const startTime = performance.now();

    const step = (now) => {
      const progress = Math.min((now - startTime) / duration, 1);
      const value = Math.floor(progress * target);
      el.textContent = value;
      if (progress < 1) {
        requestAnimationFrame(step);
      } else {
        el.textContent = target;
      }
    };

    requestAnimationFrame(step);
  };

  const observer = new IntersectionObserver(
    (entries, obs) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          obs.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.6 }
  );

  counters.forEach((counter) => observer.observe(counter));
}

/**
 * 8. Exibe o botão "voltar ao topo" após certa rolagem
 * e faz a página rolar suavemente até o início ao clicar.
 */
function initBackToTop() {
  const btn = document.getElementById('backToTop');
  if (!btn) return;

  const toggleVisibility = () => {
    btn.classList.toggle('visible', window.scrollY > 500);
  };

  toggleVisibility();
  window.addEventListener('scroll', toggleVisibility, { passive: true });

  btn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

/**
 * 9. Valida o formulário de contato no lado do cliente (sem back-end).
 * Mostra mensagens de erro específicas por campo e uma mensagem
 * de status de sucesso ao final, simulando o envio.
 */
function initContactForm() {
  const form = document.getElementById('contactForm');
  const statusEl = document.getElementById('formStatus');
  if (!form) return;

  const rules = {
    name: (value) => value.trim().length >= 3 || 'Informe seu nome completo.',
    email: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) || 'Informe um e-mail válido.',
    subject: (value) => value.trim().length >= 3 || 'Conte o assunto em poucas palavras.',
    message: (value) => value.trim().length >= 10 || 'Escreva uma mensagem com pelo menos 10 caracteres.',
  };

  const showError = (field, message) => {
    const errorEl = form.querySelector(`[data-error-for="${field}"]`);
    if (errorEl) errorEl.textContent = message || '';
  };

  const validateField = (field) => {
    const input = form.querySelector(`#${field}`);
    if (!input) return true;

    const result = rules[field](input.value);
    const isValid = result === true;
    showError(field, isValid ? '' : result);
    return isValid;
  };

  // Valida em tempo real ao sair do campo
  Object.keys(rules).forEach((field) => {
    const input = form.querySelector(`#${field}`);
    if (input) {
      input.addEventListener('blur', () => validateField(field));
    }
  });

  form.addEventListener('submit', (event) => {
    event.preventDefault();

    const isFormValid = Object.keys(rules)
      .map((field) => validateField(field))
      .every(Boolean);

    if (!isFormValid) {
      statusEl.textContent = 'Verifique os campos destacados antes de enviar.';
      statusEl.style.color = '#ff6b6b';
      return;
    }

    // Simulação de envio (sem back-end configurado neste template)
    statusEl.style.color = 'var(--color-orange)';
    statusEl.textContent = 'Enviando mensagem...';

    setTimeout(() => {
      statusEl.textContent = 'Mensagem enviada com sucesso! Retornarei em breve.';
      form.reset();
    }, 900);
  });
}

/**
 * 10. Atualiza automaticamente o ano exibido no rodapé.
 */
function initFooterYear() {
  const yearEl = document.getElementById('year');
  if (yearEl) {
    yearEl.textContent = new Date().getFullYear();
  }
}
