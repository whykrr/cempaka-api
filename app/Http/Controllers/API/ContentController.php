<?php

namespace App\Http\Controllers\API;

use App\Models\Content;
use Cocur\Slugify\Slugify;
use Illuminate\Http\Response;
use App\Constant\RespondMessage;
use App\Http\Controllers\Controller;
use App\Http\Resources\RespondWithMeta;
use App\Http\Requests\Content as RequestsContent;

class ContentController extends Controller
{
    /**
     * Get all contents.
     * 
     * @return \App\Http\Resources\RespondWithMeta
     */
    public function get()
    {
        // get param request
        $param = request()->query();
        $perpage = $param['perpage'] ?? 10;

        // get content with category
        $contents = Content::select(['id', 'category_id', 'title', 'slug', 'tags', 'is_active']);
        $contents = $contents->orderBy('created_at', 'desc')->paginate($perpage);

        return new RespondWithMeta($contents);
    }

    /**
     * Get content by id.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $content = Content::findOrFail($id);
        return response()->json([
            'message' => RespondMessage::SUCCESS_RETRIEVE,
            'data' => $content,
        ]);
    }

    /**
     * Store data to database.
     * 
     * @param \App\Http\Requests\Content $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestsContent $request)
    {
        // get data from json
        $data = $request->json()->all();

        // instanceof content
        $content = new Content($data);

        // save data
        $content->save();

        return response()->json([
            'message' => RespondMessage::SUCCESS_CREATE,
            'data' => $content
        ], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param int $id 
     * @param \App\Http\Requests\Content $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, RequestsContent $request)
    {
        // get data from json
        $payload = $request->json()->all();

        // get content with id
        $content = Content::findOrFail($id);

        //update data
        $content->update($payload);
        return response()->json([
            'message' => RespondMessage::SUCCESS_UPDATE,
            'data' => $content
        ], Response::HTTP_OK);
    }

    /**
     * Delete the specified resource from storage.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        // get content with id
        $content = Content::findOrFail($id);

        // delete content
        $content->delete();
        return response()->json([
            'message' => RespondMessage::SUCCESS_DELETE,
            'data' => $content
        ], Response::HTTP_OK);
    }
}
