<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class tbCountry extends Model
{
  protected $table = 'tbCountry';
  protected $primaryKey = 'CountryId';
  public $timestamps = false;

  public function SelectCountry()
  {
    $sql = DB::select(" SELECT  CountryId ,
							CountryDesc
					FROM    dbo.tbCountry
					WHERE   (
										tbCountry.OperationOffice = 1
										OR tbCountry.CountryId IN (
											'BKG1200800000013',
											'BKG1200900000012',
											'BKG1200800000014',
											'BKG1201000000008',
											'BKG1201100000004',
											'BKG1200800000007'
										)
										OR tbCountry.Supplier = 1
									)
									AND CountryDesc <> ''

            ORDER BY CountryDesc ASC
    ");
    return $sql;
  }
}
