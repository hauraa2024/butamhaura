<?php

namespace Tests\Feature;

use App\Models\GuestEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class GuestEntryFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_can_submit_guest_entry_with_valid_captcha(): void
    {
        $payload = [
            'name' => 'Rina',
            'email' => 'rina@example.com',
            'phone' => '08120000000',
            'organization' => 'Acme',
            'person_to_meet' => 'Pak Budi',
            'visit_date' => now()->toDateString(),
            'purpose' => 'Mengantarkan dokumen',
            'captcha' => 7,
        ];

        $response = $this->withSession(['guest_captcha_answer' => 7])->post(route('guest.store'), $payload);

        $response->assertRedirect(route('landing'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('guest_entries', [
            'email' => 'rina@example.com',
            'status' => GuestEntry::STATUS_PENDING,
        ]);
    }

    public function test_submission_with_wrong_captcha_fails(): void
    {
        $payload = [
            'name' => 'Rina',
            'email' => 'rina@example.com',
            'purpose' => 'Mengantarkan dokumen',
            'captcha' => 5,
        ];

        $response = $this->withSession(['guest_captcha_answer' => 7])->from(route('landing'))->post(route('guest.store'), $payload);

        $response->assertRedirect(route('landing'));
        $response->assertSessionHasErrors('captcha');
        $this->assertDatabaseCount('guest_entries', 0);
    }

    public function test_admin_can_approve_and_delete_guest_entry(): void
    {
        $admin = User::factory()->create([
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
        ]);

        $entry = GuestEntry::factory()->create();

        $approve = $this->actingAs($admin)->post(route('admin.guests.approve', $entry), [
            'notes' => 'Silakan masuk',
        ]);

        $approve->assertRedirect(route('admin.guests.index'));

        $this->assertDatabaseHas('guest_entries', [
            'id' => $entry->id,
            'status' => GuestEntry::STATUS_APPROVED,
            'notes' => 'Silakan masuk',
        ]);

        $delete = $this->actingAs($admin)->delete(route('admin.guests.destroy', $entry));

        $delete->assertRedirect(route('admin.guests.index'));
        $this->assertDatabaseMissing('guest_entries', ['id' => $entry->id]);
    }
}
