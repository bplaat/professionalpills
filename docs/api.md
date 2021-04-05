# The ProfessionalPills REST API 🔥
[Go back](/README.md) to the home page

This REST API is **very** secure I promise 😘...

## All the routes

### Hospital routes
- GET `/api/hospitals`

    Get information about all the hospitals
- GET `/api/hospitals/{hospital id}`

    Get information about a single hospital by a hospital id
- GET `/api/hospitals/{hospital id}/trails`

    Get information about all the trails of a single hospital
- GET `/api/hospitals/{hospital id}/trails{trail id}`

    Get information about a single trail of a single hospital
- GET `/api/hospitals/{hospital id}/users`

    Get information about all the users of a single hospital
- GET `/api/hospitals/{hospital id}/users{user id}`

    Get information about a single user of a single hospital

### Trail routes
- GET `/api/trails`

    Get information about all the trails
- GET `/api/trails/{trail id}`

    Get information about a single trail by trail id
- GET `/api/trails/{trail id}/users`

    Get all the users and user info that are connected to the trail
- POST `/api/trails/{trail id}/users`
    Add a user to a trail

    **Required POST variables:**
    - `user_id` The id of the user you want to add
- GET `/api/trails/{trail id}/users/{user id}/delete`

    Remove a user to a trail

## Extra information
Just do a HTTP get request to a API endpoint and you get all the data in JSON back.

You can search all index routes with the `q` GET variable.

All index results all paged with a 20 limit boudary you can access the next page with the `page` GET variable.
