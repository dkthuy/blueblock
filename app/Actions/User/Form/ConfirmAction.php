<?php

namespace App\Actions\User\Form;

use App\Contracts\Repositories\QuestionRepositoryContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Enums\QuestionTypeEnum;
use App\Models\Question;
use App\Models\User;
use App\Supports\Traits\HasTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;

class ConfirmAction
{
    use HasTransformer;

    protected UserRepositoryContract $userRepositoryContract;

    protected QuestionRepositoryContract $questionRepository;

    public function __construct(UserRepositoryContract $userRepositoryContract, QuestionRepositoryContract $questionRepository)
    {
        $this->userRepositoryContract = $userRepositoryContract;
        $this->questionRepository = $questionRepository;
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function __invoke($data): JsonResponse
    {
        $userId = auth('api')->user()->id;
        $answerData = $data['qanda'];
        if (! empty($answerData) && is_array($answerData)) {
            foreach ($answerData as $key => $answer) {
                if (! empty($answer['question_id'])) {
                    $question = $this->questionRepository->find($answer['question_id']);
                    $data['qanda'][$key] = $this->processUploadImageQuestionData($answer, $question);
                }
            }
        }

        if (! empty($data['user_data'])) {
            $this->userRepositoryContract->update([
                'user_data' => $data['user_data']
            ], $userId);
        }

        return $this->httpOK($data);
    }

    /**
     * @param array $questionData
     * @param Question $question
     * @return array
     */
    private function processUploadImageQuestionData(array $questionData, Question $question): array
    {
        // check question type is UPLOAD_IMAGES and answers > 0
        if ($question->type !== QuestionTypeEnum::UPLOAD_IMAGES
            || empty($questionData['answers'])
            || count($questionData['answers']) === 0
            || !($questionData['answers'][0] instanceof UploadedFile)
        ) {
            return $questionData;
        }
        /**
         * @var User $currentUser
         */
        $currentUser = auth()->user();
        $fullPath = $currentUser->imageDirectoryPath();
        // clear old files
        $currentUser->storageDriver()->deleteDir($fullPath);
        $answers = [];
        foreach ($questionData['answers'] as $answer) {
            /**
             * @var UploadedFile $answer
             */
            if (! ($answer instanceof UploadedFile)) {
                continue;
            }
            $answers[] = $currentUser->storageDriver()
                ->url($answer->store($fullPath, ['visibility' => 'public']));
        }
        $questionData['answers'] = $answers;
        return $questionData;
    }
}
