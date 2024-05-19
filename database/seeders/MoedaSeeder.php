<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Moeda;

class MoedaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Moeda::create(["descricao" => "Euro", "sigla" => "EUR", "simbolo" => "€"]);
        Moeda::create(["descricao" => "Dolar", "sigla" => "USD", "simbolo" => "$"]);
        Moeda::create(["descricao" => "Yen", "sigla" => "JPY", "simbolo" => "¥"]);
        Moeda::create(["descricao" => "Libra Esterlina", "sigla" => "GBP", "simbolo" => "£"]);
    }
}
