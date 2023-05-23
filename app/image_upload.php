<?php
require_once('../config.php');

// Include the database configuration file  

// Database configuration  
$dbHost     = "localhost";  
$dbUsername = "root";  
$dbPassword = "";  
$dbName     = "mts_db";  
  
// Create database connection  
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);  
  
// Check connection  
if ($db->connect_error) {  
    die("Connection failed: " . $db->connect_error);  
}


// If file upload form is submitted 
$status = $statusMsg = ''; 

    $name = $_POST['name'];
  
    $description = $_POST['description'];
   
if(!empty($_POST['uid'])){
    $id = $_POST['uid'];
}
    
    $status = 'error'; 


    $filename = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    
    $folder = "./../assets/" . $filename;
    if(!empty($_FILES["image"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            $image = $_FILES['image']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image)); 
           $userid =  $_settings->userdata('id');
           if(empty($id)){
             // Insert image content into database 
            $insert = $db->query("INSERT into report_images (name, user_id,  image, description,  created_at) VALUES ('$name','$userid', '$filename','$description', NOW())"); 
            move_uploaded_file($tempname, $folder);
           }else{
              $update = $db->query("UPDATE report_images SET name = '$name', image = '$filename', description = '$description', created_at = NOW()
              WHERE id = {$id}");
              move_uploaded_file($tempname, $folder);
           }
            if($insert){ 
               
                $status = 'success'; 
                header('Location: ' . $_SERVER['HTTP_REFERER']);
               
               $_settings->set_flashdata('success',"Report has been added successfully.");
               
            }elseif($update){
                $status = 'success'; 
                header('Location: ' . $_SERVER['HTTP_REFERER']);
               
               $_settings->set_flashdata('success',"Report has been updated successfully.");
            }
            else{ 
                $statusMsg = "File upload failed, please try again."; 
            }  
        }else{ 
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
        } 
    }else{ 
        $statusMsg = 'Please select an image file to upload.'; 
    } 

 
// Display status message 
echo $statusMsg; 
?>