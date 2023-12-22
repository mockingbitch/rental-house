<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Repositories\House\HouseRepositoryInterface;
use App\Repositories\Room\RoomRepositoryInterface;
use App\Repositories\Tag\TagRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\FileService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class RoomController extends Controller
{
    /**
     * @param FileService $fileService
     * @param RoomRepositoryInterface $roomRepository
     * @param TagRepositoryInterface $tagRepository
     * @param HouseRepositoryInterface $houseRepository
     */
    public function __construct(
        public FileService $fileService,
        public RoomRepositoryInterface $roomRepository,
        public TagRepositoryInterface $tagRepository,
        public HouseRepositoryInterface $houseRepository,
    ) {
    }


    /**
     * Create room
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        $data = $request->all();

        try {
            // get id tags
            $tag_ids = [];
            $tag_names = explode(',', $data['tags']);
            foreach ($tag_names as $tag_name) :
                $tag = $this->tagRepository->findTagByName($tag_name);
                if ($tag) :
                    $tag_ids[] = $tag->id;
                endif;
            endforeach;
            $data['tags'] = implode(',', $tag_ids);

            // get image urls
            $image_list = [];
            foreach ($data['images'] as $image) :
                $image_list[] = $this->fileService->storeFile($image, 'public/room');
            endforeach;
            $data['images'] = implode(",", $image_list);

            // create room
            $this->roomRepository->create($data);

            return redirect()
                ->route('lessor.house.room-list', ['id' => $data['house_id']])
                ->with('errCode', 0);
        } catch (Throwable $th) {
            return redirect()
                ->route('lessor.house.room-list', ['id' => $data['house_id']])
                ->with('errCode', 1);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateStatus(Request $request): JsonResponse
    {
        try {
            $house = $this->roomRepository
                ->update(
                    $request->id,
                    [
                        'status' => $request->status ? '0' : '1'
                    ]
                );

            return response()->json([
                'house'     => $house,
                'errCode'   => 0,
                'message'   => 'Update status successfully'
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'errCode' => 1,
                'message' => 'Something went wrong'
            ], 200);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function detail(Request $request): JsonResponse
    {
        $data = $request->all()['data'];
        $room = $this->roomRepository->find($data['id']);

        if (! $room) :
            return response()->json([
                'room'     => null,
                'errCode'   => 1,
                'message'   => 'Error',
            ], 200);
        endif;

        // convert room tags id to room tags name
        $tags = $this->tagRepository->findTagsByIDString($room->tags);
        $room->tags = $tags->implode('name_vi', ',');

        // convert images string to array
        $images = $room->images;
        $room->images = explode(',', $room->images);

        return response()->json([
            'room'     => $room,
            'errCode'   => 0,
            'message'   => 'Successfully',
        ], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $data = $request->all();

        try {
            if (!$room = $this->roomRepository->find($data['id'])) :
                return response()->json([
                    'errCode' => 1,
                    'message' => 'Room not found!',
                ]);
            endif;

            // get image list
            $image_list = [];
            for ($i = 0; $i < 6; $i++) :
                if (isset($data['image_' . $i])) :
                    $image = $data['image_' . $i];
                    if (gettype($image) == 'string') :
                        $image_list[] = $image;
                    else :
                        $image_list[] = $this->fileService
                            ->storeFile($image, 'public/room');
                    endif;
                    // foreach($data['images'] as $image):
                    // endforeach;
                endif;
            endfor;
            $data['images'] = implode(',', $image_list);

            // convert tag name to tag id
            $tag_ids = [];
            $tag_names = explode(',', $data['tags']);
            foreach ($tag_names as $tag_name) :
                $tag = $this->tagRepository->findTagByName($tag_name);
                if ($tag) :
                    $tag_ids[] = $tag->id;
                endif;
            endforeach;
            $data['tags'] = implode(',', $tag_ids);

            $room = $this->roomRepository->update($data['id'], $data);

            return response()->json([
                'room' => $room,
                'errCode' => 0,
                'message' => 'Update successfully!',
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'errCode' => 1,
                'message' => 'Something went wrong!',
            ], 200);
        }
    }

    /**
     * @param int|null $id
     * @return RedirectResponse
     */
    public function delete(?int $id): RedirectResponse
    {
        try {
            $room = $this->roomRepository->find($id);

            if (!$room) :
                throw ValidationException::withMessages([
                    'msg'   => 'Can not find room',
                ]);
            endif;

            $this->roomRepository->delete($id);

            return redirect()->route('lessor.house.room-list', ['id' => $room->house_id])
                ->with([
                    'errCode' => 0,
                    'message' => 'Delete house successfully',
                ]);
        } catch (Throwable $th) {
            return redirect()->route('lessor.house.room-list', ['id' => $room->house_id])
                ->with([
                    'errCode' => 1,
                    'message' => 'Something went wrong',
                ]);
        }
    }

    /**
     * @param int|null $id
     * @return Exception|Throwable|Response
     */
    public function detailRoom(?int $id): Exception|Throwable|Response
    {
        try {
            $room = $this->roomRepository->find($id);
            $house = $this->houseRepository
                ->findByWithRelationship(
                    ['lessor'],
                    ['id' => $room->house_id],
                    true
                );
            $roomTag = explode(',', $room->tags);
            $tags = [];
            foreach ($roomTag as $item) :
                $tag = \App\Models\Tag::select('name_vi')
                    ->where('id', $item)
                    ->first();
            $tags[] = $tag->name_vi;
            endforeach;
            $images = explode(',', $room->images);
            $room->tags = implode(", ", $tags);
            $room->thumbnail = $images[0];
            $room->images = $images;

            return Inertia::render('Client/RoomDetail/RoomDetail', [
                'room'  => $room,
                'house' => $house,
            ]);
        } catch (Throwable $throwable) {
            return $throwable;
        }
    }
}
