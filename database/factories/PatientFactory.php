<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name_patient'=>fake('es_ES')->firstName() . ' ' . fake('es_ES')->lastName(),
            'ci_patient'=>fake()->numberBetween(1000000, 1999999),
            'birth_date'=>fake()->date(),
            'gender'=>fake()->randomElement(['masculino','femenino']),
            'insurance_code'=>fake()->numberBetween(100,999),
            'patient_contact'=>fake()->numberBetween(60000000, 79999999),
            'family_contact'=>fake()->numberBetween(60000000, 79999999),          
        ];
    }
}
