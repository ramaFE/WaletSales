// Import Bootstrap
import 'bootstrap';

// Import SB Admin 2
import './sb-admin-2.min.js';

// Document Ready
$(document).ready(function () {
    console.log('Vite and jQuery are working!');
    console.log('jQuery version:', $.fn.jquery);

    /**
     * Open Delete Confirmation Popup
     */
    $(document).on('click', '.open-delete-popup', function () {
        const url = $(this).data('url'); // Get URL from button
        const name = $(this).data('name'); // Get name
        const code = $(this).data('code'); // Get product code

        // Set product information dynamically in modal
        $('#customer-info').text(name);
        $('#product-info').text(`(${code}) ${name}`);
        $('#delete-form').attr('action', url);

        // Show delete confirmation modal
        $('#delete-modal').css('display', 'flex'); // Display modal
    });

    /**
     * Close Delete Confirmation Popup
     */
    $(document).on('click', '#delete-cancel', function () {
        $('#delete-modal').css('display', 'none'); // Hide modal
    });

    /**
     * Close Modal When Clicking Outside Content
     */
    $(document).on('click', '#delete-modal .overlay', function () {
        $('#delete-modal').css('display', 'none'); // Hide modal
    });

    /**
     * Search Functionality (Optional: Customize as needed)
     */
    $('#search').on('keyup', function () {
        const searchValue = $(this).val().toLowerCase();

        // Filter table rows based on search input
        $('.table tbody tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
        });
    });

    /**
     * Handle AJAX View Sale Modal
     * This is an optional feature to view additional details.
     */
    $(document).on('click', '.view-sale', function () {
        const saleId = $(this).data('id'); // Get sale ID from button

        // Set loading state in modal body
        $('#saleModalBody').html('<div class="text-center"><p>Loading...</p></div>');

        // AJAX Request to fetch sale data
        $.ajax({
            url: `/sales/${saleId}`, // Adjust URL as per your routing
            method: 'GET',
            success: function (response) {
                $('#saleModalBody').html(response.html); // Populate modal body with response data
                $('#saleModal').modal('show'); // Show modal
            },
            error: function (xhr, status, error) {
                $('#saleModalBody').html('<div class="text-danger text-center"><p>Gagal memuat data. Silakan coba lagi.</p></div>');
                console.error('Error:', xhr.responseText);
            }
        });
    });
});
