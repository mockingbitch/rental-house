<?php

namespace App\Repositories\ModelHasCategory;

use App\Models\Kid;
use App\Models\ModelHasCategory;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Constants\KidConstants;
use App\Constants\ModelHasCategoryConstants;
use App\Repositories\ModelHasCategory\ModelHasCategoryRepositoryInterface;
use Carbon\Carbon;

class ModelHasCategoryRepository extends BaseRepository implements ModelHasCategoryRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return ModelHasCategory::class;
    }

    public function getAllCategoryOfKid($kid_id)
    {
        $modelHasCategories =  $this->model->where([
            ModelHasCategoryConstants::COL_MODEL_TYPE   => ModelHasCategoryConstants::MODEL_KID,
            ModelHasCategoryConstants::COL_MODEL_ID     => $kid_id,
        ])->get();

        $categories = [];
        foreach ($modelHasCategories as $modelHasCategory):
            $categories[] = $modelHasCategory->category;
        endforeach;

        return $categories;
    }
}