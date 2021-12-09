<?php

class ProductTest extends \PHPUnit\Framework\TestCase{

  public function search_product(){
        $product = new App\Models\Product;
        $result = $product->select_product_search("gent");

        $this->assertEquals("array", $result);

  }

  public function addProduct(){
        $product = new App\Models\Product;
        $result = $product->add_product(1, 'Men wear','2.0', 'Decent Wear', '../img/product/p3.png', 'gent');

        $this->assertEquals(true, $result);
  }


}

?>