<nav>
    <div class="nav nav-tabs nav-fill" >
        <a class="nav-item nav-link @if(strpos($_SERVER["REQUEST_URI"],"wallet") == "1")    active @endif"  href="/wallet" style="font-size:15px" >지갑</a>
        <a class="nav-item nav-link @if(strpos($_SERVER["REQUEST_URI"],"history") == "1")   active @endif"  href="/history" style="font-size:15px" >거래내역</a>
        <a class="nav-item nav-link @if(strpos($_SERVER["REQUEST_URI"],"send") == "1")      active @endif"  href="/send" style="font-size:15px" >보내기</a>
        <a class="nav-item nav-link @if(strpos($_SERVER["REQUEST_URI"],"buy") == "1")       active @endif"  href="/buy" style="font-size:15px" >구매하기</a>
    </div>
</nav>