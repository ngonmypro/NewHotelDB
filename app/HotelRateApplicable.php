<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class HotelRateApplicable extends Model
{
  protected $table = 'HotelRateApplicable';
  protected $primaryKey = 'ApplicableId';
  public $timestamps = false;

}
