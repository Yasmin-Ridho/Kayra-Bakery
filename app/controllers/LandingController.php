<?php

require_once 'core/autoload.php';
require_once 'app/models/Product.php';

/**
 * Landing Controller
 * 
 * Controller untuk menangani halaman landing/homepage
 */

class LandingController extends Controller
{
    /**
     * Halaman index landing
     */
    public function index()
    {
        // Get 4 random products from database
        $randomProducts = $this->getRandomProducts(4);

        $this->view('landings/index', [
            'randomProducts' => $randomProducts
        ]);
    }

    /**
     * Get random products from database
     */
    private function getRandomProducts($limit = 4)
    {
        try {
            $pdo = DB();
            
            // Get random products with RAND() function
            $sql = "SELECT * FROM products WHERE stock > 0 ORDER BY RAND() LIMIT :limit";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            $results = [];
            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $product = new Product();
                $product->fillFromDatabase($data);
                $product->exists = true;
                $product->original = $data;
                $results[] = $product;
            }
            
            return $results;
        } catch (Exception $e) {
            // If error, return empty array
            return [];
        }
    }
}

?> 