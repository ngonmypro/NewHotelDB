<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class FHotel extends Model
{
  protected $table = 'FHotel';
  protected $primaryKey = 'HId';
  public $timestamps = false;

}
