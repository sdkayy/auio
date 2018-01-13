<head>
  <!-- W3 CSS -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- W3 CSS Override -->
  <style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,600,600i');
    html, body, h1, h2, h3, h4, h5, h6, p, th, tr, li {
      font-family: 'Montserrat', sans-serif;
    }
    .sdk {
      background: #1C3144;
      /*background: #683257;*/
      color: #D7D9D7;
    }

    a, h2, label, input, th, tr, li {
      font-weight: 300;
    }

    input[type="password"]{
      font-weight: 500;
    }

    body {
      background: #FCFAFA; /*Possible EAEAEA */
    }
  </style>
  <!-- JQuery   -->
  <script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  <!-- Font Awesome -->
  <script src="https://use.fontawesome.com/38940925f7.js"></script>
</head>
<body>
  <div class="w3-bar sdk w3-padding">
	@if(Auth::check())
        <a href="/home" class="w3-bar-item w3-button">Dashboard</a>
        <a href="/settings" class="w3-bar-item w3-button">Account Settings</a>
        <a href="/download" class="w3-bar-item w3-button">Download</a>
        <a href="/logout" class="w3-bar-item w3-button">Logout</a>
    @else 
        <a href="/login" class="w3-bar-item w3-button">Login</a>
        <a href="/register" class="w3-bar-item w3-button">Register</a>
    @endif
  </div>
</body>
