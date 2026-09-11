<?php

namespace Database\Factories;

use App\Models\PpdbRegistration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PpdbRegistration>
 */
class PpdbRegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenjang = fake()->randomElement(['sd', 'smp', 'smk']);
        return [
            'no_pendaftaran' => 'PPDB-' . date('Y') . '-' . fake()->unique()->numerify('####'),
            'jenjang' => $jenjang,
            'major_choice' => $jenjang === 'smk' ? fake()->randomElement(['Rekayasa Perangkat Lunak (RPL)', 'Teknik Komputer & Jaringan (TKJ)', 'Desain Komunikasi Visual (DKV)']) : null,
            'full_name' => fake()->name(),
            'gender' => fake()->randomElement(['L', 'P']),
            'birth_date' => fake()->dateTimeBetween('-16 years', '-6 years')->format('Y-m-d'),
            'address' => fake()->address(),
            'parent_name' => fake()->name(),
            'parent_phone' => fake()->phoneNumber(),
            'status' => 'pending',
            'notes' => fake()->sentence(),
        ];
    }
}
