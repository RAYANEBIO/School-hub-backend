<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Serie;

class SerieSeeder extends Seeder
{
    public function run(): void
    {
        Serie::create(['nom' => 'Série A']);
        Serie::create(['nom' => 'Série B']);
        Serie::create(['nom' => 'Série C']);
        Serie::create(['nom' => 'Série D']);
    }
}