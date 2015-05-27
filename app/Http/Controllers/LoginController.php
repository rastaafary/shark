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
use DateTime;
use App\model\Role;
use App\User;
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
            Session::flash('status', 'success');

            $check_user_has_role = DB::table('role_user')->where('user_id', '=', Auth::User()->id)->first();

            if ($check_user_has_role == null) {
                $role = Role::all();

                if (Auth::User()->role == 1) {
                    $user = User::where('id', '=', Auth::User()->id)->first();
                    $user->attachRole($role[0]);
                    // return Redirect('permissionCreate');
                } else if (Auth::User()->role == 2) {
                    $user = User::where('id', '=', Auth::User()->id)->first();
                    $user->attachRole($role[1]);
                    // return Redirect('permissionCreate');
                } else if (Auth::User()->role == 3) {
                    $user = User::where('id', '=', Auth::User()->id)->first();
                    $user->attachRole($role[2]);
                    //  return Redirect('permissionCreate');
                }
            }
            if (Auth::user()->hasRole('customer')) {
                return Redirect::intended('/po');
            } else {
                return Redirect::intended('/part');
            }
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
                    $token = md5(uniqid(time(), true));
                    $to = $post['email'];
                    //$to = "wamasoftware5@gmail.com";
                    $subject = 'Forgot Password';
                    $link = action('LoginController@resetPassword', array('id' => $user->id, 'token' => $token));
//                   / $body = View::make('resetPassword', ['link' => $link, 'username' => $user->name]);
                    /*  $data = array(
                      'username' => $user->name,
                      'link' => $link,
                      );    // $bodyK = view('resetPassword', ['link' => $link, 'username' => $user->name ]); */

                    $message = '<html>
                                <head>
                                    <meta charset="utf-8">
                                </head>
                                <body>
                                    <h2>Forgot Password</h2>

                                    <div>
                                        Dear ' . $user->name . ', <a href=' . $link . '>Click Here</a> to reset your password. 
                                    </div>
                                </body>
                            </html>';
                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                    $mail_status = mail($to, $subject, $message, $headers);
                    /*   $mail_status = Mail::send('mailTemplet', $data, function($m) {
                      $m->to('wamasoftware5@gmail.com', 'Hiiii.....');
                      $m->subject('Forgot Password');
                      });
                     */
                    $db_status = DB::table('user')
                            ->where('id', $user->id)
                            ->update(array('email_token' => $token, 'time' => date('Y-m-d H:i:s')));

                    if ($mail_status && $db_status) {
                        $error = 'Reset password link is send to your Email address.';
                        Session::flash('messagelogin', $error);
                        Session::flash('status', 'success');
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
        if (isset($id) && isset($token)) {
            $dbTime = DB::table('user')
                    ->select(array('time'))
                    ->where('id', $id)
                    ->where('email_token', $token)
                    ->first();
            if (!isset($dbTime)) {
                $error = 'Invalid token';
                Session::flash('messagelogin', $error);
                Session::flash('alert-class', 'alert-danger');
                return redirect('/forgotpassword');
            }
            $time = strtotime($dbTime->time);
            $dbTime = strtotime('+24 hour', $time);
            if (strtotime(date('Y-m-d H:i:s')) > $dbTime) {
                $error = 'Sorry, Your reset password link has been expired..!!';
                Session::flash('messagelogin', $error);
                Session::flash('alert-class', 'alert-danger');
                return redirect('/');
            }
        }
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
                        Session::flash('status', 'success');
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
