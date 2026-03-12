<?php
include("db.php");

// Function to render rooms floor-wise
function renderRooms($conn, $floor) {
    $rooms = mysqli_query($conn, "SELECT * FROM room_data WHERE floor='$floor' ORDER BY room_no ASC");

    // If no rooms found
    if (!$rooms || mysqli_num_rows($rooms) == 0) {
        return "<p class='text-center text-danger mt-3'>No rooms found for $floor floor.</p>";
    }

    // Floor title
    $output = "<h4 class='floor-title'>" . 
              ($floor == 'Ground' ? "🏠 Ground Floor" : "🏢 First Floor") . "</h4>";
    $output .= "<div class='room-grid'>";

    // Loop through each room
    while ($room = mysqli_fetch_assoc($rooms)) {
        $filled = 0;
        for ($i = 1; $i <= 4; $i++) {
            if (!empty($room["student$i"])) $filled++;
        }
        $available = 4 - $filled;
        $class = ($filled == 4) ? 'full' : (($filled > 0) ? 'partial' : 'empty');

        // Room Card UI
        $output .= "
        <div class='room-card $class'>
            <h5>{$room['room_no']}</h5>
            <div class='room-info'>Filled: $filled / 4 | Vacant: $available</div>
            <form method='POST' action='room_data.php'>
                <input type='hidden' name='room_id' value='{$room['id']}'>";

        // Input boxes for each student
        for ($i = 1; $i <= 4; $i++) {
            $val = htmlspecialchars($room["student$i"]);
            $output .= "<div class='mb-2'>
                            <input type='text' name='student$i' 
                                   placeholder='Student $i' 
                                   value='$val' 
                                   list='studentList' 
                                   class='form-control'>
                        </div>";
        }

        // Update button
        $output .= "<button type='submit' name='update_room' class='btn-update'>Update Room</button>
                    </form>
                </div>";
    }

    $output .= "</div>";
    return $output;
}

// Output both Ground and First floor sections
echo renderRooms($conn, 'Ground');
echo renderRooms($conn, 'First');
?>
