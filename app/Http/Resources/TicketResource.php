<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'priority' => Ticket::PRIORITIES[$this->priority],
            'category' => Ticket::CATEGORIES[$this->category],
            'status' => Ticket::STATUSES[0],

        ];
    }
}
