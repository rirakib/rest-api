<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function userData(){
            $user = User::all();
            return response()->json($user);
    }
    public function addUser(Request $request){

        $data = $request->all();
        $rules = [ 
            'name' => 'required',
            'email' => 'required | email | unique:users',
            'password' => 'required',
        ];

        $customMessages = [
            'name.required' => 'name is required',
            'email.required' => 'email is required',
            'email.email' => 'email is must be valid',
            'password.required' => 'password is required',
        ];

        $validator = Validator::make($data,$rules,$customMessages);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }else{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            $message = 'Data inserted successfully';
            return response()->json($message);
        }


    
            


        
    }


    public function multipeUserAdd(Request $request){
        $data = $request->all();
        $rules = [ 
            'name' => 'required',
            'email' => 'required | email | unique:users',
            'password' => 'required',
        ];

        $customMessages = [
            'name.required' => 'name is required',
            'email.required' => 'email is required',
            'email.email' => 'email is must be valid',
            'password.required' => 'password is required',
        ];

        
        
        foreach ($request->users as $key => $value) {
            
            $validator = Validator::make($value,$rules,$customMessages);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
            }else{
                $user = new User();
                $user->name = $value['name'];
                $user->email = $value['email'];
                $user->password = Hash::make($value['password']);
                $user->save();
                $message = 'Data inserted successfully';
            }
        }
        return response()->json($message);

        
        

        


    }
}
