<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Recursive&display=swap");

    * {
        box-sizing: border-box;
    }

    body {
        font-family: "Recursive", "sans serif";
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100%;
        background-color: black;
        color: white;
        margin: 0;
    }

    h2 {
        text-align: center;
        color: brown;
        background-color: white;
        border-radius: 10px;
    }

    .movie-container select {
        margin: 0;
        border-radius: 5px;
        background-color: #ffffff;
        font-size: 14px;
        margin-left: 10px;
        padding: 7px 5px;
    }

    .d-none {
        display: none !important;
    }


    .wrapping-seat {

        width: 35px;
        height: 24px;
        margin: 10px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        text-align: center;
    }

    .seat {
        background-color: #777;
        width: 35px;
        height: 24px;
        line-height: 24px;
        margin: 10px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        text-align: center;
    }

    .seat.selected {
        background-color: #6feaf6;
    }

    .seat.occupied {
        background-color: #fff;
    }

    /* Selects the nth elements among the group of siblings */
    .seat:nth-of-type(2) {
        /* margin-right: 20px; */
    }

    /* Selects the nth elements among the group of siblings starting from end */
    .seat:nth-last-of-type(2) {
        /* margin-left: 20px; */
    }

    /* Selects any element that is NOT a given type or contains a class */
    .container .seat:not(.occupied):hover {
        cursor: pointer;
        transform: scale(1.2);
    }

    .showcase {
        background: rgba(31, 31, 31, 0.89);
        padding: 5px 10px;
        color: #777;
        border-radius: 5px;
        list-style-type: none;
        display: flex;
        justify-content: space-between;
    }

    .showcase li {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 10px;
    }

    .showcase li small {
        margin: 2px;
    }

    .row {
        display: flex;
    }

    .container {
        perspective: 350px;
        margin-bottom: 15px;
    }

    .screen {
        width: 100%;
        height: 70px;
        background-color: #fff;
        margin: 20px 0;
        box-shadow: 0 3px 12px rgba(255, 255, 255, 0.7);
        transform: rotateX(-45deg);
    }

    p.text {
        margin: 5px 0;
    }

    p.text span {
        color: #6feaf6;
    }
</style>

<body>
    <div class="movie-container">
        <h2>Event Bersama</h2>
        <label>Pilih Event:</label>
        <select id="event" name="event">
            <option value="">Pilih Event</option>
            @foreach ($event as $key => $value)
                <option value="{{ $value->event }}">{{ $value->event }}</option>
            @endforeach
        </select>
        <label>Pilih Kategori:</label>
        <select id="kategori" name="kategori">
            <option value="">Pilih Kategori</option>
        </select>
    </div>

    <ul class="showcase">
        <li>
            <div class="seat"></div>
            <small>Available</small>
        </li>
        <li>
            <div class="seat selected"></div>
            <small>Selected</small>
        </li>
    </ul>

    <div class="container">
        <div class="screen"></div>
        <div class="seating"></div>
    </div>

    <p class="text">
        You have selected <span id="count">0</span> <span id="total">0</span>
    </p>
    <!-- <script src="script.js"></script> -->
    <script src="script.js"></script>
</body>

<script src="{{ asset('js/jquery.slim.min.js') }}"></script>
{{-- <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script> --}}
<script src="{{ asset('mobile/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {


        $('#event').on('change', function() {
            var dataCategories = getJSON('{{ route('seating.get_category') }}', {
                'event': $(this).val()
            }, 'GET');
            $('#kategori option').remove();
            $('#kategori').append(`<option value="">Pilih Kategori</option>`)
            $.each(dataCategories.data, function(key, value) {
                $('#kategori').append(`
                <option value="${value.category}">${value.category}</option>
                `);
            })
        });

        $('#kategori').on('change', function() {
            getData();
        })

        setInterval(() => {
            getData();
        }, 10000);

        function getData() {

            category = $('#kategori').val();
            event = $('#event').val();
            getDataSeating({
                'event': event,
                'category': category
            });
        }

        function getDataSeating(data) {
            var dataSeating = getJSON('{{ route('seating.get_seating_tree') }}', data, 'GET');
            var dataSeating = dataSeating.data;
            var dataSelected = dataSeating.data_selected;
            var dataTotal = dataSeating.data_total;
            // console.log(dataSeating);
            $('.seating div').remove();
            $.each(dataSeating.data_seating, function(key, value) {
                var columnSeating = '';
                // $j == 10 ? 'd-none' : ''  $j == 3 ? 'selected' : '' 
                console.log(value.columns);
                $.each(value.columns, function(key2, value2) {
                    columnSeating += `
                    <div class="wrapping-seat" data-id="${value2.id}">
                        <div class="seat ${value2.is_seating == 1 ? 'selected' : ''}">
                            ${value2.name}
                        </div>
                    </div>`
                })

                $('.seating').append(`
                <div class="row">
                    ${columnSeating}
                </div>    
                `);
            });
            $('#total').html(dataTotal);
            $('#count').html(dataSelected);
        }

        function getJSON(url, data, type = 'POST') {
            return JSON.parse($.ajax({
                type: type,
                url: url,
                data: data,
                dataType: 'json',
                global: false,
                async: false,
                success: function(msg) {

                }
            }).responseText);
        }
    });
</script>
{{-- <script>
    // Select all the required DOM elements
    const container = document.querySelector(".container");
    const seats = document.querySelectorAll(".row .seat:not(.occupied)");
    const selectMovie = document.getElementById("movie");
    let count = document.getElementById("count");
    let total = document.getElementById("total");

    populateUI();
    let ticketPrice = +selectMovie.value;

    // Set Movie data and price
    function setMovieData(movieIndex, moviePrice) {
        localStorage.setItem("selectedMovieIndex", movieIndex);
        localStorage.setItem("selectedMoviePrice", moviePrice);
    }

    // Update selected Count using value from selected movie
    function updateCountAndTotal() {
        let selectedSeatsCount = document.querySelectorAll(".row .seat.selected");
        count.innerHTML = selectedSeatsCount.length;
        ticketPrice
            ?
            (total.innerText = selectedSeatsCount.length * ticketPrice) :
            (total.innerText = " => Please select a movie");

        // get seleted seats into an array
        // map through array
        // return a new array
        // index of returns index of array
        const seatsIndex = [...selectedSeatsCount].map((seat) =>
            // this returns the index of elements containing class of selected in this case
            // every time we click this map functions runs and returns a list containing indexes of
            // elements with class selected

            [...seats].indexOf(seat)
        );
        localStorage.setItem("seatIndex", JSON.stringify(seatsIndex));
    }

    // Populate UI
    function populateUI() {
        // getting stored index of selected seats from local storage
        const selectedSeats = JSON.parse(localStorage.getItem("seatIndex"));

        if (selectedSeats !== null && selectedSeats.length > 0) {
            // looping through list of seats
            seats.forEach((seat, index) => {
                // indexOf() returns index of given value
                // here we are checking if selectedSeats contains the seat from seats
                // if yes than add class of selected
                if (selectedSeats.indexOf(index) > -1) {
                    seat.classList.add("selected");
                }
            });
        }
        const selectedMovieIndex = localStorage.getItem("selectedMovieIndex");

        if (selectedMovieIndex !== null) {
            // The selectedIndex property sets or returns the index of the selected
            // option in a drop-down list. The index starts at 0.
            selectMovie.selectedIndex = selectedMovieIndex;
        }
    }

    // Movie select eventListner
    selectMovie.addEventListener("change", (e) => {
        ticketPrice = +e.target.value;
        setMovieData(e.target.selectedIndex, e.target.value);
        updateCountAndTotal();
    });

    // Event Listener
    container.addEventListener("click", (e) => {
        if (
            e.target.classList.contains("seat") &&
            !e.target.classList.contains("occupied")
        ) {
            e.target.classList.toggle("selected");

            updateCountAndTotal();
        }
    });

    // update count and total happens only on event change
    // we need to trigger the updateCountAndTotal()
    updateCountAndTotal(); --}}
<script></script>

</html>
