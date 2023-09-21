<?php

namespace App\Repositories\Review;

interface ReviewRepositoryInterface
{
    /**
     * @return object
     */
    public function getUserReviews($lesson_id) : object;

    /**
     * @param array $listLesson
     * @return array
     */
    public function getListReviewOfTeacher($listLesson = []) : array;
}