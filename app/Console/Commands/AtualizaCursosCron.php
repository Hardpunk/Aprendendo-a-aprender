<?php

namespace App\Console\Commands;

use App\Category;
use App\Course;
use App\Http\Controllers\IpedAPIController;
use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class AtualizaCursosCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atualizacursos:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rotina para buscar novos cursos no Iped.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            $output = new ConsoleOutput();
            ProgressBar::setFormatDefinition(
                'custom',
                '%current:3s%/%max% [%bar%] %percent:3s%% -- %message%'
            );

            $this->line('<bg=white;fg=green;options=bold>INICIANO ROTINA DE ATUALIZAÇÃO DE CURSOS NO IPED</>');
            $this->newLine();

            $IpedAPI = new IpedAPIController();
            $getCategoriesCourses = $IpedAPI->get_categories_courses();
            $totalCategories = count($getCategoriesCourses->CATEGORIES ?? 0);
            $arrayCategories = [];
            $totalCourses = 0;

            $section1 = $output->section();
            $section2 = $output->section();
            $progress1 = new ProgressBar($section1);
            $progress1->setFormat('custom');
            $progress2 = new ProgressBar($section2);
            $progress2->setFormat('custom');

            if ($totalCategories) {
                $progress1->setMessage("<bg=green;options=bold>INSERINDO CATEGORIAS...</>");
                $progress1->start($totalCategories);

                foreach ($getCategoriesCourses->CATEGORIES as $category) {
                    $progress1->setMessage(
                        "<options=bold>INSERINDO A CATEGORIA:</> <fg=magenta;options=bold>{$category->category_title}</>"
                    );
                    $progress1->display();
                    $this->updateOrCreateCategory($category);
                    $totalCourses += count($category->category_courses);
                    $arrayCategories[] = $category;
                    $progress1->advance();
                }

                $progress1->setMessage("<options=bold>ATUALIZAÇÃO DAS CATEGORIAS FINALIZADA</>");
                $progress1->finish();
            }

            if ($totalCourses) {
                $progress2->setMessage("<bg=green;options=bold>INSERINDO CURSOS...</>");
                $progress2->start($totalCourses);
                foreach ($arrayCategories as $category) {
                    foreach ($category->category_courses as $course) {
                        $progress2->setMessage(
                            "<options=bold>INSERINDO O CURSO:</> <fg=yellow;options=bold>{$course->course_title}</>"
                        );
                        $progress2->display();
                        $this->updateOrCreateCourse($category, $course);
                        $progress2->advance();
                    }
                }
                $progress2->setMessage("<options=bold>ATUALIZAÇÃO DOS CURSOS FINALIZADA</>");
                $progress2->finish();
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return Command::FAILURE;
        }

        $this->newLine();
        $this->line('<bg=white;fg=green;options=bold>FIM DA ROTINA</>');

        return Command::SUCCESS;
    }

    /**
     * @param $category
     * @return void
     */
    public function updateOrCreateCategory($category): void
    {
        $data['icon'] = $category->category_icon;
        $data['courses_total'] = count($category->category_courses ?? 0);
        $categoryInstance = Category::where('category_id', $category->category_id)->withTrashed()->firstOrNew();

        if ($categoryInstance->id !== null) {
            if (!str_contains($categoryInstance->image, '/images/cursos/')) {
                $data['image'] = $category->category_image;
            }
            $categoryInstance->update($data);
        } else {
            $data['category_id'] = $category->category_id;
            $data['slug'] = $category->category_slug;
            $data['image'] = $category->category_image;
            $data['title'] = $category->category_title;
            $data['description'] = $category->category_description;
            $categoryInstance->fill($data)->save();
        }
    }

    /**
     * @param $category
     * @param $course
     * @return void
     */
    public function updateOrCreateCourse($category, $course): void
    {
        $data['category_id'] = $course->course_category_id;
        $data['category_slug'] = $category->category_slug;
        $data['category_title'] = $category->category_title;
        $data['rating'] = $course->course_rating;
        $data['students'] = $course->course_students;
        $data['captions'] = json_encode($course->course_captions);
        $data['hours'] = $course->course_hours;
        $data['topics'] = isset($course->course_topics) ? json_encode($course->course_topics) : '';
        $data['video'] = $course->course_video;
        $data['background'] = '';
        $data['slideshow'] = json_encode($course->course_slideshow);
        $data['teacher_name'] = $course->course_teacher->teacher_name;
        $data['teacher_description'] = $course->course_teacher->teacher_description;
        $data['teacher_image'] = $course->course_teacher->teacher_image;
        $courseInstance = Course::where('course_id', $course->course_id)->withTrashed()->firstOrNew();

        if ($courseInstance->id !== null) {
            if (!str_contains($courseInstance->image, '/images/courses/')) {
                $data['image'] = $course->course_image;
            }
            $courseInstance->update($data);
        } else {
            $data['title'] = $course->course_title;
            $data['description'] = $course->course_description;
            $data['slug'] = $course->course_slug;
            $data['old_price'] = $course->course_price;
            $data['price'] = $course->course_price;
            $data['image'] = $course->course_image;
            $data['course_id'] = $course->course_id;
            $courseInstance->fill($data)->save();
        }
    }
}
