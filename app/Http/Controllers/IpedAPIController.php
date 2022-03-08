<?php

namespace App\Http\Controllers;

use App\Classes\IpedAPI;

class IpedAPIController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new IpedAPI();
    }

    /**
     * @param string $slug
     * @return array|mixed
     */
    public function get_course_by_slug($slug = '')
    {
        $query = [
            'slug' => $slug,
            'include_topics' => '1',
        ];
        return $this->client->post('/course/get-courses', ['query' => $query]);
    }

    /**
     * @param string $id
     * @return array|mixed
     */
    public function get_course_by_id($id)
    {
        $query = [
            'course_id' => $id,
        ];
        return $this->client->post('/course/get-courses', ['query' => $query]);
    }

    /**
     * @param string $slug
     * @return array|mixed
     */
    public function get_courses_by_category_slug($slug = '')
    {
        return $this->client
            ->post('/course/get-courses', [
                'query' => [
                    'category_slug' => $slug,
                    'include_topics' => '1',
                ],
            ]);
    }

    /**
     * @param string $slug
     * @return array|mixed
     */
    public function get_category_by_slug($slug = '')
    {
        return $this->client->post('/category/get-categories', ['query' => ['slug' => $slug]]);
    }

    public function user_registration($arrayData)
    {
        return $this->client->post('/user/set-registration', ['query' => $arrayData]);
    }
}
