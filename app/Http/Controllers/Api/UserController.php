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

    public function userUpdate(Request $request,$id){
      $data =  User::where('id',$id)->update([
            'name' => $request->name,
        ]);
        // $data = $request->all();
        // $user = User::find($id);
        // $user->name = $data['name'];
        // $user->password = Hash::make($data['password']);
        // $user->save();
        return response()->json($data);
    }

    public function user_destroy(Request $request, $id)
    {
        
     $header = $request->header('Authorization');
     if($header == ''){
            $message = "you have not any key!!!";
            return response()->json(['message'=>$message]);
     }else{
        if($header == "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6InJpciByYWtpYiIsImlhdCI6MTUxNjIzOTAyMn0.a_Bn-lySBFJ0snSMSqjTGTPBRAiPzsR6RlNeyBZjMKg"){
            $data = User::find($id);
            if($data){
                $data->delete();
                $message = "Data deleted successfully";
                return response()->json(['message'=>$message]);
            }else{
                $message = "not find id";
                return response()->json(['message'=>$message]);
            }
        }else{
                $message = "envalid access key";
                return response()->json(['message'=>$message]);
        }
     }
        
        
    }
}
