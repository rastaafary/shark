<?php 

namespace App\Http\Controllers;

class BlogartController extends Controller {

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