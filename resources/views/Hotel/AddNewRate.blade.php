@extends('layouts.master')
@section('pageTitle', 'New Rate')
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
    <input type="hidden" id="hotelid" name="hotelid" value="<?php echo $Hotelid; ?>">

    <div class="tab-content">
      <div class="row">
        <div class="form-group">
          <div class="col-md-12" align='left'><h3><b>Add New Rate</b></h3></div>
        </div>
      </div>

      <form class="">
        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Room Category</label></div>
            <div class="col-md-3">
              <select class="form-control" name="RoomCategory" id="RoomCategory">
              <option value=""> # Select #</option>
                @foreach($FHRoom1 AS $FHRoom1_row)
                <option value="{{$FHRoom1_row->ID}}">{{$FHRoom1_row->Roomcat}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Extra Bed Type</label></div>
            <div class="col-md-3">
              <select class="form-control" name="ExtraBedType" id="ExtraBedType" OnChange="JavaScript:ChangeExtraBedType();">
                @foreach($HotelExtraBedType AS $HotelExtraBedType_row)
                <option value="{{$HotelExtraBedType_row->ExtraBedTypeId}}"> {{$HotelExtraBedType_row->ExtraBedTypeName}} </option>
                @endforeach
              </select>
            </div>

            <div class="col-md-2" align='right'><label for=""> Extra Bed Max</label></div>
            <div class="col-md-1">
              <select class="form-control" name="ExtraBedMax" id="ExtraBedMax">
                <?php for ($i=0; $i < 5; $i++) { ?>
                  <option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Formerly Name of Room</label></div>
            <!-- <div class="col-md-8"><input type="text" class="form-control" name="" id=""  value=""> </div> -->
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Route of Cruise</label></div>
            <!-- <div class="col-md-8"><input type="text" class="form-control" name="" id=""  value=""> </div> -->
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Number of Bedrooms</label></div>
            <div class="col-md-2">
              <input type="radio" name="Bedrooms" id="BedroomsOne" value="Standard" checked OnClick="JavaScript:ClickBedrooms();"> One
            </div>
            <div class="col-md-2">
              <input type="radio" name="Bedrooms" id="BedroomsTwo" value="Two" OnClick="JavaScript:ClickBedrooms();"> Two
            </div>
            <div class="col-md-2">
              <input type="radio" name="Bedrooms" id="BedroomsThree" value="Three" OnClick="JavaScript:ClickBedrooms();"> Three
            </div>
            <div class="col-md-2">
              <input type="radio" name="Bedrooms" id="BedroomsQuad" value="Quad" OnClick="JavaScript:ClickBedrooms();"> Four
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-6">
              <td>
                <table width="98%" border="0" cellspacing="0" cellpadding="0" id="">
                  <tbody>
                    <tr>
                      <td width="20%">Price applicable</td>
                      <td width="10%">
                        <select class="input-sm form-control" name="BedroomFrom" id="BedroomFrom">
                          <?php for ($i=1; $i < 21; $i++) { ?>
                            <option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
                          <?php } ?>
                        </select>
                      </td>
                      <td width="5%"> &nbsp;To </td>
                      <td width="10%">
                        <select class="input-sm form-control" name="BedroomTo" id="BedroomTo">
                          <?php for ($i=1; $i < 21; $i++) { ?>
                            <option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
                          <?php } ?>
                        </select>
                      </td>
                      <td width="5%">&nbsp;Pax</td>
                      <td width="20%" align="right">Price Unit &nbsp;</td>
                      <td width="30%">
                        <select class="input-sm form-control" name="slctPriceUnit" id="slctPriceUnit">
                          <option value="Per Person">Per Person</option>
                          <option value="Per Room">Per Room</option>
                          <option value="Per Package">Per Package</option>
                        </select>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-3" align='right'>
              <input type="checkbox" name="chkAddType" id="chkAddType" OnClick="JavaScript:ClickAddType();" value=""> Additional Charge Type
            </div>
            <div class="col-md-6">
              <td>
                <table width="98%" border="0" cellspacing="0" cellpadding="0" id="tbAddType">
                  <input type="hidden" name="NumType" id="NumType" value="1">
                  <input type="hidden" name="DateType" id="DateType" value="1">
                    <tbody  id="tbodyAddTypeOriginal" style="display:none">
                      <tr id="tbodyAddTypeOriginal1">
                        <td width="50%">
                          <select class="input-sm form-control" name="slctAddType" id="slctAddType">
                            @foreach($HotelChargeType AS $HotelChargeType_row)
                              <option value="{{$HotelChargeType_row->ChargeTypeId}}" <?php if ($HotelChargeType_row->ChargeTypeName == 'Extra Bed') { echo 'selected';} ?>> {{$HotelChargeType_row->ChargeTypeName}} </option>
                            @endforeach
                          </select>
                        </td>
                        <td> &nbsp;&nbsp;&nbsp;&nbsp;From</td>
                        <td>
                          <select class="input-sm form-control" name="slctAddTypeFrom" id="slctAddTypeFrom">
                            <?php for ($i=1; $i < 21; $i++) { ?>
                              <option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
                            <?php } ?>
                          </select>
                        </td>
                        <td> &nbsp;&nbsp;To</td>
                        <td>
                          <select class="input-sm form-control" name="slctAddTypeTo" id="slctAddTypeTo">
                            <?php for ($i=1; $i < 21; $i++) { ?>
                              <option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
                            <?php } ?>
                          </select>
                        </td>
                        <td>&nbsp;&nbsp;
                          <button class="btn btn-success btn-xs" type="button" name="imgadd" id="imgadd" OnClick="JavaScript:CloneAddType();"><span align="left" class="glyphicon glyphicon-plus"></span></button>
                          <button class="btn btn-danger btn-xs" type="button" name="imgdel" id="imgdel" OnClick="JavaScript:DeleteRow(this);"><span align="left" class="glyphicon glyphicon-minus"></span></button>
                        </td>

                      </tr>
                    </tbody>
                    <tbody id="tbodyAddType_1">
                      <tr id="">
                        <td width="50%">
                          <select class="input-sm form-control" name="slctAddType_1" id="slctAddType_1">
                            @foreach($HotelChargeType AS $HotelChargeType_row)
                              <option value="{{$HotelChargeType_row->ChargeTypeId}}" <?php if ($HotelChargeType_row->ChargeTypeName == 'Extra Bed') { echo 'selected';} ?>> {{$HotelChargeType_row->ChargeTypeName}} </option>
                            @endforeach
                          </select>
                        </td>
                        <td> &nbsp;&nbsp;&nbsp;&nbsp;From</td>
                        <td>
                          <select class="input-sm form-control" name="slctAddTypeFrom_1" id="slctAddTypeFrom_1">
                            <?php for ($i=1; $i < 21; $i++) { ?>
                              <option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
                            <?php } ?>
                          </select>
                        </td>
                        <td> &nbsp;&nbsp;To</td>
                        <td>
                          <select class="input-sm form-control" name="slctAddTypeTo_1" id="slctAddTypeTo_1">
                            <?php for ($i=1; $i < 21; $i++) { ?>
                              <option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
                            <?php } ?>
                          </select>
                        </td>
                        <td>&nbsp;&nbsp;
                          <button class="btn btn-success btn-xs" type="button" name="imgadd_1" id="imgadd_1" OnClick="JavaScript:CloneAddType();"><span align="left" class="glyphicon glyphicon-plus"></span></button>
                        </td>

                      </tr>
                    </tbody>
                </table>
              </td>

            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Define FIT/GIT</label></div>
            <div class="col-md-2">
              <input type="radio" name="DefineFitGit" id="DefineAll" value="0" OnClick="JavaScript:ClickDefineFITGIT();" checked> All
            </div>
          </div>
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-1">
              <input type="radio" name="DefineFitGit" id="DefineFit" value="1" OnClick="JavaScript:ClickDefineFITGIT();"> FIT
            </div>
            <div class="col-md-3">
              <table width="98%" border="0" cellspacing="0" cellpadding="0">
                <tbody  >
                  <tr>
                    <td>
                      <select class="input-sm form-control" name="StartFit" id="StartFit">
                        <?php for ($i=1; $i < 21; $i++) { ?>
                          <option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
                        <?php } ?>
                      </select>
                    </td>
                    <td> &nbsp;&nbsp;To&nbsp;&nbsp;</td>
                    <td>
                      <select class="input-sm form-control" name="EndFit" id="EndFit">
                        <?php for ($i=1; $i < 21; $i++) { ?>
                          <option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
                        <?php } ?>
                      </select>
                    </td>
                    <td>&nbsp;&nbsp;</td>
                    <td>
                      <select class="input-sm form-control" name="RPFit" id="RPFit">
                        <option value="Room(s)"> Room(s) </option>
                        <option value="Pax(s)"> Pax(s) </option>
                      </select>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-1">
              <input type="radio" name="DefineFitGit" id="DefineGit" value="2" OnClick="JavaScript:ClickDefineFITGIT();"> GIT
            </div>
            <div class="col-md-3">
              <table width="98%" border="0" cellspacing="0" cellpadding="0">
                <tbody  >
                  <tr>
                    <td>
                      <select class="input-sm form-control" name="StartGit" id="StartGit">
                        <?php for ($i=1; $i < 21; $i++) { ?>
                          <option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
                        <?php } ?>
                      </select>
                    </td>
                    <td> &nbsp;&nbsp;To&nbsp;&nbsp;</td>
                    <td>
                      <select class="input-sm form-control" name="EndGit" id="EndGit">
                        <?php for ($i=1; $i < 21; $i++) { ?>
                          <option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
                        <?php } ?>
                      </select>
                    </td>
                    <td>&nbsp;&nbsp;</td>
                    <td>
                      <select class="input-sm form-control" name="RPGit" id="RPGit">
                        <option value="Room(s)"> Room(s) </option>
                        <option value="Pax(s)"> Pax(s) </option>
                      </select>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Define Rate Applicable</label></div>
            <div class="col-md-2">
              <input type="radio" name="DefineRateApp" id="Daily" value="Daily" checked OnClick="JavaScript:ClickDefineRateApplicable();"> Daily
            </div>
          </div>
          <div class="row">
            <div class="col-md-2" align='right'><label for="">  </label></div>
            <div class="col-md-2">
              <input type="radio" name="DefineRateApp" id="Weekday" value="Weekday" OnClick="JavaScript:ClickDefineRateApplicable();"> Weekday
            </div>
            <div class="col-md-5">
              <table width="98%" border="0" cellspacing="0" cellpadding="0">
                <tbody  >
                  <tr>
                    <td>
                      <input type="checkbox" name="WeekdayMon" id="WeekdayMon" value="1">&nbsp;Mon
                    </td>
                    <td>
                      <input type="checkbox" name="WeekdayTue" id="WeekdayTue" value="1">&nbsp;Tue
                    </td>
                    <td>
                      <input type="checkbox" name="WeekdayWed" id="WeekdayWed" value="1">&nbsp;Wed
                    </td>
                    <td>
                      <input type="checkbox" name="WeekdayThu" id="WeekdayThu" value="1">&nbsp;Thu
                    </td>
                    <td>
                      <input type="checkbox" name="WeekdayFri" id="WeekdayFri" value="1">&nbsp;Fri
                    </td>
                    <td>
                      <input type="checkbox" name="WeekdaySat" id="WeekdaySat" value="1">&nbsp;Sat
                    </td>
                    <td>
                      <input type="checkbox" name="WeekdaySun" id="WeekdaySun" value="1">&nbsp;Sun
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2" align='right'><label for="">  </label></div>
            <div class="col-md-2">
              <input type="radio" name="DefineRateApp" id="Weekend" value="Weekend" OnClick="JavaScript:ClickDefineRateApplicable();"> Weekend
            </div>
            <div class="col-md-5">
              <table width="98%" border="0" cellspacing="0" cellpadding="0">
                <tbody  >
                  <tr>
                    <td>
                      <input type="checkbox" name="WeekendMon" id="WeekendMon" value="1">&nbsp;Mon
                    </td>
                    <td>
                      <input type="checkbox" name="WeekendTue" id="WeekendTue" value="1">&nbsp;Tue
                    </td>
                    <td>
                      <input type="checkbox" name="WeekendWed" id="WeekendWed" value="1">&nbsp;Wed
                    </td>
                    <td>
                      <input type="checkbox" name="WeekendThu" id="WeekendThu" value="1">&nbsp;Thu
                    </td>
                    <td>
                      <input type="checkbox" name="WeekendFri" id="WeekendFri" value="1">&nbsp;Fri
                    </td>
                    <td>
                      <input type="checkbox" name="WeekendSat" id="WeekendSat" value="1">&nbsp;Sat
                    </td>
                    <td>
                      <input type="checkbox" name="WeekendSun" id="WeekendSun" value="1">&nbsp;Sun
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2" align='right'><label for="">  </label></div>
            <div class="col-md-2">
              <input type="radio" name="DefineRateApp" id="NotApplicable" value="Not Applicable" OnClick="JavaScript:ClickDefineRateApplicable();"> Not Applicable
            </div>
            <div class="col-md-3">
              <input type="text" class="form-control" name="NotApplicableInput" id="NotApplicableInput" value="">
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Define Market </label></div>
            <div class="col-md-3">
              <input type="radio" name="DefineMarket" id="Worldwide" OnClick="JavaScript:ClickMarket();" checked value=""> Worldwide
            </div>
          </div>
          <input type="hidden" name="CountTOMarketMaster" id="CountTOMarketMaster" value="<?php echo $CountTOMarketMaster; ?>">
          <div class="row">
            <div class="col-md-2" align='right'><label for="">  </label></div>
            <div class="col-md-5">
              <input type="radio" name="DefineMarket" id="WorldwideMarket" OnClick="JavaScript:ClickMarket();" value=""> Worldwide except Market(s)
              <div class="row">
                <?php $a = 1;?>
                @foreach($TOMarketMaster AS $TOMarketMaster_Row)
                <div class="col-md-6" style="font-size:13px;">
                  <input type="checkbox" name="wmarket_<?php echo $a; ?>" id="wmarket_<?php echo $a; ?>" value="{{$TOMarketMaster_Row->TOMarketId}}"> {{$TOMarketMaster_Row->TOMarketData}}
                </div>
                <?php $a += 1; ?>
                @endforeach
              </div>
              <div class="row">
                <div class="col-md-12">
                  <table width="98%" border="0" cellspacing="0" cellpadding="0">
                    <tbody  >
                      <tr>
                        <td>
                          Other :
                        </td>
                        <td>
                          <input type="text" class="form-control" name="" id="" value="" readonly>
                        </td>
                        <td>&nbsp;</td>
                        <td>
                          <button type="button" name="btnwmarket" id="btnwmarket" class="btn btn-success btn-xs"><span align="left" class="glyphicon glyphicon-plus"></span></button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <input type="radio" name="DefineMarket" id="Market" OnClick="JavaScript:ClickMarket();" value=""> Market(s)
              <div class="row">
                <?php $a = 1;?>
                @foreach($TOMarketMaster AS $TOMarketMaster_Row)
                <div class="col-md-6" style="font-size:13px;">
                  <input type="checkbox" name="market_<?php echo $a; ?>" id="market_<?php echo $a; ?>" value="{{$TOMarketMaster_Row->TOMarketId}}"> {{$TOMarketMaster_Row->TOMarketData}}
                </div>
                <?php $a += 1; ?>
                @endforeach
              </div>
              <div class="row">
                <div class="col-md-12">
                  <table width="98%" border="0" cellspacing="0" cellpadding="0">
                    <tbody  >
                      <tr>
                        <td>
                          Other :
                        </td>
                        <td>
                          <input type="text" class="form-control" name="" id="" value="" readonly>
                        </td>
                        <td>&nbsp;</td>
                        <td>
                          <button type="button" name="btnmarket" id="btnmarket" class="btn btn-success btn-xs"><span align="left" class="glyphicon glyphicon-plus"></span></button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'>
              <input type="checkbox" name="DefineTo" id="DefineTo" OnClick="JavaScript:ClickDefineTo();" value="">
              <label for=""> Define TO </label>
            </div>
            <div class="col-md-5">
              <select class="form-control" name="DefineSelect" id="DefineSelect">
                @foreach($tbContacts AS $tbContacts_row)
                <option value="{{$tbContacts_row->ContactsId}}">{{$tbContacts_row->CompanyDesc}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'>
              <input type="checkbox" name="DefineSeriesTO" id="DefineSeriesTO" OnClick="JavaScript:ClickDefineSeriesTO();" value="">
              <label for=""> Define Series TO </label>
            </div>
            <div class="col-md-5">
              <select class="form-control" name="DefineSeriesTOSelect" id="DefineSeriesTOSelect">
                <option value="">All</option>
                @foreach($tbContacts AS $tbContacts_row)
                <option value="{{$tbContacts_row->ContactsId}}">{{$tbContacts_row->CompanyDesc}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Series Name </label></div>
            <div class="col-md-4">
              <input type="text" class="form-control" name="SeriesName" id="SeriesName" value="">
            </div>
          </div>
          <div class="row">
            <div class="col-md-2" align='right'></div>
            <div class="col-md-2">
              <input type="radio" name="SeriesNameRadio" id="SeriesNameAll" OnClick="JavaScript:ClickSeriesName();" checked value=""> All
            </div>
          </div>
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-1">
              <input type="radio" name="SeriesNameRadio" id="SeriesNameFit" OnClick="JavaScript:ClickSeriesName();" value=""> FIT
            </div>
            <div class="col-md-3">
              <table width="98%" border="0" cellspacing="0" cellpadding="0">
                <tbody  >
                  <tr>
                    <td>
                      <select class="input-sm form-control" name="FitStart" id="FitStart">
                        <?php for ($i=1; $i < 21; $i++) { ?>
                          <option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
                        <?php } ?>
                      </select>
                    </td>
                    <td> &nbsp;&nbsp;To&nbsp;&nbsp;</td>
                    <td>
                      <select class="input-sm form-control" name="FitTo" id="FitTo">
                        <?php for ($i=1; $i < 21; $i++) { ?>
                          <option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
                        <?php } ?>
                      </select>
                    </td>
                    <td>&nbsp;&nbsp;</td>
                    <td>
                      <select class="input-sm form-control" name="FitRP" id="FitRP">
                        <option value="Room(s)"> Room(s) </option>
                        <option value="Pax(s)"> Pax(s) </option>
                      </select>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-1">
              <input type="radio" name="SeriesNameRadio" id="SeriesNameGit" OnClick="JavaScript:ClickSeriesName();" value=""> GIT
            </div>
            <div class="col-md-3">
              <table width="98%" border="0" cellspacing="0" cellpadding="0">
                <tbody  >
                  <tr>
                    <td>
                      <select class="input-sm form-control" name="GitStart" id="GitStart">
                        <?php for ($i=1; $i < 21; $i++) { ?>
                          <option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
                        <?php } ?>
                      </select>
                    </td>
                    <td> &nbsp;&nbsp;To&nbsp;&nbsp;</td>
                    <td>
                      <select class="input-sm form-control" name="GitTo" id="GitTo">
                        <?php for ($i=1; $i < 21; $i++) { ?>
                          <option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
                        <?php } ?>
                      </select>
                    </td>
                    <td>&nbsp;&nbsp;</td>
                    <td>
                      <select class="input-sm form-control" name="GitRP" id="GitRP">
                        <option value="Room(s)"> Room(s) </option>
                        <option value="Pax(s)"> Pax(s) </option>
                      </select>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-2" align='right'><label for=""> Currency </label></div>
            <div class="col-md-2">
              <select class="form-control" name="Currency" id="Currency">
                @foreach($Currency AS $Currency_Row)
                <option value="{{$Currency_Row->Id}}" <?php if ($Currency_Row->Currency == 'USD') { echo "selected"; } ?>>{{$Currency_Row->Currency}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

      </form>

      <div class="form-group">
        <div class="row" align="center">
          <button type="button" name="button" class="btn btn-success" OnClick="JavaScript:SaveNewRate();"> Save </button>
          <button type="button" name="button" class="btn btn-danger"  OnClick="javascript:Cancel();"> Cancel </button>
        </div>
      </div>
    </div>

@include('layouts.inc-scripts')
<script type="text/javascript">
$(document).ready(function () {
  $('.selectTo').select2();
  $('.datepicker').datepicker({
      format: 'dd/mm/yyyy'
  });

  var ExtraBedType = $("#ExtraBedType").val();
  if (ExtraBedType == '9DA7AA01-98D6-43FD-9AD4-0B53FA1F9999') {
    $('#ExtraBedMax').val('0').attr('disabled',true);
  }

  ClickBedrooms();
  ClickMarket();
  ClickDefineTo();
  ClickDefineSeriesTO();
  ClickDefineFITGIT();
  ClickDefineRateApplicable();

  $("#imgadd_1").hide();
});

function ClickAddType() {
  if(($('#chkAddType').is(':checked'))){
    $('select[id^="slctAddType"]').each(function(){	$(this).removeAttr("disabled") 	;	});
    $('select[id^="slctAddTypeFrom"]').each(function(){	$(this).removeAttr("disabled") 	;	});
    $('select[id^="slctAddTypeTo"]').each(function(){	$(this).removeAttr("disabled") 	;	});
    // alert("1");
    $("*[id^=imgadd]").each(function(){	$(this).show();});
    $("*[id^=imgdel]").each(function(){	$(this).show();});
    $("*[id^=imgadd_1]").each(function(){	$(this).show();});
    // $('#imgadd').each(function(){	$(this).show();  	});
    // $('#imgdel').each(function(){	$(this).show() 	;  	});
  }else{
    $('select[id^="slctAddType"]').each(function(){	$(this).attr("disabled","disabled") ; 		});
    $('select[id^="slctAddTypeFrom"]').each(function(){	$(this).attr("disabled","disabled") ; 		});
    $('select[id^="slctAddTypeTo"]').each(function(){	$(this).attr("disabled","disabled") ; 		});
    // alert("2");
    $("*[id^=imgadd]").each(function(){	$(this).hide();});
    $("*[id^=imgdel]").each(function(){	$(this).hide();});
    $("*[id^=imgadd_1]").each(function(){	$(this).hide();});
    // $('#imgadd_').each(function(){	$(this).hide()	  ; 	});
    // $('#imgdel').each(function(){	$(this).hide()		;  	});
  }
}

  function ChangeExtraBedType() {
    var ExtraBedType = $("#ExtraBedType").val();
    if (ExtraBedType != '9DA7AA01-98D6-43FD-9AD4-0B53FA1F9999') {
      $('#ExtraBedMax').attr('disabled', false);
    }else {
      $('#ExtraBedMax').val('0').attr('disabled',true);
    }
  }

  function ClickBedrooms() {
    if ($("#BedroomsOne").is(":checked")) {
      var Bedrooms = $("#BedroomsOne").val();
      disBedroom() ;
    }else if ($("#BedroomsTwo").is(":checked")) {
      var Bedrooms = $("#BedroomsTwo").val();
      disBedroom('checked') ;
    }else if ($("#BedroomsThree").is(":checked")) {
      var Bedrooms = $("#BedroomsThree").val();
      disBedroom('checked') ;
    }else if ($("#BedroomsQuad").is(":checked")) {
      var Bedrooms = $("#BedroomsQuad").val();
      disBedroom('checked') ;
    }

    // alert(Bedrooms)
  }

  function disBedroom(status){
	if(status == 'checked'){
		$('#BedroomFrom').removeAttr("disabled") 	;
		$('#BedroomTo').removeAttr("disabled") 	;
		$('#slctPriceUnit').removeAttr("disabled") 	;
		$('#chkAddType').removeAttr("disabled") 	;

		if($('#chkAddType').is(':checked')){

			$('select[id^="slctAddType"]').each(function(){	$(this).removeAttr("disabled") 	;	});
			$('select[id^="slctAddTypeFrom"]').each(function(){	$(this).removeAttr("disabled") 	;	});
			$('select[id^="slctAddTypeTo"]').each(function(){	$(this).removeAttr("disabled") 	;	});
			// $('button[id^="imgadd"]').each(function(){	$(this).show();  	});
			// $('button[id^="imgdel"]').each(function(){	$(this).show();  	});
      $("*[id^=imgadd]").each(function(){	$(this).show();  	});
      $("*[id^=imgdel]").each(function(){	$(this).show();  	});
      $("*[id^=imgadd_1]").each(function(){	$(this).show();  	});
		}

	}else{
		$('#BedroomFrom').attr("disabled","disabled")  	;
		$('#BedroomTo').attr("disabled","disabled")  	;
		$('#chkAddType').attr("disabled","disabled")  	;
		$('#slctPriceUnit').attr("disabled","disabled")  	;
		$('select[id^="slctAddType"]').each(function(){	$(this).attr("disabled","disabled") ; 		});
		$('select[id^="slctAddTypeFrom"]').each(function(){	$(this).attr("disabled","disabled") ; 		});
		$('select[id^="slctAddTypeTo"]').each(function(){	$(this).attr("disabled","disabled") ; 		});
		// $('button[id^="imgadd_"]').each(function(){	$(this).hide(); 	});
		// $('button[id^="imgdel"]').each(function(){	$(this).hide();  	});
    $("*[id^=imgadd]").each(function(){	$(this).hide();});
    $("*[id^=imgdel]").each(function(){	$(this).hide();});
    $("*[id^=imgadd_1]").each(function(){	$(this).hide();});
	}
}

  function CloneAddType() {
    $("#test").show();
    var times = new Date() ; //alert(times.getHours()+''+times.getMinutes()+''+times.getMilliseconds()) ; return false() ;
	var timestamp = times.getHours()+''+times.getMinutes()+''+times.getMilliseconds();
	var table = 'tbAddType';
	var tbodyOri = 'tbodyAddTypeOriginal';
	var newrow = timestamp;
  var NumType = parseInt($("#NumType").val());
  var DateType = $("#DateType").val();

  NumType += 1;
  // if (DateType == '') {
  //   DateType = newrow;
  // }else {
    DateType = DateType+','+newrow;
  // }
	var tbodyNew = 'tbodyAddType_'+newrow;
	$('#'+tbodyOri).clone().removeAttr("style").appendTo($('#'+table)).attr('id',tbodyNew);
	$('#'+tbodyNew).find("select[id='slctAddType']").attr('name','slctAddType_'+newrow).attr('id','slctAddType_'+newrow);
	$('#'+tbodyNew).find("select[id='slctAddTypeFrom']").attr('name','slctAddTypeFrom_'+newrow).attr('id','slctAddTypeFrom_'+newrow);
	$('#'+tbodyNew).find("select[id='slctAddTypeTo']").attr('name','slctAddTypeTo_'+newrow).attr('id','slctAddTypeTo_'+newrow);
  $("#NumType").val(NumType);
  $("#DateType").val(DateType);
	// $('#'+tbodyNew).find("img[name='imgadd']").attr('name','imgadd_'+newrow).attr('id','imgadd_'+newrow);
  }

  function DeleteRow(obj){
	   try{
		     $(obj).parent().parent().parent().remove();
	   }catch(e){
		     alert(e.description);
	   }
  }

  function ClickMarket() {
    if ($("#Worldwide").is(":checked")) {
      // var Worldwide = $("#Worldwide").val();
      $('input[id^="wmarket_"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('input[id^="market_"]').each(function(){	$(this).attr("disabled","disabled") ;		});
      $("*[id^=btnwmarket]").each(function(){	$(this).hide();});
      $("*[id^=btnmarket]").each(function(){	$(this).hide();});
    }else if ($("#WorldwideMarket").is(":checked")) {
      // var Worldwide = $("#WorldwideMarket").val();
      $('input[id^="market_"]').each(function(){	$(this).attr("disabled","disabled") ;		});
      $('input[id^="wmarket_"]').each(function(){	$(this).removeAttr("disabled");		});
      $("*[id^=btnwmarket]").each(function(){	$(this).show();});
      $("*[id^=btnmarket]").each(function(){	$(this).hide();});
    }else if ($("#Market").is(":checked")) {
      // var Worldwide = $("#Market").val();
      $('input[id^="wmarket_"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('input[id^="market_"]').each(function(){	$(this).removeAttr("disabled");		});
      $("*[id^=btnmarket]").each(function(){	$(this).show();});
      $("*[id^=btnwmarket]").each(function(){	$(this).hide();});
    }
  }

  function ClickDefineTo() {
    if ($("#DefineTo").is(":checked")) {
      // alert("click");
      $('select[id^="DefineSelect"]').each(function(){	$(this).removeAttr("disabled") ; 		});
    }else {
      // alert("NOt");
      $('select[id^="DefineSelect"]').each(function(){	$(this).attr("disabled","disabled") ; 		});
    }
  }

  function ClickDefineSeriesTO() {
    if ($("#DefineSeriesTO").is(":checked")) {
      $('select[id^="DefineSeriesTOSelect"]').each(function(){	$(this).removeAttr("disabled") ; 		});
      $('input[id^="SeriesNameAll"]').each(function(){	$(this).removeAttr("disabled");		});
      $('input[id^="SeriesNameFit"]').each(function(){	$(this).removeAttr("disabled");		});
      $('input[id^="SeriesNameGit"]').each(function(){	$(this).removeAttr("disabled");		});
    }else {
      $('select[id^="DefineSeriesTOSelect"]').each(function(){	$(this).attr("disabled","disabled") ; 		});
      $('input[id^="SeriesNameAll"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('input[id^="SeriesNameFit"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('input[id^="SeriesNameGit"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="FitStart"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="FitTo"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="FitRP"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="GitStart"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="GitTo"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="GitRP"]').each(function(){	$(this).attr("disabled","disabled");		});
    }
  }

  function ClickSeriesName() {
    if ($("#SeriesNameAll").is(":checked")) {
      $('select[id^="FitStart"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="FitTo"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="FitRP"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="GitStart"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="GitTo"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="GitRP"]').each(function(){	$(this).attr("disabled","disabled");		});
    }else if ($("#SeriesNameFit").is(":checked")) {
      $('select[id^="FitStart"]').each(function(){	$(this).removeAttr("disabled");		});
      $('select[id^="FitTo"]').each(function(){	$(this).removeAttr("disabled");		});
      $('select[id^="FitRP"]').each(function(){	$(this).removeAttr("disabled");		});
      $('select[id^="GitStart"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="GitTo"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="GitRP"]').each(function(){	$(this).attr("disabled","disabled");		});
    }else if ($("#SeriesNameGit").is(":checked")) {
      $('select[id^="GitStart"]').each(function(){	$(this).removeAttr("disabled");		});
      $('select[id^="GitTo"]').each(function(){	$(this).removeAttr("disabled");		});
      $('select[id^="GitRP"]').each(function(){	$(this).removeAttr("disabled");		});
      $('select[id^="FitStart"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="FitTo"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="FitRP"]').each(function(){	$(this).attr("disabled","disabled");		});
    }
  }

  function ClickDefineFITGIT() {
    if ($("#DefineAll").is(":checked")) {
      $('select[id^="StartFit"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="EndFit"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="RPFit"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="StartGit"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="EndGit"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="RPGit"]').each(function(){	$(this).attr("disabled","disabled");		});
    }else if ($("#DefineFit").is(":checked")) {
      $('select[id^="StartFit"]').each(function(){	$(this).removeAttr("disabled");		});
      $('select[id^="EndFit"]').each(function(){	$(this).removeAttr("disabled");		});
      $('select[id^="RPFit"]').each(function(){	$(this).removeAttr("disabled");		});
      $('select[id^="StartGit"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="EndGit"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="RPGit"]').each(function(){	$(this).attr("disabled","disabled");		});
    }else if ($("#DefineGit").is(":checked")) {
      $('select[id^="StartGit"]').each(function(){	$(this).removeAttr("disabled");		});
      $('select[id^="EndGit"]').each(function(){	$(this).removeAttr("disabled");		});
      $('select[id^="RPGit"]').each(function(){	$(this).removeAttr("disabled");		});
      $('select[id^="StartFit"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="EndFit"]').each(function(){	$(this).attr("disabled","disabled");		});
      $('select[id^="RPFit"]').each(function(){	$(this).attr("disabled","disabled");		});
    }
  }

  function ClickDefineRateApplicable() {

    if ($("#Daily").is(":checked")) {
      $('input[id^="WeekdayMon"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekdayTue"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekdayWed"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekdayThu"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekdayFri"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekdaySat"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekdaySun"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendMon"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendTue"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendWed"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendThu"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendFri"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendSat"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendSun"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="NotApplicableInput"]').each(function(){	$(this).attr("disabled","disabled");	});
    }else if ($("#Weekday").is(":checked")) {
      $('input[id^="WeekdayMon"]').each(function(){	$(this).removeAttr("disabled");	});
      $('input[id^="WeekdayTue"]').each(function(){	$(this).removeAttr("disabled");	});
      $('input[id^="WeekdayWed"]').each(function(){	$(this).removeAttr("disabled");	});
      $('input[id^="WeekdayThu"]').each(function(){	$(this).removeAttr("disabled");	});
      $('input[id^="WeekdayFri"]').each(function(){	$(this).removeAttr("disabled");	});
      $('input[id^="WeekdaySat"]').each(function(){	$(this).removeAttr("disabled");	});
      $('input[id^="WeekdaySun"]').each(function(){	$(this).removeAttr("disabled");	});
      $('input[id^="WeekendMon"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendTue"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendWed"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendThu"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendFri"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendSat"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendSun"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="NotApplicableInput"]').each(function(){	$(this).attr("disabled","disabled");	});
    }else if ($("#Weekend").is(":checked")) {
      $('input[id^="WeekdayMon"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekdayTue"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekdayWed"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekdayThu"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekdayFri"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekdaySat"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekdaySun"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendMon"]').each(function(){	$(this).removeAttr("disabled");	});
      $('input[id^="WeekendTue"]').each(function(){	$(this).removeAttr("disabled");	});
      $('input[id^="WeekendWed"]').each(function(){	$(this).removeAttr("disabled");	});
      $('input[id^="WeekendThu"]').each(function(){	$(this).removeAttr("disabled");	});
      $('input[id^="WeekendFri"]').each(function(){	$(this).removeAttr("disabled");	});
      $('input[id^="WeekendSat"]').each(function(){	$(this).removeAttr("disabled");	});
      $('input[id^="WeekendSun"]').each(function(){	$(this).removeAttr("disabled");	});
      $('input[id^="NotApplicableInput"]').each(function(){	$(this).attr("disabled","disabled");	});
    }else if ($("#NotApplicable").is(":checked")) {
      $('input[id^="WeekdayMon"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekdayTue"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekdayWed"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekdayThu"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekdayFri"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekdaySat"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekdaySun"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendMon"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendTue"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendWed"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendThu"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendFri"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendSat"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="WeekendSun"]').each(function(){	$(this).attr("disabled","disabled");	});
      $('input[id^="NotApplicableInput"]').each(function(){	$(this).removeAttr("disabled");	});
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

  function SaveNewRate() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var url = '{{url('/SaveNewRate')}}';
    var session_ssid = $("#session_ssid").val();
    var session_isid = $("#session_isid").val();
    var hotelid = $("#hotelid").val();

    var RoomCategory = $("#RoomCategory").val();
    var ExtraBedType = $("#ExtraBedType").val();
    var ExtraBedMax = "";
    if (ExtraBedType != "9DA7AA01-98D6-43FD-9AD4-0B53FA1F9999") {
      var ExtraBedMax = $("#ExtraBedMax").val();
    }

    var NumberofBedrooms = "";
    var BedroomFrom = "";
    var BedroomTo = "";
    var slctPriceUnit = "";
    if ($("#BedroomsOne").is(":checked")) {
      NumberofBedrooms = $("#BedroomsOne").val();
      BedroomFrom = "";
      BedroomTo = "";
      slctPriceUnit = "";
    }else if ($("#BedroomsTwo").is(":checked")) {
      NumberofBedrooms = $("#BedroomsTwo").val();
      BedroomFrom = $("#BedroomFrom").val();
      BedroomTo = $("#BedroomTo").val();
      slctPriceUnit = $("#slctPriceUnit").val();
    }else if ($("#BedroomsThree").is(":checked")) {
      NumberofBedrooms = $("#BedroomsThree").val();
      BedroomFrom = $("#BedroomFrom").val();
      BedroomTo = $("#BedroomTo").val();
      slctPriceUnit = $("#slctPriceUnit").val();
    }else if ($("#BedroomsQuad").is(":checked")) {
      NumberofBedrooms = $("#BedroomsQuad").val();
      BedroomFrom = $("#BedroomFrom").val();
      BedroomTo = $("#BedroomTo").val();
      slctPriceUnit = $("#slctPriceUnit").val();
    }

//Additional Charge Type
  var NumType = "";
  var slctAddType = "";
  var slctAddTypeFrom = "";
  var slctAddTypeTo = "";
  var CountNumType = 0;

  if ($("#chkAddType").is(":checked")) {
    var NumType = parseInt($("#NumType").val());
    var DateType = $("#DateType").val();

    var slctAddType = "";
    if (NumType == 1) {
      slctAddType = $("#slctAddType_"+DateType).val();
      slctAddTypeFrom = $("#slctAddTypeFrom_"+DateType).val();
      slctAddTypeTo = $("#slctAddTypeTo_"+DateType).val();
      CountNumType += 1;
    }else {
      var res = DateType.split(",");
      for (var i = 0; i < NumType; i++) {

        if (slctAddType == '') {
          slctAddType = $("#slctAddType_"+res[i]).val();
          slctAddTypeFrom = $("#slctAddTypeFrom_"+res[i]).val();
          slctAddTypeTo = $("#slctAddTypeTo_"+res[i]).val();
          if ($("#slctAddType_"+res[i]).val() != undefined) {
            CountNumType += 1;
          }
        }else {
          slctAddType = slctAddType+','+$("#slctAddType_"+res[i]).val();
          slctAddTypeFrom = slctAddTypeFrom+','+$("#slctAddTypeFrom_"+res[i]).val();
          slctAddTypeTo = slctAddTypeTo+','+$("#slctAddTypeTo_"+res[i]).val();
          if ($("#slctAddType_"+res[i]).val() != undefined) {
            CountNumType += 1;
          }
        }
        slctAddType = slctAddType.replace(',undefined','');
        slctAddTypeFrom = slctAddTypeFrom.replace(',undefined','');
        slctAddTypeTo = slctAddTypeTo.replace(',undefined','');
      }
    }
  }

// Define FIT/GIT
var DefineStart = 0;
var DefineEnd = 0;
var DefineRP = "Room(s)";
var Define = "";
  if ($("#DefineAll").is(":checked")) {
    DefineStart = 0;
    DefineEnd = 0;
    DefineRP = "Room(s)";
    Define = $("#DefineAll").val();
  }else if ($("#DefineFit").is(":checked")) {
    DefineStart = $("#StartFit").val();
    DefineEnd = $("#EndFit").val();
    DefineRP = $("#RPFit").val();
    Define = $("#DefineFit").val();
  }else if ($("#DefineGit").is(":checked")) {
    DefineStart = $("#StartGit").val();
    DefineEnd = $("#EndGit").val();
    DefineRP = $("#RPGit").val();
    Define = $("#DefineGit").val();
  }

//Define Rate Applicable
  var ApplicableType = "";
  var MON = 0;
  var TUE = 0;
  var WED = 0;
  var THU = 0;
  var FRI = 0;
  var SAT = 0;
  var SUN = 0;
  var NotApplicable = "";

  if ($("#Daily").is(":checked")) {
    ApplicableType = $("#Daily").val();
    MON = 0;
    TUE = 0;
    WED = 0;
    THU = 0;
    FRI = 0;
    SAT = 0;
    SUN = 0;
    NotApplicable = "";
  }else if ($("#Weekday").is(":checked")) {
    ApplicableType = $("#Weekday").val();
    MON = $("#WeekdayMon").val();
    TUE = $("#WeekdayTue").val();
    WED = $("#WeekdayWed").val();
    THU = $("#WeekdayThu").val();
    FRI = $("#WeekdayFri").val();
    SAT = $("#WeekdaySat").val();
    SUN = $("#WeekdaySun").val();
    NotApplicable = "";
  }else if ($("#Weekend").is(":checked")) {
    ApplicableType = $("#Weekend").val();
    MON = $("#WeekendMon").val();
    TUE = $("#WeekendTue").val();
    WED = $("#WeekendWed").val();
    THU = $("#WeekendThu").val();
    FRI = $("#WeekendFri").val();
    SAT = $("#WeekendSat").val();
    SUN = $("#WeekendSun").val();
    NotApplicable = "";
  }else if ($("#NotApplicable").is(":checked")) {
    ApplicableType = $("#NotApplicable").val();
    MON = 0;
    TUE = 0;
    WED = 0;
    THU = 0;
    FRI = 0;
    SAT = 0;
    SUN = 0;
    NotApplicable = $("#NotApplicableInput").val();
  }

//Define Market
    var CountTOMarketMaster = $("#CountTOMarketMaster").val();
    var market = "";
    var nummarket = 0;
    if ($("#Worldwide").is(":checked")) {
      market = "";
      nummarket = 0;
    }else if ($("#WorldwideMarket").is(":checked")) {
      for (var i = 1; i <= CountTOMarketMaster; i++) {
        if ($("#wmarket_"+i).is(":checked")) {
          if (market == '') {
            market = $("#wmarket_"+i).val();
          }else {
            market = market+','+$("#wmarket_"+i).val();
          }
          nummarket += 1;
        }
      }
    }else if ($("#Market").is(":checked")) {
      for (var i = 1; i <= CountTOMarketMaster; i++) {
        if ($("#market_"+i).is(":checked")) {
          if (market == '') {
            market = $("#market_"+i).val();
          }else {
            market = market+','+$("#market_"+i).val();
          }
          nummarket += 1;
        }
      }
    }

    var DefineSelect = "";
    if ($("#DefineTo").is(":checked")) {
      DefineSelect = $("#DefineSelect").val();
    }else {
      DefineSelect = "";
    }

    var DefineSeriesTOSelect = "";
    var SeriesStart = 0;
    var SeriesTo = 0;
    var SeriesRP = "Room(s)";
    if ($("#DefineSeriesTO").is(":checked")) {
      DefineSeriesTOSelect = $("#DefineSeriesTOSelect").val();
      if ($("#SeriesNameAll").is(":checked")) {
        SeriesStart = 0;
        SeriesTo = 0;
        SeriesRP = "Room(s)";
      }else if ($("#SeriesNameFit").is(":checked")) {
        SeriesStart = $("#FitStart").val();
        SeriesTo = $("#FitTo").val();
        SeriesRP = $("#FitRP").val();
      }else if ($("#SeriesNameGit").is(":checked")) {
        SeriesStart = $("#GitStart").val();
        SeriesTo = $("#GitTo").val();
        SeriesRP = $("#GitRP").val();
      }
    }else {
      DefineSeriesTOSelect = "";
    }

    var Currency = $("#Currency").val();


    var request = $.ajax({
        url: url,
        method: "POST",
        data: {session_ssid: session_ssid,
              session_isid: session_isid,
              hotelid: hotelid,
              RoomCategory: RoomCategory,
              ExtraBedType: ExtraBedType,
              ExtraBedMax: ExtraBedMax,
              NumberofBedrooms: NumberofBedrooms,
              BedroomFrom: BedroomFrom,
              BedroomTo: BedroomTo,
              slctPriceUnit: slctPriceUnit,
              NumType: NumType,
              slctAddType: slctAddType,
              slctAddTypeFrom: slctAddTypeFrom,
              slctAddTypeTo: slctAddTypeTo,
              CountNumType: CountNumType,
              DefineStart: DefineStart,
              DefineEnd: DefineEnd,
              DefineRP: DefineRP,
              Define: Define,
              ApplicableType: ApplicableType,
              MON: MON,
              TUE: TUE,
              WED: WED,
              THU: THU,
              FRI: FRI,
              SAT: SAT,
              SUN: SUN,
              NotApplicable: NotApplicable,
              CountTOMarketMaster: CountTOMarketMaster,
              market: market,
              nummarket: nummarket,
              DefineSelect: DefineSelect,
              DefineSeriesTOSelect: DefineSeriesTOSelect,
              SeriesStart: SeriesStart,
              SeriesTo: SeriesTo,
              SeriesRP: SeriesRP,
              Currency: Currency,
              _token: CSRF_TOKEN},
              dataType: "text"
            });
            request.done(function(data) {

            });
            request.fail(function(data) {
              Swal.fire('Search Error.', '', 'error');
            });
  }
</script>
@endsection
