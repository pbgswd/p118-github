<?php
echo "********* Process minutes array file  to import into db *********** \n \n";

$files[] = ['path' => "minutes/MinutesGM_10212019.pdf", 'title' => "General Membership Meeting - October 21, 2019"];
$files[] = ['path' => "minutes/MinutesEXEC_101519.pdf", 'title' => "Executive Board Meeting - October 15, 2019"];
$files[] = ['path' => "minutes/MinutesGM_092519.pdf", 'title' => "General Membership Meeting - September 25, 2019"];
$files[] = ['path' => "minutes/MinutesEXEC091819.pdf", 'title' => "Executive Board Meeting - September 18, 2019"];
$files[] = ['path' => "minutes/MinutesEXEC_081219.pdf", 'title' => "Executive Board Meeting - August 12, 2019"];
$files[] = ['path' => "minutes/MinutesGM_072919.pdf", 'title' => "General Membership Meeting - July 29, 2019"];
$files[] = ['path' => "minutes/MinutesEXEC_07152019.pdf", 'title' => "Executive Board Meeting - July 15, 2019"];
$files[] = ['path' => "minutes/MinutesGM_052919", 'title' => "General Membership Meeting - May 29, 2019"];
$files[] = ['path' => "minutes/MinutesGM_Special_062619.pdf", 'title' => "Special General Membership Meeting - June 26, 2019"];
$files[] = ['path' => "minutes/MinutesGM_062619.pdf", 'title' => "General Membership Meeting - June 26, 2019"];
$files[] = ['path' => "minutes/MinutesEXEC_061119.pdf", 'title' => "Executive Board Meeting - June 11, 2019"];
$files[] = ['path' => "minutes/MinutesEXEC_051419.pdf", 'title' => "Executive Board Meeting - May 14, 2019"];
$files[] = ['path' => "minutes/MinutesGM_042919", 'title' => "General Membership Meeting - April 29, 2019"];
$files[] = ['path' => "minutes/MinutesEXEC_041219.pdf", 'title' => "Executive Board Meeting - April 12, 2019"];
$files[] = ['path' => "minutes/MinutesEXEC_032519.pdf", 'title' => "Executive Board Meeting - March 25, 2019"];
$files[] = ['path' => "minutes/MinutesGM_031419.pdf", 'title' => "General Membership  Meeting - March 14, 2019"];
$files[] = ['path' => "minutes/MinutesEXEC_022019.pdf", 'title' => "Executive Board Meeting - February 20, 2019"];
$files[] = ['path' => "minutes/MinutesGM_013019.pdf", 'title' => "General Membership  Meeting - January 30, 2019"];
$files[] = ['path' => "minutes/MinutesEXEC_011219.pdf", 'title' => "Executive Board Meeting - January 12, 2019"];

$files[] = ['path' => "minutes/MinutesGM_12272018.pdf", 'title' => "General Membership  Meeting - December 27, 2018"];
$files[] = ['path' => "minutes/MinutesEXEC_121118.pdf", 'title' => "Executive Board Meeting - December 11, 2018"];
$files[] = ['path' => "minutes/MinutesGM_112618.pdf", 'title' => "General Membership  Meeting - November 26, 2018"];
$files[] = ['path' => "docs/MinutesEXEC_10302018.pdf", 'title' => "Executive Board Meeting - October  30, 2018"];
$files[] = ['path' => "docs/MinutesGM_10192018.pdf", 'title' => "General Membership  Meeting - October 19, 2018"];
$files[] = ['path' => "docs/MinutesEXEC_10052018.pdf", 'title' => "Executive Board Meeting - October  5, 2018"];
$files[] = ['path' => "docs/MinutesGM_09172018.pdf", 'title' => "General Membership  Meeting - September 17, 2018"];
$files[] = ['path' => "minutes/MinutesEXEC_09012018.pdf", 'title' => "Executive Board Meeting - September 1, 2018"];
$files[] = ['path' => "minutes/MinutesEXEC_08162018.pdf", 'title' => "Executive Board Meeting - August 16, 2018"];
$files[] = ['path' => "minutes/MinutesEXEC_08022018.pdf", 'title' => "Executive Board Meeting - August 2, 2018"];
$files[] = ['path' => "minutes/MinutesGM_07182018.pdf", 'title' => "General Membership Meeting - July 18, 2018"];
$files[] = ['path' => "minutes/MinutesEXEC_07172018.pdf", 'title' => "Executive Board Meeting - July 17, 2018"];
$files[] = ['path' => "minutes/MinutesEXEC_06212018.pdf", 'title' => "Executive Board Meeting - June 26, 2018"];
$files[] = ['path' => "minutes/MinutesGM_06132018.pdf", 'title' => "General Membership Meeting - June 13, 2018"];
$files[] = ['path' => "minutes/MinutesEXEC_05222018.pdf", 'title' => "Executive Board Meeting - May 22, 2018"];
$files[] = ['path' => "minutes/MinutesGM_04302018.pdf", 'title' => "General Membership Meeting - April 30, 2018"];
$files[] = ['path' => "minutes/MinutesEXEC_041618.pdf", 'title' => "Executive Board Meeting - April 16, 2018"];
$files[] = ['path' => "minutes/MinutesEXEC_031618.pdf", 'title' => "Executive Board Meeting - March 16, 2018"];
$files[] = ['path' => "minutes/MinutesGM_022518.pdf", 'title' => "General Membership Meeting - February 25, 2018"];
$files[] = ['path' => "minutes/MinutesEXEC_02022018.pdf", 'title' => "Executive Board Meeting - February 2, 2018"];
$files[] = ['path' => "minutes/MinutesEXEC_01262018.pdf", 'title' => "Executive Board Meeting - January 26, 2018"];
$files[] = ['path' => "minutes/MinutesEXEC_01252018.pdf", 'title' => "Executive Board Meeting - January 25, 2018"];
$files[] = ['path' => "minutes/MinutesEXEC_01082018.pdf", 'title' => "Executive Board Meeting - January 8, 2018"];

$files[] = ['path' => "minutes/MinutesGM_12182018.pdf", 'title' => "General Membership Meeting - December 18, 2017"];
$files[] = ['path' => "minutes/MinutesEXEC_11202017.pdf", 'title' => "Executive Board Meeting - November 20, 2017"];
$files[] = ['path' => "minutes/MinutesGM_10292017.pdf", 'title' => "General Membership Meeting - October 29, 2017"];
$files[] = ['path' => "minutes/MinutesEXEC_10172017.pdf", 'title' => "Executive Board Meeting - October 17, 2017"];
$files[] = ['path' => "minutes/MinutesGM_09242017.pdf", 'title' => "General Membership Meeting - September 24, 2017"];
$files[] = ['path' => "minutes/MinutesSPECEX_09162017.pdf", 'title' => "Special Executive Meeting - September 16, 2017"];
$files[] = ['path' => "minutes/MinutesEXEC_09092017.pdf", 'title' => "Executive Board Meeting - September 9, 2017"];
$files[] = ['path' => "minutes/MinutesEXEC_08182017.pdf", 'title' => "Executive Board Meeting - August 18, 2017"];
$files[] = ['path' => "minutes/MinutesGM_07192017.pdf", 'title' => "General Membership Meeting - July 19, 2017"];
$files[] = ['path' => "minutes/MinutesGM_06252017.pdf", 'title' => "General Membership Meeting - June 25, 2017"];
$files[] = ['path' => "minutes/MinutesGM_05182017.pdf", 'title' => "General Membership Meeting - May 18, 2017"];
$files[] = ['path' => "minutes/MinutesEXEC_05172017.pdf", 'title' => "Executive Board Meeting - May 17, 2017"];
$files[] = ['path' => "minutes/MinutesEXEC_04272017.pdf", 'title' => "Executive Board Meeting - April 27, 2017"];
$files[] = ['path' => "minutes/MinutesGM_03262017.pdf", 'title' => "General Membership Meeting - March 26, 2017"];
$files[] = ['path' => "minutes/MinutesEXEC_03182017.pdf", 'title' => "Executive Board Meeting - March 18, 2017"];
$files[] = ['path' => "minutes/MinutesGM_02262017.pdf", 'title' => "General Membership Meeting - February 26, 2017"];
$files[] = ['path' => "minutes/MinutesEXEC_02052017.pdf", 'title' => "Executive Board Meeting - February 5, 2017"];
$files[] = ['path' => "minutes/MinutesGM_01222017.pdf", 'title' => "General Membership Meeting - January 22, 2017"];
$files[] = ['path' => "minutes/MinutesEXEC_011517.pdf", 'title' => "Executive Board Meeting - January 15, 2017"];
$files[] = ['path' => "minutes/MinutesEXEC_010717.pdf", 'title' => "Executive Board Meeting - January 7, 2017"];

$files[] = ['path' => "minutes/MinutesGM_12292016.pdf", 'title' => "Executive Board Meeting - December 29, 2016"];
$files[] = ['path' => "minutes/MinutesEXEC_12082016.pdf", 'title' => "Executive Board Meeting - December 8, 2016"];
$files[] = ['path' => "minutes/MinutesGM_11292016.pdf", 'title' => "General Membership Meeting - November 29, 2016"];
$files[] = ['path' => "minutes/MinutesEXEC_11072016.pdf", 'title' => "Executive Board Meeting - November 7, 2016"];
$files[] = ['path' => "minutes/MinutesEXEC_10252016.pdf", 'title' => "Executive Board Meeting - October 25, 2016"];
$files[] = ['path' => "minutes/MinutesEXEC_10112016.pdf", 'title' => "Executive Board Meeting - October 11, 2016"];
$files[] = ['path' => "minutes/MinutesGM_09292016.pdf", 'title' => "General Membership Meeting - September 29, 2016"];
$files[] = ['path' => "minutes/MinutesEXEC_082916.pdf", 'title' => "Executive Board Meeting - August 29, 2016"];
$files[] = ['path' => "minutes/MinutesEXEC_07142016.pdf", 'title' => "Executive Board Meeting - July 14, 2016"];
$files[] = ['path' => "minutes/MinutesGM_06272016.pdf", 'title' => "General Membership Meeting - June 27, 2016"];
$files[] = ['path' => "minutes/MinutesEXEC_06102016.pdf", 'title' => "Executive Board Meeting - June 10, 2016"];
$files[] = ['path' => "minutes/MinutesEXEC_05162016.pdf", 'title' => "Executive Board Meeting - May 16, 2016"];
$files[] = ['path' => "minutes/MinutesGM_05162016.pdf", 'title' => "General Membership Meeting - May 16, 2016"];
$files[] = ['path' => "minutes/MinutesEXEC_04302016.pdf", 'title' => "Executive Board Meeting - April 30, 2016"];
$files[] = ['path' => "minutes/MinutesEXEC_04112016.pdf", 'title' => "Executive Board Meeting - April 8, 2016"];
$files[] = ['path' => "minutes/MinutesGM_03302016.pdf", 'title' => "General Membership Meeting - March 30, 2016"];
$files[] = ['path' => "minutes/MinutesEXEC_03082016.pdf", 'title' => "Executive Board Meeting - March 8, 2016"];
$files[] = ['path' => "minutes/MinutesEXEC_02262016.pdf", 'title' => "Executive Board Meeting - February 26, 2016"];
$files[] = ['path' => "minutes/MinutesGM_02262016.pdf", 'title' => "General Membership Meeting - February 26, 2016 "];
$files[] = ['path' => "minutes/MinutesSPEC_02222016.pdf", 'title' => "Special General Membership Meeting - February 22, 2016"];
$files[] = ['path' => "minutes/MinutesEXEC_02032016.pdf", 'title' => "Executive Board Meeting - February 3, 2016"];
$files[] = ['path' => "minutes/MinutesGM_01142016.pdf", 'title' => "General Membership Meeting - January 14, 2016"];
$files[] = ['path' => "minutes/MinutesEXEC_01092016.pdf", 'title' => "Executive Board Meeting - January 9, 2016"];

$data = [];

foreach ($files as $file)
{
    $doc = explode('/', $file['path']);
    $result = explode('-', $file['title']);
    $title = trim($result[0]);
    $date = date_format(new DateTime(trim($result[1])),  'Y-m-d H:i:s');
    $data[] = ['path' => $file['path'], 'file' => $doc[1], 'title' => $title, 'date' => $date];
}

print_r($data);