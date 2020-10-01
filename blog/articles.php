<?php
require_once "db.inc.php";



try {
    $pdo = db_init();


    $sql = ('SELECT * FROM categories');
    $categories = $pdo->query($sql)->fetchAll();



    if (!empty($_GET)) {

        $sql = 'SELECT articles.id, articles.title, articles.created_at, categories.name, articles.article
            FROM articles
            join categories ON categories.id = articles.category_id WHERE categories.id = ? ORDER BY created_at DESC';
            $stmt = $pdo->prepare($sql);

            $stmt->execute(array($_GET['c']));

        $articles = $stmt->fetchAll();


    } else {
        $sql = 'SELECT articles.id, articles.title, articles.created_at, categories.name, articles.article
            FROM articles
            join categories ON categories.id = articles.category_id ORDER BY created_at DESC';
        $articles = $pdo->query($sql)->fetchAll();
    }


} catch (PDOException $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}



function h($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}


// echo '<pre>';
// print_r($articles);
// echo '</pre>';


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taro's Blog</title>
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <header class="header">
            <h1><a href="articles.php">Taro's Blog</a></h1>
        </header>
        <main class="main">
            <?php foreach ($articles as $article) : ?>
                <article class="article">
                    <section class="title">

                        <h2><?= h($article['title']); ?></h2>

                        <h3><?= h($article['created_at']) ?> | <?= h($article['name']) ?> | <a href="delete_article.php?a=<?= $article['id'] ?>">削除</a></h3>

                    </section>
                    <div class="body">
                        <?= h($article['article']) ?>
                    </div>
                </article>
            <?php endforeach; ?>

        </main>
        <aside class="side">
            <nav class="sidebox">
                <h2>カテゴリ</h2>
                    <li><a href="articles.php">全件表示</a></li>
                <?php foreach ($categories as $category) : ?>
                    <ul>
                        <li><a href="?c=<?= $category['id'] ?>"><?= $category['name'] ?></a></li>
                    </ul>
                <?php endforeach ?>
            </nav>
            <p class="right"><a href="post_article.php">記事の投稿</a></p>
            <p class="right"><a href="post_category.php">カテゴリーの投稿</a></p>
        </aside>
    </div>
</body>

</html>