<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class HotelRateMaster extends Model
{
  protected $table = 'HotelRateMaster';
  protected $primaryKey = 'RateMasterId';
  public $timestamps = false;

}
