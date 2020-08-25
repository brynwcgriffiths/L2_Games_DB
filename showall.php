<?php include("topbit.php");

    $find_sql = "SELECT * FROM `game_details` 
    JOIN genre ON (game_details.GenreID = genre.GenreID)
    JOIN developer ON (game_details.DeveloperID = developer.DeveloperID)
    ";
    $find_query = mysqli_query($dbconnect, $find_sql);
    $find_rs = mysqli_fetch_assoc($find_query);
    $count = mysqli_num_rows($find_query);

?>
			
			<div class="box main">
				<h2>All results</h2>
				
                <?php
                    if($count < 1)  {
                        ?>

            <div class = "error">
                        Sorry, there are no results that match your search. Please use the search bar in the 
                        side box to try again.
            </div>  <!--end error-->

                <?php
                    }   //end no results 'if'
                    else    {
                        do  {

                            ?>
                <!--results go here-->
                <div class = "results">
                <!--heading and sub heading-->
                <div class="flex-container">
                    <div>
                        <span class="sub_heading">
                            <a href="<?php echo $find_rs['URL']; ?>">
                                <?php echo $find_rs['Name']; ?>
                            </a>
                        </span>
                    </div>
                    
                    <?php 
                        if($find_rs['Subtitle'] != "") {
                    ?>
                        <div>
                        &nbsp; &nbsp; | &nbsp; &nbsp;
                        <?php echo $find_rs['Subtitle']; ?>
                        </div>
                    <?php
                        }
                    ?>
                <!--ratings-->
                <div class = "flex-container">
                        <!--star source: https://www.codepen.io/Bluetidepro/pen/GkpEa-->
                        <div class = "star-ratings-sprite">
                        </div>

                        <div class = "actual-rating">
                            (<?php echo $find_rs['User Rating'] ?> based of  
                            <?php echo number_format($find_rs['User Rating Count']) ?> ratings)
                        </div>
                </div>
                <!--price-->
                <?php
                    if($find_rs['Price'] == 0) {
                ?>
                <p>Free 
                        <?php   
                            if($find_rs['Purchases'] == 1) {
                        ?>
                        (In App Purchases)
                        <?php
                            } 
                        ?>
                   
                <p>
                <?php
                    }
                else {
                ?>
                <b>Price</b>: $<?php echo $find_rs['Price']?>
                <?php
                }
                ?>  

                </div>

                    <p>
                        <b>Genre</b>:
                        <?php echo $find_rs['Genre']; ?>

                        <br />
                        <b>Developer</b>:
                        <?php echo $find_rs['Developer']; ?>
                        
                        <br />
                        <b>Rating</b>:
                        <?php echo $find_rs['User Rating']; ?>
                            (based on <?php echo $find_rs['User Rating Count']; ?> votes )

                    </p>
                    <hr />
                    <?php echo $find_rs['Description']; ?>
                </div>
                
                <br />

                <?php
                
                        }   //end results 'do'

                        while
                            ($find_rs = mysqli_fetch_assoc($find_query));
                    }   //end else
                ?>

			</div> <!-- / main -->
			
<?php include("bottombit.php") ?>			
			