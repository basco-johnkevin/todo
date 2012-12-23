
<div id="todo-form">
	<h3>What to do?</h3>
	{{ Form::open('todos', 'POST', array('id' => 'todo-form')) }}
		{{ Form::text('name', '', array('id' => 'name')) }}
		<br>
		{{-- Form::submit('save') --}}
	{{ Form::close() }}
</div>

<div id="todo-list-con">
	@if ( $todos )
		<ul id="todo-list">
			@foreach($todos as $todo)
			
		    	<li id="todo-{{ $todo->id }}">
		    		<div class="view">
		    			<label>{{ $todo->name }}</label>
		    			<a href="#" class="delete-btn" data-id="{{ $todo->id }}">x</a>
		    		</div>
		    	</li>
			
			@endforeach
		</ul>
	@endif
</div>



<script type="text/javascript">
(function($){ // to avoid conflicts

	$(function() { // document.ready 

    	// console.log('working');

    	/**
    	 * add
    	 */
    	$('form#todo-form').submit(function(){
    		console.log('form submit');

    		var name = $('#name').val();

    		// save data
    		$.ajax({
			  	type: "POST",
			  	url: "<?php action('todos'); ?>",
			  	data: { name: name }
			}).done(function( data ) {
			  	console.log(data);

				var list = '';

			  	$.each(data, function(i, data){
			  		// console.log(data.name);

			  		list = list + 
			  		"<li id=" + data.id + ">"
			  		+ "<div class='view'>"
			  		+ "<label>" + data.name + "</label>"
			  		+ "<a href='#' class='delete-btn' data-id='" + data.id + "'>x</a>"
			  		+ "</div>";
			  		+ "<li>";

			  	});

			  	// console.log(list);

			  	$('ul#todo-list').html(list);

			  
			});

    		return false; // to avoid submitting the form

    	});


    	/**
    	 * edit
    	 */
		// $('ul#todo-list').find('a.delete-btn').live('click', function() { // deprecated as of jquery 1.7
		$('ul#todo-list').on('click', 'a.delete-btn', function(event) {
    		
    		$this = $(this); // cache the current $('a.delete-btn');

    		// console.log($this.data('id'));

    		var id = $this.data('id');

			// delete the list
			$.ajax({
			  	type: "DELETE",
			  	url: "<?php action('todos'); ?>",
			  	data: { id: id }
			}).done(function( data ) {
			  	//console.log(data);
	
			  	var list = '';

			  	$.each(data, function(i, data){
			  		// console.log(data.name);

			  		list = list + 
			  		"<li id=" + data.id + ">"
			  		+ "<div class='view'>"
			  		+ "<label>" + data.name + "</label>"
			  		+ "<a href='#' class='delete-btn' data-id='" + data.id + "'>x</a>"
			  		+ "</div>";
			  		+ "<li>";

			  	});

			  	console.log(list);

			  	$('ul#todo-list').html(list);

			});

    		return false;
    	});



	}); 

})(jQuery);
</script>