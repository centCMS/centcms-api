<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        {% include "layouts/nav.volt" %}
    </nav>
	<!-- Page Content -->
    <div class="container">
	  {% block content %}
	  {% endblock %}
    </div>
    <!-- /.container -->
</div>