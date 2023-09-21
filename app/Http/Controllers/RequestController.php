<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use App\Repositories\Request\RequestRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\RequestApplication\RequestApplicationRepositoryInterface;
use App\Repositories\ApplicationDetail\ApplicationDetailRepositoryInterface;
use App\Constants\RequestConstants;
use App\Constants\CommonConstants;
use App\Constants\NotificationConstants;
use App\Services\NotificationService;
use App\Http\Requests\RequestRequest;
use Inertia\Inertia;
use Inertia\Response;

class RequestController extends Controller
{
    /**
     * @var requestRepository
     */
    protected $requestRepository;

    /**
     * @var categoryRepository
     */
    protected $categoryRepository;

    /**
     * @var requestApplicationRepository
     */
    protected $requestApplicationRepository;

    /**
     * @var lessonRepository
     */
    protected $lessonRepository;

    /**
     * @var applicationDetailRepository
     */
    protected $applicationDetailRepository;

    /**
     * @param RequestRepositoryInterface $requestRepository
     * @param CategoryRepositoryInterface $categoryRepository
     * @param RequestApplicationRepositoryInterface $requestApplicationRepository
     * @param ApplicationDetailRepositoryInterface $applicationDetailRepository
     */
    public function __construct(
        RequestRepositoryInterface $requestRepository,
        CategoryRepositoryInterface $categoryRepository,
        RequestApplicationRepositoryInterface $requestApplicationRepository,
        ApplicationDetailRepositoryInterface $applicationDetailRepository,
        public NotificationService $notificationService,
        )
    {
        $this->requestRepository    = $requestRepository;
        $this->categoryRepository   = $categoryRepository;
        $this->requestApplicationRepository   = $requestApplicationRepository;
        $this->applicationDetailRepository = $applicationDetailRepository;
    }

    /**
     * @Route get("/request", name="request.index")
     * @return Response
     */
    public function index(): Response
    {
        $user = auth()->user();

        if (! $user) :
            $isLoggedIn = false;
            $requests = [];
            $listRequest = $this->requestRepository->getRequests([], '*', 2);
        else:
            $isLoggedIn = true;
            $requests = $this->requestRepository
                ->getRequests([RequestConstants::COL_USER_ID => $user->id]);
            $listRequest = $this->requestRepository
                ->getRequests([], '*', null);
        endif;

        return Inertia::render('Request/User/RequestList', [
            'isLoggedIn'    => $isLoggedIn,
            'requests'      => $requests,
            'listRequest'   => $listRequest
        ]);
    }

    /**
     * @Route get("/request/create" , name="request.create.view")
     * @return Response
     */
    public function viewCreate(): Response
    {
        $categories = $this->categoryRepository->all();

        return Inertia::render('Request/User/CreateRequest', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route post("/request/create" , name="request.create")
     * @param RequestRequest $request
     * @return void
     */
    public function create(RequestRequest $request)
    {
        $data = [
            RequestConstants::COL_USER_ID       => auth()->user()->id,
            RequestConstants::COL_CATEGORY_ID   => $request->category_id,
            RequestConstants::COL_SUMMARY       => $request->summary,
            RequestConstants::COL_DETAIL        => $request->detail,
            RequestConstants::COL_MIN_PRICE     => $request->min_price,
            RequestConstants::COL_MAX_PRICE     => $request->max_price,
            RequestConstants::COL_ABOUT_TEACHER => $request->about_teacher,
            RequestConstants::COL_LANGUAGE      => $request->language,
            RequestConstants::COL_MIN_TIME      => $request->min_time,
            RequestConstants::COL_MAX_TIME      => $request->max_time,
            RequestConstants::COL_START_TIME    => $request->start_time,
            RequestConstants::COL_END_TIME      => $request->end_time,
            RequestConstants::COL_MIN_AGE       => $request->min_age,
            RequestConstants::COL_MAX_AGE       => $request->max_age,
            RequestConstants::COL_WEEKDAYS      => json_encode($request->weekdays),
        ];

        try {
            if ($request->confirm) :
                $req = $this->requestRepository->create($data);
                $this->notificationService->sendNotification(
                    auth()->user(),
                    [
                        'title'     => 'リクエストを受け付けました。',
                        'target'    => route('request.index'),
                    ],
                    NotificationConstants::BROADCAST_USER,
                );

                return redirect()->route('request.index');
            endif;
        } catch (\Throwable $th) {
            throw ValidationException::withMessages([
                CommonConstants::ERR_MSG => trans('messages.login.EM-001'),
            ]);
        }
    }


    /**
     * @Route post("/request/edit" , name="request.edit")
     * @param RequestRequest $request
     * @return void
     */
    public function edit(RequestRequest $request)
    {
        try {
            if (! $oldRequest = $this->requestRepository->findBy([
                RequestConstants::COL_ID => $request->id
            ])->first()):
                return redirect()
                    ->route('top')
                    ->with(CommonConstants::ERR_MSG, 'Invalid Token');
            endif;

            if (! $request_update = $this->requestRepository
                    ->update(
                        $oldRequest->id,
                        [
                            RequestConstants::COL_USER_ID       => auth()->user()->id,
                            RequestConstants::COL_CATEGORY_ID   => $request->category_id,
                            RequestConstants::COL_SUMMARY       => $request->summary,
                            RequestConstants::COL_DETAIL        => $request->detail,
                            RequestConstants::COL_MIN_PRICE     => $request->min_price,
                            RequestConstants::COL_MAX_PRICE     => $request->max_price,
                            RequestConstants::COL_ABOUT_TEACHER => $request->about_teacher,
                            RequestConstants::COL_LANGUAGE      => $request->language,
                            RequestConstants::COL_MIN_TIME      => $request->min_time,
                            RequestConstants::COL_MAX_TIME      => $request->max_time,
                            RequestConstants::COL_START_TIME    => $request->start_time,
                            RequestConstants::COL_END_TIME      => $request->end_time,
                            RequestConstants::COL_MIN_AGE       => $request->min_age,
                            RequestConstants::COL_MAX_AGE       => $request->max_age,
                            RequestConstants::COL_WEEKDAYS      => json_encode($request->weekdays),
                        ]
                    )
                ) :
                return redirect()
                    ->route('top')
                    ->with(CommonConstants::MSG, __('messages.common.invalid'));
            endif;

            return redirect()->route('request.index');
        } catch (\Throwable $th) {
            throw ValidationException::withMessages([
                CommonConstants::ERR_MSG => trans('messages.login.EM-001'),
            ]);
        }
    }
    /**
     * @Route get("/request/{id}", name="request.detail")
     * @param integer|null $id
     * @return void
     */
    public function detail(?int $id)
    {
        try {
            $categories = $this->categoryRepository->all();

            if (! $request = $this->requestRepository->find($id)) :
                return redirect()->back();
            endif;

            $request->weekdays = json_decode($request->weekdays);

            return Inertia::render('Request/User/EditRequest', [
                'request'       => $request,
                'categories'    => $categories,
            ]);
        } catch (\Throwable $th) {
            throw ValidationException::withMessages([
                CommonConstants::ERR_MSG => trans('messages.login.EM-001'),
            ]);
        }
    }

    /**
     * @Route get("/request", name="teacher.request.list")
     * @return Response
     */
    public function teacherListRequest()
    {
        $user = auth()->user();
        $list_request = $this->requestRepository
            ->getRequests([
                [
                    RequestConstants::COL_USER_ID,
                    CommonConstants::OPERATOR_DIFFERENT,
                    $user->id
                ]
            ]);
        
        return Inertia::render('Request/Teacher/RequestList', [
            'list_request'  => $list_request,
            'user_id' => $user->id,
        ]);
    }

    /**
     * @Route delete("/request/delete/{id}", name="request.delete")
     * @param integer|null $id
     * @return RedirectResponse
     */
    public function delete(?int $id): RedirectResponse
    {
        $request = $this->requestRepository->find($id);
        $request->delete();
        sleep(0.3);
    
        return redirect()->route('request.index');
    }
}
