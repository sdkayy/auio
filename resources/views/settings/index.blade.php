@include('layouts.nav')
<body>
  <div class="w3-container">
    <br>
    <div class="w3-responsive w3-row-padding">
      <div class="w3-full">
        <div class="w3-card-4 w3-modal-content">
          <header class="sdk w3-container">
            <h2 style="font-weight: 200;">Edit Account Details</h2>
          </header>
          @include('layouts.errors')
          <form class="w3-container" method="POST" action="/settings/save">
            {{ csrf_field() }}
            <div class="w3-section">
              <label>Email</label>
              <input class="w3-input" type="email" name="new_email" value="{{ auth()->user()->email }}" required>
            </div>
            <hr>
            <div class="w3-section">
              <label>New Password</label>
              <input class="w3-input" type="password" name="new_password">
            </div>
            <div class="w3-section">
              <label>Confirm New Password</label>
              <input class="w3-input" type="password" name="new_password_confirm">
            </div>
            <hr>
            <!--<div class="w3-padding  w3-display-container">
              <p>Current Plan</p>
              <p><a href="billing"></a>  </p>
            </div> -->
            <hr>
            <div class="w3-section">
              <button class="w3-button w3-input sdk" type="submit">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>