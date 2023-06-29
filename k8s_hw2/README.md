## Run postman tests

```shell
newman run --env-var hwBaseUrl=arch.homework:80 otus_hw2.postman_collection.json
```

##  Run Helm DB
https://artifacthub.io/packages/helm/bitnami/mariadb

```shell
helm install crud-db -f db/values.yaml oci://registry-1.docker.io/bitnamicharts/mariadb
```

After helm delete crud-db need to clean pvc
```shell
kubectl delete pvc data-p-0
#kubectl delete pv  <pv-name>  --grace-period=0 --force
```

## How to run

```shell
//2 - run db (it also creates db secrets)
helm install crud-db -f db/values.yaml oci://registry-1.docker.io/bitnamicharts/mariadb

//4 - run applucation - it also runs migration job
kubectl apply -f k8s
```

## TODO
- prepare help charts
- push arm image
- build and push amd image
