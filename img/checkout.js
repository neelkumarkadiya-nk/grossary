document.addEventListener("DOMContentLoaded", () => {
  const orderItemsContainer = document.getElementById("orderItems");
  const orderTotalElement = document.getElementById("orderTotal");
  const checkoutForm = document.getElementById("checkoutForm");

  // 1. Get cart data from localStorage
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  // let total = 0;

  // 2. If cart is empty, warn the user
  if (cart.length === 0) {
    orderItemsContainer.innerHTML = "<p style='color:red;'>Your cart is empty. Please add items before checking out.</p>";
    orderTotalElement.innerText = "0.00";
  }

  // 3. Populate Order Summary
  orderItemsContainer.innerHTML = cart
    .map((item) => {
      const itemTotal = item.price * item.quantity;
      total += itemTotal;
      return `
        <div class="summary-item">
          <span>${item.name} (x${item.quantity})</span>
          <span>₹${itemTotal.toFixed(2)}</span>
        </div>
      `;
    })
    .join("");

  orderTotalElement.innerText = total.toFixed(2);

  // 4. Handle Form Submission via fetch (AJAX)
  checkoutForm.addEventListener("submit", (e) => {
    e.preventDefault(); // Prevent default HTML form POST (we use fetch instead)

    // Validate cart is not empty before submitting
    if (cart.length === 0) {
      alert("Your cart is empty! Please add items first.");
      return;
    }

    const orderData = {
      orderId: "ORD-" + Math.floor(Math.random() * 1000000),
      customerName: document.getElementById("name").value,
      email: document.getElementById("email").value,
      phone: document.getElementById("phone").value,
      address: document.getElementById("address").value,
      paymentMethod: document.querySelector('input[name="payment"]:checked').value,
      total: total,
      items: cart, // Array of cart items from localStorage
    };

    // Send data to PHP backend as JSON
    fetch("save_order.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(orderData),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Server returned status " + response.status);
        }
        return response.json();
      })
      .then((result) => {
        if (result.status === "success") {
          // Clear cart and show success modal
          localStorage.removeItem("cart");

          // ✅ FIX: Show DB order_id with ORD- prefix (consistent display)
          document.getElementById("orderId").innerText = "ORD-" + result.order_id;
          document.getElementById("orderSuccess").style.display = "flex";
        } else {
          alert("Error placing order: " + result.message);
        }
      })
      .catch((error) => {
        console.error("Fetch Error:", error);
        alert("Something went wrong. Please try again.\nError: " + error.message);
      });
  });
});