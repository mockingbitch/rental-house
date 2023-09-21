<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Inertia\Inertia;
use App\Repositories\Lesson\LessonRepositoryInterface;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * @var lessonRepository
     */
    protected $lessonRepository;

    /**
     * @param LessonRepositoryInterface $lessonRepository
     */
    public function __construct(
        LessonRepositoryInterface $lessonRepository
        )
    {
        $this->lessonRepository = $lessonRepository;
    }

    /**
     * @Route("/", name="top")
     * @return Response
     */
    public function index(): Response
    {
        $lessons = $this->lessonRepository->getListAvailable();
        
        return Inertia::render('Top', [
            'lessons' => $lessons,
        ]);
    }

    /**
     * @Route("/search", name="search")
     * @param Request $request
     * @return Response
     */
    public function search(Request $request): Response
    {
        $lessons     = $this->lessonRepository->search($request->all());
        $listSuggest = $this->lessonRepository->suggest();
        
        return Inertia::render('SearchResult', [
            'lessons'       => $lessons,
            'listSuggest'   => $listSuggest,
            'dataSearch'    => $request->all(),
        ]);
    }
}
