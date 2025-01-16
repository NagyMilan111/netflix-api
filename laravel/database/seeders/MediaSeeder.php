<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Media;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    public function run()
    {
        $genres = Genre::all();
        $movieTitles = [
            'Inception', 'The Dark Knight', 'Interstellar', 'The Matrix', 'Gladiator', 'Mad Max: Fury Road', 'John Wick', 'Die Hard', 'Mission Impossible', 'The Bourne Identity',
            'The Hangover', 'Superbad', 'Bridesmaids', 'Step Brothers', 'Anchorman', 'Dumb and Dumber', 'Ted', '21 Jump Street', 'The Big Lebowski', 'Groundhog Day',
            'The Shawshank Redemption', 'Forrest Gump', 'The Godfather', 'Schindler\'s List', 'Titanic', 'The Pursuit of Happyness', 'A Beautiful Mind', 'The Green Mile', 'Good Will Hunting', 'The Help',
            'The Exorcist', 'The Shining', 'Hereditary', 'Get Out', 'A Quiet Place', 'The Conjuring', 'Insidious', 'Sinister', 'The Babadook', 'It',
            'Blade Runner 2049', 'Star Wars: A New Hope', 'The Martian', 'Arrival', 'Avatar', 'Inception', 'The Fifth Element', 'The Terminator', 'Alien', 'Predator',
            'The Silence of the Lambs', 'Se7en', 'Gone Girl', 'Prisoners', 'The Girl with the Dragon Tattoo', 'Shutter Island', 'Zodiac', 'The Prestige', 'Memento', 'The Departed',
            'Free Solo', 'Jiro Dreams of Sushi', 'Won\'t You Be My Neighbor?', 'The Act of Killing', '13th', 'Blackfish', 'Man on Wire', 'The Cove', 'Amy', 'Citizenfour'
        ];

        $index = 0; // Start from the first movie title

        foreach ($genres as $genre) {
            for ($i = 0; $i < 10; $i++) {
                Media::create([
                    'title' => $movieTitles[$index],
                    'genre_id' => $genre->genre_id,
                    'duration' => '02:00:00',
                ]);
                $index++; // Move to the next movie title
            }
        }
    }
}