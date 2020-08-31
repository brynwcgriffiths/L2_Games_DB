<?php include("topbit.php");

$genre_sql="SELECT * FROM `genre` ORDER BY `genre`.`Genre` ASC ";
$genre_query=mysqli_query($dbconnect, $genre_sql);
$genre_rs=mysqli_fetch_assoc($genre_query);

$app_name = "";
$subtitle = "";
$url = "";
$genreID = "";
$dev_name = "";
$age = "";
$rating = "";
$rate_count = "";
$cost = "";
$in_app = 1;
$description = "Please enter a discription";

$has_errors = "no";



$app_error = $url_error = $dev_error = $description_error = $genre_error = $age_error = $rating_error = $count_error = "no-error";

$app_field = $url_field = $dev_field = $description_field = $genre_field = $age_field = $rating_field = $count_field = "form-ok";

$age_message = $cost_message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $app_name = mysqli_real_escape_string($dbconnect, $_POST['app_name']);
    $subtitle = mysqli_real_escape_string($dbconnect, $_POST['subtitle']);
    $url = mysqli_real_escape_string($dbconnect, $_POST['url']);
   
    $genreID = mysqli_real_escape_string($dbconnect, $_POST['genre']);
   
    if ($genreID != "") {
        $genreitem_sql = "SELECT * FROM `genre` WHERE`GenreID` = $genreID";
        $genreitem_query=mysqli_query($dbconnect, $genreitem_sql);
        $genreitem_rs=mysqli_fetch_assoc($genreitem_query);
       
        $genre = $genreitem_rs['Genre'];
       
    }
   
   
    $dev_name = mysqli_real_escape_string($dbconnect, $_POST['dev_name']);
    $age = mysqli_real_escape_string($dbconnect, $_POST['age']);
    $rating = mysqli_real_escape_string($dbconnect, $_POST['rating']);
    $rating_count = mysqli_real_escape_string($dbconnect, $_POST['count']);
    $cost = mysqli_real_escape_string($dbconnect, $_POST['price']);
    $in_app = mysqli_real_escape_string($dbconnect, $_POST['in_app']);
    $description = mysqli_real_escape_string($dbconnect, $_POST['description']);
   
   
    if ($app_name == "") {
        $has_errors = "yes";
        $app_error = "error-text";
        $app_field = "form-error";
    }
   
    $url = filter_var($url, FILTER_SANITIZE_URL);
   
    if (filter_var($url, FILTER_VALIDATE_URL) == false) {
        $has_errors = "yes";
        $url_error = "error-text";
        $url_field = "form-error";
    }
   
        if (genreID == "") {
        $has_errors = "yes";
        $genre_error = "error-text";
        $genre_field = "form-error";
    }
   
        if ($dev_name == "") {
        $has_errors = "yes";
        $dev_error = "error-text";
        $dev_field = "form-error";
    }
   
        if ($description == "" || $description == "please enter a description") {
        $has_errors = "yes";
        $description_error = "error-text";
        $description_field = "form-error";
        $description = "";
    }
   
    if (!is_numeric($rating)|| $rating < 0 || $rating > 5) {
        $has_errors = "yes";
        $rating_error = "error-text";
        $rating_field = "form-error";
    }
   
    if (!ctype_digit($rate_count)|| $rate_count < 1) {
        $has_errors = "yes";
        $count_error = "error-text";
        $count_field = "form-error";
    }
   
    if ($cost == "" || $cost == "0") {
        $cost = 0;
        $cost_message = "the price has been set to 0 (ie: free).";
        $cost_error = "defaulted";
    }
   
    else if (!is_numeric($cost)|| $cost < 0) {
        $cost_message = "Please enter a number that is 0 or greater";
        $cost_error = "error-text";
        $cost_field = "form-error";
    }
   
    if ($has_errors == "no") {
       
        header('Location: add_success.php');
       
        $dev_sql ="SELECT * FROM `developer` WHERE `DevName` LIKE '$dev_name'";
        $dev_query=mysqli_query($dbconnect, $dev_sql);
        $dev_rs=mysqli_fetch_assoc($dev_query);
        $dev_count=mysqli_num_rows($dev_query);
       
        if ($dev_count > 0) {
            $developerID = $dev_rs['DeveloperID'];
        }
       
        else {
            $add_dev_sql = "INSERT INTO `developer` (`DeveloperID`; `DevName`) VALUES (NULL, '$dev_name');";
            $add_dev_query = mysqli_query($dbconnect), $add_dev_sql);
           
            $newdev_sql = "SELECT * FROM `developer` WHERE `DevName` LIKE '$dev_name'";
            $newdev_query=mysqli_query($dbconnect, $newdev_sql);
            $newdev_rs=mysqli_fetch_assoc($newdev_query);
           
            $developerID = $newdev rs['DeveloperID'];
        }
       
    $addentry_sql = "INSERT INTO `game_data`.`game_details` (`ID`, `Name`, `Subtitle`, `URL`, `GenreID`, `DeveloperID`, `Age`, `User Rating`, `Rating Count`, `Price`, `In App`, `Description`) VALUES (NULL, '$app_name', '$subtitle', '$url', '$genreID', '$developerID', '$age', '$rating', '$rate_count', '$cost', '$in_app', '$description');";
    $addentry_query=mysqli_query($dbconnect,$addentry_sql);
       
    $getid_sql = "SELECT * FROM `game_details` WHERE
    `Name` LIKE '$app_name'
AND `Subtitle` LIKE '$subtitle'
AND `URL` LIKE '$url'
AND `GenreID` = $genreID
AND `Age` = $age
AND `User Rating` = $rating
AND `Rating Count` = $rate_count
AND `Price` = $cost
AND `In App` = $in_app
";
    $getid_query=mysqli_query($dbconnect, $getid_sql);
    $getid_rs=mysqli_fetch_assoc($getid_query);
       
    $ID = $getid_rs['ID'];
    $_SESSION['ID']=$ID;
       
   
       
    }
   
   
   
}

?>

<div class="box main">
                <div class ="add-entry">
   <h2>Add An Entry</h2>
                   
                    <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                   
                    <div class="<?php echo $app_error; ?>">
                        Please fill in the 'App Name' field
                    </div>    
                    <input class="add-field <?php echo $app_field; ?>" type="text" name="app_name" value="<?php echo $app_name; ?>" placeholder="App Name (required) ..."/>
                       
                    <input class="add-field" type="text" name="subtitle" size="40" value="<?php echo $subtitle; ?>" placeholder="Subtitle (optional) ..."/>
                   
                    <div class="<?php echo $url_error; ?>">
                        Please provide a valid URL
                    </div>
                    <input class="add-field <?php echo $url_field; ?>" type="text" name="url" size="40" value="<?php echo $url; ?>" placeholder="URL (Required)"/>
                       
                     <div class="<?php echo $genre_error; ?>">
                        Please choose a genre
                    </div>  
                    <select class="adv <?php echo $genre_field; ?>" name="genre">
                       
                        <?php
                        if($genreID=="") {
                            ?>
                        <option value="" selected>Genre (choose something)....</option>

                        <?php
                        }
                       
                        else {
                            ?>
                        <option value="<?php echo $genreID; ?>" selected><?php echo $genre; ?></option>
                        <?php
                        }
                        ?>
                       
                        <?php
                        do {
                        ?>
                    <option value="<?php echo $genre_rs['GenreID']; ?>"><?php echo $genre_rs['Genre']; ?></option>
                       
                    <?php
                       
                    }
                       
                    while ($genre_rs=mysqli_fetch_assoc($genre_query))
                       
                    ?>
                       
                    </select>  
                       
                    <div class="<?php echo $dev_error; ?>">
                        Please provide a developer name
                    </div>    
                    <input class="add-field <?php echo $dev_field; ?>" type="text" name="dev_name" size="40" value="<?php echo $dev_name; ?>" placeholder="Developer Name (Required) ..."/>
                       
                    <input class="add-field" type="text" name="age" value="<?php echo $age; ?>" placeholder="Age (0 for all)"/>    
                       
                    <div>
                        <input class="add-field" type="number" name="rating" value="<?php echo $rating; ?>" required step="0.1" min="0" max="5" placeholder="Rating (0-5)" />
                    </div>    
                     
                    <input class="add-field" type="text" name="rating" value="<?php echo $rate_count; ?>" placeholder="# of ratings"/>
                     
                    <div class="<?php echo $cost_error; ?>">
                        <?php echo $cost_message; ?>
                    </div>    
                    <input class="add-field <?php echo $age_field; ?>" type="text" name="price" value="<?php echo $cost; ?>" placeholder="Cost (number only)"/>
                   
                    <br /><br />    
                       
                    <div>
                        <b>In app purchase: </b>
                       
                        <input type="radio" name="in_app" value="1" checked="checked"/>Yes
                        <input type="radio" name="in_app" value="0"/>No
                    </div>
                   
                    <br />
                   
                    <div class="<?php echo $description_error; ?>">
                        Please provide a valid description
                    </div>    
                    <textarea class="add-field <?php echo $description_field?>" name="description" placeholder="description...." rows="6"><?php echo $description; ?></textarea>    
                       
                    <p>
                        <input class="submit advanced-button" type="submit" value="Submit" />
                    </p>    
                       
                    </form>

    </div>
</div> <!-- / main -->

<?php include("bottombit.php") ?>