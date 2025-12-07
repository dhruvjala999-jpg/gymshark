<?php include("connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title> GYMSHARK Protein Supplement Store</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    :root {
      --blue1: #3a7bd5; 
      --blue2: #00d2ff; 
      --white: #fff;
      --gray: #f2f4f8; 
      --card: #e9f4fb; 
      --shadow: 0 2px 8px rgba(0,0,0,0.07);
      --radius: 16px;
    }
    body { 
      background: linear-gradient(90deg, #020024 0%, #090979 35%, #00d2ff 100%);
      margin: 0; 
      font-family: 'Segoe UI', Arial, sans-serif; 
      min-height: 100vh; 
      color: #1a2233;
      padding-top: 100px; /* Space for fixed header */
    }
    header {
      background: rgba(255,255,255,0.18);
      backdrop-filter: blur(6px);
      color: white;
      padding: 1rem 2rem;
      font-size: 2rem;
      font-weight: bold;
      text-align: center;
      letter-spacing: 1px;
      border-bottom: 2px solid #b3e2ff66;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1000;
    }
    header a.home-link {
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      color: #fff;
      text-decoration: none;
      font-size: 1rem;
      font-weight: 600;
      background: #3a7bd5;
      padding: 6px 12px;
      border-radius: 6px;
      transition: background 0.3s ease;
    }
    header a.home-link:hover {
      background: #00d2ff;
    }
    nav {
      margin: 0;
      padding: 0.5rem 2rem;
      background: transparent;
      display: flex;
      gap: 1.5rem;
      justify-content: center;
      font-size: 1.1rem;
    }
    nav button {
      background: none;
      border: none;
      color: var(--white);
      font-weight: 600;
      padding: 0.5rem 1rem;
      cursor: pointer;
      border-radius: 5px;
      transition: background 0.3s ease, color 0.3s ease;
    }
    nav button.active,
    nav button:hover {
      background: var(--white);
      color: var(--blue1);
    }
    .container {
      max-width: 1100px;
      margin: 36px auto 0 auto;
      background: rgba(255,255,255,0.98);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: 2rem 2rem 3rem 2rem;
      min-height: 60vh;
    }
    .product-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
      gap: 2rem;
    }
    .card {
      background: var(--card);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: 1rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      min-height: 420px;
    }
    .card img {
      width: 148px;
      height: 148px;
      object-fit: contain;
      border-radius: 12px;
      margin-bottom: 1rem;
      box-shadow: 0 4px 16px #3a7bd533;
      background: #e0f2fc;
      border: 2px solid #b3e2ff66;
    }
    .card h3 {
      margin: 0.6rem 0 0.3rem 0;
      font-size: 1.12rem;
      font-weight: 600;
      color: #2366a6;
      min-height: 40px;
    }
    .card p {
      font-size: 0.97rem;
      margin: 0.3rem 0 0.2rem 0;
      color: #355c7d;
      min-height: 40px;
    }
    .card .price {
      font-size: 1.13rem;
      font-weight: bold;
      color: #0b254e;
      margin: 0.5rem 0;
    }
    .card button {
      background: linear-gradient(90deg, var(--blue1), var(--blue2));
      color: var(--white);
      border: none;
      padding: 0.5rem 1.3rem;
      border-radius: 6px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
    }
    .product-details {
      display: flex;
      gap: 2rem;
      flex-wrap: wrap;
      align-items: flex-start;
    }
    .product-details img {
      width: 300px;
      height: 300px;
      object-fit: contain;
      border-radius: 12px;
    }
    .product-info { flex: 1; }
    table.cart-list {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }
    table.cart-list th, table.cart-list td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: center;
    }
    table.cart-list th { background: #f0f0f0; }
    .cart-actions { margin-top: 1rem; }
  </style>
</head>
<body>
  <header>
    <a href="index.php" class="home-link">← Go to Home Page</a>
    Protein Supplement Store
    <nav>
      <button id="nav-home" class="active" onclick="showPage('home')">Home</button>
      <button id="nav-cart" onclick="showPage('cart')">Cart (<span id="cart-count">0</span>)</button>
    </nav>
  </header>

  <div class="container" id="main-content"></div>

  <script>
    let PRODUCTS = [];

    async function loadProducts() {
      try {
        const res = await fetch('get_supplements.php');
        PRODUCTS = await res.json();
        PRODUCTS = PRODUCTS.map(p => ({
          ...p,
          image: p.image.startsWith('http') ? p.image : 'images/' + p.image
        }));
        updateCartCount();
        showPage('home');
      } catch (err) {
        console.error('Error loading products:', err);
        document.getElementById('main-content').innerHTML = "<h2>Error loading products</h2>";
      }
    }

    const CART_KEY = "protein_cart";
    function getCart() {
      try { return JSON.parse(localStorage.getItem(CART_KEY)) || []; }
      catch { return []; }
    }
    function setCart(c) { localStorage.setItem(CART_KEY, JSON.stringify(c)); }
    function updateCartCount() {
      document.getElementById('cart-count').textContent = getCart().reduce((s,c) => s+c.qty, 0);
    }
    function addToCart(pid) {
      let cart = getCart();
      let f = cart.find(c => c.id == pid);
      if (f) f.qty++; else cart.push({id: pid, qty: 1});
      setCart(cart);
      updateCartCount();
      alert("Added to cart!");
    }

    function showPage(page, data) {
      document.getElementById("nav-home").classList.remove("active");
      document.getElementById("nav-cart").classList.remove("active");
      if (page === 'home') document.getElementById("nav-home").classList.add("active");
      if (page === 'cart') document.getElementById("nav-cart").classList.add("active");

      if (page === 'home') renderProductList();
      else if (page === 'details') renderProductDetails(data);
      else if (page === 'cart') renderCart();
    }

    function renderProductList() {
      let html = `<div class="product-list">`;
      for (let p of PRODUCTS) {
        html += `
          <div class="card">
            <img src="${p.image}" alt="${p.name}">
            <h3>${p.name}</h3>
            <p>${p.description}</p>
            <div class="price">₹${Number(p.price).toLocaleString()}</div>
            <button onclick="showPage('details',${p.id})">View Details</button>
            <button onclick="addToCart(${p.id})">Add to Cart</button>
          </div>`;
      }
      html += `</div>`;
      document.getElementById('main-content').innerHTML = html;
    }

    function renderProductDetails(pid) {
      const prod = PRODUCTS.find(p => p.id == pid);
      if (!prod) return showPage('home');
      document.getElementById('main-content').innerHTML = `
        <div class="product-details">
          <img src="${prod.image}" alt="${prod.name}">
          <div class="product-info">
            <h2>${prod.name}</h2>
            <div class="price">₹${Number(prod.price).toLocaleString()}</div>
            <p>${prod.details}</p>
            <div style="margin:1.2rem 0;">
              <form action="payment.php" method="GET" style="display:inline;">
                <button onclick="addToCart(${prod.id})">Add to Cart</button>
                <input type="hidden" name="product_id" value="${prod.id}">
                <button type="submit">Pay Now</button>
              </form>
            </div>
            <button style="background:#e0eaff;color:#2b6399;" onclick="showPage('home')">← Back to All Products</button>
          </div>
        </div>`;
    }

    function renderCart() {
      let cart = getCart();
      if (!cart.length) {
        document.getElementById('main-content').innerHTML = `<h2>Your cart is empty.</h2>
        <button onclick="showPage('home')">← Shop Products</button>`;
        return;
      }
      let rows = '', total = 0;
      for (let c of cart) {
        let p = PRODUCTS.find(x => x.id == c.id);
        if (!p) continue;
        let subtotal = p.price * c.qty; total += subtotal;
        rows += `
          <tr>
            <td><img src="${p.image}" width="60"></td>
            <td>${p.name}</td>
            <td>₹${Number(p.price).toLocaleString()}</td>
            <td>${c.qty}</td>
            <td>₹${subtotal.toLocaleString()}</td>
            <td><button onclick="removeItem(${p.id})" style="background:#e06161;">Remove</button></td>
          </tr>`;
      }
      document.getElementById('main-content').innerHTML = `
        <h2>Your Cart</h2>
        <table class="cart-list">
          <tr><th>Image</th><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th><th></th></tr>
          ${rows}
          <tr class="total-row"><td colspan="4" style="text-align:right;">Total:</td><td colspan="2">₹${total.toLocaleString()}</td></tr>
        </table>
        <div class="cart-actions">
          <form action="payment.php" method="GET" style="display:inline;">
            <button onclick="showPage('home')" style="background:#e0eaff;color:#2b6399;">← Continue Shopping</button>
            <button type="submit">Proceed to Payment</button>
          </form>
        </div>`;
    }

    function removeItem(pid) {
      let c = getCart();
      c = c.filter(x => x.id != pid);
      setCart(c);
      renderCart();
    }

    window.showPage = showPage;
    window.addToCart = addToCart;
    window.removeItem = removeItem;
    window.onload = loadProducts;
  </script>
</body>
</html>
