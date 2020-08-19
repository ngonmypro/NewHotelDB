<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class HotelPaymentPolicy extends Model
{
  protected $table = 'HotelPaymentPolicy';
  protected $primaryKey = 'PaymentId';
  public $timestamps = false;
  
  public function getHotelPaymentPolicy($HotelId,$Payment)
  {
    $where = "";
    if ($Payment != '') {
      $where .= " AND PaymentType = '$Payment'";
    }
    $sql = DB::select("SELECT PaymentType , DepType
        FROM  dbo.HotelPaymentPolicy
        WHERE HotelId = '$HotelId'
              $where
        ORDER BY  PaymentType
    ");
    $payments = "";
    foreach ($sql as $row) {
      $payments.= $row->PaymentType."($row->DepType)" .", ";
    }
    $paymentAll = rtrim($payments,", ");
    // dd($paymentAll);
    return $paymentAll;
  }
}
