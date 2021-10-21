<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>
                <li>
                    <a href="/home"  class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                @if(Auth::user()->type == "Administrator")
                
                <li>
                    <a class="waves-effect">
                    <i class='bx bxs-bank'></i>
                        <span key="t-chat">Agencies</span>
                    </a>
                    <ul class="sub-menu " aria-expanded="false">
                        <li><a href="/agencies" key="t1" class="font-size-11"><i class='bx bx-news'></i>National Agencies</a></li>
                        <li><a href="/lgus" key="t2" class="font-size-11"><i class='bx bxs-school'></i>Local Government Unit's</a></li>
                        <li><a href="/staffs" key="t3" class="font-size-11"><i class='bx bxs-user-circle'></i>Staffs</a></li>
                    </ul>
                </li>

                <li>
                    <a class="waves-effect">
                    <i class='bx bx-chip'></i>
                        <span key="t-chat">Devices</span>
                    </a>
                    <ul class="sub-menu " aria-expanded="false">
                        <li><a href="/devices" key="t1"><i class='bx bx-detail'></i>Lists</a></li>
                        <li><a href="/trackers" key="t2"><i class='bx bxs-chip'></i>Trackers</a></li>
                    </ul>
                </li>

                <li>
                    <a href="/lists" class="waves-effect">
                    <i class='bx bx-category' ></i>
                        <span key="t-chat">Lists</span>
                    </a>
                </li>
                
                @elseif(Auth::user()->type == "Member")
                <li>
                    <a href="/assets/list" class="waves-effect">
                    <i class='bx bx-detail' ></i>
                        <span key="t-chat">Lists</span>
                    </a>
                </li>
                <li>
                    <a href="/stations" class="waves-effect">
                    <i class='bx bx-map'></i>
                        <span key="t-chat">Stations</span>
                    </a>
                </li>
                <li>
                    <a href="/search" class="waves-effect">
                    <i class='bx bx-search'></i>
                        <span key="t-chat">Search</span>
                    </a>
                </li>
                @elseif(Auth::user()->type == "Researcher")
                <li>
                    <a href="/researches" class="waves-effect">
                    <i class='bx bxs-book'></i>
                        <span key="t-chat">Researches</span>
                    </a>
                </li>
                @elseif(Auth::user()->type == "Laboratory Coordinator")
                <li>
                    <a href="/laboratory/basic" class="waves-effect">
                    <i class='bx bxs-box'></i>
                        <span key="t-chat">Basic Laboratories</span>
                    </a>
                </li>
                <li>
                    <a href="/laboratory/specialized" class="waves-effect">
                    <i class='bx bxs-cabinet'></i>
                        <span key="t-chat">Specialized Laboratories</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>