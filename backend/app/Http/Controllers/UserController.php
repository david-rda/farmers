<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IUser;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Auth;

class UserController extends Controller implements IUser
{
    public function Add_User(UserRequest $request) {
        $validated = $request->validated();

        if(Gate::allows("add-user", Auth::user())) {
            if($validated) {
                try {
                    User::create([
                        "name" => $validated["name"],
                        "email" => $validated["email"],
                        "password" => bcrypt($validated["password"]),
                        "role" => $validated["role"]
                    ]);
        
                    return response()->json([
                        "message" => "მომხმარებელი დაემატა."
                    ], 200);
                }catch(Exception $e) {
                    return response()->json([
                        "message" => "მომხმარებელი ვერ დაემატა."
                    ], 422);
                }
            }else {
                return response()->json([
                    "message" => "შეიყვანეთ სწორი ფორმატის მონაცემები!"
                ], 422);
            }
        }else {
            return response()->json([
                "message" => "თქვენ არ გაქვთ მომხმარებლის დამატების უფლება"
            ], 403);
        }
    }

    public function Edit_User(int $id, Request $request) {
        $this->validate($request, [
            "name" => "required|string",
            "email" => "required|email",
            "password" => "required_if:password,!=,null",
            "role" => "required"
        ]);

        if(Gate::allows("edit-user", Auth::user())) {
            try {
                $pass = User::whereId($id)->first()->password;

                User::whereId($id)->update([
                    "name" => $request->name,
                    "email" => $request->email,
                    "password" => ($request->password == null) ? $pass : bcrypt($request->password),
                    "role" => $request->role
                ]);
        
                return response()->json([
                    "message" => "მომხმარებელი დარედაქტირდა."
                ], 200);
            }catch(Exception $e) {
                return response()->json([
                    "message" => "მომხმარებელი ვერ დარედაქტირდა."
                ], 422);
            }
        }else {
            return response()->json([
                "message" => "თქვენ არ გაქვთ მომხმარებლის რედაქტირების უფლება"
            ], 403);
        }
    }

    /**
     * იუზერების წამოღება ბაზიდან
     * @method GET
     * @param null
     * @return json data
     */
    public function User_List() {
        if(Gate::allows("get-users", Auth::user())) {
            return User::all();
        }
    }

    /**
     * იუზერების წაშლის მეთოდი
     * @method DELETE
     * @param int id
     * @return json data
     */
    public function Delete_User(int $id) {
        if(Gate::allows("delete-user", Auth::user())) {
            $delete_user = User::whereId($id)->delete();

            if($delete_user) {
                return response()->json([
                    "message" => "მომხმარებელი წაიშალა"
                ], 200);
            }else {
                return response()->json([
                    "message" => "მომხმარებელი ვერ წაიშალა"
                ], 422);
            }
        }else {
            return response()->json([
                "message" => "თქვენ არ გაქვთ მომხმარებლის წაშლის უფლება"
            ], 403);
        }
    }

    /**
     * იუზერის წამოღება ბაზიდან
     * @method GET
     * @param int $id
     * @return json data
     */
    public function Get_User(int $id) {
        if(Gate::allows("get-users", Auth::user())) {
            return User::whereId($id)->first();
        }
    }
}
