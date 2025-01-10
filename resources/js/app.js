// // Import jQuery
// import $ from 'jquery';
// window.$ = $;
// window.jQuery = $; // Pastikan jQuery tersedia secara global
$(document).ready(function () {
    $(document).on('click', '.view-sale', function () {
        const saleId = $(this).data('id');

        $('#saleModalBody').html('<div class="text-center"><p>Loading...</p></div>');

        $.ajax({
            url: `/sales/${saleId}`,
            method: 'GET',
            success: function (response) {
                $('#saleModalBody').html(response.html);
                $('#saleModal').modal('show');
            },
            error: function (xhr, status, error) {
                $('#saleModalBody').html('<div class="text-danger text-center"><p>Gagal memuat data. Silakan coba lagi.</p></div>');
                console.error('Error:', xhr.responseText);
            }
        });
    });
});

// Import Bootstrap
import 'bootstrap';

// // Import jQuery Easing Plugin
// import 'jquery.easing';

// Import SB Admin 2
import './sb-admin-2.min.js';

// Contoh penggunaan jQuery
$(document).ready(function () {
    console.log('Vite and jQuery are working!');
});

console.log('jQuery version:', $.fn.jquery);
