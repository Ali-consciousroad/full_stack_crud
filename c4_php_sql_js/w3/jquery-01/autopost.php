<html>
<head>
</head>
<body>
<p>Change the contents of the text field and 
then tab away from the field
to trigger the change event. Do not use
Enter or the form will get submitted.</p>
<form id="target">
  <input type="text" name="one" value="Hello there" 
     style="vertical-align: middle;"/> 
  <img id="spinner" src="spinner.gif" height="25" 
      style="vertical-align: middle; display:none;">
</form>
<hr/>
<div id="result"></div>
<hr/>

<!-- Asynchronous event based programming : The function get called when a change occures -->

<script type="text/javascript" src="jquery.min.js">
</script>
<script type="text/javascript">
  $('#target').change(function(event) 
  {
    $('#spinner').show();
    var form = $('#target');
    var txt = form.find('input[name="one"]').val();
    window.console && console.log('Sending POST');
    $.post( 'autoecho.php', { 'val': txt },
      function( data ) {
          window.console && console.log(data);
          $('#result').empty().append(data);  // Delete text (empty) if any content and add the new data 
          $('#spinner').hide();
      }
    ).error( function() { 
      $('#target').css('background-color', 'red');
      alert("Dang!");});
  });
</script>
</body>
