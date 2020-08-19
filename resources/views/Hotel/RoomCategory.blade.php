@extends('layouts.master')
@section('pageTitle', 'Room Category')
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

.pointer {cursor: pointer;}

table{
border-collapse:collapse;
}
</style>
<input type="hidden" id="session_ssid" name="session_ssid" value="<?php echo $ssid; ?>">
<input type="hidden" id="session_isid" name="session_isid" value="<?php echo $isid; ?>">
<input type="hidden" id="hotelid" name="hotelid" value="<?php echo $Hotelid; ?>">
<input type="hidden" id="locationid" name="locationid" value="<?php echo $LocationID; ?>">


<div class="tab-content">
  <div class="row">
    <div class="form-group">
      <div class="col-md-12" align='left'><h3><b><?php echo $Hotel; ?></b></h3></div>
    </div>
  </div>
    <hr>

    <form>
        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Hotel Name :</label></div>
            <div class="col-md-1"></div>
            <div class="col-md-3"><?php echo $Hotel; ?></div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Room category :</label></div>
            <!-- <div class="col-md-5"><input type="text" class="form-control"  id="hotelname" name="hotelname"  value=""> </div> -->
          </div>
        </div>

        <?php  $num = 1;
        $Roomcat = array();
        foreach ($FHRoom1 as $FHRoom1_row) {
          $Roomcat[$num] = $FHRoom1_row->Roomcat;
          $RoomcatID[$num] = $FHRoom1_row->ID;
          $num += 1;
        }
          $k = $num - 1;
          $a = 1;
        for ($i=1; $i <= 15; $i++) {?>
        <div class="form-group">
          <div class="row">
            <div class="col-md-3" align='right'><?php echo $i; ?>.</div>

                <?php if($a <= $k){
                  if ($RoomcatID[$i] != '') {?>
                    <div class="col-md-4">
                      <?php echo $Roomcat[$i]; ?>
                      <input type="hidden" id="RoomcatID<?php echo $i; ?>" name="RoomcatID<?php echo $i; ?>"  value="<?php echo $RoomcatID[$i]; ?>">
                    </div>
                    <div class="col-md-1">
                      <button type="button" name="button" class="btn btn-danger btn-sm" OnClick="JavaScript:DelRoomcat('<?php echo $RoomcatID[$i]; ?>','<?php echo $Roomcat[$i]; ?>');">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                      </button>
                    </div>
                  <?php }
                  }else { ?>
                    <div class="col-md-4">
                      <input type="text" class="form-control"  id="Roomcat<?php echo $i; ?>" name="Roomcat<?php echo $i; ?>" onKeyUp="javascript:RoomKey(this.id,'<?php echo $i; ?>');" value="">
                    </div>
                    <div class="col-md-1">
                      <button type="button" class="btn btn-info btn-sm" style="border-radius: 50%;" name="button" OnClick="javascript:SearchRoomMaster('<?php echo $i; ?>');"><span class="glyphicon glyphicon-search"></span></button>
                    </div>
                <input type="hidden" id="RoomcatID<?php echo $i; ?>" name="RoomcatID<?php echo $i; ?>"  value="">
                <input type="hidden" id="HotelRoomMasterId<?php echo $i; ?>" name="HotelRoomMasterId<?php echo $i; ?>"  value="">

                <div id="modal_Roomcat<?php echo $i; ?>" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header" style="background-color:rgb(54, 255, 195);">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Room Category <?php echo $i; ?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="row" >
                              <div class="form-group">
                                <!-- <div style='overflow-y:auto;' id="dataHotel"></div> -->
                                <table id="table_Roomcat<?php echo $i; ?>" align='center'  class="table fixed_header" style="display:none;">
                                  <!-- <thead>
                                    <tr>
                                      <th width="70%">Hotel</th>
                                      <th width="30%">City</th>
                                    </tr>
                                  </thead> -->
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
                <?php } ?>

          </div>
        </div>
      <?php $a += 1;
        } ?>
        <input type="hidden" name="NumRoomcat" id="NumRoomcat" value="<?php echo $k; ?>">

      <div class="form-group">
        <div class="row">
          <div class="col-md-7"></div>
          <div class="col-md-3" align='right'>
            <button type="button" class="btn btn-success" name="button" OnClick="javascript:SaveRoomcat();">Save</button>
            <!-- <button type="button" class="btn btn-warning" name="button">Clear</button> -->
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

function RoomKey(n,num) {
  if (event.keyCode == '13') {
    var Roomcat = $("#"+n).val();
      SearchRoomMaster(num);
    }
}


  function Cancel() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var session_ssid = $("#session_ssid").val();
    var session_isid = $("#session_isid").val();
    var hotelid = $("#hotelid").val();

    var url = '{{url('/viewHotel')}}'+'/'+hotelid+'/'+session_ssid+'/'+session_isid;
    window.location.assign(url);
  }

  function SearchRoomMaster(num) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var url = '{{url('/SearchRoomMaster')}}';
    var Roomcat = $("#Roomcat"+num).val();

            var request = $.post(url,
                {Roomcat: Roomcat,
                _token: CSRF_TOKEN,
              });
            request.done(function(response) {
              // alert(data);
              // Swal.fire('Search Error.', '', 'error');
              $("#modal_Roomcat"+num).modal();
              $("#table_Roomcat"+num+" tbody tr").remove();
              $("#table_Roomcat"+num).css('display','table');
              var item_Array = $.parseJSON(response);
              // alert(response)
              if(item_Array["data"].length > 0){
                itemArray = item_Array["data"];
                // alert(itemArray);
                for(index = 0; index < itemArray.length; index++){
                var itemData = itemArray[index];
                // alert(itemData)
                $("#table_Roomcat"+num+" > tbody").append("<tr><td><a class='pointer' target='_blank' onclick='selectRoom(this , "+num+")' data-roomcat-id='"+
                                                  itemData['HotelRoomMasterId'] +","+itemData['HotelRoomMasterName'] +"'>" +itemData['HotelRoomMasterName'] + "</a></td></tr>");
                }
              }

            });
            request.fail(function(response) {
                Swal.fire('Search Error.', '', 'error');
            });
  }

  function selectRoom(item,num) {
    var Roomcat_id = $(item).data('roomcat-id');
    str = Roomcat_id;
    res = str.split(",");
    // var Roomcat_name = $(item).html('roomcat-id');
    // alert(res[0]+' | '+num+' | '+res[1])
    $("#modal_Roomcat"+num).modal('hide');
    $("#Roomcat"+num).val(res[1]);
    $("#HotelRoomMasterId"+num).val(res[0]);
  }

  function DelRoomcat(RoomcatID, Roomcat) {
    BootstrapDialog.show({
     	title: '<i class="glyphicon glyphicon-trash"></i> Confirm Delete RoomCategory.',
		type: BootstrapDialog.TYPE_DANGER,
        message: 'Confirm delete ' + Roomcat + ' Yes/No ?',
		draggable: true,
		closable: false,
		closeByBackdrop: false,
        closeByKeyboard: false,
		buttons: [{
			label: "<i class='glyphicon glyphicon-remove'></i> No",
			cssClass: 'btn-secondary',
			hotkey: 13,
        	action: function(dialogItself){
            	dialogItself.close();
        	}
		},{
			label: "<i class='glyphicon glyphicon-ok'></i>&nbsp; Yes",
			cssClass: 'btn-danger',
			//hotkey: 13, //enter
			action: function(dialogItself){

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var url = '{{url('/DelRoomcat')}}';
        var locationid = $("#locationid").val();

        var request = $.ajax({
            url: url,
            method: "POST",
            data: {
                  RoomcatID: RoomcatID,
                  Roomcat: Roomcat,
                  locationid: locationid,
                  _token: CSRF_TOKEN},
                  dataType: "text"
                });
                request.done(function(data) {
                  // alert(data);
                  Swal.fire('Delete success!', '', 'success');

                  dialogItself.close();
                  setInterval(function () {
                    document.location.reload(true);
                    // location.reload();
                  }, 1000);

                });
                request.fail(function(data) {
                    Swal.fire('Delete Error.', '', 'error');
                });


        // alert('Delete success!');


        //
				// 			RefreshAdminUse();
				//
				// 		}else if(data==2){
        //
				// 			dialogItself.close();
				// 			BootstrapDialog.alert("ระบบไม่สามารถ ลบ User : " + udt4 + udt5 + " ได้ กรุณาติดต่อผู้ดูและระบบ.");
				// 		}else{
				// 			//
				// 		}
        // 			},
        // 			error: function() {
				// 		BootstrapDialog.alert("Error Can't Delete user.");
        // 			}
				// });

			}
		}]
     });
  }

  function SaveRoomcat() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var url = '{{url('/SaveRoomcat')}}';
    var session_ssid = $("#session_ssid").val();
    var session_isid = $("#session_isid").val();
    var hotelid = $("#hotelid").val();
    var locationid = $("#locationid").val();
    var NumRoomcat = 1;
    var Roomcat = "";
    var RoomcatID = "";
    var HotelRoomMasterId = "";

    for (var i = 1; i <= 15; i++) {
      if ($("#Roomcat"+i).val() != '') {
        if (Roomcat == '') {
          Roomcat = $("#Roomcat"+i).val();
          RoomcatID = $("#RoomcatID"+i).val();
          HotelRoomMasterId = $("#HotelRoomMasterId"+i).val();
        }else {
          Roomcat = Roomcat+','+$("#Roomcat"+i).val();
          // if ($("#RoomcatID"+i).val() != '') {
            RoomcatID = RoomcatID+','+$("#RoomcatID"+i).val();
            HotelRoomMasterId = HotelRoomMasterId+','+$("#HotelRoomMasterId"+i).val();
          // }
        }
        NumRoomcat += 1;
      }
    }
    // alert(Roomcat+' | '+RoomcatID)
    NumRoomcat -= 1;

    var request = $.ajax({
        url: url,
        method: "POST",
        data: {session_ssid: session_ssid,
              session_isid: session_isid,
              hotelid: hotelid,
              locationid: locationid,
              NumRoomcat: NumRoomcat,
              RoomcatID: RoomcatID,
              Roomcat: Roomcat,
              HotelRoomMasterId: HotelRoomMasterId,
              _token: CSRF_TOKEN},
              dataType: "text"
            });
            request.done(function(data) {
              Swal.fire('Save success!', '', 'success');
              setInterval(function () {
                location.reload();
              }, 1000);

            });
            request.fail(function(data) {
                alert("Search Error.");
            });
  }

</script>
@endsection
