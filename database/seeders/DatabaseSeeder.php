<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\OrganizationChart;
use App\Models\Resources\Person;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {



        $especialidades = [
            [
                'name' => 'Cardiología',
                'description' => 'Especialización en el corazón y los vasos sanguíneos.',
            ],
            [
                'name' => 'Ortopedia',
                'description' => 'Tratamiento de deformidades o discapacidades funcionales del sistema esquelético.',
            ],
            [
                'name' => 'Dermatología',
                'description' => 'Enfermedades de la piel, cabello y uñas.',
            ],
            [
                'name' => 'Neurología',
                'description' => 'Estudio del sistema nervioso.',
            ],
            [
                'name' => 'Ginecología',
                'description' => 'Salud reproductiva femenina.',
            ],
            // Agrega más especialidades según sea necesario
        ];

        foreach ($especialidades as $especialidad) {
            DB::table('specialties')->insert($especialidad);
        }

        Person::create([
            'name' => 'John',
            'father_last_name' => 'Doe',
            'mother_last_name' =>  'Doe',
            'document_number' => '00000001',
            'phone' => '951208106',
            'gender' => 'M',
        ]);

        User::create([
            'fullname' => 'John Doe Doe',
            'email' => 'admin@goyeneche.com',
            'password' => 'password',

            'person_id' => 1,
        ]);

        $positions = [
            [
                "position" => 'Dirección General',
                "level" => '1',
            ],
            [
                "position" => 'Sub Dirección',
                "level" => '2',
            ],
            [
                "position" => 'Dirección General de Administración',
                "level" => '3',
            ],
        ];


        foreach ($positions as $position) {
            OrganizationChart::create([
                "position" => $position['position'],
                "level" => $position['level'],
            ]);
        }
    }
}
