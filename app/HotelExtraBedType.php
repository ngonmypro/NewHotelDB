<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class HotelExtraBedType extends Model
{
  protected $table = 'HotelExtraBedType';
  protected $primaryKey = 'ExtraBedTypeId';
  public $timestamps = false;

}
