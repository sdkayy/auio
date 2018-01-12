@if(count($errors))
<div class="w3-padding w3-red w3-display-container">
	<span onclick="this.parentElement.style.display='none'" class="w3-button w3-display-topright">X</span>
    <p>Error</p>
    <p>
    	<ul>
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</p>
</div>
@endif