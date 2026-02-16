document.addEventListener('DOMContentLoaded', () => {
    const orderItemsContainer = document.getElementById('orderItems');
    const orderTotalElement = document.getElementById('orderTotal');
    const checkoutForm = document.getElementById('checkoutForm');

    // 1. LocalStorage se cart data lena
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let total = 0;

    // 2. Agar cart empty hai to wapas bhejna
    // if (cart.length === 0) {
    //     alert("Your cart is empty!");
    //     window.location.href = 'index.php';
    //     return;
    // }

    // 3. Order Summary populate karna
    orderItemsContainer.innerHTML = cart.map(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        return `
            <div class="summary-item">
                <span>${item.name} (x${item.quantity})</span>
                <span>₹${itemTotal.toFixed(2)}</span>
            </div>
        `;
    }).join('');

    orderTotalElement.innerText = total.toFixed(2);

    // 4. Form Submission handle karna
    checkoutForm.addEventListener('submit', (e) => {
        e.preventDefault();

        // Order object banana
        const orderData = {
            orderId: 'ORD-' + Math.floor(Math.random() * 1000000),
            customerName: document.getElementById('name').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            address: document.getElementById('address').value,
            paymentMethod: document.querySelector('input[name="payment"]:checked').value,
            total: total,
            status: 'pending',
            date: new Date().toISOString(),
            items: cart
        };

        // Orders ko localStorage mein save karna
        let orders = JSON.parse(localStorage.getItem('orders')) || [];
        orders.push(orderData);
        localStorage.setItem('orders', JSON.stringify(orders));

        // Cart khali karna aur UI update karna
        localStorage.removeItem('cart');
        
        document.getElementById('orderId').innerText = orderData.orderId;
        document.getElementById('orderSuccess').style.display = 'flex';
    });
});