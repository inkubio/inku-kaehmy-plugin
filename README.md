# Inkukähmy

Inkukähmy (Inkugrabbing) is a web application to handle the full kähmy (grabbing) flow for recruiting new guild officials and board members. This repository is the backend of the application, implemented as a WordPress plugin due to current website architecture. See also the [frontend repository](https://github.com/inkubio/inku-kaehmy-front).

## Basics

The backend handles all the data used in the kähmy (grabbing) process by implementing a RESTful API on top of WordPress' REST API. Base route for all API calls is:

`https://www.inkubio.fi/wp-json/inku-kaehmy/v1`

Data manipulation must be done through an authorized frontend, most often the frontend app running on the official Inkubio website. Any logged in user will be able to create new data, edit their own submissions and delete them.

## Data types

All data handled either up- or downstream must be valid `JSON`. The API returns data in the following formats:

`grabbing`: represents a single grabbing

```
{
    "ID": integer,
    "user_ID": integer,
    "username": string,
    "title": string,
    "text": string,
    "timestamp": string,
    "batch": string,
    "is_hallitus": boolean,
    "tags": tag[,
}
```

`comment`: represents a single comment

```
{
  "ID": integer,
  "username": string,
  "text": string,
  "timestamp": string,
  "depth": integer
}
```

`tag`: represents a "category" of a kähmy (grabbing)

```
{
  "ID": integer,
  "name_fi": string,
  "name_en": string
}
```

## Endpoints

Basis of the endpoints:

- All endpoints support `GET` requests
- Endpoints which have a plural form return their data in an array and support `POST`ing new data
- Editing data with `PUT` must be done via submitting a new object with wanted changes
- Only the user who created the data is allowed to edit or `DELETE` it

The API implements the following endpoints:

- `/grabbings`
- `/grabbing/{id}`
- `/grabbing/{id}/comments`
- `/comments`
- `/comment/{id}`
- `/tags`

### `/grabbings`

Endpoint for getting all kähmys (grabbings) or creating a new one.

`GET`: Returns a list of kähmy (grabbing) -objects in the following format:

```
[
    {
        "ID": integer,
        "user_ID": integer,
        "username": string,
        "title": string,
        "text": string,
        "timestamp": string,
        "batch": string,
        "is_hallitus": boolean,
        "tags": tag[]
    },
    ...
]
```

`POST`: Send a kähmy (grabbing) in the `body` of the request in the following format:

```
{
    "user_ID": integer,
    "title": string,
    "text": string,
    "batch": string,
    "is_hallitus": boolean,
    "tags": [ {"ID": integer}, ... ]
}
```

#### Example `GET`:

Input:

```bash
curl -X GET -H "Accept: application/json" {API_URL}/grabbings
```

Output:

```bash
[
    {
        "ID": 1,
        "user_ID": 100,
        "username": "Maikki Inkubiitti"
        "title": "My liver has had an easy life thus far.",
        "text": "Me is good at cooking (read: drinking) so i want to be the hostess",
        "timestamp": "2018-07-01 20:18:52",
        "batch": "Syksy 2018",
        "is_hallitus": true,
        "tags": [ {"ID": 10, "name_fi": "tapahtumat", "name_en": "events"}, ... ]
    },
    ...
]
```

#### Example `POST`:

Input:

```bash
curl -X POST -H "Content-Type: application/json" -d '{ user_ID": 100, title": "My liver has had an easy life thus far.", "text": "Me is good at cooking (read: drinking) so i want to be the hostess", "batch": "Syksy 2018", "is_hallitus": true, "tags": [{"ID": 11}, {"ID": 12}] }' {API_URL}/grabbings
```

Output:

```bash
HTTP 200 OK
```

---

### `/grabbing/{id}`

Endpoint for getting, editing or deleting a single kähmy (grabbing).

`GET`: Returns a kähmy (grabbing) -object specified by `{id}` in the following format:

```
{
    "ID": integer,
    "user_ID": integer,
    "username": string,
    "title": string,
    "text": string,
    "timestamp": string,
    "batch": string,
    "is_hallitus": boolean,
    "tags": tag[]
}
```

`PUT`: Edit a kähmy (grabbing) by submitting an edited one in the `body` of the request in the following format:

```
{
    "user_ID": integer,
    "title": string,
    "text": string,
    "batch": string,
    "is_hallitus": boolean,
    "tags": tag[]
}
```

`DELETE`: Delete a kähmy (grabbing) by calling the endpoint with the `{id}` of the kähmy (grabbing) to be erased.

#### Example `GET`:

Input:

```bash
curl -X GET -H "Accept: application/json" {API_URL}/grabbing/1
```

Output:

```bash
{
    "ID": 1,
    "user_ID": 101,
    "username": "Inku Maikkibiitti"
    "title": "My student allowances ran out",
    "text": "As the treasurer I will steal all of our money",
    "timestamp": "2018-07-01 13:47:29",
    "batch": "Syksy 2018",
    "is_hallitus": false,
    "tags": [ {"ID": 10, "name_fi": "talous", "name_en": "economy"}, ... ]
}
```

#### Example `PUT`:

Input:

```bash
curl -X POST -H "Content-Type: application/json" -d '{ user_ID": 100, title": "I dont like this title", "text": "Not the text either", "batch": "Syksy 2018", "is_hallitus": true, "tags": [] }' {API_URL}/grabbing/1
```

Output:

```bash
HTTP 200 OK
```

#### Example `DELETE`:

Input:

```bash
curl -X DELETE {API_URL}/grabbing/1
```

Output:

```bash
HTTP 200 OK
```

---

**TODO**: rest of the docs
