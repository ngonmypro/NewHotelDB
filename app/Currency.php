<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Currency extends Model
{
  protected $table = 'Currency';
  protected $primaryKey = 'Id';
  public $timestamps = false;

}
