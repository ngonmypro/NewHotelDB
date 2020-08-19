@extends('layouts.master')
@section('pageTitle', 'Hotel Dateabase Center')
@section('content')
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{csrf_token()}}" />
</head>
<style media="screen">
.spanHotel{
/*cursor:pointer; */
background-color:#CCCCCC;
margin:0px;
position:absolute;
display:none;
width: 560px;
height: 250px;
overflow: auto;
padding:2px;
border: 1px solid black;
}

table{
border-collapse:collapse;
}
</style>
<input type="hidden" id="session_ssid" name="session_ssid" value="<?php echo $ssid; ?>">
<input type="hidden" id="session_isid" name="session_isid" value="<?php echo $isid; ?>">

<div class="tab-content">
  <div class="row">
    <div class="form-group">
      <div class="col-md-12" align='center'><h3><b>New Hotel</b></h3></div>
    </div>
  </div>
    <hr>

    <form>
        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Hotel Name :</label></div>
            <div class="col-md-8"><input type="text" class="form-control"  id="hotelname" name="hotelname"  value=""> </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Previous Name 1 :</label></div>
            <div class="col-md-4"><input type="text" class="form-control"  id="previousname1" name="previousname1"  value=""> </div>

            <div class="col-md-2" align='right'><label for=""> Change on :</label></div>
            <div class="col-md-2"><input type="text" class="form-control datepicker"  id="changeon1" name="changeon1"  value="" readonly> </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Previous Name 2 :</label></div>
            <div class="col-md-4"><input type="text" class="form-control"  id="previousname2" name="previousname2"  value=""> </div>

            <div class="col-md-2" align='right'><label for=""> Change on :</label></div>
            <div class="col-md-2"><input type="text" class="form-control datepicker"  id="changeon2" name="changeon2"  value="" readonly> </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Group :</label></div>
            <div class="col-md-4">
              <select class="form-control"   id="group" name="group"  >
                <option value=""> # Select Group # </option>
                @foreach($Company AS $CompanyData)
                <option value="{{$CompanyData->CompanyID}}">{{$CompanyData->Company}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-2" align='right'><label for="">	Country Prefix :</label></div>
            <div class="col-md-2"><input type="text" class="form-control"  id="Countryprefix" name="Countryprefix"  value=""></div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Street :</label></div>
            <div class="col-md-4"><textarea   id="street" name="street"   class="form-control" rows="3" cols="80"></textarea></div>

            <div class="col-md-2" align='right'><label for=""> City Prefix :</label></div>
            <div class="col-md-2"><input type="text" class="form-control"  id="cityprefix" name="cityprefix"  value=""> </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Country :</label></div>
            <div class="col-md-3">
              <select class="form-control" id="country" name="country" OnChange="javascript:ChkCountry();">
                <option value=""> # Select Country # </option>
                @foreach($Country AS $CountryData)
                <option value="{{$CountryData->CountryId}}">{{$CountryData->CountryDesc}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2" align='right'><label for=""> Phone :</label></div>
            <div class="col-md-3"><input type="text" class="form-control"  id="phone" name="phone"  value="" readonly></div>
            <div class="col-md-1">
              <button class="btn btn-info btn-xs" type="button" name="button" OnClick="javascript:AddPhone();"><span align="left" class="glyphicon glyphicon-plus"></span></button>
                <!-- <img src="../images/add.jpg" style="cursor: pointer;" width="20px;" alt="" onclick="javascript:AddPhone();"> -->
            </div>

          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> City :</label></div>
            <div class="col-md-3">
              <select class="form-control" id="city" name="city">
                <option value=""> # Select City # </option>
                @foreach($City AS $CityData)
                <option value="{{$CityData->CityId}}">{{$CityData->City}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-2" align='right'><label for=""> Mobile :</label></div>
            <div class="col-md-3"><input type="text" class="form-control"  id="mobile" name="mobile"  value="" readonly> </div>
            <div class="col-md-1">
              <button class="btn btn-info btn-xs" type="button" name="button" OnClick="javascript:AddMobile();"><span align="left" class="glyphicon glyphicon-plus"></span></button>
                <!-- <img src="../images/add.jpg" style="cursor: pointer;" OnClick="javascript:AddMobile();"  width="20px;" alt=""> -->
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Zip Code :</label></div>
            <div class="col-md-3"><input type="text" class="form-control"  id="zipcode" name="zipcode"  value=""> </div>

            <div class="col-md-2" align='right'><label for=""> Fax :</label></div>
            <div class="col-md-3"><input type="text" class="form-control"  id="fax" name="fax"  value="" readonly> </div>
            <div class="col-md-1">
              <button class="btn btn-info btn-xs" type="button" name="button" OnClick="javascript:AddFax();"><span align="left" class="glyphicon glyphicon-plus"></span></button>
                <!-- <img src="../images/add.jpg" style="cursor: pointer;" OnClick="javascript:AddFax();" width="20px;" alt=""> -->
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Contact Person :</label></div>
            <div class="col-md-3"><input type="text" class="form-control"  id="contactperson" name="contactperson"  value=""> </div>

            <div class="col-md-2" align='right'><label for=""> Contact Position :</label></div>
            <div class="col-md-3"><input type="text" class="form-control"  id="contactposition" name="contactposition"  value=""> </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Contact Department :</label></div>
            <div class="col-md-3"><input type="text" class="form-control"  id="contactdepartment" name="contactdepartment"  value=""> </div>

            <div class="col-md-2" align='right'><label for=""> Website :</label></div>
            <div class="col-md-3"><input type="text" class="form-control"  id="website" name="website"  value="" readonly> </div>
            <div class="col-md-1">
              <button class="btn btn-info btn-xs" type="button" name="button" OnClick="javascript:AddWebsite();"><span align="left" class="glyphicon glyphicon-plus"></span></button>
                <!-- <img src="../images/add.jpg" style="cursor: pointer;" OnClick="javascript:AddWebsite();" width="20px;" alt=""> -->
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> RSVN E-mail :</label></div>
            <div class="col-md-3">
              <textarea  id="rsvn" name="rsvn" width='80%' class="form-control" rows="2" cols="80" readonly></textarea>
            </div>
            <div class="col-md-1">
              <button class="btn btn-info btn-xs" type="button" name="button" OnClick="javascript:AddRSVN();"><span align="left" class="glyphicon glyphicon-plus"></span></button>
                <!-- <img src="../images/add.jpg" style="cursor: pointer;" OnClick="javascript:AddRSVN();" width="20px;" alt=""> -->
            </div>

            <div class="col-md-1" align='right'><label for=""> Sales E-mail :</label></div>
            <div class="col-md-3">
              <textarea   id="sale" name="sale"   class="form-control" rows="2" cols="80" readonly></textarea>
            </div>
            <div class="col-md-1">
              <button class="btn btn-info btn-xs" type="button" name="button" OnClick="javascript:AddSale();"><span align="left" class="glyphicon glyphicon-plus"></span></button>
                <!-- <img src="../images/add.jpg" style="cursor: pointer;"  width="20px;" alt=""> -->
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Hotel Category :</label></div>
            <div class="col-md-3">
              <select class="form-control"   id="hotelcategory" name="hotelcategory"  >
                <option value=""> # Selece Hotel Category # </option>
                @foreach($HotelCategory AS $HotelCategoryData)
                <option value="{{$HotelCategoryData->CategoryId}}">{{$HotelCategoryData->CategoryName}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-2" align='right'>
              <input type="checkbox" id="contract" name="contract" value=""> <b>Contract</b>
            </div>

            <div class="col-md-1" align='right'><label for=""> Valid on :</label></div>
            <div class="col-md-2">
              <input type="text" class="form-control datepicker" id="validon" name="validon" value="" readonly>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Policy :</label></div>
            <div class="col-md-8">
              <textarea id="policy" name="policy" class="form-control" rows="2" cols="80"></textarea>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Remark :</label></div>
            <div class="col-md-8">
              <textarea id="remark" name="remark" class="form-control" rows="2" cols="80"></textarea>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> InboundRemark :</label></div>
            <div class="col-md-8">
              <textarea id="inboundremark" name="inboundremark" class="form-control" rows="2" cols="80"></textarea>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> NAV Code :</label></div>
            <div class="col-md-2">
              <input type="text" class="form-control" id="navcode" name="navcode" value="">
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Overnight Cruise :</label></div>
            <div class="col-md-1">
              <input type="checkbox" id="overnightcruise" name="overnightcruise" value="">
            </div>

            <div class="col-md-7" align='right'>
              <label for=""> Rate include VAT : </label>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"  id="rateincludevat" name="rateincludevat"  value="">

              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for=""> Rate include service charge :</label>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"  id="rateincludeservicecharge" name="rateincludeservicecharge"  value="">
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-3" align='right'><label for=""> Boutique Hotel (Shown on tariff) :</label></div>
            <div class="col-md-1">
              <input type="checkbox"  id="boutiquehotel" name="boutiquehotel"  value="">
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-7"></div>
            <div class="col-md-3" align='right'>
              <button type="button" class="btn btn-success" name="button" OnClick="javascript:SaveNewHotel();">Save</button>
              <button type="button" class="btn btn-warning" name="button">Clear</button>
              <button type="button" class="btn btn-danger" name="button" OnClick="javascript:Cancel();">Cancel</button>
            </div>
          </div>
        </div>
    </form>
</div>
@include('layouts.inc-scripts')
<script type="text/javascript">
$(document).ready(function () {
  $('.selectTo').select2();
  $('.datepicker').datepicker({
        format: 'dd/mm/yyyy'
      });
});
  // Start Phone
  function AddPhone() {
    $("#modal_phone").modal();
  }

  function Cancel() {
    window.close();
  }

  function ChkCountry() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var url = '{{url('/ChkCountry')}}';
    var Country = $("#country").val();
    var request = $.ajax({
    url: url,
    method: "POST",
    data: {Country: Country, _token: CSRF_TOKEN},
    dataType: "json"
});
request.done(function(data) {
  $("#city").html("");
  var CityList = data;
  $(CityList).each(function() {
    var option = $("<option/>");
     option.val(this.CityId);
     option.html(this.City);
   $("#city").append(option);
  });
    $("#city").prepend("<option value='0'> Select City </option>").val(0);
});
  }

  $(document).ready(function() {
    $('#addPhone').click(function() {
      var a = parseInt($("#NumPhone2").val());
        var i = a + 1;

      $('#table_phone').append('<tr id="row'+i+'"><td width="95%"><input type="text" name="Phone[]" id="Phone'+i+'" value="" class="form-control" placeholder="Enter Phone"></td>'
      +'<td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_removePhone"><span  class="glyphicon glyphicon-remove"></span></button></td>'+
      +'</tr>');
      $("#NumPhone2").val(i);
    });

    $(document).on('click', '.btn_removePhone', function() {
      // var i = parseInt($("#NumPhone2").val()) - 1;
      var i = parseInt($("#NumPhone2").val());
      $("#NumPhone2").val(i);
      var button_id = $(this).attr("id");
      $("#row"+button_id+"").remove();
    });
  });

  function savephone() {
    var a = parseInt($("#NumPhone2").val());
    var sumphone = "";
    for (var i = 1; i <= a; i++) {
      var name = $("#Phone"+i).val();
      if (name != "" || name == 'undefined') {
        if (i == 1) {
          sumphone = name;
        } else {
          sumphone = sumphone+","+name;
        }
        sumphone = sumphone.replace(',undefined','');
      }
    }
    $('#modal_phone').modal('hide');
    $("#phone").val(sumphone);
  }
  // End Phone

  //Start Mobile
  function AddMobile() {
    $("#modal_mobile").modal();
  }

  $(document).ready(function() {
    $('#addMobile').click(function() {
      var a = parseInt($("#NumMobile2").val());
        var i = a + 1;

      $('#table_mobile').append('<tr id="row'+i+'"><td width="95%"><input type="text" name="Mobile[]" id="Mobile'+i+'" value="" class="form-control" placeholder="Enter Mobile"></td>'
      +'<td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_removeMobile"><span  class="glyphicon glyphicon-remove"></span></button></td>'+
      +'</tr>');
      $("#NumMobile2").val(i);
    });

    $(document).on('click', '.btn_removeMobile', function() {
      var i = parseInt($("#NumMobile2").val());
      $("#NumMobile2").val(i);
      var button_id = $(this).attr("id");
      $("#row"+button_id+"").remove();
    });
  });

  function savemobile() {
    var a = parseInt($("#NumMobile2").val());
    var summobile = "";
    for (var i = 1; i <= a; i++) {
      var name = $("#Mobile"+i).val();
      if (name != "" || name == 'undefined') {
        if (i == 1) {
          summobile = name;
        } else {
          summobile = summobile+","+name;
        }
        summobile = summobile.replace(',undefined','');
        // sumphone = sumphone.split(',undefined');
      }
    }
    $('#modal_mobile').modal('hide');
    $("#mobile").val(summobile);
  }
  // End Mobile

  //Start Fax
  function AddFax() {
    $("#modal_fax").modal();
  }

  $(document).ready(function() {
    $('#addFax').click(function() {
      var a = parseInt($("#NumFax2").val());
        var i = a + 1;

      $('#table_fax').append('<tr id="row'+i+'"><td width="95%"><input type="text" name="Fax[]" id="Fax'+i+'" value="" class="form-control" placeholder="Enter Fax"></td>'
      +'<td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_removeFax"><span  class="glyphicon glyphicon-remove"></span></button></td>'+
      +'</tr>');
      $("#NumFax2").val(i);
    });

    $(document).on('click', '.btn_removeFax', function() {
      var i = parseInt($("#NumFax2").val());
      $("#NumFax2").val(i);
      var button_id = $(this).attr("id");
      $("#row"+button_id+"").remove();
    });
  });

  function savefax() {
    var a = parseInt($("#NumFax2").val());
    var sumfax = "";
    for (var i = 1; i <= a; i++) {
      var name = $("#Fax"+i).val();
      if (name != "" || name == 'undefined') {
        if (i == 1) {
          sumfax = name;
        } else {
          sumfax = sumfax+","+name;
        }
        sumfax = sumfax.replace(',undefined','');
        // sumphone = sumphone.split(',undefined');
      }
    }
    $('#modal_fax').modal('hide');
    $("#fax").val(sumfax);
  }
  // End Fax

  //Start Website
  function AddWebsite() {
    $("#modal_website").modal();
  }

  $(document).ready(function() {
    $('#addWebsite').click(function() {
      var a = parseInt($("#NumWebsite2").val());
        var i = a + 1;

      $('#table_website').append('<tr id="row'+i+'"><td width="95%"><input type="text" name="Website[]" id="Website'+i+'" value="" class="form-control" placeholder="Enter Website"></td>'
      +'<td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_removeWebsite"><span  class="glyphicon glyphicon-remove"></span></button></td>'+
      +'</tr>');
      $("#NumWebsite2").val(i);
    });

    $(document).on('click', '.btn_removeWebsite', function() {
      var i = parseInt($("#NumWebsite2").val()) - 1;
      $("#NumWebsite2").val(i);
      var button_id = $(this).attr("id");
      $("#row"+button_id+"").remove();
    });
  });

  function savewebsite() {
    var a = parseInt($("#NumWebsite2").val());
    var sumwebsite = "";
    for (var i = 1; i <= a; i++) {
      var name = $("#Website"+i).val();
      if (name != "" || name == 'undefined') {
        if (i == 1) {
          sumwebsite = name;
        } else {
          sumwebsite = sumwebsite+","+name;
        }
        sumwebsite = sumwebsite.replace(',undefined','');
        // sumphone = sumphone.split(',undefined');
      }
    }
    $('#modal_website').modal('hide');
    $("#website").val(sumwebsite);
  }
  // End Website

  //Start RSVN E-mail
  function AddRSVN() {
    $("#modal_rsvn").modal();
  }

  $(document).ready(function() {
    $('#addRSVN').click(function() {
      var a = parseInt($("#NumRSVN2").val());
        var i = a + 1;

      $('#table_rsvn').append('<tr id="row'+i+'"><td width="95%"><input type="text" name="RSVN[]" id="RSVN'+i+'" value="" class="form-control" placeholder="Enter RSVN E-mail"></td>'
      +'<td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_removeRSVN"><span  class="glyphicon glyphicon-remove"></span></button></td>'+
      +'</tr>');
      $("#NumRSVN2").val(i);
    });

    $(document).on('click', '.btn_removeRSVN', function() {
      var i = parseInt($("#NumRSVN2").val());
      $("#NumRSVN2").val(i);
      var button_id = $(this).attr("id");
      $("#row"+button_id+"").remove();
    });
  });

  function saversvn() {
    var a = parseInt($("#NumRSVN2").val());
    var sumrsvn = "";
    for (var i = 1; i <= a; i++) {
      var name = $("#RSVN"+i).val();
      var reg = /\S+@\S+\.\S+/;
          if (name == undefined) {}else {
            if(!reg.test(name)){
              alert('Wrong email pattern.');
              exit();
            }
          }

      if (name != "" || name == 'undefined') {
        if (i == 1) {
          sumrsvn = name;
        } else {
          sumrsvn = sumrsvn+","+name;
        }
        sumrsvn = sumrsvn.replace(',undefined','');
        // sumphone = sumphone.split(',undefined');
      }
    }
    $('#modal_rsvn').modal('hide');
    $("#rsvn").val(sumrsvn);
  }
  // End RSVN E-mail

  //Start Sales E-mail
  function AddSale() {
    $("#modal_sale").modal();
  }

  $(document).ready(function() {
    $('#addSale').click(function() {
      var a = parseInt($("#NumSale2").val());
        var i = a + 1;

      $('#table_sale').append('<tr id="row'+i+'"><td width="95%"><input type="text" name="Sale[]" id="Sale'+i+'" value="" class="form-control" placeholder="Enter Sales E-mail"></td>'
      +'<td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_removeSale"><span  class="glyphicon glyphicon-remove"></span></button></td>'+
      +'</tr>');
      $("#NumSale2").val(i);
    });

    $(document).on('click', '.btn_removeSale', function() {
      var i = parseInt($("#NumSale2").val()) ;
      $("#NumSale2").val(i);
      var button_id = $(this).attr("id");
      $("#row"+button_id+"").remove();
    });
  });

  function savesale() {
    var a = parseInt($("#NumSale2").val());
    var sumsale = "";
    for (var i = 1; i <= a; i++) {
      var name = $("#Sale"+i).val();
      var reg = /\S+@\S+\.\S+/;

          if (name == undefined) {}else {
            if(!reg.test(name)){
              alert('Wrong email pattern.');
              exit();
            }
          }

        if (name != "" || name == 'undefined') {
          if (i == 1) {
            sumsale = name;
          } else {
            sumsale = sumsale+","+name;
          }
          sumsale = sumsale.replace(',undefined','');
        // sumphone = sumphone.split(',undefined');
        }
      // }
    }
    $('#modal_sale').modal('hide');
    $("#sale").val(sumsale);
  }
  // End Sales E-mail

  function SaveNewHotel() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var url = '{{url('/SaveNewHotel')}}';
    var session_ssid = $("#session_ssid").val();
    var session_isid = $("#session_isid").val();
    var hotelname = $("#hotelname").val();
    var previousname1 = $("#previousname1").val();
    var changeon1 = $("#changeon1").val();
    var previousname2 = $("#previousname2").val();
    var changeon2 = $("#changeon2").val();
    var group = $("#group").val();
    var Countryprefix = $("#Countryprefix").val();
    var street = $("#street").val();
    var cityprefix = $("#cityprefix").val();
    var countryid = $("#country").val();
    var country = $("#country option:selected").text();
    var phone = $("#phone").val();
    var cityid = $("#city").val();
    var city = $("#city option:selected").text();
    var mobile = $("#mobile").val();
    var zipcode = $("#zipcode").val();
    var fax = $("#fax").val();
    var contactperson = $("#contactperson").val();
    var contactposition = $("#contactposition").val();
    var contactdepartment = $("#contactdepartment").val();
    var website = $("#website").val();
    var rsvn = $("#rsvn").val();
    var sale = $("#sale").val();
    var hotelcategory = $("#hotelcategory").val();
    var star = $("#hotelcategory option:selected").text();
    if ($("#contract").is(':checked')) {
      var contract = 1;
    }else {
      var contract = 0;
    }
    var validon = $("#validon").val();
    var policy = $("#policy").val();
    var remark = $("#remark").val();
    var inboundremark = $("#inboundremark").val();
    var navcode = $("#navcode").val();
    if ($("#overnightcruise").is(':checked')) {
      var overnightcruise = 1;
    }else {
      var overnightcruise = 0;
    }

    if ($("#rateincludevat").is(':checked')) {
      var rateincludevat = 1;
    }else {
      var rateincludevat = 0;
    }

    if ($("#rateincludeservicecharge").is(':checked')) {
      var rateincludeservicecharge = 1;
    }else {
      var rateincludeservicecharge = 0;
    }

    if ($("#boutiquehotel").is(':checked')) {
      var boutiquehotel = 'true';
    }else {
      var boutiquehotel = 'false';
    }

    if (hotelname == '') {
      alert('Please Insert Hotel Name');
      exit();
    }
    if (country == '') {
      alert('Please Select Country');
      exit();
    }
    if (contract == 1 && validon == '') {
      alert('Please Insert Valid on');
      exit();
    }

    var request = $.ajax({
        url: url,
        method: "POST",
        data: {hotelname: hotelname,
              previousname1: previousname1,
              changeon1: changeon1,
              previousname2: previousname2,
              changeon2: changeon2,
              group: group,
              Countryprefix: Countryprefix,
              street: street,
              cityprefix: cityprefix,
              country: country,
              phone: phone,
              city: city,
              mobile: mobile,
              zipcode: zipcode,
              fax: fax,
              contactperson: contactperson,
              contactposition: contactposition,
              contactdepartment: contactdepartment,
              website: website,
              rsvn: rsvn,
              sale: sale,
              hotelcategory: hotelcategory,
              contract: contract,
              validon: validon,
              policy: policy,
              remark: remark,
              inboundremark: inboundremark,
              navcode: navcode,
              overnightcruise: overnightcruise,
              rateincludevat: rateincludevat,
              rateincludeservicecharge: rateincludeservicecharge,
              boutiquehotel: boutiquehotel,
              countryid: countryid,
              cityid: cityid,
              star: star,
              session_ssid: session_ssid,
              session_isid: session_isid,
              _token: CSRF_TOKEN},
              dataType: "text"
    });
    request.done(function(data) {
          str = data;
					res = str.split(",");
          if (res[1] != '') {
            // alert("Save Completed");
            var url = '{{url('/viewHotel')}}'+'/'+res[1]+'/'+session_ssid+'/'+session_isid;
            // window.location.assign(url);
            Swal.fire('Save Completed!', '', 'success');
            setInterval(function () {
              window.location.assign(url);
              // location.reload();
            }, 1000);
          }
          }

    });
    request.fail(function(data) {
      Swal.fire('Search Error.', '', 'error');
        // alert("");
    });

  }
</script>
@endsection

<!-- Add Phone -->
<div id="modal_phone" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color:rgb(0, 100, 251)">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title" style="color:#fff;">Add Phone Number</h3>
        </div>
        <div class="modal-body">
            <div class="row" >
              <div class="form-group">
                <!-- <div style='overflow-y:auto;' id="dataHotel"></div> -->
                <!-- <form> -->
                  <table id="table_phone" align="center" class="table" border="0" cellpadding="0" cellspacing="0" style="border-bottom: solid 0px #000; border-top:solid 0px #000;">
                      <tr>
                        <td width="95%"><input type="text" class="form-control" name="Phone[]" id="Phone1" value="" placeholder="Enter Phone"></td>
                        <td><button type="button" name="addPhone" id="addPhone" class="btn btn-info"><span align="left" class="glyphicon glyphicon-plus"></span></button></td>
                      </tr>
                  </table>
                  <input type="hidden" id="NumPhone2" name="" value="1">
                  <div class="row">
                    <div class="col-md-9"></div>
                    <div class="col-md-3">
                      <button type="button" name="button" class="btn btn-success form-control" onclick="JavaScript:savephone();">Save</button>
                    </div>
                  </div>

                <!-- </form> -->
              </div>
            </div>

        </div>
        <!-- <div class="modal-footer">
        </div> -->
      </div>
  </div>
</div>


<!-- Add Mobile -->
<div id="modal_mobile" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color:rgb(0, 100, 251)">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title" style="color:#fff;">Add Mobile Number</h3>
        </div>
        <div class="modal-body">
            <div class="row" >
              <div class="form-group">
                <!-- <div style='overflow-y:auto;' id="dataHotel"></div> -->
                <!-- <form> -->
                  <table id="table_mobile" align="center" class="table" border="0" cellpadding="0" cellspacing="0" style="border-bottom: solid 0px #000; border-top:solid 0px #000;">
                      <tr>
                        <td width="95%"><input type="text" class="form-control" name="Mobile[]" id="Mobile1" value="" placeholder="Enter Mobile"></td>
                        <td><button type="button" name="addMobile" id="addMobile" class="btn btn-info"><span align="left" class="glyphicon glyphicon-plus"></span></button></td>
                      </tr>
                  </table>
                  <input type="hidden" id="NumMobile2" name="" value="1">
                  <div class="row">
                    <div class="col-md-9"></div>
                    <div class="col-md-3">
                      <button type="button" name="button" class="btn btn-success form-control" onclick="JavaScript:savemobile();">Save</button>
                    </div>
                  </div>

                <!-- </form> -->
              </div>
            </div>

        </div>
        <!-- <div class="modal-footer">
        </div> -->
      </div>
  </div>
</div>


<!-- Add Fax -->
<div id="modal_fax" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color:rgb(0, 100, 251)">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title" style="color:#fff;">Add Fax Number</h3>
        </div>
        <div class="modal-body">
            <div class="row" >
              <div class="form-group">
                <!-- <div style='overflow-y:auto;' id="dataHotel"></div> -->
                <!-- <form> -->
                  <table id="table_fax" align="center" class="table" border="0" cellpadding="0" cellspacing="0" style="border-bottom: solid 0px #000; border-top:solid 0px #000;">
                      <tr>
                        <td width="95%"><input type="text" class="form-control" name="Fax[]" id="Fax1" value="" placeholder="Enter Fax"></td>
                        <td><button type="button" name="addFax" id="addFax" class="btn btn-info"><span align="left" class="glyphicon glyphicon-plus"></span></button></td>
                      </tr>
                  </table>
                  <input type="hidden" id="NumFax2" name="" value="1">
                  <div class="row">
                    <div class="col-md-9"></div>
                    <div class="col-md-3">
                      <button type="button" name="button" class="btn btn-success form-control" onclick="JavaScript:savefax();">Save</button>
                    </div>
                  </div>

                <!-- </form> -->
              </div>
            </div>

        </div>
        <!-- <div class="modal-footer">
        </div> -->
      </div>
  </div>
</div>


<!-- Add Website -->
<div id="modal_website" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color:rgb(0, 100, 251)">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title" style="color:#fff;">Add Website</h3>
        </div>
        <div class="modal-body">
            <div class="row" >
              <div class="form-group">
                <!-- <div style='overflow-y:auto;' id="dataHotel"></div> -->
                <!-- <form> -->
                  <table id="table_website" align="center" class="table" border="0" cellpadding="0" cellspacing="0" style="border-bottom: solid 0px #000; border-top:solid 0px #000;">
                      <tr>
                        <td width="95%"><input type="text" class="form-control" name="Website[]" id="Website1" value="" placeholder="Enter Website"></td>
                        <td><button type="button" name="addWebsite" id="addWebsite" class="btn btn-info"><span align="left" class="glyphicon glyphicon-plus"></span></button></td>
                      </tr>
                  </table>
                  <input type="hidden" id="NumWebsite2" name="" value="1">
                  <div class="row">
                    <div class="col-md-9"></div>
                    <div class="col-md-3">
                      <button type="button" name="button" class="btn btn-success form-control" onclick="JavaScript:savewebsite();">Save</button>
                    </div>
                  </div>

                <!-- </form> -->
              </div>
            </div>

        </div>
        <!-- <div class="modal-footer">
        </div> -->
      </div>
  </div>
</div>


<!-- Add RSVN E-mail -->
<div id="modal_rsvn" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color:rgb(0, 100, 251)">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title" style="color:#fff;">Add Website</h3>
        </div>
        <div class="modal-body">
            <div class="row" >
              <div class="form-group">
                <!-- <div style='overflow-y:auto;' id="dataHotel"></div> -->
                <!-- <form> -->
                  <table id="table_rsvn" align="center" class="table" border="0" cellpadding="0" cellspacing="0" style="border-bottom: solid 0px #000; border-top:solid 0px #000;">
                      <tr>
                        <td width="95%"><input type="email" class="form-control" name="RSVN[]" id="RSVN1" value="" placeholder="Enter RSVN E-mail" ></td>
                        <td><button type="button" name="addRSVN" id="addRSVN" class="btn btn-info"><span align="left" class="glyphicon glyphicon-plus"></span></button></td>
                      </tr>
                  </table>
                  <input type="hidden" id="NumRSVN2" name="" value="1">
                  <div class="row">
                    <div class="col-md-9"></div>
                    <div class="col-md-3">
                      <button type="button" name="button" class="btn btn-success form-control" onclick="JavaScript:saversvn();">Save</button>
                    </div>
                  </div>

                <!-- </form> -->
              </div>
            </div>

        </div>
        <!-- <div class="modal-footer">
        </div> -->
      </div>
  </div>
</div>


<!-- Add Sales E-mail -->
<div id="modal_sale" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color:rgb(0, 100, 251)">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title" style="color:#fff;">Add Sales E-mail</h3>
        </div>
        <div class="modal-body">
            <div class="row" >
              <div class="form-group">
                <!-- <div style='overflow-y:auto;' id="dataHotel"></div> -->
                <!-- <form> -->
                  <table id="table_sale" align="center" class="table" border="0" cellpadding="0" cellspacing="0" style="border-bottom: solid 0px #000; border-top:solid 0px #000;">
                      <tr>
                        <td width="95%"><input type="email" class="form-control" name="Sale[]" id="Sale1" request value="" placeholder="Enter Sales E-mail" ></td>
                        <td><button type="button" name="addSale" id="addSale" class="btn btn-info"><span align="left" class="glyphicon glyphicon-plus"></span></button></td>
                      </tr>
                  </table>
                  <input type="hidden" id="NumSale2" name="" value="1">
                  <div class="row">
                    <div class="col-md-9"></div>
                    <div class="col-md-3">
                      <button type="button" name="button" class="btn btn-success form-control" onclick="JavaScript:savesale();">Save</button>
                    </div>
                  </div>

                <!-- </form> -->
              </div>
            </div>

        </div>
        <!-- <div class="modal-footer">
        </div> -->
      </div>
  </div>
</div>
