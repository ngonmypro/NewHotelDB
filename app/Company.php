<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Company extends Model
{
  protected $table = 'Company';
  protected $primaryKey = 'CompanyID';
  public $timestamps = false;


}
