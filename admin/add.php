<?php

session_start();
include_once('../includes/connection.php');


if (isset($_SESSION['logged_in'])) {
        #Get all submitted data from the form
    if (isset($_POST['title'],$_POST['content'],$_FILES['image'],$_POST['text'])) {
        $title =$_POST['title'];
        $content = nl2br($_POST['content']);
        $image = $_FILES['image'];
        $text = $_POST['text'];

        #check if the user entered anything
        if (empty($title) or empty($content) or empty($image)) {
            $error = 'All fields are requiered';

        } else {
            $query = $pdo->prepare('INSERT INTO articles (article_title, article_content, article_image, article_imageText, article_timestamp) VALUES (?, ?, ?, ?, ?)');

            $query->bindValue(1, $title);
            $query->bindValue(2, $content);
            $query->bindValue(3, $image);
            $query->bindValue(4, $text);
            $query->bindValue(5, time());

            $query->execute();

            header('Location: index.php');
        }
    }
    ?>

<html>
	<head>
		<title>CMS Tutorial</title>
		<link rel="stylesheet" href="../assets/style.css" /> 
	</head>
	<body>
		<div class="container">
            <a href="index.php" id="logo">CMS</a>

            <br>
            <h4>Add Article</h4>
            <?php if (isset($error)) { ?>
                <small style="color:#aa0000;"><?php echo $error;?></small>
                <br><br>
            <?php } ?>
            <form action="add.php" method="post" autocomlete="off" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="Title">
                <br><br>
                <div>
  	                <input type="file" name="image">
  	            </div>
                <textarea name="text" id="" cols="15" rows="12"></textarea>
                <textarea name="content" id="" cols="50" rows="12" placeholder="Content"></textarea>
                <br><br>
                <input type="submit" value="Add Article">
            </form>
		</div>
	</body>
</html>

    <?php
}else {
    header('Location: index.php');
}

?>
