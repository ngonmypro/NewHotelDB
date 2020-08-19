@extends('layouts.master')
@section('pageTitle', 'Hotel Dateabase Center')
@section('content')
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{csrf_token()}}" />
  </head>
  <style media="screen">
  .fixed_header1{
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
  }

  .fixed_header1 tbody{
  display:block;
  width: 100%;
  overflow: auto;
  height: 255px;
  }

  .fixed_header1 thead tr {
   display: block;
  }

  .fixed_header1 thead {
  background: black;
  color:#fff;
  }

  .fixed_header1 th, .fixed_header1 td {
  padding: 5px;
  text-align: left;
  width: 400;
  }

  .fixed_header1{
  width: 100%;
  table-layout: fixed;
  border-collapse: collapse;
}

.fixed_header tbody{
display:block;
width: 100%;
overflow: auto;
height: 350px;
}

.fixed_header thead tr {
 display: block;
}

.fixed_header thead {
background: black;
color:#fff;
}

.fixed_header th, .fixed_header td {
padding: 5px;
text-align: left;
width: 300px;
}

.pointer {cursor: pointer;}
#table_search tr:hover {background-color: #ddd;}
  </style>
  <input type="hidden" id="session_ssid" name="session_ssid" value="<?php echo $ssid; ?>">
  <input type="hidden" id="session_isid" name="session_isid" value="<?php echo $isid; ?>">

  <body>
    <div class="col-sm-12" align="center">
      <h4><b>HOTEL DATABASE SYSTEM</b></h4><hr>
    </div>
    <div class="col-sm-12">
      <!-- <form id="for-export" action="{{ url('crm/searchExportExcel') }}" method="POST" > -->
      <div class="row">
        <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
        <div class="col-md-2" style="text-align:right;"><label style="font-size:13px"> Hotel : </label></div>
        <div class="col-md-5">
            <div class="form-group">
              <input type="text" class="form-control col-md-4" name="Hotel" id="Hotel" placeholder="Search Hotel">
            </div>
        </div>

        <div class="col-md-1">
          <button type="button" name="button" class="btn btn-default" OnClick="JavaScript:SearchHotelENT();"><i class="glyphicon glyphicon-search"></i></button>
        </div>

        <div class="col-md-1" style="text-align:right;"><label style="font-size:13px"> Contract : </label></div>
        <div class="col-md-1">
            <div class="form-group">
              <input type="checkbox" class="form-control" name="Contract" id="Contract" checked>
            </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-2" style="text-align:right;"><label style="font-size:13px"> Hotel Rating : </label></div>
        <div class="col-md-2">
            <div class="form-group">
              <select class="form-control selectTo" name="HotelRating" id="HotelRating">
                <option value="">ALL</option>
                @foreach($HotelCategoryArray as $HotelCategoryDB)
                <option value="{{$HotelCategoryDB->CategoryId}}">{{$HotelCategoryDB->CategoryName}}</option>
                @endforeach
              </select>
            </div>
        </div>

        <div class="col-md-1" style="text-align:right;"><label style="font-size:13px"> Payment : </label></div>
        <div class="col-md-2">
            <div class="form-group">
              <select class="form-control selectTo" name="Payment" id="Payment">
                <option value=""></option>
                <option value="Credit Facility">Credit Facility</option>
             	  <option value="Full Prepayment">Full Prepayment</option>
              	<option value="Other">Other</option>
              </select>
            </div>
        </div>

        <div class="col-md-1" style="text-align:right;"><label style="font-size:13px"> Year : </label></div>
        <div class="col-md-2">
            <div class="form-group">
              <select class="form-control selectTo" name="Year" id="Year">
                <option value="">ALL</option>
                @foreach($tbHotelsArray AS $tbHotelsDB)
                <option value="{{$tbHotelsDB->YearValid}}">{{$tbHotelsDB->YearValid}}</option>
                @endforeach
              </select>
            </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-2" style="text-align:right;"><label style="font-size:13px"> Country : </label></div>
        <div class="col-md-2">
            <div class="form-group">
              <select class="form-control selectTo" name="Country" id="Country" OnChange="javascript:ChkCountry();">
                <option value="">ALL</option>
                @foreach($CountryArray AS $CountryDB)
                <option value="{{$CountryDB->CountryId}}">{{$CountryDB->CountryDesc}}</option>
                @endforeach
              </select>
            </div>
        </div>

        <div class="col-md-1" style="text-align:right;"><label style="font-size:13px"> City : </label></div>
        <div class="col-md-2">
            <div class="form-group">
              <select class="form-control selectTo" name="City" id="City">
                <option value="">ALL</option>
                @foreach($CityArray AS $CityDB)
                <option value="{{$CityDB->CityId}}">{{$CityDB->City}}</option>
                @endforeach
              </select>
            </div>
        </div>

        <div class="col-md-1" style="text-align:right;"><label style="font-size:13px"> Status : </label></div>
        <div class="col-md-2">
            <div class="form-group">
              <select class="form-control selectTo" name="Status" id="Status">
                <option value="">ALL</option>
				        <option value="1">Active</option>
				        <option value="2">InActive</option>
              </select>
            </div>
        </div>
      </div>

      <div class="row">
      <div class="col-md-12" style="text-align:center;">
        <div class="form-group">
          <button type="button" class="btn btn-info" name="button" id="btnSearch" OnClick="javascripct:SearchHotelDB();">Search</button>
          <button type="button" class="btn btn-warning" name="button" OnClick="document.location.reload(true)">Clear</button>
        </div>
      </div>
    </div>

      <div class="row">
      <div class="col-md-12" style="text-align:center;">
        <button type="button" class="btn btn-primary" name="button" OnClick="javascript:addHotel();">New Hotel</button>
        <button type="button" class="btn btn-default" name="button" disabled>Transfer All new allotment to old system</button>
        <button type="submit" class="btn btn-success" name="button">Export to excel</button>

        <hr>
        </div>
      </div>
      <!-- </form> -->
    </div>

    <div class="col-md-12">
      <div class="" id="showdata"></div>
      <!-- <table id="table_id" class="display">
        <thead>
          <tr>
            <th>Column 1</th>
            <th>Column 2</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Row 1 Data 1</td>
            <td>Row 1 Data 2</td>
          </tr>
          <tr>
            <td>Row 2 Data 1</td>
            <td>Row 2 Data 2</td>
          </tr>
        </tbody>
      </table> -->
      <br>
    </div>
    <!-- <button type="button" name="button" onclick="ttest();">test</button> -->
  </body>
  @include('layouts.inc-scripts')
  <script type="text/javascript">
  $(document).ready(function () {
    $('.selectTo').select2();
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy'
    });
  });

  $(document).ready( function () {
    $('#table_id').DataTable();
  } );

  $('#Hotel').keyup(function (event) {
    if (event.keyCode == '13') {
      SearchHotelENT();
    }
  });

  function addHotel() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var session_ssid = $("#session_ssid").val();
    var session_isid = $("#session_isid").val();
    var url = '{{url('/addHotel')}}'+'/'+session_ssid+'/'+session_isid;
    open(url);
  }

  function SearchHotelENT() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var Hotel = $("#Hotel").val();
    var url = '{{url('/SearchHotelENT')}}';
        var request = $.post(url,
            {Hotel: Hotel,
            _token: CSRF_TOKEN,
          });
        request.done(function(response) {
          $("#modal_leaveVacation").modal();
          $("#table_search tbody tr").remove();
          $("#table_search").css('display','table');
          var item_Array = $.parseJSON(response);
          // alert(response)
          if(item_Array["data"].length > 0){
            itemArray = item_Array["data"];
            // alert(itemArray);
            for(index = 0; index < itemArray.length; index++){
            var itemData = itemArray[index];
            // alert(itemData)
            $("#table_search > tbody").append("<tr><td><a class='pointer' target='_blank' onclick='ViewHotel(this)' data-hotel-id='"+
                                              itemData['HotelId'] +"'>" +itemData['Hotel'] + "</a></td>"
            +"<td>" +itemData['City']+"</td></tr>");
            }
          }
        });
        request.fail(function(response) {
            alert("Search Error.");
        });
  }

  function SearchHotelDB() {
    // alert("TEST");
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var url = '{{url('/SearchHotel')}}';

        var Hotel = $("#Hotel").val();
          if(($('#Contract').is(':checked'))){
		        var Contract = '1' ;
	        }else{
		        var Contract = '0' ;
	        }
        var HotelRating = $("#HotelRating").val();
        var NameRating 	= 	$('#HotelRating option:selected').text();
        var Payment = $("#Payment").val();
        var Year = $("#Year").val();
        var Country = $("#Country").val();
        var City = $("#City").val();
        var Status = $("#Status").val();

        var request = $.ajax({
        url: url,
        method: "POST",
        data: {Country: Country
          ,Hotel: Hotel
          ,Contract: Contract
          ,HotelRating: HotelRating
          ,NameRating: NameRating
          ,Payment: Payment
          ,Year: Year
          ,Country: Country
          ,City: City
          ,Status: Status
          ,_token: CSRF_TOKEN},
        dataType: "text"
    });
      request.done(function(data) {
        $("#showdata").html(data);
        // alert(data);
      });
      request.fail(function(data) {
          alert("Search Error.");
      });
  }

  function ChkCountry() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var url = '{{url('/ChkCountry')}}';

        var Country = $("#Country").val();
        var request = $.ajax({
        url: url,
        method: "POST",
        data: {Country: Country, _token: CSRF_TOKEN},
        dataType: "json"
    });
    request.done(function(data) {
      $("#City").html("");
      var CityList = data;
      $(CityList).each(function() {
        var option = $("<option/>");
         option.val(this.CityId);
         option.html(this.City);
       $("#City").append(option);
      });
        $("#City").prepend("<option value='0'> ALL </option>").val(0);
    });
  }

  function ViewHotel(item) {
    var hotel_id = $(item).data('hotel-id');
    // alert(hotel_id)
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var session_ssid = $("#session_ssid").val();
    var session_isid = $("#session_isid").val();
    var url = '{{url('/viewHotel')}}'+'/'+hotel_id+'/'+session_ssid+'/'+session_isid;
      window.open(url,'_blank');
  }
  </script>

  <div id="modal_leaveVacation" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Hotel Data</h3>
          </div>
          <div class="modal-body">
              <div class="row" >
                <div class="form-group">
                  <!-- <div style='overflow-y:auto;' id="dataHotel"></div> -->
                  <table id="table_search" align='center'  class="table fixed_header" style="display:none;">
                    <thead>
                      <tr>
                        <th width="70%">Hotel</th>
                        <th width="30%">City</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>

          </div>
          <!-- <div class="modal-footer">
          </div> -->
        </div>
    </div>
  </div>
  @endsection
