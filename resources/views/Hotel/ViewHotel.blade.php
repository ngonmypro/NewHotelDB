@extends('layouts.master')
@section('pageTitle', 'View Hotel')
@section('content')
  <head>
    <meta charset="utf-8">
  </head>
  <style media="screen">
  ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #dedbdb;
  }

  li {
    float: left;
  }

  li a {
    display: block;
    color: black;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
  }

  li a:hover {
    background-color: rgba(19, 19, 19, 0.67);
    color: white;
    cursor: pointer;
  }
  /* .pointer {cursor: pointer;} */


  body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
  color: #fff;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  color: #fff;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #258000;
  color: #fff;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #258000;
  color: #fff;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
  /* color: #fff; */
}
  </style>
  <body>
    <input type="hidden" id="session_ssid" name="session_ssid" value="<?php echo $ssid; ?>">
    <input type="hidden" id="session_isid" name="session_isid" value="<?php echo $isid; ?>">
    <input type="hidden" id="hotelid" name="hotelid" value="<?php echo $Hotelid; ?>">

    <ul align='center'>
      <li><a OnClick="javascript:EditHotel();">Edit Hotel</a></li>
      <li><a OnClick="javascript:RoomCategory();">Add Room Category</a></li>
      <li><a OnClick="javascript:NewRate();">New Rate</a></li>
      <li><a OnClick="javascript:T4();">Factsheet</a></li>
      <li><a OnClick="javascript:T5();">Special Terms</a></li>
      <li><a OnClick="javascript:T6();">Construction</a></li>
      <li><a OnClick="javascript:T7();">Promotion and Benefit</a></li>
      <li><a OnClick="javascript:T8();">Back To Search Hotel</a></li>
      <!-- <li><a>Hotel Rate (Old System)</a></li> -->
      <li><a OnClick="javascript:T9();">Hotel Rate(Old)</a></li>
    </ul>
    <!-- <div class="col-sm-12" align='right'>
      <a style="cursor: pointer;">Hotel Rate (Old System)</a>
    </div> -->

    <!-- <div class="row">
      <div class="col-md-1">1</div>
      <div class="col-md-1">2</div>
      <div class="col-md-1">3</div>
      <div class="col-md-1">4</div>
      <div class="col-md-1">5</div>
      <div class="col-md-1">6</div>
      <div class="col-md-1">7</div>
      <div class="col-md-1">8</div>
      <div class="col-md-1">9</div>
      <div class="col-md-1">10</div>
      <div class="col-md-1">11</div>
      <div class="col-md-1">12</div>
    </div> -->
    @foreach($tbHotelsArray AS $tbHotelsData)
    <form style="/*background-color: rgb(232, 242, 225)*/">
    <div class="col-sm-12">
      <div class="row">
        <div class="col-sm-9" align='left'>
          <h3><b>{{$tbHotelsData->Hotel}}</b></h3>
        </div>
        <div class="col-sm-3" align='right'><br>
          <input type="checkbox" name="" value=""> Show Inactivated Rates &nbsp;<button type="button" name="button">OK</button><br>
          <input type="checkbox" name="" value=""> Show All Active Rates&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="button">OK</button>
        </div>
      </div>
    </div>

    <div class="col-sm-12">
      <div class="row">
        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Previous Name: </label></div>
        <div class="col-md-2" style="text-align:left;">
          @if($tbHotelsData->PreviousName1 != '')
              {{$tbHotelsData->PreviousName1}}
          @else
              {{$tbHotelsData->PreviousName2}}
          @endif
        </div>
      </div>

      <div class="row">
        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Group : </label></div>
        <div class="col-md-2" style="text-align:left;">{{$tbHotelsData->Company}}</div>

        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px">Country Prefix : </label></div>
        <div class="col-md-2" style="text-align:left;">{{$tbHotelsData->CountryPrefix}}</div>
      </div>

      <div class="row">
        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Street : </label></div>
        <div class="col-md-2" style="text-align:left;">{{$tbHotelsData->Street}}</div>

        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> City Prefix : </label></div>
        <div class="col-md-2" style="text-align:left;">{{$tbHotelsData->CityPrefix}}</div>
      </div>

      <div class="row">
        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Country : </label></div>
        <div class="col-md-2" style="text-align:left;">{{$tbHotelsData->Country}}</div>

        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Phone : </label></div>
        <div class="col-md-2" style="text-align:left;">{{$tbHotelsData->Phone}}</div>
      </div>

      <div class="row">
        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> City : </label></div>
        <div class="col-md-2" style="text-align:left;">{{$tbHotelsData->City}}</div>

        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Mobile : </label></div>
        <div class="col-md-2" style="text-align:left;">{{$tbHotelsData->mobile}}</div>
      </div>

      <div class="row">
        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Zip Code : </label></div>
        <div class="col-md-2" style="text-align:left;">{{$tbHotelsData->ZipCode}}</div>

        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Fax : </label></div>
        <div class="col-md-2" style="text-align:left;">{{$tbHotelsData->Fax}}</div>
      </div>

      <div class="row">
        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Contact Person : </label></div>
        <div class="col-md-2" style="text-align:left;">{{$tbHotelsData->ContactName}}</div>

        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Contact Position : </label></div>
        <div class="col-md-2" style="text-align:left;">{{$tbHotelsData->ContactPosition}}</div>
      </div>

      <div class="row">
        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Contact Department : </label></div>
        <div class="col-md-2" style="text-align:left;">{{$tbHotelsData->ContactDepartment}}</div>

        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Website : </label></div>
        <div class="col-md-2" style="text-align:left;"><textarea cols="38" rows="<?=$websiterows?>" readonly="readonly"
    style="border:0px;background-color:#fff;overflow:hidden;padding:0;margin:0" ><?=str_replace(",", " ",$website) ?></textarea></div>
      </div>

      <div class="row">
        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> RSVN email : </label></div>
        <div class="col-md-2" style="text-align:left;"><textarea cols="38" rows="<?=$rsvnrows?>" readonly="readonly"
    style="border:0px;background-color:#fff;overflow:hidden;padding:0;margin:0" ><?=str_replace(",", " ",$reservationemail )  ?></textarea></div>

        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Sale email : </label></div>
        <div class="col-md-2" style="text-align:left;"><textarea cols="38" rows="<?=$salerows?>" readonly="readonly"
    style="border:0px;background-color:#fff;overflow:hidden;padding:0;margin:0" ><?=str_replace(",", " ",$saleemail )  ?></textarea></div>
      </div>

      <div class="row">
        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Official Star Rating : </label></div>
        <div class="col-md-2" style="text-align:left;">{{$tbHotelsData->Starcat}}</div>

        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> NAVCode : </label></div>
        <div class="col-md-2" style="text-align:left;">{{$tbHotelsData->NAVCode}}</div>
      </div>

      <div class="row">
        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Hotel Category : </label></div>
        <div class="col-md-2" style="text-align:left;">{{$tbHotelsData->Star}}</div>

        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Contract : </label></div>
        <div class="col-md-3" style="text-align:left;">
          @if($tbHotelsData->IsContract)
            <span style="color:rgb(0, 255, 25)" class="glyphicon glyphicon-ok" width="15"></span> Valid on : {{$tbHotelsData->ContractValid}}
          @else
            <span style="color:rgb(255, 0, 0)" class="glyphicon glyphicon-remove" width="15"></span>
          @endif
        </div>
      </div>

      <div class="row">
        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Policy : </label></div>
        <div class="col-md-2" style="text-align:left;">{{$tbHotelsData->Policy}}</div>

      </div>

      <div class="row">
        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Remark : </label></div>
        <div class="col-md-2" style="text-align:left;">{{$tbHotelsData->Remark}}</div>

      </div>

      <div class="row">
        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> InboundRemark : </label></div>
        <div class="col-md-7" style="text-align:left;"><textarea readonly="readonly" cols="100" rows="<?=$InboundRemarkrows?>"
    style="border:0px;background-color:#fff;padding:0;margin:0">{{$tbHotelsData->InboundRemark}}</textarea></div>

      </div>

      <div class="row">
        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Overnight Cruise : </label></div>
        <div class="col-md-7" style="text-align:left;">
          @if($tbHotelsData->OvernightCruise == 1)
            <span style="color:rgb(0, 255, 25)" class="glyphicon glyphicon-ok" width="15"></span>
          @else
            <span style="color:rgb(255, 0, 0)" class="glyphicon glyphicon-remove" width="15"></span>
          @endif
        </div>
      </div>


      <div class="row">
        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Boutique Hotel (shown on tariff) : </label></div>
        <div class="col-md-7" style="text-align:left;">
          @if($tbHotelsData->Boutique == 1)
            <span style="color:rgb(0, 255, 25)" class="glyphicon glyphicon-ok" width="15"></span> Yes
          @else
            <span style="color:rgb(255, 0, 0)" class="glyphicon glyphicon-remove" width="15"></span> No
          @endif
        </div>
      </div>

      <div class="row">
        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Active : </label></div>
        <div class="col-md-7" style="text-align:left;">
          @if($tbHotelsData->IsActive == 0)
            <span style="color:rgb(0, 255, 25)" class="glyphicon glyphicon-ok" width="15"></span> Yes
          @else
            <span style="color:rgb(255, 0, 0)" class="glyphicon glyphicon-remove" width="15"></span> No
          @endif
        </div>
      </div>

      <div class="row">
        <div class="col-md-3" style="text-align:right;"><label style="font-size:13px"> Preferred For Tariff : </label></div>
        <div class="col-md-7" style="text-align:left;">
          @if($tbHotelsData->PreferredForTariff == 0)
            <span style="color:rgb(255, 0, 0)" class="glyphicon glyphicon-remove" width="15"></span> No
          @else
            <span style="color:rgb(0, 255, 25)" class="glyphicon glyphicon-ok" width="15"></span> Yes
          @endif
        </div>
      </div>


    </div>
    @endforeach
    <p align='center'>---------------------------------------------------------------------------------------------</p>
    </form>
    <div class="tab" style="background-color:#0185b6;">
      <button id="defaultOpen" class="tablinks" onclick="openCity(event, 'HTRate')" >Hotel Rate</button>
      <button class="tablinks" onclick="openCity(event, 'Res')">Restaurants</button>
      <button class="tablinks" onclick="openCity(event, 'Bout')">Blackout</button>
    </div>

    <div id="HTRate" class="tabcontent">
      <h3>London</h3>
      <p>London is the capital city of England.</p>
    </div>

    <div id="Res" class="tabcontent">
      <h3>Paris</h3>
      <p>Paris is the capital of France.</p>
    </div>

    <div id="Bout" class="tabcontent">
      <h3>Tokyo</h3>
      <p>Tokyo is the capital of Japan.</p>
    </div>
<br>
  </body>
  @include('layouts.inc-scripts')
  @endsection

<script type="text/javascript">


function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// $(document).ready(function () {
document.getElementById("defaultOpen").click();
// });

// function openCity(evt, cityName) {
//   var i, tabcontent, tablinks;
//   tabcontent = document.getElementsByClassName("tabcontent");
//   for (i = 0; i < tabcontent.length; i++) {
//     tabcontent[i].style.display = "none";
//   }
//   tablinks = document.getElementsByClassName("tablinks");
//   for (i = 0; i < tablinks.length; i++) {
//     tablinks[i].className = tablinks[i].className.replace(" active", "");
//   }
//   document.getElementById(cityName).style.display = "block";
//   evt.currentTarget.className += " active";
// }

  function EditHotel() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var session_ssid = $("#session_ssid").val();
    var session_isid = $("#session_isid").val();
    var hotelid = $("#hotelid").val();
    // alert(hotelid+'/'+session_ssid+'/'+session_isid);
    var url = '{{url('/ViewEditHotel')}}'+'/'+hotelid+'/'+session_ssid+'/'+session_isid;
    window.location.assign(url);
  }
  function RoomCategory() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var session_ssid = $("#session_ssid").val();
    var session_isid = $("#session_isid").val();
    var hotelid = $("#hotelid").val();
    // alert(hotelid+'/'+session_ssid+'/'+session_isid);
    var url = '{{url('/ViewRoomCategory')}}'+'/'+hotelid+'/'+session_ssid+'/'+session_isid;
    window.location.assign(url);
  }
  function NewRate() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var session_ssid = $("#session_ssid").val();
    var session_isid = $("#session_isid").val();
    var hotelid = $("#hotelid").val();
    // alert(hotelid+'/'+session_ssid+'/'+session_isid);
    var url = '{{url('/AddNewRate')}}'+'/'+hotelid+'/'+session_ssid+'/'+session_isid;
    window.location.assign(url);
  }
  function T4() {
    alert("4");
  }
  function T5() {
    alert("5");
  }
  function T6() {
    alert("6");
  }
  function T7() {
    alert("7");
  }
  function T8() {
    alert("8");
  }
  function T9() {
    alert("9");
  }
</script>
