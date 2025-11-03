<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternetPayment extends Model
{
    public function order()
    {
        return $this->morphOne('App\Order', 'orderable');
	}
}
