var pollServer = function() {
    $.get('chat.php', function(result) {
   if(!result.success) {
   console.log("Error polling server for new messages!");
   return;
   }
   $.each(result.messages, function(idx) {
   var chatBubble;
   if(this.sent_by == 'self') {
   chatBubble = $('<div class="row bubble-sent pull-right">' + 
   this.message + 
   '</div><div class="clearfix"></div>');
   } else {
   chatBubble = $('<div class="row bubble-recv">' + 
   this.message + 
   '</div><div class="clearfix"></div>');
   }
   $('#chatPanel').append(chatBubble);
   });
   setTimeout(pollServer, 5000);
    });
   }