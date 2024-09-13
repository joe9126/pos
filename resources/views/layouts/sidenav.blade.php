<header class="header bg-grey" id="header">
    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    <div class="pagetitle"><h2 id="page_title">Page Title</h2></div>
    <div class="header_img" id="profileicon"> 
        <img src="https://i.imgur.com/hczKIze.jpg" alt=""> 
    </div>
      
</header>

<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div> 
            <a href="{{ url('home') }}" class="nav_logo"> 
                <i class='bx bx-layer nav_logo-icon'></i> 
                <span class="nav_logo-name fw-bold">PrimePOS</span> 
            </a>
            <div class="nav_list" id="nav_list"> 
                <a href="{{ url('home') }}" class="nav_link"> 
                    <i class="fa-solid fa-gauge-high nav_icon"></i> <span class="nav_name">Dashboard</span> 
                </a> 
                <a href="{{ url('pos') }}" class="nav_link"> 
                    <i class="fa-solid fa-cash-register nav_icon"></i> <span class="nav_name">POS</span> 
                </a> 
                <a href="{{ url('products') }}" class="nav_link">
                    <i class="fa-solid fa-boxes-stacked nav_icon"></i> <span class="nav_name">Products</span>
                 </a>

                 <a href="{{ url('sales') }}" class="nav_link"> 
                    <i class='bx bx-bar-chart-alt-2 nav_icon'></i> <span class="nav_name">Sales</span>
                 </a> 
                 <a href="{{ url('suppliers') }}" class="nav_link"> 
                    <i class="fa-solid fa-users-between-lines nav_icon"></i><span class="nav_name">Suppliers</span>
                </a>
                
                <a href="{{ url('cashier') }}" class="nav_link"> 
                    <i class='bx bx-user nav_icon'></i> <span class="nav_name">Cashier</span> 
                </a>
               
                 <a href="{{ url('settings') }}" class="nav_link"> 
                    <i class='bx bx-cog nav_icon'></i> <span class="nav_name">Settings</span>
                 </a>
               
               
            </div>
        </div>
         <a href="{{ route('logout') }}" class="nav_link"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> 
            <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">  {{ __('Logout') }}</span> 
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </nav>
</div>