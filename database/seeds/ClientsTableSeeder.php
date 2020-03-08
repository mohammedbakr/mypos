<?php

use App\Client;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $clients = ['Mohamed', 'Ahmed'];

        foreach ($clients as $client) {

            Client::create([

                'name' => $client,
                'phone' => '1111111',
                'address' => 'Dubai'
                
            ]);

        }// end of foreach

    }// end of run

}// end of seeder
