<?php

namespace App\Http\Resources;

use Illuminate\Http\Response;
use App\Constant\RespondMessage;
use Illuminate\Http\Resources\Json\JsonResource;

class RespondWithMeta extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'message' => RespondMessage::SUCCESS_RETRIEVE,
            'data' => $this->resource->items(),
            'meta' => [
                'total' => $this->resource->total(),
                'per_page' => $this->resource->perPage(),
                'current_page' => $this->resource->currentPage(),
                'last_page' => $this->resource->lastPage(),
            ],
        ];
    }

    // add respond code
    public function withResponse($request, $response)
    {
        $response->setStatusCode(Response::HTTP_OK);
    }
}
