<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PageController extends Controller
{
    //fn to view the homepage
    public function homePage() {
        return view('homePage');
    }

    //fn to view the login page
    public function loginPage() {
        return view('auth.loginPage');
    }

    //fn to check the login credentials and redirect to blog page
    public function login(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials)) {
            return redirect()->intended(route('listblog')); 
        }
        return redirect(route('loginpage'))->with('errors',"Invalid Credentials");
    }

    //fn to view register page
    public function registerPage() {
        return view('auth.registerPage');
    }

    //fn to validate the user registration and redirect to login page on successful registration
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['password']=Hash::make($request->password);
        $user=User::create($data);
        if(!$user){
            return redirect(route('registerpage'))->with('errors',"Registration Failed");
        }
        return redirect(route('loginpage'));
    }

    //fn to perform logout
    public function logout() {
        Session()->flush();
        Auth::logout();
        return redirect(route('loginpage'));
    }
}
