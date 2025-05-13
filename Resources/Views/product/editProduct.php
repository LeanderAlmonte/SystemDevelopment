<?php
namespace resources\views\product;

class EditProduct {
    public function render($data, $error = null) {
        $product = $data['product'] ?? null;
        if (!$product) {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=products');
            exit();
        }
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Product - Eyesightcollectibles</title>
            <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        </head>
        <body>
            <div class="container">
                <!-- Menu Panel -->
                <div class="menu-panel">
                    <h2 class="menu-title"><?php echo lang('menu_panel'); ?></h2>
                    <ul class="menu-items">
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards"><i class="fas fa-home"></i><span><?php echo lang('home'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual"><i class="fas fa-book"></i><span><?php echo lang('view_manual'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings"><i class="fas fa-cog"></i><span><?php echo lang('settings'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products" class="active"><i class="fas fa-box"></i><span><?php echo lang('manage_inventory'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts"><i class="fas fa-shopping-cart"></i><span><?php echo lang('view_sold_products'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive"><i class="fas fa-archive"></i><span><?php echo lang('archived_items'); ?></span></a></li>
                        <?php if ($_SESSION['userRole'] === 'Admin'): ?>
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

                    <div class="edit-product-container">
                        <h2><?php echo lang('edit'); ?> <?php echo lang('product'); ?></h2>
                        <?php if (isset($error)): ?>
                            <div class="error-message"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=products/update" class="edit-product-form">
                            <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>">
                            
                            <div class="form-group">
                                <label for="productName"><?php echo lang('product_name'); ?></label>
                                <input type="text" id="productName" name="productName" placeholder="<?php echo lang('enter_product_name'); ?>" value="<?php echo htmlspecialchars($product['productName']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="category"><?php echo lang('category'); ?></label>
                                <select id="category" name="category" required>
                                    <option value="" disabled><?php echo lang('select_category'); ?></option>
                                    <option value="Pokemon Japanese" <?php echo $product['category'] === 'pokemon-japanese' ? 'selected' : ''; ?>>Pokemon Japanese</option>
                                    <option value="Pokemon Korean" <?php echo $product['category'] === 'pokemon-korean' ? 'selected' : ''; ?>>Pokemon Korean</option>
                                    <option value="pokemon-chinese" <?php echo $product['category'] === 'pokemon-chinese' ? 'selected' : ''; ?>>Pokemon Chinese</option>
                                    <option value="card-accessories" <?php echo $product['category'] === 'card-accessories' ? 'selected' : ''; ?>>Card Accessories</option>
                                    <option value="weiss-schwarz" <?php echo $product['category'] === 'weiss-schwarz' ? 'selected' : ''; ?>>Weiss Schwarz</option>
                                    <option value="kayou-naruto" <?php echo $product['category'] === 'kayou-naruto' ? 'selected' : ''; ?>>Kayou Naruto</option>
                                    <option value="kayou" <?php echo $product['category'] === 'kayou' ? 'selected' : ''; ?>>Kayou</option>
                                    <option value="dragon-ball-japanese" <?php echo $product['category'] === 'dragon-ball-japanese' ? 'selected' : ''; ?>>Dragon Ball Japanese</option>
                                    <option value="one-piece-japanese" <?php echo $product['category'] === 'one-piece-japanese' ? 'selected' : ''; ?>>One Piece Japanese</option>
                                    <option value="carreda-demon-slayer" <?php echo $product['category'] === 'carreda-demon-slayer' ? 'selected' : ''; ?>>Carreda Demon Slayer</option>
                                    <option value="pokemon-plush" <?php echo $product['category'] === 'pokemon-plush' ? 'selected' : ''; ?>>Pokemon Plush</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="listedPrice"><?php echo lang('listed_price'); ?></label>
                                <input type="number" id="listedPrice" name="listedPrice" placeholder="<?php echo lang('enter_listed_price'); ?>" step="0.01" min="0" value="<?php echo $product['listedPrice']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="paidPrice"><?php echo lang('paid_price'); ?></label>
                                <input type="number" id="paidPrice" name="paidPrice" placeholder="<?php echo lang('enter_paid_price'); ?>" step="0.01" min="0" value="<?php echo $product['paidPrice']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="quantity"><?php echo lang('quantity'); ?></label>
                                <input type="number" id="quantity" name="quantity" placeholder="<?php echo lang('enter_quantity'); ?>" min="0" value="<?php echo $product['quantity']; ?>" required>
                            </div>

                            <div class="form-actions">
                                <button type="button" onclick="window.location.href='/ecommerce/Project/SystemDevelopment/index.php?url=products'"><?php echo lang('back'); ?></button>
                                <button type="submit"><?php echo lang('update'); ?> <?php echo lang('product'); ?></button>
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
