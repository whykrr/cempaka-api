<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Constant\RespondMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\User as RequestsUser;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RespondWithMeta;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public $token = true;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    // get all user
    public function get()
    {
        // get request
        $param = request()->query();
        $perpage = $param['perpage'] ?? 10;

        $users = User::select(['id', 'name', 'email', 'level'])->where('level', '!=', 'superadmin')->paginate($perpage);
        return new RespondWithMeta($users);
    }

    // get detail user
    public function detail($id)
    {
        $client = User::findOrFail($id);
        return response()->json([
            'message' => RespondMessage::SUCCESS_RETRIEVE,
            'data' => $client,
        ]);
    }

    // update user
    public function update(RequestsUser $request, $id)
    {
        // get data from json
        $payload = $request->json()->all();

        // instanceof content
        $user = User::findOrFail($id);

        // save data
        $user->update($payload);
        return response()->json([
            'message' => RespondMessage::SUCCESS_UPDATE,
            'data' => $user,
        ]);
    }

    // delete user
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'message' => RespondMessage::SUCCESS_DELETE,
            'data' => $user,
        ]);
    }

    public function register(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]
        );

        if ($validator->fails()) {

            return response()->json(['message' => $validator->errors()], 401);
        }


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->level = $request->level;
        $user->password = bcrypt($request->password);
        $user->save();

        if ($this->token) {
            return $this->login($request);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ], Response::HTTP_OK);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        try {
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['message' => 'Login Fail, please check your cridential!'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Could not create token'], 500);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'message' => 'Login Success!',
            'access_token' => $token,
            'user' => [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 1440
        ]);
    }
}
