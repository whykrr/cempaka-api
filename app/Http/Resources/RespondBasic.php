<?php

namespace App\Http\Resources;

use Illuminate\Http\Response;
use App\Constant\RespondMessage;
use Illuminate\Http\Resources\Json\JsonResource;

class RespondBasic extends JsonResource
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
            'message' => RespondMessage::SUCCESS_CREATE,
            'data' => $this->resource,
        ];
    }

    // add respond code
    public function withResponse($request, $response)
    {
        $response->setStatusCode(Response::HTTP_OK);
    }
}
