<?php 
include('db.php');  // Tambahkan ini untuk memastikan koneksi ke database ada
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Artikel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Info Lengkapnya</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php
        if (isset($_GET['id'])) {
            $article_id = intval($_GET['id']);
            // Query untuk mengambil detail artikel berdasarkan ID
            $article_query = "SELECT * FROM articles WHERE ID = $article_id";
            $article_result = $connection->query($article_query);

            if ($article_result && $article_result->num_rows > 0) {
                $article = $article_result->fetch_assoc();

                echo "<div class='article-container'>";
                echo "<div class='article-content-container'>";
                echo "<h2>" . htmlspecialchars($article['Title']) . "</h2>";
                echo "<div class='article-content'>";
                echo nl2br(htmlspecialchars($article['Content']));
                echo "</div>";
                echo "</div>";

                // Query untuk mengambil kategori artikel berdasarkan ID
                $category_query = "SELECT categories.Nama FROM categories 
                                   JOIN article_category ON categories.ID = article_category.category_id 
                                   WHERE article_category.article_id = $article_id";
                $categories_result = $connection->query($category_query);

                if ($categories_result && $categories_result->num_rows > 0) {
                    echo "<div class='article-category'><strong>Kategori:</strong> ";
                    while ($category = $categories_result->fetch_assoc()) {
                        echo htmlspecialchars($category['Nama']) . " ";
                    }
                    echo "</div>";
                } else {
                    echo "<div class='article-category'><strong>Kategori:</strong> Tidak ada kategori</div>";
                }

                echo "<a href='index.php' class='back-button'>Back to List</a>";
                echo "</div>"; // Close article-container
            } else {
                echo "<p>Artikel tidak ditemukan.</p>";
            }
        } else {
            echo "<p>ID artikel tidak diberikan.</p>";
        }
        ?>
    </main>
</body>
</html>
