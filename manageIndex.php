<?php

    use Elasticsearch\ClientBuilder;

    require "vendor/autoload.php";

    $hosts = [
      [
          'host' => '127.0.0.1',
          'port' => '9200',
          'scheme'=> 'http'
      ]
    ];

    $client = ClientBuilder::create()
        ->setHosts($hosts)
        ->build();

    $exists = $client->indices()->exists(['index' => 'article']);

//    $indices = $client->cat()->indices();
//
//    var_dump($indices);

    $action = $_GET['action'] ?? "";

    if($action == 'create'){
        if (!$exists)
            $client->indices()->create(['index' => 'article']);
    }

    if($action == 'delete'){
        if ($exists)
            $client->indices()->delete(['index' => 'article']);
    }

    $exists = $client->indices()->exists(['index' => 'article']);

    $msg = $exists ? "Index article dang ton tai " : "index article khong tin tai";

    ?>

    <div class="card a-4">
        <div class="card-header text-danger display-4">Quan ly index</div>
        <div class="card-body">

            <?php if (!$exists): ?>
                <a class="btn btn-success" href="http://localhost:8001/?page=manageIndex&action=create">Tao index article</a>
            <?php else:?>
                <a class="btn btn-danger" href="http://localhost:8001/?page=manageIndex&action=delete">Xoa index article</a>
            <?php endif;?>

            <div class="alert alert-primary mt-3">
                <?=$msg?>
            </div>


        </div>
    </div>

