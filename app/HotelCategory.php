<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class HotelCategory extends Model
{
  protected $table = 'HotelCategory';
  protected $primaryKey = 'CategoryId';
  public $timestamps = false;
  
  public function HotelCategorySelect()
  {
    $sql = DB::select(" SELECT * FROM HotelCategory
        ORDER BY CategoryName ASC
    ");
    return $sql;
  }
}
