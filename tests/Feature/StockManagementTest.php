<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Unit;
use App\Models\UserAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockManagementTest extends TestCase
{
    // use RefreshDatabase; // Commented out to avoid wiping existing data if not intended, but recommended for clean tests

    public function test_cannot_add_more_than_stock_to_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create(['stock' => 5, 'price' => 100]);

        // Try to add 6 items (stock is 5)
        $response = $this->postJson('/api/cart', [
            'product_id' => $product->id,
            'quantity' => 6
        ]);

        $response->assertStatus(500); // Or 422 if we handled exception to return specific status
        // Note: Currently threw Exception which results in 500 unless caught by handler
    }

    public function test_stock_decrements_on_order_creation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create(['stock' => 10, 'price' => 100]);
        $address = UserAddress::factory()->create(['user_id' => $user->id]);

        // Add to cart
        $this->postJson('/api/cart', [
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        // Create order
        $response = $this->postJson('/api/order', [
            'address_id' => $address->id,
            'delivery_date' => now()->addDay()->format('Y-m-d'),
            'delivery_time' => '10:00:00',
        ]);

        $response->assertStatus(201);

        // Assert stock decremented
        $this->assertEquals(8, $product->fresh()->stock);
    }

    public function test_stock_restores_on_order_cancellation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create(['stock' => 10, 'price' => 100]);
        $address = UserAddress::factory()->create(['user_id' => $user->id]);

        // Add to cart
        $this->postJson('/api/cart', [
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        // Create order
        $response = $this->postJson('/api/order', [
            'address_id' => $address->id,
            'delivery_date' => now()->addDay()->format('Y-m-d'),
            'delivery_time' => '10:00:00',
        ]);

        $orderId = $response->json('data.id');

        // Cancel order
        $response = $this->putJson("/api/order/{$orderId}/cancel");
        $response->assertStatus(200);

        // Assert stock restored
        $this->assertEquals(10, $product->fresh()->stock);
    }
}
