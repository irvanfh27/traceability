<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryDocument extends Model
{
    protected $table = 'category_document';
    protected $fillable = ['name','category_for','number'];

    protected $appends = ['category_for_name'];

    public function getCategoryForNameAttribute()
    {
       if($this->category_for == 1){
           $name = "Supplier";
       }else{
           $name = "Stockpile";
       }
       return $name;
    }

    /**
     * Get the user that owns the CategoryDocument
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */


    public function document()
    {
        return $this->belongsTo(MasterDocument::class,'id','category_id');
    }
}
