<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RepoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        foreach ($this->resource as $item)
        {
            $item =(object)$item ;
            $res[]= [
                'id'=>    $item->id,
                'name'=>    $item->name,
                'url' => $item->url,
                'owner_url' => $item->owner['url'],
                'description'=> \Str::limit($item->description,100),
                'forks'=> $item->forks,
                'watchers'=> $item->watchers,
                'language'=> $item->language,
                'stargazers_count' => $item->stargazers_count,
                'created_at' => $item->created_at,
                'update_at' => $item->updated_at,

            ];
        }
        return $res;


    }
}
