<script>
    
    // Reservation Dropdown Functionality (ref. Reservation.php)
    const materialDropdown = document.getElementById('materialDropdown');
    const additionalFields = document.getElementById('additionalFields');
    const availableQtySpan = document.getElementById('availableQty');
    const quantityInput = additionalFields.querySelector('input[name="quantity"]');

    materialDropdown.addEventListener('change', function() {
        const selectedOption = materialDropdown.selectedOptions[0];

        if (selectedOption && selectedOption.value) {
            // Show the additional fields
            additionalFields.classList.remove('hidden');

            // Set the available quantity
            const availableQty = parseInt(selectedOption.getAttribute('data-available')) || 0;
            availableQtySpan.textContent = availableQty;

            // Set quantity input: default value = available, min = 0, max = available
            quantityInput.value = availableQty;
            quantityInput.min = 0;
            quantityInput.max = availableQty;
        } else {
            // Hide additional fields if nothing selected
            additionalFields.classList.add('hidden');

            // Reset quantity input
            quantityInput.value = 0;
            quantityInput.min = 0;
            quantityInput.max = 0;
            availableQtySpan.textContent = 0;
        }
    });

</script>