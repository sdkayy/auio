<td>{{ $license->id }}</td>
<td>
	<p id="license-{{ $license->id }}" style="display:none" onclick="hidelagain('{{ $license->id }}')">{{ $license->code }}</p>
  	<button class="w3-button w3-half sdk" id="hidel-{{ $license->id }}" onclick="reveall('{{ $license->id }}')">Click to reveal license code</button>
</td>
<td>{{ $license->expires }} Weeks</td>
<td>{{ $license->created_at->toFormattedDateString() }}</td>
<td>
  <form method="POST" action="/programs/{{ $id }}/license/{{ $license->id }}/delete">
  	{{ csrf_field() }}
  	<input type="hidden" name="user_id" value="{{ auth()->user()->id }}" />
  	<button class="w3-button w3-red" type="submit">Delete License</button>
  </form>
</td>