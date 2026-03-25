// ------------------------------------------------
// Engagement Modal
// ------------------------------------------------
(function () {
    const modal       = document.getElementById('engagement-modal');
    const backdrop    = document.getElementById('modal-backdrop');
    const closeBtn    = document.getElementById('modal-close');
    const step1       = document.getElementById('modal-step-1');
    const step2       = document.getElementById('modal-step-2');
    const choiceBrief = document.getElementById('choice-briefing');
    const choiceCal   = document.getElementById('choice-calendar');
    const backBtn     = document.getElementById('modal-back');
    const calIframe   = document.getElementById('cal-iframe');
    const calLoader   = document.getElementById('cal-loader');

    if (!modal) return;

    // --- Open / Close ---
    function openModal() {
        modal.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        showStep(1);
    }

    function closeModal() {
        modal.classList.remove('is-open');
        modal.classList.remove('show-calendar');
        document.body.style.overflow = '';
        setTimeout(() => {
            showStep(1);
            calIframe.src = '';
            calIframe.classList.remove('is-loaded');
            calLoader.classList.remove('is-hidden');
        }, 300);
    }

    // --- Step control ---
    function showStep(n) {
        if (n === 1) {
            step1.classList.remove('engagement-modal__step--hidden');
            step2.classList.add('engagement-modal__step--hidden');
            modal.classList.remove('show-calendar');
        } else {
            step1.classList.add('engagement-modal__step--hidden');
            step2.classList.remove('engagement-modal__step--hidden');
            modal.classList.add('show-calendar');
        }
    }

    // --- Choice: Submit Briefing ---
    choiceBrief.addEventListener('click', function () {
        closeModal();
        setTimeout(function () {
            const contact = document.getElementById('contact');
            if (contact) {
                contact.scrollIntoView({ behavior: 'smooth' });
            }
        }, 350);
    });

    // --- Choice: Schedule a Call ---
    choiceCal.addEventListener('click', function () {
        showStep(2);
    });

    // --- Back button ---
    backBtn.addEventListener('click', function () {
        showStep(1);
    });

    // --- Close triggers ---
    closeBtn.addEventListener('click', closeModal);
    backdrop.addEventListener('click', closeModal);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeModal();
    });

    // --- Attach to all trigger buttons ---

    // "Initiate Briefing" navbar button
    const initiateBtn = document.querySelector('.book-call-btn');
    if (initiateBtn) {
        initiateBtn.addEventListener('click', function (e) {
            e.preventDefault();
            openModal();
        });
    }

    // "Book a Call" footer button
    const bookCallBtn = document.querySelector('.footer__btn .btn-circle-icon');
    if (bookCallBtn) {
        bookCallBtn.addEventListener('click', function (e) {
            e.preventDefault();
            openModal();
        });
    }

    // Dropdown "Book a Call" item
    const dropdownBook = document.querySelector('.dropdown-item[href="#contact"]');
    if (dropdownBook) {
        dropdownBook.addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('menu-toggle')?.classList.remove('active');
            document.getElementById('menu-dropdown')?.classList.remove('show');
            openModal();
        });
    }

    // "Start Engagement" about section button — delegated
    document.addEventListener('click', function (e) {
        if (e.target.closest('.start-engagement-btn')) {
            e.preventDefault();
            openModal();
        }
    });

})();
