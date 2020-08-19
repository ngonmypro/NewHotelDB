<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Location extends Model
{
  protected $table = 'Location';
  protected $primaryKey = 'LocationID';
  public $timestamps = false;


}
