<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  </head>
  <body>
    <div class='email-container'>
    {{-- Turn this into a table --}}
    {{-- 3x3 size, 1st and 3rd column are just for correct middle alignment --}}
      <table style='width:100%;'>
        {{-- header, 1st row of table --}}
        <tr>
          <td class='email-filler'></td>
          <td>
            <div class='text-center'>
              {{ HTML::image('img/fruit_logo.png','',array('class'=>'header-image')) }}
            </div>
            <div class='text-right'>
              <small>{{ Carbon::now()->format('l, F j, Y') }}</small>
            </div>
          </td>
          <td class='email-filler'></td>
        </tr>
        {{-- /header --}}
        
        {{-- content, 2nd row of table --}}
        <tr>
          <td class='email-filler'></td>
          <td class='email-content'>
            @section('emailContent')
            @show
          </td>
          <td class='email-filler'></td>
        </tr>
        {{-- /content --}}
        
        {{-- footer, 3rd row of table --}}
        <tr>
          <td class='email-filler'></td>
          <td>
            <div class='text-center'>
              <h3>{{ HTML::secureLink('/dashboard','Fruit Analytics') }}</h3>
              <p>Copyright © {{Carbon::now()->year}} All rights reserved</p>
              <small class='text-muted'>You can change your notification settings {{ HTML::secureLink('/settings','here')}}.</small>
            </div>
          </td>
          <td class='email-filler'></td>
        </tr>
        {{-- /footer --}}
      </table>
    </div>
  </body>