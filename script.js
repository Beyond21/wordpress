// Queues a tracker object for creation.

ga('create', 'UA-114422545-1', 'auto');
var tal ;
console.log("d");
alert("p");
// Once the tracker has been created, log the
// client ID to the console.

    ga(function(tracker) {
  var clientId = tracker.get('clientId');
  tal=clientId;
  console.log(clientId);
});

jQuery(document).ready(function($) {
    

    // console.log(phpData);
    var tempId = 0;
    if (typeof phpData.uid == 'undefined') {
        tempId = getParameterByName('si');
    } else {
        tempId = phpData.uid;
    }
    jQuery('a').each(function() {
debugger
        this.href += (/\?/.test(this.href) ? '&' : '?si=') + tempId;
        this.href += (/\?/.test(this.href) ? '&' : '?=gi') + tal;

    
    });
    

})