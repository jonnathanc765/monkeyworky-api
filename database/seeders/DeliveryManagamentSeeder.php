<?php

namespace Database\Seeders;

use App\Models\DeliveryManagement;
use Illuminate\Database\Seeder;

class DeliveryManagamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DeliveryManagement::create([
            'name' => 'Delivery',
            'description' => 'El tiempo estimado de entrega para el delivery es de 48 horas. Para
            mayor información escriba al 04121654567.',
            'icon' => 'icons-sky/icons/delivery.svg',
            'icon_active' => 'icons-sky/icons/delivery-click.svg',
        ]);

        DeliveryManagement::create([
            'name' => 'Retiro en tienda',
            'description' => 'Av. Circunvalación Norte con Av. Las Industrias, Zona Industrial II.
            Local Nro. S/N. Zona Oeste. Barquisimeto, Edo.Lara',
            'icon' => 'icons-sky/icons/retiro-tienda.svg',
            'icon_active' => 'icons-sky/icons/retiro-tienda-click.svg',
        ]);
    }
}
