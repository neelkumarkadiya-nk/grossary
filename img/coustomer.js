const DELIVERY_FEE = 40;

function renderOrderSummary() {
    const container = document.getElementById('orderItems');
    const breakdown = document.getElementById('priceBreakdown');
    const cartCount = document.getElementById('cartCount');

    if (!container || !breakdown) return;

    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    const totalQty = cart.reduce((s, i) => s + i.quantity, 0);
    if (cartCount) cartCount.textContent = totalQty;

    if (cart.length === 0) {
        container.innerHTML = `<div class="empty-cart"><ion-icon name="cart-outline"></ion-icon><p>Your cart is empty</p></div>`;
        breakdown.style.display = 'none';
        return;
    }

    let html = '';
    let subtotal = 0;
    cart.forEach(item => {
        const lineTotal = item.price * item.quantity;
        subtotal += lineTotal;
        html += `
            <div class="order-item">
                <img src="${item.image}" alt="${item.name}">
                <div class="order-item-info">
                    <h4>${item.name}</h4>
                    <p>&#8377;${item.price.toFixed(2)} &times; ${item.quantity}</p>
                </div>
                <div class="order-item-price">&#8377;${lineTotal.toFixed(2)}</div>
            </div>`;
    });
    container.innerHTML = html;

    const discount = subtotal >= 500 ? 50 : 0;
    const total = subtotal + DELIVERY_FEE - discount;

    document.getElementById('subtotalAmt').textContent = '&#8377;' + subtotal.toFixed(2);
    document.getElementById('deliveryFee').textContent = '&#8377;' + DELIVERY_FEE.toFixed(2);
    document.getElementById('discountAmt').textContent = '-&#8377;' + discount.toFixed(2);
    document.getElementById('totalAmt').textContent    = '&#8377;' + total.toFixed(2);
    breakdown.style.display = 'block';
}

// ── Reset button to normal state ──
function resetBtn() {
    const btn = document.getElementById('placeOrderBtn');
    if (btn) {
        btn.classList.remove('btn-loading');
        btn.disabled = false;
        btn.innerHTML = '<ion-icon name="checkmark-circle-outline"></ion-icon> Place Order';
    }
}

// ── Validation ──
function validate() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const fields = [
        { id: 'fullName', label: 'Full Name' },
        { id: 'phone',    label: 'Phone Number' },
        { id: 'address',  label: 'Address' },
        { id: 'city',     label: 'City' },
        { id: 'state',    label: 'State' },
        { id: 'pincode',  label: 'PIN Code' },
    ];
    for (const f of fields) {
        const el = document.getElementById(f.id);
        if (!el || !el.value.trim()) {
            if (el) {
                el.focus();
                el.style.borderColor = '#e74c3c';
                setTimeout(() => el.style.borderColor = '', 2000);
            }
            alert('Please fill in: ' + f.label);
            return false;
        }
    }
    if (cart.length === 0) {
        alert('Your cart is empty!');
        return false;
    }
    return true;
}

// ── Place Order ──
async function placeOrder() {
    if (!validate()) return;

    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const btn  = document.getElementById('placeOrderBtn');

    // Show loading state
    btn.classList.add('btn-loading');
    btn.disabled = true;
    btn.innerHTML = '<ion-icon name="hourglass-outline"></ion-icon> Processing...';

    const subtotal = cart.reduce((s, i) => s + i.price * i.quantity, 0);
    const discount = subtotal >= 500 ? 50 : 0;
    const total    = subtotal + DELIVERY_FEE - discount;

    const payload = {
        fullName: document.getElementById('fullName').value.trim(),
        phone:    document.getElementById('phone').value.trim(),
        email:    document.getElementById('email').value.trim(),
        address:  document.getElementById('address').value.trim(),
        city:     document.getElementById('city').value.trim(),
        state:    document.getElementById('state').value,
        pincode:  document.getElementById('pincode').value.trim(),
        notes:    document.getElementById('notes').value.trim(),
        payment:  document.querySelector('input[name="payment"]:checked').value,
        cart:     cart,
        total:    total.toFixed(2)
    };

    // Safety timeout — if no response in 15s, unblock the button
    const safetyTimer = setTimeout(() => {
        resetBtn();
        alert('Request timed out. Please check your connection and try again.');
    }, 15000);

    try {
        const res = await fetch('process_checkout.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        clearTimeout(safetyTimer);

        // Always read raw text first so we can show it if JSON parse fails
        const text = await res.text();

        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            resetBtn();
            alert('Server returned an unexpected response:\n\n' + text.substring(0, 300));
            return;
        }

        if (data.success) {
            localStorage.removeItem('cart');
            document.getElementById('orderIdBadge').textContent = 'Order #' + data.order_id;
            document.getElementById('successModal').classList.add('show');
            // Button stays in success state — modal is showing
        } else {
            resetBtn();
            alert('Could not place order: ' + (data.message || 'Unknown error.'));
        }

    } catch (err) {
        clearTimeout(safetyTimer);
        resetBtn();
        alert('Network error: ' + err.message);
    }
}

// ── Single event listener ──
document.addEventListener('DOMContentLoaded', function () {
    renderOrderSummary();

    const btn = document.getElementById('placeOrderBtn');
    if (btn) {
        btn.addEventListener('click', placeOrder);
    }
});