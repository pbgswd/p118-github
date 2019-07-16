@extends('layouts.email')
@section('content')
  <table class="body">
    <tr>
      <td class="center" align="center" valign="top">
        <center>

          <table class="row header">
            <tr>
              <td class="center" align="center">
                <center>

                  <table class="container">
                    <tr>
                      <td class="wrapper last">
                        <table class="twelve columns">
                          <tr>
                            <td class="six sub-columns"><a href="{{ Request::root() }}" title="{{env('SITE_NAME')}}"><img src="{{Request::root()}}/images/world-globe-mail-blur.jpg" alt="{{env('SITE_NAME')}}"></a>
                            </td>
                            <td class="six sub-columns last" style="text-align:right; vertical-align:middle;">
                              <span class="template-label"></span>
                            </td>
                            <td class="expander"></td>
                          </tr>
                        </table>

                      </td>
                    </tr>
                  </table>

                </center>
              </td>
            </tr>
          </table>

          <table class="container">
            <tr>
              <td>
                <table class="row">
                  <tr>
                    <td class="wrapper last">
                      <table class="twelve columns">
                        <tr>
                            <td><h1>Payment Receipt</h1></td>
                            <td class="expander"></td>
			            </tr>	
                        <tr>
                            <td>
                        <ul>
                    <li>Payment Date: {{$data['payment_date']}}</li>
                    <li>{{$data['subscription_order_data']['publication'][0]['title']}}</li>
                    <li>{{$data['subscription_order_data']['subscription_type'][0]['display_text']}}</li>
<li>Until:{{ date('F j, Y', strtotime($data['subscription_order_data']['subscription']['end_date'])) }} </li>
                    <li>Transaction code: {{$data['request']['tx']}}</li>
                    <li>Transaction status: {{$data['request']['st']}}</li>
                    <li>Amount: ${{$data['request']['amt']}}</li>
                    <li>Item: {{$data['request']['item_number']}}</li> 
                         </ul>
                             </td>
                             <td class="expander"></td>
                        </tr>
			            <tr>
			           <td></td>
                       <td class="expander"></td>
                   </tr>
               </table>
           </td>
       </tr>
   </table>
@endsection