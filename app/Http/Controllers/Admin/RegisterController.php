<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Mail\verificationMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('admin.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'verify_token' => Str::random(40),
        ]);

        if($user){
            Session::flash('verify_message','Your account created successfully! Please verify your email for active account');
            $userDetails = Admin::findOrFail($user->id);
            $this->sendVerificationEmail($userDetails);
        }
        return $user;
    }

    public function sendVerificationEmail($userDetails){
        Mail::to($userDetails->email)->send(new verificationMail($userDetails));
        /*
        Mail::send('email.sendVerificationMail', ['user'=>$userDetails], function ($mail) use($userDetails) {
                $mail->from('test.maab@gmail.com', 'Md Abu Ahsan Basir');

                $mail->to($userDetails->email,$userDetails->name);
                $mail->subject('Veryfy Your Account');
        });
        */
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return redirect(route('admin.login'));
    }

    public function verifyRegistrationEmail($email,$verify_token){
        $user = Admin::where(['email'=>$email,'verify_token'=>$verify_token])->first();

        if($user) {
            if($update = Admin::where(['email'=>$email,'verify_token'=>$verify_token])->update(['active'=>1,'verify_token'=>null])){
                Session::flash('verify_message','Your account activated successfully! Now you can login');
                return redirect(route('admin.login'));
            }
        }
    }
}
