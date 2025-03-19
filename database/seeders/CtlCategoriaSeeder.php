<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;


class CtlCategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
       
        $data = ['Categoria 1', 'categoria 2'];
        foreach ($data as $d) {
            DB::table('ctl_categoria')->insert([
                'nombre' => $d, // assuming the column is 'name'
            ]);
        }
    }
}
