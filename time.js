$(document).ready(function()
{
   setInterval(tick, 1000);
});
function tick()
{
  $.ajax({
    url: 'time.php',
    success: function(data) {
       $('#time').val(data);
       document.getElementById('time').innerText = data;
    },
  });
}
