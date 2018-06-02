@extends('layouts.master')
@section('title','اضافه نمودن سند')
@section('content')
  <div class="portlet light">
    <div class="portlet-title">

      <div class="caption">
          <i class="fa fa-plus font-green-sharp"></i>
          <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
      </div>
    </div>
    <div class="portlet-body form">
      {{-- print <alerts></alerts> if present --}}
      @component('components.alert')
        @slot('alert_type')
           success
        @endslot
      @endcomponent

          <div class="form-wizard">
            <div class="form-body">
              <ul class="nav nav-pills nav-justified steps">
                <li class="active">
                  <a href="#" class="step active">
                    <span class="number">
                    1 </span>
                    <span class="desc">
                    <i class="fa fa-check"></i> ثبت اسناد </span>
                  </a>
                </li>
                <li>
                  <a href="#" class="step">
                    <span class="number">
                    2 </span>
                    <span class="desc">
                    <i class="fa fa-check"></i> تاییدی اسناد </span>
                  </a>
                </li>
                <li>
                  <a  href="#" class="step">
                    <span class="number">
                    3 </span>
                    <span class="desc">
                    <i class="fa fa-check"></i> جابجایی اسناد </span>
                  </a>
                </li>

              </ul>
              <div id="bar" class="progress progress-striped" role="progressbar">
                <div class="progress-bar progress-bar-success" style="width:5%;">
                </div>
              </div>
          </div>
          <div class="row">
            <div class="col-md-5" id="date_converter">
              <div class="panel panel-info">
                <div class="panel-heading">تبدیل تاریخ</div>
                <div class="panel-body">
                  <div class="form-group">
                    <select class="form-control input-medium" style="" name="convert" id="convert">
                      <option value=" ">نوع تبدیل</option>
                      <option value="1">میلادی به هجری شمسی</option>
                      <option value="2">هجری قمری به هجری شمسی</option>
                    </select>
                  </div>
                  <form class="form-inline margin-top-10" name="islamic"  role="form">
                    <div class="form-group">
                      <input type="number" class="form-control input-xsmall" name="day" placeholder="روز">
                    </div>
                    <div class="form-group">
                      <select class="form-control input-xsmall" name="month">
                        <option value="1">محرم</option>
                        <option value="2">صفر</option>
                        <option value="3">ربیع الاول</option>
                        <option value="4">ربیع الثانی</option>
                        <option value="5">جمادی الاول</option>
                        <option value="6">جمادی الثانی</option>
                        <option value="7">رجب</option>
                        <option value="8">شعبان</option>
                        <option value="9">رمضان</option>
                        <option value="10">شوال</option>
                        <option value="11">ذی القعده</option>
                        <option value="12">ذی الحجه</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <input type="year" class="form-control input-xsmall" name="year" placeholder="سال">
                    </div>
                    <input type="button" onclick="calcIslamic()" class="btn btn-default convert" value="تبدیل">

                    <input type="hidden" name="hour" value="00">
                    <input type="hidden" name="min" value="00">
                    <input type="hidden" name="sec" value="00">
                    <input type="hidden" name="wday">
                    <input type="hidden" name="leap">

                  </form>

                  <form class="form-inline margin-top-10" name="gregorian" role="form">
                    <div class="form-group">
                      <input type="number" class="form-control input-xsmall" name="day" placeholder="روز">
                    </div>
                    <div class="form-group">
                      <select class="form-control input-xsmall" name="month">
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <input type="year" class="form-control input-xsmall" name="year" placeholder="سال">
                    </div>
                    <input type="button" onclick="calcGregorian()" class="btn btn-default convert" value="تبدیل">

                    <input type="hidden" name="hour" value="00">
                    <input type="hidden" name="min" value="00">
                    <input type="hidden" name="sec" value="00">
                    <input type="hidden" name="wday">
                    <input type="hidden" name="leap">

                  </form>
                  <form name="julianday">
                    <input type="hidden" name="day">
                  </form>
                </div>
                <div class="alert alert-success result" style="margin:0;">
                  <p style="text-align:center;">

                    <span id="day"></span> -
                    <span id="month"></span> -
                    <span id="year"></span>
                  </p>
                </div>

              </div>
            </div>
          </div>
          <form role="form" id="entry_form" class="form-horizontal" action="{{route('documents.store')}}" enctype="multipart/form-data" method="post">
              {{csrf_field()}}
          <div class="form-body">
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-3">شماره</label>
                          <div class="col-md-9">
                              <input type="number" name="document_number" lang="en" value="{{old('document_number')}}" placeholder="شماره" class="form-control en">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-3">تاریخ</label>
                          <div class="col-md-9">
                              <input type="text" name="document_date" value="{{old('document_date')}}" placeholder="تاریخ" class="form-control persian_date">
                          </div>
                      </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">نوع سند</label>
                    <div class="col-md-9">
                      <select class="form-control select2" name="document_categories" id="categories_id">
                        {{-- <option value="">نوع سند</option> --}}
                        @foreach ($categories as $item)
                          <option {{$item->id==old('document_categories')?'selected':''}} value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">تعداد اوراق</label>
                    <div class="col-md-9">
                      <input type="number" name="document_page_count" value="{{old('document_page_count')}}" placeholder="تعداد اوراق" class="form-control en">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">مرسل</label>
                    <div class="col-md-9">
                      <select class="form-control select2" name="document_department" id="department_id">
                        <option value="">مرسل</option>
                        @foreach ($departments as $item)
                          <option {{$item->id==old('document_department')?'selected':''}} value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">مرسل الیه </label>
                    <div class="col-md-9">
                      <input type="text" name="receiver" value="{{old('receiver')}}" placeholder="مرسل الیه " class="form-control ">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">موضوع</label>
                    <div class="col-md-9">
                      <textarea name="document_subject" value=""  lang="fa" placeholder="موضوع" rows="2" class="form-control">{{old('document_subject')}}</textarea>
                    </div>
                  </div>
                </div>
              <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">ضمایم</label>
                    <div class="col-md-9">
                      <textarea name="description" value=""  lang="fa" placeholder="ضمایم" rows="2" class="form-control">{{old('description')}}</textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">لسان سند</label>
                    <div class="col-md-9">
                      <select class="form-control select2" name="language_id" >
                        <option value="">لسان سند</option>
                        @foreach ($document_language as $item)
                          @if ($item!=null)
                          <option {{$item->id==old('language_id')?'selected':''}} value="{{$item->id}}">{{$item->language_name}}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6" id="countries" style="display:none;">
                  <div class="form-group">
                    <label class="control-label col-md-3">کشورها</label>
                    <div class="col-md-9">
                    <select id="multiple" class="form-control select2-multiple select2-hidden-accessible" multiple="" tabindex="-1" aria-hidden="true" name="countries[]">
                      <option value="افغانستان">افغانستان</option>
                      <option value="آلبانی ">آلبانی </option>
                      <option value="الجزایر ">الجزایر </option>
                      <option value="آندورا ">آندورا </option>
                      <option value="آنگولا ">آنگولا </option>
                      <option value="آنتیگوا و باربودا ">آنتیگوا و باربودا </option>
                      <option value="آرژانتین ">آرژانتین </option>
                      <option value="ارمنستان ">ارمنستان </option>
                      <option value="استرالیا ">استرالیا </option>
                      <option value="اتریش ">اتریش </option>
                      <option value="آذربایجان ">آذربایجان </option>
                      <option value="باهاما ">باهاما </option>
                      <option value="بحرین ">بحرین </option>
                      <option value="بنگلادش ">بنگلادش </option>
                      <option value="باربادوس ">باربادوس </option>
                      <option value="بلاروس ">بلاروس </option>
                      <option value="بلژیک ">بلژیک </option>
                      <option value="بلیز ">بلیز </option>
                      <option value="بنین ">بنین </option>
                      <option value="پادشاهی بوتان ">پادشاهی بوتان </option>
                      <option value="بولیوی ">بولیوی </option>
                      <option value="بوسنی و هرزگوین ">بوسنی و هرزگوین </option>
                      <option value="بوتسوانا ">بوتسوانا </option>
                      <option value="برزیل ">برزیل </option>
                      <option value="برونئی ">برونئی </option>
                      <option value="بلغارستان ">بلغارستان </option>
                      <option value="بورکینافاسو ">بورکینافاسو </option>
                      <option value="بوروندی ">بوروندی </option>
                      <option value="کامبوج ">کامبوج </option>
                      <option value="کامرون ">کامرون </option>
                      <option value="کانادا ">کانادا </option>
                      <option value="کیپ ورد ">کیپ ورد </option>
                      <option value="جمهوری آفریقای مرکزی ">جمهوری آفریقای مرکزی </option>
                      <option value="چاد ">چاد </option>
                      <option value="شیلی ">شیلی </option>
                      <option value="جمهوری خلق چین ">جمهوری خلق چین </option>
                      <option value="کلمبیا ">کلمبیا </option>
                      <option value="مجمع‌الجزایر قمر ">مجمع‌الجزایر قمر </option>
                      <option value="کاستاریکا ">کاستاریکا </option>
                      <option value="ساحل عاج ">ساحل عاج </option>
                      <option value="کرواسی ">کرواسی </option>
                      <option value="کوبا ">کوبا </option>
                      <option value="قبرس ">قبرس </option>
                      <option value="جمهوری چک ">جمهوری چک </option>
                      <option value="جمهوری دموکراتیک کنگو ">جمهوری دموکراتیک کنگو </option>
                      <option value="دانمارک ">دانمارک </option>
                      <option value="جیبوتی ">جیبوتی </option>
                      <option value="دومینیکا ">دومینیکا </option>
                      <option value="جمهوری دومینیکن ">جمهوری دومینیکن </option>
                      <option value="تیمور شرقی ">تیمور شرقی </option>
                      <option value="اکوادور ">اکوادور </option>
                      <option value="مصر ">مصر </option>
                      <option value="السالوادور ">السالوادور </option>
                      <option value="گینه استوایی ">گینه استوایی </option>
                      <option value="اریتره ">اریتره </option>
                      <option value="استونی ">استونی </option>
                      <option value="اتیوپی ">اتیوپی </option>
                      <option value="فیجی ">فیجی </option>
                      <option value="فنلاند ">فنلاند </option>
                      <option value="فرانسه ">فرانسه </option>
                      <option value="گابن ">گابن </option>
                      <option value="گامبیا ">گامبیا </option>
                      <option value="گرجستان ">گرجستان </option>
                      <option value="آلمان ">آلمان </option>
                      <option value="غنا ">غنا </option>
                      <option value="یونان ">یونان </option>
                      <option value="گرانادا ">گرانادا </option>
                      <option value="گواتمالا ">گواتمالا </option>
                      <option value="گینه ">گینه </option>
                      <option value="گینه بیسائو ">گینه بیسائو </option>
                      <option value="گویان ">گویان </option>
                      <option value="هائیتی ">هائیتی </option>
                      <option value="هندوراس ">هندوراس </option>
                      <option value="مجارستان ">مجارستان </option>
                      <option value="ایسلند ">ایسلند </option>
                      <option value="هندوستان ">هندوستان </option>
                      <option value="اندونزی ">اندونزی </option>
                      <option value="ایران ">ایران </option>
                      <option value="عراق ">عراق </option>
                      <option value="ایرلند ">ایرلند </option>
                      <option value="اسرائیل ">اسرائیل </option>
                      <option value="ایتالیا ">ایتالیا </option>
                      <option value="جامائیکا ">جامائیکا </option>
                      <option value="ژاپن ">ژاپن </option>
                      <option value="اردن ">اردن </option>
                      <option value="قزاقستان ">قزاقستان </option>
                      <option value="کنیا ">کنیا </option>
                      <option value="کیریباتی ">کیریباتی </option>
                      <option value="کویت ">کویت </option>
                      <option value="قرقیزستان ">قرقیزستان </option>
                      <option value="لائوس ">لائوس </option>
                      <option value="لتونی ">لتونی </option>
                      <option value="لبنان ">لبنان </option>
                      <option value="لسوتو ">لسوتو </option>
                      <option value="لیبریا ">لیبریا </option>
                      <option value="لیبی ">لیبی </option>
                      <option value="لیختن اشتاین ">لیختن اشتاین </option>
                      <option value="لیتوانی ">لیتوانی </option>
                      <option value="لوکزامبورگ ">لوکزامبورگ </option>
                      <option value="ماداگاسکار ">ماداگاسکار </option>
                      <option value="مالاوی ">مالاوی </option>
                      <option value="مالزی ">مالزی </option>
                      <option value="مالدیو ">مالدیو </option>
                      <option value="مالی ">مالی </option>
                      <option value="مالت ">مالت </option>
                      <option value="جزایر مارشال ">جزایر مارشال </option>
                      <option value="موریتانی ">موریتانی </option>
                      <option value="موریس ">موریس </option>
                      <option value="مکزیک ">مکزیک </option>
                      <option value="میکرونزی ">میکرونزی </option>
                      <option value="مولدووا ">مولدووا </option>
                      <option value="موناکو ">موناکو </option>
                      <option value="مغولستان ">مغولستان </option>
                      <option value="مونته‌نگرو ">مونته‌نگرو </option>
                      <option value="مراکش ">مراکش </option>
                      <option value="موزامبیک ">موزامبیک </option>
                      <option value="میانمار ">میانمار </option>
                      <option value="نامیبیا ">نامیبیا </option>
                      <option value="نائورو ">نائورو </option>
                      <option value="نپال ">نپال </option>
                      <option value="هلند ">هلند </option>
                      <option value="نیوزیلند ">نیوزیلند </option>
                      <option value="نیکاراگوئه ">نیکاراگوئه </option>
                      <option value="نیجر ">نیجر </option>
                      <option value="نیجریه ">نیجریه </option>
                      <option value="کره شمالی ">کره شمالی </option>
                      <option value="نروژ ">نروژ </option>
                      <option value="عمان ">عمان </option>
                      <option value="پاکستان ">پاکستان </option>
                      <option value="پالائو ">پالائو </option>
                      <option value="پاناما ">پاناما </option>
                      <option value="پاپوآ گینه نو ">پاپوآ گینه نو </option>
                      <option value="پاراگوئه ">پاراگوئه </option>
                      <option value="پرو ">پرو </option>
                      <option value="فیلیپین ">فیلیپین </option>
                      <option value="لهستان ">لهستان </option>
                      <option value="پرتغال ">پرتغال </option>
                      <option value="قطر ">قطر </option>
                      <option value="جمهوری کنگو ">جمهوری کنگو </option>
                      <option value="جمهوری مقدونیه ">جمهوری مقدونیه </option>
                      <option value="رومانی ">رومانی </option>
                      <option value="روسیه ">روسیه </option>
                      <option value="رواندا ">رواندا </option>
                      <option value="سنت کیتس و نویس ">سنت کیتس و نویس </option>
                      <option value="سنت لوسیا ">سنت لوسیا </option>
                      <option value="سنت وینسنت و گرنادین‌ها ">سنت وینسنت و گرنادین‌ها </option>
                      <option value="ساموآ ">ساموآ </option>
                      <option value="سن مارینو ">سن مارینو </option>
                      <option value="سائوتومه و پرینسیپ ">سائوتومه و پرینسیپ </option>
                      <option value="عربستان سعودی ">عربستان سعودی </option>
                      <option value="سنگال ">سنگال </option>
                      <option value="صربستان ">صربستان </option>
                      <option value="سیشل ">سیشل </option>
                      <option value="سیرالئون ">سیرالئون </option>
                      <option value="سنگاپور ">سنگاپور </option>
                      <option value="اسلواکی ">اسلواکی </option>
                      <option value="اسلوونی ">اسلوونی </option>
                      <option value="جزایر سلیمان ">جزایر سلیمان </option>
                      <option value="سومالی ">سومالی </option>
                      <option value="آفریقای جنوبی ">آفریقای جنوبی </option>
                      <option value="کره جنوبی ">کره جنوبی </option>
                      <option value="سودان جنوبی ">سودان جنوبی </option>
                      <option value="اسپانیا ">اسپانیا </option>
                      <option value="سری‌لانکا ">سری‌لانکا </option>
                      <option value="سودان ">سودان </option>
                      <option value="سورینام ">سورینام </option>
                      <option value="سوازیلند ">سوازیلند </option>
                      <option value="سوئد ">سوئد </option>
                      <option value="سوئیس ">سوئیس </option>
                      <option value="سوریه ">سوریه </option>
                      <option value="تاجیکستان ">تاجیکستان </option>
                      <option value="تانزانیا ">تانزانیا </option>
                      <option value="تایلند ">تایلند </option>
                      <option value="توگو ">توگو </option>
                      <option value="تونگا ">تونگا </option>
                      <option value="ترینیداد و توباگو ">ترینیداد و توباگو </option>
                      <option value="تونس ">تونس </option>
                      <option value="بوقلمون ">بوقلمون </option>
                      <option value="ترکمنستان ">ترکمنستان </option>
                      <option value="تووالو ">تووالو </option>
                      <option value="اوگاندا ">اوگاندا </option>
                      <option value="اوکراین ">اوکراین </option>
                      <option value="امارات متحده عربی ">امارات متحده عربی </option>
                      <option value="انگلستان ">انگلستان </option>
                      <option value="ایالات متحده آمریکا ">ایالات متحده آمریکا </option>
                      <option value="اروگوئه ">اروگوئه </option>
                      <option value="ازبکستان ">ازبکستان </option>
                      <option value="وانواتو ">وانواتو </option>
                      <option value="ونزوئلا ">ونزوئلا </option>
                      <option value="ویتنام ">ویتنام </option>
                      <option value="یمن ">یمن </option>
                      <option value="زامبیا ">زامبیا </option>
                      <option value="زیمبابوه ">زیمبابوه </option>

                    </select>
                  </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">اسکن</label>
                    <div class="col-md-9 upload">
                      <a href="#" id="choose_file" class="btn green-jungle scan_or_upload">
                        <i class="icon-picture"></i>
                        انتخاب فایل ها
                      </a>
                      <input id="browse" type="file" multiple name="selected_files[]" value="">
                      {{-- <span>- و یا -</span>
                      <button type="button" class="btn grey-gallery scan_or_upload">
                        <i class="icon-printer"></i>
                        اسکن
                      </button> --}}
                    </div>
                    <div id="images"></div>
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3"></label>
                    <div class="col-md-9" id="count_selected_files">
                      {{-- <a href="#" id="" class="btn green">

                      </a> --}}
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="form-actions">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3"></label>
                  <div class="col-md-9">
                    <button type="submit" class="btn blue">ثبت</button>
                    <button type="reset" href="#" id="reset_form" class="btn red">حذف اطلاعات</button>
                    <a href="{{route('documents.index')}}" class="btn default">بازگشت</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
  </div>
@endsection
@push('custom-css')
  <style media="screen">
    .col-md-9 {
      padding-right: 0;
    }
    .step:not(.active) {
      color: #999;
    }
    .upload span {
      padding: 10px;
    }
    .upload input {
      display: none;
    }

    img.scanned {
        height: 200px; /** Sets the display size */
        margin-right: 12px;
    }
    div#images {
        margin-top: 20px;
    }
    form[name='gregorian'], form[name='persian'], form[name='islamic'], .result {
      display: none;
    }
    #convert, form[name=islamic],form[name=gregorian] {
      margin:auto;
    }
    form[name=islamic],form[name=gregorian] {
      width: 315px;
    }
  </style>

@endpush
@push('custom-js')
  <script>
    //if document type between countries
    $('#categories_id').change(function() {
      var category_id = $('#categories_id').val();
      if(category_id == 10 || category_id == 15 || category_id == 16) {

        $( "#countries" ).show();

      }else{
        $( "#countries" ).hide();

      }
    });



    // scan or upload buttons alternating
    $('.scan_or_upload').click(function() {
      $(this).siblings().not($(this)).addClass('disabled');
    });

    // reset whole form
    $('#reset_form').click(function() {
      // enable upload keys if previously disabled
      $('.scan_or_upload').removeClass('disabled');
      // remove uploaded files count notification
      $('#count_selected_files').hide();

      $('select').find('option:selected').remove()
    });

    // choose multiple files by clicking button
    $('#choose_file').click(function() {
      $('#browse').click();
    });

    // selected file notification & validation
    $(document).ready(function() {
      $('input[type="file"]').change(function () {

        var total_pages = $("input[name='document_page_count']").val()*2;
        var total_selected_files = $(this)[0].files.length;
        // if files more than total pages selected disable submit and show error else show notification
        if(total_selected_files>total_pages) {
          $('#count_selected_files').html("<div class='alert alert-danger'>تعداد فایل ها بیشتر از تعداد اوراق میباشد </div>");
          $('button[type=submit]').addClass('disabled');
        }
        else {
          $('#count_selected_files').html("<div class='alert alert-info'>"+total_selected_files+" فایل انتخاب گردید!!!</div>");
          $('button[type=submit]').removeClass('disabled');
        }
      });

      var width = $(window).width();
      if(width>1351) {
          $('#date_converter').addClass('col-lg-3').removeClass('col-lg-5');
      }
    });





  </script>

@endpush
@push('custom-js')
  <script>
    //  display appropriate date conversion form
    $('#convert').change(function() {
      if($('#convert').val()==' ') {
        $("form[name='gregorian'], form[name='islamic'], .result ").hide();
      }
      else if($('#convert').val()==1) {
        $("form[name='gregorian']").show();
        $("form[name='islamic']").hide();

      }
      else if($('#convert').val()==2) {
        $("form[name='gregorian']").hide();
        $("form[name='islamic']").show();

      }
    });

    //display appropriate result i.e. converted date to shamsi
    $('.convert').click(function() {
      $('.result').show();
    });
  </script>


  <script language="JavaScript" src="{{asset('assets/js/test/astro.js')}}"></script>
  <script language="JavaScript" src="{{asset('assets/js/test/convert.js')}}"></script>

@endpush
