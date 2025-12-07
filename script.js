// Products data (max 10)
const products = [
    {
        id: 1,
        name: "Whey Protein Isolate",
        price: 2499,
        image: "https://images.unsplash.com/photo-1519864600265-abb23847ef2c?auto=format&fit=crop&w=400&q=80",
        desc: "Ultra-pure whey protein isolate for muscle gain, rapid absorption. 1kg pack. Chocolate flavour.",
    },
    {
        id: 2,
        name: "MB Mass Gainer",
        price: 1899,
        image: "./img/product-1.webp",
        desc: "Carb-protein blend for bulking up. 2kg tub, delicious vanilla taste.",
    },
    {
        id: 3,
        name: "Vegan Protein",
        price: 2099,
        image: "https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=400&q=80",
        desc: "100% plant-based, allergen-free protein. Great for lactose intolerant athletes. 1kg.",
    },
    {
        id: 4,
        name: "Casein Night Protein",
        price: 1599,
        image: "https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80",
        desc: "Slow-absorbing protein for overnight muscle recovery. 900g.",
    },
    {
        id: 5,
        name: "Hydrolyzed Whey",
        price: 2799,
        image: "https://images.unsplash.com/photo-1465101178521-c1a9136a3c5d?auto=format&fit=crop&w=400&q=80",
        desc: "Ultra-fast absorption for post-workout recovery. 1kg.",
    },
    {
        id: 6,
        name: "Soy Protein Isolate",
        price: 1399,
        image: "https://images.unsplash.com/photo-1502741338009-cac2772e18bc?auto=format&fit=crop&w=400&q=80",
        desc: "Tasty, lactose-free soy protein for lean muscle. 1kg.",
    },
    {
        id: 7,
        name: "Pea Protein",
        price: 1599,
        image: "https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=400&q=80",
        desc: "Non-dairy, easy to digest protein. 1kg. Unflavored.",
    },
    {
        id: 8,
        name: "Whey Protein Concentrate",
        price: 1199,
        image: "https://images.unsplash.com/photo-1519864600265-abb23847ef2c?auto=format&fit=crop&w=400&q=80",
        desc: "Classic, value-for-money whey. 1kg. Mango flavour.",
    },
    {
        id: 9,
        name: "Egg White Protein",
        price: 2199,
        image: "https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80",
        desc: "Egg white protein for highest purity. 1kg.",
    },
    {
        id: 10,
        name: "Collagen Protein",
        price: 2499,
        image: "https://images.unsplash.com/photo-1465101178521-c1a9136a3c5d?auto=format&fit=crop&w=400&q=80",
        desc: "Supports joints & skin. Unflavored, 500g.",
    },

    {
        id: 11,
        name: "protin",
        price: 2500,
        // image: "https://images.unsplash.com/photo-1465101178521-c1a9136a3c5d?auto=format&fit=crop&w=400&q=80",
        desc: "Supports joints & skin. Unflavored, 500g.",
    },
];

let cart = [];

// LocalStorage helpers
function saveCart() {
    localStorage.setItem('suppCart', JSON.stringify(cart));
}
function loadCart() {
    cart = JSON.parse(localStorage.getItem('suppCart')) || [];
}

function updateCartCount() {
    document.getElementById('cart-count').textContent = cart.reduce((sum, item) => sum + item.qty, 0);
}

// Home Page: product grid
function renderProductList() {
    const listEl = document.getElementById('product-list');
    listEl.innerHTML = '';
    products.forEach(prod => {
        const inCart = cart.find(item => item.id === prod.id);
        const card = document.createElement('div');
        card.className = 'product-card';
        card.innerHTML = `
            <img src="${prod.image}" alt="${prod.name}">
            <h3>${prod.name}</h3>
            <p>${prod.desc.substring(0, 47)}...</p>
            <div class="price">₹${prod.price}</div>
            <div class="product-btns">
                <button class="view-btn" data-id="${prod.id}">View Details</button>
                <button class="cart-btn" data-id="${prod.id}" ${inCart ? 'disabled' : ''}>${inCart ? 'Added' : 'Add to Cart'}</button>
            </div>
        `;
        listEl.appendChild(card);
    });

    // Add listeners
    listEl.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', () => showProductDetail(parseInt(btn.dataset.id)));
    });
    listEl.querySelectorAll('.cart-btn').forEach(btn => {
        btn.addEventListener('click', () => addToCart(parseInt(btn.dataset.id)));
    });
}

// Product Selection Dropdown
function renderProductSelect() {
    const select = document.getElementById('product-select');
    select.innerHTML = `<option value="">-- Choose Product --</option>`;
    products.forEach(prod => {
        const opt = document.createElement('option');
        opt.value = prod.id;
        opt.textContent = prod.name;
        select.appendChild(opt);
    });
    select.value = "";
}

// Show Product Detail Page
function showProductDetail(id) {
    const prod = products.find(p => p.id === id);
    if (!prod) return;
    const inCart = cart.find(item => item.id === prod.id);

    document.getElementById('home-section').classList.remove('active');
    document.getElementById('cart-section').classList.remove('active');
    document.getElementById('detail-section').classList.add('active');
    document.getElementById('nav-cart').classList.remove('active');

    const detail = `
        <img src="${prod.image}" alt="${prod.name}">
        <div id="detail-text">
            <h3>${prod.name}</h3>
            <p>${prod.desc}</p>
            <div class="price">₹${prod.price}</div>
            
            <label for="qty-input"><b>Quantity:</b></label>
            <input type="number" id="qty-input" value="1" min="1" style="width:60px; margin-left:5px;">
            
            <button id="detail-add-btn">${inCart ? 'Update Cart' : 'Add to Cart'}</button>
        </div>
    `;
    document.getElementById('detail-content').innerHTML = detail;

    // Add listener
    document.getElementById('detail-add-btn').addEventListener('click', () => {
        const qty = parseInt(document.getElementById('qty-input').value) || 1;
        addToCart(prod.id, qty);
        showProductDetail(prod.id); // Refresh button state
    });
}


// Cart rendering
function renderCart() {
    const cartList = document.getElementById('cart-list');
    cartList.innerHTML = '';
    if (cart.length === 0) {
        cartList.innerHTML = '<p>Your cart is empty.</p>';
        document.getElementById('cart-total').textContent = '';
        return;
    }
    cart.forEach(item => {
        const prod = products.find(p => p.id === item.id);
        const div = document.createElement('div');
        div.className = 'cart-item';
        div.innerHTML = `
            <div class="cart-item-details">
                <img src="${prod.image}" alt="${prod.name}">
                <span class="cart-item-title">${prod.name}</span>
                <span>Qty: ${item.qty}</span>
            </div>
            <span>₹${prod.price * item.qty}</span>
            <button class="remove-btn" data-id="${item.id}">Remove</button>
        `;
        cartList.appendChild(div);
    });
    cartList.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            removeFromCart(parseInt(btn.dataset.id));
        });
    });

    const total = cart.reduce((sum, item) => {
        const prod = products.find(p => p.id === item.id);
        return sum + (prod.price * item.qty);
    }, 0);
    document.getElementById('cart-total').textContent = `Total: ₹${total}`;
}

function addToCart(id, qty = 1) {
    const prod = products.find(p => p.id === id);
    if (!prod) return;
    let item = cart.find(i => i.id === id);
    if (item) {
        item.qty += qty;  // add chosen qty
    } else {
        cart.push({ id, qty });
    }
    saveCart();
    updateCartCount();
    renderProductList();
    renderCart();
}


function removeFromCart(id) {
    cart = cart.filter(item => item.id !== id);
    saveCart();
    updateCartCount();
    renderProductList();
    renderCart();
}

// Navigation
function showSection(section) {
    document.getElementById('home-section').classList.remove('active');
    document.getElementById('cart-section').classList.remove('active');
    document.getElementById('detail-section').classList.remove('active');
    document.getElementById('nav-home').classList.remove('active');
    document.getElementById('nav-cart').classList.remove('active');
    if (section === 'home') {
        document.getElementById('home-section').classList.add('active');
        document.getElementById('nav-home').classList.add('active');
        document.getElementById('product-select').value = "";
    } else if (section === 'cart') {
        document.getElementById('cart-section').classList.add('active');
        document.getElementById('nav-cart').classList.add('active');
    }
}

document.getElementById('nav-home').addEventListener('click', e => {
    e.preventDefault();
    showSection('home');
});
document.getElementById('nav-cart').addEventListener('click', e => {
    e.preventDefault();
    renderCart();
    showSection('cart');
});
document.getElementById('back-to-home').addEventListener('click', () => {
    showSection('home');
});
document.getElementById('back-to-home-cart').addEventListener('click', () => {
    showSection('home');
});

// Product selection dropdown
document.getElementById('product-select').addEventListener('change', function() {
    const val = this.value;
    if (val) showProductDetail(parseInt(val));
});

function showProductDetail(id) {
    const prod = products.find(p => p.id === id);
    if (!prod) return;
    const inCart = cart.find(item => item.id === prod.id);

    document.getElementById('home-section').classList.remove('active');
    document.getElementById('cart-section').classList.remove('active');
    document.getElementById('detail-section').classList.add('active');
    document.getElementById('nav-cart').classList.remove('active');

    const detail = `
        <img src="${prod.image}" alt="${prod.name}">
        <div id="detail-text">
            <h3>${prod.name}</h3>
            <p>${prod.desc}</p>
            <div class="price">₹${prod.price}</div>
            
            <label for="qty-input"><b>Quantity:</b></label>
            <input type="number" id="qty-input" value="1" min="1" style="width:60px; margin-left:5px;">
            
            <button id="detail-add-btn">${inCart ? 'Update Cart' : 'Add to Cart'}</button>
        </div>
    `;
    document.getElementById('detail-content').innerHTML = detail;

    // Add listener
    document.getElementById('detail-add-btn').addEventListener('click', () => {
        const qty = parseInt(document.getElementById('qty-input').value) || 1;
        addToCart(prod.id, qty);
        showProductDetail(prod.id); // Refresh button state
    });
}


// Basic "validation" - disables add to cart if already in cart
// Also handles edge case of invalid selection

// Initial load
loadCart();
updateCartCount();
renderProductList();
renderCart();
renderProductSelect();
showSection('home');