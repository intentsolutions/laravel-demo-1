<?php

namespace App\Services;

use App\Models\Course;
use App\Repositories\CourseRepository;
use App\Repositories\ModuleRepository;
use App\Repositories\PurchaseRepository;

class PurchaseCheckerService
{
    public function __construct(
        private readonly PurchaseRepository $purchaseRepository,
        private readonly CourseRepository   $courseRepository,
        private readonly ModuleRepository   $moduleRepository
    )
    {
    }

    public function isCoursesPurchased(int $courseId): bool
    {
        if (auth()->check()) {
            $purchase = $this->purchaseRepository->getByCourseIdsAndUserId(auth()->id(), $courseId);
            if ($purchase) {
                return true;
            }
        }

        return false;
    }

    public function isModulePurchased(int $moduleId): bool
    {
        $course = $this->courseRepository->getCourseByModuleIds([$moduleId]);

        return $course && $this->isCoursesPurchased($course->id);
    }

    public function isLessonPurchased(int $lessonId): bool
    {
        $modules = $this->moduleRepository->getModulesByLessonIds([$lessonId]);
        $course = $this->courseRepository->getCourseByModuleIds($modules->pluck('id')->toArray());

        return $this->isCoursesPurchased($course->id);
    }

    public function isQuizPurchased(int $quizId): bool
    {
        $modules = $this->moduleRepository->getModulesByQuizIds([$quizId]);
        $course = $this->courseRepository->getCourseByModuleIds($modules->pluck('id')->toArray());

        return $this->isCoursesPurchased($course->id);
    }
}
