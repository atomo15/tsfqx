 var allSeats = []

 // Clicking any seat
    $(".seatNumber").click(
        function () {
            if (!$(this).hasClass("seatUnavailable")){
                // If selected, unselect it
                if ($(this).hasClass("seatSelected")) {
                    var thisId = $(this).attr('id');
                    var price = $('#seatsList .' + thisId).val();
                    $(this).removeClass("seatSelected");

                    $('#seatsList .' + thisId).remove();
                    // Calling functions to update checkout total and seat counter.

                    const line = thisId.trim().split("_")
                    let [row, seat] = line
                    row = line[0];
                    seat = Number(seat)



                    allSeats.forEach((e, ind) => {
                        //console.log(e.row)
                        //console.log(row)
                        if(e.row == row && e.seat == seat){ 
                            //console.log(line)
                            allSeats = allSeats.slice(0, ind).concat(allSeats.slice(ind + 1, allSeats.length))
                        }

                    })
                    console.log(allSeats)

                    removeFromCheckout(price);
                    refreshCounter();
                }
                else {
                    // else, select it
                    // getting values from Seat
                    var thisId = $(this).attr('id');
                    var id = thisId.split("_");
                    var price = $(this).attr('value');
                    var seatDetails = "Row: " + id[0] + " Seat:" + id[1] + " Price:Baht$:" + price;
                    //console.log('select seat jaaa')
                    
                   
                    var freeSeats = parseInt($('.freeSeats').first().text());
                    var selectedSeats = parseInt($(".seatSelected").length);
                    
                    // If you have free seats available the price of this one will be 0.
                    /*if (selectedSeats < freeSeats) {
                        price = 0;
                    }*/

                    // Adding this seat to the list
                    var seatDetails = "Row: " + id[0] + " Seat:" + id[1] + " Price:Baht:" + price;
                    $("#seatsList").append('<li value=' + price + ' class=' + thisId + '>' + seatDetails);// + "  " + "<button id='remove:" + thisId + "'+ class='btn btn-default btn-sm removeSeat' value='" + price + "'><strong>X</strong></button></li>");
                    $(this).addClass("seatSelected");

                    allSeats.push({row: id[0], seat: id[1]})
                    console.log(allSeats)
                
                    addToCheckout(price);
                    refreshCounter();
                }
            }
        }
    );
    // Clicking any of the dynamically-generated X buttons on the list
    $(document).on('click', ".removeSeat", function () {
        // console.log('select seat jaaa')
        // Getting the Id of the Seat
        var id = $(this).attr('id').split(":");
        var price = $(this).attr('value')

        $('#seatsList .' + id[1]).remove();

        $("#" + id[1] + ".seatNumber").removeClass("seatSelected");   


        removeFromCheckout(price);  
        refreshCounter();
      }
  );
    // Show tooltip on hover.
    $(".seatNumber").hover(
        function () {
            if (!$(this).hasClass("seatUnavailable")) {
                var id = $(this).attr('id');
                var id = id.split("_");
                var price = $(this).attr('value');
                var tooltip = "Row: " + id[0] + " Seat:" + id[1] + " Price:Baht:" + price;

                $(this).prop('title', tooltip);

            } else
            {
                $(this).prop('title', "Seat unavailable");
            }
        }
        );
    // Function to refresh seats counter
    function refreshCounter() {
        $(".seatsAmount").text($(".seatSelected").length); 

    }
    // Add seat to checkout
    function addToCheckout(thisSeat) {
        var seatPrice = parseInt(thisSeat);
        var num = parseInt($('.txtSubTotal').text());
        num += seatPrice;
        num = num.toString();
    }
    // Remove seat from checkout
    function removeFromCheckout(thisSeat) {
        var seatPrice = parseInt(thisSeat);
        var num = parseInt($('.txtSubTotal').text());
        num -= seatPrice;
        num = num.toString();

        $('.txtSubTotal').text(num);

    }

    function sendseat(){

        var seatsep = JSON.stringify(allSeats);
        console.log(seatsep);
        var seatsep2 = JSON.stringify(seatsep);
        document.getElementById("eiei").value = seatsep;
        axios.post('action.php',{data: seatsep2})
        //console.log(allSeats)
        .then(function (response) {
            console.log(response);
        })
        .catch(function (error) {
            console.log(error);
        });
    }

    // Clear seats.
    $("#btnClear").click(
        function () {
            $('.txtSubTotal').text(0);
            $(".seatsAmount").text(0);
            $('.seatSelected').removeClass('seatSelected');
            $('#seatsList li').remove();
        }
    );