<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Constants\Constant;
use App\Http\Requests\TagRequest;
use App\Repositories\Tag\TagRepositoryInterface;

class TagController extends Controller
{
    /**
     * @param TagRepositoryInterface $tagRepository
     */
    public function __construct(
        public TagRepositoryInterface $tagRepository,
        )
    {

    }

    /**
     * get list tags
     * @Route get("/tag" name="tag.get")
     * @return View
     */
    public function get(): View
    {
        $tags = $this->tagRepository->all();

        return view('tags.list', [
            'tags'          => $tags,
            'breadcrumb'    => 'Tag'
        ]);
    }

    /**
     * @Route post("/tag" name="tag.create")
     * @param TagRequest $request
     * @return RedirectResponse
     */
    public function create(TagRequest $request): RedirectResponse
    {
        $data = $request->all();
        try {
            $this->tagRepository->create($data);

            return redirect()
                ->route('tag.get')
                ->with('errCode', 1);
        } catch (\Throwable $th) {
            return redirect()
                ->route('tag.get')
                ->with('errCode', 0);
        }
    }

    /**
     * @Route post("/edit/{id}/tag" name="tag.update")
     * @param TagRequest $request
     * @param integer|null $id
     * @return RedirectResponse
     */
    public function update(TagRequest $request, ?int $id): RedirectResponse
    {
        $data = $request->all();
        try {
            $this->tagRepository->update($id, $data);

            return redirect()
                ->route('tag.get')
                ->with('errCode', 1);
        } catch (\Throwable $th) {
            return redirect()
                ->route('tag.get')
                ->with('errCode', 0);
        }
    }

    /**
     * @Route get("/delete/tag" name="tag.delete")
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Request $request): RedirectResponse
    {
        $errCode = $this->tagRepository->delete($request->id);

        return redirect()
            ->route('tag.get')
            ->with('errCode', $errCode);
    }

    /**
     * @Route get("/detail/{id}/tag" name="tag.detail")
     * @param integer|null $id
     * @return View
     */
    public function detail(?int $id): View
    {
        $tag = $this->tagRepository->find($id);

        return view('tags.detail', [
            'tag' => $tag,
        ]);
    }
}
