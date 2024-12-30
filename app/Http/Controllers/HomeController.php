<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Validator;
use Input;
use App\Models\User;
class HomeController extends Controller
{
  
    
    public function secretLogin(){
      return view('auth.secret_login');
    }
  
      /** Do Login */
    public function secretLoginDo(Request $request)
    {
      //dd($request->all());
    // validate the info, create rules for the inputs
    $rules = [
        'email'    => 'required|email', // make sure the email is an actual email
        //'password' => 'required|min:3' // password can only be alphanumeric and has to be greater than 3 characters
    ];

    // run the validation rules on the inputs from the form
    $validator = Validator::make($request->all(), $rules);

    // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return redirect()->to('secret_login')
                ->withErrors($validator); 
        } else {
            // create our user data for the authentication
            $userdata = [
                'email'     => $request->email,
                'secret_token'  => $request->password,
            ];
            $user = User::where('email', $request->email)->where('secret_token', $request->password)->first();
            $errors = [];
          /*
            if(!$user){
                $errors = ['email' => 'The provided credentials do not match our records.'];
            }
            if ($user && !\Hash::check($request->password, $user->password)) {
                $errors = ['password' => 'The provided credentials do not match our records.'];
            }
            */
          	//$a = Auth::attempt(['email'=>$request->email, 'secret_token' => $request->password]);
          	if($user){
               Auth::login($user);
               return redirect()->route('dashboard');
            }else {
            	return redirect()->back()->withErrors(['errors' => 'token not matched']);
            }
        
          
			//dd(Auth::attempt($userdata));
            // attempt to do the login
            //if (Auth::attempt($userdata)) {
          /*
          	if($a){
                //$request->session()->regenerate();
                return redirect()->route('dashboard');
            } else {
                // validation not successful, send back to form
                return redirect()->route('our_secret_login')->withInput($request->input())->withErrors($errors);
            }
            */
        }
    }

}
