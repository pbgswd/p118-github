<!DOCTYPE html PUBLIC "-\/\/W3C\/\/DTD XHTML 1.0 Strict\/\/EN" "http:\/\/www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width"/>
    <title>{{$title ?? "IATSE Local 118 Email Message"}}</title>
  <link href="https://iatse118.com/css/email.css" rel="stylesheet" />
</head>
<body style="background-color: #fafafa; margin-left: auto; margin-right: auto;">
@yield('content')
@include('emails.footer')
