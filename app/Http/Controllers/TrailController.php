<?php

namespace App\Http\Controllers;

use App\Trail;
use Cookie;
use Illuminate\Http\Request;

class TrailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $trail
     * @return \Illuminate\Http\Response
     */
    public function show($trail_slug)
    {
        $trail = Trail::where('slug', $trail_slug)
            ->with('courses')
            ->first();

        if ($trail !== null) {
            $in_cart = false;
            if (Cookie::has('cart')) {
                $cart = json_decode(Cookie::get('cart'), true);
                if (isset($cart['trail'])) {
                    $in_cart = array_search($trail->id, $cart['trail']) !== false;
                }
            }
            return view('pages.trilhas.show', ['trilha' => $trail, 'in_cart' => $in_cart]);
        }

        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trail  $trail
     * @return \Illuminate\Http\Response
     */
    public function edit(Trail $trail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trail  $trail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trail $trail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trail  $trail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trail $trail)
    {
        //
    }

    public function course($trail_slug, $course_slug)
    {
        $trail = Trail::where('slug', $trail_slug)
            ->with(['courses' => function ($q) use ($course_slug) {
                $q->where('slug', 'LIKE', $course_slug);
            }])
            ->first();

        if ($trail !== null) {
            return view('pages.trilhas.course', ['trilha' => $trail]);
        }

        return redirect('/');
    }
}
