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

    public function forgotPassword()
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
                    $error = 'Reset password link is send to your Email address.';
                    Session::flash('messagelogin', $error);
                    Session::flash('alert-class', 'alert-danger');
                    return redirect('/');
                } else {
                    $error = 'Email address not registered with us.';
                    Session::flash('messagelogin', $error);
                    Session::flash('alert-class', 'alert-danger');
                }
            }
            return redirect('/forgotpassword');
        }
        /* if (!empty($user)) {     //If user available
          // Send Mail to user
          $hostname = $request->getHttpHost();
          $mailer = $this->get('my_mailer');
          $to = $post['email'];
          $subject = 'Forgot Password';
          $link = 'http://' . $hostname . $this->generateUrl('resetpassword', array('userid' => $userDetails->getId(), 'token' => $token));
          $body = $this->renderView('AcmeTMSBundle:Mail_Template:forgot_password.html.twig', array('link' => $link, 'username' => $userDetails->getFirstName()));

          $from = 'donotreplay@classcare.in';
          $headers = "From: " . strip_tags($from) . "\r\n";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
          $mailer->allsendmail($to, $subject, $body, $headers);

          return Redirect::to('/')
          ->withErrors("Reset password link is send to your Email address.");
          } else {
          //exit("Sucess Fail");
          return Redirect::to('/')
          ->withErrors("Email address not registered with us.");
          }
          //   return redirect('/forgotpassword'); */
        return view('forgotPassword');
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
