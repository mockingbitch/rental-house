<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use App\Constants\UserConstant;
//use App\Constants\CommonConstant;
use App\Http\Requests\LessorRegistrationStep1;
use App\Repositories\Tag\TagRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Room\RoomRepositoryInterface;
use App\Repositories\House\HouseRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use Inertia\Inertia;
use Inertia\Response;
use Mockery\Exception;
use x\cache\File;

class LessorController extends Controller
{
    /**
     * @param FileService $fileService
     * @param TagRepositoryInterface $tagRepository
     * @param UserRepositoryInterface $userRepository
     * @param RoomRepositoryInterface $roomRepository
     * @param HouseRepositoryInterface $houseRepository
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        public FileService $fileService,
        public TagRepositoryInterface $tagRepository,
        public UserRepositoryInterface $userRepository,
        public RoomRepositoryInterface $roomRepository,
        public HouseRepositoryInterface $houseRepository,
        public CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    /**
     * @return Response
     */
    public function register(): Response
    {
        return Inertia::render('Client/LessorRegistration/Index');
    }

    public function registerStep1(LessorRegistrationStep1 $request)
    {
        $data = $request->all();
        try {
            if ($request->profileImage && gettype($request->profileImage) != 'string') :
                $data['avatar'] = $this->fileService->storeFile(
                    $request->profileImage,
                    UserConstant::STORAGE_LINK_AVATAR
                );
            endif;
            $data['birthday'] = Carbon::parse(
                $data['year'] . '-' . $data['month'] . '-' . $data['day']
            )->format('Y-m-d H:i:s');
            $data['verify_lessor'] = 'VERIFYING';
            $this->userRepository->update(auth()->user()->id, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * @return View
     */
    public function dashboard(): View
    {
        return view('lessor.dashboard');
    }

    /**
     * @return View
     */
    public function getHouses(): View
    {
        $houses = $this->houseRepository->all();
        $category = $this->categoryRepository->all();

        return view('lessor.house.list', [
            'houses'        => $houses,
            'category'      => $category,
            'breadcrumb'    => 'House',
            'user'          => auth()->user(),
        ]);
    }

    /**
     * @param int|null $id
     * @return View
     */
    public function listRoom(?int $id): View
    {
        $rooms = $this->roomRepository->findBy([
            'house_id' => $id
        ]);

        // only get first image of room
        foreach ($rooms as &$room) :
            $imageURLs = explode(',', $room->images);
            $room->first_image = reset($imageURLs);
        endforeach;

        $tags = $this->tagRepository->all();

        return view('lessor.room.list', [
            'house_id'      => $id,
            'rooms'         => $rooms,
            'tags'          => $tags,
            'breadcrumb'    => 'House/Room',
        ]);
    }
}
