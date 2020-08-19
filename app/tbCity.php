<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class tbCity extends Model
{
  protected $table = 'tbCity';
  protected $primaryKey = 'CityId';
  public $timestamps = false;
  
  public function SelectCity()
  {
    $sql = DB::select(" SELECT 	CityId
								,City
						FROM    dbo.tbCity
						JOIN 	dbo.tbCountry ON dbo.tbCity.CountryId = dbo.tbCountry.CountryId
						WHERE   (
							tbCountry.OperationOffice = 1
							OR tbCountry.CountryId IN (
							  'BKG1200800000013',
							  'BKG1200900000012',
							  'BKG1200800000014',
							  'BKG1201000000008',
							  'BKG1201100000004'
							)
							OR tbCountry.Supplier = 1
						)
 								AND (tbCity.ddate IS NULL OR tbCity.ddate = '')

            ORDER BY City ASC
    ");
    return $sql;
  }

  public function ChangeCity($Country)
  {
    $sql = DB::select(" SELECT 	CityId
								,City
						FROM    dbo.tbCity
						JOIN 	dbo.tbCountry ON dbo.tbCity.CountryId = dbo.tbCountry.CountryId
						WHERE   --(
							tbCountry.OperationOffice = 1
						-- 	OR tbCountry.CountryId IN (
						-- 	  'BKG1200800000013',
						-- 	  'BKG1200900000012',
						-- 	  'BKG1200800000014',
						-- 	  'BKG1201000000008',
						-- 	  'BKG1201100000004'
						-- 	)
						-- 	OR tbCountry.Supplier = 1
						-- )
 								AND (tbCity.ddate IS NULL OR tbCity.ddate = '')
                AND tbCity.CountryId = '$Country'

            ORDER BY City ASC
    ");
    return $sql;
  }
}
