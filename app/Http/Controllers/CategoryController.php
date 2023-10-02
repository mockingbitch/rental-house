<?php

namespace App\Http\Controllers;

use App\Constants\Constant;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\User\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function __construct(
        public CategoryRepositoryInterface $categoryRepository,
        )
    {

    }

    /**
     * get list categories
     * @Route get("category.get")
     * @return Factory|View|RedirectResponse
     */
    public function get()
    {
        $categories = $this->categoryRepository->all();
        return view('categories.list', [
            'categories' => $categories,
        ]);
    }

    /**
     * create category
     * @Route post("category.create")
     * @param CategoryRequest
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(CategoryRequest $request)
    {
        $data = $request->all();
        try {
            $this->categoryRepository->create($data);
            return redirect()->route('category.get')->with('errCode', 1);
        } catch (\Throwable $th) {
            throw ValidationException::withMessages([
                Constant::ERR_MSG => trans('messages.create_category.EM-001'),
            ]);
            return redirect()->route('category.get')->with('errCode', 0);
        }
    }

    /**
     * update category
     * @Route post("category.update")
     * @param CategoryRequest
     * @param int $id
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(CategoryRequest $request, $id)
    {
        $data = $request->all();
        try {
            $this->categoryRepository->update($id, $data);
            return redirect()->route('category.get')->with('errCode', 1);
        } catch (\Throwable $th) {
            throw ValidationException::withMessages([
                Constant::ERR_MSG => trans('messages.update_category.EM-001'),
            ]);
            return redirect()->route('category.get')->with('errCode', 0);
        }
    }

    /**
     * delete category
     * @Route post("category.delete")
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function delete(Request $request)
    {
        $errCode = $this->categoryRepository->delete($request->id);
        return redirect()->route('category.get')->with('errCode', $errCode);
    }

    /**
     * get detail category
     * @Route get("category.detail")
     * @return Factory|View|RedirectResponse
     */
    public function detail($id)
    {
        $category = $this->categoryRepository->find($id);
        return view('categories.detail', [
            'category' => $category,
        ]);
    }
}
