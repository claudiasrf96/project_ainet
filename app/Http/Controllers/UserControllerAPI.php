<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\User;
use Hash;
use Carbon\Carbon;

class UserControllerAPI extends Controller
{ //added
    public function index(Request $request)
    {
        return new UserResource($request->user());
        /*
        if ($request->has('page')) {
            return UserResource::collection(User::paginate(5));
        } else {
            return UserResource::collection(User::all());
        }
*/
        /*Caso não se pretenda fazer uso de Eloquent API Resources (https://laravel.com/docs/5.5/eloquent-resources), é possível implementar com esta abordagem:
        if ($request->has('page')) {
            return User::with('department')->paginate(5);;
        } else {
            return User::with('department')->get();;
        }*/
    }

    public function show($id)
    {
        return new UserResource(User::find($id));
    }

    public function store(Request $request)
    {
        $request->validate([
                'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
                'username' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
                'email' => 'required|email|unique:users,email',
                'password' => 'min:3'
            ]);
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->save();
        return response()->json(new UserResource($user), 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
                'name' => 'required|min:3',
                'username' => 'required|unique:users,username,'.$id
            ]);
        $user = User::findOrFail($id);
        $user->update($request->all());
        return new UserResource($user);
    } 

    public function updatePic(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $filename = basename($request->file('file')->store('public/profiles'));
        $user->photo_url = $filename;
        $user->update($request->all());
        return new UserResource($user);
    } 

    public function updateShift(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return new UserResource($user);
    }

    public function updatePass(Request $request, $id)
    {
        $request->validate([
            'password' => 'min:3'
        ]);
        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password); //not hashing
        return new UserResource($user);
    }

    public function createUser (Request $request)
    {
        $request->validate([
            'name' => 'required|min:3'.$id,
            'username' => 'required|unique:users,username,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'min:3'.$id
        ]);
        $user = new User();
        $user->fill($request->all());
        $user->password = "123";
        $user->password = Hash::make($user->password);
        $user->save();
        
        $user->update($request->all());
        return response()->json(new UserResource($user), 201);
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
    public function emailAvailable(Request $request)
    {
        $totalEmail = 1;
        if ($request->has('email') && $request->has('id')) {
            $totalEmail = DB::table('users')->where('email', '=', $request->email)->where('id', '<>', $request->id)->count();
        } else if ($request->has('email')) {
            $totalEmail = DB::table('users')->where('email', '=', $request->email)->count();
        }
        return response()->json($totalEmail == 0);
    }

    public function myProfile(Request $request)
    {
        return new UserResource($request->user());
    }
}
