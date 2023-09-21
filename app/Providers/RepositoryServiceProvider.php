<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $repositories = [
            'User\UserRepositoryInterface' => 'User\UserRepository',
            'User\PasswordResetRepositoryInterface' => 'User\PasswordResetRepository',
            'Category\CategoryRepositoryInterface' => 'Category\CategoryRepository',
            'Lesson\LessonRepositoryInterface' => 'Lesson\LessonRepository',
            'Material\MaterialRepositoryInterface' => 'Material\MaterialRepository',
            'Kid\KidRepositoryInterface' => 'Kid\KidRepository',
            'Review\ReviewRepositoryInterface' => 'Review\ReviewRepository',
            'LessonCourse\LessonCourseRepositoryInterface' => 'LessonCourse\LessonCourseRepository',
            'CourseApplication\CourseApplicationRepositoryInterface' => 'CourseApplication\CourseApplicationRepository',
            'ApplicationDetail\ApplicationDetailRepositoryInterface' => 'ApplicationDetail\ApplicationDetailRepository',
            'Request\RequestRepositoryInterface' => 'Request\RequestRepository',
            'RequestApplication\RequestApplicationRepositoryInterface' => 'RequestApplication\RequestApplicationRepository',
            'LessonView\ViewRepositoryInterface' => 'LessonView\ViewRepository',
            'CourseSchedule\CourseScheduleRepositoryInterface' => 'CourseSchedule\CourseScheduleRepository',
            'TeacherInformation\TeacherInformationRepositoryInterface' => 'TeacherInformation\TeacherInformationRepository',
            'TeacherWorkHistory\TeacherWorkHistoryRepositoryInterface' => 'TeacherWorkHistory\TeacherWorkHistoryRepository',
            'UserSchedule\UserScheduleRepositoryInterface' => 'UserSchedule\UserScheduleRepository',
            'ModelHasCategory\ModelHasCategoryRepositoryInterface' => 'ModelHasCategory\ModelHasCategoryRepository',
        ];

        foreach ($repositories as $key => $value) {
            $this->app->bind("App\\Repositories\\$key", "App\\Repositories\\$value");
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
