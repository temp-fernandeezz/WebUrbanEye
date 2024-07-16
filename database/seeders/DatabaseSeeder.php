<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate([
            'name' => 'Admin',
            'type' => 'admin',
            'email' => 'nandafernandes259@gmail.com',
        ], [
            'password' => bcrypt('homolog123'),
        ]);

        \App\Models\About::updateOrCreate([
            'title' => 'Cláudio Rodrigues',
            'content' => 'Responsável pelo design do site.',
            'github_link' => 'https://github.com/ClaudioRodri',
            'linkedin_link' => 'https://www.linkedin.com/in/claudio-rodrigues-/',
            'representative_image' => 'https://media.licdn.com/dms/image/C4D03AQF0AlO1KA47iQ/profile-displayphoto-shrink_200_200/0/1660592415488?e=1726704000&v=beta&t=uC4vg8wjW2oJr_H-UpvM9H3eQxET__Pt8LbhJwtuWvs',
        ]);

        \App\Models\About::updateOrCreate([
            'title' => 'Fernanda Fernandes',
            'content' => 'Desenvolvedora Full Stack do site.',
            'github_link' => 'https://github.com/Fernandeezz',
            'linkedin_link' => 'https://www.linkedin.com/in/fernanda-fernandes-nascimento/',
            'representative_image' => 'https://media.licdn.com/dms/image/D4D03AQHJGLbthXmsEg/profile-displayphoto-shrink_200_200/0/1687194692543?e=1726704000&v=beta&t=FfkNaxJDNZky3XTeMOX8uyGSmskNiHQFh9shUifJmiE',
        ]);

        \App\Models\About::updateOrCreate([
            'title' => 'Lais Fontinele',
            'content' => 'Desenvolvedora Front-End do site.',
            'github_link' => 'https://github.com/Lais2810',
            'linkedin_link' => 'https://www.linkedin.com/in/lais-fontinele/',
            'representative_image' => 'https://media.licdn.com/dms/image/C4E03AQGmNJxtBk6yaw/profile-displayphoto-shrink_200_200/0/1655899995829?e=1726704000&v=beta&t=_Hv1AJcxg7x5N3Jhqm6U1ilzOMM8k53Db1LgG08yMqs',
        ]);

        \App\Models\About::updateOrCreate([
            'title' => 'Nycolas Neres',
            'content' => 'Responsável pela coordenação do projeto.',
            'github_link' => 'https://github.com/Nycolas-Rafa',
            'linkedin_link' => 'https://linkedin.com/in/pessoa4https://www.linkedin.com/in/nycolas-rafael-neres/',
            'representative_image' => 'https://avatars.githubusercontent.com/u/142312472?v=4',
        ]);
    }
}
