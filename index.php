<?php include('db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Artikel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Selamat Datang di GhaniHub</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php
                $category_query = "SELECT * FROM categories";
                $categories = $connection->query($category_query);

                while ($category = $categories->fetch_assoc()) {
                    echo "<li><a href='index.php?category_id=" . $category['ID'] . "'>" . $category['Nama'] . "</a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>

    <div class="search-bar">
        <form method="GET" action="index.php">
            <input type="text" name="search" placeholder="Search...">
            <button type="submit">Search</button>
        </form>
    </div>

    <main>
    <?php
    if (isset($_GET['category_id'])) {
        $category_id = $_GET['category_id'];
        $article_query = "SELECT articles.* FROM articles 
                          JOIN article_category ON articles.ID = article_category.article_id 
                          WHERE article_category.category_id = $category_id";
    } elseif (isset($_GET['search'])) {
        $search = $_GET['search'];
        $article_query = "SELECT * FROM articles WHERE Title LIKE '%$search%'";
    } else {
        $article_query = "SELECT * FROM articles";
    }

    $articles = $connection->query($article_query);

    if ($articles->num_rows > 0) {
        // PHP loop for articles with a dynamic index
        $index = 0; // Start index for animation delay
        while ($article = $articles->fetch_assoc()) {
            echo "<div class='article' style='--index: {$index};'>"; // Set dynamic index for animation
            echo "<h2><a href='detail.php?id=" . $article['ID'] . "'>" . $article['Title'] . "</a></h2>";
            echo "<p>" . substr($article['Content'], 0, 100) . "...</p>";
            echo "</div>";
            $index++; // Increment index for next article
        }
    } else {
        echo "<p>Tidak ada artikel ditemukan.</p>";
    }
    ?>
</main>

</body>
</html>
