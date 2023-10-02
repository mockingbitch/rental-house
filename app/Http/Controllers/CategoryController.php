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
                $this->categoryRepository->create($data);
            });
            DB::commit();

            return redirect()->route('category.get')->with('errCode', 1);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw ValidationException::withMessages([
                Constant::ERR_MSG => trans('messages.create_category.EM-001'),
            ]);
            return redirect()->route('category.get')->with('errCode', 0);
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        $data = $request->all();
        try {
            DB::transaction(function () use ($id, $data) {
                $this->categoryRepository->update($id, $data);
            });
            DB::commit();

            return redirect()->route('category.get')->with('errCode', 1);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw ValidationException::withMessages([
                Constant::ERR_MSG => trans('messages.update_category.EM-001'),
            ]);
            return redirect()->route('category.get')->with('errCode', 0);
        }
    }

    public function delete(Request $request)
    {
        $errCode = $this->categoryRepository->delete($request->id);
        return redirect()->route('category.get')->with('errCode', $errCode);
    }

    public function detail($id)
    {
        $category = Category::find($id);
        return view('categories.detail', compact('category'));
    }
}
