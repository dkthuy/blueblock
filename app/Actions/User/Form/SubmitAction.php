<?php

namespace App\Actions\User\Form;

use App\Contracts\Repositories\ApplicationRepositoryContract;
use App\Contracts\Repositories\GiftRepositoryContract;
use App\Contracts\Repositories\QuestionRepositoryContract;
use App\Enums\QuestionTypeEnum;
use App\Models\User;
use App\Supports\Traits\HasTransformer;
use Illuminate\Http\JsonResponse;

class SubmitAction
{
    use HasTransformer;

    protected ApplicationRepositoryContract $applicationRepository;

    protected QuestionRepositoryContract $questionRepository;

    protected GiftRepositoryContract $giftRepository;

    public function __construct(
        ApplicationRepositoryContract $applicationRepository,
        QuestionRepositoryContract    $questionRepository,
        GiftRepositoryContract        $giftRepository
    )
    {
        $this->applicationRepository = $applicationRepository;
        $this->questionRepository = $questionRepository;
        $this->giftRepository = $giftRepository;
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function __invoke($data): JsonResponse
    {
        /**
         * @var User $currentUser
         */
        $currentUser = auth('api')->user();
        $userId = $currentUser->id;

        if ($this->applicationRepository->isSubmitted($userId)) {
            return $this->httpBadRequest([], null, 'You are already registered!');
        }

        if (! empty($data['qanda']) && is_array($data['qanda'])) {
            $answerData = $data['qanda'];
            foreach ($answerData as $key => $answer) {
                if (! empty($answer['question_id'])) {
                    $question = $this->questionRepository->find($answer['question_id']);
                    if ($question->type === QuestionTypeEnum::UPLOAD_IMAGES) {
                        $data['qanda'][$key]['answers'] = $this->getFiles($currentUser);
                    }
                    $data['qanda'][$key]['question'] = $question->question ?? null;
                }
            }
        }
        if (! empty($data['gift_id'])) {
            if (! empty($gift = $this->giftRepository->find($data['gift_id']))) {
                $data['gift_name'] = $gift->name;
            }
        }
        $data = array_merge($data, [
            'apply_date' => now(),
            'user_id' => $userId,
        ]);
        $this->applicationRepository->saveApplyData($data);

        return $this->httpNoContent();
    }

    private function getFiles(User $user): array
    {
        return array_map(function ($path) use ($user) {
            return $user->storageDriver()->url($path);
        }, $user->storageDriver()
            ->files($user->imageDirectoryPath()));
    }
}
