<?php
    //create an empty array
    $empty = "";

    //check if the have been submited
    if(isset($_POST["submit"])){

        //get the user input as image name
        $uploadFile = $_FILES["image"]["name"];

        //target the folder to insert the image
        $location = "compressedImageFile/" . $uploadFile;

        //create an array with image extensions
        $extensions = array('png','jpg','jpeg');

        //get the user input file type extension
        $fileExtension = pathinfo($uploadFile, PATHINFO_EXTENSION);

        //convert the image file extension to lower case
        $tolower = strtolower($fileExtension);

        //check if the input is empty
        if(empty($uploadFile)){

            //display an empty message warning
            $empty = "The input is empty!";

        }else{

            //if the user input file has a valid extension for image
            if(in_array ($tolower, $extensions)){

              //function to compress the image
              function compressimage($source, $destination, $quality){

                  //get the size of the image
                  $details = getimagesize($source);

                  if($details['mime'] == 'image/jpeg'){

                      $image = imagecreatefromjpeg($source);
                  }
                  elseif($details['mime'] == 'image/png'){

                      $image = imagecreatefrompng($source);

                  }elseif($details['mime'] == 'image/jpg'){

                      $image = imagecreatefromjpg($source);
                  }

                  //compress the image file to the quality given
                  imagejpeg($image, $destination, $quality);
              }

                //call this function
                compressimage($_FILES['image']['tmp_name'], $location, 60);

            }else{
                //alert an error warning
                echo"<script> alert('invaild file type (not an image!)'); </script>";
            }

        }
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial_scale=0.1">
        <link rel="stylesheet" href="style.css">
        <title>Mr.Pinnacle Compressor</title>
    </head>
    <body class="container-fluid m-0 p-0" id="body">
        <h2>Mr.Pinnacle Image Compressor</h2>
        <br><br>
        <div class="col-8">
            <form action="compressor.php" name="form" method="POST" enctype="multipart/form-data">
                <input type="file" name="image" id="uploadImage">
                <br>
                <span class="text-danger">
                    <?php echo $empty; ?>
                </span>
                <br>
                <input type="submit" name="submit" value="CompressImage" id="submitBTU">
                <br><br>
            </form>
        </div>

    </body>
</html>
