<?php 

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    // Signature of the command
    protected $signature = 'user:create {name} {email} {password}';
    
    // Description of the command
    protected $description = 'Creates a new user';

    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        if (User::where('email', $email)->exists()) {
            $this->error('Email already exists!');
            return;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('User created successfully!');
    }
}
