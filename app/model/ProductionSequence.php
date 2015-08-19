<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ProductionSequence extends Model
{

    protected $fillable = ['seqId', 'title'];
    protected $table = 'production_sequences';

}
