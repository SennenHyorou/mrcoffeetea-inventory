<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    private function formatResponse($message = "", $data = []) {
        return array(
            "data" => $data,
            "message" => $message
        );
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(
                $this->formatResponse("Invalid username or password"), 400
            );
        } else {
            if(!auth()->attempt($request->all())){
                return response()->json(
                    $this->formatResponse("Invalid username or password"), 401
                );
            }
            $accessToken = $user->createToken('authToken')->accessToken;
            return response()->json(
                $this->formatResponse(
                    "Login success",
                    array(
                        "user" => $user,
                        "token" => $accessToken
                    ),
                ), 200
            );
        }
    }

    public function me()
    {
        return response()->json(
            $this->formatResponse(
                "User data",
                array(
                    "user" => auth()->user()
                ),
            ), 200
        );
    }
}
