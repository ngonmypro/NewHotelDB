<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class HotelRateGroup extends Model
{
  protected $table = 'HotelRateGroup';
  protected $primaryKey = 'GroupId';
  public $timestamps = false;

}
