<?php

namespace App\Http\Controllers\API;

use Cocur\Slugify\Slugify;
use Illuminate\Http\Response;
use App\Models\ContentCategory;
use App\Constant\RespondMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContentCategory as RequestsContentCategory;
use App\Http\Resources\RespondWithMeta;

class ContentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        // get query params
        $param = request()->query();
        (bool)$is_display = $params['is_display'] ?? false;
        $perpage = $param['perpage'] ?? 10;

        // custom select
        $content_categories = ContentCategory::select(['id', 'name', 'slug', 'description', 'is_active']);

        // check if query params is_display is not empty
        if (isset($param['is_display'])) {
            // replace true = 1 and false = 0
            $is_display = $param['is_display'] == 'true' ? 1 : 0;
            $content_categories = $content_categories->where('is_display', $is_display);
        }
        // check param search
        if (isset($param['search'])) {
            $content_categories = $content_categories->where(function ($query) use ($param) {
                $query->where('name', 'like', '%' . $param['search'] . '%')
                    ->orWhere('description', 'like', '%' . $param['search'] . '%');
            });
        }

        // get content categories
        $content_categories = $content_categories->paginate($perpage);

        return new RespondWithMeta($content_categories);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        // try {
        $content_category = ContentCategory::findOrFail($id);
        //     return new RespondWithMeta($content_category);
        // } catch (\Exception $e) {
        //     return $e;
        // }

        return response()->json([
            'message' => RespondMessage::SUCCESS_RETRIEVE,
            'data' => $content_category
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestsContentCategory $request)
    {
        // get request json
        $data = $request->json()->all();

        // create new content category
        $content_category = new ContentCategory();
        $content_category->name = $data['name'];

        // get slug
        $content_category->slug = Slugify::create()->slugify($data['name']);

        $content_category->description = $data['description'];
        $content_category->image = $data['image'];
        $content_category->icon = $data['icon'];

        // check component is object or not
        if (isset($data['component']) && is_array($data['component'])) {
            $content_category->component = json_encode($data['component']);
        } else {
            $content_category->component = null;
        }

        $content_category->is_active = $data['is_active'];
        $content_category->is_display = $data['is_display'];

        // save content category
        $content_category->save();

        // check object component is empty or not
        if (isset($data['component']) && is_array($data['component'])) {
            // get component
            $content_category->component = $data['component'];
        }

        // return response
        return response()->json([
            'message' => RespondMessage::SUCCESS_CREATE,
            'data' => $content_category
        ], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContentCategory  $contentCategory
     * @return \Illuminate\Http\Response
     */
    public function update($id, RequestsContentCategory $request, ContentCategory $contentCategory)
    {
        // get request json
        $data = $request->json()->all();

        $contentCategory = ContentCategory::findOrFail($id);

        // update content category
        $contentCategory->name = $data['name'];
        $contentCategory->name = $data['name'];
        $contentCategory->slug = Slugify::create()->slugify($data['name']);
        $contentCategory->description = $data['description'];
        $contentCategory->image = $data['image'];
        $contentCategory->icon = $data['icon'];

        // check component is object or not
        if (isset($data['component']) && is_array($data['component'])) {
            $contentCategory->component = json_encode($data['component']);
        } else {
            $contentCategory->component = null;
        }

        $contentCategory->is_active = $data['is_active'];
        $contentCategory->is_display = $data['is_display'];

        // save content category
        $contentCategory->save();

        // check object component is empty or not
        if (isset($data['component']) && is_array($data['component'])) {
            // get component
            $contentCategory->component = $data['component'];
        }

        // return response
        return response()->json([
            'message' => RespondMessage::SUCCESS_UPDATE,
            'data' => $contentCategory
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentCategory  $contentCategory
     * @return \Illuminate\Http\Response
     */
    public function delete($id, ContentCategory $contentCategory)
    {
        // get content category
        $contentCategory = ContentCategory::findOrFail($id);
        // delete content category
        $contentCategory->delete();
        // return response
        return response()->json([
            'message' => RespondMessage::SUCCESS_DELETE
        ], Response::HTTP_OK);
    }
}
