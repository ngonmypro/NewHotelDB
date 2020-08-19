<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class tbHotels extends Model
{
  protected $table = 'tbHotels';
  protected $primaryKey = 'HotelId';
  public $timestamps = false;

  public function SelectYear()
  {
    $sql = DB::select(" SELECT YEAR(ContractValid) AS YearValid FROM tbHotels
      WHERE YEAR(ContractValid) IS NOT NULL
        GROUP BY YEAR(ContractValid)
        ORDER BY YEAR(ContractValid) ASC
    ");
    return $sql;
  }

  public function SearchHotel($Hotel,$Contract,$HotelRating,$Year,$Country,$City,$Status,$Countrys,$Payment,$NameRating)
  {
    $where = "";
    $leftjoin = "";
    if ($Payment != '') {
      $leftjoin .= "LEFT JOIN dbo.HotelPaymentPolicy HP ON HP.HotelId  = H.HotelId
                              AND HP.PaymentType =(SELECT TOP 1 HP1.PaymentType FROM HotelPaymentPolicy Hp1
                             Where Hp1.HotelId =HP.HotelId)";

      $where .= " AND HP.PaymentType = '$Payment'";
    }

    if ($Hotel != '') {
      $where .= " AND H.Hotel LIKE '%$Hotel%'";
    }

    if ($Contract == 1) {
      $where .= " AND H.ContractValid IS NOT NULL";
    }

    if ($HotelRating != '' && $NameRating != 'ALL') {
      $where .= " AND (H.Star = '$NameRating' or H.CategoryId = '$HotelRating')";
    }

    if ($Year != '') {
      $where .= " AND Year(H.ContractValid) = '$Year'";
    }

    if ($Country != '') {
      $where .= " AND H.CountryId = '$Country'";
    }

    if ($City != '') {
      $where .= " AND H.CityId = '$City'";
    }

    if ($Status == '1') {
      $where .= " AND (H.IsActive IS NULL OR H.IsActive = 0)";
    }elseif ($Status == '2') {
      $where .= " AND H.IsActive = 1 AND H.IsActive IS NOT NULL";
    }

    if ($Countrys != '') {
      $where .= " AND H.CountryId = '$Countrys'";
    }

    $sql = DB::select("SELECT H.*
      , dbo.Date_Format(H.ContractValid, 'dd-mmm-yyyy') as ContractV
      FROM dbo.tbHotels AS H

      $leftjoin

      WHERE ( H.HotelId IS NOT NULL )
      $where
      GROUP BY H.[HotelId]
      ,H.[Hotel]
      ,H.[FormerName]
      ,H.[Street]
      ,H.[ZipCode]
      ,H.[City]
      ,H.[Country]
      ,H.[ContactName]
      ,H.[Fax]
      ,H.[Phone]
      ,H.[CountryPrefix]
      ,H.[CityPrefix]
      ,H.[Email]
      ,H.[Email2]
      ,H.[PeakSurcharge]
      ,H.[Star]
      ,H.[IsContract]
      ,H.[ContractValid]
      ,H.[Remark]
      ,H.[udate]
      ,H.[ABF]
      ,H.[Policy]
      ,H.[cdate]
      ,H.[GuideChrgDesc]
      ,H.[RmListReq]
      ,H.[FOCpolicy]
      ,H.[Childpolicy]
      ,H.[ddate]
      ,H.[IsActive]
      ,H.[OldId]
      ,H.[cby]
      ,H.[uby]
      ,H.[dby]
      ,H.[msrepl_tran_version]
      ,H.[AutoId]
      ,H.[SaleEmail]
      ,H.[WebSite]
      ,H.[HobicsPolicy]
      ,H.[CountryId]
      ,H.[CityId]
      ,H.[IsPreferred]
      ,H.[CategoryId]
      ,H.[Beach]
      ,H.[InboundRemark]
      ,H.[ContactPosition]
      ,H.[ContactDepartment]
      ,H.[OvernightCruise]
      ,H.[Boutique]
      ,H.[PreferredForTariff]
      ,H.[RERUser]
      ,H.[RERPassword]
      ,dbo.Date_Format(H.ContractValid, 'dd-mmm-yyyy')
    ");
    // dd($Hotel,$Contract,$HotelRating,$Year,$Country,$City,$Status,$Countrys,$Payment);
    // $sql = DB::select("SELECT  H.HotelId ,
		// 					H.Hotel ,
		// 					H.Street ,
		// 					H.ZipCode ,
		// 					H.City ,
		// 					H.Country ,
		// 					H.Fax ,
		// 					H.Phone ,
		// 					H.ContractValid ,
		// 					H.Remark ,
		// 					H.InboundRemark ,
		// 					H.CountryId ,
		// 					H.CityId ,
		// 					YEAR(H.ContractValid) AS YearValid ,
		// 					H.ContactName ,
		// 					H.Star ,
		// 					H.CountryPrefix ,
		// 					H.Email ,
		// 					H.SaleEmail ,
		// 					H.WebSite ,
		// 					H.CategoryId ,
		// 					H.IsContract ,
		// 					H.CityPrefix ,
		// 					H.ContactPosition ,
		// 					H.ContactDepartment ,
		// 					H.IsActive ,
		// 					H.Boutique ,
		// 					dbo.DFormat(H.ContractValid, 'dd-MMM-yyyy') AS ContractValid ,
		// 					CAST(H.Policy AS TEXT) AS Policy ,
		// 					C.Currency ,
		// 					L.Mobile as mobile,
		// 					H.OvernightCruise ,
		// 					L.VAT ,
		// 					L.ServiceCharge,
		// 					L.NAVCode,
    //                         H.PreferredForTariff ,
    //                         H.RERUser ,
    //                         H.RERPassword ,
		// 			(
    //       SELECT COUNT (*) FROM RERBarter
    //       WHERE RERBarter.HotelId = H.HotelId
    //     	) + (
    //       SELECT COUNT (*) FROM RERBarterGroupHotel
    //       WHERE RERBarterGroupHotel.HotelId = H.HotelId
    //     	) AS CntRerbarter
    //
		// 			FROM    dbo.tbHotels H
    //                        LEFT JOIN dbo.Currency C ON H.CountryId = C.CountryId
		// 				   LEFT JOIN dbo.Location L ON H.HotelId = L.HotelId
    //                        $leftjoin
    //               WHERE   ( H.HotelId IS NOT NULL )
    //               $where
    //               ORDER BY H.Country
		// 						, H.City
		// 						, H.Hotel
    //
    // ");
    // dd($sql);

    return $sql;
  }

  public function searchCountPages($Hotel,$Contract,$HotelRating,$Year,$Country,$City,$Status,$Countrys,$Payment,$NameRating){
    $pagesSize = 10;
    $HotelArray = $this->SearchHotel($Hotel,$Contract,$HotelRating,$Year,$Country,$City,$Status,$Countrys,$Payment,$NameRating);
    $count = COUNT($HotelArray);
    // dd($count);
    $result = ceil($count / $pagesSize);
    return $result;
  }

  public function SearchHotelENT($Hotel)
  {
    $where = "";
    if ($Hotel != '') {
      $where .= "WHERE Hotel LIKE '%$Hotel%'";
    }
    $sql = DB::select("SELECT * FROM tbHotels
      $where
    ");

    return $sql;
  }

  public function ViewHotel($HotelId)
  {
    $sql = DB::select("SELECT  H.HotelId ,
							H.Hotel ,
							H.Street ,
							H.ZipCode ,
							H.City ,
							H.Country ,
							H.Fax ,
							H.Phone ,
							H.ContractValid ,
							H.Remark ,
							H.InboundRemark ,
							H.CountryId ,
							H.CityId ,
							YEAR(H.ContractValid) AS YearValid ,
							H.ContactName ,
							H.Star ,
							H.CountryPrefix ,
							H.Email ,
							H.SaleEmail ,
							H.WebSite ,
							H.CategoryId ,
							H.IsContract ,
							H.CityPrefix ,
							H.ContactPosition ,
							H.ContactDepartment ,
							H.IsActive ,
							H.Boutique ,
							dbo.DFormat(H.ContractValid, 'dd-MMM-yyyy') AS ContractValid ,
							CAST(H.Policy AS TEXT) AS Policy ,
							C.Currency ,
							L.Mobile as mobile,
							H.OvernightCruise ,
							L.VAT ,
							L.ServiceCharge,
							L.NAVCode,
              H.PreferredForTariff ,
              H.RERUser ,
              H.RERPassword ,
              F.PreviousName1 ,
              F.PreviousName2 ,
              Com.Company ,
              FH.Starcat,
					(
          SELECT COUNT (*) FROM RERBarter
          WHERE RERBarter.HotelId = H.HotelId
        	) + (
          SELECT COUNT (*) FROM RERBarterGroupHotel
          WHERE RERBarterGroupHotel.HotelId = H.HotelId
        	) AS CntRerbarter

					FROM    dbo.tbHotels H
               LEFT JOIN dbo.Currency C ON H.CountryId = C.CountryId
						   LEFT JOIN dbo.Location L ON H.HotelId = L.HotelId
               LEFT JOIN dbo.FHotel AS F ON H.HotelId = F.HotelId
               LEFT JOIN dbo.Company AS Com ON L.CompanyID = Com.CompanyID
               LEFT JOIN dbo.FHHotel AS FH ON L.LocationID = FH.LocationID

                  WHERE    H.HotelId = '$HotelId'
                  ORDER BY H.Country
								, H.City
								, H.Hotel

    ");
    // dd($sql);
    // $sql = DB::select("SELECT tbHotels.*, FHotel.*, Company.Company FROM tbHotels
    //   LEFT JOIN FHotel ON tbHotels.HotelId = FHotel.HotelId
    //   Left JOIN Location ON tbHotels.HotelId = Location.HotelId
    //   LEFT JOIN Company ON Location.CompanyID = Company.CompanyID
    // WHERE tbHotels.HotelId = '$HotelId'");

    return $sql;
  }

  public function GetFullHotelName($HotelID)
  {
    $sql = DB::select("SELECT tbHotels.Hotel,
        FHotel.PreviousName1,
        dbo.DFormat(FHotel.ChangeNameUpdate1, 'dd-MMM-yyyy') as ChangeNameUpdate1,
        FHotel.PreviousName2,
        dbo.DFormat(FHotel.ChangeNameUpdate2, 'dd-MMM-yyyy') as ChangeNameUpdate2
    FROM tbHotels
    LEFT JOIN FHotel ON tbHotels.HotelId = FHotel.HotelId
    WHERE tbHotels.HotelId = '$HotelID'
    ");

    $Hotel = '';
    $PreviousName1 = '';
    $ChangeNameUpdate1 = '';
    $PreviousName2 = '';
    $ChangeNameUpdate2 = '';

    foreach($sql as $row){
			$Hotel = trim(preg_replace('/(\(.*)\)/','',$row->Hotel));
			$PreviousName1 = trim($row->PreviousName1);
			$ChangeNameUpdate1 = $row->ChangeNameUpdate1;
			$PreviousName2 = trim($row->PreviousName2);
			$ChangeNameUpdate2 = $row->ChangeNameUpdate2;
		}

		if(!empty($PreviousName1) OR !empty($PreviousName2)){
			if(empty($ChangeNameUpdate1) AND empty($ChangeNameUpdate2)){
				if(!empty($PreviousName1)){
					return $Hotel." (F.".$PreviousName1.")";
				}else{
					return $Hotel." (F.".$PreviousName2.")";
				}
			}

			if(!empty($ChangeNameUpdate1) AND !empty($ChangeNameUpdate2)){
				if(strtotime($ChangeNameUpdate1) < strtotime($ChangeNameUpdate2)){
					return $Hotel." (F.".$PreviousName1.")";
				}else{
					return $Hotel." (F.".$PreviousName2.")";
				}
			}

			if(!empty($ChangeNameUpdate1) AND empty($ChangeNameUpdate2)){
				return $Hotel." (F.".$PreviousName1.")";
			}

			if(empty($ChangeNameUpdate1) AND !empty($ChangeNameUpdate2)){
				return $Hotel." (F.".$PreviousName2.")";
			}

			return $Hotel." (F.".$PreviousName1.")";

		}else{
			return $Hotel;
		}
    // dd($sql);
  }
}
