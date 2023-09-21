<?php

namespace App\Repositories\Request;

use App\Models\Request;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Constants\RequestConstants;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;
use App\Constants\CommonConstants;
use Carbon\Carbon;

class RequestRepository extends BaseRepository implements RequestRepositoryInterface
{
    /**
     * Get model.
     *
     * @return Model|string
     */
    public function getModel(): Model|string
    {
        return Request::class;  
    }

    public function getRequestApplied($teacher_id)
    {
        return $this->model
                    ->select(DB::raw('requests.*, lessons.*, request_applications.created_at as applied_date, requests.language as request_language'))
                    ->join('request_applications', function (JoinClause $join) {
                        $join->on('request_applications.request_id', '=', 'requests.id');
                    })
                    ->join('lessons', function (JoinClause $join) use ($teacher_id) {
                        $join->on('lessons.id', '=', 'request_applications.lesson_id')
                            ->where('lessons.teacher_id', '=', $teacher_id);
                    })
                    ->get();
    }

    /**
     * @param array $data
     * @param string $columns
     * @return Collection
     */
    public function getRequests(array $data, $columns = '*', $limit = null): Collection
    {
        $query = $this->model;

        if (! empty($data)) :
            $query = $query->where($data);
        endif;
        if ($limit !== null) :
            $query = $query->limit($limit);
        endif;
        $requests = $query
            ->orderBy(CommonConstants::COL_CREATED, CommonConstants::ORDER_DESC)
            ->get($columns);
        
        foreach ($requests as $request) :
            $created = Carbon::parse($request->created_at)->addWeeks(1);

            if ($created->gt(Carbon::now())) :
                $request->isNew = true;
            else :
                $request->isNew = false;
            endif;
        endforeach;

        return $requests;
    }
}