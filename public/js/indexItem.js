document.addEventListener('DOMContentLoaded', function() {
    // Quantity increment/decrement functionality
    document.querySelectorAll('.increment-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentNode.querySelector('input[type=number]');
            input.value = parseInt(input.value) + 1;
            updateNewTotal(input);
        });
    });

    document.querySelectorAll('.decrement-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentNode.querySelector('input[type=number]');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                updateNewTotal(input);
            }
        });
    });

    // Quick amount buttons
    document.querySelectorAll('.quick-amount').forEach(btn => {
        btn.addEventListener('click', function() {
            const amount = parseInt(this.getAttribute('data-amount'));
            const input = this.closest('.modal-body').querySelector('input[type=number]');
            input.value = amount;
            updateNewTotal(input);
        });
    });

    // Input field change handler
    document.querySelectorAll('input[name="quantity"]').forEach(input => {
        input.addEventListener('change', function() {
            if (parseInt(this.value) < 1) this.value = 1;
            updateNewTotal(this);
        });
    });

    // Update the "new total" display
    function updateNewTotal(inputElement) {
        const modal = inputElement.closest('.modal');
        const currentStock = parseInt(modal.querySelector('.badge').textContent.match(/\d+/)[0]);
        const newTotal = currentStock + parseInt(inputElement.value);
        modal.querySelector('.text-primary.fw-semibold').textContent = `New total: ${newTotal} units`;
    }
});