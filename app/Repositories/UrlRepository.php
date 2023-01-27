<?php

namespace App\Repositories;

use App\Models\Url;

class UrlRepository
{
    protected $model;

    public function __construct(Url $url)
    {
        $this->model = $url;
    }

    /**
     * Get paginated data for URLs
     */
    public function getAll($user_id)
    {
        return Url::where('user_id', $user_id)->latest()->paginate(10);
    }

    /**
     * Create a new Url in the database.
     */
    public function create(array $data)
    {
        $url = Url::create($data);
        return $url;
    }

    /**
     * Make a query in model
     */
    public function findWhere(array $where)
    {
        return $this->model->where($where)->get();
    }

    /**
     * Update an existing Url in the database.
     */
    public function update(Url $url, array $data)
    {
        $url->destination = $data['destination'];
        $url->slug = $data['slug'];
        $url->save();
        return $url;
    }

    /**
     * Delete an existing Url from the database.
     */
    public function delete(Url $url)
    {
        return $url->delete();
    }

}
