<!-- Global Modals -->
<!-- Nodal for new applications -->
<div id="newapp" class="w3-modal">
  <div class="w3-modal-content w3-card-4">
    <header class="w3-container sdk w3-card-4">
      <h2>Register New Application</h2>
      <span onclick="document.getElementById('newapp').style.display='none'"
      class="w3-button w3-display-topright">X</span>
    </header>
    <form class="w3-container" method="POST" action="/programs/create">
      {{ csrf_field() }}
      <div class="w3-section">
        <input class="w3-input" type="text" name="name" required="">
        <label>Application Name</label>
      </div>
      <div class="w3-row">
        <div class="w3-full">
          <button class="w3-button w3-input sdk" type="submit">Create</button>
          <br>
          <br>
        </div>
      </div>
    </form>
  </div>
</div>
