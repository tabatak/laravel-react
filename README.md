laravel + reactのアプリ開発


## 起動方法

- sqliteを使っているので適当にインストール
- databaseファイルを作成

```
touch database/database.sqlite
```

- .envファイルを作成

```
cp .env.example .env
```

- npm

```
npm install

npm run dev
```

- サーバ起動

9000ポートになっているので気を付けてください

```
php artisan serve --port=9000
```

http://localhost:9000

