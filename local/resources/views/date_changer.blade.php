
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/elonat.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="" content="mahmoodkamen,afghan clothing london,afghans in london,paiwand news,for afghans in london,afghan students,scholarship for afghan students,afghanpersonals,kabul university age entry ,ariana tv online,afghan student association uk,afghan london uk,afghan student,afghan maihan,forum for afghans in london,pashto job london,farhad darya.info,afghanistan pashto dari controversy,afghans at university of brighton,british afghan business association,scholarships for afghan students,kabul sport,hammasa kohistani,chevening afghan 2007,afghan,websites,afghan.net,afghan education university results,afghan women, afghan translters,afghanan,afghana,pashto,pashtu,dari,farsi,persion,afghan elonat,elonat,yama,qrabahg,ariana tv,ariana afghanistan tv " />
<meta name="description" content="Elonat.com is the largest online Afghan and Iranian business finder. Our Vision is to become the largest and comprehensive search engine for Afghan and Iranian businesses in the UK. We aim to build on the success of our technology and continue to deliver innovative, leading-edge and cost-effective solutions to consumer, Afghan and Iranian business. Our Magazine, Elonat magazine is printing once every month, to support networking Afghan and Iranian businesses and organisations. For more info conatct sales@elonat.com
" />
<link rel="SHORTCUT ICON" href="images/elonat.ico" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Elonat &#1575;&#1593;&#1604;&#1575;&#1606;&#1575;&#1578; | Afghan & Iranian Advertising in London</title>
<!-- InstanceEndEditable -->

<!-- InstanceBeginEditable name="head" -->

<meta name="keywords" content="Calendar, Converter, Gregorian, Jalali, Islamic, Solar, Lunar">
<meta name="description" content="Calendar Converter">

<script language="JavaScript" src="{{asset('assets/test/astro.js')}}">
</script>

<script language="JavaScript">
<!--

/*  You may notice that a variety of array variables logically local
    to functions are declared globally here.  In JavaScript, construction
    of an array variable from source code occurs as the code is
    interpreted.  Making these variables pseudo-globals permits us
    to avoid overhead constructing and disposing of them in each
    call on the function in which they are used.  */

var J0000 = 1721424.5;                // Julian date of Gregorian epoch: 0000-01-01
var J1970 = 2440587.5;                // Julian date at Unix epoch: 1970-01-01
var JMJD  = 2400000.5;                // Epoch of Modified Julian Date system
var J1900 = 2415020.5;                // Epoch (day 1) of Excel 1900 date system (PC)
var J1904 = 2416480.5;                // Epoch (day 0) of Excel 1904 date system (Mac)

var NormLeap = new Array("Normal year", "Leap year");

/*  WEEKDAY_BEFORE  --  Return Julian date of given weekday (0 = Sunday)
                        in the seven days ending on jd.  */

function weekday_before(weekday, jd)
{
    return jd - jwday(jd - weekday);
}

/*  SEARCH_WEEKDAY  --  Determine the Julian date for:

            weekday      Day of week desired, 0 = Sunday
            jd           Julian date to begin search
            direction    1 = next weekday, -1 = last weekday
            offset       Offset from jd to begin search
*/

function search_weekday(weekday, jd, direction, offset)
{
    return weekday_before(weekday, jd + (direction * offset));
}

//  Utility weekday functions, just wrappers for search_weekday

function nearest_weekday(weekday, jd)
{
    return search_weekday(weekday, jd, 1, 3);
}

function next_weekday(weekday, jd)
{
    return search_weekday(weekday, jd, 1, 7);
}

function next_or_current_weekday(weekday, jd)
{
    return search_weekday(weekday, jd, 1, 6);
}

function previous_weekday(weekday, jd)
{
    return search_weekday(weekday, jd, -1, 1);
}

function previous_or_current_weekday(weekday, jd)
{
    return search_weekday(weekday, jd, 1, 0);
}

function TestSomething()
{
}

//  LEAP_GREGORIAN  --  Is a given year in the Gregorian calendar a leap year ?

function leap_gregorian(year)
{
    return ((year % 4) == 0) &&
            (!(((year % 100) == 0) && ((year % 400) != 0)));
}

//  GREGORIAN_TO_JD  --  Determine Julian day number from Gregorian calendar date

var GREGORIAN_EPOCH = 1721425.5;

function gregorian_to_jd(year, month, day)
{
    return (GREGORIAN_EPOCH - 1) +
           (365 * (year - 1)) +
           Math.floor((year - 1) / 4) +
           (-Math.floor((year - 1) / 100)) +
           Math.floor((year - 1) / 400) +
           Math.floor((((367 * month) - 362) / 12) +
           ((month <= 2) ? 0 :
                               (leap_gregorian(year) ? -1 : -2)
           ) +
           day);
}

//  JD_TO_GREGORIAN  --  Calculate Gregorian calendar date from Julian day

function jd_to_gregorian(jd) {
    var wjd, depoch, quadricent, dqc, cent, dcent, quad, dquad,
        yindex, dyindex, year, yearday, leapadj;

    wjd = Math.floor(jd - 0.5) + 0.5;
    depoch = wjd - GREGORIAN_EPOCH;
    quadricent = Math.floor(depoch / 146097);
    dqc = mod(depoch, 146097);
    cent = Math.floor(dqc / 36524);
    dcent = mod(dqc, 36524);
    quad = Math.floor(dcent / 1461);
    dquad = mod(dcent, 1461);
    yindex = Math.floor(dquad / 365);
    year = (quadricent * 400) + (cent * 100) + (quad * 4) + yindex;
    if (!((cent == 4) || (yindex == 4))) {
        year++;
    }
    yearday = wjd - gregorian_to_jd(year, 1, 1);
    leapadj = ((wjd < gregorian_to_jd(year, 3, 1)) ? 0
                                                  :
                  (leap_gregorian(year) ? 1 : 2)
              );
    month = Math.floor((((yearday + leapadj) * 12) + 373) / 367);
    day = (wjd - gregorian_to_jd(year, month, 1)) + 1;

    return new Array(year, month, day);
}

//  ISO_TO_JULIAN  --  Return Julian day of given ISO year, week, and day

function n_weeks(weekday, jd, nthweek)
{
    var j = 7 * nthweek;

    if (nthweek > 0) {
        j += previous_weekday(weekday, jd);
    } else {
        j += next_weekday(weekday, jd);
    }
    return j;
}

function iso_to_julian(year, week, day)
{
    return day + n_weeks(0, gregorian_to_jd(year - 1, 12, 28), week);
}

//  JD_TO_ISO  --  Return array of ISO (year, week, day) for Julian day

function jd_to_iso(jd)
{
    var year, week, day;

    year = jd_to_gregorian(jd - 3)[0];
    if (jd >= iso_to_julian(year + 1, 1, 1)) {
        year++;
    }
    week = Math.floor((jd - iso_to_julian(year, 1, 1)) / 7) + 1;
    day = jwday(jd);
    if (day == 0) {
        day = 7;
    }
    return new Array(year, week, day);
}

//  ISO_DAY_TO_JULIAN  --  Return Julian day of given ISO year, and day of year

function iso_day_to_julian(year, day)
{
    return (day - 1) + gregorian_to_jd(year, 1, 1);
}

//  JD_TO_ISO_DAY  --  Return array of ISO (year, day_of_year) for Julian day

function jd_to_iso_day(jd)
{
    var year, day;

    year = jd_to_gregorian(jd)[0];
    day = Math.floor(jd - gregorian_to_jd(year, 1, 1)) + 1;
    return new Array(year, day);
}

/*  PAD  --  Pad a string to a given length with a given fill character.  */

function pad(str, howlong, padwith) {
    var s = str.toString();

    while (s.length < howlong) {
        s = padwith + s;
    }
    return s;
}

//  LEAP_ISLAMIC  --  Is a given year a leap year in the Islamic calendar ?

function leap_islamic(year)
{
    return (((year * 11) + 14) % 30) < 11;
}

//  ISLAMIC_TO_JD  --  Determine Julian day from Islamic date

var ISLAMIC_EPOCH = 1948439.5;
var ISLAMIC_WEEKDAYS = new Array("al-'ahad", "al-'ithnayn",
                                 "ath-thalatha'", "al-'arb`a'",
                                 "al-khamis", "al-jum`a", "as-sabt");

function islamic_to_jd(year, month, day)
{
    return (day +
            Math.ceil(29.5 * (month - 1)) +
            (year - 1) * 354 +
            Math.floor((3 + (11 * year)) / 30) +
            ISLAMIC_EPOCH) - 1;
}

//  JD_TO_ISLAMIC  --  Calculate Islamic date from Julian day

function jd_to_islamic(jd)
{
    var year, month, day;

    jd = Math.floor(jd) + 0.5;
    year = Math.floor(((30 * (jd - ISLAMIC_EPOCH)) + 10646) / 10631);
    month = Math.min(12,
                Math.ceil((jd - (29 + islamic_to_jd(year, 1, 1))) / 29.5) + 1);
    day = (jd - islamic_to_jd(year, month, 1)) + 1;
    return new Array(year, month, day);
}

//  LEAP_PERSIAN  --  Is a given year a leap year in the Persian calendar ?

function leap_persian(year)
{
    return ((((((year - ((year > 0) ? 474 : 473)) % 2820) + 474) + 38) * 682) % 2816) < 682;
}

//  PERSIAN_TO_JD  --  Determine Julian day from Persian date

var PERSIAN_EPOCH = 1948320.5;
var PERSIAN_WEEKDAYS = new Array("Yekshanbeh", "Doshanbeh",
                                 "Seshhanbeh", "Chaharshanbeh",
                                 "Panjshanbeh", "Jomeh", "Shanbeh");

function persian_to_jd(year, month, day)
{
    var epbase, epyear;

    epbase = year - ((year >= 0) ? 474 : 473);
    epyear = 474 + mod(epbase, 2820);

    return day +
            ((month <= 7) ?
                ((month - 1) * 31) :
                (((month - 1) * 30) + 6)
            ) +
            Math.floor(((epyear * 682) - 110) / 2816) +
            (epyear - 1) * 365 +
            Math.floor(epbase / 2820) * 1029983 +
            (PERSIAN_EPOCH - 1);
}

//  JD_TO_PERSIAN  --  Calculate Persian date from Julian day

function jd_to_persian(jd)
{
    var year, month, day, depoch, cycle, cyear, ycycle,
        aux1, aux2, yday;


    jd = Math.floor(jd) + 0.5;

    depoch = jd - persian_to_jd(475, 1, 1);
    cycle = Math.floor(depoch / 1029983);
    cyear = mod(depoch, 1029983);
    if (cyear == 1029982) {
        ycycle = 2820;
    } else {
        aux1 = Math.floor(cyear / 366);
        aux2 = mod(cyear, 366);
        ycycle = Math.floor(((2134 * aux1) + (2816 * aux2) + 2815) / 1028522) +
                    aux1 + 1;
    }
    year = ycycle + (2820 * cycle) + 474;
    if (year <= 0) {
        year--;
    }
    yday = (jd - persian_to_jd(year, 1, 1)) + 1;
    month = (yday <= 186) ? Math.ceil(yday / 31) : Math.ceil((yday - 6) / 30);
    day = (jd - persian_to_jd(year, month, 1)) + 1;
    return new Array(year, month, day);
}

/*  updateFromGregorian  --  Update all calendars from Gregorian.
                             "Why not Julian date?" you ask.  Because
                             starting from Gregorian guarantees we're
                             already snapped to an integral second, so
                             we don't get roundoff errors in other
                             calendars.  */

function updateFromGregorian()
{
    var j, year, mon, mday, hour, min, sec,
        weekday, julcal, hebcal, islcal, hmindex, utime, isoweek,
        may_countcal, mayhaabcal, maytzolkincal, bahcal, frrcal,
        indcal, isoday, xgregcal;

    year = new Number(document.gregorian.year.value);
    mon = document.gregorian.month.selectedIndex;
    mday = new Number(document.gregorian.day.value);
    hour = min = sec = 0;
    hour = new Number(document.gregorian.hour.value);
    min = new Number(document.gregorian.min.value);
    sec = new Number(document.gregorian.sec.value);

    //  Update Julian day

    j = gregorian_to_jd(year, mon + 1, mday) +
           ((sec + 60 * (min + 60 * hour)) / 86400.0);

    //  Update day of week in Gregorian box

    weekday = jwday(j);
    document.gregorian.wday.value = Weekdays[weekday];

    //  Update leap year status in Gregorian box

    document.gregorian.leap.value = NormLeap[leap_gregorian(year) ? 1 : 0];

    //  Update Islamic Calendar

    islcal = jd_to_islamic(j);
    document.islamic.year.value = islcal[0];
    document.islamic.month.selectedIndex = islcal[1] - 1;
    document.islamic.day.value = islcal[2];
    document.islamic.wday.value = "yawm " + ISLAMIC_WEEKDAYS[weekday];
    document.islamic.leap.value = NormLeap[leap_islamic(islcal[0]) ? 1 : 0];

    //  Update Persian Calendar

    perscal = jd_to_persian(j);
    document.persian.year.value = perscal[0];
    document.persian.month.selectedIndex = perscal[1] - 1;
    document.persian.day.value = perscal[2];
    document.persian.wday.value = PERSIAN_WEEKDAYS[weekday];
    document.persian.leap.value = NormLeap[leap_persian(perscal[0]) ? 1 : 0];
}

//  calcGregorian  --  Perform calculation starting with a Gregorian date

function calcGregorian()
{
    updateFromGregorian();
}

//  calcJulian  --  Perform calculation starting with a Julian date

function calcJulian()
{
    var j, date, time;

    j = new Number(document.julianday.day.value);
    date = jd_to_gregorian(j);
    time = jhms(j);
    document.gregorian.year.value = date[0];
    document.gregorian.month.selectedIndex = date[1] - 1;
    document.gregorian.day.value = date[2];
    document.gregorian.hour.value = pad(time[0], 2, " ");
    document.gregorian.min.value = pad(time[1], 2, "0");
    document.gregorian.sec.value = pad(time[2], 2, "0");
    updateFromGregorian();
}

//  setJulian  --  Set Julian date and update all calendars

function setJulian(j)
{
    document.julianday.day.value = new Number(j);
    calcJulian();
}

//  calcJulianCalendar  --  Update from Julian calendar

function calcJulianCalendar()
{
    setJulian(julian_to_jd((new Number(document.juliancalendar.year.value)),
                           document.juliancalendar.month.selectedIndex + 1,
                           (new Number(document.juliancalendar.day.value))));
}

//  calcIslamic  --  Update from Islamic calendar

function calcIslamic()
{
    setJulian(islamic_to_jd((new Number(document.islamic.year.value)),
                           document.islamic.month.selectedIndex + 1,
                           (new Number(document.islamic.day.value))));
}

//  calcPersian  --  Update from Persian calendar

function calcPersian()
{
    setJulian(persian_to_jd((new Number(document.persian.year.value)),
                           document.persian.month.selectedIndex + 1,
                           (new Number(document.persian.day.value))));
}

//  calcGregSerial  --  Update from Gregorian serial day number

function calcGregSerial()
{
    setJulian((new Number(document.gregserial.day.value)) + J0000);
}

// -->
</script>


<script language="JavaScript">
<!--
function openWindow(url, name, width, height)
{
 popupWin = window.open(url, name, "width="+width+",height="+height+", toolbar=no, scrollbars=no, menubar=no, status=no, left=5, top=5");
}
//-->
</script>
<!-- InstanceEndEditable -->
<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>
<link href="css/mainsite.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #FFF;
}
-->
</style></head>

<body>

<div align="center">
<p>
  <script>
<!--
          function openWindow(url, w, h) {
            var options = "width=" + w + ",height=" + h + ",";
            options += "resizable=no,scrollbars=yes,status=no,";
            options += "menubar=no,toolbar=no,location=no,directories=no";
            var newWin = window.open(url, 'newWin', options);
            newWin.focus();
          }
//-->
</script>
</p>
<p>&nbsp;</p>
<table width="100%" align="center" border="0" cellspacing="0" class="tableborder">
  <tr>
  <td align="center" valign="top">

  <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <!--*** body ***-->

    <td class="fontiran" align="center" valign="top">
      <img src="images/sponcered bunners/afg-calendar-banner.jpg" alt="" width="950" height="118" border="0" /><br>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="640" align="left" valign="top" class="fontiran">
            <form name="julianday">
              <input type="hidden" name="day" value="" size="16">
            </form>
            <p>&nbsp;</p>
            <p><strong>You can convert any date, from Afghan to Gregorian or Arabic or back from Gregorian or Arabic to Afghan calendar, just enter the desirable date and click calculate!
            </strong></p>
            <hr noshade>
            <!-- PERSIAN CALENDAR -->
            <strong>Shamsi Calendar</strong><br>
            <form name="persian">
              <table width="100%" bgcolor="#f5f5f5" border="0" cellspacing="0" cellpadding="0" style="border-right: #aaaaaa 1px solid; border-top: #aaaaaa 1px solid; border-left: #aaaaaa 1px solid; border-bottom: #aaaaaa 1px solid">
                <tr>
                  <td width="100%" align="left" colspan="3"></td>
                  </tr>
                <tr>
                  <td width="25%" class="fontiran" align="right"><b>Date:</b></td>
                  <td width="40%" class="fontiran" align="left">
                    <input type="text" name="year" value="" size="5">
                    <select name=month size=1>
                      <option value=1>Hamal
                        <option value=2>Sawour
                          <option value=3>Jowza
                            <option value=4>Sarataan
                              <option value=5>Asad
                                <option value=6>Saunbola
                                  <option value=7>Meezan
                                    <option value=8>Hagrab
                                    <option value=9>Qows
                                    <option value=10>Jady
                                    <option value=11>Dawlo
                                    <option value=12>Hoot
                                  </select>
                    <input type="text" name="day" value="" size="3"></td>
                  <td width="35%" class="fontiran" align="left"><input type="text" name="leap" value="" size="12" class=ctr readonly></td>
                  </tr>
                <tr>
                  <td width="100%" align="left" colspan="3"></td>
                  </tr>
                <tr>
                  <td width="25%" class="fontiran" align="right"><b>Weekday:</b></td>
                  <td width="40%" class="fontiran" align="left"><input type="text" name="wday" value="" size="13" class=ctr readonly></td>
                  <td width="35%" class="fontiran1" align="left"><input type="button" value="Calculate" onClick="calcPersian();">  To other Calendars</td>
                  </tr>
                <tr>
                  <td width="100%" align="right" colspan="3"></td>
                  </tr>
                </table>
              </form>
            <br><br>



            <!-- GREGORIAN CALENDAR -->
<strong>Gregorian Calendar
            </strong><br>
<form name="gregorian">
  <table width="100%" bgcolor="#f5f5f5" border="0" cellspacing="0" cellpadding="0" style="border-right: #aaaaaa 1px solid; border-top: #aaaaaa 1px solid; border-left: #aaaaaa 1px solid; border-bottom: #aaaaaa 1px solid">
    <tr>
      <td width="100%" align="left" colspan="3"></td>
      </tr>
    <tr>
      <td width="25%" class="fontiran" align="right"><strong>Date:</strong></td>
      <td width="40%" class="fontiran" align="left">
        <strong>
          <input type="text" name="year" value="1998" size="4" style="border: #aaaaaa 1px solid; background-color: #ffffff">
          <select name=month size="1">
            <option value=1>January
              <option value=2>February
                <option value=3>March
                  <option value=4>April

                    <option value=5>May
                      <option value=6>June
                        <option value=7>July
                          <option value=8>August
                            <option value=9>September
                              <option value=10>October
                                <option value=11>November
                                  <option value=12>December
                                  </select>
          <input type="text" name="day" value="1" size="2" style="border: #aaaaaa 1px solid; background-color: #ffffff">
          </strong></td>
      <td width="35%" class="fontiran" align="left"><strong>
        <input type="text" name="leap" value="" size="12"  style="border: #aaaaaa 1px solid; background-color: #ffffff" readonly>
        </strong></td>
      </tr>
    <tr>
      <td width="100%" align="left" colspan="3"></td>
      </tr>
    <input type="hidden" name="hour" value="00" size="2"><input type="hidden" name="min" value="00" size="2"><input type="hidden" name="sec" value="00" size="2">
    <tr>
      <td width="100%" align="left" colspan="3"></td>
      </tr>
    <tr>
      <td width="25%" class="fontiran" align="right"><strong>Weekday:</strong></td>
      <td width="40%" class="fontiran" align="left"><strong>
        <input type="text" name="wday" value="" size="16" style="border: #aaaaaa 1px solid; background-color: #ffffff" readonly>
        </strong></td>
      <td width="35%" class="fontiran1" align="left"><strong>
        <input type="button" value="Calculate" onClick="calcGregorian();">
        To other Calendars</strong></td>
      </tr>
    <tr>
      <td width="100%" align="left" colspan="3"></td>
      </tr>
    </table>
</form>
            <br><br>


            <!-- ISLAMIC CALENDAR -->
            <strong>Islamic Calendar</strong> (Hijri Calendar)
<form name="islamic">
              <table width="100%" bgcolor="#f5f5f5" border="0" cellspacing="0" cellpadding="0" style="border-right: #aaaaaa 1px solid; border-top: #aaaaaa 1px solid; border-left: #aaaaaa 1px solid; border-bottom: #aaaaaa 1px solid">
                <tr>
                  <td width="100%" align="left" colspan="3"></td>
                  </tr>
                <tr>
                  <td width="25%" class="fontiran" align="right"><b>Date:</b></td>
                  <td width="40%" class="fontiran" align="left">
                    <input type="text" name="year" value="1998" size="4" style="border: #aaaaaa 1px solid; background-color: #ffffff">
                    <select name=month size="1">
                      <option value=1>Muharram
                        <option value=2>Safar
                          <option value=3>Rabi`al-Awwal
                            <option value=4>Rabi`ath-Thani
                              <option value=5>Jumada l-Ula
                                <option value=6>Jumada t-Tania
                                  <option value=7>Rajab
                                    <option value=8>Sha`ban
                                    <option value=9>Ramadan
                                    <option value=10>Shawwal
                                    <option value=11>Dhu l-Qa`da
                                    <option value=12>Dhu l-Hijja
                                  </select>
                    <input type="text" name="day" value="1" size="2" style="border: #aaaaaa 1px solid; background-color: #ffffff"></td>
                  <td width="35%" class="fontiran" align="left"><input type="text" name="leap" value="" size="12"  style="border: #aaaaaa 1px solid; background-color: #ffffff" readonly></td>
                  </tr>
                <tr>
                  <td width="100%" align="left" colspan="3"></td>
                  </tr>
                <tr>
                  <td width="25%" class="fontiran" align="right"><b>Weekday:</b></td>
                  <td width="40%" class="fontiran" align="left"><input type="text" name="wday" value="" size="16" style="border: #aaaaaa 1px solid; background-color: #ffffff" readonly></td>
                  <td width="35%" class="fontiran1" align="left"><input type="button" value="Calculate" onClick="calcIslamic();">  To other Calendars</td>
                  </tr>
                <tr>
                  <td width="100%" align="left" colspan="3"></td>
                  </tr>
                </table>
              <p>&nbsp;</p>
              </form></td>
          </tr>
        </table>

      </td>
  </tr>
  </table>

  <!--*** bottom ***-->

  </td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
  <script language="JavaScript">
<!--

    //  A little JavaScript action to preset the fields in
    //  the request form to today's date.

    var today = new Date();

    /*  The following idiocy is due to bizarre incompatibilities
        in the behaviour of getYear() between Netscrape and
        Exploder.  The ideal solution is to use getFullYear(),
        which returns the actual year number, but that would
        break this code on versions of JavaScript prior to
        1.2.  So, for the moment we use the following code
        which works for all versions of JavaScript and browsers
        for all year numbers greater than 1000.  When we're willing
        to require JavaScript 1.2, this may be replaced by
        the single line:

            document.gregorian.year.value = today.getFullYear();

        Thanks to Larry Gilbert for pointing out this problem.
    */

    var y = today.getYear();
    if (y < 1000) {
        y += 1900;
    }
    document.gregorian.year.value = y

    document.gregorian.month.selectedIndex = today.getMonth();
    document.gregorian.day.value = today.getDate();
// -->
  </script>
</div>

<script language="JavaScript">
<!--
    calcGregorian();                  // Calculate today's values in other calendars
// -->
  </script><!-- InstanceEndEditable --></td>
  </tr>

</table>

</body>
</html>
