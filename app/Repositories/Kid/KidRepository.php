<?php

namespace App\Repositories\Kid;

use App\Models\Kid;
use App\Models\ModelHasCategory;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Constants\KidConstants;
use App\Constants\ModelHasCategoryConstants;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Diff\Diff;

class KidRepository extends BaseRepository implements KidRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return Kid::class;
    }

    /**
     * @param integer $parent_id
     * @param array $data
     * @return bool
     */
    public function createKidInformation(int $parent_id, array $data = []): bool
    {
        foreach ($data['kids'] as $item) :
            if ($item['db_id']):
                $kid = $this->update($item['db_id'], [
                    KidConstants::COL_PARENT_ID         => $parent_id,
                    KidConstants::COL_NICK_NAME         => $item['nickName'] ?? '',
                    KidConstants::COL_NAME              => $item['name'],
                    KidConstants::COL_LAST_NAME         => $item['lastName'],
                    KidConstants::COL_FIRST_NAME        => $item['firstName'],
                    KidConstants::COL_BIRTHDAY          => $item['birthday'],
                    KidConstants::COL_LEARNING_STYLE    => $item['learningStyle'],
                ]);
            else:
                $kid = $this->model->create([
                    KidConstants::COL_PARENT_ID         => $parent_id,
                    KidConstants::COL_NICK_NAME         => $item['nickName'] ?? '',
                    KidConstants::COL_NAME              => $item['name'],
                    KidConstants::COL_LAST_NAME         => $item['lastName'],
                    KidConstants::COL_FIRST_NAME        => $item['firstName'],
                    KidConstants::COL_BIRTHDAY          => $item['birthday'],
                    KidConstants::COL_LEARNING_STYLE    => $item['learningStyle'],
                ]);
            endif;

            $oldCategories = DB::table('model_has_categories')
                ->select('category_id')
                ->where([
                    ModelHasCategoryConstants::COL_MODEL_ID     => $kid->id,
                    ModelHasCategoryConstants::COL_MODEL_TYPE   => ModelHasCategoryConstants::MODEL_KID,
                ])
                ->get()
                ->map(function ($item) {return $item->category_id;});
            $newCategories = collect($item['categories']);
            
            foreach ($oldCategories->diff($newCategories) as $removeCategoryId):
                ModelHasCategory::where([
                    ModelHasCategoryConstants::COL_MODEL_ID     => $kid->id,
                    ModelHasCategoryConstants::COL_MODEL_TYPE   => ModelHasCategoryConstants::MODEL_KID,
                    ModelHasCategoryConstants::COL_CATEGORY_ID  => $removeCategoryId,
                ])->delete();
            endforeach;
            
            foreach ($newCategories->diff($oldCategories) as $addCategoryId) :
                if (! ModelHasCategory::create([
                        ModelHasCategoryConstants::COL_MODEL_ID     => $kid->id,
                        ModelHasCategoryConstants::COL_MODEL_TYPE   => ModelHasCategoryConstants::MODEL_KID,
                        ModelHasCategoryConstants::COL_CATEGORY_ID  => $addCategoryId,
                    ])
                ) :
                    return false;
                endif;
            endforeach;
        endforeach;

        return true;
    }

    /**
     * @param integer $parent_id
     * @param array $data
     * @return mixed
     */
    public function createKidIfNotExist(int $parent_id, array $data = [])
    {
        if (!$data[KidConstants::COL_ID]) :
            $kid_data = [
                KidConstants::COL_PARENT_ID     => $parent_id,
                KidConstants::COL_NAME          => $data[KidConstants::COL_NAME],
                KidConstants::COL_BIRTHDAY      => Carbon::now()->subYear($data[KidConstants::COL_BIRTHDAY]),
            ];
            $kid_create = $this->model->create($kid_data);
        else:
            $kid_create = $this->find($data[KidConstants::COL_ID]);
        endif;

        return $kid_create;
    }
}
