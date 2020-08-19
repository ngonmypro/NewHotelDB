<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Cookie;
use DB;
use Session;
use Response;
use Mail;
use App\HotelCategory;
use App\tbHotels;
use App\tbCountry;
use App\tbCity;
use App\HotelPaymentPolicy;
use App\Company;
use App\Employee;
use App\Country;
use App\FHotel;
use App\HotelPreferredCategory;
use App\HotelRoomMaster;
use App\FHroom1;
use App\HotelRateMaster;
use App\HotelRateApplicable;
use App\HotelRateGroup;
use App\HotelRateBedroom;
use App\Location;
use App\HotelExtraBedType;
use App\tbContacts;
use App\TOMarketMaster;

class HotelDatabaseController extends controller{

    public function index($user,$ssid,$isid)
    {
      /*$session_ssid = Session::get('ssid');
      $session_isid = Session::get('isid');

      Cookie::make('session_ssid9999',$session_ssid,60*24*1);
      Cookie::make('session_isid9999',$session_isid,60*24*1);*/
      // dd($user,$ssid,$isid);
      $HotelCategory = new HotelCategory();
      $HotelCategoryArray = $HotelCategory->HotelCategorySelect();
      $tbHotels = new tbHotels();
      $tbHotelsArray = $tbHotels->SelectYear();
      $Country = new tbCountry();
      $CountryArray = $Country->SelectCountry();
      // $CityArray = DB::table('tbCity')->where('City','!=','')->orderby('City','asc')->get();
      $City = new tbCity();
      $CityArray = $City->SelectCity();

      // HotelCategory::orderby('CategoryName');
      // dd($CountryArray);
      return view('Hotel.SearchHotel')->with(compact('HotelCategoryArray','tbHotelsArray','CountryArray','CityArray','ssid','isid'));
    }

    public function ChkCountry(Request $req)
    {
      $City = new tbCity();
      $CityArray = $City->ChangeCity($req->Country);
// dd($CityArray);
      return json_encode($CityArray);
    }

    public function SearchHotel(Request $req)
    {
      $Countrys = $req->Country;
      $Hotel = $req->Hotel;
      $Contract = $req->Contract;
      $HotelRating = $req->HotelRating;
      $Year = $req->Year;
      $Country = $req->Country;
      $City = $req->City;
      $Status = $req->Status;
      $Payment = $req->Payment;
      $NameRating = $req->NameRating;
      // dd($Countrys);
      $tbHotels = new tbHotels();
      $HotelArray = $tbHotels->SearchHotel($Hotel,$Contract,$HotelRating,$Year,$Country,$City,$Status,$Countrys,$Payment,$NameRating);
      // dd($HotelArray);
      // $pagesSize = 10;
      // $count = COUNT($HotelArray);
      // $allPages = ceil($HotelArray / $pagesSize);
      $allPages = $tbHotels->searchCountPages($Hotel,$Contract,$HotelRating,$Year,$Country,$City,$Status,$Countrys,$Payment,$NameRating);
      // dd($allPages);
      $datashow = "";
        $datashow .= "<table class='table fixed_header1' align='center' cellspacing='0' border='1' cellpadding='2'   style='font-size:13px;'>";
        $datashow .= "<tr style='background-color:#209608; color:#fafafa;'>";
        $datashow .= "<th> Hotel </th>";
        $datashow .= "<th> StarCat </th>";
        $datashow .= "<th> Contact Valid </th>";
        $datashow .= "<th> Payment </th>";
        $datashow .= "<th> Street </th>";
        $datashow .= "<th> City </th>";
        $datashow .= "<th> Country  </th>";
        $datashow .= "<th> Contact </th>";
        $datashow .= "<th> Zipcode </th>";
        $datashow .= "<th> Phone </th>";
        $datashow .= "<th> Fax </th>";
        $datashow .= "<th> IsContact </th>";
        $datashow .= "</tr>";

      foreach ($HotelArray as $row) {
        $HotelPaymentPolicy = new HotelPaymentPolicy;
        $paymentTerm = $HotelPaymentPolicy->getHotelPaymentPolicy($row->HotelId,$Payment);
        $Phone = str_replace(",",", ",$row->Phone);
        $Fax = str_replace(",",", ",$row->Fax);
        $isContact = $row->IsContract == "1" ? "Yes":"No";
        $datashow .= "<tr>";
        $datashow .= "<td> $row->Hotel </td>";
        $datashow .= "<td> $row->Star </td>";
        $datashow .= "<td> $row->ContractV </td>";
        $datashow .= "<td> $paymentTerm </td>";
        $datashow .= "<td> $row->Street </td>";
        $datashow .= "<td> $row->City </td>";
        $datashow .= "<td> $row->Country </td>";
        $datashow .= "<td> $row->Hotel </td>";
        $datashow .= "<td> $row->ZipCode </td>";
        $datashow .= "<td> $Phone </td>";
        $datashow .= "<td> $Fax </td>";
        $datashow .= "<td> $isContact </td>";
        $datashow .= "</tr>";

      }
        $datashow .= "</table>";
      return $datashow;
    }

    public function SearchHotelENT(Request $req)
    {
      $Hotel = $req->Hotel;
        $tbHotels = new tbHotels();
        $tbHotelsArray = $tbHotels->SearchHotelENT($Hotel);
        $data_list = [];
        if (count($tbHotelsArray) > 0) {
          $result = [];
          foreach ($tbHotelsArray as $row) {
            $result = [ 'HotelId' => $row->HotelId ,
                'Hotel' => $row->Hotel ,
                'City' => $row->City
            ];
            array_push($data_list , $result);
          }
        }
      $result_array = [
      "data" => $data_list,
    ];
      return json_encode($result_array);
    }

    public function viewHotel($Hotelid,$ssid,$isid)
    {
      $tbHotels = new tbHotels();
      $tbHotelsArray = $tbHotels->ViewHotel($Hotelid);

      foreach ($tbHotelsArray as $row) {
        $website = $row->WebSite;
        $reservationemail = $row->Email;
        $saleemail = $row->SaleEmail;
        $InboundRemark = $row->InboundRemark;
      }

      $websiterows = 0;
      $rsvnrows = 0;
      $salerows = 0;
      $InboundRemarkrows = 0;
      if( strlen($website) < 40){ $websiterows = 1;}
        else if( strlen($website) > 40 && strlen($website) < 80){ $websiterows = 2;}
        else {$websiterows = 3;}

     if(strlen($reservationemail) < 40){ $rsvnrows = 1; }
        else if( strlen($reservationemail) > 40 && strlen($reservationemail) < 80){ $rsvnrows = 2; }
        else { $rsvnrows = 3; }

    if ($saleemail != '' || $saleemail || null) {
        if(strlen($saleemail) < 40){ $salerows = 1; }
          else if( strlen($saleemail) > 40 && strlen($saleemail) < 80){ $salerows = 2; }
          else { $salerows = 3; }
        }

      if( strlen($InboundRemark) < 150){
           $InboundRemarkrows = 1;
        }else if( strlen($InboundRemark) > 150 && strlen($InboundRemark) < 300){
            $InboundRemarkrows = 2;
        }else {
            $InboundRemarkrows = 3;
        }

      // dd($param);
      return view('Hotel.ViewHotel')->with(compact('tbHotelsArray','websiterows','rsvnrows','salerows','InboundRemarkrows','website','reservationemail','saleemail','ssid','isid','Hotelid'));
    }

    public function ViewEditHotel($Hotelid,$ssid,$isid)
    {
      $Hotel = DB::table('tbHotels')
                ->leftjoin('Location','Location.HotelId','=','tbHotels.HotelId')
                ->leftjoin('FHotel','FHotel.HotelId','=','tbHotels.HotelId')
                ->select('tbHotels.*','Location.*','FHotel.*')
                ->where('tbHotels.HotelId','=',$Hotelid)
                // ->groupby('tbHotels.HotelId')
                // ->groupby('Location.*')
                // ->groupby('FHotel.*')
                ->get();
      $Company = DB::table('Company')->where('Company','!=','')->orderby('Company','asc')->get();
      $City = DB::table('tbCity')->where('City','!=','')->orderby('City','asc')->get();
      $Country = DB::table('tbCountry')->where('CountryDesc','!=','')->orderby('CountryDesc','asc')->get();
      $HotelCategory = DB::table('HotelCategory')->where('CategoryName','!=','')->orderby('CategoryName','asc')->get();
      // dd($Hotel);

      return view('Hotel.EditHotel')->with(compact('Hotel','Company','City','Country','HotelCategory','ssid','isid','Hotelid'));
      // dd($Hotelid,$ssid,$isid);
    }

    public function addHotel($ssid,$isid)
    {
      $Company = DB::table('Company')->where('Company','!=','')->orderby('Company','asc')->get();
      $City = DB::table('tbCity')->where('City','!=','')->orderby('City','asc')->get();
      $Country = DB::table('tbCountry')->where('CountryDesc','!=','')->orderby('CountryDesc','asc')->get();
      $HotelCategory = DB::table('HotelCategory')->where('CategoryName','!=','')->orderby('CategoryName','asc')->get();
      // dd($Country);

      return view('Hotel.AddHotel')->with(compact('Company','City','Country','HotelCategory','ssid','isid'));
    }

    public function SaveNewHotel(Request $req)
    {
      $session_ssid = $req->session_ssid;
      $session_isid = $req->session_isid;

      $Employee = DB::table('Employee')
          ->select('Employee.FirstName','Employee.LastName','IS.ISID')
          ->join('IS','Employee.EmployeeID','=','IS.EmployeeID')
          ->where('IS.ISID','=',$session_isid)->get();

          if (COUNT($Employee) > 0) {
            $NameEmp = "";
            foreach ($Employee as $row) {
              $NameEmp = $row->FirstName.' '.$row->LastName;
              $ISIDEmp = $row->ISID;
            }
          }else {
            return "Not Employee";
            exit();
          }

      // dd($NameEmp,$ISIDEmp);
      $hotelname = !empty($req->hotelname) ? $req->hotelname:NULL;
      $previousname1 = !empty($req->previousname1) ? $req->previousname1:NULL;
      $changeon1_N = str_replace('/', '-', $req->changeon1 );
      $changeon1 = date("Y-m-d", strtotime($changeon1_N));
      $previousname2 = !empty($req->previousname2) ? $req->previousname2:NULL;
      $changeon2_N = str_replace('/', '-', $req->changeon2 );
      $changeon2 = date("Y-m-d", strtotime($changeon2_N));
      $group = !empty($req->group) ? $req->group:0;
      $Countryprefix = !empty($req->Countryprefix) ? $req->Countryprefix:NULL;
      $street = !empty($req->street) ? $req->street:NULL;
      $cityprefix = !empty($req->cityprefix) ? $req->cityprefix:NULL;
      $country = !empty($req->country) ? $req->country:NULL;
      $phone = !empty($req->phone) ? $req->phone:NULL;
      $city = !empty($req->city) ? $req->city:NULL;
      $mobile = !empty($req->mobile) ? $req->mobile:NULL;
      $zipcode = !empty($req->zipcode) ? $req->zipcode:NULL;
      $fax = !empty($req->fax) ? $req->fax:NULL;
      $contactperson = !empty($req->contactperson) ? $req->contactperson:NULL;
      $contactposition = !empty($req->contactposition) ? $req->contactposition:NULL;
      $contactdepartment = !empty($req->contactdepartment) ? $req->contactdepartment:NULL;
      $website = !empty($req->website) ? $req->website:NULL;
      $rsvn = !empty($req->rsvn) ? $req->rsvn:NULL;
      $sale = !empty($req->sale) ? $req->sale:NULL;
      $hotelcategory = !empty($req->hotelcategory) ? $req->hotelcategory:NULL;
      $contract = !empty($req->contract) ? $req->contract:NULL;
      $validon_N = str_replace('/', '-', $req->validon );
      $validon = date("Y-m-d", strtotime($validon_N));
      // dd($validon);
      $policy = !empty($req->policy) ? $req->policy:NULL;
      $remark = !empty($req->remark) ? $req->remark:NULL;
      $inboundremark = !empty($req->inboundremark) ? $req->inboundremark:NULL;
      $navcode = !empty($req->navcode) ? $req->navcode:NULL;
      $overnightcruise = !empty($req->overnightcruise) ? $req->overnightcruise:NULL;
      $rateincludevat = !empty($req->rateincludevat) ? $req->rateincludevat:NULL;
      $rateincludeservicecharge = !empty($req->rateincludeservicecharge) ? $req->rateincludeservicecharge:NULL;
      $boutiquehotel = !empty($req->boutiquehotel) ? $req->boutiquehotel:NULL;
      $countryid = !empty($req->countryid) ? $req->countryid:NULL;
      $cityid = !empty($req->cityid) ? $req->cityid:NULL;
      if ($req->star == '# Selece Hotel Category #') {
        $star = NULL;
      }else {
        $star = !empty($req->star) ? $req->star:NULL;
      }

      $DateTime = date('Y-m-d H:i:s.000');
      // dd($group);

      $Company = DB::table('tbHotels')->where('Hotel','=',$hotelname)->where('Country','=',$country)->where('City','=',$city)->get();
      // dd($Company);
      if (COUNT($Company) > 0) {
        return "Error : This hotel is duplicate.";
        exit();
      }else {
        $HotelID = $this->getNewHotelId();
        // return $HotelID;

// ADD tbHotels
        $tbHotels = new tbHotels();

        $tbHotels->HotelId = $HotelID;
        $tbHotels->Hotel = $hotelname;
        $tbHotels->FormerName = $hotelname;
        $tbHotels->Street = $street;

        $tbHotels->ZipCode = $zipcode;
        $tbHotels->City = $city;
        $tbHotels->Country = $country;
        $tbHotels->ContactName = $contactperson;

        $tbHotels->Fax = $fax;
        $tbHotels->Phone = $phone;
        $tbHotels->CountryPrefix = $Countryprefix;
        $tbHotels->CityPrefix = $cityprefix;

        $tbHotels->Email = $rsvn;
        $tbHotels->Star = $star;
        $tbHotels->SaleEmail = $sale;
        $tbHotels->WebSite = $website;

        $tbHotels->CountryId = $countryid;
        $tbHotels->CityId = $cityid;
        $tbHotels->CategoryId = $hotelcategory;
        $tbHotels->Remark = $remark;
        $tbHotels->InboundRemark = $inboundremark;

        $tbHotels->Policy = $policy;
        $tbHotels->IsContract = $contract;
        $tbHotels->ContractValid = $validon;
        $tbHotels->IsActive = '0';


        $tbHotels->ContactPosition = $contactposition;
        $tbHotels->ContactDepartment = $contactdepartment;

        $tbHotels->cdate = $DateTime;
        $tbHotels->cby = $NameEmp;
        $tbHotels->OvernightCruise = $overnightcruise;
        $tbHotels->Boutique = $boutiquehotel;

        $tbHotels->save();

        $Country2 = DB::table('Country')->select('CountryID','Country')->where('Country','=',$country)->get();
        foreach ($Country2 as $count2) {
          $CountryID2 = $count2->CountryID;
        }
        // dd($CountryID2);
        if ($HotelID) {
          if (strpos($hotelname,'Preferred') == false) {
            $hotelname_former = $hotelname;
            $hotelname = $tbHotels->GetFullHotelName($HotelID);
            // dd($hotelname);
            if (!empty($hotelname)) {
              $hotelname = $hotelname_former;
            }
          }

// Add Location
          $Location = new Location() ;

          $Location->CompanyID = $group;
          $Location->LocationTypeID = '3';
          $Location->SupplyTypeID = '5';
          //
          $Location->Company = $hotelname;
          $Location->Street = $street;
          $Location->City = $city;
          $Location->ZipCode = $zipcode;
          //
          $Location->Email = $rsvn;
          $Location->Phone = $phone;
          $Location->Fax = $fax;
          $Location->CountryID = $CountryID2;
          //
          $Location->Url1 = $website;
          $Location->HotelId = $HotelID;
          $Location->Mobile = $mobile;
          $Location->UserBy = $ISIDEmp;
          //
          $Location->Created = $DateTime;
          $Location->ServiceCharge = $rateincludeservicecharge;
          $Location->VAT = $rateincludevat;
          //
          $Location->NAVCode = $navcode;

          $Location->save();
          $LocationID = $Location->LocationID;

          if ($LocationID) {
// ADD FHotel
          $FHotel = new FHotel();

          $FHotel->LocationID = $LocationID;
          $FHotel->HCompany = $hotelname;
          $FHotel->HName = $hotelname;
          $FHotel->Street = $street;

          $FHotel->PfPCountry = $Countryprefix;
          $FHotel->PfFCountry = $Countryprefix;
          $FHotel->PfPCity = $cityprefix;
          $FHotel->PfFCity = $cityprefix;

          $FHotel->City = $city;
          $FHotel->Zipcode = $zipcode;
          $FHotel->Country = $CountryID2;
          $FHotel->Tel = $phone;

          $FHotel->Fax = $fax;
          $FHotel->Website1 = $website;
          $FHotel->Email = $rsvn;
          $FHotel->HotelId = $HotelID;

          $FHotel->PreviousName1 = $previousname1;
          $FHotel->PreviousName2 = $previousname2;
          $FHotel->ChangeNameUpdate1 = $changeon1;
          $FHotel->ChangeNameUpdate2 = $changeon2;
          $FHotel->save();
          $FHotelId = $FHotel->HId;
        }

          if(strpos($hotelname,'Preferred') == false){
            $tbHotelsEdt = tbHotels::find($HotelID);
            if ($tbHotelsEdt->ContractValid == $validon) {
              $tbHotelsEdt->ContractValid = $validon;
              $tbHotelsEdt->uby = $NameEmp;
              $tbHotelsEdt->udate = date('Y-m-d H:i:s');
              $tbHotelsEdt->save();
            }
          }
        }

        if(strpos($hotelname,'Preferred') == true){
            // dd($HotelRoomMaster);
            $HotelPreferredCategory = DB::table('HotelPreferredCategory')->orderby('CategoryName','asc')->get();
            foreach ($HotelPreferredCategory as $HotelPreferredCategory_row) {
              $PreferredCatId = $HotelPreferredCategory_row->CategoryNo;
  				    $PreferredCatName = $HotelPreferredCategory_row->CategoryName;

              $HotelRoomMaster = DB::table('HotelRoomMaster')->where('HotelRoomMasterName','=',$PreferredCatName)->get();

              if (COUNT($HotelRoomMaster) > 0){
                foreach ($HotelRoomMaster as $HotelRoomMaster_row) {
                  $HotelRoomMasterId = $HotelRoomMaster_row->HotelRoomMasterId;
                }

                $FHroom1 = DB::table('FHroom1')
                              ->where('HotelRoomMasterId','=',$HotelRoomMasterId)
                              ->where('LocationID','=',$LocationID)
                              ->where('Roomcat','=',$PreferredCatName)
                              ->get();

                    if (COUNT($FHroom1) > 0) {
                      foreach ($FHroom1 as $FHroom1_row) {
                        $FHRoomId = $FHroom1_row->ID;
                      }
                    }else {
                      $FHroom1  =	new FHroom1();
                      $FHroom1->Roomcat = $HotelRoomMasterId;
                      $FHroom1->LocationID = $LocationID;
                      $FHroom1->Roomcat = $PreferredCatName;
                      $FHroom1->save();
                      $FHRoomId = $FHroom1->ID;
                    }

                    $HotelRateMaster = new HotelRateMaster();
                    $RateMasterId = $this->getNewRateMasterId();

                    $HotelRateMaster->RateMasterId = $RateMasterId;
                    $HotelRateMaster->FHRoomId = $FHRoomId;
                    $HotelRateMaster->ExtraBedTypeId = '9DA7AA01-98D6-43FD-9AD4-0B53FA1F9999';
                    $HotelRateMaster->MaxExtraBedNumber = '0';
                    $HotelRateMaster->DateCreated = date('Y-m-d H:i:s');
                    $HotelRateMaster->UserCreated = $NameEmp;
                    $HotelRateMaster->save();

                    $HotelRateApplicable = new HotelRateApplicable();
                    $HotelRateApplicable->ApplicableType = 'Daily';
                    $HotelRateApplicable->MON = '0';
                    $HotelRateApplicable->TUE = '0';
                    $HotelRateApplicable->WED = '0';
                    $HotelRateApplicable->THU = '0';
                    $HotelRateApplicable->FRI = '0';
                    $HotelRateApplicable->SAT = '0';
                    $HotelRateApplicable->SUN = '0';
                    $HotelRateApplicable->NotApplicable = '';
                    $HotelRateApplicable->RateMasterId = $RateMasterId;
                    $HotelRateApplicable->DateCreated = date('Y-m-d H:i:s');
                    $HotelRateApplicable->UserCreated = $NameEmp;
                    $HotelRateApplicable->save();

                    $HotelRateGroup = new HotelRateGroup();
                    $HotelRateGroup->RateMasterId = $RateMasterId;
                    $HotelRateGroup->FIT_GIT = '0';
                    $HotelRateGroup->PaxGroup = 'Room(s)';
                    $HotelRateGroup->PaxFrom = '0';
                    $HotelRateGroup->PaxTo = '0';
                    $HotelRateGroup->DateCreated = date('Y-m-d H:i:s');
                    $HotelRateGroup->UserCreated = $NameEmp;
                    $HotelRateGroup->save();

                    $NewBedroomRateId= $this->getNewBedroomRateId();
                    $HotelRateBedroom = new HotelRateBedroom();
                    $HotelRateBedroom->BedroomRateId = $NewBedroomRateId;
                    $HotelRateBedroom->RateMasterId = $RateMasterId;
                    $HotelRateBedroom->BedroomType = 'Standard';
                    $HotelRateBedroom->PaxFrom = '0';
                    $HotelRateBedroom->PaxTo = '0';
                    $HotelRateBedroom->PriceUnit = 'Per person';
                    $HotelRateBedroom->DateCreated = date('Y-m-d H:i:s');
                    $HotelRateBedroom->UserCreated = $NameEmp;
                    $HotelRateBedroom->save();
              }else {

                $HotelRoomMasterId = $this->getNewHotelRoomMasterId();
                $HotelRoomMaster = new HotelRoomMaster();
                $HotelRoomMaster->HotelRoomMasterId = $HotelRoomMasterId;
                $HotelRoomMaster->HotelRoomMasterName = $PreferredCatName;
                $HotelRoomMaster->UserCreated = $NameEmp;
                $HotelRoomMaster->DateCreated = date('Y-m-d H:i:s');
                $HotelRoomMaster->save();

                $FHroom1 = DB::table('FHroom1')
                              ->where('HotelRoomMasterId','=',$HotelRoomMasterId)
                              ->where('LocationID','=',$LocationID)
                              ->where('Roomcat','=',$PreferredCatName)
                              ->get();

                    if (COUNT($FHroom1) > 0) {
                      foreach ($FHroom1 as $FHroom1_row) {
                        $FHRoomId = $FHroom1_row->ID;
                      }
                    }else {
                      $FHroom1  =	new FHroom1();
                      $FHroom1->Roomcat = $HotelRoomMasterId;
                      $FHroom1->LocationID = $LocationID;
                      $FHroom1->Roomcat = $PreferredCatName;
                      $FHroom1->save();
                      $FHRoomId = $FHroom1->ID;
                    }
                    $HotelRateMaster = new HotelRateMaster();
                    $RateMasterId = $this->getNewRateMasterId();

                    $HotelRateMaster->RateMasterId = $RateMasterId;
                    $HotelRateMaster->FHRoomId = $FHRoomId;
                    $HotelRateMaster->ExtraBedTypeId = '9DA7AA01-98D6-43FD-9AD4-0B53FA1F9999';
                    $HotelRateMaster->MaxExtraBedNumber = '0';
                    $HotelRateMaster->DateCreated = date('Y-m-d H:i:s');
                    $HotelRateMaster->UserCreated = $NameEmp;
                    $HotelRateMaster->save();

                    $HotelRateApplicable = new HotelRateApplicable();
                    $HotelRateApplicable->ApplicableType = 'Daily';
                    $HotelRateApplicable->MON = '0';
                    $HotelRateApplicable->TUE = '0';
                    $HotelRateApplicable->WED = '0';
                    $HotelRateApplicable->THU = '0';
                    $HotelRateApplicable->FRI = '0';
                    $HotelRateApplicable->SAT = '0';
                    $HotelRateApplicable->SUN = '0';
                    $HotelRateApplicable->NotApplicable = '';
                    $HotelRateApplicable->RateMasterId = $RateMasterId;
                    $HotelRateApplicable->DateCreated = date('Y-m-d H:i:s');
                    $HotelRateApplicable->UserCreated = $NameEmp;
                    $HotelRateApplicable->save();

                    $HotelRateGroup = new HotelRateGroup();
                    $HotelRateGroup->RateMasterId = $RateMasterId;
                    $HotelRateGroup->FIT_GIT = '0';
                    $HotelRateGroup->PaxGroup = 'Room(s)';
                    $HotelRateGroup->PaxFrom = '0';
                    $HotelRateGroup->PaxTo = '0';
                    $HotelRateGroup->DateCreated = date('Y-m-d H:i:s');
                    $HotelRateGroup->UserCreated = $NameEmp;
                    $HotelRateGroup->save();

                    $NewBedroomRateId= $this->getNewBedroomRateId();
                    $HotelRateBedroom = new HotelRateBedroom();
                    $HotelRateBedroom->BedroomRateId = $NewBedroomRateId;
                    $HotelRateBedroom->RateMasterId = $RateMasterId;
                    $HotelRateBedroom->BedroomType = 'Standard';
                    $HotelRateBedroom->PaxFrom = '0';
                    $HotelRateBedroom->PaxTo = '0';
                    $HotelRateBedroom->PriceUnit = 'Per person';
                    $HotelRateBedroom->DateCreated = date('Y-m-d H:i:s');
                    $HotelRateBedroom->UserCreated = $NameEmp;
                    $HotelRateBedroom->save();
              }
              // dd($HotelRoomMaster);
            }
        }

        $dataHotel = $LocationID.','.$HotelID.','.$FHotelId;
        return json_encode($dataHotel);
      }
    }

    public function SaveEditHotel(Request $req)
    {
      $session_ssid = $req->session_ssid;
      $session_isid = $req->session_isid;
      $hotelid = $req->hotelid;

      $Employee = DB::table('Employee')
          ->select('Employee.FirstName','Employee.LastName','IS.ISID')
          ->join('IS','Employee.EmployeeID','=','IS.EmployeeID')
          ->where('IS.ISID','=',$session_isid)->get();

          if (COUNT($Employee) > 0) {
            $NameEmp = "";
            foreach ($Employee as $row) {
              $NameEmp = $row->FirstName.' '.$row->LastName;
              $ISIDEmp = $row->ISID;
            }
          }else {
            return "Not Employee";
            exit();
          }

      $hotelname = !empty($req->hotelname) ? $req->hotelname:NULL;
      $previousname1 = !empty($req->previousname1) ? $req->previousname1:NULL;
      $changeon1_N = str_replace('/', '-', $req->changeon1 );
      $changeon1 = date("Y-m-d", strtotime($changeon1_N));
      $previousname2 = !empty($req->previousname2) ? $req->previousname2:NULL;
      $changeon2_N = str_replace('/', '-', $req->changeon2 );
      $changeon2 = date("Y-m-d", strtotime($changeon2_N));
      $group = !empty($req->group) ? $req->group:0;
      $Countryprefix = !empty($req->Countryprefix) ? $req->Countryprefix:NULL;
      $street = !empty($req->street) ? $req->street:NULL;
      $cityprefix = !empty($req->cityprefix) ? $req->cityprefix:NULL;
      $country = !empty($req->country) ? $req->country:NULL;
      $phone = !empty($req->phone) ? $req->phone:NULL;
      $city = !empty($req->city) ? $req->city:NULL;
      $mobile = !empty($req->mobile) ? $req->mobile:NULL;
      $zipcode = !empty($req->zipcode) ? $req->zipcode:NULL;
      $fax = !empty($req->fax) ? $req->fax:NULL;
      $contactperson = !empty($req->contactperson) ? $req->contactperson:NULL;
      $contactposition = !empty($req->contactposition) ? $req->contactposition:NULL;
      $contactdepartment = !empty($req->contactdepartment) ? $req->contactdepartment:NULL;
      $website = !empty($req->website) ? $req->website:NULL;
      $rsvn = !empty($req->rsvn) ? $req->rsvn:NULL;
      $sale = !empty($req->sale) ? $req->sale:NULL;
      $hotelcategory = !empty($req->hotelcategory) ? $req->hotelcategory:NULL;
      $contract = !empty($req->contract) ? $req->contract:NULL;
      $validon_N = str_replace('/', '-', $req->validon );
      $validon = date("Y-m-d", strtotime($validon_N));
      // dd($validon);
      $policy = !empty($req->policy) ? $req->policy:NULL;
      $remark = !empty($req->remark) ? $req->remark:NULL;
      $inboundremark = !empty($req->inboundremark) ? $req->inboundremark:NULL;
      $navcode = !empty($req->navcode) ? $req->navcode:NULL;
      $overnightcruise = !empty($req->overnightcruise) ? $req->overnightcruise:NULL;
      $rateincludevat = !empty($req->rateincludevat) ? $req->rateincludevat:NULL;
      $rateincludeservicecharge = !empty($req->rateincludeservicecharge) ? $req->rateincludeservicecharge:NULL;
      $boutiquehotel = !empty($req->boutiquehotel) ? $req->boutiquehotel:NULL;
      $countryid = !empty($req->countryid) ? $req->countryid:NULL;
      $cityid = !empty($req->cityid) ? $req->cityid:NULL;
      if ($req->star == '# Selece Hotel Category #') {
        $star = NULL;
      }else {
        $star = !empty($req->star) ? $req->star:NULL;
      }
      $active = $req->active;
      $PreferredForTariff = !empty($req->PreferredForTariff) ? $req->PreferredForTariff:NULL;
      $DateTime = date('Y-m-d H:i:s.000');


      // Edit tbHotels
              $tbHotels = tbHotels::find($hotelid);

              // $tbHotels->HotelId = $hotelid;
              $tbHotels->Hotel = $hotelname;
              $tbHotels->FormerName = $hotelname;
              $tbHotels->Street = $street;

              $tbHotels->ZipCode = $zipcode;
              $tbHotels->City = $city;
              $tbHotels->Country = $country;
              $tbHotels->ContactName = $contactperson;

              $tbHotels->Fax = $fax;
              $tbHotels->Phone = $phone;
              $tbHotels->CountryPrefix = $Countryprefix;
              $tbHotels->CityPrefix = $cityprefix;

              $tbHotels->Email = $rsvn;
              $tbHotels->Star = $star;
              $tbHotels->SaleEmail = $sale;
              $tbHotels->WebSite = $website;

              $tbHotels->CountryId = $countryid;
              $tbHotels->CityId = $cityid;
              $tbHotels->CategoryId = $hotelcategory;
              $tbHotels->Remark = $remark;
              $tbHotels->InboundRemark = $inboundremark;

              $tbHotels->Policy = $policy;
              $tbHotels->IsContract = $contract;
              $tbHotels->ContractValid = $validon;
              $tbHotels->IsActive = $active;

              $tbHotels->ContactPosition = $contactposition;
              $tbHotels->ContactDepartment = $contactdepartment;

              $tbHotels->udate = $DateTime;
              $tbHotels->uby = $NameEmp;
              $tbHotels->OvernightCruise = $overnightcruise;
              $tbHotels->Boutique = $boutiquehotel;
              $tbHotels->PreferredForTariff = $PreferredForTariff;

              $tbHotels->save();

              if(strpos($hotelname,'Preferred') == false){
				            //$HotelName = GetFullHotelName($HotelId);
				         $Hotel_n  = $req->hotelname;
				         if(!empty($previousname1) OR !empty($previousname2)){
					         if(empty($changeon1) AND empty($changeon2)){
						         if(!empty($previousname1)){
                       $hotelname =  $Hotel_n." (F.".$previousname1.")";
						         }else{
                       $hotelname =  $Hotel_n." (F.".$previousname2.")";
                     }
					         }

					         if(!empty($changeon1) AND !empty($changeon2)){
						         if(strtotime($changeon1) < strtotime($changeon2)){
                       $hotelname =  $Hotel_n." (F.".$previousname1.")";
                     }else{
                       $hotelname =  $Hotel_n." (F.".$previousname2.")";
                     }
                   }

					         if(!empty($changeon1) AND empty($changeon2)){
                     $hotelname =  $Hotel_n." (F.".$previousname1.")";
                   }

					         if(empty($changeon1) AND !empty($changeon2)){
                     $hotelname =  $Hotel_n." (F.".$previousname2.")";
                   }

					         $hotelname =  $Hotel_n." (F.".$previousname1.")";

				       }else{
					         $hotelname =  trim(preg_replace('/(\(.*)\)/','',$Hotel_n));
				       }
               // dd($hotelname);
			      }

            $Country2 = DB::table('Country')->select('CountryID','Country')->where('Country','=',$country)->get();
            foreach ($Country2 as $count2) {
              $CountryID2 = $count2->CountryID;
            }


            // Edit Location
                      $LocationArray = DB::table('Location')->where('HotelId','=',$hotelid)->get();
                      foreach ($LocationArray as $LocationArray_row) {
                        $LocationID = $LocationArray_row->LocationID;
                      }
                      $Location = Location::find($LocationID);
                      // dd($Location);
                      $Location->CompanyID = $group;
                      $Location->LocationTypeID = '3';
                      $Location->SupplyTypeID = '5';
                      //
                      $Location->Company = $hotelname;
                      $Location->Street = $street;
                      $Location->City = $city;
                      $Location->ZipCode = $zipcode;
                      //
                      $Location->Email = $rsvn;
                      $Location->Phone = $phone;
                      $Location->Fax = $fax;
                      $Location->CountryID = $CountryID2;
                      //
                      $Location->Url1 = $website;
                      $Location->HotelId = $hotelid;
                      $Location->Mobile = $mobile;
                      $Location->UserBy = $ISIDEmp;
                      //
                      $Location->Created = $DateTime;
                      $Location->ServiceCharge = $rateincludeservicecharge;
                      $Location->VAT = $rateincludevat;
                      //
                      $Location->NAVCode = $navcode;
                      $Location->inactive = $active;

                      $Location->save();

                      if ($LocationID) {
            // ADD FHotel
                      $FHotelArray = DB::table('FHotel')->where('LocationID','=',$LocationID)->where('HotelId','=',$hotelid)->get();
                      foreach ($FHotelArray as $FHotelArray_row) {
                        $FHotelId = $FHotelArray_row->HId;
                      }
                      $FHotel = FHotel::find($FHotelId);
                      // dd($FHotel);
                      $FHotel->LocationID = $LocationID;
                      $FHotel->HCompany = $hotelname;
                      $FHotel->HName = $hotelname;
                      $FHotel->Street = $street;

                      $FHotel->PfPCountry = $Countryprefix;
                      $FHotel->PfFCountry = $Countryprefix;
                      $FHotel->PfPCity = $cityprefix;
                      $FHotel->PfFCity = $cityprefix;

                      $FHotel->City = $city;
                      $FHotel->Zipcode = $zipcode;
                      $FHotel->Country = $CountryID2;
                      $FHotel->Tel = $phone;

                      $FHotel->Fax = $fax;
                      $FHotel->Website1 = $website;
                      $FHotel->Email = $rsvn;
                      $FHotel->HotelId = $hotelid;

                      $FHotel->PreviousName1 = $previousname1;
                      $FHotel->PreviousName2 = $previousname2;
                      $FHotel->ChangeNameUpdate1 = $changeon1;
                      $FHotel->ChangeNameUpdate2 = $changeon2;
                      $FHotel->save();
                      // $FHotelId = $FHotel->HId;
                    }

                    if(strpos($hotelname,'Preferred') == false){
                      $tbHotelsEdt = tbHotels::find($hotelid);
                      if ($tbHotelsEdt->ContractValid == $validon) {
                        $tbHotelsEdt->ContractValid = $validon;
                        $tbHotelsEdt->uby = $NameEmp;
                        $tbHotelsEdt->udate = date('Y-m-d H:i:s');
                        $tbHotelsEdt->save();
                      }
                    }
            $dataHotel = $LocationID.','.$hotelid.','.$FHotelId;
            return $dataHotel;
    }


// RoomCategory
    public function ViewRoomCategory($Hotelid,$ssid,$isid)
    {
      $HotelArray = DB::table('tbHotels')
                ->leftjoin('Location','Location.HotelId','=','tbHotels.HotelId')
                ->select('tbHotels.Hotel','Location.LocationID')
                ->where('tbHotels.HotelId','=',$Hotelid)
                ->get();

            foreach ($HotelArray as $HotelArray_row) {
              $Hotel = $HotelArray_row->Hotel;
              $LocationID = $HotelArray_row->LocationID;
            }

      $FHRoom1 = DB::table('FHRoom1')->where('LocationID','=',$LocationID)->get();
                 // dd($Hotel,$LocationID,$FHRoom1);
      return view('Hotel.RoomCategory')->with(compact('Hotel','LocationID','FHRoom1','ssid','isid','Hotelid'));
    }

    public function SearchRoomMaster(Request $req)
    {
      $Roomcat = $req->Roomcat;
      $HotelRoomMaster = DB::table('HotelRoomMaster')->where('HotelRoomMasterName','LIKE','%'.$Roomcat.'%')->orderby('HotelRoomMasterName','asc')->get();

      // dd($HotelRoomMaster);
      $data_list = [];
      if (count($HotelRoomMaster) > 0) {
        $result = [];
        foreach ($HotelRoomMaster as $HotelRoomMaster_row) {
          $result = [ 'HotelRoomMasterId' => $HotelRoomMaster_row->HotelRoomMasterId ,
              'HotelRoomMasterName' => $HotelRoomMaster_row->HotelRoomMasterName
          ];
          array_push($data_list , $result);
        }
      }
    $result_array = [
    "data" => $data_list,
  ];
  // dd($result_array);
      return json_encode($result_array);
    }

    public function SaveRoomcat(Request $req)
    {
      $session_ssid = $req->session_ssid;
      $session_isid = $req->session_isid;
      $hotelid = $req->hotelid;
      $locationid = $req->locationid;
      $NumRoomcat = $req->NumRoomcat;
      $RoomcatID = explode(",",$req->RoomcatID);
      $Roomcat = explode(",",$req->Roomcat);
      $HotelRoomMasterId = explode(",",$req->HotelRoomMasterId);

      for ($i=0; $i < $NumRoomcat; $i++) {
        if ($RoomcatID[$i] != '') {
          $FHroom1 = FHroom1::find($RoomcatID[$i]);
          // dd($FHroom1);
        }else {
          $FHroom1 = new FHroom1();

          $FHroom1->LocationID = $locationid;
          $FHroom1->Roomcat = $Roomcat[$i];
          $FHroom1->HotelRoomMasterId = $HotelRoomMasterId[$i];

          $FHroom1->save();
        }
      }
      return $session_ssid.' | '.$session_isid.' | '.$hotelid.' | '.$locationid.' | '.$NumRoomcat;
    }

    public function DelRoomcat(Request $req)
    {
      $FHroom1 = FHroom1::where('ID','=',$req->RoomcatID)->where('LocationID','=',$req->locationid)->where('Roomcat','=',$req->Roomcat)->delete();
      // dd($FHroom1);
      if (count($FHroom1) > 0) {
        return "Delete success.";
      }
    }

// AddNewRate
    public function AddNewRate($Hotelid,$ssid,$isid)
    {
      $HotelArray = DB::table('tbHotels')
                ->leftjoin('Location','Location.HotelId','=','tbHotels.HotelId')
                ->select('tbHotels.Hotel','Location.LocationID')

                ->where('tbHotels.HotelId','=',$Hotelid)
                ->get();

            foreach ($HotelArray as $HotelArray_row) {
              $Hotel = $HotelArray_row->Hotel;
              $LocationID = $HotelArray_row->LocationID;
            }

      $FHRoom1 = DB::table('FHRoom1')->where('LocationID','=',$LocationID)->get();
      $HotelExtraBedType = DB::table('HotelExtraBedType')->get();
      $Currency = DB::table('Currency')->where('Id','!=',NULL)->orderBy('Currency','ASC')->get();
      $tbContacts = DB::table('tbContacts')
                        ->select('ContactsId','CompanyDesc','Shortcut')
                        ->where('ContactsId','!=',NULL)
                        ->where('IsMainContact','=','1')
                        ->orderBy('CompanyDesc','ASC')
                        ->get();
      $TOMarketMaster = DB::table('TOMarketMaster')->where('TOMarketData','!=','South America')
                        ->where('TOMarketData','!=','Africa')
                        ->where('TOMarketData','!=','Asian')
                        ->where('TOMarketData','!=','Cruise')
                        ->where('TOMarketData','!=','Europe')
                        ->where('TOMarketData','!=','France')
                        ->where('TOMarketData','!=','Japan')
                        ->where('TOMarketData','!=','Korea')
                        ->where('TOMarketData','!=','Oceania')
                        ->where('TOMarketData','!=','Portugal')
                        ->where('TOMarketData','!=','Russia and CIS')
                        ->where('TOMarketData','!=','Scandinavia')
                        ->where('TOMarketData','!=','Switzerland')
                        ->get();
      $CountTOMarketMaster = COUNT($TOMarketMaster);
      $HotelChargeType = DB::table('HotelChargeType')->get();
                 // dd($TOMarketMaster , $CountTOMarketMaster);
      return view('Hotel.AddNewRate')->with(compact('Hotel','LocationID','FHRoom1','ssid','isid','Hotelid','HotelExtraBedType','Currency','tbContacts','TOMarketMaster','CountTOMarketMaster','HotelChargeType'));
    }

    public function SaveNewRate(Request $req)
    {
      $session_ssid = $req->session_ssid;
      $session_isid = $req->session_isid;
      $hotelid = $req->hotelid;
      $RoomCategory = $req->RoomCategory;
      $ExtraBedType = $req->ExtraBedType;
      $ExtraBedMax = $req->ExtraBedMax;
      $NumberofBedrooms = $req->NumberofBedrooms;
      $BedroomFrom = $req->BedroomFrom;
      $BedroomTo = $req->BedroomTo;
      $slctPriceUnit = $req->slctPriceUnit;
      $NumType = $req->NumType;
      $slctAddType = $req->slctAddType;
      $slctAddTypeFrom = $req->slctAddTypeFrom;
      $slctAddTypeTo = $req->slctAddTypeTo;
      $CountNumType = $req->CountNumType;
      $DefineStart = $req->DefineStart;
      $DefineEnd = $req->DefineEnd;
      $DefineRP = $req->DefineRP;
      $Define = $req->Define;
      $ApplicableType = $req->ApplicableType;
      $MON = $req->MON;
      $TUE = $req->TUE;
      $WED = $req->WED;
      $THU = $req->THU;
      $FRI = $req->FRI;
      $SAT = $req->SAT;
      $SUN = $req->SUN;
      $NotApplicable = $req->NotApplicable;
      $CountTOMarketMaster = $req->CountTOMarketMaster;
      $market = $req->market;
      $nummarket = $req->nummarket;
      $DefineSelect = $req->DefineSelect;
      $DefineSeriesTOSelect = $req->DefineSeriesTOSelect;
      $SeriesStart = $req->SeriesStart;
      $SeriesTo = $req->SeriesTo;
      $SeriesRP = $req->SeriesRP;
      $Currency = $req->Currency;

      dd($session_ssid,$session_isid,$hotelid,$RoomCategory,
      $ExtraBedType,$ExtraBedMax,$NumberofBedrooms,$BedroomFrom,
      $BedroomTo,$slctPriceUnit,$NumType,$slctAddType,$slctAddTypeFrom,
      $slctAddTypeTo,$CountNumType,$DefineStart,$DefineEnd,$DefineRP,
      $Define,$ApplicableType,$MON,$TUE,$WED,$THU,$FRI,$SAT,$SUN,
      $NotApplicable,$CountTOMarketMaster,$market,$nummarket,$DefineSelect,
      $DefineSeriesTOSelect,$SeriesStart,$SeriesTo,$SeriesRP,$Currency);
    }

    public function getNewHotelId()
    {
    $newHotelID = "";
    $getNewHotelId = DB::select(DB::raw("
          DECLARE @PrimaryKey varchar (16)
          EXEC dbo.uspGenAutoKey 'tbHotels',
              'HotelId',
              1,
              0,
              0,
              'BKG1',
              8,
              @PrimaryKey output
          SELECT @PrimaryKey as PrimaryKey"));
    if($getNewHotelId){
      $newHotelID = $getNewHotelId[0]->PrimaryKey;
    }
    return $newHotelID;
  }

  public function getNewRateMasterId()
  {
    $newRateMasterId = "";
    $getNewRateMasterId = DB::select(DB::raw("
            DECLARE @Id UNIQUEIDENTIFIER
    				SET @Id = NEWID()
    				SELECT  @Id AS  RateMasterId
    "));
    if($getNewRateMasterId){
      $newRateMasterId = $getNewRateMasterId[0]->RateMasterId;
    }
    return $newRateMasterId;
  }

  public function getNewBedroomRateId()
  {
    $newBedroomRateId = "";
    $getNewBedroomRateId = DB::select(DB::raw("
            DECLARE @Id UNIQUEIDENTIFIER
						SET @Id = NEWID()
						SELECT  @Id AS  BedroomRateId
    "));
    if($getNewBedroomRateId){
      $newBedroomRateId = $getNewBedroomRateId[0]->BedroomRateId;
    }
    return $newBedroomRateId;
  }

  public function getNewHotelRoomMasterId()
  {
    $newHotelRoomMasterId = "";
    $getNewHotelRoomMasterId = DB::select(DB::raw("
          DECLARE @Id UNIQUEIDENTIFIER
          SET @Id = NEWID()
          SELECT  @Id as MasterNo
    "));
    if($getNewHotelRoomMasterId){
      $newHotelRoomMasterId = $getNewHotelRoomMasterId[0]->MasterNo;
    }
    return $newHotelRoomMasterId;
  }


}
