@include('layouts.nav')
<body>
  <div class="w3-responsive w3-row-padding">
    <div class="w3-full">
      @include('layouts.errors')
      <br>
      <!-- Panel 1 -->
      <div class="w3-full w3-container">
        <div class="w3-card-4">
          <header class="sdk w3-container">
            <h2 style="font-weight: 200;">Downloads</h2>
          </header>

          <div class="w3-container">
            <div class="w3-padding">
              <p>Dowload the class from below</p>
              <a href="BETA.01.zip">BETA.01.zip</a>
            </div>
          </div>
        </div>
      </div>
      <br>
      <br>

    </div>
  </div>
  @include('layouts.modals')
</body>