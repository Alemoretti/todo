<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    use HasFactory;

    public function getCompletedAttribute($value)
    {
        return (bool) $value;
    }
    
    public function setCompletedAttribute($value)
    {
        $this->attributes['completed'] = (int) $value;
    }
}



