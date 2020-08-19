<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class HotelRateBedroom extends Model
{
  protected $table = 'HotelRateBedroom';
  protected $primaryKey = 'BedroomRateId';
  public $timestamps = false;

}
