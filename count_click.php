<body>
  <!-- Various <a> links that will increment your counter -->
  <ul>
    <li><a href='#' onclick='addToCount(1);'>Add One</a></li>
    <li><a href='#' onclick='addToCount(2);'>Add Two</a></li>
    <li><a href='#' onclick='addToCount(3);'>Add Three</a></li>
  </ul>
  <hr />
  <!-- Example Counter -->
  Count : <span id='count'>1</span>
  <!-- Hidden Counter (consider using a HiddenField for this) -->
  <input id='counter' name='counter' type='hidden' value='1' />
  <script type='text/javascript'>
    function addToCount(valueToAdd){
      // Grab the current count
      var count = parseInt(document.getElementById('count').innerText);
      
      // Add the specified amount to the count
      var new_count = count + valueToAdd;
      
      // Update your count (both the counter and hidden field)
      document.getElementById('count').innerText = new_count;
      document.getElementById('counter').value = new_count;
    }
  </script>
</body>