<?php
require_once 'db.inc.php';

// echo '<pre>';
// var_dump($_GET[a]);
// echo '</pre>';

try {

    $pdo = db_init();
    $isValidated = false;
    $categoryError = true;


    if (!empty($_POST)) {
        $category = $_POST['category'];
        $title = $_POST['title'];
        $article = $_POST['article'];
        $isValidated = true;



        $sql = ('SELECT categories.name, articles.title, articles.article FROM articles
        JOIN categories ON articles.category_id = categories.id
        WHERE articles.id = ?');

        $stmt = $pdo->prepare($sql);

        $stmt->execute(array($_GET['a']));

        $articles = $stmt->fetchAll();

        // if ($isValidated == true) {


        //     $sql = ('INSERT INTO categories(name) VALUES(?)');
        //     $stmt = $pdo->prepare($sql);
        //     $stmt->execute([$category]);
        // }

        // $sql = ('INSERT INTO categories(name) VALUES(?)');
        // $stmt = $pdo->query($sql);
        // $stmt->execute(array($title));
    }

} catch (PDOException $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}

echo '<pre>';
var_dunp($articles['title']);
echo '</pre>';

// $stmt->query(array($articles, $title));

// echo '<pre>';
// var_dump($category_id);
// echo '</pre>';

// $ = $pdo->query($sql)->fetchAll();

function h($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taro's Blog | 記事の削除</title>
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <header class="header">
            <h1>記事の削除</h1>
        </header>

    <?php /* <?php if (!error) : ?> */ ?>

            <section class="postform">
                <p class="right"><a href="articles.php">記事の一覧に戻る</a></p>
                <p>削除を完了しました。</p>


        <?php /* <?php else: ?> */ ?>
                <table>
                    <tr>
                        <th>カテゴリ</th>
                        <td><?= $articles ?></td>

                </table>
                <p><a href="post_article.php">続けて投稿する</a></p>



                <p>内容に問題がなければ削除ボタンを押してください。</p>




                <form action="" method="post">
                    <p><input type="submit" value="削除" /></p>
                </form>

            </section>
    </div>
           <?php /* <?php endif; ?> */ ?>
</body>

</html>