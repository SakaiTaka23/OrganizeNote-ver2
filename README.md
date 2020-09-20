<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# OraganizeNote-ver2
https://github.com/SakaiTaka23/OrganizeNote
このリポジトリを依存性の注入、デザインパターンを考慮した上で作り替える
機能は特に変えない

Laravel version 8.0

# 概要
https://note.com/ に関して投稿した記事の整理を可能にするアプリ

ユーザーはログイン後記事の題名、目次、タグから投稿を確認、記事に飛ぶことができる他  
ユーザー自身のプロフィールも確認できる。

# インストール
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

# ログインurl

{domain}/login

# 注意点
## 新規登録

・noteurlとはnote公式でnoteidと呼ばれているものを指している
