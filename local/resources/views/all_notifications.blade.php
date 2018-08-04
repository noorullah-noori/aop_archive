@extends('layouts.master')
@section('title','اطلاعیه ها')
@section('content')
  <div class="portlet light">
      <div class="portlet-title tabbable-line">
          <ul class="nav nav-tabs">
              <li class="active">
                  <a href="#tab_1_1" data-toggle="tab">
                    جدید
                   </a>
              </li>
              <li>
                  <a href="#tab_1_2" data-toggle="tab">
                خوانده شده</a>
              </li>
          </ul>
      </div>
      <div class="portlet-body">
          <!--BEGIN TABS-->
          <div class="tab-content">
              <div class="tab-pane active" id="tab_1_1">
                  <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 320px;"><div class="scroller" style="height: 320px; overflow: hidden; width: auto;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" data-initialized="1">
                      <ul class="feeds">
                        @foreach ($unread as $item)
                          <li>
                            <a onclick="markAsRead('{{$item->id}}', {{isset($item->data['document_id']) ? $item->data['document_id'] : '""'}}, '{{$item->data['notification_type']}}')" href="javascript:;">
                              <div class="col1">
                                <div class="cont">
                                  <div class="cont-col1">
                                    <div class="label label-sm label-{{$item->data['alert_type']}}">
                                      <i class="fa fa-{{$item->data['alert_type']=='success'?'bell-o':'bolt'}}"></i>
                                    </div>
                                  </div>
                                  <div class="cont-col2">
                                    <div class="desc">
                                      {{$item->data['notification']}}
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col2">
                                <div class="date">
                                  {{$item->created_at->diffForHumans()}}
                                </div>
                              </div>
                            </a>
                          </li>
                        @endforeach
                      </ul>
                  </div>
                  <div class="slimScrollBar" style="background: rgb(215, 220, 226); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 169.256px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(234, 234, 234); opacity: 0.2; z-index: 90; right: 1px;">

                  </div>
                </div>
              </div>
              <div class="tab-pane" id="tab_1_2">
                  <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 337px;"><div class="scroller" style="height: 337px; overflow: hidden; width: auto;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" data-initialized="1">
                      <ul class="feeds">
                        @foreach ($read as $item)
                          <li>
                            <a onclick="" href="javascript:;">
                              <div class="col1">
                                <div class="cont">
                                  <div class="cont-col1">
                                    <div class="label label-sm label-{{$item->data['alert_type']}}">

                                      <i class="fa fa-{{$item->data['alert_type']=='success'?'bell-o':'bolt'}}"></i>
                                    </div>
                                  </div>
                                  <div class="cont-col2">
                                    <div class="desc">
                                      {{$item->data['notification']}}
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col2">
                                <div class="date">
                                  {{$item->created_at->diffForHumans()}}
                                </div>
                              </div>
                            </a>
                          </li>
                        @endforeach
                      </ul>
                  </div>
                  <div class="slimScrollBar" style="background: rgb(215, 220, 226); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(234, 234, 234); opacity: 0.2; z-index: 90; right: 1px;">

                  </div>
                </div>
              </div>
          </div>
          <!--END TABS-->
      </div>
  </div>

@endsection
@push('custom-css')
  <style media="screen">
    .feeds li .col1 {
      float: right;
      width: 100%;
      clear: both;
    }
    .feeds li .col1 > .cont {
        float: right;
        margin-right: 75px;
        overflow: hidden;
    }
    .feeds li .col2 {
      float: right;
      width: 100px;
      margin-left: -100px;
      margin-right: -100px;
    }
    .feeds li .col1 > .cont > .cont-col1 {
        float: right;
        margin-right: 0;
    }
  </style>
@endpush
