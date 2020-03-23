<div class="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
          {% include "layouts/nav" with [] %}
	</nav>
	<div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item{%if controller is "schema-template"%} active{% endif %}" href="{{url('/schema-template')}}">数据模板</a>
          <a class="blog-nav-item{%if controller is "item"%} active{% endif %}" href="{{url('/item')}}">数据可视</a>
          <a class="blog-nav-item" href="{{url('/category')}}">分类大全</a>
          <a class="blog-nav-item" href="{{url('/about')}}">关于我们</a>
        </nav>
      </div>
    </div>

	<!-- Page Content -->
    <div style="background-color: white; min-height: 505px;" >
	<div class="container">

      <div class="blog-header">
        {# <h1 class="blog-title">轻云数据展示</h1>
        <p class="lead blog-description"></p> #}
      </div>

	  <div class="row">
      	<div class="col-sm-8 blog-main" id="blog-main">
{% block content %}
{% endblock %}
	  	</div>

		<!-- /.blog-sidebar -->
        <div class="col-sm-3 col-sm-offset-1 blog-sidebar" id="blog-sidebar">
          <div class="sidebar-module sidebar-module-inset">
            <h4>关于</h4>
            <p>CentCMS(C=Content + Controller + Config)，是一个功能超级强大的动态模板数据发布/管理/调度中心。</p>
          </div>
          <div class="sidebar-module">
            <h4>分类</h4>
            <ol class="list-unstyled">
{% for item in sidebarCategoryList %}
              <li><a href="#">{{item["name"]}}</a>
			  {% if item["children"] is defined %}
			  	<ol class="list-unstyled" style="padding-left: 10px;">
				  {% for subitem in item["children"] %}
				  	<li><a href="">{{subitem["name"]}}</a><li>
				  {% endfor %}
				</ol>
			  {% endif %}
			  </li>
{% endfor %}
            </ol>
          </div>
          <div class="sidebar-module">
            <h4>友情链接</h4>
            <ol class="list-unstyled">
              <li><a href="https://bullsoft.org">BullSoft</a></li>
              <li><a href="http://phalconplus.bullsoft.org">PhalconPlus</a></li>
			  <li><a href="http://guweigang.com">Weigang Gu</a></li>
              <li><a href="https://github.com/bullsoft/phalconplus">Github</a></li>
            </ol>
          </div>
        </div><!-- /.blog-sidebar -->
      
	  </div>

	</div>    
    </div>
	
</div>