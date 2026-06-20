document.querySelectorAll('.quantity-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const action = e.submitter ? e.submitter.value : null;
        const input = this.querySelector('input[name="quantity"]');
        let quantity = parseInt(input.value);

        if (action === 'increase') {
            quantity++;
        } else if (action === 'decrease' && quantity > 1) {
            quantity--;
        }
        // If action is neither (e.g. direct input), keep quantity as-is but enforce min 1
        if (quantity < 1) quantity = 1;

        input.value = quantity;

        const existing = this.querySelector('input[name="action"]');
        if (existing) existing.remove();

        const hiddenAction = document.createElement('input');
        hiddenAction.type = 'hidden';
        hiddenAction.name = 'action';
        hiddenAction.value = action || '';
        this.appendChild(hiddenAction);

        this.submit();
    });
});

// Confirm before removing item
document.querySelectorAll('.remove-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        if (!confirm('Are you sure you want to remove this item?')) {
            e.preventDefault();
        }
    });
});