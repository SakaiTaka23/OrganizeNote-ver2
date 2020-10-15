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



**apiサンプル**

sample.json

https://note.com/api/v2/creators/note_fumi/contents?kind=note&page=1



## インストール

laravel・データベースの環境(mysql)は持っていることが前提

git clone https://github.com/SakaiTaka23/OrganizeNote-ver2.git  
cd oraganizenote-ver2
composer install  
php artisan key:generate  
データベースを作成  
cp .env.example .env  
.envファイルのデータベース、ユーザーネーム、パスワードの修正  
php artisan migrate:fresh  
php artisan serve

  

## ログインurl

{domain}/login



## タスクスケジュール

* 毎日3:00に実行させる

* 順番　削除→更新→取得



* 1ヶ月以上ログインしていない人はユーザー情報を消す
  1. last_loginを確認し、1ヶ月以上空いていればfalseにする
  2. falseになっているものは削除する

* 新たに登録したユーザーの記事の全取得 FirstTask

  **実装済み**

* 既存ユーザーの記事の更新 UpdateArticle

  1. ユーザーを全取得(first_task_finishedがtrueの場合のみ)
  2. ユーザーの記事数を更新 get_resent_article
  3. ユーザーの今日の記事を取得、dbに保存





## 注意点

**新規登録**

・noteurlとはnote公式でnoteidと呼ばれているものを指している



## 問題点

ログイン後の処理を付け加える関数が見つからない