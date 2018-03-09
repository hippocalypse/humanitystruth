            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">HumanitysTruth</a>
                </div>

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <ul class="nav navbar-nav navbar-left navbar-top-links">
                    <li><a href="/"><i class="fa fa-home fa-fw"></i> Website</a></li>
                </ul>

                <ul class="nav navbar-right navbar-top-links">
                    
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> Administrator <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                                <li class="sidebar-search">
                                        <div class="input-group custom-search-form">
                                            <input type="text" class="form-control" placeholder="Search...">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="button">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                        </span>
                                        </div>
                                        <!-- /input-group -->
                                    </li>
                            
                            <li>
                                <a href="{{route('admins')}}" @if($menu=='dashboard') class="active" @endif><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                            </li>
                            <li>
                                <a href="{{route('admin.affiliatesView')}}" @if($menu=='affiliates') class="active" @endif><i class="fa fa-file-text-o fa-fw"></i> Affiliates</a>
                            </li>
                            
                            
                        </ul>
                    </div>
                </div>
            </nav>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: hidden;">
                @csrf
            </form>