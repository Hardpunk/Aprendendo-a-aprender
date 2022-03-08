<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
        $categorias = Category::all();
        $result = Category::with([
            'courses' => function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%");
                $q->orderBy('students', 'DESC');
            }])
            ->whereHas('courses', function($q) use ($query) {
                return $q->where('title', 'like', "%{$query}%");
            })
            ->get();

        return view('pages.search',
            [
                'categorias' => $categorias,
                'search' => $query,
                'result' => $result
            ]
        );
    }
}
