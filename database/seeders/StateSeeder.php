<?php

namespace Database\Seeders;

use App\Models\State;
use App\Utils\Venezuela;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class StateSeeder extends Seeder
{
    use Venezuela;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = $this->venezuela();

        foreach ($values as $row) :
            $state = State::create(['name' => $row['estado']]);
            foreach ($row['municipios'] as $item) :
                $municipality = $state->municipalities()->create(['name' => $item['municipio']]);
                foreach ($item['parroquias'] as $parishe) :
                    $municipality->parishes()->create(['name' => $parishe]);
                endforeach;
            endforeach;
        endforeach;
    }
}
