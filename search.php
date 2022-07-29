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

    if (!$exists){
        throw new ErrorException("Index article khong ton tai");
    }

    $search = $_POST['search'] ?? "";

    //var_dump($search);
    if($search != ''){
        $params =[
          'index' => 'article',
            'type' => 'article_type',
            'body' => [
                "query" => [
                    "bool" => [
                        "should" => [
                            ['match' => ['title' => $search]],
                            ['match' => ['content' => $search]],
                            ['match' => ['keywords' => $search]]
                        ]
                    ]
                ],

                        'highlight' => [
                                'pre_tags' => ["<strong class ='text-danger'>"],
                                'post_tags' => ["</strong>"],
                                'fields' => [
                                        'title' => new stdClass(),
                                        'content' => new stdClass()
                                ]
                        ]

            ]
        ];

        $js = $client ->search($params);

        $items = null;

        $total = $js['hits']['total']['value'];

        if($total > 0){
            $items = $js['hits']['hits'];
        }

        //var_dump($total,$items);
    }


?>

<div class="card a-4">
    <div class="card-header text-danger display-4">Tim kiem</div>
    <div class="card-body">
        <form action="#" method="post">
            <div class="form-group">
                <label>Noi dung tim kiem</label>
                <input class="form-control" type="text"  name="search" value="<?=$search?>">
            </div>

            <div class="form-group">
                <input class="btn btn-danger" type="submit"  value="Search">
            </div>
        </form>

        <?php if($items != null):?>
            <?php foreach ($items as $item):?>
                <?php
                    $title = $item['_source']['title'];
                    $content = $item['_source']['content'];

                    if(isset($item['highlight']['title']))
                        $title = implode(" ", $item['highlight']['title']);
                    if(isset($item['highlight']['content']))
                        $content = implode(" ", $item['highlight']['content']);
                ?>
                <p><strong><?=$title?></strong></p><br>
                    <?=$content?>

                </p>
            <?php endforeach?>
        <?php endif;?>

    </div>
