<?php

namespace App\Repositories\Review;

use App\Models\Review;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Constants\ReviewConstants;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return Review::class;
    }

    /**
     * @return object
     */
    public function getUserReviews($lesson_id) : object
    {
        return $this->model
            ->where(
                ReviewConstants::COL_LESSON_ID,
                $lesson_id
            )
            ->with('user')
            ->orderBy('reviews.created_at', 'desc')
            ->get();
    }

    /**
     * @param array $listLesson
     * @return array
     */
    public function getListReviewOfTeacher($listLesson = []) : array
    {
        $listReview = [];

        foreach ($listLesson as $lesson) :
            $result = $this->model
                ->where(ReviewConstants::COL_LESSON_ID, $lesson->id)->get();
            if (count($result) > 0) :
                foreach ($result as $item) :
                    $listReview[] = $item;
                endforeach;
            endif;
        endforeach;

        return $listReview;
    }
}