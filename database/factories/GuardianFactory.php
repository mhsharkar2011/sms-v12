<?php

namespace Database\Factories;

use App\Models\Guardian;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuardianFactory extends Factory
{
    protected $model = Guardian::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'guardian_id' => Guardian::generateGuardianId(),
            'relationship' => $this->faker->randomElement(['Father', 'Mother', 'Guardian']),
            'occupation' => $this->faker->jobTitle(),
            'employer' => $this->faker->company(),
            'work_phone' => $this->faker->phoneNumber(),
            'work_email' => $this->faker->companyEmail(),
            'emergency_contact_name' => $this->faker->name(),
            'emergency_contact_phone' => $this->faker->phoneNumber(),
            'emergency_contact_relationship' => $this->faker->randomElement(['Spouse', 'Sibling', 'Grandparent']),
            'medical_notes' => $this->faker->optional()->sentence(),
            'notes' => $this->faker->optional()->paragraph(),
            'is_primary' => $this->faker->boolean(80),
            'can_pickup' => $this->faker->boolean(90),
            'receive_sms_alerts' => $this->faker->boolean(80),
            'receive_email_alerts' => $this->faker->boolean(90),
            'is_active' => true,
        ];
    }
}
