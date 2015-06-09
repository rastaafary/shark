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

    public function __construct() {
        $this->middleware('auth');
    }

    public function index($id = null) {
        $po_image_data = DB::table('po_images')->where('id', $id)->first();

        if ($po_image_data != null) {

            $post = Input::all();

            $dt = date('Y-m-d');
            $my_date = date('m/d/Y', strtotime($dt));
            $time = strtotime($my_date);
            $Date = date('Y/m/d', $time);

            $isValidUser = $this->isValidateForApprove($id);

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
                    $destinationPath = getcwd() . '/images/blog';
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

            $orderList = array();
            //get Order list
            if ($isValidUser == true) {
                $orderList = DB::table('order_list')
                        ->select(array('part_number.SKU as sku', 'order_list.id as order_id'))
                        ->leftJoin('part_number', 'part_number.id', '=', 'order_list.part_id')
                        ->where('order_list.po_id', $po_image_data->po_id)
                        ->get();
            }

            return view('poImageblog', ['page_title' => 'Image Blog Art', 'ordersList' => $orderList, 'po_image_data' => $po_image_data, 'isValidUser' => $isValidUser, 'id' => $id, 'comments' => $data, 'image_data' => $image_data]);
        } else {
            Session::flash('message', "Opss..!,blog not found...!");
            Session::flash('status', 'error');
            return redirect('/po/add');
        }

        return view('poImageblog', ['page_title' => 'Blog Art']);
    }

    protected function isValidateForApprove($blodId) {
        $count = DB::table('po_images')
                ->leftJoin('purchase_order', 'purchase_order.id', '=', 'po_images.po_id')
                ->leftJoin('customers', 'customers.id', '=', 'purchase_order.customer_id')
                ->leftJoin('user', 'user.id', '=', 'customers.user_id')
                ->where('user.id', Auth::id())
                ->where('po_images.id', $blodId)
                ->count();

        if ((int) $count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function approveImage($id = null) {
        $po_image_data = DB::table('po_images')->where('id', $id)->first();

        if ($po_image_data != null) {

            $post = Input::all();

            if (Request::isMethod('post')) {

                $imageCommentList = DB::table('image_blog_comments')
                        ->leftJoin('image_blog_files', 'image_blog_files.comment_id', '=', 'image_blog_comments.id')
                        ->select('image_blog_files.filename', 'image_blog_files.id')
                        ->where('image_blog_id', $id)
                        ->orderBy('image_blog_files.id', 'desc')
                        ->get();

                if ($this->isValidateForApprove($id)) {
                    DB::table('po_images')
                            ->where('id', $id)
                            ->update(array('is_approved' => 1, 'order_id' => $post['order'], 'approved_image' => $imageCommentList[0]->filename));

                    Session::flash('message', "Approved successfuly.");
                    Session::flash('status', 'success');
                } else {
                    Session::flash('message', "Access Denined.");
                    Session::flash('status', 'error');
                }
            }
        } else {
            Session::flash('message', "Opss..!,blog not found...!");
            Session::flash('status', 'error');
            return redirect('/po/add');
        }
        return redirect('/blog/' . $id);
    }

}
