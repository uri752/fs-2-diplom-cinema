<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChPassRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request){
            
        if(Auth::check()){
            return redirect(route('user.private'));
        }
           
        $validateFields = $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        ]);

        if (\App\Models\User::where('email', $validateFields['email'])->exists()){
            return redirect(route('user.register'))->withErrors([
                'email' => 'Такой пользователь уже зарегистрирован!'
            ]);
        }

        $user = \App\Models\User::create($validateFields);

        if($user){
            Auth::login($user);
            return redirect('/admin/index');
        }        
    }


    public function updatePassword($email, ChPassRequest $request){
        $currentId = DB::table('users')->where('email', $email)->value('id'); 

        $user = \App\Models\User::find($currentId);

        if($user) {
            $user->password = $request->input('password');
            $user->save();
            Auth::logout();
            return redirect(route('user.login'))->with('success', 'Пароль успешно обновлён. Выполните повторный вход.');
        }

        return redirect(route('user.login'))->withErrors([
            'formError' => 'Произошла ошибка при изменении пароля!'
        ]);
    }

    public function registerGet() {
        if(Auth::check()|| Auth::viaRemember()) {
            return redirect(route('user.private'));
        }
        
        return view('admin.app_register');
    }

    public function adminRegister() {  
        return view('admin.app_register');
    }
}
