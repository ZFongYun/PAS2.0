<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">

            <ul>

                <div class="col-md-6 col-6 center" style="text-align: center">
                    <img src="{{ URL::asset('assets/images/users/avatar-11.png') }}" class="img-fluid d-block rounded-circle" alt="user">
                    <p class="user-title">觀迎教師使用</p>
                </div>

                <li class="text-muted menu-title"> 功能列表</li>

                <li class="has_sub">
                    <a href="{{route('prof.index')}}" class="waves-effect"><i class="fa fa-home"></i> <span> 首頁 </span> </a>
                </li>

                <li class="has_sub">
                    <a href="{{route('ImportStudent.index')}}" class="waves-effect"><i class="fa fa-user"></i> <span> 成員名單 </span> </a>
                </li>

                <li class="has_sub">
                    <a href="{{route('GroupList.index')}}" class="waves-effect"><i class="fa fa-users"></i> <span> 小組專區 </span> </a>
                </li>

                <li class="has_sub">
                    <a href="{{route('meeting.index')}}" class="waves-effect"><i class="fa fa-cog"></i> <span> 會議管理 </span> </a>
                </li>

                <li class="has_sub">
                    <a href="{{route('ReportList.index')}}" class="waves-effect"><i class="fa fa-download"></i> <span> 報告下載 </span> </a>
                </li>

                <li class="has_sub">
                    <a href="{{route('Transcript.index')}}" class="waves-effect"><i class="fa fa-search"></i> <span> 成績查詢 </span> </a>
                </li>

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>

    </div>
</div>

<!-- Left Sidebar End -->
