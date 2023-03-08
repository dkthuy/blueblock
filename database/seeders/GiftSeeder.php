<?php

namespace Database\Seeders;

use App\Models\Gift;
use Illuminate\Database\Seeder;

class GiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gift::create([
            'name' => 'A賞
額入りポスター＆描き下ろし商品フィルム',
            'image_url' => secure_asset('/presents/present01.png'),
        ]);
        Gift::create([
            'name' => 'B賞
描き下ろしアクリルスタンド',
            'image_url' => secure_asset('/presents/present02.png'),
        ]);
    }
}
