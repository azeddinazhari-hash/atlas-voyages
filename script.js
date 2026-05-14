document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Navbar scroll effect
    const header = document.querySelector('.head-1');
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // 2. Active Navigation Link
    const currentLocation = location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.main-nav a');
    
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentLocation || (currentLocation === '' && link.getAttribute('href') === 'index.php')) {
            link.classList.add('active');
        }
    });

    // 3. Scroll Reveal Animation
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const revealElements = document.querySelectorAll('.section-reveal');
    revealElements.forEach(el => observer.observe(el));

    // 4. Form Validation (Bootstrap style)
    const forms = document.querySelectorAll('.needs-validation');

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // 5. Pre-fill form from URL parameters (if clicked from 'Réserver' on offres.php)
    const urlParams = new URLSearchParams(window.location.search);
    const offreParam = urlParams.get('offre');
    
    if (offreParam && document.getElementById('message')) {
        let msgText = "";
        switch(offreParam) {
            case 'marrakech':
                msgText = "Bonjour, je souhaite avoir plus d'informations sur le 'Week-end à Marrakech'.";
                break;
            case 'nord':
                msgText = "Bonjour, je souhaite réserver le 'Circuit Nord Magique'.";
                break;
            case 'sahara':
                msgText = "Bonjour, je suis intéressé(e) par l''Aventure Saharienne'.";
                break;
        }
        document.getElementById('message').value = msgText;
    }
});
