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
- https://api.onthelink.nl/api/fruition/v1/getContributions/:uid
- - uid: string
- https://api.onthelink.nl/api/fruition/v1/getSeason/:seasonId
- - seasonId: string
- https://api.onthelink.nl/api/fruition/v1/getItems/:seasonId
- - seasonId: string (optional)
- https://api.onthelink.nl/api/fruition/v1/getItemRecommendations/:itemId
- - itemId: string
- https://api.onthelink.nl/api/fruition/v1/getItem/:itemId
- - itemId: string
- https://api.onthelink.nl/api/fruition/v1/getSeasons
