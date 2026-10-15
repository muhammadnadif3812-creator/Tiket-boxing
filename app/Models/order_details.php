<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class order_details extends Model
{
     protected $table ='order_details';
    protected $guarded = ['id'];

    public function Orders()
    {
        return $this->HasMany(Orders::class);
    }

    public function event()
    {
        return $this->belongsTo(events::class, 'event_id');
    }
}
