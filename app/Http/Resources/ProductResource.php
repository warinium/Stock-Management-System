<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'barcode' => $this->barcode,
            'image' => $this->image,
            'status' => $this->status,
            'price' => $this->price,
            'purchase_price' => $this->purchase_price,
            'quantity' => $this->stock->quantity,
            'created_at' => $this->created_at,
            'image_url' =>  $this->image == "" ? Storage::url("no_image.jpg") : Storage::url($this->image),
            'image' =>  $this->image,
        ];
    }
}
