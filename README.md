# My site (OLD)

[**My site**](https://ishowta.club)

## アプリの追加
1. /php/apps/に追加したいアプリ名のフォルダを作成
1. その中に①追加したいアプリ名.php②metadata.iniを追加
1. ①は/php/index.phpから呼ばれて展開されます。htmlタグとかbodyタグとかは付けないでください。
1. ②は他のアプリのiniを参考に作って下さい。widthとheightはアプリのサイズ（単位は400pxくらい）です。

## 言語とか
* メインはPHPです。/phpがルートです
* ゲームとか作れるようにNodeJSも用意してます。/nodeがルートです。8oti.com/Node/\*\*\*にアクセスするとルートに飛びます。
* データベースはmySQLです。KVSが欲しかったら追加してください。

## 自分のPCで動かす(Windows)
**Windowsのユーザー名が日本語の場合は動きません**

1. [docker-tools](https://www.docker.com/products/docker-toolbox)をインストール
1. Docker Quickstart Terminalを開く
```
git clone https://github.com/kinironote/8oti.git
cd 8oti
docker-compose up -d
start 192.168.99.100:27463
```

## 自分のPCで動かす(Linux,Mac)
1. [docker](https://docs.docker.com/engine/installation/)
1. [docker-compose](https://docs.docker.com/compose/install/)
```
git clone https://github.com/kinironote/8oti.git
cd 8oti
./reboot.sh
start localhost:27463
```

## docker
* php変更時→何もする必要はない。
* NodeJS変更時(それがサーバーなら)→リスタートが必要
```
//サーバーの状態表示
docker-compose ps
//サーバースタート
docker-compose start
//サーバーリスタート
docker-compose restart
//サーバーストップ
docker-compose stop
//サーバーのログ確認
docker-compose logs php
docker-compose logs nodejs

//コンテナに入る
docker exec -it 8oti_php_1 /bin/bash
//サーバーの構築し直し
docker-compose build
```

## データベース取得
```
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/utils.php');
$dbh = openDB();

// データアクセス（例）
$stmt = $dbh->prepare('SELECT * FROM users WHERE username = :username');
$stmt->bindParam(':username',$username);
$stmt->execute();
$userid = $stmt->fetch(PDO::FETCH_ASSOC)['userid'];
```

## ユーザー名取得
```
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/utils.php');
getUserName();
```

## ツリー
* bin : 設定ファイル入れ（たぶんbinって名前は適切じゃない）
     * docker_containers : ビルドが必要なコンテナ入れ
     * node : nodeJSのコンテナ設定ファイル
     * php : phpのコンテナ設定ファイル
* nodejs : nodejsを必要としてる処理はここに。
* php
     * apps : ***アプリ入れ***
     * css : index.phpのためのcssが入ってます。
     * example : nodeJSの簡単なサンプルとかが入ってます。
     * img : index.phpのためのimgが入ってます。
     * js : index.phpのためのjsが入ってます。
     * index.php : /の本体です。ここからアプリを呼んでいい感じに配置してます。
* apache2.conf : (apache2の）php設定ファイル
* nginx_conf.template : （nginxの）ルーティングの設定ファイル
* docker-compose.yml : 一番大枠の設定ファイル

## 連絡
@ishowta
ishowta@gmail.com
