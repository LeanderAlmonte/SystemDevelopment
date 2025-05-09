<?php
namespace resources\views\product;

class AddProduct {
    public function render($error = null) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Add Product - Eyesightcollectibles</title>
            <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        </head>
        <body>
            <div class="container">
                <!-- Menu Panel -->
                <div class="menu-panel">
                    <h2 class="menu-title">Menu Panel</h2>
                    <ul class="menu-items">
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards"><i class="fas fa-home"></i><span>Home</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual"><i class="fas fa-book"></i><span>User Manual</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings"><i class="fas fa-cog"></i><span>Settings</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users"><i class="fas fa-users"></i><span>Manage Users</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products" class="active"><i class="fas fa-box"></i><span>Manage Inventory</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts"><i class="fas fa-shopping-cart"></i><span>Sold Products</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive"><i class="fas fa-archive"></i><span>Archived Items</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=historys"><i class="fas fa-history"></i><span>History</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/salesCosts"><i class="fas fa-chart-line"></i><span>Sales/Costs</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=auths/logout"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
                    </ul>
                </div>

                <!-- Main Content -->
                <div class="main-content">
                    <div class="header">
                        <h1 class="brand">Eyesightcollectibles</h1>
                        <div class="welcome-text">Welcome <?php echo explode(' ', $_SESSION['userName'])[0]; ?>! <i class="fas fa-user-circle"></i></div>
                    </div>

                    <div class="add-product-container">
                        <h2>New Product</h2>
                        <?php if (isset($error)): ?>
                            <div class="error-message"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=products/create" class="add-product-form">
                            <div class="form-group">
                                <label for="productName">Product Name</label>
                                <input type="text" id="productName" name="productName" placeholder="Enter product name" required>
                            </div>

                            <div class="form-group">
                                <label for="category">Category</label>
                                <select id="category" name="category" required>
                                    <option value="" disabled selected>Select Category</option>
                                    <?php
                                    $productController = new \Controllers\ProductController();
                                    $categories = $productController->getCategories();
                                    foreach ($categories as $value => $label) {
                                        if ($value !== 'all') { // Skip 'all' category as it's not for selection
                                            echo "<option value=\"$value\">$label</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="listedPrice">Listed Price</label>
                                <input type="number" id="listedPrice" name="listedPrice" placeholder="Enter listed price" step="0.01" min="0" required>
                            </div>

                            <div class="form-group">
                                <label for="paidPrice">Paid Price</label>
                                <input type="number" id="paidPrice" name="paidPrice" placeholder="Enter paid price" step="0.01" min="0" required>
                            </div>

                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" min="0" required>
                            </div>

                            <div class="form-actions">
                                <button type="button" onclick="window.location.href='/ecommerce/Project/SystemDevelopment/index.php?url=products'">Back</button>
                                <button type="submit">Add Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}
