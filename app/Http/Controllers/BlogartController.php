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
use Redirect;
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

        if ($po_data != null) {

            $post = Input::all();

            $dt = date('Y-m-d');
            $my_date = date('m/d/Y', strtotime($dt));
            $time = strtotime($my_date);
            $Date = date('Y/m/d', $time);

            if (isset($post['id']) && $post['id'] != null) {
                $rules = array(
                    'txtMessage' => 'required'
                );

                $validator = Validator::make(Input::all(), $rules);
                if ($validator->fails()) {
                    return Redirect::to('blogArt/' . $post['id'])
                                    ->withErrors($validator);
                }

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
                // var_dump(count($imgs));
                //exit;
                if (count($imgs) > 0) {
                    $destinationPath = 'images/blogArt';
                    foreach ($imgs as $key => $value) {
                        if ($value !== null) {
                            $filename = $post['id'] . '_' . Auth::user()->id . '_' . time() . '_' . $value->getClientOriginalName();
                            $one = $value->move($destinationPath, $filename);
                            $blog_files = DB::table('blog_files')->insert(
                                    array('name' => $filename,
                                        'blog_id' => $blog_id->id)
                            );
                        }
                    }
                }
                Session::flash('message', "Comment Added Sucessfully.");
                Session::flash('status', 'success');
                return redirect('/blogArt/' . $id);
            }
            // $data = DB::table('blog_art')->where('po_id',$id)->get();        
            $data = DB::table('blog_art')
                    ->leftJoin('user', 'user.id', '=', 'blog_art.customer_id')
                    ->select(array('user.name', 'user.image', 'blog_art.comments', 'blog_art.id', 'blog_art.customer_id'))
                    ->where('blog_art.po_id', '=', $id)
                    ->orderBy('id', 'DESC')
                    ->paginate(5);
            // ->orderBy('id', 'DESC')
            // ->groupBy('blog_art.id')
            //->get();
            

           // Paginator::setCurrentPage($lastPage);
         //  $publication = new Publication;
        //  $lastPage = $data->lastPage();
         //   $publication->getConnection()->setCurrentPage($lastPage);

             // DB::getPaginator()->setCurrentPage($lastPage);

            $image_data = DB::table('blog_files')
                    ->leftJoin('blog_art', 'blog_art.id', '=', 'blog_files.blog_id')
                    ->select(array('blog_files.name', 'blog_art.id'))
                    ->get();
            return view('blog_art', ['page_title' => 'Blog Art', 'po_id' => $po_data->po_number, 'id' => $id, 'bdata' => $data, 'image_data' => $image_data]);
        } else {
            Session::flash('message', "Opss..!,No Purchase Order Found...!");
            Session::flash('status', 'error');
            return redirect('/po/add');
        }
    }

}
