<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function index()
    {

        if(!empty(auth()->user())){
            
            return redirect()->to('dashboard');
        }
        echo"out";
        return view('login');
    }

    public function test()
    {   
        return view('registration');
    }


    public function process()
    {
        $request = \Config\Services::request();

        $email = $request->getPost('email');
        $password = $request->getPost('password');

        $logindata=[
            'email' => $email,
            'password' => $password,
        ];

        $validCreds = auth()->check($logindata);

        if (! $validCreds->isOK()) {
            return redirect()->back()->with('error', $validCreds->reason());
        }else{
            $id = $validCreds->extraInfo()->id;
            $users = auth()->getProvider();
            $user = $users->findById($id);

            if ($user->active == 1){        
                $loginAttempt = auth()->attempt($logindata);
            }else{
                return redirect()->to('package/select/'.$user->id);
            }   
        }

        if(! $loginAttempt->isOK()) {
            return redirect()->back()->with('error', $loginAttempt->reason());
        }
        
        if(! $loginAttempt->isOK()) {
            return redirect()->back()->with('error', $loginAttempt->reason());
        }
        
        return redirect()->to('dashboard');
    }
}