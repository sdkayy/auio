@include('layouts.nav')
<body>
  <div class="w3-container">
    <br>
    <div class="w3-responsive w3-row-padding">
      <div class="w3-full">
        <div class="w3-card-4 w3-modal-content">
          <header class="sdk w3-container">
            <h2 style="font-weight: 200;">Login</h2>
          </header>
          @include('layouts.errors')
          <form class="w3-container" method="POST" action="/register">
            {{ csrf_field() }}
            <div class="w3-section">
              <label>Username</label>
              <input class="w3-input" type="text" name="username" required>
            </div>
            <div class="w3-section">
              <label>Password</label>
              <input class="w3-input" type="password" name="password" required>
            </div>
            <div class="w3-section">
              <label>Confirm Password</label>
              <input class="w3-input" type="password" name="password_confirmation" required>
            </div>
            <div class="w3-section">
              <label>Email</label>
              <input class="w3-input" type="email" name="email" required>
            </div>
            <div class="w3-section">
              {{--{!! Recaptcha::render() !!}--}}
            </div>
            <div class="w3-section">
              <button class="w3-button w3-input w3-full sdk" type="submit">Register</button>
            </div>
          </form>
        </div>
        </div>
      </div>
    </div>
  </div>
</body>
