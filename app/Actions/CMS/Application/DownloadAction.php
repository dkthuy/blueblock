<?php

namespace App\Actions\CMS\Application;

use App\Contracts\Repositories\ApplicationRepositoryContract;
use App\Contracts\Repositories\QuestionRepositoryContract;
use App\Enums\QuestionTypeEnum;
use App\Supports\Traits\HasTransformer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadAction
{
    use HasTransformer;

    protected ApplicationRepositoryContract $applicationRepository;
    protected QuestionRepositoryContract $questionRepository;

    public function __construct(ApplicationRepositoryContract $applicationRepository, QuestionRepositoryContract $questionRepository)
    {
        $this->applicationRepository = $applicationRepository;
        $this->questionRepository = $questionRepository;
    }

    /**
     * @return StreamedResponse
     */
    public function __invoke(): StreamedResponse
    {
        set_time_limit(0);
        $questions = $this->questionRepository->skipCriteria()->all();
        $data = $this->getData();

        // set header
        $columns = $this->setHeader();

        // create csv
        return response()->streamDownload(function () use ($questions, $columns, $data) {
            echo "\xEF\xBB\xBF";
            $file = fopen('php://output', 'wb+');

            $this->formatCSVData($questions, $columns, $data, $file);
        }, 'applications_' . date('d-m-Y H:i:s') . '.csv');
    }

    /**
     * @return string[]
     */
    private function setHeader(): array
    {
        return [
            'apply_id' => '応募ID',
            'apply_date' => '応募日時',
            'full_name' => '氏名',
            'furigana_full_name' => 'フリガナ',
            'gift_name' => '希望コース',
            'gender' => '性別',
            'age' => '年代',
            'post_code' => '郵便番号',
            'prefecture' => 'ご住所（都道府県）',
            'city' => 'ご住所（市区町村）',
            'additional_address' => 'ご住所（丁目/番地/号）',
            'room_building_number' => 'ご住所（建物/階）',
            'telephone' => '電話番号',
        ];
    }

    /**
     * @return mixed
     */
    private function getData()
    {
        return $this->applicationRepository
            ->select([
                'apply_id',
                'apply_date',
                'first_name',
                'last_name',
                'furigana_first_name',
                'furigana_last_name',
                'gift_name',
                'gender',
                'age',
                'post_code',
                'prefecture',
                'city',
                'additional_address',
                'room_building_number',
                'telephone',
                'qanda',
            ])
            ->take(Request::get('per_page') ?? 10)
            ->offset(((Request::get('page') ?? 1) - 1) * Request::get('per_page') ?? 10);
    }

    /**
     * @param $questions
     * @param $columns
     * @param $data
     * @param $file
     * @return void
     */
    private function formatCSVData($questions, $columns, $data, $file): void
    {
        // TODO: ANOTHER OPTION JUST WORK WITH MULTIPLE CHOICE QUESTION
        // create header
        $questionColumns = [];
        foreach ($questions as $question) {
            $questionData = [];
            // check multiple or single choice
            switch ($question->type) {
                case QuestionTypeEnum::MULTIPLE_CHOICE:
                    $questionData = [
                        $question->question . '【はい/いいえ】',
                        $question->question . '【選択肢】'
                    ];
                    break;
                default:
                    $questionData = [
                        $question->question,
                    ];
                    break;
            }

            if ($question->have_other_option) {
                $questionData[] = 'このキャンペーンをどこで知りましたか？【その他自由記述】';
            }

            $questionColumns[] = $questionData;
        }

        $questionColumns = collect($questionColumns)->flatten()->toArray();
        $csvColumns = array_merge($columns, $questionColumns);
        fputcsv($file, $csvColumns);

        // handle data
        $data = $data->cursor()
            ->each(function ($data) use ($questions, $columns, $file) {
                $data = $data->toArray();

                $data['qanda'] = collect($data['qanda']);
                $newData = [];
                foreach ($columns as $key => $value) {
                    $newData[] = $data[$key];
                }

                foreach ($questions as $question) {
                    $answer = $data['qanda']->where('question_id', $question->id)->first();
                    if (!$answer) {
                        $newData[] = [''];
                        continue;
                    }
                    $allAnswers = [];

                    if (isset($answer['answers']) && $question->type === QuestionTypeEnum::MULTIPLE_CHOICE) {
                        $answerDetail = $answer['answers'];
                        $allAnswers[] = Arr::get($answerDetail, 0);
                        $optionAnswers = Arr::except($answerDetail, 0);
                        $allAnswers[] = implode("\n", $optionAnswers);
                    } elseif (isset($answer['answers'])) {
                        $allAnswers[] = implode("\n", $answer['answers']);
                    }

                    if ($question->have_other_option) {
                        $otherAnswer = !is_null(Arr::get($answer, 'other_answer')) ? Arr::get($answer, 'other_answer') : '';
                        $allAnswers[] = $otherAnswer;
                    }

                    $newData[] = $allAnswers;
                }
                $newData = collect($newData)->flatten()->toArray();
                fputcsv($file, $newData);
            });

        fclose($file);
    }
}
