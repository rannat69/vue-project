# vue-project

This template should help get you started developing with Vue 3 in Vite.

## Recommended IDE Setup

[VSCode](https://code.visualstudio.com/) + [Volar](https://marketplace.visualstudio.com/items?itemName=Vue.volar) (and disable Vetur) + [TypeScript Vue Plugin (Volar)](https://marketplace.visualstudio.com/items?itemName=Vue.vscode-typescript-vue-plugin).

## Customize configuration

See [Vite Configuration Reference](https://vitejs.dev/config/).

## Project Setup

```sh
cd vue-project
npm install
```

### Compile and Hot-Reload for Development

```sh
npm run dev
```


### Configure 

Set-up a php server to access to the read_db.php file and life_expectancy.db file.

Both are included in the php directory.

Make sure your PHP server allows access to external requests. 

In the case of an Apache server, add this line to httpd.conf 

```
Header set Access-Control-Allow-Origin <your Vue website>

```

Go to src/config.json and enter the address of the PHP API 

Example : 

```
{
  "apiPHPUrl": "http://127.0.0.1:3000/techtestsql/",
  "apiPHPLifeExpectancy": "read_db.php"
}
```



