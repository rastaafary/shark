<?php

namespace App\Http\Controllers;

use File;
use Session;
use Input;
use DB;
use View;
use Validator;
use Datatables;
use Auth;
use Response;
use Request;
use App\Http\Controllers\Image;
use Illuminate\Database\Query\Builder;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BlogartController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function viewBlog($id = null)
    {
        $post = Input::all();
        if (isset($post['id']) && $post['id'] != null) {
            $file = Input::file('images');
            var_dump($post);
        }
        return view('blog_art');
    }

    public function index($id = null)
    {
        $po_data = DB::table('purchase_order')->where('id', $id)->first();
        $post = Input::all();

        $dt = date('Y-m-d');
        $my_date = date('m/d/Y', strtotime($dt));
        $time = strtotime($my_date);
        $Date = date('Y/m/d', $time);

        if (isset($post['id']) && $post['id'] != null) {
            
            $blog_art = DB::table('blog_art')->insert(
                    array('po_id' => $post['id'],
                        'customer_id' => Auth::user()->id,
                        'date' => $Date,
                        'comments' => $post['txtMessage'])
            );

            $blog_id = DB::table('blog_art')
                    ->where('po_id', $post['id'])
                    ->where('customer_id', Auth::user()->id)
                    ->orderBy('id', 'desc')
                    ->first();
                  
            $imgs = Input::file('images'); 
          
            if (count($imgs[0]) > 0) {
                $destinationPath = 'images/blogArt';
                foreach ($imgs as $key => $value) {
                    $filename = $post['id'] . '_' . Auth::user()->id . '_' . time() . '_' . $value->getClientOriginalName();
                    $one = $value->move($destinationPath, $filename);
                    $blog_files = DB::table('blog_files')->insert(
                            array('name' => $filename,
                                'blog_id' => $blog_id->id)
                    );
                }
            }            
            Session::flash('message', "Comment Added Sucessfully.");
            Session::flash('status', 'sucess');
            return redirect('/blogArt/'.$id);
        }
       // $data = DB::table('blog_art')->where('po_id',$id)->get();        
        $data = DB::table('blog_art')
                ->leftJoin('user', 'user.id', '=', 'blog_art.customer_id')
                //->leftJoin('blog_files', 'blog_files.blog_id', '=', 'blog_art.id')
                ->select(array('user.name', 'user.image', 'blog_art.comments'))
                ->groupBy('blog_art.id')->get();
        var_dump($data);
        return view('blog_art', ['page_title' => 'Blog Art', 'po_id' => $po_data->po_number, 'id' => $id,'data' => $data]);        
    }

}
