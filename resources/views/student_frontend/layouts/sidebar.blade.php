<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>

                <div class="col-md-10 col-10 center" style="text-align: center">
                    <p class="user-title">觀迎 {{auth('student')->user()->name}} 使用 ᐠ( ᐛ )ᐟ</p>
                </div>

                <li class="text-muted menu-title">功能列表</li>

                <li class="has_sub">
                    <a href="{{route('StuIndex.index')}}" class="waves-effect"><i class="fa fa-home"></i> <span> 首頁 </span> </a>
                </li>

                <li class="has_sub">
                    <a href="#" class="waves-effect"><i class="fa fa-comments"></i> <span> 會議 </span> </a>
                </li>

                <li class="has_sub">
                    <a href="{{route('StuGroupList.index')}}" class="waves-effect"><i class="fa fa-users"></i> <span> 小組專區 </span> </a>
                </li>

                <li class="has_sub">
                    <a href="#" class="waves-effect"><i class="fa fa-search"></i> <span> 成績查詢 </span> </a>
                </li>

                <li class="has_sub">
                    <a href="{{route('ResetPassword.index')}}" class="waves-effect"><i class="fa fa-undo"></i> <span> 修改密碼 </span> </a>
                </li>

                <li class="has_sub">
                    <a href="{{action('StuLoginController@logout')}}" class="waves-effect"><i class="fa fa-sign-out"></i> <span> 登出 </span> </a>
                </li>

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>

    </div>
</div>
<!-- Left Sidebar End -->
