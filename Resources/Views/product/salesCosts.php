<?php
namespace Resources\Views\Product;

require_once(__DIR__ . '/../../../lang/lang.php');

class SalesCosts {
    public function render($data = null) {
        ?>
        <!DOCTYPE html>
        <html lang="<?php echo $_SESSION['lang'] ?? 'en'; ?>">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo lang('sales_costs'); ?> - Eyesightcollectibles</title>
            <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts"><i class="fas fa-shopping-cart"></i><span><?php echo lang('view_sold_products'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive"><i class="fas fa-archive"></i><span><?php echo lang('archived_items'); ?></span></a></li>
                        <?php if ($role === 'Admin'): ?>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users"><i class="fas fa-users"></i><span><?php echo lang('manage_users'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=historys"><i class="fas fa-history"></i><span><?php echo lang('history'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/salesCosts" class="active"><i class="fas fa-chart-line"></i><span><?php echo lang('sales_costs'); ?></span></a></li>
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

                    <div class="sales-costs-container">
                        <div class="inventory-header">
                            <div class="header-content">
                                <h2><i class="fas fa-chart-pie"></i> <?php echo lang('sales_costs_overview'); ?></h2>
                                <p><?php echo lang('view_financial_performance'); ?></p>
                            </div>
                        </div>

                        <div class="chart-container">
                            <canvas id="profitLossChart"></canvas>
                        </div>

                        <div class="financial-summary">
                            <div class="summary-card revenue">
                                <h3><?php echo lang('total_revenue'); ?></h3>
                                <p>$<?php echo number_format($data['revenue'], 2); ?></p>
                            </div>
                            <div class="summary-card costs">
                                <h3><?php echo lang('total_costs'); ?></h3>
                                <p>$<?php echo number_format($data['costs'], 2); ?></p>
                            </div>
                            <div class="summary-card profit">
                                <h3><?php echo lang('net_profit_loss'); ?></h3>
                                <p class="<?php echo $data['profit'] >= 0 ? 'positive' : 'negative'; ?>">
                                    $<?php echo number_format($data['profit'], 2); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .sales-costs-container {
                    padding: 20px;
                }

                .chart-container {
                    background: white;
                    border-radius: 8px;
                    padding: 20px;
                    margin: 20px 0;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    height: 400px;
                }

                .financial-summary {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                    gap: 20px;
                    margin-top: 20px;
                }

                .summary-card {
                    background: white;
                    border-radius: 8px;
                    padding: 20px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

                .summary-card h3 {
                    margin: 0 0 10px 0;
                    color: #666;
                    font-size: 16px;
                }

                .summary-card p {
                    margin: 0;
                    font-size: 24px;
                    font-weight: 600;
                }

                .revenue p {
                    color: #4CAF50;
                }

                .costs p {
                    color: #f44336;
                }

                .profit p.positive {
                    color: #4CAF50;
                }

                .profit p.negative {
                    color: #f44336;
                }

                .inventory-header {
                    background-color: var(--primary-color);
                    color: var(--white);
                    padding: 15px 20px;
                    border-radius: 8px;
                    margin-bottom: 20px;
                }

                .header-content {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    width: 100%;
                }

                .header-content h2 {
                    margin: 0;
                    font-size: 20px;
                    color: var(--white);
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }

                .header-content h2 i {
                    font-size: 18px;
                }

                .header-content p {
                    margin: 0;
                    font-size: 14px;
                    opacity: 0.9;
                }
            </style>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('profitLossChart').getContext('2d');
                    
                    const revenue = <?php echo $data['revenue']; ?>;
                    const costs = <?php echo $data['costs']; ?>;
                    const profit = revenue - costs;

                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: [
                                '<?php echo lang('revenue'); ?>',
                                '<?php echo lang('costs'); ?>',
                                '<?php echo lang('profit_loss'); ?>'
                            ],
                            datasets: [{
                                data: [revenue, costs, profit],
                                backgroundColor: [
                                    '#4CAF50',  // Revenue - Green
                                    '#f44336',  // Costs - Red
                                    profit >= 0 ? '#2196F3' : '#ff9800'  // Profit/Loss - Blue if positive, Orange if negative
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const label = context.label || '';
                                            const value = context.raw || 0;
                                            return `${label}: $${value.toFixed(2)}`;
                                        }
                                    }
                                }
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