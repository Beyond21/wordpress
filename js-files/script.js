
// getting a random millisecond 
var rand_millisec_4000_to_24000 = (Math.random() * (24000 - 4000) + 0.0200).toFixed(4)
var rand_millisec_3000_to_8000 = (Math.random() * (8000 - 3000) + 0.0200).toFixed(4)

    var upOrdown = '';
    

    function scroll(direction, percentage, speed) {
        //Checking the direction, setting and pasing the values to window.scrollBy func:
        if (direction == 'up') {
            console.log('up')
            upOrdown = -10;
        } else {
            console.log('not up')
            upOrdown = 10;
        }
        
        window.scrollBy(0, upOrdown);
    }




function go_to_random_links() {
    var sites = ['http://www.google.com',
                 'http://www.stackoverflow.com', 
                 'http://www.example.com', 
                 'http://www.youtube.com'];
    function randomSite() {
        var i = parseInt(Math.random() * sites.length);
        location.href = sites[i];
    }
}
function pageScrolldown() {
    window.scrollBy(0, 10); // horizontal and vertical scroll increments
    scrolldelay = setTimeout('pageScrolldown()', 100); // scrolls every 100 milliseconds
}
function pageScrollup() {
    window.scrollBy(0, -10); // horizontal and vertical scroll increments
    scrolldelay = setTimeout('pageScrollup()', 100); // scrolls every 100 milliseconds
}

function scrolling() {

    setTimeout(pageScrolldown, rand_millisec_3000_to_8000)
    function myFunction() {
        alert('Was called after' + rand_millisec_3000_to_8000 + 'seconds');
    }
}

jQuery(document).ready(function($) {
    // var direction = prompt('up or down?');
    
    // scroll(direction);

// var arr = [], l = document.links;
// for(var i=0; i<l.length; i++) {
//   arr.push(l[i].href);
// }

// console.log(arr);

var site = window.location.href;

// function getAnchorElements(){
//     var elems = [];
//     site.each(function(){
//         if($(this).attr('href').match(/^#\w+/g))
//             elems.push(this);
//     });
//     return elems;
// }



// console.log(arr1);
//version 1 working:

var arr1 = new Array();
$("a[href*=\\#]").each(function() {
	  arr1.push(this);
});  

    console.log(arr1);

//version 2 working:
// $("a[href*=\\#]:not([href=\\#])").each(function() {
//     console.log(this);
// });  

//Find elements with click event
// $.each($("*"), function(index, value) {
//     if ($._data($(value)[0], "events") != undefined) {
//          console.log($._data($(value)[0], "events")
//                      , window.jQuery().jquery); 
//     };
// });



})



//     //Do your work   
// })
// )

// $("a").each(function() {
//     //Do your work   
// })

// $("a:has(href*=#)").each(function() {
// 	console.log(this);
//     //Do your work   
// })


// $('a:has(href*=#)').each(function() {
// 	console.log(this);
//     //Do your work   
// })

// $('a[href^="'+site+'"]').click(function() {
//       _gaq.push(['_trackPageview', '/external/pagename']);
// });





// Queues a tracker object for creation:

// ga('create', 'UA-114422545-1', 'auto');
// var tal ;
// // Once the tracker has been created, log the
// // client ID to the console.
//     ga(function(tracker) {
//   var clientId = tracker.get('clientId');
//   tal=clientId;
//   console.log(clientId);
// });


//getting parameters from URL:
// phpdata is created on set-uid php file

// jQuery(document).ready(function($) {
// console.log(phpData);
// var temp_si= 0;
// if (typeof phpData.sid == 'undefined') {
//     temp_is = getParameterByName('si');
// } else {
//     temp_is = phpData.sid;
// }

//setting all the urls of the page with the values of the parameters :
// jQuery('a').each(function() {
//     this.href += (/\?/.test(this.href) ? '&?' : '?si=') + temp_is;
// });
// console.log("f");
// jQuery('a').each(function() {
//         this.href += (/\?/.test(this.href) ? '&' : '?=gi') + tal;