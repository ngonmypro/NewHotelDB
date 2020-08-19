<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class tbContacts extends Model
{
  protected $table = 'tbContacts';
  protected $primaryKey = 'PK_ID';
  public $timestamps = false;

}
