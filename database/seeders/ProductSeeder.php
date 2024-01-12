<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'category_id'=>1,
                'storehouse_id'=>1,
                's_name'=>'Lansoprazole',
                't_name'=>'Lansoprazole',
                'company_name'=>'Tameco',
                'amount'=>9,
                'ending_date'=>'15/3/2024',
                'price'=>200,
             //   'created_at'=> Carbon::now(),
             //   'updated_at'=> Carbon::now()


            ],
            [
                'category_id'=>1,
                'storehouse_id'=>1,
                's_name'=>'Omeprazole',
                't_name'=>'Omeprazole',
                'company_name'=>'Medico',
                'amount'=>10,
                'ending_date'=>'20/7/2024',
                'price'=>300,
            //    'created_at'=> Carbon::now(),
            //    'updated_at'=> Carbon::now()

            ],
            [
                'category_id'=>1,
                'storehouse_id'=>1,
                's_name'=>'Pantoprazole',
                't_name'=>'Pantoprazole',
                'company_name'=>'Maatouk',
                'amount'=>17,
                'ending_date'=>'14/8/2024',
                'price'=>450,
            //    'created_at'=> Carbon::now(),
            //    'updated_at'=> Carbon::now()
            ],
            [
                'category_id'=>2,
                'storehouse_id'=>1,
                's_name'=>'Proventil',
                't_name'=>'Proventil Albuterol',
                'company_name'=>'Tameco',
                'amount'=>15,
                'ending_date'=>'19/2/2024',
                'price'=>450,
            //    'created_at'=> Carbon::now(),
            //    'updated_at'=> Carbon::now()
            ],
            [
                'category_id'=>2,
                'storehouse_id'=>1,
                's_name'=>'Tornalate',
                't_name'=>'Tornalate Bitolterol',
                'company_name'=>'Medico',
                'amount'=>12,
                'ending_date'=>'23/9/2024',
                'price'=>250,
            //    'created_at'=> Carbon::now(),
            //    'updated_at'=> Carbon::now()
            ],
            [
                'category_id'=>2,
                'storehouse_id'=>1,
                's_name'=>'Alupent',
                't_name'=>'Alupent Metaproterenol ',
                'company_name'=>'Maatouk',
                'amount'=>10,
                'ending_date'=>'20/9/2024',
                'price'=>350,
            //    'created_at'=> Carbon::now(),
            //    'updated_at'=> Carbon::now()
            ],
            [
                'category_id'=>2,
                'storehouse_id'=>1,
                's_name'=>'Metaprel',
                't_name'=>'Metaprel Birputerol ',
                'company_name'=>'Medico',
                'amount'=> 7,
                'ending_date'=>'13/12/2024',
                'price'=>200,
            //    'created_at'=> Carbon::now(),
            //    'updated_at'=> Carbon::now()
            ],
            [
                'category_id'=>3,
                'storehouse_id'=>1,
                's_name'=>'Acetaminophen',
                't_name'=>'Acetaminophen',
                'company_name'=>'Tameco',
                'amount'=>14,
                'ending_date'=>'15/4/2024',
                'price'=>500,
            //    'created_at'=> Carbon::now(),
            //    'updated_at'=> Carbon::now()
            ],
            [
                'category_id'=>3,
                'storehouse_id'=>1,
                's_name'=>'Ibuprofen',
                't_name'=>'Ibuprofen PainKiller',
                'company_name'=>'Maatouk',
                'amount'=>5,
                'ending_date'=>'5/7/2024',
                'price'=>150,
            //    'created_at'=> Carbon::now(),
            //    'updated_at'=> Carbon::now()
            ],
            [
                'category_id'=>3,
                'storehouse_id'=>1,
                's_name'=>'Aspirin',
                't_name'=>'Aspirin PainKiller',
                'company_name'=>'Medico',
                'amount'=>10,
                'ending_date'=>'21/8/2024',
                'price'=>150,
            //    'created_at'=> Carbon::now(),
            //    'updated_at'=> Carbon::now()
            ],
            [
                'category_id'=>1,
                'storehouse_id'=>1,
                's_name'=>'Maxair',
                't_name'=>'Maxair Pirtubterol',
                'company_name'=>'Tameco',
                'amount'=>16,
                'ending_date'=>'18/5/2024',
                'price'=>300,
            //    'created_at'=> Carbon::now(),
            //    'updated_at'=> Carbon::now()
            ],

        ]);

        DB::table('categories')->insert([
            [
                'name'=>'Digestive'
            ],
            [
                'name'=>'Respiratory'
            ],
            [
                'name'=>'Dental'
            ]
    ]);

    DB::table('storehouses')->insert([
        [
            'name'=>'First Store',
            'user_id'=>2
        ],
        [
            'name'=>'Second store',
            'user_id'=>4
        ]
]);

    DB::table('users')->insert([
        [
            'name'=>'Nicolas',
            'phone_number'=>'0937029983',
            'password'=>  bcrypt('nicolas2003'),
            'role'=>0

        ],
        [
            'name'=>'Michline',
            'phone_number'=>'0956782632',
            'password'=>bcrypt('micho2003'),
            'role'=>1

        ],
        [
            'name'=>'Mounir',
            'phone_number'=>'0955773425',
            'password'=>bcrypt('mounir2003'),
            'role'=>0

        ],
        [
            'name'=>'Dona',
            'phone_number'=>'0964352786',
            'password'=>bcrypt('donaa2003'),
            'role'=>1

        ],

    ]);
    }
}
