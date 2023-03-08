<?php

namespace Database\Seeders;

use App\Enums\QuestionTypeEnum;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $answers = [];
        Question::create([
            'type' => QuestionTypeEnum::UPLOAD_IMAGES,
            'question' => 'レシート画像のアップロード',
            'answers' => $answers,
            'have_other_option' => false,
            'order' => 1,
            'is_required' => true,
            'options' => [
                'description_html' => '
            <div class="caution">
                <picture>
                    <!--[if IE 9]><video style="display: none;"><![endif]-->
                    <source media="(min-width:781px)" srcset="' . url('/img/recipt.jpg') . '">
                    <source media="(max-width:780px)" srcset="' . url('/img/recipt-s.jpg') . '">
                    <!--[if IE 9]></video><![endif]-->
                    <img src="' . url('/img/recipt.jpg') . '" alt="レシート撮影時の注意" class="switching">
                </picture>
            </div>

            <p class="indent">※画像の切れや汚れ、ピンボケ等により内容判断ができない場合は応募が無効となります。</p>
            <p class="indent">※対応画像形式：jpg ／ png ／ gif</p>
            <p class="indent">※ファイル容量上限：5MB</p>
            <p class="indent">※レシートを他人へ譲渡することは固く禁止させていただきます。予めご了承くださいませ。</p>
            <p class="indent">※同一レシートを使用した複数回のご応募は無効となります。</p>
            <hr />
            <div class="box noline">
                <h5>アンケートにご協力ください。</h5>
                <p class="ctext">※ご回答内容は抽選の当選確率に一切の影響はありません。</p>
            </div>',
                'min_files' => 1,
                'max_files' => 5,
                'min_file_size' => null,
                'max_file_size' => 5, // MB
            ],
        ]);

        $answers = [
            '今回初めて',
            '買ったことがある',
            '普段から買っている',
        ];
        Question::create([
            'type' => QuestionTypeEnum::SINGLE_CHOICE,
            'question' => 'スナックサンドは普段買われますか？',
            'answers' => $answers,
            'have_other_option' => false,
            'order' => 2,
            'is_required' => true,
        ]);

        Question::create([
            'type' => QuestionTypeEnum::SINGLE_CHOICE,
            'question' => 'フジパンの菓子パンは買ったことがありますか？',
            'answers' => $answers,
            'have_other_option' => false,
            'order' => 3,
            'is_required' => true,
        ]);

        $answers = [
            '店頭',
            'フジパンホームページ',
            '懸賞サイト',
            'SNS',
            '知人・友人',
        ];
        Question::create([
            'type' => QuestionTypeEnum::SINGLE_CHOICE,
            'question' => 'このキャンペーンをどこで知りましたか？',
            'answers' => $answers,
            'have_other_option' => true,
            'other_option_name' => 'その他（自由記述）',
            'order' => 4,
            'is_required' => true,
        ]);
    }
}
