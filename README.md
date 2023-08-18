# Ingress

## Setup 
```bash
helm upgrade --install ingress-nginx ingress-nginx \
--repo https://kubernetes.github.io/ingress-nginx \
--namespace ingress-nginx --create-namespace
```

## Delete
```bash
helm uninstall ingress-nginx ingress-nginx --namespace ingress-nginx
```
