<td>{{ $user->id }}</td>
<td>{{ $user->username }}</td>
<td>
	<p id="userMail-{{ $user->id }}" style="display:none" onclick="hideagain('{{ $user->id }}')">{{ $user->email }}</p>
  	<button class="w3-button sdk" id="hide-{{ $user->id }}" onclick="reveal('{{ $user->id }}')">Click to reveal user email</button>
</td>
<td>{{ $user->created_at->toFormattedDateString() }}</td>
<td>{{ $user->expires->toFormattedDateString() }}</td>
<td>
  <form method="POST" action="/programs/{{ $id }}/users/{{ $user->id }}/delete">
  	{{ csrf_field() }}
  	<input type="hidden" name="user_id" value="{{ auth()->user()->id }}" />
  	<button class="w3-button w3-red" type="submit">Delete User</button>
  </form>
</td>
