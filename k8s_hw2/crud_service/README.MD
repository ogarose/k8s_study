## Run DB for test

```bash
docker run -rm --name some-mariadb -p 3306:3306 --env MARIADB_USER=example-user --env MARIADB_PASSWORD=my_cool_secret --env MARIADB_ROOT_PASSWORD=my-secret-pw  --env MARIADB_DATABASE=hw_db mariadb:10.4.22
```

##