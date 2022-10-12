<?php

namespace App\Http\Controllers\API;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Constant\RespondMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client as RequestsClient;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RespondWithMeta;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthClientController extends Controller
{
    public $token = true;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api_client', ['except' => ['login', 'register']]);
    }

    // get all client
    public function get()
    {
        // get request
        $param = request()->query();
        $perpage = $param['perpage'] ?? 10;

        $clients = Client::select(['id', 'name', 'email'])->paginate($perpage);
        return new RespondWithMeta($clients);
    }

    // get detail client
    public function detail($id)
    {
        $client = Client::findOrFail($id);
        return response()->json([
            'message' => RespondMessage::SUCCESS_RETRIEVE,
            'data' => $client,
        ]);
    }

    // update client
    public function update(RequestsClient $request, $id)
    {
        // get data from json
        $payload = $request->json()->all();

        // instanceof content
        $client = Client::findOrFail($id);

        // save data
        $client->update($payload);
        return response()->json([
            'message' => RespondMessage::SUCCESS_UPDATE,
            'data' => $client,
        ]);
    }

    // delete client
    public function delete($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return response()->json([
            'message' => RespondMessage::SUCCESS_DELETE,
            'data' => $client,
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

            return response()->json(['error' => $validator->errors()], 401);
        }


        $client = new Client();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->password = bcrypt($request->password);
        $client->save();

        return response()->json([
            'message' => true,
            'data' => $client
        ], Response::HTTP_CREATED);
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
            if (!$token = auth('api_client')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
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
        return response()->json(auth('api_client')->user());
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
        return $this->respondWithToken(auth('api_client')->refresh());
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
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api_client')->factory()->getTTL() * 1440
        ]);
    }
}
