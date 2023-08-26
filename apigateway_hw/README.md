## Run service
1. Set k8s namespace to "default". _(important for ingress user routing)_
2. ```kubectl apply -f k8s```

## Run postman tests

```shell
newman run --env-var hwBaseUrl=arch.homework:80 apigateway_for_tests.postman_collection.json
```
