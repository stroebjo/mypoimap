<?php

namespace App\Http\Controllers;

use App\UserCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(UserCategory::class, 'user_category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = UserCategory::where('user_id', Auth::id())->orderBy('order', 'ASC')->get();
        return view('category.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userCategory = new UserCategory();

        $userCategory->user_id = Auth::id();
        $userCategory->name    = $request->name;
        $userCategory->color   = $request->color;
        $userCategory->order   = $request->order;

        $userCategory->save();

        return redirect()->route('user_category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserCategory  $userCategory
     * @return \Illuminate\Http\Response
     */
    public function show(UserCategory $userCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserCategory  $userCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(UserCategory $userCategory)
    {
        return view('category.edit', ['category' => $userCategory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserCategory  $userCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserCategory $userCategory)
    {
        $userCategory->name  = $request->name;
        $userCategory->color = $request->color;
        $userCategory->order = $request->order;

        $userCategory->save();

        return redirect()->route('user_category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserCategory  $userCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserCategory $userCategory)
    {
        $userCategory->delete();
        return redirect()->route('user_category.index');
    }
}
