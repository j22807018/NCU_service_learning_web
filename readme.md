## 服務學習網

# 架設開發環境

1.先把 repo 拉下來

2.透過 composer 安裝 Laravel 以及其他相依套件

```
$ composer install
```

3.複製環境設定檔

```
$ cp .env.example .env
```

4.生成 App Key

```
$ php artisan key:generate
```

5.將 NETID_HOST_DOMAIN 設定成你開發用的網址，這樣 portal 登入完後才能夠導回來
