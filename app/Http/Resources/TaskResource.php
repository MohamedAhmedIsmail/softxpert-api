<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'status' => $this->status,
            'due_date' => optional($this->due_date)->toDateString(),
            'assignee' => $this->whenLoaded('assignee', function () {
                return [
                    'id' => $this->assignee?->id,
                    'name' => $this->assignee?->name,
                    'email' => $this->assignee?->email,
                    'role' => $this->assignee?->role,
                ];
            }),
            'dependencies' => $this->whenLoaded('dependencies', function () 
            {
                return $this->dependencies->map(fn($t) => [
                    'id' => $t->id,
                    'title' => $t->title,
                    'status' => $t->status,
                    'due_date' => optional($t->due_date)->toDateString(),
                ])->values();
            }),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
