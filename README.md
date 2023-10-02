# Getting started
## Project Specifications:
- PHP
- SASS (frontend)

## API Specifications:
- NodeJS (using Express and AppWrite)
- - This is handled by Misha

## Installation:
1. Clone the repository
2. Install dependencies

   ```cd src```
      
    ```npm install```
3. Run the app

    ```npm run start```

## Appwrite:
###### Endpoint: https://api.onthelink.nl/api/sudorky/v1/

### Documentation:
- https://appwrite.io/docs

## API:
#### routes:
- https://api.onthelink.nl/api/fruition/v1/insertItem/:uid/:name/:location/:seasonId
- - uid: string
- - name: string
- - location: string {longitude, latitude}
- - seasonId: string
- - - returns: boolean
- https://api.onthelink.nl/api/fruition/v1/getContributions/:uid
- - uid: string
- - - returns: array
- https://api.onthelink.nl/api/fruition/v1/getSeason/:seasonId
- - seasonId: string
- - - returns: object
- https://api.onthelink.nl/api/fruition/v1/getItems/:seasonId
- - seasonId: string (optional)
- - - returns: array
- https://api.onthelink.nl/api/fruition/v1/getItemRecommendations/:itemId
- - itemId: string
- - - returns: array
- https://api.onthelink.nl/api/fruition/v1/getItem/:itemId
- - itemId: string
- - - returns: object
- https://api.onthelink.nl/api/fruition/v1/getSeasons
- - - returns: array