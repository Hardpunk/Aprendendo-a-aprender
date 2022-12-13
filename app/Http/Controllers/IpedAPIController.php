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

    /**
     * @param string $query
     * @return array|mixed
     */
    public function get_category_by_query($query = '')
    {
        return $this->client->post('/category/get-categories', ['query' => $query]);
    }

    /**
     * @param int $page
     * @return array|mixed
     */
    public function get_course_by_page($page)
    {
        $query = [
            'page' => $page
        ];

        return $this->client->post('/course/get-courses', ['query' => $query]);
    }

    public function get_categories_courses()
    {
        $query = [
            'include_topics' => '1',
            'include_all' => '1'
        ];
        return $this->client->post('/course/get-categories-courses', ['query' => $query]);
    }

    /**
     * @param int $page
     * @return array|mixed
     */
    public function cancel_registration($platform_user_id)
    {
        return $this->client->post('/api/user/del-registration', ['user_id' => $platform_user_id]);
    }
}
