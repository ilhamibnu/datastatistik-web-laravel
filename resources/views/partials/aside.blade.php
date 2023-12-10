<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                @if(Auth::user()->id_role == '1' || Auth::user()->id_role == '2')
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="/dashboard" aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span class="hide-menu">Dashboard</span></a></li>

                <li class="sidebar-item"> <a class="sidebar-link" href="/isian" aria-expanded="false"><i data-feather="tag" class="feather-icon"></i><span class="hide-menu">Isian</span></a>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="/pengguna" aria-expanded="false"><i data-feather="message-square" class="feather-icon"></i><span class="hide-menu">Pengguna</span></a></li>



                @else
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="/dashboard" aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span class="hide-menu">Dashboard</span></a></li>

                <li class="sidebar-item"> <a class="sidebar-link" href="/isian" aria-expanded="false"><i data-feather="tag" class="feather-icon"></i><span class="hide-menu">Isian</span></a> </li>
                @endif


            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
