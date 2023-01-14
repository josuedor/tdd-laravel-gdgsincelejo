<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Can get all products
     * @test
     */
    public function can_get_all_products(){

        Product::factory()->count(5)->create();

        $response = $this->get('api/product');
        $data = $response->getData();
        
        $response->assertStatus(200);
        $this->assertNotEmpty($data);
        $this->assertIsArray($data);
    }

    /**
     * Can store a product
     * @test
     */
    public function can_store_product(){

        $data = [
            "name"        => $this->faker->name(),
            "description" => $this->faker->realText(),
            "price"       => $this->faker->randomFloat()
        ];
        $response = $this->post('api/product', $data);
        $data = $response->getData();
        
        $response->assertStatus(201);
        $this->assertNotEmpty($data);
        $this->assertIsObject($data);
    }

    /**
     * Can show a product
     * @test
     */
    public function can_show_one_product(){
        
        $product = Product::factory()->create();
        $response = $this->get("api/product/{$product->id}");
        $data = $response->getData();
        
        $response->assertStatus(200);
        $this->assertNotEmpty($data);
        $this->assertIsObject($data);
    }

    /**
     * Can update a product
     * @test
     */
    public function can_update_product(){
        
        $product = Product::factory()->create();
        $this->assertNotEmpty($product);
        $this->assertIsInt($product->id);
        $this->assertGreaterThan(0, $product->id);

        $dataToUpdate = [
            "name"        => $this->faker->name(),
            "description" => $this->faker->realText(),
            "price"       => $this->faker->randomFloat()
        ];

        $response = $this->put("api/product/{$product->id}", $dataToUpdate);
        $data = $response->getData();
        
        $response->assertStatus(200);
        $this->assertNotEmpty($data);
        $this->assertIsObject($data);
    }

    /**
     * Can delete a product
     * @test
     */
    public function can_delete_product(){
        
        $product = Product::factory()->create();
        $response = $this->delete("api/product/{$product->id}");
        $response->assertStatus(200);
    }
}
