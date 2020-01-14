<?php
echo "********* Process meetings 1 file to import into db *********** \n \n";
$files = [];

$files[] = ['path' => "meetings/2019/NOM December 2019.pdf", 'title' => "December 2019 Notice of General Meeting"];
$files[] = ['path' => "meetings/2019/NOM November 2019.pdf", 'title' => "November 2019 Notice of General Meeting"];
$files[] = ['path' => "meetings/2019/NOM October 2019.pdf", 'title' => "October 2019 Notice of General Meeting"];
$files[] = ['path' => "meetings/2019/NOM September 2019.pdf", 'title' => "September 2019 Notice of General Meeting"];
$files[] = ['path' => "meetings/2019/NOM July 2019.pdf", 'title' => "July 2019 Notice of General Meeting"];
$files[] = ['path' => "meetings/2019/NOM June 2019.pdf", 'title' => "June 2019 Notice of General Meeting"];
$files[] = ['path' => "meetings/2019/NOM May 2019.pdf", 'title' => "May 2019 Notice of General Meeting"];
$files[] = ['path' => "meetings/2019/NOM March 2019.pdf", 'title' => "March 2019 Notice of General Meeting"];
$files[] = ['path' => "meetings/2019/NOM January 2019.pdf", 'title' => "January 2019 Notice of General Meeting"];

$files[] = ['path' => "meetings/2018/NOM December 2018.pdf", 'title' => "December 2018 Notice of General Meeting"];
$files[] = ['path' => "meetings/2018/NOM November 2018.pdf", 'title' => "November 2018 Notice of General Meeting"];
$files[] = ['path' => "meetings/2018/NOM October 2018.pdf", 'title' => "October 2018 Notice of General Meeting"];
$files[] = ['path' => "meetings/2018/NOM September 2018.pdf", 'title' => "September 2018 Notice of General Meeting"];
$files[] = ['path' => "meetings/2018/NOM July 2018.pdf", 'title' => "July 2018 Notice of General Meeting"];
$files[] = ['path' => "meetings/2018/NOM June 2018.pdf", 'title' => "June 2018 Notice of General Meeting"];
$files[] = ['path' => "meetings/2018/NOM April 2018.pdf", 'title' => "April 2018 Notice of General Meeting"];
$files[] = ['path' => "meetings/2018/NOM March 2018.pdf", 'title' => "March 2018 Notice of March General Meeting and Special General Meeting"];
$files[] = ['path' => "meetings/2018/Addendum Feb 2018 NOM.pdf", 'title' => "February 2018 Addendum Notice of General Meeting"];
$files[] = ['path' => "meetings/2018/NOM February 2018.pdf", 'title' => "February 2018 Notice of General Meeting"];

$files[] = ['path' => "meetings/2017/NOM October 2017.pdf", 'title' => "October 2017 Notice of General Meeting"];
$files[] = ['path' => "meetings/2017/NOM September 2017.pdf", 'title' => "September 2017 Notice of General Meeting"];
$files[] = ['path' => "meetings/2017/NOM July 2017.pdf", 'title' => "July 2017 Notice of General Meeting"];
$files[] = ['path' => "meetings/2017/NOM June 2017.pdf", 'title' => "June 2017 Notice of General Meeting"];
$files[] = ['path' => "meetings/2017/NOM May 18, 2017 GM.pdf", 'title' => "May 2017 Notice of General Meeting"];
$files[] = ['path' => "meetings/2017/NOM March 2017.pdf", 'title' => "March 2017 Notice of General Meeting"];
$files[] = ['path' => "meetings/2017/NOM February 2017.pdf", 'title' => "February 2017 Notice of General Meeting"];
$files[] = ['path' => "meetings/2017/NOM January 2017.pdf", 'title' => "January 2017 Notice of General Meeting"];

$files[] = ['path' => "meetings/2016/NOM Dec 2016.pdf", 'title' => "December 2016 Notice of General Meeting"];
$files[] = ['path' => "meetings/2016/NOM November 2016.pdf", 'title' => "November 2016 Notice of General Meeting"];
$files[] = ['path' => "meetings/2016/NOM October 2016.pdf", 'title' => "October 2016 Notice of General Meeting"];
//$files[] = ['path' => "docs/CB Committee Report October 12 2016.pdf", 'title' => "October 2016 Special Meeting - C&B Committee Report"];
$files[] = ['path' => "meetings/2016/NOM September 2016.pdf", 'title' => "September 2016 Notice of General Meeting"];

foreach ($files as $file)
{
    $document = explode('/', $file['path']);
    $date = explode(" ", $file['title']);
    $date_string = trim($date[0]) . " " . trim($date[1]);

    $date = date_format(new DateTime($date_string),  'Y-m-d H:i:s');
    
    $result[] = ['path' => $file['path'],
                 'file' => $document[2],
                 'title' => trim($file['title']),
                 'date' => $date];
    unset($date);
    unset($document);
}