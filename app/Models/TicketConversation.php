<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketConversation extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public $timestamps = false;

    public function get_ticket(){
        return $this->belongsTo(Ticket::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'from_user')->select('id','name');
    }
}
