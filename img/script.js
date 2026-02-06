function openForm() {
    document.getElementById("chatForm").style.display = "block";
}

function closeForm() {
    document.getElementById("chatForm").style.display = "none";
}

async function sendMessage() {
    const msgInput = document.getElementById("msgInput");
    const message = msgInput.value.trim();
    if (!message) return;

    const chatLog = document.getElementById("chatLog");
    chatLog.innerHTML += "<div><b>आप:</b> " + message + "</div>";

    const res = await fetch("/get", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ msg: message })
    });
    const data = await res.json();
    chatLog.innerHTML += "<div><b>Bot:</b> " + data.response + "</div>";

    msgInput.value = "";
    chatLog.scrollTop = chatLog.scrollHeight;
}





// // Initialize cart from localStorage or empty array
// let cart = JSON.parse(localStorage.getItem('cart')) || [];



// // Update cart count
// function updateCartCount() {
//     const cartCount = document.getElementById('cartCount');
//     cartCount.textContent = cart.reduce((total, item) => total + item.quantity, 0);
// }

// // Add to cart function
// function addToCart(productId) {
//     const product = Object.values(products)
//         .flat()
//         .find(p => p.id === productId);

//     if (product) {
//         const existingItem = cart.find(item => item.id === productId);
//         if (existingItem) {
//             existingItem.quantity += 1;
//         } else {
//             cart.push({ ...product, quantity: 1 });
//         }
//         localStorage.setItem('cart', JSON.stringify(cart));
//         updateCartCount();
//         alert('Product added to cart!');
//     }
// }

// // Display categories
// function displayCategories() {
//     const categoryContainer = document.querySelector('.category-container');
//     if (categoryContainer) {
//         Object.keys(products).forEach(category => {
//             const categoryCard = document.createElement('div');
//             categoryCard.className = 'category-card';
//             categoryCard.innerHTML = `
//                 <h3>${category.charAt(0).toUpperCase() + category.slice(1)}</h3>
//                 <p>${products[category].length} items</p>
//             `;
//             categoryCard.addEventListener('click', () => displayProducts(category));
//             categoryContainer.appendChild(categoryCard);
//         });
//     }
// }

// // Display products
// function displayProducts(category = null) {
//     const productsContainer = document.querySelector('.products-container');
//     if (productsContainer) {
//         productsContainer.innerHTML = '';
//         const productsToShow = category ? products[category] : Object.values(products).flat();
        
//         productsToShow.forEach(product => {
//             const productCard = document.createElement('div');
//             productCard.className = 'product-card';
//             productCard.innerHTML = `
//                 <img src="${product.image}" alt="${product.name}">
//                 <h3>${product.name}</h3>
//                 <p class="price"> ₹ ${product.price.toFixed(2)}</p>
//                 <button class="add-to-cart" onclick="addToCart(${product.id})">Add to Cart</button>
//             `;
//             productsContainer.appendChild(productCard);
//         });
//     }
// }

// // Display cart items
// function displayCart() {
//     const cartContainer = document.querySelector('.cart-container');
//     const cartTotal = document.getElementById('cartTotal');
    
//     if (cartContainer) {
//         if (cart.length === 0) {
//             cartContainer.innerHTML = '<p>Your cart is empty</p>';
//             cartTotal.textContent = '0.00';
//             return;
//         }

//         cartContainer.innerHTML = '';
//         let total = 0;

//         cart.forEach(item => {
//             const itemTotal = item.price * item.quantity;
//             total += itemTotal;

//             const cartItem = document.createElement('div');
//             cartItem.className = 'cart-item';
//             cartItem.innerHTML = `
//                 <img src="${item.image}" alt="${item.name}">
//                 <div class="cart-item-details">
//                     <h3>${item.name}</h3>
//                     <p>₹  ${item.price.toFixed(2)} x ${item.quantity}</p>
//                     <div class="cart-item-quantity">
//                         <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
//                         <span>${item.quantity}</span>
//                         <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
//                         <button onclick="removeFromCart(${item.id})">Remove</button>
//                     </div>
//                 </div>
//             `;
//             cartContainer.appendChild(cartItem);
//         });

//         cartTotal.textContent = total.toFixed(2);
//     }
// }

// // Update quantity
// function updateQuantity(productId, newQuantity) {
//     if (newQuantity < 1) {
//         removeFromCart(productId);
//         return;
//     }

//     const item = cart.find(item => item.id === productId);
//     if (item) {
//         item.quantity = newQuantity;
//         localStorage.setItem('cart', JSON.stringify(cart));
//         // updateQuantity();
//         updateCartCount();
//         displayCart();
//     }
// }

// // Remove from cart
// function removeFromCart(productId) {
//     cart = cart.filter(item => item.id !== productId);
//     localStorage.setItem('cart', JSON.stringify(cart));
//     updateCartCount();
//     displayCart();
// }

// document.addEventListener('DOMContentLoaded', () => {
//     updateCartCount();
//     if (document.querySelector('.cart-container')) displayCart();
// });

