<?php

namespace App\Http\Controllers;

use App\Constants\Constant;
use App\Http\Requests\TagRequest;
use App\Repositories\User\TagRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TagController extends Controller
{
    public function __construct(
        public TagRepositoryInterface $tagRepository,
        )
    {

    }

    /**
     * get list tags
     * @Route get("tag.get")
     * @return Factory|View|RedirectResponse
     */
    public function get()
    {
        $tags = $this->tagRepository->all();
        return view('tags.list', [
            'tags' => $tags,
        ]);
    }

    /**
     * create tag
     * @Route post("tag.create")
     * @param TagRequest
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(TagRequest $request)
    {
        $data = $request->all();
        try {
            $this->tagRepository->create($data);
            return redirect()->route('tag.get')->with('errCode', 1);
        } catch (\Throwable $th) {
            throw ValidationException::withMessages([
                Constant::ERR_MSG => trans('messages.create_tag.EM-001'),
            ]);
            return redirect()->route('tag.get')->with('errCode', 0);
        }
    }

    /**
     * update tag
     * @Route post("tag.update")
     * @param TagRequest
     * @param int $id
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(TagRequest $request, $id)
    {
        $data = $request->all();
        try {
            $this->tagRepository->update($id, $data);
            return redirect()->route('tag.get')->with('errCode', 1);
        } catch (\Throwable $th) {
            throw ValidationException::withMessages([
                Constant::ERR_MSG => trans('messages.update_tag.EM-001'),
            ]);
            return redirect()->route('tag.get')->with('errCode', 0);
        }
    }

    /**
     * delete tag
     * @Route post("tag.delete")
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function delete(Request $request)
    {
        $errCode = $this->tagRepository->delete($request->id);
        return redirect()->route('tag.get')->with('errCode', $errCode);
    }

    /**
     * get detail tag
     * @Route get("tag.detail")
     * @return Factory|View|RedirectResponse
     */
    public function detail($id)
    {
        $tag = $this->tagRepository->find($id);
        return view('tags.detail', [
            'tag' => $tag,
        ]);
    }
}
