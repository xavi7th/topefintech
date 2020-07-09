<tr>
  <td class="header">
    <a href="{{ $url }}" style="display: inline-block; text-align:center;">
      @if (trim($slot) === 'Laravel')
      <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
      @else
      <img src="{{ asset('/img/logo.png') }}" class="logo" alt="Laravel Logo" style="width:240px; height:63px; display:block:">
      @endif
    </a>
  </td>
</tr>
