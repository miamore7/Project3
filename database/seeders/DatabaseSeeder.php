<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('password'),
    'role' => 'admin',
]);

User::create([
    'name' => 'User',
    'email' => 'user@example.com',
    'password' => Hash::make('password'),
    'role' => 'user',
]);
