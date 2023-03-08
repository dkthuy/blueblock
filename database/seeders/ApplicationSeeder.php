<?php

namespace Database\Seeders;

use App\Enums\AgeEnum;
use App\Enums\GenderEnum;
use App\Enums\QuestionTypeEnum;
use App\Models\Gift;
use App\Models\Question;
use App\Models\User;
use App\Services\Question\QuestionBuilder;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $totalRecords = 1 * 1000 * 1000;
        $gifts = Gift::all();
        $requiredQuestions = Question::where('is_required', true)->get();
        $otherQuestions = Question::whereNotIn('id', $requiredQuestions->pluck('id'))->get();

        for ($i = 1; $i <= $totalRecords; $i++) {
            $randomGift = $gifts->random();
            // prepare data
            $data = [
                'apply_date'            => now(),
                'first_name'            => 'お名前',
                'last_name'             => 'テスト',
                'furigana_first_name'   => 'フリガナ',
                'furigana_last_name'    => 'テスト',
                'gender'                => GenderEnum::getRandomValue(),
                'age'                   => AgeEnum::getRandomValue(),
                'post_code'             => $this->getRandomPostCode(),
                'prefecture'            => $this->getRandomPrefecture(),
                'city'                  => 'city ' . $i,
                'additional_address'    => 'address ' . $i,
                'telephone'             => '12312312',
                'room_building_number'  => 'room/building number',
                'gift_id'               => $randomGift->id,
                'gift_name'             => $randomGift->name,
            ];
            $answerData = [];
            $randomLength = $otherQuestions->count() > 0 ? random_int(1, $otherQuestions->count()) : 0;
            $randomOtherQuestions = $otherQuestions->random($randomLength);
            foreach ($randomOtherQuestions as $question) {
                $answered = $this->makeQuestionData($question);
                // TODO: Other option - WIP
                $questionData = [
                    'question_id' => $question->id,
                ];
                $questionData['answers'] = $answered;
                $answerData[] = $questionData;
            }
            foreach ($requiredQuestions as $question) {
                $answered = $this->makeQuestionData($question);
                // TODO: Other option - WIP
                $questionData = [
                    'question_id' => $question->id,
                ];
                $questionData['answers'] = $answered;
                $answerData[] = $questionData;
            }
            $data[QuestionBuilder::RULE_KEY] = $answerData;
            $user = User::create([]);
            $user->applications()->create($data);
        }
    }

    private function makeQuestionData($question) {
        $answers = collect($question->answers);
        switch ($question->type) {
            case QuestionTypeEnum::MULTIPLE_CHOICE:
                $randomLength = $answers->count() > 0 ? random_int(1, $answers->count()) : 0;
                $answered = $answers->random($randomLength);
                break;
            case QuestionTypeEnum::SINGLE_CHOICE:
                $answered = $answers->random($answers->count() > 0 ? 1 : 0);
                break;
            case QuestionTypeEnum::INPUT:
                $answered = ['input'];
                break;
            case QuestionTypeEnum::TEXTAREA:
                $answered = ['textarea'];
                break;
            case QuestionTypeEnum::UPLOAD_IMAGES:
                $answered = [url('/img/recipt-s.jpg')];
                break;
            default:
                throw new \Exception('Missing question type!?');
        }
        return $answered;
    }

    /**
     * @return false|string
     * @throws \Exception
     */
    private function randomDatetime()
    {
        $timestamp = random_int(1, time());

        return date('Y-m-d H:i:s', $timestamp);
    }

    private function getRandomPrefecture()
    {
        $prefectures = $this->prefectures();

        return $prefectures[array_rand($prefectures)];
    }

    /**
     * @return string
     */
    private function getRandomPostCode()
    {
        $postcodes = $this->postcodes();

        return $postcodes[array_rand($postcodes)];
    }

    /**
     * @return array|int|string
     */
    private function prefectures()
    {
        return [
            '北海道',
            '青森県',
            '岩手県',
            '宮城県',
            '秋田県',
            '山形県',
            '福島県',
            '茨城県',
            '栃木県',
            '群馬県',
            '埼玉県',
            '千葉県',
            '東京都',
            '神奈川県',
            '山梨県',
            '長野県',
            '新潟県',
            '富山県',
            '石川県',
            '福井県',
        ];
    }

    protected function postcodes()
    {
        return [
            '190-0100',
            '196-0000',
            '206-0000',
            '574-0000',
            '520-0816',
            '857-0404',
            '252-0302',
            '853-0603',
            '631-0034',
            '959-0107',
            '814-0143',
            '784-0005',
            '370-0331',
            '857-0071',
            '492-8135',
            '789-1235',
            '321-3556',
            '929-2204',
            '905-0222',
            '761-2202',
            '529-1656',
            '520-3426',
            '811-3215',
            '640-1364',
        ];
    }
}
