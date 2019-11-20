<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Model;

class BaseModel extends Model
{
    protected $guarded=[];//不可以注入的字段
    //protected $fillable;//可以注入的数据字段
}