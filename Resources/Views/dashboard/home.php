<?php
namespace Resources\Views\Dashboard;

class Home {
    public function render($data = null) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Dashboard - Eyesightcollectibles</title>
            <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <style>
                .dashboard-container {
                    padding: 20px;
                }

                .dashboard-grid {
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
                    gap: 20px;
                    margin-bottom: 20px;
                }

                .dashboard-card {
                    background: white;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    padding: 20px;
                }

                .dashboard-card h3 {
                    margin: 0 0 15px 0;
                    color: #333;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }

                .dashboard-card h3 i {
                    color: var(--primary-color);
                }

                .product-list {
                    list-style: none;
                    padding: 0;
                    margin: 0;
                }

                .product-item {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 10px 0;
                    border-bottom: 1px solid #eee;
                }

                .product-item:last-child {
                    border-bottom: none;
                }

                .product-info {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }

                .product-rank {
                    width: 24px;
                    height: 24px;
                    background: var(--primary-color);
                    color: white;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 12px;
                    font-weight: bold;
                }

                .pokemon-card {
                    background: white;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    padding: 20px;
                    text-align: center;
                }

                .pokemon-image {
                    width: 200px;
                    height: 200px;
                    margin: 0 auto 15px;
                }

                .pokemon-name {
                    font-size: 24px;
                    color: #333;
                    margin: 0 0 10px 0;
                    text-transform: capitalize;
                }

                .pokemon-types {
                    display: flex;
                    gap: 10px;
                    justify-content: center;
                    margin-bottom: 15px;
                }

                .pokemon-type {
                    padding: 5px 10px;
                    border-radius: 15px;
                    font-size: 14px;
                    color: white;
                }

                .refresh-btn {
                    background: var(--primary-color);
                    color: white;
                    border: none;
                    padding: 8px 15px;
                    border-radius: 4px;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    gap: 5px;
                    margin: 0 auto;
                }

                .refresh-btn:hover {
                    background: #d15a1a;
                }

                .stats-grid {
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
                    gap: 10px;
                    margin-top: 15px;
                }

                .stat-item {
                    background: #f8f9fa;
                    padding: 10px;
                    border-radius: 4px;
                    text-align: center;
                }

                .stat-label {
                    font-size: 12px;
                    color: #666;
                    margin-bottom: 5px;
                }

                .stat-value {
                    font-size: 16px;
                    font-weight: bold;
                    color: #333;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <!-- Menu Panel -->
                <div class="menu-panel">
                    <h2 class="menu-title">Menu Panel</h2>
                    <ul class="menu-items">
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards" class="active"><i class="fas fa-home"></i><span>Home</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual"><i class="fas fa-book"></i><span>User Manual</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings"><i class="fas fa-cog"></i><span>Settings</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users"><i class="fas fa-users"></i><span>Manage Users</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products"><i class="fas fa-box"></i><span>Manage Inventory</span></a></li>
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

                    <div class="dashboard-container">
                        <div class="dashboard-grid">
                            <!-- Top 5 Best Sellers -->
                            <div class="dashboard-card">
                                <h3><i class="fas fa-trophy"></i> Top 5 Best Sellers</h3>
                                <ul class="product-list">
                                    <?php if (isset($data['bestSellers']) && !empty($data['bestSellers'])): ?>
                                        <?php foreach ($data['bestSellers'] as $index => $product): ?>
                                            <li class="product-item">
                                                <div class="product-info">
                                                    <span class="product-rank"><?php echo $index + 1; ?></span>
                                                    <span><?php echo htmlspecialchars($product['productName']); ?></span>
                                                </div>
                                                <span><?php echo htmlspecialchars($product['totalSold']); ?> sold</span>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li class="product-item">No sales data available</li>
                                    <?php endif; ?>
                                </ul>
                            </div>

                            <!-- Top 5 Most Stocked -->
                            <div class="dashboard-card">
                                <h3><i class="fas fa-box"></i> Top 5 Most Stocked</h3>
                                <ul class="product-list">
                                    <?php if (isset($data['mostStocked']) && !empty($data['mostStocked'])): ?>
                                        <?php foreach ($data['mostStocked'] as $index => $product): ?>
                                            <li class="product-item">
                                                <div class="product-info">
                                                    <span class="product-rank"><?php echo $index + 1; ?></span>
                                                    <span><?php echo htmlspecialchars($product['productName']); ?></span>
                                                </div>
                                                <span><?php echo htmlspecialchars($product['quantity']); ?> in stock</span>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li class="product-item">No stock data available</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>

                        <!-- Random Pokemon Card -->
                        <div class="pokemon-card">
                            <h3><i class="fas fa-dragon"></i> Random Pokemon</h3>
                            <div id="pokemonContent">
                                <img id="pokemonImage" class="pokemon-image" src="" alt="Pokemon">
                                <h4 id="pokemonName" class="pokemon-name"></h4>
                                <div id="pokemonTypes" class="pokemon-types"></div>
                                <div class="stats-grid">
                                    <div class="stat-item">
                                        <div class="stat-label">Height</div>
                                        <div id="pokemonHeight" class="stat-value"></div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-label">Weight</div>
                                        <div id="pokemonWeight" class="stat-value"></div>
                                    </div>
                                </div>
                                <button class="refresh-btn" onclick="fetchRandomPokemon()">
                                    <i class="fas fa-sync-alt"></i> Get Another Pokemon
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Function to fetch a random Pokemon
                async function fetchRandomPokemon() {
                    try {
                        const randomId = Math.floor(Math.random() * 898) + 1; // There are 898 Pokemon
                        const response = await fetch(`https://pokeapi.co/api/v2/pokemon/${randomId}`);
                        const data = await response.json();

                        // Update Pokemon image
                        document.getElementById('pokemonImage').src = data.sprites.front_default;
                        
                        // Update Pokemon name
                        document.getElementById('pokemonName').textContent = data.name;

                        // Update Pokemon types
                        const typesContainer = document.getElementById('pokemonTypes');
                        typesContainer.innerHTML = '';
                        data.types.forEach(type => {
                            const typeSpan = document.createElement('span');
                            typeSpan.className = 'pokemon-type';
                            typeSpan.style.backgroundColor = getTypeColor(type.type.name);
                            typeSpan.textContent = type.type.name;
                            typesContainer.appendChild(typeSpan);
                        });

                        // Update Pokemon stats
                        document.getElementById('pokemonHeight').textContent = (data.height / 10) + ' m';
                        document.getElementById('pokemonWeight').textContent = (data.weight / 10) + ' kg';

                    } catch (error) {
                        console.error('Error fetching Pokemon:', error);
                    }
                }

                // Function to get color based on Pokemon type
                function getTypeColor(type) {
                    const colors = {
                        normal: '#A8A878',
                        fire: '#F08030',
                        water: '#6890F0',
                        electric: '#F8D030',
                        grass: '#78C850',
                        ice: '#98D8D8',
                        fighting: '#C03028',
                        poison: '#A040A0',
                        ground: '#E0C068',
                        flying: '#A890F0',
                        psychic: '#F85888',
                        bug: '#A8B820',
                        rock: '#B8A038',
                        ghost: '#705898',
                        dragon: '#7038F8',
                        dark: '#705848',
                        steel: '#B8B8D0',
                        fairy: '#EE99AC'
                    };
                    return colors[type] || '#777';
                }

                // Fetch a random Pokemon when the page loads
                document.addEventListener('DOMContentLoaded', fetchRandomPokemon);
            </script>
        </body>
        </html>
        <?php
    }
} 