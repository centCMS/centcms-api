			<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li{% if request.getURI() == '/' %} class="active"{% endif %}>
                            <a href="{{url('/')}}"{% if request.getURI() == '/' %} class="active"{% endif %}><i class="fa fa-dashboard fa-fw"></i> 控制台</a>
                        </li>
                        <li{% if controller == 'item' %} class="active"{% endif %}>
                            <a href="#"{% if controller == 'item' %} class="active"{% endif %}><i class="fa fa-bar-chart-o fa-fw"></i> 数据<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								{% for item in sidebarCategoryList %}
                                <li>
                                    <a href="{{url('/item/list/')}}{{item['id']}}">{{item['name']}}</a>
                                </li>
								{% endfor %}
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li {% if controller == "category" %} class="active"{% endif %}>
                            <a href="#"{% if controller == "category" %} class="active"{% endif %}><i class="fa fa-sitemap fa-fw"></i> 分类<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								{% for item in sidebarCategoryList %}
                                <li{% if request.getURI() == '/category/list' and categoryId == item['id'] %} class="active"{% endif %}>
                                    <a href="{{url('/category/list/')}}{{item['id']}}"{% if categoryId == item['id'] %} class="active"{% endif %}>{{item['name']}}</a>
                                </li>
                                {% endfor %}
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="{{url('/schema-template/list')}}"><i class="fa fa-table fa-fw"></i> 模板</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->