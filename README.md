# [api.dropparty.xyz](https://api.dropparty.xyz)

Source code of api.dropparty.xyz website.

## Endpoints

### GET /auth

Dropbox OAuth flow, will create a user with data returned from Dropbox and an access token.

### POST /auth.verify

Will verify if the post param `token` is a valid JWT token.

### POST /files.upload

Upload a file.
