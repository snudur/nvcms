<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Notendur
        \App\User::create([
            'name' => 'Netvistun',
            'email' => 'vinna@netvistun.is',
            'password' => bcrypt(env('NETVISTUN')),
            'remember_token' => str_random(10),
        ]);

        factory(App\Page::class)->create([
            'title' => 'Hafa samband',
            'status' => 1,
            'slug' => 'hafa-samband',
            'content' => '<p>Sendu okkur skilaboð hér fyrir neðan.</p>'
        ]);


        $um_okkur = factory(App\Page::class)->create([
            'title' => 'Um okkur',
            'status' => 1,
            'slug' => 'um-okkur',
            'content' => '<p>Mér hefur gengið mjög vel í þessum tilraunum og er alltaf að prufa nýtt í hverri uppskrift svo hef ég verið að gefa ættingjum og vinum sem eru tilraunadýrin hjá mér, einnig erum við á heimilinu alveg farin að nota þessar sápur eingöngu, algjörlega hætt að nota aðrar handsápur. Þessar eru svo mjúkar og fara vel með húðina algjör viðsnúningur  hjá mér, ég var alltaf með vandamála húð áður, þökk sé þér að halda svona námskeið.</p>'
        ]);

        factory(App\Page::class, 5)->create([
            'parent_id' => $um_okkur->id
        ]); 

        factory(App\Page::class, 2)->create();

        $p1 = factory(App\Page::class)->create();    

        factory(App\Page::class)->create(['parent_id' => $p1->id]);    
        factory(App\Page::class)->create(['parent_id' => $p1->id]);    

        $p2 = factory(App\Page::class)->create(['parent_id' => $p1->id]);    
        $p3 = factory(App\Page::class)->create(['parent_id' => $p2->id]);    

        factory(App\Page::class)->create(['parent_id' => $p2->id]);    
        factory(App\Page::class)->create(['parent_id' => $p2->id]);    

        $p4 = factory(App\Page::class)->create(['parent_id' => $p3->id]);

        factory(App\Page::class)->create(['parent_id' => $p1->id]);    
        factory(App\Page::class)->create(['parent_id' => $p1->id]);    

        $forsidumyndir = factory(App\Page::class)->create([
                    'title' => 'Forsíðumyndir',
                    'status' => 0,
                    'slug' => '_forsidumyndir',
                    'content' => '',
                ]);

            factory(App\Page::class)->create([
                'title' => 'Mynd 1',
                'status' => 1,
                'slug' => '_mynd1',
                'parent_id' => $forsidumyndir->id,
                'content' => '',
                'images' => [
                    [
                        'name' => 'mynd1.jpg',
                    ],
                ],
            ]);

            factory(App\Page::class)->create([
                'title' => 'Mynd 2',
                'status' => 1,
                'slug' => '_mynd2',
                'parent_id' => $forsidumyndir->id,
                'content' => '',
                'images' => [
                    [
                        'name' => 'mynd2.jpg',
                    ],
                ],
            ]);

            factory(App\Page::class)->create([
                'title' => 'Mynd 3',
                'status' => 1,
                'slug' => '_mynd3',
                'parent_id' => $forsidumyndir->id,
                'content' => '',
                'images' => [
                    [
                        'name' => 'mynd3.jpg',
                    ],
                ],
            ]);











         $forsidukubbar = factory(App\Page::class)->create([
                    'title' => 'Forsíðukubbar',
                    'status' => 0,
                    'slug' => '_forsidukubbar',
                    'content' => '',
                ]);

            factory(App\Page::class)->create([
                'title' => 'Vörur',
                'status' => 1,
                'slug' => 'kubbur-vorur',
                'parent_id' => $forsidukubbar->id,
                'url' => '/vorur/',
                'images' => [
                    [
                        'name' => 'kubbur1.jpg',
                    ],
                ],
            ]);

            factory(App\Page::class)->create([
                'title' => 'Námskeið',
                'status' => 1,
                'slug' => 'kubbur-namskeid',
                'parent_id' => $forsidukubbar->id,
                'url' => '/namskeid/',
                'images' => [
                    [
                        'name' => 'kubbur2.jpg',
                    ],
                ],
            ]);

            factory(App\Page::class)->create([
                'title' => 'Fróðleikur',
                'status' => 1,
                'slug' => 'kubbur-frodleikur',
                'parent_id' => $forsidukubbar->id,
                'url' => '/frodleikur/',
                'images' => [
                    [
                        'name' => 'kubbur3.jpg',
                    ],
                ],
            ]);


        Model::reguard();
    }
}