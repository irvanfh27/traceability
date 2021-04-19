<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterDocumentLog extends Model
{
    protected $table = 'master_document_log';
    protected $appends = ['categoryName','documentStatusName','statusName'];

    protected $fillable = [
        'category_id', 'vendor_id', 'file', 'department', 'expired_date','document_status','document_name','document_no',
        'document_date','document_pic','remarks','status','created_by'
    ];

    public function category()
    {
        return $this->belongsTo(CategoryDocument::class, 'category_id');
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }

    public function getDocumentStatusNameAttribute(){

        if($this->document_status == 1){
            $name = "Ada";
        }else{
            $name = "Tidak Ada";
        }
        return $name;
    }

    public function getStatusNameAttribute(){

        if($this->status == 1){
            $name = "Aktif";
        }else{
            $name = "Tidak Aktif";
        }
        return $name;
    }
}
