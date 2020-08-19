<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Employee extends Model
{
  protected $table = 'Employee';
  protected $primaryKey = 'EmployeeID';
  public $timestamps = false;

}
