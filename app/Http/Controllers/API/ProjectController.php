<?php

namespace App\Http\Controllers\API;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Constant\RespondMessage;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\RespondWithMeta;
use App\http\Requests\Project as RequestsProject;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $jwt = JWTAuth::parseToken()->getPayload();

        $param = request()->query();
        $perpage = $param['perpage'] ?? 10;
        $client_id = ($jwt->get('level') == 'client') ? $jwt->get('id') : null;
        $is_sort_name = $param['sort_name'] ?? null;

        $projects = Project::select(['id', 'client_id', 'name', 'description', 'embed_url', 'action_date']);
        if (!is_null($client_id)) {
            $projects = $projects->where('client_id', $client_id);
        }
        if (!is_null($is_sort_name)) {
            $projects = $projects->orderBy('name', $is_sort_name);
        } else {
            $projects = $projects->orderBy('created_at', 'desc');
        }
        $projects = $projects->paginate($perpage);
        return new RespondWithMeta($projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestsProject $request)
    {
        $data = $request->json()->all();

        $project = new Project($data);
        $project->save();

        return response()->json([
            'message' => RespondMessage::SUCCESS_CREATE,
            'data' => $project
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $project = Project::findOrFail($id);
        return response()->json([
            'message' => RespondMessage::SUCCESS_RETRIEVE,
            'data' => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestsProject $request, $id)
    {
        $data = $request->json()->all();

        $project = Project::findOrFail($id);
        $project->update($data);
        return response()->json([
            'message' => RespondMessage::SUCCESS_UPDATE,
            'data' => $project
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return response()->json([
            'message' => RespondMessage::SUCCESS_DELETE,
            'data' => $project
        ], Response::HTTP_OK);
    }
}
