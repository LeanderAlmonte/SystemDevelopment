<?php

namespace Controllers;

use Models\Product;
use Models\Sales;
use Resources\Views\Dashboard\Home;
use Resources\Views\Dashboard\Manual;

require_once(dirname(__DIR__) . '/Models/Product.php');
require_once(dirname(__DIR__) . '/Models/Sales.php');
require_once(dirname(__DIR__) . '/Resources/Views/Dashboard/Home.php');
require_once(dirname(__DIR__) . '/Resources/Views/Dashboard/Manual.php');

class DashboardController {
    private Product $product;
    private Sales $sales;
    private Home $homeView;
    private Manual $manualView;

    public function __construct() {
        $this->product = new Product();
        $this->sales = new Sales();
        // $this->homeView = new Home();
        $this->manualView = new Manual();
    }

    public function read() {
        // Get top 5 best sellers
        $bestSellers = $this->sales->getTopSellers(5);
        
        // Get top 5 most stocked products
        $mostStocked = $this->product->getMostStocked(5);
        
        $data = [
            'bestSellers' => $bestSellers,
            'mostStocked' => $mostStocked
        ];
        
        $home = new Home();
        $home->render($data);
    }

    public function manual() {
        $this->manualView->render();
    }
} 