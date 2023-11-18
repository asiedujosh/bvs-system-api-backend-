<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordingTable extends Model
{
    use HasFactory;

    public function scopeFilter($query, array $filters){
        if($filters['keyword'] ?? false){
           $query->where('clientName','like','%' . request('keyword') . '%')
           ->orWhere('clientId','like','%' . request('keyword') . '%')
           ->orWhere('productId','like','%' . request('keyword').'%');
        }
      }
    // public function search($keyword) {
    //     return $this->where('clientName','like','%' . request('search') . '%')->get();
    // }

    //   public function search($keyword) {
    //     return RecordingTable::where(function ($query) use ($keyword) {
    //         $query->where('productId','like','%' . request('search').'%')
    //         ->orWhere('clientId','like','%' . request('search') . '%')
    //         ->orWhere('clientName','like','%' . request('search') . '%');
    //     })->get();
    // }
}
