// Supplement Products Data
const products = [
  {
    id: 1,
    name: "Whey Protein",
    image: "https://via.placeholder.com/150?text=Whey+Protein",
    price: 35.99,
    description: "High-quality whey protein for muscle growth and recovery. 2lb pack, 25g protein per scoop.",
  },
  {
    id: 2,
    name: "Creatine Monohydrate",
    image: "https://via.placeholder.com/150?text=Creatine",
    price: 18.99,
    description: "Micronized creatine monohydrate for strength and performance. 300g tub.",
  },
  {
    id: 3,
    name: "Multivitamin",
    image: "https://via.placeholder.com/150?text=Multivitamin",
    price: 12.50,
    description: "Daily multivitamin for men and women. 100 tablets.",
  },
  {
    id: 4,
    name: "Fish Oil",
    image: "https://via.placeholder.com/150?text=Fish+Oil",
    price: 14.70,
    description: "Omega-3 rich fish oil softgels. 180 softgels per bottle.",
  },
  {
    id: 5,
    name: "BCAA",
    image: "https://via.placeholder.com/150?text=BCAA",
    price: 22.10,
    description: "Branched-chain amino acids for workout recovery. 200g powder.",
  },
  {
    id: 6,
    name: "Pre-Workout",
    image: "https://via.placeholder.com/150?text=Pre-Workout",
    price: 24.99,
    description: "Energy and focus pre-workout blend with caffeine. 250g tub.",
  },
  {
    id: 7,
    name: "Vitamin D3",
    image: "https://via.placeholder.com/150?text=Vitamin+D3",
    price: 7.99,
    description: "Vitamin D3 5000IU. 120 softgels.",
  },
  {
    id: 8,
    name: "Zinc Tablets",
    image: "https://via.placeholder.com/150?text=Zinc",
    price: 6.49,
    description: "Zinc gluconate for immunity support. 100 tablets.",
  },
  {
    id: 9,
    name: "Mass Gainer",
    image: "https://via.placeholder.com/150?text=Mass+Gainer",
    price: 42.00,
    description: "High-calorie mass gainer for bulking up. 5lb pack.",
  },
  {
    id: 10,
    name: "L-Carnitine",
    image: "https://via.placeholder.com/150?text=L-Carnitine",
    price: 16.75,
    description: "L-Carnitine for fat metabolism and energy. 60 capsules.",
  }
];

let cart = JSON.parse(localStorage.getItem('cart')) || [];

function saveCart() {
  localStorage.setItem('cart', JSON.stringify(cart));
}

function updateCartCount() {
  document.getElementById('cart-count').textContent = cart.reduce((acc, item) => acc + item.qty, 0);
}

function showHome() {
  let html = `<h2>Our Supplements</h2>
    <div class="products-grid">`;
  products.forEach(p => {
    html += `
      <div class="product-card">
        <img src="${p.image}" alt="${p.name}">
        <h3>${p.name}</h3>
        <div class="price">$${p.price.toFixed(2)}</div>
        <button onclick="showProduct(${p.id})">View Details</button>
        <button onclick="addToCart(${p.id})">Add to Cart</button>
      </div>`;
  });
  html += `</div>`;
  document.getElementById('main-content').innerHTML = html;
}

function showProduct(id) {
  const p = products.find(prod => prod.id === id);
  let html = `
    <div class="product-card" style="max-width:400px;margin:0 auto;">
      <img src="${p.image}" alt="${p.name}">
      <h3>${p.name}</h3>
      <div class="price">$${p.price.toFixed(2)}</div>
      <p>${p.description}</p>
      <button onclick="addToCart(${p.id})">Add to Cart</button>
      <button onclick="showHome()" style="margin-left:10px;background:#aaa;">Back</button>
    </div>
  `;
  document.getElementById('main-content').innerHTML = html;
}

function addToCart(id) {
  let found = cart.find(item => item.id === id);
  if (found) found.qty += 1;
  else cart.push({id, qty: 1});
  saveCart();
  updateCartCount();
  alert("Added to cart!");
}

function removeFromCart(id) {
  cart = cart.filter(item => item.id !== id);
  saveCart();
  showCart();
  updateCartCount();
}

function showCart() {
  if (cart.length === 0) {
    document.getElementById('main-content').innerHTML = `<h2>Your Cart is Empty</h2>
      <button onclick="showHome()">Back to Store</button>
    `;
    updateCartCount();
    return;
  }
  let html = `<h2>Your Cart</h2>
    <div class="cart-list">`;
  let total = 0;
  cart.forEach(item => {
    const p = products.find(prod => prod.id === item.id);
    total += p.price * item.qty;
    html += `
      <div class="cart-item">
        <img src="${p.image}" alt="${p.name}">
        <div class="details">
          <strong>${p.name}</strong> <br>
          $${p.price.toFixed(2)} x ${item.qty}
        </div>
        <button class="remove" onclick="removeFromCart(${p.id})">Remove</button>
      </div>`;
  });
  html += `</div>
    <div class="cart-total">Total: $${total.toFixed(2)}</div>
    <button onclick="showPayment()" class="btn" style="margin-top:18px;">Proceed to Payment</button>
    <button onclick="showHome()" style="margin-left:10px;background:#aaa;">Back to Store</button>
  `;
  document.getElementById('main-content').innerHTML = html;
}

function showPayment() {
  let total = cart.reduce((sum, item) => {
    const p = products.find(prod => prod.id === item.id);
    return sum + p.price * item.qty;
  }, 0);
  let html = `
    <h2>Payment</h2>
    <form class="payment-form" onsubmit="processPayment(event)">
      <label>Name on Card</label>
      <input required type="text" name="name">
      <label>Card Number</label>
      <input required type="text" name="card" maxlength="16" pattern="\\d{16}">
      <label>Expiry</label>
      <input required type="text" name="expiry" placeholder="MM/YY" maxlength="5" pattern="\\d{2}/\\d{2}">
      <label>CVV</label>
      <input required type="text" name="cvv" maxlength="3" pattern="\\d{3}">
      <div class="cart-total" style="margin-top:14px;">Total: $${total.toFixed(2)}</div>
      <button type="submit" class="btn" style="width:100%;margin-top:16px;">Pay Now</button>
    </form>
    <button onclick="showCart()" style="margin:20px auto;display:block;background:#aaa;">Back to Cart</button>
  `;
  document.getElementById('main-content').innerHTML = html;
}

function processPayment(e) {
  e.preventDefault();
  cart = [];
  saveCart();
  updateCartCount();
  document.getElementById('main-content').innerHTML = `
    <h2>Thank You!</h2>
    <p>Your payment was successful. Your supplements will be delivered soon.</p>
    <button onclick="showHome()">Back to Store</button>
  `;
}

// Initial render
showHome();
updateCartCount();

// For navigation from browser history (optional)
window.showHome = showHome;
window.showProduct = showProduct;
window.addToCart = addToCart;
window.showCart = showCart;
window.removeFromCart = removeFromCart;
window.showPayment = showPayment;
window.processPayment = processPayment;