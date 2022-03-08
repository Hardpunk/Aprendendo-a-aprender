<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Category;
use App\Trail;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function home(Request $request)
    {
        $arrayCategorias = [28, 44, 4, 24, 23, 47, 18, 14, 38, 13, 25, 36];
        $idsCategorias = implode(',', $arrayCategorias);
        $categoriasDestaque = Category::whereIn('category_id', $arrayCategorias)
            ->orderByRaw("FIELD(category_id, {$idsCategorias})")->get();
        $categorias = Category::all();
        $banners = Banner::orderBy('order')->get();
        $trilhas = Trail::with('courses')->get();

        return view('index', [
            'categorias' => $categorias,
            'destaques' => $categoriasDestaque,
            'trilhas' => $trilhas,
            'banners' => $banners
        ]);
    }

    /**
     * @return View
     */
    public function termos()
    {
        return view('pages.condicoes-gerais');
    }

    public function contato()
    {
        return view('pages.contato');
    }

}
