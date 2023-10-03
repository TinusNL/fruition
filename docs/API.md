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
- https://api.onthelink.nl/api/fruition/v1/insertRecommendation/:uid/:itemId
- - uid: string
- - itemId: string
- - - returns: boolean
- https://api.onthelink.nl/api/fruition/v1/userLogin/:email/:password
- - email: string
- - password: string
- - - returns: userObject
- https://api.onthelink.nl/api/fruition/v1/userRegister/:email/:password
- - email: string
- - password: string
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