<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Constants\Constant;
use App\Http\Requests\CategoryRequest;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    /**
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        public CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    /**
     * get list categories
     * @Route get("/category" name="category.get")
     * @return View
     */
    public function get(): View
    {
        $categories = $this->categoryRepository->all();

        return view('categories.list', [
            'categories' => $categories,
            'breadcrumb' => 'Category'
        ]);
    }

    /**
     * @Route post("/category" name="category.create")
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function create(CategoryRequest $request): RedirectResponse
    {
        $data = $request->all();
        try {
            $this->categoryRepository->create($data);

            return redirect()
                ->route('category.get')
                ->with('errCode', 1);
        } catch (\Throwable $th) {
            return redirect()
                ->route('category.get')
                ->with('errCode', 0);
        }
    }

    /**
     * @Route post("/edit/{id}/category" name="category.update")
     * @param CategoryRequest $request
     * @param integer|null $id
     * @return RedirectResponse
     */
    public function update(CategoryRequest $request, ?int $id): RedirectResponse
    {
        $data = $request->all();
        try {
            $this->categoryRepository->update($id, $data);

            return redirect()
                ->route('category.get')
                ->with('errCode', 1);
        } catch (\Throwable $th) {
            return redirect()
                ->route('category.get')
                ->with('errCode', 0);
        }
    }

    /**
     * @Route get("/delete/category" name="category.delete")
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Request $request): RedirectResponse
    {
        $errCode = $this->categoryRepository->delete($request->id);

        return redirect()
            ->route('category.get')
            ->with('errCode', $errCode);
    }

    /**
     * @Route get("/detail/{id}/category" name="category.detail")
     * @param integer|null $id
     * @return View
     */
    public function detail(?int $id): View
    {
        $category = $this->categoryRepository->find($id);

        return view('categories.detail', [
            'category' => $category,
        ]);
    }
}
