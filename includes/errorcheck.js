
<script src="jquery-1.11.1.min.js"></script>
<script>
    $(document).ready(
        myParser("tolololololo");
    );
    /*$(document).ready(function() {
        // Trimming off the top part of the doc.
        $.get("teststring.html", function(data) {
            var s;
            var rawString = ($(data).text());
            rawString = rawString.trim();
            var work = rawString.indexOf("The Account or PIN code is incorrect!");

            // TO PRINT STUFF OUT ON THE PAGE
            //document.writeln(work);
            if (work != -1) {
                document.write("Login Failed. Please check your login information and internet connection.")
            } else {
                document.write("Success.")
            };
            return work;
        });

    });

*/
    function myParser(webpageAsString){
    	$.get("teststring2.html", function(data) {
            var s;
            var rawString = ($(data).text());
            rawString = rawString.trim();
            var work = webpageAsString.indexOf("The Account or PIN code is incorrect!");

            // TO PRINT STUFF OUT ON THE PAGE
            //document.writeln(work);
            if (work != -1) {
                //document.write("Login Failed. Please check your login information and internet connection.")
                return 0
            } else {
                //document.write("Success.")
                return 1
            };
            
        });
    	
    }
</script>
