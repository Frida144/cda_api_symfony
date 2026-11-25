```sh
# installer la dépendance
composer require lexik/jwt-authentication-bundle
```

```sh
mkdir config/jwt

openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096

openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```

dans `routes.yaml` :
```yaml
api_login_check:
    path: /api/login_check
```

```yaml
login:
    pattern: ^/api/login
    stateless: true
    json_login:
        check_path: /api/login_check
        success_handler: lexik_jwt_authentication.handler.authentication_success
        failure_handler: lexik_jwt_authentication.handler.authentication_failure
api:
    pattern: ^/api
    stateless: true
    jwt: ~ 
```
**Lien repository API** :
https://github.com/evaluationWeb/apirestcda.git

**installer API plateform** :
```sh
composer require api
```
**Ajouter les dépendances suivantes dans notre User Entity** :

```php
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;
```

Ajouter dans l'entité User avant le nom de la classe :
```php
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/user/{id}', 
            requirements: ['id' => '\d+'],
            normalizationContext: ['groups' => 'user:item']),
        new GetCollection(
            uriTemplate: '/user',
            normalizationContext: ['groups' => 'user:list']),
    ],
    order: ['id' => 'ASC', 'firstname' => 'ASC'],
    paginationEnabled: true
)]
```

Editer le fichier `config/api_plateform.yaml` :
```yaml
api_platform:
    title: Hello API Platform
    version: 1.0.0
    defaults:
        stateless: true
        cache_headers:
            vary: ['Content-Type', 'Authorization', 'Origin']
    formats:
        jsonld: ["application/ld+json"]
        json: ["application/json"]
    patch_formats:
        json: ["application/merge-patch+json"]
        
```

**Pour hasher un mot de passe Entité User** :
https://api-platform.com/docs/symfony/user/

## Tester les endpoints dans Bruno

Créer un utilisateur avant de demander son token :

- `POST http://localhost:8000/api/user`
- Headers : `Content-Type: application/json` et `Accept: application/json`
- Body :

```json
{
  "email": "test@example.com",
  "password": "MotDePasseTest123!"
}
```

La création doit renvoyer `201 Created`. Le mot de passe est hashé avant son enregistrement et n'est pas renvoyé dans la réponse.

Demander ensuite un token avec les mêmes identifiants :

- `POST http://localhost:8000/api/login_check`
- Header : `Content-Type: application/json`
- Body :

```json
{
  "email": "test@example.com",
  "password": "MotDePasseTest123!"
}
```

La réponse contient un champ `token`. Pour tester une route protégée, appeler par exemple `GET http://localhost:8000/api/users` avec l'authentification Bearer et ce token.
