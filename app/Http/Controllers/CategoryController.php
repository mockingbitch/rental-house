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
    public function get()
    {
        $categories = Category::all();
        return view('categories.list', compact('categories'));
    }

    public function create(CategoryRequest $request)
    {
        $data = $request->all();
        try {
            DB::transaction(function () use ($data) {
                $category = $this->categoryRepository->create($data);
            });
            DB::commit();

            return redirect()->route('category.get');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw ValidationException::withMessages([
                Constant::ERR_MSG => trans('messages.create_category.EM-001'),
            ]);
        }
    }

    public function update()
    {

    }

    public function delete($id)
    {
        $this->categoryRepository->delete($id);
        return redirect()->route('category.get');
    }
}
