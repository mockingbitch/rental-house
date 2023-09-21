<?php

namespace App\Repositories\LessonView;

interface ViewRepositoryInterface
{
    /**
     * @param int $user_agent, $lesson_id
     * @return Collection
     */
    public function checkUserAgent($user_agent, $lesson_id);
}