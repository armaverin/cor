<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<div class="container">


<?include 'dbConfig.php'?>

<hr />
<div align="center">
<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="submit" name="submit" value="Загрузить">
</form>
<?
$date_today = date("d.m.y"); //присвоено 03.12.01
$today[1] = date("H:i:s"); //присвоит 1 элементу массива 17:16:17
?>

<p><?echo("Текущее время: $today[1] и дата: $date_today");?>
</div>
<div>
</p>

</div>
<?php
$statusMsg = '';

$targetDir = "uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName; 
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','jpeg');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $insert = $db->query("INSERT into images (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
            if($insert){
                $statusMsg = "Файл ".$fileName. " успешно загружен.";
            }else{
                $statusMsg = "Ошибка загрузки файла, повторите попытку.";
            } 
        }else{
            $statusMsg = "Извините, при загрузке файла произошла ошибка.Повторите еще раз";
        }
    }else{
        $statusMsg = 'Извините, только файлы JPG, JPEG разрешены для загрузки».';
    }
}

// Display status message
echo $statusMsg;
?>
<?
$sql = 'SELECT COUNT(id) FROM images'; 
$result = $db->query($sql);  
$count = $result->fetch_array(); 
$count = $count[0];
?>
<hr />
<h1>Заданий:<?echo $count?></h1> <h1>Кликов:<?echo $count?></h1>
<?php

$query = $db->query("SELECT * FROM images ORDER BY uploaded_on DESC");

if($query->num_rows > 0){
    echo '<table class="table">' . 
'<thead>' . 
'</thead>'; 
    while($row = $query->fetch_assoc()){
      
        $imageURL = 'uploads/'.$row["file_name"];
?>
      
<td><img src="<?php echo $imageURL; ?>" alt="" /></td>
</tr>


<?php }
}else{ ?>
   <div align="center"> <p>Не выполнено ни одного задания...</div></p>
   
<?php } ?>
</div>