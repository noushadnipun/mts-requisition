<?php

namespace App\Repositories\Routelist;

use App\Models\Routelist;

class RoutelistEloquent implements RoutelistInterface
{
    private $model;

    /**
     * RoutelistEloquent constructor.
     * @param RoutelistInterface $model
     */
    public function __construct(Routelist $model)
    {
        $this->model = $model;
    }

    /**
     *
     */
    public function getAll()
    {
        return $this->model
            ->orderBy('id', 'desc')
            //->take(100)
            ->paginate(10);
    }

    public function getDataByFilter(array $options = [], $totalrowcount = false)
    {
        $default = [
            'search_key' => null,
            'column' => !empty($field) ? $field : null,
            'sort_type' => !empty($type) ? $type : null,
            'limit' => 10,
            'offset' => 0
        ];
        $no = array_merge($default, $options);

        if (!empty($no['limit'])) {
            $limit = $no['limit'];
        } else {
            $limit = 10;
        }

        if (!empty($no['offset'])) {
            $offset = $no['offset'];
        } else {
            $offset = 0;
        }

        if (!empty($no['sort_type'])) {
            $orderBy = $no['column'] . ' ' . $no['sort_type'];
        } else {
            $orderBy = 'id desc';
        }

        if (!empty($no['search_key'])) {
            if ($totalrowcount == true) {
                return $this->model
                    ->orWhere('route_name', 'like', "%{$no['search_key']}%")
                    ->paginate($limit)
                    ->get()->count();
            } else {
                return $this->model
                    ->orWhere('route_name', 'like', "%{$no['search_key']}%")
                    ->paginate($limit);
            }
        } else {
            if ($totalrowcount == true) {
                return $this->model
                    ->get()->count();
            } else {
                return $this->model
                    ->leftJoin('productcategories AS pc', function ($join) {
                        $join->on('products.id', '=', 'pc.main_pid');
                    })
                    //->whereIn('pc.term_id', $no['category'])
                    //->whereRaw('parent_id IS NULL')
                    //->whereRaw($price_btw)
                    //->orderByRaw($orderBy)
                    //->offset($offset)->limit($limit)
                    //->toSql();
                    //->select(['products.*', 'pc.*', 'products.id AS proid'])
                    //->orderBy('products.id', 'desc')
                    ->paginate(5);
            }
        }
    }


    /**
     * @param $id
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param $column
     * @param $value
     */
    public function getByAny($column, $value)
    {
        return $this->model->where($column, $value)->get();
    }

    /**
     * @param array $att
     */
    public function create(array $att)
    {
        return $this->model->create($att);
    }

    /**
     * @param $id
     * @param array $att
     */
    public function update($id, array $att)
    {
        $todo = $this->getById($id);
        $todo->update($att);
        return $todo;
    }

    public function delete($id)
    {
        $this->getById($id)->delete();
        return true;
    }
}
