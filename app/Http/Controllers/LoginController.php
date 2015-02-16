<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Input;
use Validator;
use Session;
use Hash;
use Auth;
use Redirect;
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
