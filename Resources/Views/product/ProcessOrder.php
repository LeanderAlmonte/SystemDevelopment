<?php
namespace Resources\Views\Product;

class ProcessOrder {
    public function render($data = null, $error = null) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Process Order - Eyesightcollectibles</title>
            <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <style>
                .main-content {
                    background-color: #f4f4f4;
                    min-height: 100vh;
                }
                
                .process-order-container {
                    max-width: 800px;
                    margin: 0 auto;
                    padding: 20px;
                }

                .process-order-form {
                    display: flex;
                    flex-direction: column;
                    gap: 15px;
                }

                .form-group {
                    margin: 0;
                }

                .form-group label {
                    display: block;
                    margin-bottom: 5px;
                    font-weight: normal;
                }

                .form-group input,
                .form-group select {
                    width: 100%;
                    padding: 8px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                }

                .form-actions {
                    display: flex;
                    gap: 10px;
                    margin-top: 20px;
                }

                .form-actions button {
                    padding: 8px 20px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    background-color: #fff;
                    cursor: pointer;
                }

                .form-actions button:hover {
                    background-color: #f0f0f0;
                }

                .header {
                    padding: 20px;
                    background-color: #fff;
                    margin-bottom: 20px;
                }

                .error-message {
                    color: #dc3545;
                    margin-bottom: 15px;
                    padding: 10px;
                    background-color: #f8d7da;
                    border: 1px solid #f5c6cb;
                    border-radius: 4px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <!-- Menu Panel -->
                <div class="menu-panel">
                    <h2 class="menu-title">Menu Panel</h2>
                    <ul class="menu-items">
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards"><i class="fas fa-home"></i><span>Home</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual"><i class="fas fa-book"></i><span>View Manual</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings"><i class="fas fa-cog"></i><span>Settings</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users"><i class="fas fa-users"></i><span>Manage Users</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products"><i class="fas fa-box"></i><span>Manage Inventory</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts" class="active"><i class="fas fa-shopping-cart"></i><span>View sold products</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive"><i class="fas fa-archive"></i><span>Archived Items</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=history"><i class="fas fa-history"></i><span>History</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=sales"><i class="fas fa-chart-line"></i><span>Sales/Costs</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=auths/logout"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
                    </ul>
                </div>

                <!-- Main Content -->
                <div class="main-content">
                    <div class="header">
                        <h1 class="brand">Eyesightcollectibles</h1>
                        <div class="welcome-text">Welcome <?php echo explode(' ', $_SESSION['userName'])[0]; ?>! <i class="fas fa-user-circle"></i></div>
                    </div>

                    <div class="process-order-container">
                        <h2>Process Order</h2>
                        <?php if ($error): ?>
                            <div class="error-message"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form action="/ecommerce/Project/SystemDevelopment/index.php?url=products/processOrder" method="POST" class="process-order-form">
                            <div class="form-group">
                                <label for="productID">Product:</label>
                                <select name="productID" id="productID" required>
                                    <option value="">Select a product</option>
                                    <?php foreach ($data['products'] as $product): ?>
                                        <option value="<?php echo $product['productID']; ?>" 
                                                data-price="<?php echo $product['listedPrice']; ?>"
                                                data-quantity="<?php echo $product['quantity']; ?>">
                                            <?php echo $product['productName']; ?> (Available: <?php echo $product['quantity']; ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="salePrice">Sale Price:</label>
                                <input type="number" step="0.01" name="salePrice" id="salePrice" placeholder="Enter sale price" required>
                            </div>

                            <div class="form-group">
                                <label for="clientID">Client:</label>
                                <select name="clientID" id="clientID" required>
                                    <option value="">Select a client</option>
                                    <?php foreach ($data['clients'] as $client): ?>
                                        <option value="<?php echo $client['clientID']; ?>">
                                            <?php echo $client['clientName']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="quantitySold">Quantity:</label>
                                <input type="number" name="quantitySold" id="quantitySold" min="1" placeholder="Enter quantity" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Your Password:</label>
                                <input type="password" name="password" id="password" placeholder="Enter your password" required>
                            </div>

                            <div class="form-actions">
                                <button type="button" onclick="window.location.href='/ecommerce/Project/SystemDevelopment/index.php?url=products'">Back</button>
                                <button type="submit">Process Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const productSelect = document.getElementById('productID');
                    const salePriceInput = document.getElementById('salePrice');
                    const quantityInput = document.getElementById('quantitySold');

                    // Update price when product is selected
                    productSelect.addEventListener('change', function() {
                        const selectedOption = this.options[this.selectedIndex];
                        if (selectedOption.value) {
                            const price = selectedOption.getAttribute('data-price');
                            salePriceInput.value = price;
                            
                            // Set max quantity based on available stock
                            const maxQuantity = selectedOption.getAttribute('data-quantity');
                            quantityInput.max = maxQuantity;
                        } else {
                            salePriceInput.value = '';
                            quantityInput.max = '';
                        }
                    });

                    // Validate quantity against available stock
                    quantityInput.addEventListener('change', function() {
                        const selectedOption = productSelect.options[productSelect.selectedIndex];
                        if (selectedOption.value) {
                            const maxQuantity = parseInt(selectedOption.getAttribute('data-quantity'));
                            if (this.value > maxQuantity) {
                                alert('Quantity cannot exceed available stock: ' + maxQuantity);
                                this.value = maxQuantity;
                            }
                        }
                    });
                });
            </script>
        </body>
        </html>
        <?php
    }
}
?> 