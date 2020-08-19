<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class HotelChargeType extends Model
{
  protected $table = 'HotelChargeType';
  protected $primaryKey = 'ChargeTypeId';
  public $timestamps = false;
}
