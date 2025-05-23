<?php
namespace Resources\Views\Product;

require_once(__DIR__ . '/../../../lang/lang.php');

class ProcessOrder {
    public function render($data = null, $error = null) {
        ?>
        <!DOCTYPE html>
        <html lang="<?php echo $_SESSION['lang'] ?? 'en'; ?>">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo lang('process_order'); ?> - Eyesightcollectibles</title>
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
                    padding: 12px 15px;
                    background-color: #f8d7da;
                    border: 1px solid #f5c6cb;
                    border-radius: 4px;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }

                .error-message i {
                    font-size: 18px;
                }

                .form-group {
                    margin-bottom: 20px;
                }

                .form-group label {
                    display: block;
                    margin-bottom: 5px;
                    font-weight: 500;
                    color: #333;
                }

                .form-group input,
                .form-group select {
                    width: 100%;
                    padding: 8px 12px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    font-size: 14px;
                }

                .form-group input:focus,
                .form-group select:focus {
                    border-color: var(--primary-color);
                    outline: none;
                }

                .form-actions {
                    display: flex;
                    gap: 10px;
                    margin-top: 20px;
                }

                .btn {
                    padding: 10px 20px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    font-weight: 500;
                    transition: background-color 0.3s;
                }

                .btn-primary {
                    background-color: var(--primary-color);
                    color: black;
                }

                .btn-primary:hover {
                    background-color: #d45a1a;
                }

                .btn-secondary {
                    background-color: #d45a1a;
                    color: black;
                    text-decoration: none;
                }

                .btn-secondary:hover {
                    background-color: #5a6268;
                }
            </style>
        </head>
        <body<?php $theme = $_SESSION['theme'] ?? 'Light'; echo $theme === 'Dark' ? ' class="dark-theme"' : ''; ?>>
            <div class="container">
                <!-- Menu Panel -->
                <div class="menu-panel">
                    <h2 class="menu-title"><?php echo lang('menu_panel'); ?></h2>
                    <?php $role = $_SESSION['userRole'] ?? 'Admin'; ?>
                    <ul class="menu-items">
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards"><i class="fas fa-home"></i><span><?php echo lang('home'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual"><i class="fas fa-book"></i><span><?php echo lang('view_manual'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings"><i class="fas fa-cog"></i><span><?php echo lang('settings'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products"><i class="fas fa-box"></i><span><?php echo lang('manage_inventory'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts" class="active"><i class="fas fa-shopping-cart"></i><span><?php echo lang('view_sold_products'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive"><i class="fas fa-archive"></i><span><?php echo lang('archived_items'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=clients"><i class="fas fa-user-friends"></i><span><?php echo lang('manage_clients'); ?></span></a></li>
                        <?php if ($role === 'Admin'): ?>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users"><i class="fas fa-users"></i><span><?php echo lang('manage_users'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=historys"><i class="fas fa-history"></i><span><?php echo lang('history'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/salesCosts"><i class="fas fa-chart-line"></i><span><?php echo lang('sales_costs'); ?></span></a></li>
                        <?php endif; ?>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=auths/logout"><i class="fas fa-sign-out-alt"></i><span><?php echo lang('logout'); ?></span></a></li>
                    </ul>
                </div>

                <!-- Main Content -->
                <div class="main-content">
                    <div class="header">
                        <h1 class="brand">Eyesightcollectibles</h1>
                        <div class="welcome-text"><?php echo lang('welcome') . ' ' . explode(' ', $_SESSION['userName'])[0]; ?>! <i class="fas fa-user-circle"></i></div>
                    </div>

                    <div class="process-order-container">
                        <h2><?php echo lang('process_order'); ?></h2>
                        <?php if (isset($error)): ?>
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>
                        
                        <form action="/ecommerce/Project/SystemDevelopment/index.php?url=products/processOrder" method="POST" class="process-order-form">
                            <div class="form-group">
                                <label for="productID"><?php echo lang('product'); ?>:</label>
                                <select name="productID" id="productID" required oninvalid="this.setCustomValidity('<?php echo lang('please_fill_out_this_field'); ?>')" oninput="this.setCustomValidity('')">
                                    <option value=""><?php echo lang('select_product'); ?></option>
                                    <?php foreach (
                                        $data['products'] as $product): ?>
                                        <option value="<?php echo $product['productID']; ?>" 
                                                data-price="<?php echo $product['listedPrice']; ?>"
                                                data-quantity="<?php echo $product['quantity']; ?>"
                                                <?php echo (isset($_POST['productID']) && $_POST['productID'] == $product['productID']) ? 'selected' : ''; ?>>
                                            <?php echo $product['productName']; ?> (<?php echo lang('available'); ?>: <?php echo $product['quantity']; ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="salePrice"><?php echo lang('sale_price'); ?>:</label>
                                <input type="number" id="salePrice" name="salePrice" step="0.01" value="<?php echo isset($_POST['salePrice']) ? htmlspecialchars($_POST['salePrice']) : ''; ?>" required oninvalid="this.setCustomValidity('<?php echo lang('please_fill_out_this_field'); ?>')" oninput="this.setCustomValidity('')">
                            </div>

                            <div class="form-group">
                                <label for="clientID"><?php echo lang('client'); ?>:</label>
                                <select name="clientID" id="clientID" required oninvalid="this.setCustomValidity('<?php echo lang('please_fill_out_this_field'); ?>')" oninput="this.setCustomValidity('')">
                                    <option value=""><?php echo lang('select_client'); ?></option>
                                    <?php foreach ($data['clients'] as $client): ?>
                                        <option value="<?php echo $client['clientID']; ?>"
                                                <?php echo (isset($_POST['clientID']) && $_POST['clientID'] == $client['clientID']) ? 'selected' : ''; ?>>
                                            <?php echo $client['clientName']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="quantitySold"><?php echo lang('quantity'); ?>:</label>
                                <input type="number" name="quantitySold" id="quantitySold" min="1" value="<?php echo isset($_POST['quantitySold']) ? htmlspecialchars($_POST['quantitySold']) : ''; ?>" placeholder="<?php echo lang('enter_quantity'); ?>" required oninvalid="this.setCustomValidity('<?php echo lang('please_fill_out_this_field'); ?>')" oninput="this.setCustomValidity('')">
                            </div>

                            <div class="form-group">
                                <label for="password"><?php echo lang('enter_password_to_confirm'); ?></label>
                                <input type="password" id="password" name="password" required oninvalid="this.setCustomValidity('<?php echo lang('please_fill_out_this_field'); ?>')" oninput="this.setCustomValidity('')">
                            </div>

                            <div class="form-actions">
                                <a href="/ecommerce/Project/SystemDevelopment/index.php?url=products" class="btn btn-secondary"><?php echo lang('cancel'); ?></a>
                                <button type="submit" class="btn btn-primary"><?php echo lang('process_order'); ?></button>
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
                                alert('<?php echo lang('quantity_exceed_stock'); ?>'.replace('{max}', maxQuantity));
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