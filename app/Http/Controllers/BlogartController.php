<?php 

namespace App\Http\Controllers;

class BlogartController extends Controller {
     public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function viewBlog()
	{
		return view('blog_art',['page_title'=>'Blog Art']);
	}
}