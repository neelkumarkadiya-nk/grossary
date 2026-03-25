const products = {
    fruits: [
        {
            id: 1,
            name: "Apple",
            price: 60,
            image:
                "https://images.unsplash.com/photo-1619546813926-a78fa6372cd2?w=500",
            category: "fruits",
        },
        {
            id: 2,
            name: "Banana",
            price: 50,
            image:
                "https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?w=500",
            category: "fruits",
        },
        {
            id: 3,
            name: "Orange",
            price: 70,
            image:
                "https://images.unsplash.com/photo-1580052614034-c55d20bfee3b?w=500",
            category: "fruits",
        },
        {
            id: 4,
            name: "Mango",
            price: 90,
            image: "https://images.unsplash.com/photo-1553279768-865429fa0078?w=500",
            category: "fruits",
        },
        {
            id: 11,
            name: "Strawberry",
            price: 50,
            image:
                "https://images.unsplash.com/photo-1464965911861-746a04b4bca6?w=500",
            category: "fruits",
        },
        // {
        //     id: 12,
        //     name: "Grapes",
        //     price: 2.99,
        //     image:
        //         "https://images.unsplash.com/photo-1596364721223-30014f01d1b6?w=500",
        //     category: "fruits",
        // },
        // {
        //     id: 13,
        //     name: "Pineapple",
        //     price: 4.5,
        //     image:
        //         "https://images.unsplash.com/photo-1589883661923-6476cb0ae9f2?w=500",
        //     category: "fruits",
        // },
        {
            id: 14,
            name: "Watermelon",
            price: 80,
            image:
                "https://images.unsplash.com/photo-1589984662646-e7b2e4962f18?w=500",
            category: "fruits",
        },
        {
            id: 25,
            name: "Blueberries",
            price: 30,
            image:
                "https://images.unsplash.com/photo-1498557850523-fd3d118b962e?w=500",
            category: "fruits",
        },
        // {
        //     id: 26,
        //     name: "Kiwi",
        //     price: 2.5,
        //     image:
        //         "https://images.unsplash.com/photo-1591796079474-735c9a2bc36d?w=500",
        //     category: "fruits",
        // },
    ],
    vegetables: [
        {
            id: 5,
            name: "Carrot",
            price: 60,
            image:
                "https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=500",
            category: "vegetables",
        },
        {
            id: 6,
            name: "Broccoli",
            price: 20,
            image:
                "https://images.unsplash.com/photo-1584270354949-c26b0d5b4a0c?w=500",
            category: "vegetables",
        },
        {
            id: 7,
            name: "Tomato",
            price: 50,
            image:
                "https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=500",
            category: "vegetables",
        },
        {
            id: 15,
            name: "Spinach",
            price: 40,
            image:
                "https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=500",
            category: "vegetables",
        },
        {
            id: 16,
            name: "Potato",
            price: 30,
            image:
                "https://images.unsplash.com/photo-1518977676601-b53f82aba655?w=500",
            category: "vegetables",
        },
        // {
        //     id: 17,
        //     name: "Bell Pepper",
        //     price: 1.25,
        //     image:
        //         "https://images.unsplash.com/photo-1563565312874-84399f5e23ad?w=500",
        //     category: "vegetables",
        // },
        {
            id: 18,
            name: "Cucumber",
            price: 20,
            image:
                "https://images.unsplash.com/photo-1449300079323-02e209d9d3a6?w=500",
            category: "vegetables",
        },
        // {
        //     id: 27,
        //     name: "Eggplant",
        //     price: 1.1,
        //     image:
        //         "https://images.unsplash.com/photo-1511263152607-00c8f10f8a7e?w=500",
        //     category: "vegetables",
        // },
        {
            id: 28,
            name: "Corn",
            price: 25,
            image: "https://images.unsplash.com/photo-1551754655-cd27e38d2076?w=500",
            category: "vegetables",
        },
        // {
        //     id: 29,
        //     name: "Lettuce",
        //     price: 1.99,
        //     image:
        //         "https://images.unsplash.com/photo-1622206141580-579f6e3cf1ad?w=500",
        //     category: "vegetables",
        // },
    ],
    dairy: [
        {
            id: 8,
            name: "Milk",
            price: 35,
            image: "https://images.unsplash.com/photo-1563636619-e9143da7973b?w=500",
            category: "dairy",
        },
        {
            id: 9,
            name: "Cheese",
            price: 45,
            image:
                "https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?w=500",
            category: "dairy",
        },
        {
            id: 10,
            name: "Yogurt",
            price: 25,
            image: "https://images.unsplash.com/photo-1563227812-0ea4c22e6cc8?w=500",
            category: "dairy",
        },
        {
            id: 19,
            name: "Butter",
            price: 35,
            image:
                "https://images.unsplash.com/photo-1589985270826-4b7bb135bc9d?w=500",
            category: "dairy",
        },
        {
            id: 20,
            name: "Eggs (12pk)",
            price: 40,
            image:
                "https://images.unsplash.com/photo-1506976785307-8732e854ad03?w=500",
            category: "dairy",
        },
        {
            id: 21,
            name: "Ice Cream",
            price: 40,
            image:
                "https://images.unsplash.com/photo-1501443762994-82bd5dace89a?w=500",
            category: "dairy",
        },
        // {
        //     id: 22,
        //     name: "Cottage Cheese",
        //     price: 3.25,
        //     image:
        //         "https://images.unsplash.com/photo-1624308462832-65935398246b?w=500",
        //     category: "dairy",
        // },
        {
            id: 30,
            name: "Sour Cream",
            price: 25,
            image:
                "https://images.unsplash.com/photo-1528750997573-59b89d56f4f7?w=500",
            category: "dairy",
        },
        {
            id: 31,
            name: "Whipping Cream",
            price: 30,
            image: "https://images.unsplash.com/photo-1553909489-cd47e0907980?w=500",
            category: "dairy",
        },
        {
            id: 32,
            name: "Greek Yogurt",
            price: 90,
            image:
                "https://images.unsplash.com/photo-1488477181946-6428a0291777?w=500",
            category: "dairy",
        },
    ],
};

// Initialize cart from localStorage or empty array
let cart = JSON.parse(localStorage.getItem("cart")) || [];

function updateCartCount() {
    const cartCount = document.getElementById("cartCount");
    if (cartCount) {
        cartCount.textContent = cart.reduce(
            (total, item) => total + item.quantity,
            0,
        );
    }
}

// Add to cart function
function addToCart(productId) {
    const product = Object.values(products)
        .flat()
        .find((p) => p.id === productId);

    if (product) {
        const existingItem = cart.find((item) => item.id === productId);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({ ...product, quantity: 1 });
        }
        localStorage.setItem("cart", JSON.stringify(cart));
        updateCartCount();
        alert("Product added to cart!");
    }
}

// Display categories
function displayCategories() {
    const categoryContainer = document.querySelector(".category-container");
    if (categoryContainer) {
        Object.keys(products).forEach((category) => {
            const categoryCard = document.createElement("div");
            categoryCard.className = "category-card";
            categoryCard.innerHTML = `
                <h3>${category.charAt(0).toUpperCase() + category.slice(1)}</h3>
                <p>${products[category].length} items</p>
            `;
            categoryCard.addEventListener("click", () => displayProducts(category));
            categoryContainer.appendChild(categoryCard);
        });
    }
}

// Display products
function displayProducts(category = null) {
    const productsContainer = document.querySelector(".products-container");
    if (productsContainer) {
        productsContainer.innerHTML = "";
        const productsToShow = category
            ? products[category]
            : Object.values(products).flat();

        productsToShow.forEach((product) => {
            const productCard = document.createElement("div");
            productCard.className = "product-card";
            productCard.innerHTML = `
                <img src="${product.image}" alt="${product.name}">
                <h3>${product.name}</h3>
                <p class="price"> ₹ ${product.price.toFixed(2)}</p>
                <button class="add-to-cart" onclick="addToCart(${product.id})">Add to Cart</button>
            `;
            productsContainer.appendChild(productCard);
        });
    }
}

// Display cart items
function displayCart() {
    const cartContainer = document.querySelector(".cart-container");
    const cartTotal = document.getElementById("cartTotal");

    if (cartContainer) {
        if (cart.length === 0) {
            cartContainer.innerHTML = "<p>Your cart is empty</p>";
            cartTotal.textContent = "0.00";
            return;
        }

        cartContainer.innerHTML = "";
        let total = 0;

        cart.forEach((item) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            const cartItem = document.createElement("div");
            cartItem.className = "cart-item";
            cartItem.innerHTML = `
                <img src="${item.image}" alt="${item.name}">
                <div class="cart-item-details">
                    <h3>${item.name}</h3>
                    <p>₹  ${item.price.toFixed(2)} x ${item.quantity}</p>
                    <div class="cart-item-quantity">
                        <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
                        <span>${item.quantity}</span>
                        <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                        <button onclick="removeFromCart(${item.id})">Remove</button>
                    </div>
                </div>
            `;
            cartContainer.appendChild(cartItem);
        });

        cartTotal.textContent = total.toFixed(2);
    }
}

function updateQuantity(productId, newQuantity) {
    if (newQuantity < 1) {
        removeFromCart(productId);
        return;
    }
    const item = cart.find((item) => item.id === productId);
    if (item) {
        item.quantity = newQuantity;
        localStorage.setItem("cart", JSON.stringify(cart));
        updateCartCount(); // Fixed infinite loop here
        displayCart();
    }
}

function removeFromCart(productId) {
    cart = cart.filter((item) => item.id !== productId);
    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();
    displayCart();
}

document.addEventListener("DOMContentLoaded", () => {
    updateCartCount();
    if (document.querySelector(".cart-container")) displayCart();
});

// Search functionality
function setupSearch() {
    const searchInput = document.getElementById("searchInput");
    if (searchInput) {
        searchInput.addEventListener("input", (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const allProducts = Object.values(products).flat();
            const filteredProducts = allProducts.filter(
                (product) =>
                    product.name.toLowerCase().includes(searchTerm) ||
                    product.category.toLowerCase().includes(searchTerm),
            );

            const productsContainer = document.querySelector(".products-container");
            if (productsContainer) {
                productsContainer.innerHTML = "";
                filteredProducts.forEach((product) => {
                    const productCard = document.createElement("div");
                    productCard.className = "product-card";
                    productCard.innerHTML = `
                        <img src="${product.image}" alt="${product.name}">
                        <h3>${product.name}</h3>
                        <p class="price">₹${product.price.toFixed(2)}</p>
                        <button class="add-to-cart" onclick="addToCart(${product.id})">Add to Cart</button>
                    `;
                    productsContainer.appendChild(productCard);
                });
            }
        });
    }
}

// Initialize the page
document.addEventListener("DOMContentLoaded", () => {
    displayProducts();
    displayCategories();
    displayCart();
    updateCartCount();
    setupSearch();
});
