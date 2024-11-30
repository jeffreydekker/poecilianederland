<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Registratie;
use App\Models\User;

class RegistratieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::where('email', 'jeffreydekker@live.com')->first();

        // Loop to create 100 entries
        for ($i = 1; $i <= 100; $i++) {
            Registratie::create([
                'user_id' => $user1->id,
                'geslachtsnaam' => 'Cichlidae',
                'soortnaam' => 'Tilapia' . $i, // Unique soortnaam
                'vangplaats' => 'Lake Malawi',
                'AS' => ($i % 2 == 0) ? 'Ja' : 'Nee', // Alternate between 'Ja' and 'Nee'
                'KV' => ($i % 3 == 0) ? 'Ja' : 'Nee', // Alternate every 3 records
                'notitie' => 'Sample note ' . $i, // Unique note
                'ondersoort' => 'Tilapia mossambica',
                'jongen' => ($i % 2 == 0) ? 'Ja' : 'Nee', // Alternate between 'Ja' and 'Nee'
            ]);
        }
    }
}
