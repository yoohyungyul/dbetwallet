<nav>
    <div class="nav nav-tabs nav-fill" >
        <a class="nav-item nav-link @if(strpos($_SERVER["REQUEST_URI"],"wallet") == "1") active @endif"    href="/wallet" >Wallet</a>
        <a class="nav-item nav-link @if(strpos($_SERVER["REQUEST_URI"],"history") == "1") active @endif"    href="/history" >History</a>
        <a class="nav-item nav-link @if(strpos($_SERVER["REQUEST_URI"],"send") == "1") active @endif"    href="/send" >Send</a>
        <a class="nav-item nav-link @if(strpos($_SERVER["REQUEST_URI"],"buy") == "1") active @endif"    href="/send" >Buy</a>
    </div>
</nav>