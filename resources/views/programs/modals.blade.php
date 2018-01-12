<!-- Modal for creating a new license -->
<div id="generateLicense" class="w3-modal">
  <div class="w3-modal-content w3-card-4">
    <header class="w3-container sdk w3-card-4">
      <h2>Generate License</h2>
      <span onclick="document.getElementById('generateLicense').style.display='none'"
      class="w3-button w3-display-topright">X</span>
    </header>
    <form class="w3-container" method="POST" action="/programs/{{ $id }}/license/create">
      {{ csrf_field() }}
      <div class="w3-section">
        <label>Custom license prefix (e.g Auth-CODE)</label>
        <input class="w3-input" type="text" name="license_prefix" maxlength="10">
      </div>
      <div class="w3-section">
        <label>Length of the license (In Weeks)</label>
        <input class="w3-input" type="number" name="license_length" required>
      </div>
      <div class="w3-section">
        <label>Amount to Generate (1-10)</label>
        <input class="w3-input" type="number" name="license_amount" required>
      </div>
      <div class="w3-row">
        <div class="w3-full">
          <button class="w3-button w3-input sdk" type="submit">Generate</button>
          <br>
          <br>
        </div>
      </div>
    </form>
  </div>
</div>