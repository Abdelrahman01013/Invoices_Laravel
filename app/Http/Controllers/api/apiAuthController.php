<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Api\ApiTrait;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class apiAuthController extends Controller
{
    use ApiTrait;
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->apiResponse($validator->errors(), 400, 'تحقق من كتابه البريد الألكتروني والرقم السري');
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {

            if ($user->Status === 'مفعل') {

                if (Hash::check($request->password, $user->password)) {

                    $token = $user->createToken($user->name);
                    // return response($token, 200);

                    return response([
                        'token' => $token->plainTextToken,
                        'user' => $user
                    ]);
                } else {
                    return response(['error' => 'تاكد من الرقم السري']);
                }
            } else {
                return $this->apiResponse('Sorry', 401, 'الاميل غير مفعل ');
            }
        } else {
            return $this->apiResponse(null, 404, 'البريد الالكتروني غير موجود');
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required | between:3,100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required| between:5,100',
            'status' => 'required | in:مفعل,غيرمفعل',
            'rolse_name' => 'required|exists:roles,name'


        ]);

        if ($validator->fails()) {
            return $this->apiResponse($validator->errors(), 401,);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'Status' => $request->status,
            'roles_name' => $request->rolse_name

        ]);
        if ($user) {

            $token = $user->createToken($user->name);

            return response(['token' => $token->plainTextToken, 'user' => $user, 'message' => 'عمليه ناجحه']);
        }
    }

    public function profile()
    {
        return response(auth()->user());
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required | between:3,100',
            'email' => 'sometimes| required|email|unique:users,email',
            'password' => 'sometimes|required| between:5,100',
            'roles_name' => 'sometimes | required | exists:roles,name',
            'status' => 'sometimes|required|in:مفعل,غير مفعل',



        ]);

        if ($validator->fails()) {
            return $this->apiResponse($validator->errors(), 401,);
        }

        $user = $request->user();
        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($request->has('roles_name')) {
            $user->roles_name = $request->roles_name;
        }
        if ($request->has('status')) {
            $user->Status = $request->status;
        }
        if ($request->has('img')) {
            $user->img = $request->img;
        }

        $user->save();

        return response(['message' => 'تم التعديل', 'user' => $user]);
    }

    public function show_all()
    {
        $users = User::all();
        return response(['users' => $users, 'message' => 'حميع المستخدمين']);
    }
}
