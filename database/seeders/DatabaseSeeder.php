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

        \App\Models\Report::updateOrCreate([
            'user_id' => 1,
            'type' => 'flood',
            'description' => 'Área Alagada',
            'status' => 'approved',
            'address' => 'Av. Brasil',
            'city' => 'São Paulo',
            'postal_code' => '08530-300',
            'image_path' => 'none',
        ]);

        \App\Models\Report::updateOrCreate([
            'user_id' => 1,
            'type' => 'flood',
            'description' => 'Área Alagada',
            'status' => 'approved',
            'address' => 'Av. Brasil',
            'city' => 'São Paulo',
            'postal_code' => '08530-300',
            'image_path' => 'none',
            'latitude' => '-23.54107',
            'longitude' => '-46.36841',
        ]);

        \App\Models\Report::updateOrCreate([
            'user_id' => 1,
            'type' => 'flood',
            'description' => 'Área Alagada',
            'status' => 'approved',
            'address' => 'R. Ver. Diomar Novaes',
            'city' => 'São Paulo',
            'postal_code' => '08500-015',
            'image_path' => 'none',
            'latitude' => '-23.54028',
            'longitude' => '-46.36643',
        ]);

        \App\Models\Report::updateOrCreate([
            'user_id' => 1,
            'type' => 'flood',
            'description' => 'Área Alagada',
            'status' => 'approved',
            'address' => 'R. Lourenço Paganucci',
            'city' => 'São Paulo',
            'postal_code' => '08502-005',
            'image_path' => 'none',
            'latitude' => '-23.53829',
            'longitude' => '-46.36524',
        ]);

        \App\Models\Report::updateOrCreate([
            'user_id' => 1,
            'type' => 'flood',
            'description' => 'Área Alagada',
            'status' => 'approved',
            'address' => 'R. Benjamin Constant',
            'city' => 'São Paulo',
            'postal_code' => '08502-030',
            'image_path' => 'none',
            'latitude' => '-23.535220',
            'longitude' => '-46.360370',
        ]);

        \App\Models\Report::updateOrCreate([
            'user_id' => 1,
            'type' => 'flood',
            'description' => 'Área Alagada',
            'status' => 'approved',
            'address' => 'Av. Brasil',
            'city' => 'São Paulo',
            'postal_code' => '08500-025',
            'image_path' => 'none',
            'latitude' => '-23.542510',
            'longitude' => '-46.369430',
        ]);

        \App\Models\Report::updateOrCreate([
            'user_id' => 1,
            'type' => 'flood',
            'description' => 'Área Alagada',
            'status' => 'approved',
            'address' => 'R. Caetano Rúbio',
            'city' => 'São Paulo',
            'postal_code' => '08527-051',
            'image_path' => 'none',
            'latitude' => '-23.547150',
            'longitude' => '-46.377550',
        ]);

        \App\Models\Report::updateOrCreate([
            'user_id' => 1,
            'type' => 'flood',
            'description' => 'Área Alagada',
            'status' => 'approved',
            'address' => 'R. Dr. Eduardo Vaz',
            'city' => 'São Paulo',
            'postal_code' => '08534-430',
            'image_path' => 'none',
            'latitude' => '-23.553910',
            'longitude' => '-46.384050',
        ]);

        \App\Models\Report::updateOrCreate([
            'user_id' => 1,
            'type' => 'flood',
            'description' => 'Área Alagada',
            'status' => 'approved',
            'address' => 'Estrada de Poá',
            'city' => 'São Paulo',
            'postal_code' => '08526-000',
            'image_path' => 'none',
            'latitude' => '-23.554900',
            'longitude' => '-46.392030',
        ]);

        \App\Models\Report::updateOrCreate([
            'user_id' => 1,
            'type' => 'flood',
            'description' => 'Área Alagada',
            'status' => 'approved',
            'address' => 'Estrada de Poá',
            'city' => 'São Paulo',
            'postal_code' => '08526-000',
            'image_path' => 'none',
            'latitude' => '-23.554900',
            'longitude' => '-46.392030',
        ]);
    }
}
