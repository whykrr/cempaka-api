<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ContentCategory;
use App\Constant\RespondMessage;
use App\Http\Controllers\Controller;
use App\Models\Content;

class DisplayController extends Controller
{
    /**
     * Display a listing of the category content.
     *
     * @return \Illuminate\Http\Response
     */
    public function menubar()
    {
        $category = ContentCategory::select(['name', 'slug'])->where('is_active', 1)->orderBy('name', 'asc')->get();
        return response()->json([
            'message' => RespondMessage::SUCCESS_RETRIEVE,
            'data' => $category
        ], Response::HTTP_OK);
    }

    /**
     * Display a listing of the content per category.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function content_category($slug_category)
    {
        $category = ContentCategory::select('id')->where('slug', $slug_category)->first();
        if (empty($category)) {
            return response()->json([
                'message' => RespondMessage::ERROR_NOT_FOUND,
                'data' => []
            ], Response::HTTP_OK);
        }

        $content = Content::select(['id', 'title', 'slug', 'content', 'image', 'tags'])->where('category_id', $category->id)->get();
        $content->makeHidden(['category_content']);

        return response()->json([
            'message' => RespondMessage::SUCCESS_RETRIEVE,
            'data' => $content
        ], Response::HTTP_OK);
    }

    /**
     * Display the content with id.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function content($slug)
    {
        $content = Content::select(['id', 'title', 'slug', 'content', 'image', 'tags'])->where('slug', $slug)->first();
        if (empty($content)) {
            return response()->json([
                'message' => RespondMessage::ERROR_NOT_FOUND,
                'data' => []
            ], Response::HTTP_OK);
        }

        $content->makeHidden(['category_content']);

        return response()->json([
            'message' => RespondMessage::SUCCESS_RETRIEVE,
            'data' => $content
        ], Response::HTTP_OK);
    }
}
