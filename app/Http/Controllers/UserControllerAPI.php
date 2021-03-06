<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\User;
use Hash;

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

    public function getAllUsers()
    {
        return new UserResource(User::All());
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

    public function updateUser(Request $request, $id)
    {
        $request->validate([
                'name' => 'required|min:3',
                'username' => 'required|unique:users,username,'.$id
            ]);
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->username= $request->input('username');
        $user->email= $request->input('email');
        $user->save();

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
            'password' => 'required|min:3|max:8'.$id,
        ]);

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        if (Hash::check($request->password, $hashedPassword)) //pasword certa
        {   
            $user->save();  
            return new UserResource($user);
        }

    }

    public function createUser (Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'username' => 'required|unique:users,username,',
            'email' => 'required|email|unique:users,email,',
            'password' => 'min:3'
        ]);
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->save();
        
        $user->update($request->all());
        return response()->json(new UserResource($user), 201);
    }

    //Block
    public function blockUser($id)
    {
        $user = User::findOrFail($id);
        $user->blocked = "1";
        $user->save();
        return new UserResource($user);
    }

    //Unblock
    public function unblockUser($id)
    {
        $user = User::findOrFail($id);
        $user->blocked = "0";
        $user->save();
        return new UserResource($user);
    }

    //Delete
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->softDeletes();
        return new UserResource($user);
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
