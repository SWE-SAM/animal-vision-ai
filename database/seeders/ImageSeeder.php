<?php

use Illuminate\Database\Seeder;
use App\Models\Image;
use App\Models\User;

class ImageSeeder extends Seeder
{
    public function run()
    {
        // Get all users
        $users = User::all();

        // Ensure there are users before creating images
        if ($users->isEmpty()) {
            $this->command->info("No users found! Seeding users first...");
            $this->call(UserSeeder::class);
            $users = User::all(); // Re-fetch users
        }

        // Generate images linked to real users
        foreach ($users as $user) {
            Image::create([
                'file_path' => 'uploads/user_' . $user->id . '/sample_image.jpg',
                'uploadDate' => now(),
                'user_ID' => $user->id,
            ]);
        }
    }
}
