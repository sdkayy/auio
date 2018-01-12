<td>{{ $program->id }}</td>
<td>
  <p id="appSec-{{ $program->id }}" style="display:none" onclick="hideagain('{{ $program->id }}')">{{ $program->secret }}</p>
  <button class="w3-button sdk" id="hide-{{ $program->id }}" onclick="reveal('{{ $program->id }}')">Click to reveal secret</button>
</td>
<td>{{ $program->name }}</td>
<td>0</td>
<td>
  <a onclick="document.getElementById('viewFeatures-{{ $program->id }}').style.display='block'" class="w3-button sdk">View Features</a>
  <a href="/programs/{{ $program->id }}" class="w3-button sdk">Manage</a>
  <a onclick="" class="w3-button w3-red">Suspend</a>
  <!-- Program Specific Modals -->
  <!-- View / Edit Features -->
  <div id="viewFeatures-{{ $program->id }}" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
      <header class="w3-container sdk w3-card-4">
        <h2>All Features</h2>
        <span onclick="document.getElementById('viewFeatures-{{ $program->id }}').style.display='none'" class="w3-button w3-display-topright">
          X
        </span>
      </header>
      <form class="w3-container" method="POST">
        <div class="w3-section w3-full">
          <div class="w3-section w3-half">
            <input class="w3-check" type="checkbox" name="aAnalytics">
            <label>Enable Application Analytics <small><a href="x">Learn More</a></small></label>
          </div>
          <div class="w3-section w3-half">
            <input class="w3-check" type="checkbox" name="aVariables">
            <label>Enable Application Variables <small><a href="x">Learn More</a></small></label>
          </div>
        </div>
        <div class="w3-section w3-full">
          <div class="w3-section w3-half">
            <input class="w3-check" type="checkbox" name="aUserFields">
            <label>Enable User Specific Variables <small><a href="x">Learn More</a></small></label>
          </div>
          <div class="w3-section w3-half">
            <input class="w3-check" type="checkbox" name="aFileServer">
            <label>Enable Private File Server <small><a href="x">Learn More</a></small></label>
          </div>
        </div>
        <div class="w3-section w3-full">
          <div class="w3-section w3-half">
            <input class="w3-check" type="checkbox" name="aLic">
            <label>Require Licenses to Register <small><a href="x">Learn More</a></small></label>
          </div>
          <div class="w3-section w3-half">
          </div>
        </div>
        <div class="w3-row">
          <div class="w3-half">
            <input id="submit" name="updateFeatures" type="submit" class="w3-button sdk" value="Update">
            <br>
            <br>
          </div>
        </div>
      </form>
    </div>
  </div>
</td>