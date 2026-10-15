<?php

namespace Tests\Feature;

use App\Models\events;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_an_event_from_the_dashboard_link(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee(route('event.admin.create'), false);

        $this->actingAs($admin)
            ->get(route('event.admin.create'))
            ->assertOk()
            ->assertSee(route('event.admin.store'), false);
    }

    public function test_admin_can_store_an_event_without_an_image(): void
    {
        $response = $this->actingAs(User::factory()->create())
            ->post(route('event.admin.store'), [
                'title' => 'Festival Baru',
                'category' => 'Festival',
                'ticket_price' => 25000,
                'description' => 'Festival tahunan',
            ]);

        $response->assertRedirect(route('event.admin.index', absolute: false));
        $response->assertSessionHas('success', 'Data event berhasil ditambahkan.');
        $this->assertDatabaseHas('events', [
            'title' => 'Festival Baru',
            'category' => 'Festival',
            'ticket_price' => 25000,
            'description' => 'Festival tahunan',
        ]);
    }

    public function test_admin_can_open_the_event_edit_form(): void
    {
        $event = events::create([
            'title' => 'Festival Musik',
            'category' => 'Musik',
            'ticket_price' => 15000,
            'description' => 'Festival musik',
        ]);

        $response = $this->actingAs(User::factory()->create())
            ->get(route('event.admin.edit', ['event' => $event->id]));

        $response->assertOk();
        $response->assertSee('Festival Musik');
        $response->assertSee(route('event.admin.update', ['event' => $event->id]), false);
    }

    public function test_admin_can_update_an_event_from_the_edit_form(): void
    {
        $event = events::create([
            'title' => 'Festival Musik',
            'category' => 'Musik',
            'ticket_price' => 15000,
            'description' => 'Festival musik',
        ]);

        $response = $this->actingAs(User::factory()->create())
            ->put(route('event.admin.update', ['event' => $event->id]), [
                'title' => 'Festival Baru',
                'category' => 'Festival',
                'ticket_price' => 25000,
                'description' => 'Deskripsi terbaru',
            ]);

        $response->assertRedirect(route('event.admin.index', absolute: false));
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Festival Baru',
            'category' => 'Festival',
            'ticket_price' => 25000,
            'description' => 'Deskripsi terbaru',
        ]);
    }

    public function test_admin_can_delete_an_event(): void
    {
        $event = events::create([
            'title' => 'Festival Musik',
            'category' => 'Musik',
            'ticket_price' => 15000,
            'description' => 'Festival musik',
        ]);

        $response = $this->actingAs(User::factory()->create())
            ->delete(route('event.admin.destroy', $event));

        $response->assertRedirect(route('event.admin.index', absolute: false));
        $response->assertSessionHas('success', 'Data Event berhasil dihapus!');
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }
}
