<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model {
    protected $fillable = array(
        "title", "content", "owner_id"
    );
    
    public function owner() {
        return $this->belongsTo("App\User");
    }
}

?>