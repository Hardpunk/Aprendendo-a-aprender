<?php

namespace App\Http\Controllers;

use App\Category;
use App\Course;
use Cookie;
use DB;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class CourseController extends IpedAPIController
{

    /**
     * @return Factory|View
     */
    public function index()
    {
        $categorias = Category::all();
        return view('pages.cursos.index', ['categorias' => $categorias]);
    }

    /**
     * @param $category_slug
     * @return Factory|View
     */
    public function category($category_slug)
    {
        $categorias = Category::all();
        $categoria = Category::where('slug', 'LIKE', $category_slug)
            ->with(['courses' => function ($q) {
                $q->orderBy('students', 'desc');
            }])
            ->first();
        $cursos = $categoria->courses;

        return view('pages.cursos.categoria',
            [
                'categorias' => $categorias,
                'categoria' => $categoria,
                'cursos' => $cursos,
            ]
        );
    }

    /**
     * @param $categoria
     * @param $curso
     * @return Factory|View
     */
    public function course($categoria, $curso)
    {
        $curso = Course::where('slug', 'LIKE', $curso)->first();
        $categoria = Category::where('slug', 'LIKE', $categoria)->first();
        $categorias = Category::all();

        if (!strpos($curso->teacher_image, '.jpg') && !check_remote_file($curso->teacher_image)) {
            $curso->teacher_image = "";
        }

        $in_cart = false;
        if (Cookie::has('cart')) {
            $cart = json_decode(Cookie::get('cart'), true);
            if (isset($cart['course'])) {
                $in_cart = array_search($curso->id, $cart['course']) !== false;
            }
        }

        return view('pages.cursos.curso', [
            'categoria' => $categoria,
            'categorias' => $categorias,
            'curso' => $curso,
            'in_cart' => $in_cart
        ]);
    }

    /**
     * Sync Courses by category and course slug
     *
     * @param string $categoria
     * @param string $curso
     * @return void
     */
    public function courseSync($categoria, $curso)
    {
        try {

            $_curso = $this->get_course_by_slug($curso);
            if ($_curso) {
                DB::beginTransaction();
                $curso = count($_curso->COURSES) > 0 ? $_curso->COURSES[0] : [];
                $course_data = [];
                $course_data['course_id'] = $curso->course_id;
                $course_data['category_id'] = $curso->course_category_id;
                $course_data['title'] = $curso->course_title;
                $course_data['description'] = $curso->course_description;
                $course_data['slug'] = $curso->course_slug;
                $course_data['category_slug'] = $curso->course_category_slug;
                $course_data['category_title'] = $curso->course_category_title;
                $course_data['old_price'] = 149.90;
                $course_data['price'] = 79.90;
                $course_data['rating'] = $curso->course_rating;
                $course_data['students'] = $curso->course_students;
                $course_data['captions'] = json_encode($curso->course_captions ?? []);
                $course_data['hours'] = $curso->course_hours;
                $course_data['topics'] = isset($curso->course_topics) ? json_encode($curso->course_topics) : json_encode([]);
                $course_data['video'] = $curso->course_video;
                $course_data['image'] = $curso->course_image;
                $course_data['slideshow'] = json_encode($curso->course_slideshow);
                $course_data['teacher_name'] = $curso->course_teacher->teacher_name ?? '';
                $course_data['teacher_description'] = $curso->course_teacher->teacher_description ?? '';
                $course_data['teacher_image'] = $curso->course_teacher->teacher_image ?? '';
                $newCourse = Course::updateOrCreate(['course_id' => $curso->course_id], $course_data);
                DB::commit();
            }
        } catch (Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Sync Categories from API
     *
     * @return void
     */
    public function categorySync()
    {
        try {
            $_categorias = $this->get_category_by_slug();

            if (isset($_categorias->CATEGORIES) && count($_categorias->CATEGORIES) > 0) {
                DB::beginTransaction();
                foreach ($_categorias->CATEGORIES as $category) {
                    $category_data = [];
                    $category_data['category_id'] = $category->category_id;
                    $category_data['title'] = $category->category_title;
                    $category_data['description'] = $category->category_description;
                    $category_data['slug'] = $category->category_slug;
                    $category_data['courses_total'] = $category->category_courses_total;
                    $category_data['image'] = $category->category_image;
                    $category_data['icon'] = $category->category_icon;
                    $newCategory = Category::updateOrCreate(['category_id' => $category->category_id], $category_data);
                }
                DB::commit();
            }
        } catch (Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Sync Courses from API
     *
     * @return void
     */
    public function categoryCourses()
    {
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 0);

        $categorias = Category::all();
        foreach ($categorias as $categoria) {
            for ($i = 1; $i <= 3; $i++) {
                $_categoria = $this->get_courses_by_category_id($categoria->category_id, $i);
                if (count($_categoria->COURSES) > 0) {
                    foreach ($_categoria->COURSES as $curso) {
                        $this->courseSync($categoria->slug, $curso->course_slug);
                    }
                }
            }
        }
    }
}
