<?php
require_once 'db.inc.php';


try {

    $pdo = db_init();
    $isValidated = false;
    $categoryError = '';


    if (!empty($_POST)) {
        $category = $_POST['category'];
        $isValidated = true;

        if ($category == '') {
            $categoryError = 'カテゴリーを入力してください。';
            $isValidated = false;
        } elseif (mb_strlen($category, 'utf8') > 100) {
            $categoryError = 'カテゴリーを１００文字で入力してください。';
            $isValidated = false;
        }

        if ($isValidated == true) {


            $sql = ('INSERT INTO categories(name) VALUES(?)');
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$category]);
        }

        // $sql = ('INSERT INTO categories(name) VALUES(?)');
        // $stmt = $pdo->query($sql);
        // $stmt->execute(array($title));
    }


} catch (PDOException $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}


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
    <title>Taro's Blog | カテゴリーの投稿</title>
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <header class="header">
            <h1>カテゴリーの投稿</h1>
        </header>
        <?php if ($isValidated == true) : ?>


            <section class="postform">
                <p class="right"><a href="articles.php">記事の一覧に戻る</a></p>
                <p>以下の内容で記事を保存しました。</p>


                <table>
                    <tr>
                        <th>カテゴリ</th>
                        <td><?= h($category) ?></td>


                </table>
                <p><a href="post_article.php">続けて投稿する</a></p>
            <?php endif; ?>

            <?php if ($isValidated == false) : ?>
                <p>カテゴリーを入力し、送信ボタンを押してください。</p>
                <form action="" method="post">
                    <table>
                        <tr>
                            <th>カテゴリー名</th>
                            <td>
                                <p class="error"><?= $categoryError ?></p><input type="text" name="category">
                            </td>
                        </tr>
                    </table>
                    <p><input type="submit" value="送信" /></p>
                </form>

            </section>
        <?php endif; ?>
    </div>
</body>

</html>