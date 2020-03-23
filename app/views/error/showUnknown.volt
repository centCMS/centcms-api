{% extends "layouts/super_error.volt" %}

{% block content %}
      <h1 class="mt-4 mb-3">Whoops!
        <small>Exceptions</small>
      </h1>
      <div class="jumbotron">
        <h1 class="display-1 text-center">500</h1>
        <p class="text-center">
	        <p>ErrorCode: {{e.getCode()}}</p>
	        <p>ErrorMessage: {{e.getMessage()}}</p>
			    <p>Traces: <pre>{{e.getTraceAsString() | nl2br}}</pre></p>
		    </p>  
      </div>
{% endblock %}