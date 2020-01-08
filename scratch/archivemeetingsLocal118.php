<?php

$files[] = ['path' => "meetings/2016/July 2016 NOM.pdf", 'title' => "28 July 2016"];
$files[] = ['path' => "meetings/2016/June 2016 NOM.pdf", 'title' => "27 June 2016"];
$files[] = ['path' => "meetings/2016/Supplemental NOM May 2016.pdf", 'title' => "16 May 2016 - Amended"];


foreach ($files as $file)
{

    $document = '';
    $date = '';

    $document = explode('/', $file['path']);

    $date = explode(" ", $file['title']);

    $date = $date[0] . " " . $date[1];

    $date = date_format(new DateTime(trim($date)),  'Y-m-d H:i:s');

    $result[] = ['path' => $file['path'],
        'file' => $document[2],
        'title' => trim($file['title']),
        'date' => $date];
}

print_r($result);





exit();
$files[] = ['path' => "meetings/2016/NOM May 2016.pdf", 'title' => "16 May 2016"];
$files[] = ['path' => "meetings/2016/NOM March 2016.pdf", 'title' => "30 March 2016"];
$files[] = ['path' => "meetings/2016/NOM February 2016.pdf", 'title' => "26 February 2016"];
$files[] = ['path' => "meetings/2016/NOM February 2016.pdf", 'title' => "22 February 2016 Special"];
$files[] = ['path' => "meetings/2016/January 14, 2016 NOM.pdf", 'title' => "14 January 2016"];

$files[] = ['path' => "meetings/2015/December 2015 Notice of General Meeting.pdf", 'title' => "30 December 2015"];
$files[] = ['path' => "meetings/2015/November 2015 Notice of General Meeting.pdf", 'title' => "30 November 2015"];
$files[] = ['path' => "meetings/2015/notice26oct15.pdf", 'title' => "26 October 2015"];
$files[] = ['path' => "meetings/2015/notice24aug15.pdf", 'title' => "24 August 2015"];
$files[] = ['path' => "meetings/2015/notice21jul15.pdf", 'title' => "21 July 2015"];
$files[] = ['path' => "meetings/2015/notice29may15.pdf", 'title' => "29 May 2015"];
$files[] = ['path' => "meetings/2015/notice27apr15.pdf", 'title' => "27 April 2015"];
$files[] = ['path' => "meetings/2015/notice27mar15.pdf", 'title' => "27 March 2015"];
$files[] = ['path' => "meetings/2015/notice28feb15.pdf", 'title' => "28 February 2015"];
$files[] = ['path' => "meetings/2015/notice24jan15.pdf", 'title' => "24 January 2015"];

$files[] = ['path' => "meetings/2014/notice30dec14.pdf", 'title' => "30 December 2014"];
$files[] = ['path' => "meetings/2014/notice28nov14.pdf", 'title' => "28 November 2014"];
$files[] = ['path' => "meetings/2014/notice24oct14.pdf", 'title' => "24 October 2014"];
$files[] = ['path' => "meetings/2014/notice27sep14.pdf", 'title' => "27 September 2014"];
$files[] = ['path' => "meetings/2014/notice31may14.pdf", 'title' => "31 May 2014"];
$files[] = ['path' => "meetings/2014/notice26apr14.pdf", 'title' => "26 April 2014"];
$files[] = ['path' => "meetings/2014/notice29mar14.pdf", 'title' => "29 March 2014"];
$files[] = ['path' => "meetings/2014/notice28feb14.pdf", 'title' => "28 February 2014"];
$files[] = ['path' => "meetings/2014/notice29jan14and salaries.pdf", 'title' => "29 January 2014"];

$files[] = ['path' => "meetings/2013/notice30dec13.pdf", 'title' => "30 December 2013"];
$files[] = ['path' => "meetings/2013/notice29nov13.pdf", 'title' => "29 November 2013"];
$files[] = ['path' => "meetings/2013/notice30oct13.pdf", 'title' => "30 October 2013"];
$files[] = ['path' => "meetings/2013/notice27sep13.pdf", 'title' => "27 September 2013"];
$files[] = ['path' => "meetings/2013/notice12jul13.pdf", 'title' => "12 July 2013"];
$files[] = ['path' => "meetings/2013/notice27may13.pdf", 'title' => "27 May 2013"];
$files[] = ['path' => "meetings/2013/notice18mar13.pdf", 'title' => "18 March 2013"];
$files[] = ['path' => "meetings/2013/notice21feb13.pdf", 'title' => "21 February 2013"];
$files[] = ['path' => "meetings/2013/notice17jan13.pdf", 'title' => "17 January 2013"];

$files[] = ['path' => "meetings/2012/notice20dec12.pdf", 'title' => "20 December 2012"];
$files[] = ['path' => "docs/dec-jan2013noticeof meetings.pdf", 'title' => "1 December 2012 - Dec/Jan Advance Notice of Meetings"];
$files[] = ['path' => "meetings/2012/notice15nov12.pdf", 'title' => "15 November 2012"];
$files[] = ['path' => "meetings/2012/Notice of meetings Oct 2012.pdf", 'title' => "01 October 2012 - October Meetings"];
$files[] = ['path' => "meetings/2012/notice13jul12.pdf", 'title' => "13 July 2012"];
$files[] = ['path' => "meetings/2012/notice27jun12.pdf", 'title' => "27 June 2012"];
$files[] = ['path' => "meetings/2012/notice24apr01may2012.pdf", 'title' => "24 April 2012 - (Special) 1 May (General) 2 pages (INCLUDED: Memorandum of agreement between Richmond Gateway Theatre and IATSE Local 118 December 2011)"];
$files[] = ['path' => "meetings/2012/notice27mar12.pdf", 'title' => "27 March 2012"];
$files[] = ['path' => "meetings/2012/notice31jan12.pdf", 'title' => "31 January 2012"];

$files[] = ['path' => "meetings/2011/notice30nov11.pdf", 'title' => "30 November 2011"];

$files[] = ['path' => "meetings/2011/notice07nov11.pdf", 'title' => "7 November 2011"];
$files[] = ['path' => "meetings/2011/notice29sep11.pdf", 'title' => "29 September 2011"];
$files[] = ['path' => "meetings/2011/notice29mar11.pdf", 'title' => "29 March 2011"];
$files[] = ['path' => "meetings/2011/notice22feb11.pdf", 'title' => "22 February 2011"];
$files[] = ['path' => "meetings/2011/notice25jan11.pdf", 'title' => "25 January 2011"];
$files[] = ['path' => "meetings/2011/notice06jan11.pdf", 'title' => "06 January 2011 - (Special)"];

$files[] = ['path' => "meetings/2010/notice14dec10.pdf", 'title' => "14 December 2010"];
$files[] = ['path' => "meetings/2010/notice12nov10.pdf", 'title' => "12 November 2010"];
$files[] = ['path' => "meetings/2010/notice17oct10.pdf", 'title' => "17 October 2010"];
$files[] = ['path' => "meetings/2010/notice27sep10.pdf", 'title' => "27 September 2010"];
$files[] = ['path' => "meetings/2010/notice19aug10.pdf", 'title' => "19 August 2010"];
$files[] = ['path' => "meetings/2010/notice29jun10.pdf", 'title' => "29 June 2010"];
$files[] = ['path' => "meetings/2010/notice30mar10.pdf", 'title' => "30 March 2010"];
$files[] = ['path' => "meetings/2010/notice30feb10.pdf", 'title' => "28 February 2010"];