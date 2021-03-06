<?php

session_start();
include_once('../includes/connection.php');
include_once('../includes/article.php');

$article = new Article;

  #checks if user is loged in
  if (isset($_SESSION['logged_in'])) {
      if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = $pdo->prepare('DELETE FROM articles WHERE article_id = ?');
        $query->bindValue(1, $id);
        $query->execute();
      }
      $articles = $article->fetch_all();
      #displays delete page
    ?>
<html>
	<head>
		<title>CMS Tutorial</title>
		<link rel="stylesheet" href="../assets/styles.css" /> 
	</head>
	<body>
		<div class="container">
            <a href="index.php" id="logo">CMS</a>
            <br>
            
            <h4>Select an Article to Delete:</h4>

            <form action="delete.php" method="get">
                <select onchange="this.form.submit();" name="id">
                    <?php foreach ($articles as $article) { ?>
                        <option value="<?php echo $article['article_id']; ?>">
                                <?php echo $article['article_title']; ?>
                        </option>
                    <?php } ?>
                </select>
            </form>
            <a href="index.php">&larr; Back</a>
		</div>
	</body>
</html>

    <?php
  } else {
      header('Location: index.php');
  }
?>