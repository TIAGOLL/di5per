<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * 
     */

     /*
     protected $fillable = [
        'name',
        'email',
        'password',
        'cpf'
    ];
     */
    public function run(): void
    {
        User::create(['name' => 'Luiz','email'  => 'luiz@teste.com','password'  => bcrypt('1234'),'cpf' => 12345678910]);
        User::create(['name' => 'Leo','email'   => 'Leo@teste.com','password'   => bcrypt('1234'),'cpf' => 12345678910]);
        User::create(['name' => 'Bruno','email' => 'Bruno@teste.com','password' => bcrypt('1234'),'cpf' => 12345678910]);
        User::create(['name' => 'Tiago','email' => 'Tiago@teste.com','password' => bcrypt('1234'),'cpf' => 12345678910]);
        User::create(['name' => 'Rafa','email'  => 'Rafa@teste.com','password'  => bcrypt('1234'),'cpf' => 12345678910]);
    }
}
