<?php

namespace App\Http\Controllers;

use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Request\RequestRepositoryInterface;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RequestController extends Controller
{
    /**
     * Constructor
     *
     * @param CategoryRepositoryInterface $categoryRepository
     * @param RequestRepositoryInterface $requestRepository
     */
    public function __construct(
        public CategoryRepositoryInterface $categoryRepository,
        public RequestRepositoryInterface $requestRepository,
    )
    {
    }

    /**
     * @return Response
     */
    public function list(): Response
    {
        $request = auth()->user() ? $this->requestRepository
            ->findByWithRelationShip(
                ['category'],
                ['user_id' => auth()->user()->id]
            ) : [];
        $listRequest = $this->requestRepository
            ->findByWithRelationShip(
                ['category'],
                ['status' => 1]
            );

        return Inertia::render('Client/Request/RequestList', [
            'requests'      => $request,
            'listRequest'   => $listRequest,
            'isLoggedIn'    => (bool)auth()->user()
        ]);
    }

    public function create()
    {
        $categories = $this->categoryRepository->all();

        return Inertia::render('Client/Request/CreateRequest', [
            'categories' => $categories,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Exception
     */
    public function store(Request $request): Exception|RedirectResponse
    {
        $data = $request->all();
        $data['min_price'] = (int) $request->min_price;
        $data['max_price'] = (int) $request->max_price;
        try {
            $data['user_id'] = auth()->user()->id;
            if ($request->draft) :
                $data['status'] = 2;
                $this->requestRepository->create($data);

                return redirect()->route('request.index');
            endif;
            if ($request->confirm) :
                $this->requestRepository->create($data);

                return redirect()->route('request.index');
            endif;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function delete(?int $id)
    {
        try {
            $this->requestRepository->delete($id);
        } catch (Exception $e) {
            return $e;
        }
    }
}
