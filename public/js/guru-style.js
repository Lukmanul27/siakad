$(document).ready(function() {
    // Animasi loading saat perpindahan halaman
    $(document).on('click', 'a', function() {
        $('.loading').fadeIn();
    });

    // Efek hover untuk cards
    $('.card').hover(
        function() { $(this).addClass('shadow-lg'); },
        function() { $(this).removeClass('shadow-lg'); }
    );

    // Toggle sidebar di mobile 
    $('#sidebarToggle').on('click', function() {
        $('.sidebar').toggleClass('d-none d-md-block');
    });

    // Aktifkan tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Smooth scroll
    $('a[href*="#"]').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate(
            {
                scrollTop: $($(this).attr('href')).offset().top,
            },
            500,
            'linear'
        );
    });

    // Tambahkan kelas active pada nav link yang sesuai dengan halaman
    let path = window.location.pathname;
    $('nav a').each(function() {
        if ($(this).attr('href') === path) {
            $(this).addClass('active');
        }
    });
});
