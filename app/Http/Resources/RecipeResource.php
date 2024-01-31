<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\IngredientResource;
use App\Http\Resources\StepResource;
use App\Http\Resources\CommentResource;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'nbOfLikes' => $this->totalLikes,
            'avrgRating' => $this->avrgRating,
            'imageUrl' => $this->imageUrl,
            'comment' => $this->comment,
            'comment' => $this->comment,
            'category' => $this->category->name,
            'preparationTime' => $this->preparationTime,
            'ingredients' => IngredientResource::collection($this->whenLoaded('ingredients')),
            'steps' => StepResource::collection($this->whenLoaded('steps')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'creator_id' => $this->user->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
