<header class="header" id="header">
    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    <div class="pagetitle"><h3 id="page_title">Page Title</h3></div>
    <div class="header_img" id="profileicon"> 
        <img src="https://i.imgur.com/hczKIze.jpg" alt=""> 
    </div>
      
</header>

<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div> 
            <a href="{{ url('home') }}" class="nav_logo"> 
                <i class='bx bx-layer nav_logo-icon'></i> 
                <span class="nav_logo-name"> {{ config('app.name', 'POS') }}</span> 
            </a>
            <div class="nav_list"> 
                <a href="{{ url('dashboard') }}" class="nav_link active"> 
                    <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span> 
                </a> 
                <a href="{{ url('pos') }}" class="nav_link"> 
                    <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">POS</span> 
                </a> 
                <a href="#" class="nav_link"> 
                    <i class='bx bx-user nav_icon'></i> <span class="nav_name">Users</span> 
                </a>
                <a href="#" class="nav_link"> 
                    <i class='bx bx-message-square-detail nav_icon'></i> <span class="nav_name">Messages</span>
                </a>
                 <a href="#" class="nav_link"> 
                    <i class='bx bx-bookmark nav_icon'></i> <span class="nav_name">Bookmark</span>
                 </a>
                <a href="#" class="nav_link">
                    <i class='bx bx-folder nav_icon'></i> <span class="nav_name">Files</span>
                 </a>
                <a href="#" class="nav_link"> 
                    <i class='bx bx-bar-chart-alt-2 nav_icon'></i> <span class="nav_name">Stats</span>
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