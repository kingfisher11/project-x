<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'trainer', 'attachment'];
    
    // relationship for table user and trainings
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getAttachmentUrlAttribute()
    {
        if ($this->attachment){
            return asset('storage/'.$this->attachment);

        } else {
            return  asset ('https://cdn.osxdaily.com/wp-content/uploads/2013/12/there-is-no-connected-camera-mac.jpg');
        }
        
    }
}
