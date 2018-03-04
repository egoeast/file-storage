<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;


class UserController extends Controller
{
    /**
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    protected function validator(array $data)
    {
        return \Validator::make($data, [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('blocking');
        $this->middleware('admin', ['except' => 'activation']);
        $this->middleware('activate', ['except' => 'activation']);

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();
        return view('auth.show-account', compact('users'));
    }

    /**
     * @param $id
     * @return $this
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('auth.edit-account')->with('user', $user);
    }

    /**
     * @param $id
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, UserRequest $request)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect('/users');
    }

    /**
     * @param $code
     * @return $this
     */
    public function activation($code)
    {
        $user = User::where([
            ['activation_code', '=', $code],
        ])->first();
        $user->is_active = 1;
        $user->save();
        return view('errors.error')->with('message', 'Your account is activated now.');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('auth.create-account');
    }

    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->all());
        $user->password = bcrypt($request['password']);
        $user->save();
        return redirect()->route('users.index');
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
    }
}
