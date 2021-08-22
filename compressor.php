<?php
    //create an empty array
    $emptyInput = $status = "";

    //function to compress the image
    function compressImage($source, $destination, $quality){

        //get the size of the image
        $details = getimagesize($source);

        $mime = $details['mime'];

        if($mime == 'image/jpg'){
            $image = imagecreatefromjpg($source);
        }elseif($mime == 'image/png'){
            $image = imagecreatefrompng($source);
        }elseif($mime == 'image/gif'){
            $image = imagecreatefromgif($source);
        }

        //compress the image file to the quality given
        imagejpeg($image, $destination, $quality);
    }

    //check if the have been submited
    if(isset($_POST["submit"])){

      //check if the input is empty
      if(empty($_FILES['image']['name'])){

          //display an empty message warning
          $emptyInput = "Choose Your Image To Compress...!";

      }else{

          //get the user input as image name
          $uploadFile = $_FILES['image']['name'];

          //target the folder to insert the image
          $location = "compressedImageFile/".$uploadFile;

          //create an array with image extensions
          $extensions = array('png','gif','jpg','jpeg');

          //get the user input file type extension
          $fileExtension = pathinfo($uploadFile, PATHINFO_EXTENSION);

          //convert the image file extension to lower case
          $tolowerExt = strtolower($fileExtension);

              //if the user input file has a valid extension of image
              if(in_array ($tolowerExt, $extensions)){

                $imagesize = $_FILES['image']['size'];

                  //call this function
                $compressedImage = compressImage($_FILES['image']['tmp_name'], $location, 60);

                if ($compressedImage ) {
                  //get file size
                  $compressedImageSize = filesize($compressedImage);
                  //done
                  $status = "successfully compressed..";
                }else {
                  //not done
                  $emptyInput = "Image compression failed..";
                }

              }else{
                  //error warning
                  $emptyInput = "Invalid Image Extension USE (JPG, JPEG, GIF, PNG)....!";
              }
        }
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial_scale=0.1">
        <title>Mr.Pinnacle Compressor</title>
        <link rel="stylesheet" href="./bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="./bootstrap/js/bootstrap.js">
        <style media="screen">
          body{
            background: url(images/img.jpeg);
            background-size: cover;
          }
          h2{
            font-weight: bold;
            font-family: sans-serif;
          }
          form{
            margin-top: 20%;
          }
          span{
            font-size: 1.2rem;
            font-weight: bold;
          }
        </style>
    </head>
    <body class="container">
      <div class="row pt-5">
        <div class="col-3"></div>
        <div class="col-6">
            <h2 class="mt-3 mb-5 text-center">Choose Your Image to Compressor</h2>
            <form action="compressor.php" method="POST" enctype="multipart/form-data">
              <span class="mb-3 text-danger">
                  <?php echo $emptyInput; ?>
              </span>
              <input type="file" name="image" class="form-control mb-5">
              <button type="submit" class="btn btn-primary mb-5 w-100 p-3" name="submit">Compress Now</button>
              <br>
              <span class="mb-3 text-success">
                  <?php echo $status; ?>
              </span>
            </form>
          </div>
          <div class="col-3"></div>
        </div>
        <div class="row mt-5">
          <div class="col-12">
            <?php if (!empty($compressedImage)) {?>
              <p> Original Image Size:<?php echo $imagesize; ?></p>
              <p> Compressed Image Size:<?php echo $compressedImageSize; ?></p>
              <img src="<?php $compressedImage; ?>">
            <?php }?>
          </div>
          <div class="col-12 mt-5 text-end">
            <a href="index.php">
              <button type="button" class="btn btn-dark" name="button">Go Back</button>
            </a>
          </div>
        </div>
    </body>
</html>
