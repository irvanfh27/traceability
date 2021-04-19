<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowUpDocument extends Model
{
    protected $table = 'follow_up_document';

    protected $fillable = ['vendor_id','date_follow_up','yang_menghubungi','yang_di_hubungi','keterangan'];
}
