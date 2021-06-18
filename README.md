<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# OraganizeNote-ver2

https://github.com/SakaiTaka23/OrganizeNote
このリポジトリを依存性の注入、デザインパターンを考慮した上で作り替える
機能は特に変えない

Laravel version 8.0

## 概要

https://note.com/ に関して投稿した記事の整理を可能にするアプリ

ユーザーはログイン後記事の題名、目次、タグから投稿を確認、記事に飛ぶことができる他  
ユーザー自身のプロフィールも確認できる。

**api サンプル**

sample.json

https://note.com/api/v2/creators/note_fumi/contents?kind=note&page=1

## インストール

- エイリアスを設定しておくこと

```shell
alias sail='bash vendor/bin/sail'
```



```shell
git clone https://github.com/SakaiTaka23/OrganizeNote-ver2.git  
cd oraganizenote-ver2

cp .env.example .env

docker run --rm \
 -v $(pwd):/opt \
 -w /opt \
 laravelsail/php80-composer:latest \
 composer install

sail up -d

sail artisan key:generate
sail artisan migrate:fresh
```

- 開発中であれば http://127.0.0.1/ でページを閲覧可能

## ログイン url

{domain}/login

## タスクスケジュール

-   毎日 3:00 に実行させる

-   順番　削除 → 更新 → 取得

-   1 ヶ月以上ログインしていない人(非アクティブユーザー)はユーザー情報を消す DeleteNonActiveUserCommand

    1. last_login を確認し、1 ヶ月以上空いていれば false にする
    2. false になっているものは削除する

    **実装済み**

-   新たに登録したユーザーの記事の全取得 FirstTaskCommand

    **実装済み**

-   既存ユーザーの記事の更新 UpdateArticleCommand

    1. ユーザーを全取得(first_task_finished が true の場合のみ)
    2. ユーザーの記事数を更新 get_resent_article
    3. ユーザーの今日の記事を取得、db に保存

    **実装済み**

## 注意点

**新規登録**

・noteurl とは note 公式で noteid と呼ばれているものを指している

