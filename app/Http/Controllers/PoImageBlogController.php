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

class PoImageBlogController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $po_image_data = DB::table('po_images')->where('id', $id)->first();

        if ($po_image_data != null) {

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
                    return Redirect::to('blog/' . $post['id'])
                                    ->withErrors($validator);
                }

                $comment_id = DB::table('image_blog_comments')->insertGetId(
                        array('image_blog_id' => $id,
                            'customer_id' => Auth::user()->id,
                            'date' => $Date,
                            'comments' => $post['txtMessage'])
                );

                $imgs = Input::file('images');
                if (count($imgs) > 0) {
                    $destinationPath = 'images/blog';
                    foreach ($imgs as $key => $value) {
                        if ($value !== null) {
                            $filename = $post['id'] . '_' . Auth::user()->id . '_' . time() . '_' . $value->getClientOriginalName();
                            $one = $value->move($destinationPath, $filename);
                            DB::table('image_blog_files')->insert(
                                    array('filename' => $filename,
                                        'comment_id' => $comment_id,
                                        'date' => $Date)
                            );
                        }
                    }
                }
                Session::flash('message', "Comment Added Sucessfully.");
                Session::flash('status', 'success');
                return redirect('/blog/' . $id);
            }

            $data = DB::table('image_blog_comments')
                    ->leftJoin('user', 'user.id', '=', 'image_blog_comments.customer_id')
                    ->select(array('user.name', 'user.image', 'image_blog_comments.comments', 'image_blog_comments.id', 'image_blog_comments.customer_id'))
                    ->where('image_blog_comments.image_blog_id', '=', $id)
                    ->orderBy('id', 'DESC')
                    ->paginate(10);

            $image_data = DB::table('image_blog_files')
                    ->leftJoin('image_blog_comments', 'image_blog_comments.id', '=', 'image_blog_files.comment_id')
                    ->select(array('image_blog_files.*'))
                    ->get();
//            echo "<pre>";print_r($image_data);exit;
            return view('poImageblog', ['page_title' => 'Image Blog Art', 'po_image_data' => $po_image_data, 'id' => $id, 'comments' => $data, 'image_data' => $image_data]);
        } else {
            Session::flash('message', "Opss..!,blog not found...!");
            Session::flash('status', 'error');
            return redirect('/po/add');
        }

        return view('poImageblog', ['page_title' => 'Blog Art']);
    }

}
