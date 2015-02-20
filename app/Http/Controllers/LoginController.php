<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Input;
use DB;
use Validator;
use Session;
use Hash;
use Auth;
use Redirect;
use View;
use Mail;
//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        /*
          //echo var_dump(Config::get('session.lifetime'));exit;

         *          */
        //	return view('login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function login(Request $request)
    {

        $rules = array(
            'email' => 'required|email',
            'password' => 'required',
        );
        $credentials = Input::all();
        $email = $credentials['email'];
        $password = $credentials['password'];
        if (Auth::validate(array('email' => $email, 'password' => $password)) && Auth::attempt(array('email' => $email, 'password' => $password), false)) {
            Session::flash('message', 'Login Successfully!!!');
            return Redirect::intended('/part');
        } else {
            $error = 'wrong email or password..';
            Session::flash('messagelogin', $error);
            Session::flash('alert-class', 'alert-danger');
            return redirect('/')
                            ->withInput($request->only('email', 'remember'));
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function forgotPassword(Request $request)
    {
        $post = Input::all();
        unset($post['_token']);

        if (isset($post['email']) && $post['email'] != null) {
            $rules = array(
                'email' => 'required|Email',
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                $error = 'please enter valid email address.';
                Session::flash('messagelogin', $error);
                Session::flash('alert-class', 'alert-danger');
            } else {
                $user = DB::table('user')
                                ->where('email', $post['email'])->first();

                if (!empty($user)) {
                    $token = md5(uniqid(rand(), true));
                    $to = $post['email'];
                    $subject = 'Forgot Password';
                    $link = action('LoginController@resetPassword', array('id' => $user->id, 'token' => $token));
                    $body = View::make('resetPassword', ['link' => $link, 'username' => $user->name]);
                    $data = array(
                        'username' => $user->name,
                        'link' => $link,
                    );    // $bodyK = view('resetPassword', ['link' => $link, 'username' => $user->name ]);                    

                    $mail_status = Mail::send('mailTemplet', $data, function($m) {
                                $m->to('wamasoftware5@gmail.com', 'Hiiii.....');
                                $m->subject('Forgot Password');
                            });

                    $db_status = DB::table('user')
                            ->where('id', $user->id)
                            ->update(array('email_token' => $token));

                    if ($mail_status && $db_status) {
                        $error = 'Reset password link is send to your Email address.';
                        Session::flash('messagelogin', $error);
                        Session::flash('alert-class', 'alert-danger');
                        return redirect('/');
                    } else {
                        $error = 'Something went wrong.';
                        Session::flash('messagelogin', $error);
                        Session::flash('alert-class', 'alert-danger');
                    }
                } else {
                    $error = 'Email address not registered with us.';
                    Session::flash('messagelogin', $error);
                    Session::flash('alert-class', 'alert-danger');
                }
            }
            return redirect('/forgotpassword');
        }
        return view('forgotPassword');
    }

    public function resetPassword()
    {
        $id = Input::get('id');
        $token = Input::get('token');
        //   $userforgetdata = array();
        $userforgetdata['id'] = $id;
        $userforgetdata['email_token'] = $token;
        $post = Input::all();
        $checkUser = null;
        if (isset($post['id']) && isset($post['email_token'])) {

            $checkUser = DB::table('user')
                    ->select(array('id', 'email_token'))
                    ->where('id', $post['id'])
                    ->where('email_token', $post['email_token'])
                    ->first();
            if (!isset($checkUser)) {
                $error = 'Invalid token';
                Session::flash('messagelogin', $error);
                Session::flash('alert-class', 'alert-danger');
                return redirect('/forgotpassword');
            }
        }

        /* $rules = array(
          'password' => 'required',
          'repassword' => 'same:password|required_with:password,value'
          ); */
        if (isset($post['password']) && isset($post['repassword'])) {
            $userforgetdata['id'] = $post['id'];
            $userforgetdata['email_token'] = $post['email_token'];
            if (($post['password'] === $post['repassword'])) {
                $userUpdate = DB::table('user')
                        ->where('id', $checkUser->id)
                        ->update(array('password' => Hash::make($post['password'])));
                if (isset($userUpdate)) {
                    $tokenUpdate = DB::table('user')
                            ->where('id', $checkUser->id)
                            ->update(array('email_token' => ''));
                    if (isset($tokenUpdate)) {
                        $error = 'Password successfully reset. Login from here.';
                        Session::flash('messagelogin', $error);
                        Session::flash('alert-class', 'alert-danger');
                        return redirect('/');
                    } else {
                        $error = 'Whoops, Something went to wrong. Try again!!.';
                        Session::flash('messagelogin', $error);
                        Session::flash('alert-class', 'alert-danger');
                    }
                } else {
                    $error = 'Whoops, Something went to wrong. Try again!!.';
                    Session::flash('messagelogin', $error);
                    Session::flash('alert-class', 'alert-danger');
                }
            } else {
                $error = 'Password and Re-Type password cannot be different.';
                Session::flash('messagelogin', $error);
                Session::flash('alert-class', 'alert-danger');
            }
            /*  $validator = Validator::make(Input::all(), $rules);
              if ($validator->fails()) {
              $error = 'Password do not match.';
              Session::flash('messagelogin', $error);
              Session::flash('alert-class', 'alert-danger');
              } else {
              var_dump($id);
              $user = DB::table('user')
              ->where('id', $id)
              ->update(array('password' => $post['password']));
              var_dump($user);
              exit("sdh");

              if ($user == '1') {
              $error = 'Password has been changed.';
              Session::flash('messagelogin', $error);
              Session::flash('alert-class', 'alert-danger');
              return redirect('/');
              } else {
              $error = 'Something went wrong.';
              Session::flash('messagelogin', $error);
              Session::flash('alert-class', 'alert-danger');
              }
              } */
        } 
        return view('resetPassword')->with('userforgetdata', $userforgetdata);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
