<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = $request->user();
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'image' => $this->getFirstMediaUrl('images'),
            'content' => Str::of($this->content)->markdown(),
            'author' => new UserResource($this->whenLoaded('author')),
            'translations' => $this->translations,
            'tags' => implode(', ', $this->tags->pluck('name')->toArray()),

            'viewable' => $user->can('view', $this->resource),
            'editable' => $user->can('update', $this->resource),
            'deleteable' => $user->can('delete', $this->resource),
        ];
    }
}
