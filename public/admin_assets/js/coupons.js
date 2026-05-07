/* Coupons Module JavaScript Logic */

document.addEventListener('DOMContentLoaded', function() {
    const discountType = document.getElementById('discountType');
    if (discountType) {
        discountType.addEventListener('change', function() {
            const type = this.value;
            const valueGroup = document.getElementById('valueGroup');
            const symbol = document.getElementById('valueSymbol');
            const valueInput = document.getElementById('discountValue');

            if (type === 'free_shipping') {
                if (valueGroup) valueGroup.style.display = 'none';
                if (valueInput) {
                    valueInput.value = '0';
                    valueInput.removeAttribute('required');
                }
            } else {
                if (valueGroup) valueGroup.style.display = 'block';
                if (valueInput) valueInput.setAttribute('required', 'required');
                if (symbol) symbol.textContent = type === 'percentage' ? '%' : '$';
            }
        });
    }

    // Initialize visibility on page load
    if (discountType) {
        discountType.dispatchEvent(new Event('change'));
    }
    
    // Initial calls for other toggles
    toggleMinAmount();
});

function toggleMinAmount() {
    const checkedRadio = document.querySelector('input[name="min_req_type"]:checked');
    if (!checkedRadio) return;
    
    const type = checkedRadio.value;
    const group = document.getElementById('minAmountGroup');
    if (group) group.style.display = type === 'amount' ? 'block' : 'none';
}

function toggleMaxUses(checkbox) {
    const group = document.getElementById('maxUsesGroup');
    if (group) group.style.display = checkbox.checked ? 'block' : 'none';
}

function generateCode() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let code = '';
    for (let i = 0; i < 8; i++) {
        code += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    const input = document.getElementById('couponCode');
    if (input) input.value = code;
}

function confirmDelete(id) {
    Swal.fire({
        title: 'Delete Coupon?',
        text: "This discount code will be permanently removed. This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
        borderRadius: '15px'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = window.BASE_URL + '/admin/coupons/delete/' + id;
            document.body.appendChild(form);
            form.submit();
        }
    });
}
