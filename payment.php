<?php
include("connection.php");

// Get product ID (if user clicked "Pay Now" for a single product)
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : null;
$product = null;

if ($product_id) {
    $sql = "SELECT * FROM supplements WHERE id = $product_id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout - Protein Supplement Store</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body { font-family: Arial, sans-serif; background: #f7f9fc; margin: 0; padding: 0; }
    .container { max-width: 700px; margin: 40px auto; background: #fff; padding: 2rem; box-shadow: 0 4px 16px rgba(0,0,0,0.1); border-radius: 12px; }
    h1 { text-align: center; margin-bottom: 20px; color: #2366a6; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    table th, table td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
    .total { font-weight: bold; font-size: 1.1rem; }
    label { display: block; margin: 10px 0 5px; font-weight: bold; }
    input, select { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 6px; }
    button { background: linear-gradient(90deg,#3a7bd5,#00d2ff); color: white; padding: 12px; border: none; border-radius: 6px; font-size: 1rem; cursor: pointer; width: 100%; }
    button:hover { opacity: 0.9; }
    .back { display: block; margin-top: 15px; text-align: center; text-decoration: none; color: #2366a6; font-weight: bold; }
    .hidden { display: none; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Checkout</h1>

    <?php if ($product): ?>
      <!-- Single product checkout -->
      <table>
        <tr><th>Product</th><th>Price</th></tr>
        <tr>
          <td><?php echo htmlspecialchars($product['name']); ?></td>
          <td>₹<?php echo number_format($product['price']); ?></td>
        </tr>
        <tr class="total"><td>Total</td><td>₹<?php echo number_format($product['price']); ?></td></tr>
      </table>
    <?php else: ?>
      <!-- Cart checkout -->
      <p>Please review your cart. (Cart will be handled by JS/localStorage)</p>
    <?php endif; ?>

    <form id="paymentForm" method="POST" action="process_payment.php" onsubmit="return validateForm()">
      <h3>Billing Details</h3>

      <label for="fullname">Full Name</label>
      <input type="text" id="fullname" name="fullname" maxlength="100" required placeholder="Enter your full name">

      <label for="email">Email</label>
      <input type="email" id="email" name="email" maxlength="150" required placeholder="example@email.com">

      <label for="address">Address</label>
      <input type="text" id="address" name="address" maxlength="150" required placeholder="Enter your address">

      <label for="payment_method">Payment Method</label>
      <select name="payment_method" id="payment_method" required onchange="togglePaymentFields()">
        <option value="">-- Select Payment Method --</option>
        <option value="cod">Cash on Delivery</option>
        <option value="credit">Credit/Debit Card</option>
        <option value="upi">UPI</option>
      </select>

      <!-- Card Payment Fields -->
      <div id="cardFields" class="hidden">
        <label for="card_number">Card Number</label>
        <input type="text" id="card_number" name="card_number" maxlength="14" placeholder="Enter 14-digit card number">

        <label for="expiry">Expiry (MMYY)</label>
        <input type="text" id="expiry" name="expiry" maxlength="4" placeholder="MMYY">

        <label for="cvv">CVV</label>
        <input type="password" id="cvv" name="cvv" maxlength="3" placeholder="3 digits">
      </div>

      <!-- UPI Field -->
      <div id="upiField" class="hidden">
        <label for="upi_id">UPI ID</label>
        <input type="text" id="upi_id" name="upi_id" placeholder="example@upi">
      </div>

      <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
      <button type="submit">Confirm & Pay</button>
    </form>

    <a href="index.php" class="back">← Back to Shop</a>
  </div>

  <script>
    // Show/Hide fields based on payment method
    function togglePaymentFields() {
      const paymentMethod = document.getElementById("payment_method").value;
      const cardFields = document.getElementById("cardFields");
      const upiField = document.getElementById("upiField");

      cardFields.classList.add("hidden");
      upiField.classList.add("hidden");

      if (paymentMethod === "credit") {
        cardFields.classList.remove("hidden");
      } else if (paymentMethod === "upi") {
        upiField.classList.remove("hidden");
      }
    }

    // Form Validation Function
    function validateForm() {
      const fullName = document.getElementById("fullname").value.trim();
      const email = document.getElementById("email").value.trim();
      const address = document.getElementById("address").value.trim();
      const paymentMethod = document.getElementById("payment_method").value;

      // Full name validation
      if (fullName.length === 0 || fullName.length > 100 || /\d/.test(fullName)) {
        alert("Full name must be less than 100 characters and cannot contain numbers.");
        return false;
      }

      // Email validation
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email) || email.length > 150) {
        alert("Please enter a valid email address (max 150 characters).");
        return false;
      }

      // Address validation
      if (address.length === 0 || address.length > 150) {
        alert("Address must be less than 150 characters.");
        return false;
      }

      // Card validation (only if user selected card)
      if (paymentMethod === "credit") {
        const cardNumber = document.getElementById("card_number").value.trim();
        const expiry = document.getElementById("expiry").value.trim();
        const cvv = document.getElementById("cvv").value.trim();

        if (!/^\d{14}$/.test(cardNumber)) {
          alert("Card number must be exactly 14 digits and numeric only.");
          return false;
        }

        if (!/^\d{4}$/.test(expiry)) {
          alert("Expiry must be exactly 4 digits (MMYY) and numeric only.");
          return false;
        }

        if (!/^\d{3}$/.test(cvv)) {
          alert("CVV must be exactly 3 digits and numeric only.");
          return false;
        }
      }

      // UPI validation (only if user selected UPI)
      if (paymentMethod === "upi") {
        const upiId = document.getElementById("upi_id").value.trim();
        const upiRegex = /^[\w.-]+@[\w.-]+$/; // basic UPI format like name@bank
        if (!upiRegex.test(upiId)) {
          alert("Please enter a valid UPI ID (example@upi).");
          return false;
        }
      }

      return true;
    }

    // Restrict invalid characters while typing
    document.getElementById("fullname").addEventListener("input", function (e) {
      e.target.value = e.target.value.replace(/\d/g, ""); // remove digits
    });

    document.getElementById("card_number").addEventListener("input", function (e) {
      e.target.value = e.target.value.replace(/\D/g, ""); // only digits
    });

    document.getElementById("expiry").addEventListener("input", function (e) {
      e.target.value = e.target.value.replace(/\D/g, ""); // only digits
    });

    document.getElementById("cvv").addEventListener("input", function (e) {
      e.target.value = e.target.value.replace(/\D/g, ""); // only digits
    });
  </script>
</body>
</html>
