<?php

    $page = $_GET['page'] ?? "";

    //var_dump($page);

    $menuItems = [
            'manageIndex' => 'quan ly index',
            'document' => 'Document',
            'search' => 'tim kiem'
    ];
?>

<!--    /?page=manageindex-->
<!--    /?page=document-->
<!--    /?page=search-->

<!DOCTYPE>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width =device-width">
    <meta http-equiv="X-UA-compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Example</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="collapse navbar-collapse" id="my-nav-bar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="/">Trang chủ</a>
            </li>
            <?php foreach ($menuItems as $url => $label): ?>

                <?php
                    $class ='';
                    if($page == $url)
                        $class = 'active';
                ?>


                <li class="nav-item <?=$class?>">
                    <a class="nav-link" href="/?page=<?=$url?>"><?=$label?></a>
                </li>
            <?php endforeach?>

        </ul>
        </div>
    </nav>

    <?php if ($page != ''):?>
        <?php
            include $page.".php";
        ?>
    <?php else:?>
        <p class="text-danger display">example test </p>
    <?php endif?>

</body>
</html>