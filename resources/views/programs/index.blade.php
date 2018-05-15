@include('layouts.nav')
<body>
	<div class="w3-responsive w3-row-padding">
		<div class="w3-full">
			@include('layouts.errors')
		    <br>
		    <!-- User Panel -->
		    <div class="w3-full w3-container">
		        <div class="w3-card-4">
		          <header class="sdk w3-container">
		            <h2 style="font-weight: 200;">Users</h2>
		          </header>

		          <div class="w3-container">
		            <br>
		            <table class="w3-table w3-striped w3-bordered" id="appTable">
		              <thead>
		                <tr class="sdk">
		                  <th style="font-weight: 300;">User ID</th>
		                  <th style="font-weight: 300;">Username</th>
		                  <th style="font-weight: 300;">User Email (Be responsible)</th>
		                  <th style="font-weight: 300;">Registered</th>
		                  <th style="font-weight: 300;">Account Expiration</th>
		                  <th style="font-weight: 300;">Actions</th>
		                </tr>
		              </thead>
		              <tbody>
		                @foreach($pusers as $user)
		                	<tr>@include('layouts.pusertable')</tr>
		                @endforeach
		              </tbody>
		            </table>
		            <br>
		            <div class="w3-row-padding">
		              <div class="w3-full">
		                <a class="w3-button sdk w3-right" onclick="document.getElementById('migrateUser').style.display='block'"><i class="fa fa-plus-thin" style="font-weight: 200;"></i> Migrate users from BetterSeal</a>
		              </div>
		            </div>
		            {{ 
		            	$pusers->links()
		            }}
		            <br>
		            <script>
		            function reveal(d) {
		              var show = document.getElementById("userMail-" + d);
		              show.style.display = 'block';
		              var hide = document.getElementById("hide-" + d);
		              hide.style.display = 'none';
		            }

		            function hideagain(d) {
		              var show = document.getElementById("userMail-" + d);
		              show.style.display = 'none';
		              var hide = document.getElementById("hide-" + d);
		              hide.style.display = 'block';
		            }
		            </script>
		          </div>
		        </div>
	        	<br>

	        </div>

	        <!-- License Panel -->
	        <div class="w3-full w3-container">
		        <div class="w3-card-4">
		          <header class="sdk w3-container">
		            <h2 style="font-weight: 200;">Licenses</h2>
		          </header>

		          <div class="w3-container">
		            <br>
		            <table class="w3-table w3-striped w3-bordered" id="appTable">
		              <thead>
		                <tr class="sdk">
		                  <th style="font-weight: 300;">License ID</th>
		                  <th style="font-weight: 300;">License Code</th>
		                  <th style="font-weight: 300;">License Length (From activation)</th>
		                  <th style="font-weight: 300;">License Level</th>
		                  <th style="font-weight: 300;">Created</th>
		                  <th style="font-weight: 300;">Actions</th>
		                </tr>
		              </thead>
		              <tbody>
		                @foreach($licenses as $license)
		                	<tr>@include('layouts.licensetable')</tr>
		                @endforeach
		              </tbody>
		            </table>
		            <br>
		            <div class="w3-row-padding">
		              <div class="w3-full">
		                <a class="w3-button sdk w3-right" onclick="document.getElementById('generateLicense').style.display='block'"><i class="fa fa-plus-thin" style="font-weight: 200;"></i> Generate Program License</a>
		              </div>
		            </div>
		            {{ 
		            	$licenses->links()
		            }}
		            <br>
		            <script>
		            function reveall(d) {
		              var show = document.getElementById("license-" + d);
		              show.style.display = 'block';
		              var hide = document.getElementById("hidel-" + d);
		              hide.style.display = 'none';
		            }

		            function hidelagain(d) {
		              var show = document.getElementById("license-" + d);
		              show.style.display = 'none';
		              var hide = document.getElementById("hidel-" + d);
		              hide.style.display = 'block';
		            }
		            </script>
		          </div>
		        </div>
	        	<br>

	        </div>
		</div>
	</div>
	@include('programs.modals')
</body>