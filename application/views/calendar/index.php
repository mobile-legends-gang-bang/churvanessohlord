<?php
//index.php


?>
<!DOCTYPE html>
<html>
 <head>
  <title>Calendar</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
<!--   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
 -->  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  <script>
   
  $(document).ready(function() {
   var calendar = $('#calendar').fullCalendar({
        //editable: true;
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay'
    },
    events: function(start, end, timezone, callback) {
    $.ajax({
      url: "<?php echo base_url('calendar/get_events') ?>",
      dataType: 'json',
      data: {
        // our hypothetical feed requires UNIX timestamps
        
        start: start.unix(),
        end: end.unix()
      },
      success: function(msg) {
                     var events = msg.events;
                     callback(events);
                 }
      });
  },
    selectable:true,
    selectHelper:true,
      select: function(start, end, allDay)
    {
     var title = prompt("Enter Event Title");
     if(title)
     {
      var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
      var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
      $.ajax({
       url:"<?php echo base_url('calendar/add_event') ?>",
       type:"POST",
       data:{title:title, start:start, end:end},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Added Successfully");
       }
      })
     }
    },
    editable:true,

    eventClick:function(event)
    {
     if(confirm("Are you sure you want to remove this event?"))
     {
      var id = event.id;
      $.ajax({
       url:"<?php echo base_url('calendar/delete_event') ?>",
       type:"POST",
       data:{id:id},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Event Removed");
       }
      })
     }
    },

   });
  });
   
  </script>
 </head>
 <body>
  <br />
  <h2 align="center"><a href="#">Calendar</a></h2>
  <br />
  <style type="text/css">
    #calendar{
      margin-left: 20px;
      margin-top: 70px;
      width: 1000px;
    }
  </style>
  <div class="container">
   <div id="calendar"></div>
  </div>
 </body>
</html>