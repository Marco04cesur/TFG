<?php

namespace Database\Factories;

use App\Models\Perro;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Perro>
 */
class PerroFactory extends Factory
{
   protected $model = Perro::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->firstName(),
            'raza' => fake()->randomElement(['Golden Retriever', 'Bulldog', 'Pastor Alemán', 'Poodle', 'Labrador', 'Beagle', 'Chihuahua']),
            'edad' => fake()->numberBetween(1, 14),
            'peso' => fake()->randomFloat(1, 3, 40),
            'sexo' => fake()->randomElement(['M', 'H']),
            'descripción' => fake()->sentence(10),
            'disponible' => true,
            'foto_url' => "https://placehold.jp/40/034732/ffffff/400x400.png?text=GUAU",
            'usuario_id' => Usuario::all()->random()->id, // Asigna un dueño aleatorio de los existentes
        ];
    }
}
