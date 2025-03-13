<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ];
            }),
            'cover_photo' => $this->whenLoaded('media', function () {
                return $this->media ? [
                    'id' => $this->media->id,
                    'path' => $this->media->path,
                    'url' => asset('storage/' . $this->media->path),
                ] : null;
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updates_at,
        ];
    }
}
