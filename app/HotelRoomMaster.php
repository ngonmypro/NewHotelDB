<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class HotelRoomMaster extends Model
{
  protected $table = 'HotelRoomMaster';
  protected $primaryKey = 'HotelRoomMasterId';
  public $timestamps = false;

}
