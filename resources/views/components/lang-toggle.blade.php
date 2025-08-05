<div style="float:right;">
    <form method="POST" action="{{ route('lang.switch') }}" style="display:inline;">
        @csrf
        <button type="submit" name="lang" value="en" style="margin-right:8px;">English</button>
        <button type="submit" name="lang" value="ar">العربية</button>
    </form>
</div>
