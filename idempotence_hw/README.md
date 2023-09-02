## Run service
1. ```kubectl create ns idempotence```
2. Set k8s namespace to "idempotence".
2. ```kubectl apply -f k8s```

## Run postman tests

```shell
newman run --env-var baseUrl=arch.homework:80 order_idempotence_test.postman_collection.json
```

There are 2 idempotence patters tested. 
**Idempotence by request id generated in frontend.** TEST ORDER 1.

It expects that every POST request has unique request id generated by frontend in header x-request-Id.
Every request should have unique request id. If request with the same request id is sent to the service, it should return 409 Conflict. The backend treat this request as duplicated and does not handle it.
   
**Optimistic Bloocking (Idempotence by version)** TEST ORDER 2.

The backed updates Entity(Order) only if version that came from frontend and stored in backend is the same. If backends has another version, then it returns 409 Conflict. The backend treat this request as rooted, because entity was already updated by someone else before.

Instead of versions I'm using timestamp updatedAt. It is easier to test.
