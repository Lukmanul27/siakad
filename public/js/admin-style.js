$(document).ready(function() {
    // Sembunyikan loading saat halaman selesai dimuat
    $('.loading').hide();
    
    // Tampilkan loading hanya saat navigasi halaman
    $(document).on('click', 'a', function() {
        if (!$(this).hasClass('no-loading')) {
            $('.loading').fadeIn();
        }
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

    // Smooth scroll dengan pengecekan href
    $('a[href*="#"]').on('click', function(e) {
        var href = $(this).attr('href');
        if (href && href !== '#') {
            e.preventDefault();
            $('html, body').animate(
                {
                    scrollTop: $(href).offset().top,
                },
                500,
                'linear'
            );
        }
    });

    // Tambahkan kelas active pada nav link yang sesuai dengan halaman
    let path = window.location.pathname;
    $('nav a').each(function() {
        if ($(this).attr('href') === path) {
            $(this).addClass('active');
            $(this).parent().addClass('active'); // Tambahkan active ke parent untuk submenu
        }
    });
});