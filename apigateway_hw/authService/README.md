## Run auth service
```bash
php -S 0.0.0.0:8000 index.php
```

## Build docker image
```bash
//m1 mac
docker build --platform linux/arm64 -t ogara/otus-microservice:auth-arm .

//amd64
docker build --platform linux/amd64 -t ogara/otus-microservice:auth-amd .
```