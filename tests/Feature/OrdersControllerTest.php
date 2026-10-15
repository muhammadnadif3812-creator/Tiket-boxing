<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\events;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrdersControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_saves_and_displays_total_from_event_ticket_prices(): void
    {
        $event = events::create([
            'title' => 'Festival Musik',
            'category' => 'Musik',
            'ticket_price' => 15000,
            'description' => 'Festival musik',
        ]);

        $response = $this->post(route('customer.checkout'), [
            'customer_name' => 'Nadia',
            'customer_email' => 'nadia@example.com',
            'items' => [$event->id => 2],
        ]);

        $response->assertRedirect(route('user.index', absolute: false));
        $this->assertDatabaseHas('orders', [
            'customer_email' => 'nadia@example.com',
            'total_price' => 30000,
        ]);
        $this->assertDatabaseHas('order_details', [
            'event_id' => $event->id,
            'quantity' => 2,
            'subtotal' => 30000,
        ]);

        $dashboard = $this->actingAs(User::factory()->create())
            ->get(route('dashboard'));

        $dashboard->assertOk();
        $dashboard->assertSee('Rp 30.000');
    }
}
