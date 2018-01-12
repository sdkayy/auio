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
            <h2 style="font-weight: 200;">Applications</h2>
          </header>

          <div class="w3-container">
            <br>
            <table class="w3-table w3-striped w3-bordered" id="appTable">
              <thead>
                <tr class="sdk">
                  <th style="font-weight: 300;">Application ID</th>
                  <th style="font-weight: 300;">Application Secret</th>
                  <th style="font-weight: 300;">Application Name</th>
                  <th style="font-weight: 300;">User Count</th>
                  <th style="font-weight: 300;">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($programs as $program)
                  <tr>@include('layouts.apptable')</tr>
                @endforeach
              </tbody>
            </table>
            <br>
            <script>
            function reveal(d) {
              var show = document.getElementById("appSec-" + d);
              show.style.display = 'block';
              var hide = document.getElementById("hide-" + d);
              hide.style.display = 'none';
            }

            function hideagain(d) {
              var show = document.getElementById("appSec-" + d);
              show.style.display = 'none';
              var hide = document.getElementById("hide-" + d);
              hide.style.display = 'block';
            }
            </script>
            <div class="w3-row-padding">
              <div class="w3-full">
                <a class="w3-button sdk w3-right" onclick="document.getElementById('newapp').style.display='block'"><i class="fa fa-plus-thin" style="font-weight: 200;"></i> New App</a>
              </div>
            </div>
            <br>
          </div>
        </div>
        <script>
        jQuery(function($) {
          var items = $("#appTable tbody tr");
          var numItems = items.length;
          var perPage = 10;
          items.slice(perPage).hide();
          $("#tabs").pagination({
            items: numItems,
            itemsOnPage: perPage,
            cssStyle: "light-theme",
            onPageClick: function(pageNumber) {
              var showFrom = perPage * (pageNumber - 1);
              var showTo = showFrom + perPage;
              items.hide()
              .slice(showFrom, showTo).show();
            }
          });
        });
        </script>
        <br>
      </div>
      <br>
      <br>

    </div>
  </div>
  @include('layouts.modals')
</body>