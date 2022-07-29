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

    $id = $_POST['Id'] ?? null;
    $title = $_POST['Title'] ?? null;
    $content = $_POST['Content'] ?? null;
    $keywords = $_POST['Keywords'] ?? null;

    //var_dump($id,$title,$content,$keywords);

    if($id != null && $title != null && $content != null && $keywords != null ){
        $params = [
          'index' => 'article',
            'type' => 'article_type',
            'id' => $id,
            'body' => [
                    'title' => $title,
                    'content' => $content,
                    'keywords' => explode("," , $keywords)
            ]
        ];
        $req = $client->index($params);

        $msg = "Cap nhat thanh cong document id = " .$id;

        $id = $title = $content = $keywords =null;
    }


?>
<div class="card a-4">
    <div class="card-header text-danger display-4">Tao - Cap nhat document</div>
    <div class="card-body">
        <form action="#" method="post">
            <div class="form-group">
                <label>ID Document</label>
                <input class="form-control" type="text"  name="Id" value="<?=$id?>">
            </div>

            <div class="form-group">
                <label>Title</label>
                <input class="form-control" type="text"  name="Title" value="<?=$title?>">
            </div>

            <div class="form-group">
                <label>Content</label>
                <textarea class="form-control" type="text"  name="Content"><?=$content?></textarea>
            </div>

            <div class="form-group">
                <label>Keywords</label>
                <input class="form-control" type="text"  name="Keywords" value="<?=$keywords?>">
            </div>

            <div class="form-group">
                <input class="btn btn-danger" type="submit"  value="update">
            </div>
        </form>
        <?=$msg?>
    </div>
