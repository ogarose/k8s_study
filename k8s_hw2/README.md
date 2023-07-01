## Build service
```shell
// arm version
docker build -t ogara/otus-microservice:hw2-arm crud_service

// amd version
docker build --platform linux/amd64 -t ogara/otus-microservice:hw2-amd crud_service
```

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

## How to run vanilla k8s resources version

```shell
//1 - run db (it also creates db secrets)
helm install crud-db -f db/values.yaml oci://registry-1.docker.io/bitnamicharts/mariadb

//2 - run applucation - it also runs migration job
kubectl apply -f k8s
```

## How to run HELM version
//1 - run db (it also creates db secrets)
helm install crud-db -f db/values.yaml oci://registry-1.docker.io/bitnamicharts/mariadb

//2 - run applucation - it also runs migration job
helm upgrade --install crud-app helm-version --wait --atomic -f helm-version/values.yaml