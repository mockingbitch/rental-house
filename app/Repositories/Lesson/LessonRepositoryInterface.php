<?php

namespace App\Repositories\Lesson;

use Illuminate\Database\Eloquent\Collection;

interface LessonRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getListAvailable(): Collection;

    /**
     * @param array $data
     * @return Collection
     */
    public function search($data = []): Collection;

    /**
     * @return Collection
     */
    public function suggest(): Collection;

    /**
     * @param int $teacher_id
     * @return Collection
     */
    public function getListLesson($teacher_id): Collection;

    /**
     * @param int $teacher_id, $status
     * @return array
     */
    public function getListSchedule($teacher_id, $status);

    /**
     * @param int $lesson_id
     * @return array
     */
    public function getLessontSchedule($lesson_id);

    /**
     * @param integer|null $id
     * @return boolean
     */
    public function checkIfUserHasCourse(?int $id): bool;
}
