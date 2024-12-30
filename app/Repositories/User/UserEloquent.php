<?php

namespace App\Repositories\User;

use App\Models\User;

class UserEloquent implements UserInterface
{
        private $model;

        /**
         * UserEloquent constructor.
         * @param User $model
         */
        public function __construct(User $model)
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
                ->paginate(24);
        }
        /**
         * @param array $options
         * @param false $totalrowcount
         * @return mixed
         */
        public function getDataByFilter(array $options = [], $totalrowcount = false)
        {

        $default = [
            'search_key' => null,
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
            $users = $this->model
            ->leftjoin('roles', 'roles.id', 'users.role')
            ->select('users.*', 'roles.name AS role_name')
            ->where('users.name', 'LIKE', '%'.$no['search_key'].'%')
            ->orWhere('users.email', 'LIKE', '%'.$no['search_key'].'%')
            ->orWhere('users.employee_no', 'LIKE', '%'.$no['search_key'].'%')
            ->orWhere('users.username', 'LIKE', '%'.$no['search_key'].'%')
            ->orWhere('roles.name', 'LIKE', '%'.$no['search_key'].'%')
            ->paginate('48');

            //dd($sites);
        } else {
            $users = [];
        }

        //dd($sites);
        return $users;
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
