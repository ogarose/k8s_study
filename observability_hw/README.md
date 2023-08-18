## Prometheus install

1. Create new namespace
```shell
kubectl create namespace monitoring
kubectl config set-context --current --namespace=monitoring
```
2. Install prometheus
```shell
// add prometeus helm repo
helm repo add prometheus-community https://prometheus-community.github.io/helm-charts
// 
helm update

//install prometeus
helm install prometheus prometheus-community/kube-prometheus-stack -f prometeus.yaml --namespace monitoring --atomic
```
### Grafana view
```shell
kubectl port-forward service/prometheus-grafana 9000:80
```

go to http://localhost:9000
user: admin
password: prom-operator

### Prometheus view
```shell
kubectl port-forward service/prometheus-operated 9090:9090
```

### Ingress

#### Install
helm upgrade --install ingress-nginx ingress-nginx \
--repo https://kubernetes.github.io/ingress-nginx \
--namespace ingress-nginx --create-namespace -f ingress/nginx_ingress-25239-20146a.yaml


#### Delete
helm uninstall ingress-nginx ingress-nginx --namespace ingress-nginx


## Links
How to setup prometeus and grapahana with Spring
https://tomgregory.com/spring-boot-default-metrics/

How to calculate latency and rpc
https://micrometer.io/docs/registry/prometheus#_timers