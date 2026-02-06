// Toggle admin panel visibility
function coustomer() {
    const adminPanel = document.getElementById('adminPanel');
    if (adminPanel.style.display === 'none') {
        adminPanel.style.display = 'block';
        displayOrders();
    } else {
        adminPanel.style.display = 'none';
    }
}

// Format date
function formatDate(dateString) {
    const options = { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric',
        hour: '2-digit', 
        minute: '2-digit'
    };
    return new Date(dateString).toLocaleDateString('en-US', options);
}

// Update order status
function updateOrderStatus(orderId, newStatus) {
    let orders = JSON.parse(localStorage.getItem('orders')) || [];
    const order = orders.find(o => o.orderId === orderId);
    if (order) {
        order.status = newStatus;
        localStorage.setItem('orders', JSON.stringify(orders));
        displayOrders();
    }
}

// Remove order
function removeOrder(orderId) {
    if (confirm('Are you sure you want to remove this order?')) {
        let orders = JSON.parse(localStorage.getItem('orders')) || [];
        orders = orders.filter(order => order.orderId !== orderId);
        localStorage.setItem('orders', JSON.stringify(orders));
        displayOrders();
        
        // Hide admin panel if no orders left
        if (orders.length === 0) {
            document.getElementById('adminPanel').style.display = 'none';
        }
    }
}

// Display orders in admin panel
function displayOrders() {
    const ordersTableBody = document.getElementById('ordersTableBody');
    const orders = JSON.parse(localStorage.getItem('orders')) || [];

    // Sort orders by date (newest first)
    orders.sort((a, b) => new Date(b.date) - new Date(a.date));

    ordersTableBody.innerHTML = '';

    orders.forEach(order => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${order.orderId}</td>
            <td>${order.customerName}</td>
            <td>${order.address}</td>
            <td>${order.paymentMethod === 'cod' ? 'Cash on Delivery' : 'Online Payment'}</td>
            <td>$${order.total.toFixed(2)}</td>
            <td>
                <select class="status-select" onchange="updateOrderStatus('${order.orderId}', this.value)">
                    <option value="pending" ${order.status === 'pending' ? 'selected' : ''}>Pending</option>
                    <option value="processing" ${order.status === 'processing' ? 'selected' : ''}>Processing</option>
                    <option value="delivered" ${order.status === 'delivered' ? 'selected' : ''}>Delivered</option>
                    <option value="cancelled" ${order.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                </select>
            </td>
            <td>${formatDate(order.date)}</td>
            <td>
                <button class="remove-btn" onclick="removeOrder('${order.orderId}')">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        ordersTableBody.appendChild(row);
    });
}

// Initialize admin functionality
document.addEventListener('DOMContentLoaded', () => {
    // Check if there are any orders and show admin panel if there are
    const orders = JSON.parse(localStorage.getItem('orders')) || [];
    if (orders.length > 0) {
        document.getElementById('adminPanel').style.display = 'block';
        displayOrders();
    }
}); 