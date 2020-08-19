<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class HotelPreferredCategory extends Model
{
  protected $table = 'HotelPreferredCategory';
  protected $primaryKey = 'CategoryNo';
  public $timestamps = false;

}
