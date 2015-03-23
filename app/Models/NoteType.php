<?php namespace Reflex\Models;

use Illuminate\Database\Eloquent\Model;

class NoteType extends Model {

    protected $table="note_types";

    protected $fillable = ['code','name', 'description','active'];


    //

}
